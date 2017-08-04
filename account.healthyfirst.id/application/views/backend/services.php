<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/ext/jquery-ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_appointment.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_services_helper.js"></script>

<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_categories_helper.js"></script>
		
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_items_helper.js"></script>
		
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_usage_helper.js"></script>	

<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_services.js"></script>

<script type="text/javascript">
    var GlobalVariables = {
        'csrfToken'     : <?php echo json_encode($this->security->get_csrf_hash()); ?>,
        'baseUrl'       : <?php echo json_encode($base_url); ?>,
        'dateFormat'    : <?php echo json_encode($date_format); ?>,
        'services'      : <?php echo json_encode($services); ?>,
        'categories'    : <?php echo json_encode($categories); ?>,
        'user'          : {
            'id'        : <?php echo $user_id; ?>,
            'email'     : <?php echo json_encode($user_email); ?>,
            'role_slug' : <?php echo json_encode($role_slug); ?>,
            'privileges': <?php echo json_encode($privileges); ?>
        }
    };

    $(document).ready(function() {
        BackendServices.initialize(true);
    });
</script>

<?php 
$this->load->model('inventory_model');
$items = $this->inventory_model->get_all_items();
?>

<div id="services-page" class="container-fluid backend-page">
    <ul class="nav nav-tabs">
        <li role="presentation" class="services-tab tab active"><a><?php echo $this->lang->line('services'); ?></a></li>
		<li role="presentation" class="booking-tab tab"><a>Appointment</a></li>
        <li role="presentation" class="categories-tab tab"><a><?php echo $this->lang->line('categories'); ?></a></li>
		<li role="presentation" class="items-tab tab"><a>Items</a></li>
		<li role="presentation" class="usage-tab tab"><a>Item Usage</a></li>
    </ul>

    <?php
        // --------------------------------------------------------------
        //
        // SERVICES TAB
        //
        // --------------------------------------------------------------
    ?>
    <div id="services" class="tab-content">
        <?php // FILTER SERVICES ?>
        <div class="row">
            <div id="filter-services" class="filter-records column col-xs-12 col-sm-5">
                <form class="input-append">
                    <input class="key" type="text" />
                    <div class="btn-group">
                        <button class="filter btn btn-default btn-sm" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                            <span class="glyphglyphicon glyphicon glyphglyphicon glyphicon-search"></span>
                        </button>
                        <button class="clear btn btn-default btn-sm" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                            <span class="glyphglyphicon glyphicon glyphglyphicon glyphicon-repeat"></span>
                        </button>
                    </div>
                </form>

                <h3><?php echo $this->lang->line('services'); ?></h3>
                <div class="results"></div>
            </div>

            <div class="record-details column col-xs-12 col-sm-7">
                <div class="btn-toolbar">
                    <div class="add-edit-delete-group btn-group">
                        <button id="add-service" class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus"></span>
                            <?php echo $this->lang->line('add'); ?>
                        </button>
                        <button id="edit-service" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?php echo $this->lang->line('edit'); ?>
                        </button>
                        <button id="delete-service" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-remove"></span>
                            <?php echo $this->lang->line('delete'); ?>
                        </button>
                    </div>

                    <div class="save-cancel-group btn-group" style="display:none;">
                        <button id="save-service" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok"></span>
                            <?php echo $this->lang->line('save'); ?>
                        </button>
                        <button id="cancel-service" class="btn btn-default">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                            <?php echo $this->lang->line('cancel'); ?>
                        </button>
                    </div>
                </div>

                <h3><?php echo $this->lang->line('details'); ?></h3>
                <div class="form-message alert" style="display:none;"></div>

                <input type="hidden" id="service-id" />

                <div class="form-group">
                    <label for="service-name"><?php echo $this->lang->line('name'); ?> *</label>
                    <input type="text" id="service-name" class="form-control required" />
                </div>

                <div class="form-group">
                    <label for="service-category"><?php echo $this->lang->line('category'); ?></label>
                    <select id="service-category" class="form-control"></select>
                </div>

                <div class="form-group">
                    <label for="service-description"><?php echo $this->lang->line('description'); ?></label>
                    <textarea id="service-description" rows="4" class="form-control"></textarea>
                </div>		

                <div class="form-group">
                    <label for="service-package-price">Package Price * </label><button id="add-new-package" class="btn btn-default btn-primary" disabled="disabled">Add new package</button>
                    <table id="service-package-price">
						<tr>
							<th width=50%>Duration</th>
							<th width=50%>Price</th>
						</tr>
						<tr>
							<td width=50%><input type="text" class="form-control required pack-duration" placeholder="Minutes"/></td>
							<td width=50%><input type="text" class="form-control required pack-price" placeholder="Price"/></td>
						</tr>
					</table>
                </div>				

                <p id="form-message" class="text-danger">
                    <em><?php echo $this->lang->line('fields_are_required'); ?></em>
                </p>
            </div>
        </div>
    </div>
	
    <div id="booking" class="tab-content" style="display:none;">
        <div class="row">
            <div class="filter-records column col-xs-12 col-sm-5" id="filter-booking">
				<form class="input-append">
					<input class="key" type="text">
					<div class="btn-group">
						<button class="filter btn btn-default btn-sm" type="submit" title="Filter">
							<span class="glyphglyphicon glyphicon glyphglyphicon glyphicon-search"></span>
						</button>
						<button class="clear btn btn-default btn-sm" type="button" title="Clear">
							<span class="glyphglyphicon glyphicon glyphglyphicon glyphicon-repeat"></span>
						</button>
					</div>
				</form>
            </div>

            <div class="record-details col-xs-12 col-sm-7">
				<div class="btn-toolbar">
					<div class="add-edit-delete-group btn-group">
						<button id="add-appointment" class="btn btn-primary">
							<span class="glyphicon glyphicon-plus"></span>
							<?php echo $this->lang->line('add'); ?>
						</button>
					</div>

					<div class="save-cancel-group btn-group" style="display:none;">
						<button id="save-appointment" class="btn btn-primary">
							<span class="glyphicon glyphicon-ok"></span>
							<?php echo $this->lang->line('save'); ?>
						</button>
						<button id="cancel-appointment" class="btn btn-default">
							<span class="glyphicon glyphicon-ban-circle"></span>
							<?php echo $this->lang->line('cancel'); ?>
						</button>
					</div>
				</div>
			</div>
		</div>	
		<div id="table-booking">
			
		</div>
	</div>	

    <?php
        // --------------------------------------------------------------
        //
        // CATEGORIES TAB
        //
        // --------------------------------------------------------------
    ?>
    <div id="categories" class="tab-content" style="display:none;">
        <div class="row">
            <div id="filter-categories" class="filter-records column col-xs-12 col-sm-5">
                <form class="input-append">
                    <input class="key" type="text" />
                    <div class="btn-group">
                        <button class="filter btn btn-default btn-sm" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <button class="clear btn btn-default btn-sm" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>
                </form>

                <h3><?php echo $this->lang->line('categories'); ?></h3>
                <div class="results"></div>
            </div>

            <div class="record-details col-xs-12 col-sm-7">
                <div class="btn-toolbar">
                    <div class="add-edit-delete-group btn-group">
                        <button id="add-category" class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('add'); ?>
                        </button>
                        <button id="edit-category" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?php echo $this->lang->line('edit'); ?>
                        </button>
                        <button id="delete-category" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-remove"></span>
                            <?php echo $this->lang->line('delete'); ?>
                        </button>
                    </div>

                    <div class="save-cancel-group btn-group" style="display:none;">
                        <button id="save-category" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('save'); ?>
                        </button>
                        <button id="cancel-category" class="btn btn-default">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                            <?php echo $this->lang->line('cancel'); ?>
                        </button>
                    </div>
                </div>

                <h3><?php echo $this->lang->line('details'); ?></h3>
                <div class="form-message alert" style="display:none;"></div>

                <input type="hidden" id="category-id" />

                <div class="form-group">
                    <label for="category-name"><?php echo $this->lang->line('name'); ?> *</label>
                    <input type="text" id="category-name" class="form-control required" />
                </div>

                <div class="form-group">
                    <label for="category-description"><?php echo $this->lang->line('description'); ?></label>
                    <textarea id="category-description" rows="4" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
	
    <?php
        // --------------------------------------------------------------
        //
        // ITEMS TAB
        //
        // --------------------------------------------------------------
    ?>
    <div id="items" class="tab-content" style="display:none;">
        <div class="row">
            <div id="filter-items" class="filter-records column col-xs-12 col-sm-5">
                <form class="input-append">
                    <input class="key" type="text" />
                    <div class="btn-group">
                        <button class="filter btn btn-default btn-sm" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <button class="clear btn btn-default btn-sm" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>
                </form>

                <h3>Items</h3>
                <div class="results"></div>
            </div>

            <div class="record-details col-xs-12 col-sm-7">
                <div class="btn-toolbar">
                    <div class="add-edit-delete-group btn-group">
                        <button id="add-item" class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('add'); ?>
                        </button>
                        <button id="edit-item" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?php echo $this->lang->line('edit'); ?>
                        </button>
                        <button id="delete-item" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-remove"></span>
                            <?php echo $this->lang->line('delete'); ?>
                        </button>
                    </div>

                    <div class="save-cancel-group btn-group" style="display:none;">
                        <button id="save-item" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('save'); ?>
                        </button>
                        <button id="cancel-item" class="btn btn-default">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                            <?php echo $this->lang->line('cancel'); ?>
                        </button>
                    </div>
                </div>

                <h3><?php echo $this->lang->line('details'); ?></h3>
                <div class="form-message alert" style="display:none;"></div>

                <input type="hidden" id="item-id" />

                <div class="form-group">
                    <label for="item-name"><?php echo $this->lang->line('name'); ?> *</label>
                    <input type="text" id="item-name" class="form-control required" />
                </div>
				
                <div class="form-group">
                    <label for="item-description"><?php echo $this->lang->line('description'); ?></label>
                    <textarea id="item-description" rows="4" class="form-control"></textarea>
                </div>				

                <div class="form-group">
                    <label for="item-stock">Item Stock *</label>
                    <input type="text" id="item-stock" class="form-control required" />
                </div>
            </div>
        </div>
    </div>
	
    <?php
        // --------------------------------------------------------------
        //
        // USAGE TAB
        //
        // --------------------------------------------------------------
    ?>
    <div id="usage" class="tab-content" style="display:none;">
        <div class="row">
            <div id="filter-usage" class="filter-records column col-xs-12 col-sm-5">
                <form class="input-append">
                    <input class="key" type="text" />
                    <div class="btn-group">
                        <button class="filter btn btn-default btn-sm" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <button class="clear btn btn-default btn-sm" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>
                </form>

                <h3>Item Usage</h3>
                <div class="results"></div>
            </div>

            <div class="record-details col-xs-12 col-sm-7">
                <div class="btn-toolbar">
                    <div class="add-edit-delete-group btn-group">
                        <button id="add-usage" class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('add'); ?>
                        </button>
                        <button id="edit-usage" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?php echo $this->lang->line('edit'); ?>
                        </button>
                        <button id="delete-usage" class="btn btn-default" disabled="disabled">
                            <span class="glyphicon glyphicon-remove"></span>
                            <?php echo $this->lang->line('delete'); ?>
                        </button>
                    </div>

                    <div class="save-cancel-group btn-group" style="display:none;">
                        <button id="save-usage" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok glyphicon glyphicon-white"></span>
                            <?php echo $this->lang->line('save'); ?>
                        </button>
                        <button id="cancel-usage" class="btn btn-default">
                            <span class="glyphicon glyphicon-ban-circle"></span>
                            <?php echo $this->lang->line('cancel'); ?>
                        </button>
                    </div>
                </div>

                <h3><?php echo $this->lang->line('details'); ?></h3>
                <div class="form-message alert" style="display:none;"></div>
				
				<div id="usage-field-editmode">
					<input type="hidden" id="usage-id" />
					<div class="form-group appid">
						<label for="usage-name">Appointment ID *</label>
						<input type="text" id="usage-appid" class="form-control required" disabled/>
					</div>
					
					<div class="form-group itemname">
						<label for="usage-itemname">Item Name</label>
						<input type="text" id="usage-itemname" class="form-control required" disabled/>
					</div>

					<div class="form-group usedby">
						<label for="usage-usedby">Used By</label>
						<input type="text" id="usage-usedby" class="form-control required" disabled/>
					</div>	

					<div class="form-group custname">
						<label for="usage-custname">Customer Name</label>
						<input type="text" id="usage-custname" class="form-control required" disabled/>
					</div>					

					<div class="form-group quantity">
						<label for="usage-quantity">Quantity *</label>
						<input type="text" id="usage-quantity" class="form-control required" />
					</div>
				</div>
				
				<div id="usage-field-addmode">
					<input type="hidden" id="usage-id" />
					<div class="form-group appid">
						<label for="usage-appid">Appointment ID *</label>
						<input type="text" id="add-usage-appid" class="form-control required"/>
					</div>
					
					<div class="form-group itemname">
						<label for="usage-items">Item Name</label>
						<select id="usage-items" class="form-control">
							<option value="">-----</option>
							<?php if(count($items) > 0) { foreach($items as $k=>$v){ ?>
									<option value="<?=$v['id'];?>"><?=$v['name'];?></option>
							<?php } } ?>
						</select>
					</div>
					<div class="form-group quantity">
						<label for="usage-addquantity">Quantity *</label>
						<input type="text" id="usage-addquantity" class="form-control required" />
					</div>	
				</div>				
            </div>
        </div>
    </div>	
</div>
