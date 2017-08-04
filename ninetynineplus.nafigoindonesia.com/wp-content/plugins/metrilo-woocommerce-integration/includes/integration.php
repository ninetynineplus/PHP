<?php


if ( ! class_exists( 'Metrilo_Woo_Analytics_Integration' ) ) :

class Metrilo_Woo_Analytics_Integration extends WC_Integration {


	private $integration_version = '1.6.1';
	private $events_queue = array();
	private $single_item_tracked = false;
	private $has_events_in_cookie = false;
	private $identify_call_data = false;
	private $woo = false;
	private $orders_per_import_chunk = 25;
  private $recent_orders_sync_days = 7;
	private $batch_calls_queue = array();
  private $possible_events = array('view_product' => 'View Product', 'view_category' => 'View Category', 'view_article' => 'View Article', 'add_to_cart' => 'Add to cart', 'remove_from_cart' => 'Remove from cart', 'view_cart' => 'View Cart', 'checkout_start' => 'Started Checkout', 'identify' => 'Identify calls');
  private $endpoint_domain = 'p.metrilo.com';


	/**
	 *
	 *
	 * Initialization and hooks
	 *
	 *
	 */

	public function __construct() {
		global $woocommerce, $metrilo_woo_analytics_integration;

		$this->woo = function_exists('WC') ? WC() : $woocommerce;

		$this->id = 'metrilo-woo-analytics';
		$this->method_title = __( 'Metrilo', 'metrilo-woo-analytics' );
		$this->method_description = __( 'Metrilo offers powerful yet simple CRM & Analytics for WooCommerce and WooCommerce Subscription Stores. Enter your API key to activate analytics tracking.', 'metrilo-woo-analytics' );


		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Fetch the integration settings
		$this->api_key = $this->get_option('api_key', false);
		$this->api_secret = $this->get_option('api_secret', false);
		$this->ignore_for_roles = $this->get_option('ignore_for_roles', false);
    $this->ignore_for_events = $this->get_option('ignore_for_events', false);
		$this->product_brand_taxonomy = $this->get_option('product_brand_taxonomy', 'none');
		$this->send_roles_as_tags = $this->get_option('send_roles_as_tags', 'no');
    $this->add_tag_to_every_customer = $this->get_option('add_tag_to_every_customer', '');
    $this->http_or_https = $this->get_option('http_or_https', 'https') == 'https' ? 'https' : 'http';
		$this->accept_tracking = true;

		// previous version compatibility - fetch token from Wordpress settings
		if(empty($this->api_key)){
			$this->api_key = $this->get_previous_version_settings_key();
		}
		if(empty($this->api_secret)){
			$this->api_secret = false;
		}

		// ensure correct plugin path
		$this->ensure_path();

		// initiate woocommerce hooks and activities
		add_action('woocommerce_init', array($this, 'on_woocommerce_init'));
    add_action('template_redirect', array($this, 'metrilo_endpoint_handler'));

		// hook to integration settings update
		add_action( 'woocommerce_update_options_integration_' .  $this->id, array($this, 'process_admin_options'));

	}

  public function addResponseHeader($die_with_message = false){
    if($die_with_message){
      header('X-Metrilo-Endpoint-Message: ' . $die_with_message);
      die();
    }else{
      header('X-Metrilo-Endpoint-Version: ' . $this->integration_version);
    }
  }

  public function metrilo_endpoint_handler(){
    global $wp_query;
    $metrilo_endpoint = $wp_query->get('metrilo_endpoint');
    $req_id = $wp_query->get('req_id');
    if ( ! $metrilo_endpoint ) {
      return;
    }
    $this->addResponseHeader();
    $this->validate_endpoint_request_id($req_id, $metrilo_endpoint);
    $endpoint_response = array('endpoint' => $metrilo_endpoint);
    switch($metrilo_endpoint){
      case 'sync':
        $days_sync = $wp_query->get('recent_orders_sync_days') ? (int)$wp_query->get('recent_orders_sync_days') : $this->recent_orders_sync_days;
        $this->recent_orders_sync($days_sync);
        break;
      case 'orders':
        $order_ids = explode(',', $wp_query->get('metrilo_order_ids'));
        $this->sync_orders_chunk($order_ids);
        break;
    }

    # expire this request
    $this->expire_endpoint_request_id($req_id, $metrilo_endpoint);
    wp_send_json(array('status' => 1, 'endpoint' => $metrilo_endpoint));
  }

  public function validate_endpoint_request_id($req_id, $endpoint){
    if(empty($req_id)){
      $this->addResponseHeader('No request ID specified');
    }
    $end_point_params = array('req_id' => $req_id, 'endpoint' => $endpoint, 'token' => $this->api_key);
    $response = wp_remote_post($this->http_or_https.'://'.$this->endpoint_domain.'/r', array( 'body' => $end_point_params, 'timeout' => 15, 'blocking' => true ));
    $response = json_decode($response['body']);
    if($response->status != 1){
      $this->addResponseHeader('Request ID is invalid');
    }
  }

  public function expire_endpoint_request_id($req_id, $endpoint){
    $end_point_params = array('req_id' => $req_id, 'endpoint' => $endpoint, 'token' => $this->api_key);
    $response = wp_remote_post($this->http_or_https.'://'.$this->endpoint_domain.'/er', array( 'body' => $end_point_params, 'timeout' => 15, 'blocking' => true ));
  }

  public function recent_orders_sync($days_sync){
    global $wpdb;
    $recent_orders = array();
    // do not accept more than 45 days
    if($days_sync > 45) $days_sync = 45;

    // prepare query
    $date_after = date('Y-m-d', strtotime("-{$days_sync} days"));
    $query = "select id from {$wpdb->posts} where (post_type = 'shop_order') && (post_date >= '{$date_after}') order by id desc";

    // fetch orders and prepare the order-status hash
    $order_ids = $wpdb->get_col($query);
    if(!empty($order_ids)){
      foreach($order_ids as $order_id){
        try {
          $order = new WC_Order($order_id);
          if(!empty($order) && !empty($order->id)){
            $order_id = (string)$order->id;
            $recent_orders[$order_id] = $this->get_order_status($order);
          }
        }catch(Exception $e){

				}
      }
    }


    // send the order statuses to the Metrilo endpoint
		try {

			$call = array(
        'uid'       => 'integration',
        'token'     => $this->api_key,
        'statuses'  => $recent_orders
      );

			// sort for salting and prepare base64
			ksort($call);
			$based_call = base64_encode(json_encode($call));
			$signature = md5($based_call.$this->api_secret);

			// generate API call end point and call it
			$end_point_params = array('s' => $signature, 'hs' => $based_call);
			$c = wp_remote_post($this->http_or_https.'://'.$this->endpoint_domain.'/s', array( 'body' => $end_point_params, 'timeout' => 15, 'blocking' => true ));

		} catch (Exception $e){

		}

    return $recent_orders;
  }

	public function ensure_uid(){
		$this->cbuid = $this->session_get('ensure_cbuid');
		if(!$this->cbuid){
			$this->cbuid = md5(uniqid(rand(), true)) . rand();
			$this->session_set('ensure_cbuid', $this->cbuid);
		}
	}

	public function on_woocommerce_init(){

		// check if I should clear the events cookie queue
		$this->check_for_metrilo_clear();

		// check if API token and Secret are both entered
		$this->check_for_keys();

		// hook to WooCommerce models
		$this->ensure_hooks();

		// process cookie events
		$this->process_cookie_events();

		// ensure identification
		$this->ensure_identify();

		// ensure session identification of visitor
		$this->ensure_uid();

	}

	public function check_for_keys(){
		if(is_admin()){
			if((empty($this->api_key) || empty($this->api_secret)) && empty($_POST['save'])){
				add_action('admin_notices', array($this, 'admin_keys_notice'));
			}
			if(!empty($_POST['save']) && !empty($this->api_key) && !empty($_POST['woocommerce_metrilo-woo-analytics_api_key'])){
				add_action('admin_notices', array($this, 'admin_import_invite'));
			}
		}
	}

	public function admin_keys_notice(){
		if(empty($this->api_key)) $message = 'Almost done! Just enter your Metrilo API key to get started';
		if(empty($this->api_secret)) $message = 'Almost done! Just enter your Metrilo API key and secret';
		echo '<div class="updated"><p>'.$message.' <a href="'.admin_url('admin.php?page=wc-settings&tab=integration').'">here</a></p></div>';
	}

	public function admin_import_invite(){
		echo '<div class="updated"><p>Awesome! Have you tried <a href="'.admin_url('tools.php?page=metrilo-import').'"><strong>importing your existing customers to Metrilo</strong></a>?</p></div>';
	}

	public function ensure_hooks(){

		// general tracking snipper hook
		add_filter('wp_head', array($this, 'render_snippet'));
		add_filter('wp_head', array($this, 'woocommerce_tracking'));

		// background events tracking
		add_action('woocommerce_add_to_cart', array($this, 'add_to_cart'), 10, 6);
		add_action('woocommerce_before_cart_item_quantity_zero', array($this, 'remove_from_cart'), 10);
		add_filter('woocommerce_applied_coupon', array($this, 'applied_coupon'), 10);

		// hook on new order placed
		add_action('woocommerce_checkout_order_processed', array($this, 'new_order_event'), 10);

		// hook on WooCommerce subscriptions renewal
		add_action('woocommerce_subscriptions_renewal_order_created', array($this, 'new_subscription_order_event'), 10, 4);

		// hook on WooCommerce order update
		add_action('woocommerce_order_status_changed', array($this, 'order_status_changed'), 10, 3);

		// cookie clearing actions
		add_action('wp_ajax_metrilo_chunk_sync', array($this, 'sync_orders_chunk'));

		add_action('admin_menu', array($this, 'setup_admin_pages'));

	}

	public function setup_admin_pages(){
		add_submenu_page('tools.php', 'Export to Metrilo', 'Export to Metrilo', 'export', 'metrilo-import', array($this, 'metrilo_import_page'));
	}

	public function metrilo_import_page(){
		wp_enqueue_script('jquery');
		$metrilo_import = include_once('metrilo_import.php');
		$metrilo_import->prepare_import();
		if(!empty($_GET['import'])){
			$metrilo_import->set_importing_mode(true);
			$metrilo_import->prepare_order_chunks($this->orders_per_import_chunk);
		}
		$metrilo_import->output();
	}

	public function sync_orders_chunk($specific_order_ids = false){
		global $wpdb;

    if(!$specific_order_ids){
  		$order_ids = false;
  		if(isset($_REQUEST['chunk_page'])){
  			$chunk_page = (int)$_REQUEST['chunk_page'];
  			$chunk_offset = $chunk_page * $this->orders_per_import_chunk;

  			// fetch order IDs
  			$order_ids = $wpdb->get_col("select id from {$wpdb->posts} where post_type = 'shop_order' order by id asc limit {$this->orders_per_import_chunk} offset {$chunk_offset}");
  		}
    }else{
      $order_ids = $specific_order_ids;
    }
		if(!empty($order_ids)){
			foreach($order_ids as $order_id){

				try {
					$order = new WC_Order($order_id);
					if(!empty($order) && !empty($order->id)){

						// prepare the order data
						$purchase_params = $this->prepare_order_params($order);
            $purchase_params['context'] = 'import';
						$purchase_params['order_type'] = 'import';
						$call_params = false;

						// check if order has customer IP in it
						$customer_ip = $this->get_order_ip($order_id);
						if($customer_ip){
							$call_params = array('use_ip' => $customer_ip);
						}

						$order_time_in_ms = get_post_time('U', true, $order_id) * 1000;

						// add the items data to the order
						$order_items = $order->get_items();
						foreach($order_items as $product){
							$product_hash = array('id' => $product['product_id'], 'quantity' => $product['qty'], 'name' => $product['name']);
							if(!empty($product['variation_id'])){
								$variation_data = $this->prepare_variation_data($product['variation_id']);
								$product_hash['option_id'] = $variation_data['id'];
								$product_hash['option_price'] = $variation_data['price'];
							}
							array_push($purchase_params['items'], $product_hash);
						}

						// prepare order identity data
						$identity_data = $this->prepare_order_identity_data($order);

						$this->add_call_to_batch_queue($identity_data['email'], 'order', $purchase_params, $identity_data, $order_time_in_ms, $call_params);

					}

				}catch(Exception $e){

				}
			}
			$this->send_batch_calls();
		}

		return true;
	}

	public function prepare_order_identity_data($order){
			$identity_data = array(
						'email' 		=> get_post_meta($order->id, '_billing_email', true),
						'first_name' 	=> get_post_meta($order->id, '_billing_first_name', true),
						'last_name' 	=> get_post_meta($order->id, '_billing_last_name', true),
						'name'			=> get_post_meta($order->id, '_billing_first_name', true) . ' ' . get_post_meta($order->id, '_billing_last_name', true),
			);

			if(empty($identity_data['email'])){
				$order_user = $this->get_order_user($order);
				if($order_user){
					$identity_data = array(
						'email'						=> $order_user->data->user_email,
						'name'						=> $order_user->data->display_name
					);
				}
			}

			if($this->send_roles_as_tags == 'yes'){
				$order_user = $this->get_order_user($order);
				if(!empty($order_user) && !empty($order_user->roles)){
					$identity_data['tags'] = $order_user->roles;
				}
			}

      if(!empty($this->add_tag_to_every_customer)){
        if(empty($identity_data['tags'])){
          $identity_data['tags'] = array();
        }
        array_push($identity_data['tags'], $this->add_tag_to_every_customer);
      }

			return $identity_data;

	}

  public function resolve_product($product_id){
    if(function_exists('wc_get_product')){
      return wc_get_product($product_id);
    }else{
      return get_product($product_id);
    }
  }

	public function get_order_user($order){
		if($order->user_id){
			$order_user = get_user_by('id', $order->user_id);
			return $order_user;
		}
		return false;
	}

	public function ensure_path(){
		define('METRILO_PLUGIN_PATH', dirname(__FILE__));
	}

	public function ensure_identify(){
		// if user is logged in
		if( !is_admin() && is_user_logged_in() && !( $this->session_get( $this->get_identify_cookie_name() ) ) ){
			$user = wp_get_current_user();
			$this->identify_call_data = array('id' => $user->user_email, 'params' => array('email' => $user->user_email, 'name' => $user->display_name));
			if($user->user_firstname!= '' && $user->user_lastname){
				$this->identify_call_data['params']['first_name'] = $user->user_firstname;
				$this->identify_call_data['params']['last_name'] = $user->user_lastname;
			}
			// check if roles should be sent and if they exist
			if($this->send_roles_as_tags == 'yes' && !empty($user->roles)){
				$this->identify_call_data['params']['tags'] = $user->roles;
			}
			$this->session_set($this->get_identify_cookie_name(), 'true');
		}

	}


	/**
	 *
	 *
	 * Events tracking methods, event hooks
	 *
	 *
	 */


	public function woocommerce_tracking(){
		// check if woocommerce is installed
		if(class_exists('WooCommerce')){
			/** check certain tracking scenarios **/

			// if visitor is viewing product
			if(!$this->single_item_tracked && is_product()){
				$product = $this->resolve_product(get_queried_object_id());
				$this->put_event_in_queue('track', 'view_product', $this->prepare_product_hash($product));
				$this->single_item_tracked = true;
			}

			// if visitor is viewing product category
			if(!$this->single_item_tracked && is_product_category()){
				$this->put_event_in_queue('track', 'view_category', $this->prepare_category_hash(get_queried_object()));
				$this->single_item_tracked = true;
			}

			// if visitor is viewing shopping cart page
			if(!$this->single_item_tracked && is_cart()){
				$this->put_event_in_queue('track', 'view_cart', array());
				$this->single_item_tracked = true;
			}
			// if visitor is anywhere in the checkout process
			if(!$this->single_item_tracked && is_order_received_page()){

				$this->put_event_in_queue('track', 'pageview', 'Thank You');
				$this->single_item_tracked = true;

			}elseif(!$this->single_item_tracked && function_exists('is_checkout_pay_page') && is_checkout_pay_page()){
				$this->put_event_in_queue('track', 'checkout_payment', array());
				$this->single_item_tracked = true;
			}elseif(!$this->single_item_tracked && is_checkout()){
				$this->put_event_in_queue('track', 'checkout_start', array());
				$this->single_item_tracked = true;
			}
		}

		// ** GENERIC WordPress tracking - doesn't require WooCommerce in order to work **//

		// if visitor is viewing homepage or any text page
		if(!$this->single_item_tracked && is_front_page()){
			$this->put_event_in_queue('track', 'pageview', 'Homepage');
			$this->single_item_tracked = true;
		}elseif(!$this->single_item_tracked && is_page()){
			$this->put_event_in_queue('track', 'pageview', get_the_title());
			$this->single_item_tracked = true;
		}

		// if visitor is viewing post
		if(!$this->single_item_tracked && is_single()){
			$post_id = get_the_id();
			$this->put_event_in_queue('track', 'view_article', array('id' => $post_id, 'name' => get_the_title(), 'url' => get_permalink($post_id)));
			$this->single_item_tracked = true;
		}

		// if nothing else is tracked - send pageview event
		if(!$this->single_item_tracked){
			$this->put_event_in_queue('pageview');
		}

		// check if there are events in the queue to be sent to Metrilo
		if($this->identify_call_data !== false) $this->render_identify();
		if(count($this->events_queue) > 0) $this->render_events();
	}

	public function prepare_product_hash($product, $variation_id = false, $variation = false){
    $product_id = method_exists($product, 'get_id') ? $product->get_id() : $product->id;
		$product_hash = array(
			'id'			=> $product_id,
			'name'			=> $product->get_title(),
			'price'			=> $product->get_price(),
			'url'			=> get_permalink($product_id)
		);

		if($variation_id){
			$variation_data = $this->prepare_variation_data($variation_id, $variation);
			$product_hash['option_id'] = $variation_data['id'];
			$product_hash['option_name'] = $variation_data['name'];
			$product_hash['option_price'] = $variation_data['price'];
		}
		// fetch image URL
		$image_id = get_post_thumbnail_id($product_id);
		$image = get_post($image_id);
		if($image && $image->guid) $product_hash['image_url'] = $image->guid;

		// fetch the categories
		$categories_list = array();
		$categories = wp_get_post_terms($product_id, 'product_cat');
		if(!empty($categories)){
			foreach($categories as $cat){
				array_push($categories_list, array('id' => $cat->term_id, 'name' => $cat->name));
			}
		}

		// fetch brand taxonomy if available
		if($this->product_brand_taxonomy != 'none'){
			$brand_name = $product->get_attribute($this->product_brand_taxonomy);
			if(!empty($brand_name)){
				array_push($categories_list, array('id' => 'brand_'.$brand_name, 'name' => 'Brand: '.$brand_name));
			}
		}

		// include list of categories if any
		if(!empty($categories_list)) $product_hash['categories'] = $categories_list;

		// return
		return $product_hash;
	}

	public function prepare_category_hash($category){
		$category_hash = array(
			'id'	=>	$category->term_id,
			'name'	=> 	$category->name
		);
		return $category_hash;
	}

	public function put_event_in_queue($method, $event = '', $params = array()){
    if($this->check_if_event_should_be_ignored($method)){
      return true;
    }
    if($this->check_if_event_should_be_ignored($event)){
      return true;
    }
		array_push($this->events_queue, $this->prepare_event_for_queue($method, $event, $params));
	}

	public function put_event_in_cookie_queue($method, $event, $params){
    if($this->check_if_event_should_be_ignored($method)){
      return true;
    }
    if($this->check_if_event_should_be_ignored($event)){
      return true;
    }
		$this->add_item_to_cookie($this->prepare_event_for_queue($method, $event, $params));
	}

	public function prepare_event_for_queue($method, $event, $params){
		return array('method' => $method, 'event' => $event, 'params' => $params);
	}

	public function send_api_call($ident, $event, $params, $identity_data = false, $time = false, $call_params = false){

		if(!empty($this->api_key) && !empty($this->api_secret)){
			$this->prepare_secret_call_hash($ident, $event, $params, $identity_data, $time, $call_params);
		}

	}

  public function check_if_event_should_be_ignored($event){
    if(empty($this->ignore_for_events)){
      return false;
    }
    if(in_array($event, $this->ignore_for_events)){
      return true;
    }
    return false;
  }

	private function clear_batch_call_queue(){
		$this->batch_calls_queue = array();
	}

	private function add_call_to_batch_queue($ident, $event, $params, $identity_data = false, $time = false, $call_params = false){
		$call = $this->build_call($ident, $event, $params, $identity_data, $time, $call_params);
		array_push($this->batch_calls_queue, $call);
	}

	private function send_batch_calls(){

		try {

			$call = array(
				'token'					=> $this->api_key,
				'platform'			=> 'WordPress ' . get_bloginfo('version') . ' / WooCommerce ' . WOOCOMMERCE_VERSION,
				'version'				=> $this->integration_version,
				'events'				=> $this->batch_calls_queue
			);

			// sort for salting and prepare base64
			ksort($call);
			$based_call = base64_encode(json_encode($call));
			$signature = md5($based_call.$this->api_secret);

			// generate API call end point and call it
			$end_point_params = array('s' => $signature, 'hs' => $based_call);
			$c = wp_remote_post($this->http_or_https.'://'.$this->endpoint_domain.'/bt', array( 'body' => $end_point_params, 'timeout' => 15, 'blocking' => false ));

		} catch (Exception $e){
			return false;
		}

		return true;

	}

	private function build_call($ident, $event, $params, $identity_data = false, $time = false, $call_params = false){
			$call = array(
				'event_type'		=> $event,
				'params'				=> $params,
				'uid'						=> $ident,
				'token'					=> $this->api_key,
				'platform'			=> 'WordPress ' . get_bloginfo('version') . ' / WooCommerce ' . WOOCOMMERCE_VERSION,
				'version'				=> $this->integration_version,
				'server_time'		=> round(microtime(true) * 1000)
			);

			if($time){
				$call['time'] = $time;
			}

			// check for special parameters to include in the API call
			if($call_params){
				if($call_params['use_ip']){
					$call['use_ip'] = $call_params['use_ip'];
				}
			}

			// put identity data in call if available
			if($identity_data){
				$call['identity'] = $identity_data;
			}

			return $call;
	}

	private function prepare_secret_call_hash($ident, $event, $params, $identity_data = false, $time = false, $call_params = false){

		// prepare API call params

		try {

			$call = $this->build_call($ident, $event, $params, $identity_data, $time, $call_params);

			// sort for salting and prepare base64
			ksort($call);
			$based_call = base64_encode(json_encode($call));
			$signature = md5($based_call.$this->api_secret);

			// generate API call end point and call it
			$end_point_params = array('s' => $signature, 'hs' => $based_call);
			$c = wp_remote_post($this->http_or_https.'://'.$this->endpoint_domain.'/t', array( 'body' => $end_point_params, 'timeout' => 15, 'blocking' => false ));

		} catch (Exception $e){

		}

	}

	public function add_to_cart($cart_item_key, $product_id, $quantity, $variation_id = false, $variation = false, $cart_item_data = false){
		$product = $this->resolve_product($product_id);
		$this->put_event_in_cookie_queue('track', 'add_to_cart', $this->prepare_product_hash($product, $variation_id, $variation));
		$items = $this->get_items_in_cookie();
	}

	public function remove_from_cart($key_id){
		if (!is_object($this->woo->cart)) {
			return true;
		}
		$cart_items = $this->woo->cart->get_cart();
		$removed_cart_item = isset($cart_items[$key_id]) ? $cart_items[$key_id] : false;
		if($removed_cart_item){
			$event_params = array('id' => $removed_cart_item['product_id']);
			if(!empty($removed_cart_item['variation_id'])){
				$event_params['option_id'] = $removed_cart_item['variation_id'];
			}
			$this->put_event_in_cookie_queue('track', 'remove_from_cart', $event_params);
		}
	}

	public function prepare_variation_data($variation_id, $variation = false){
		// prepare variation data array
		$variation_data = array('id' => $variation_id, 'name' => '', 'price' => '');

		// prepare variation name if $variation is provided as argument
		if($variation){
			$variation_attribute_count = 0;
			foreach($variation as $attr => $value){
				$variation_data['name'] = $variation_data['name'] . ($variation_attribute_count == 0 ? '' : ', ') . $value;
				$variation_attribute_count++;
			}
		}

		// get variation price from object
		$variation_obj = new WC_Product_Variation($variation_id);
		$variation_data['price'] = $variation_obj->price;

		// return
		return $variation_data;
	}

	public function applied_coupon($coupon_code){
		$this->put_event_in_queue('track', 'applied_coupon', $coupon_code);
	}

	public function new_order_event($order_id){

		// fetch the order
		$order = new WC_Order($order_id);

		$call_params = false;

		// identify user - put identify data in cookie
		$this->identify_call_data = array(
			'id'		=> get_post_meta($order_id, '_billing_email', true),
			'params'	=> array(
						'email' 		=> get_post_meta($order_id, '_billing_email', true),
						'first_name' 	=> get_post_meta($order_id, '_billing_first_name', true),
						'last_name' 	=> get_post_meta($order_id, '_billing_last_name', true),
						'name'			=> get_post_meta($order_id, '_billing_first_name', true) . ' ' . get_post_meta($order_id, '_billing_last_name', true),
					)
		);

		// prepare the order data
		$purchase_params = $this->prepare_order_params($order);
    $purchase_params['context'] = 'new';

		// check if order has customer IP in it
		$customer_ip = $this->get_order_ip($order_id);
		if($customer_ip){
			$call_params = array('use_ip' => $customer_ip);
		}

		// prepare the order time
		$order_time_in_ms = get_post_time('U', true, $order_id) * 1000;


		// add the items data to the order
		$order_items = $order->get_items();
		foreach($order_items as $product){
			$product_hash = array('id' => $product['product_id'], 'quantity' => $product['qty'], 'name' => $product['name']);
			if(!empty($product['variation_id'])){
				$variation_data = $this->prepare_variation_data($product['variation_id']);
				$product_hash['option_id'] = $variation_data['id'];
				$product_hash['option_price'] = $variation_data['price'];
			}
			array_push($purchase_params['items'], $product_hash);
		}

		// prepare order identity data
		$identity_data = $this->prepare_order_identity_data($order);

    // if cbuid is present, use it isntead of the order email when placing the order
    $uid = (isset($_COOKIE) && isset($_COOKIE['cbuid'])) ? $_COOKIE['cbuid'] : $identity_data['email'];

		// send backend call with the order
		$this->send_api_call($uid, 'order', $purchase_params, $identity_data, $order_time_in_ms, $call_params);
		// put the order and identify data in cookies
		$this->session_set($this->get_do_identify_cookie_name(), json_encode($this->identify_call_data));

	}

	public function check_for_multi_currency($purchase_params){
		if(class_exists('Aelia_Order')){

			$aelia_order = new Aelia_Order($purchase_params['order_id']);
			$purchase_params['amount'] =  method_exists($aelia_order, 'get_total_in_base_currency') ? $aelia_order->get_total_in_base_currency() : $purchase_params['amount'];
			$purchase_params['shipping_amount'] =  method_exists($aelia_order, 'get_total_shipping_in_base_currency') ? $aelia_order->get_total_shipping_in_base_currency() : $purchase_params['shipping_amount'];
			$purchase_params['tax_amount'] =  method_exists($aelia_order, 'get_total_tax_in_base_currency') ? $aelia_order->get_total_tax_in_base_currency() : $purchase_params['tax_amount'];
		}
		return $purchase_params;
	}

	public function new_subscription_order_event($order, $original_order, $product_id, $new_order_role){

		try {


			$purchase_params = $this->prepare_order_params($order);
      $purchase_params['context'] = 'renewal';
			$purchase_params['order_type'] = 'renewal';
			$purchase_params['meta_source'] = '_renewal';

			// prepare order identity data
			$identity_data = $this->prepare_order_identity_data($order);

			// prepare product data
			$product = $this->resolve_product($product_id);
			$product_data = $this->prepare_product_hash($product);
			$product_data['quantity'] = 1;

			$purchase_params['items'] = array($product_data);

			$this->send_api_call($identity_data['email'], 'order', $purchase_params, $identity_data);

		}catch (Exception $e){

		}

	}

	public function order_status_changed($order_id, $old_status = false, $new_status = false){
		try {

				$order = new WC_Order($order_id);

				// prepare the order data
				$purchase_params = $this->prepare_order_params($order, array('old_status' => $old_status, 'new_status' => $new_status));
        $purchase_params['context'] = 'status_change';
        $call_params = false;

				// check if order has customer IP in it
				$customer_ip = $this->get_order_ip($order_id);
				if($customer_ip){
					$call_params = array('use_ip' => $customer_ip);
				}

				$order_time_in_ms = get_post_time('U', true, $order_id) * 1000;

				// add the items data to the order
				$order_items = $order->get_items();
				foreach($order_items as $product){
					$product_hash = array('id' => $product['product_id'], 'quantity' => $product['qty'], 'name' => $product['name']);
					if(!empty($product['variation_id'])){
						$variation_data = $this->prepare_variation_data($product['variation_id']);
						$product_hash['option_id'] = $variation_data['id'];
						$product_hash['option_price'] = $variation_data['price'];
					}
					array_push($purchase_params['items'], $product_hash);
				}

				// prepare order identity data
				$identity_data = $this->prepare_order_identity_data($order);

				$this->send_api_call($identity_data['email'], 'order', $purchase_params, $identity_data, $order_time_in_ms, $call_params);




		}catch(Exeption $e){

		}
	}

	public function get_order_status($order_object){
		if(method_exists($order_object, 'get_status')){
			return $order_object->get_status();
		}else{
			if(property_exists($order_object, 'status')){
				return $order_object->status;
			}
		}
	}

	public function prepare_order_params($order, $order_merge_params = array()){

		// prepare basic order data
		$purchase_params = array(
			'order_id' 			  => $order->id,
			'order_status' 		=> $this->get_order_status($order),
			'amount' 			    => $order->get_total(),
			'shipping_amount' => method_exists($order, 'get_total_shipping') ? $order->get_total_shipping() : $order->get_shipping(),
			'tax_amount'		  => $order->get_total_tax(),
			'items' 			    => array(),
			'shipping_method'	=> $order->get_shipping_method(),
			'payment_method'	=> $order->payment_method_title
		);
    if(!empty($order_merge_params)){
      $purchase_params = array_merge($purchase_params, $order_merge_params);
    }

		// attach billing data to order
		if(isset($order->billing_phone)){
			$purchase_params['billing_phone'] = $order->billing_phone;
		}
		if(isset($order->billing_city)){
			$purchase_params['billing_city'] = $order->billing_city;
		}
		if(isset($order->billing_state)){
			$purchase_params['billing_region'] = $order->billing_state;
		}
		if(isset($order->billing_postcode)){
			$purchase_params['billing_postcode'] = $order->billing_postcode;
		}
		if(isset($order->billing_country)){
			$purchase_params['billing_country'] = $order->billing_country;
		}
		if(isset($order->billing_address_1)){
			$purchase_params['billing_address_line_1'] = $order->billing_address_1;
		}
		if(isset($order->billing_address_2)){
			$purchase_params['billing_address_line_2'] = $order->billing_address_2;
		}
		if(isset($order->billing_company)){
			$purchase_params['billing_company'] = $order->billing_company;
		}

		// attach coupons data
		$coupons_applied = $order->get_used_coupons();
		if(count($coupons_applied) > 0){
			$purchase_params['coupons'] = $coupons_applied;
		}

		// extra check for multicurrency websites
		$purchase_params = $this->check_for_multi_currency($purchase_params);

		return $purchase_params;

	}

	/**
	 *
	 *
	 * WooCommerce Subscriptions tracking
	 *
	 */


	public function has_wcs(){
		return class_exists('WC_Subscriptions');
	}

	public function get_wcs_version(){
		return $this->has_wcs() && !empty( WC_Subscriptions::$version ) ? WC_Subscriptions::$version : null;
	}

	public function is_wcs_2(){
		return $this->has_wcs() && version_compare($this->get_wcs_version(), '2.0-beta-1', '>=');
	}


	/**
	 *
	 *
	 * Tracking code rendering
	 *
	 *
	 */


	public function render_events(){
		include_once(METRILO_PLUGIN_PATH.'/render_tracking_events.php');
	}

	public function render_identify(){
		include_once(METRILO_PLUGIN_PATH.'/render_identify.php');
	}

	public function render_snippet(){
		// check if we should track data for this user (if user is available)
		if( !is_admin() && is_user_logged_in()){
			$user = wp_get_current_user();
			if($user->roles && $this->ignore_for_roles){
				foreach($user->roles as $r){
					if(in_array($r, $this->ignore_for_roles)){
						$this->accept_tracking = false;
					}
				}
			}
		}

		// render the JS tracking code
		include_once(METRILO_PLUGIN_PATH.'/js.php');

	}


	/**
	 *
	 *
	 * Session and cookie handling
	 *
	 *
	 */

	public function session_get($k){
		if(!is_object($this->woo->session)){
			return isset($_COOKIE[$k]) ? $_COOKIE[$k] : false;
		}
		return $this->woo->session->get($k);
	}

	public function session_set($k, $v){
		if(!is_object($this->woo->session)){
			@setcookie($k, $v, time() + 43200, COOKIEPATH, COOKIE_DOMAIN);
			$_COOKIE[$k] = $v;
			return true;
		}
		return $this->woo->session->set($k, $v);
	}

	public function add_item_to_cookie($data){
		$items = $this->get_items_in_cookie();
		if(empty($items)) $items = array();
		array_push($items, $data);
		$encoded_items = json_encode($items);
		$this->session_set($this->get_cookie_name(), $encoded_items);
	}

	public function get_items_in_cookie(){
		$items = array();
		$data = $this->session_get($this->get_cookie_name());
		if(!empty($data)){
			if(get_magic_quotes_gpc()) $data = stripslashes($data);
			$items = json_decode($data, true);
		}
		return $items;
	}

	public function get_identify_data_in_cookie(){
		$identify = array();
		$data = $this->session_get($this->get_do_identify_cookie_name());
		if(!empty($data)){
			if(get_magic_quotes_gpc()) $data = stripslashes($data);
			$identify = json_decode($data, true);
		}
		return $identify;
	}

	public function clear_items_in_cookie(){
		$this->session_set($this->get_cookie_name(), json_encode(array()));
		$this->session_set($this->get_do_identify_cookie_name(), json_encode(array()));
	}

	public function get_order_ip($order_id){
		$ip_address = get_post_meta($order_id, '_customer_ip_address', true);
		if(strpos($ip_address, '.') !== false){
			return $ip_address;
		}
		return false;
	}

	private function get_cookie_name(){
		return 'metriloqueue_' . COOKIEHASH;
	}

	private function get_identify_cookie_name(){
		return 'metriloid_' . COOKIEHASH;
	}

	private function get_do_identify_cookie_name(){
		return 'metrilodoid_' . COOKIEHASH;
	}


	public function check_for_metrilo_clear(){
		if(!empty($_REQUEST) && !empty($_REQUEST['metrilo_clear'])){
			$this->clear_items_in_cookie();
			wp_send_json_success();
		}
	}

	public function process_cookie_events(){
		$items = $this->get_items_in_cookie();
		if(count($items) > 0){
			$this->has_events_in_cookie = true;
			foreach($items as $event){
				// put event in queue for sending to the JS library
				$this->put_event_in_queue($event['method'], $event['event'], $event['params']);
			}
		}

		// check if identify data resides in the session
		$identify_data = $this->get_identify_data_in_cookie();
		if(!empty($identify_data)) $this->identify_call_data = $identify_data;

	}


	/**
	 * Settings compatibility with previous versin - fetch api key from WP options pool
	 */

	public function get_previous_version_settings_key(){
		$api_key = false;

		// fetch settings
		$settings = get_option('metrilo_woo_analytics');
		if(!empty($settings) && !empty($settings['api_token'])){
			$api_key = $settings['api_token'];
		}
		return $api_key;
	}

	/**
	 * Initialize integration settings form fields.
	 */
	public function init_form_fields() {

		// initiate possible user roles from settings
		$possible_ignore_roles = false;

		if(is_admin()){
			global $wp_roles;
			$possible_ignore_roles = array();
			foreach($wp_roles->roles as $role => $stuff){
				$possible_ignore_roles[$role] = $stuff['name'];
			}
		}

		$this->form_fields = array(
			'api_key' => array(
				'title'             => __( 'API Token', 'metrilo-woo-analytics' ),
				'type'              => 'text',
				'description'       => __( '<strong style="color: green;">(Required)</strong> Enter your Metrilo API token. You can find it under "Settings" in your Metrilo account.<br /> Don\'t have one? <a href="https://www.metrilo.com/signup?ref=woointegration" target="_blank">Sign-up for free</a> now, it only takes a few seconds.', 'metrilo-woo-analytics' ),
				'desc_tip'          => false,
				'default'           => ''
			),
			'api_secret' => array(
				'title'             => __( 'API Secret Key', 'metrilo-woo-analytics' ),
				'type'              => 'text',
				'description'       => __( '<strong style="color: green;">(Required)</strong> Enter your Metrilo API secret key.', 'metrilo-woo-analytics' ),
				'desc_tip'          => false,
				'default'           => ''
			)
		);

		if($possible_ignore_roles){
			$this->form_fields['ignore_for_roles'] = array(
				'title'             => __( 'Ignore tracking for roles', 'metrilo-woo-analytics' ),
				'type'              => 'multiselect',
				'description'       => __( '<strong style="color: #999;">(Optional)</strong> If you check any of the roles, tracking data will be ignored for WP users with this role', 'metrilo-woo-analytics' ),
				'desc_tip'          => false,
				'default'           => '',
				'options'			=> $possible_ignore_roles
			);
		}
    $this->form_fields['ignore_for_events'] = array(
      'title'             => __( 'Do not send the selected tracking events', 'metrilo-woo-analytics' ),
      'type'              => 'multiselect',
      'description'       => __( '<strong style="color: #999;">(Optional)</strong> Tracking won\'t be sent for the selected events', 'metrilo-woo-analytics' ),
      'desc_tip'          => false,
      'default'           => '',
      'options'			=> $this->possible_events
    );



		$product_brand_taxonomy_options = array('none' => 'None');
		foreach(wc_get_attribute_taxonomies() as $v){
			$product_brand_taxonomy_options[$v->attribute_name] = $v->attribute_label;
		}


		$this->form_fields['product_brand_taxonomy'] = array(
			'title'             => __( 'Product brand attribute', 'metrilo-woo-analytics' ),
			'type'              => 'select',
			'description'       => __( '<strong style="color: #999;">(Optional)</strong> If you check any of those attributes, it\'ll be synced with Metrilo as the product\'s brand' ),
			'desc_tip'          => false,
			'default'           => '',
			'options'						=> $product_brand_taxonomy_options
		);

		$this->form_fields['send_roles_as_tags'] = array(
			'title'             => __( 'Send user roles as tags', 'metrilo-woo-analytics' ),
			'type'              => 'checkbox',
			'description'       => __( '<strong style="color: #999;">(Optional)</strong> If you check this, your user\'s roles will be sent to Metrilo as tags when they browse your website' ),
			'desc_tip'          => false,
			'label'							=> 'Send roles as tags',
			'default'           => false
		);

    $this->form_fields['add_tag_to_every_customer'] = array(
			'title'             => __( 'Add this tag to every customer', 'metrilo-woo-analytics' ),
			'type'              => 'text',
			'description'       => __( '<strong style="color: #999;">(Optional)</strong> If you enter tag, it will be added to every customer synced with Metrilo' ),
			'desc_tip'          => false,
			'label'							=> 'Add this tag to every customer in Metrilo',
			'default'           => ''
		);

    $this->form_fields['http_or_https'] = array(
			'title'             => __( 'Sync data to Metrilo with HTTPS', 'metrilo-woo-analytics' ),
			'type'              => 'select',
			'description'       => __( '<strong style="color: #999;">(Optional)</strong> Set if data should be sent to Metrilo from your WooCommerce backend through HTTPS or HTTP' ),
			'desc_tip'          => false,
			'default'           => '',
			'options'						=> array('https' => 'Yes (HTTPS)', 'http' => 'No (HTTP)')
		);


	}

}



endif;
