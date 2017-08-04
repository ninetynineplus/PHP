<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Japi extends CI_Controller {

    /**

     * Class Constructor

     */

    public function __construct() {

        parent::__construct();

        $this->load->library('session');



        // Set user's selected language.

        if ($this->session->userdata('language')) {

        	$this->config->set_item('language', $this->session->userdata('language'));

        	$this->lang->load('translations', $this->session->userdata('language'));

        } else {

        	$this->lang->load('translations', $this->config->item('language')); // default

        }

    }

	

	//jiboy start here..

    public function check_login() {

        try {

            if (!isset($_POST['username']) || !isset($_POST['password'])) {

                throw new Exception('Invalid credentials given!');

            }

			

            $this->load->model('user_model');

            $user_data = $this->user_model->check_login($_POST['username'], $_POST['password']);



			$result = array();

            if ($user_data) {

                //$this->session->set_userdata($user_data); // Save data on user's session.

				$result["message"] = "login sukses";

				$result["result"] = 1;

				$result["data"]["id"] = $user_data["user_id"];

				$result["data"]["email"] = $user_data["user_email"];

				$result["data"]["username"] = $user_data["username"];

				$result["data"]["first_name"] = $user_data["first_name"];

				$result["data"]["last_name"] = $user_data["last_name"];

                echo json_encode($result);die;

            } else {

				$result["message"] = "login gagal, silahkan cek kembali user dan password";

				$result["result"] = 0;

				$result["data"] = null;

               echo json_encode($result);die;

            }



        } catch(Exception $exc) {

			$result = array();

			$result["message"] = "login gagal";

			$result["result"] = 0;

			echo json_encode($result);die;

        }		

    }

	

   public function register() {	

		

		$result = array();

	

		if(!isset($_POST['username']))

		{

			$result["message"] = "Username tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}

		

		if(!isset($_POST['password']))

		{

			$result["message"] = "Password tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}



		if(!isset($_POST['first_name']))

		{

			$result["message"] = "First name tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}	



		if(!isset($_POST['last_name']))

		{

			$result["message"] = "Last name tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}		

		

		if(!isset($_POST['email']))

		{

			$result["message"] = "email tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}	



		if(!isset($_POST['mobile_number']))

		{

			$result["message"] = "Mobile number tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}	

		

		if(!isset($_POST['phone_number']))

		{

			$result["message"] = "Phone number tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}		



		if(!isset($_POST['address']))

		{

			$result["message"] = "Address tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}	



		if(!isset($_POST['city']))

		{

			$result["message"] = "City tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}



		if(!isset($_POST['zip_code']))

		{

			$result["message"] = "Zip Code tidak boleh kosong";

			$result["result"] = 0;

			echo json_encode($result);die;			

		}

		

		$data["first_name"] = $_POST["first_name"];

		$data["last_name"] = $_POST["last_name"];

		$data["email"] = $_POST["email"];

		$data["mobile_number"] = $_POST["mobile_number"];

		$data["phone_number"] = $_POST["phone_number"];

		$data["address"] = $_POST["address"];

		$data["city"] = $_POST["city"];

		$data["zip_code"] = $_POST["zip_code"];

		$data["notes"] = "Register from API";

		$data["settings"]["username"] = $_POST["username"];

		$data["settings"]["password"] = $_POST["password"];

		

		$this->load->model('customers_model');

		

		$id = $this->customers_model->add($data);

		if($id < 1)

		{

			$result["message"] = "Data ada yang tidak valid";

			$result["result"] = 0;

			echo json_encode($result);die;				

		}

		

		$result["message"] = "Sukses registrasi";

		$result["result"] = 1;

		echo json_encode($result);die;		

		

    }

	

	public function getcategories()

	{

		$results = array();

		$this->load->model('services_model');

		$data = array();

		$result = $this->services_model->getcategories($data);

		$message = "There are No Category available at the moment";

		if($result && count($data) > 0)

		{

			$message = $data;

			$result = 1;

		}else{

			$result = 0;

		}

		$results["message"] = $message;

		$results["result"] = $result;

		

		echo json_encode($results);die;

	}

	

	//http://account.healthyfirst.id/index.php/japi/getservices

	public function getservices()

	{

		$results = array();

		$this->load->model('services_model');

		$data = array();

		

		$categoryid = (int)$_GET["categoryid"];

		$data = array();

		

		$result = $this->services_model->getServices($categoryid, $data);

		$message = "There are no requested services from given category id";

		if($result && count($data) > 0)

		{

			$message = $data;

			$result = 1;

		}else{

			$result = 0;

		}

		$results["message"] = $message;

		$results["result"] = $result;

		

		echo json_encode($results);die;

	}

	

	//http://account.healthyfirst.id/index.php/japi/addbooking

	

	public function addBooking()

	{	

		$results = array();

		$this->load->model('appointments_model');	

	

		$data = new stdClass();

		$data->email = $_POST['email'];

		//service = 3,60 (serviceid, duration)

		$data->service = $_POST['service'];

		$data->reqgender = $_POST['reqgender'];

		$data->starttime = $_POST['starttime'];

		$data->address = $_POST['address'];

		$data->payment = $_POST['payment'];

		$data->status = 0;

		if(isset($_POST['voucher'])) $data->voucher = $_POST['voucher'];



		$result = $this->appointments_model->addBookingCustomer($data);

		

		$results["message"] = $data;

		$results["result"] = $result;

		

		if($result > 0)

		{

			$results["data"] = $data;

			$results["message"] = "Booking Sukses";

		}

		

		echo json_encode($results);die;		

		

	}

	

	public function cancelBooking()

	{

		$results = array();

		$this->load->model('appointments_model');	

	

		$data = new stdClass();

		$data->email = $_POST['email'];

		$data->id = $_POST['id'];



		$result = $this->appointments_model->cancelBookingCustomer($data);

		

		$results["message"] = $data;

		$results["result"] = $result;

		

		echo json_encode($results);die;		

	}

	

	public function getLast10BookingCustomer()

	{

		$results = array();

		$this->load->model('appointments_model');	

	

		$data = new stdClass();

		$data->email = $_GET['email'];

		$data->id = $_GET['userid'];



		$result = $this->appointments_model->getLast10BookingCustomer($data);

		

		$results["message"] = $data;

		$results["result"] = $result;

		

		echo json_encode($results);die;		

	}



	public function getLastBookingCustomer()

	{

		$results = array();

		$this->load->model('appointments_model');	

	

		$data = new stdClass();

		$data->email = $_GET['email'];

		$data->id = $_GET['userid'];



		$result = $this->appointments_model->getLastBookingCustomer($data);

		

		$results["message"] = $data;

		

		if($result > 0)

		{

			$results["message"] = "Sukses get last booking status menunggu";

			$results["data"] = $data;

		}

		$results["result"] = $result;

		

		echo json_encode($results);die;		

	}

	

	

	public function forgotpassword()

	{

		$results = array();

		$this->load->model('user_model');	



		$email = $_POST['email'];



		$result = $this->user_model->forgotpassword($email);

		

		$results["message"] = "Email not found";

		$results["result"] = 0;

		

		if($result)

		{

			$results["message"] = "Reset Password Sukses silahkan cek email";

			$results["result"] = 1;

		}

		

		echo json_encode($results);die;			

	}

	

	public function getTaskTherapist()

	{

		$results = array();

		$this->load->model('appointments_model');	

	

		$data = new stdClass();

		$data->id = (int)$_GET['userid'];

		

		if(isset($_GET['status']))

		{

			$data->status = $_GET['status'];

		}

		

		if(!isset($_GET['limit']))

		{

			$data->today = 1;

		}else{

			$data->limit = (int)$_GET['limit'];

		}		



		$result = $this->appointments_model->getTaskTherapist($data);

		

		$results["message"] = $data;

		$results["result"] = $result;

		

		if($result > 0)

		{

			$results["message"] = "Sukses get data terapist";

			$results["data"] = $data;

			$results["result"] = $result;			

		}

		

		echo json_encode($results);die;		

	}		

}