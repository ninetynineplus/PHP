/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2016, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

(function() {

    'use strict';

    /**
     * BookingHelper
     *
     * This class contains the methods that will be used by the "Services" tab of the page.
     *
     * @class BookingHelper
     */
    function BookingHelper() {
		
    };

    BookingHelper.prototype.bindEventHandlers = function() {
		var instance = this;
		
		$("#start-datetime").datetimepicker();
		
        $('#booking form').submit(function(event) {
            var key = {key:$('#booking .key').val()};
            instance.filter(key);
            return false;
        });		
		
        $('#booking .clear').click(function() {
            $('#booking .key').val('');
            instance.filter('');
            instance.resetForm();
        });
		
        $('#booking #add-appointment').click(function() {
			instance.edit();
        });
		
        /**
         * Event: Save Service Button "Click"
         */
        $('#save-appointment').click(function() {
            var booking = {
                email: $('#email').val(),
                service: $('#select-service').val(),
				reqgender: $('#select-gender').val(),
				therapist: $('#select-provider').val(),
				starttime: $('#start-datetime').val(),
				address: $('#address').val(),
				payment: $('#payment').val(),
				pay: 0,
				status: $('#select-status').val()
            };

            if ($('#appointment-id').val() !== '') {
                booking.id = $('#appointment-id').val();
            }
			
            if ($('#payment').val() == 'Voucher') {
                booking.voucher = $('#voucher').val();
            }
			
            if ($('#pay').val() != '') {
                booking.pay = $('#pay').val();
            }			

            if (!instance.validate(booking)) {
				alert("Please fill the required Field");
                return;
            }			

            instance.save(booking);
        });		

        /**
         * Event: Cancel Booking Button "Click"
         *
         * Cancel add or edit of a booking record.
         */
        $('#cancel-appointment').click(function() {
            instance.filter('');
            instance.resetForm();
        });		

       $(document).on('change', '#booking #limit', function() {
            var limit = $('#booking #limit').val();
			var page = $('#booking #selectpage').val();
			var keyword = $('#booking .key').val();
			
            var key = {key:$('#booking .key').val(), limit: limit, page: page};
            instance.filter(key);		
			return false;
        });	

       $(document).on('click', '.edit-app', function() {
			instance.edit($(this).attr("data-id"));
        });		
		
       $(document).on('change', '#booking #selectpage', function() {
            var limit = $('#booking #limit').val();
			var page = $('#booking #selectpage').val();
			var keyword = $('#booking .key').val();
			
            var key = {key:$('#booking .key').val(), limit: limit, page: page};
            instance.filter(key);		
			return false;
        });			
    };

    /**
     * Save booking record to database.
     *
     * @param {Object} booking Contains the booking record data. If an 'id' value is provided
     * then the update operation is going to be executed.
     */
    BookingHelper.prototype.save = function(booking) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_booking';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            booking: JSON.stringify(booking)
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            Backend.displayNotification("Booking Saved");
			this.filter('');
            this.resetForm();
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);		
    };

    /**
     * Delete a service record from database.
     *
     * @param {Number} id Record ID to be deleted.
     */
    BookingHelper.prototype.delete = function(id) {

    };

    /**
     * Validates a service record.
     *
     * @param {Object} booking Contains the booking data.
     *
     * @return {Boolean} Returns the validation result.
     */
    BookingHelper.prototype.validate = function(booking) {
        $('#booking .required').css('border', '');

        try {
            // validate required fields.
            var missingRequired = false;

            $('#booking .required').each(function() {
                if ($(this).val() == '' || $(this).val() == undefined) {
                    $(this).css('border', '2px solid red');
                    missingRequired = true;
                }
            });

            if (missingRequired) {
                throw EALang['fields_are_required'];
            }

            return true;
        } catch(exc) {
            return false;
        }
    };

    /**
     * Resets the service tab form back to its initial state.
     */
    BookingHelper.prototype.resetForm = function() {
		$('#booking .key').val('');
		$('#booking .add-edit-delete-group').show();
		$('#booking .save-cancel-group').hide();
		$('#filter-booking button').prop('disabled', false);			
    };

    /**
     * Display a service record into the service form.
     *
     * @param {Object} service Contains the service record data.
     */
    BookingHelper.prototype.display = function(service) {
		
    };

    /**
     * Filters service records depending a string key.
     *
     * @param {String} key This is used to filter the service records of the database.
     * @param {Number} selectId Optional, if set then after the filter operation the record with this
     * ID will be selected (but not displayed).
     * @param {Boolean} display Optional (false), if true then the selected record will be displayed on the form.
     */
    BookingHelper.prototype.filter = function(key, selectId, display) {
       display = display || false;

        var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/getList';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            key: key
        };

		$.post( postUrl, postData, function( data ) {
		  $( "#booking #table-booking" ).html( data );
		});
    };
	
    BookingHelper.prototype.edit = function(key) {
		var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/getform';
		var postData = {
			csrfToken: GlobalVariables.csrfToken,
			id: key
		};

		$.post( postUrl, postData, function( data ) {
		  $( "#booking #table-booking" ).html( data );
		  $('.boyDatepicker').datetimepicker({dateFormat:'yy-mm-dd', timeFormat: 'HH:mm:ss' });
		});
		
		$('#booking .add-edit-delete-group').hide();
		$('#booking .save-cancel-group').show();
		$('#filter-booking button').prop('disabled', true);	
    };	

    /**
     * Select a specific record from the current filter results. If the service id does not exist
     * in the list then no record will be selected.
     *
     * @param {Number} id The record id to be selected from the filter results.
     * @param {Boolean} display Optional (false), if true then the method will display the record on the form.
     */
    BookingHelper.prototype.select = function(id, display) {
		
    };

    window.BookingHelper = BookingHelper;
})();
