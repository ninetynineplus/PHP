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
     * UsageHelper Class
     *
     * This class contains the core method implementations that belong to the categories tab
     * of the backend services page.
     *
     * @class UsageHelper
     */
    function UsageHelper() {
        this.filterResults = {};
    };

    /**
     * Binds the default event handlers of the item tab.
     */
    UsageHelper.prototype.bindEventHandlers = function() {
        var instance = this;

        /**
         * Event: Filter item Cancel Button "Click"
         */
        $('#filter-usage .clear').click(function() {
            $('#filter-usage .key').val('');
            instance.filter('');
            instance.resetForm();
        });

        /**
         * Event: Filter items Form "Submit"
         */
        $('#filter-usage form').submit(function() {
            var key = $('#filter-usage .key').val();
            $('.selected').removeClass('selected');
            instance.resetForm();
            instance.filter(key);
            return false;
        });

        /**
         * Event: Filter items Row "Click"
         *
         * Displays the selected row data on the right side of the page.
         */
        $(document).on('click', '.usage-row', function() {
            if ($('#filter-usage .filter').prop('disabled')) {
                $('#filter-usage .results').css('color', '#AAA');
                return; // exit because we are on edit mode
            }

            var categoryId = $(this).attr('data-id');
            var category = {};
            $.each(instance.filterResults, function(index, item) {
                if (item.id === categoryId) {
                    category = item;
                    return false;
                }
            });

            instance.display(category);
            $('#filter-usage .selected').removeClass('selected');
            $(this).addClass('selected');
            $('#edit-usage, #delete-usage').prop('disabled', false);
        });

        /**
         * Event: Add Category Button "Click"
         */
        $('#add-usage').click(function() {
            instance.resetForm();
            $('#usage .add-edit-delete-group').hide();
            $('#usage .save-cancel-group').show();
            $('#filter-usage button').prop('disabled', true);
            $('#filter-usage .results').css('color', '#AAA');
			
			$('#usage #usage-field-addmode').show();
			$('#usage #usage-field-editmode').hide();
			$('#usage-field-addmode input').val('');
        });

        /**
         * Event: Edit Category Button "Click"
         */
        $('#edit-usage').click(function() {
            $('#usage .add-edit-delete-group').hide();
            $('#usage .save-cancel-group').show();

            $('#filter-usage button').prop('disabled', true);
            $('#filter-usage .results').css('color', '#AAA');
			
			$('#usage #usage-field-addmode').hide();
			$('#usage #usage-field-editmode').show();
        });

        /**
         * Event: Delete Category Button "Click"
         */
        $('#delete-usage').click(function() {
            var categoryId = $('#usage-id').val();

            var messageBtns = {};
            messageBtns[EALang['delete']] = function() {
                instance.delete(categoryId);
                $('#message_box').dialog('close');
            };
            messageBtns[EALang['cancel']] = function() {
                $('#message_box').dialog('close');
            };

            GeneralFunctions.displayMessageBox('Delete item usage',
                    EALang['delete_record_prompt'], messageBtns);
        });

        /**
         * Event: items Save Button "Click"
         */
        $('#save-usage').click(function() {
			
			var item;
			
			if($("#usage-field-addmode").is(":visible"))
			{
				item = {
					appid: $('#add-usage-appid').val(),
					items: $('#usage-items').val(),
					stock: $('#usage-addquantity').val()
				};
			}else{
				item = {
					id: $('#usage-id').val(),
					stock: $('#usage-quantity').val()
				};					
			}

            if (!instance.validate(item)) {
                return;
            }
			
            instance.save(item);
        });

        /**
         * Event: Cancel item Button "Click"
         */
        $('#cancel-usage').click(function() {
            var id = $('#usage-appid').val();
            instance.resetForm();
            if (id !== '') {
                instance.select(id, true);
            }
        });
    };

    /**
     * Filter service items records.
     *
     * @param {String} key This key string is used to filter the category records.
     * @param {Number} selectId Optional, if set then after the filter operation the record with the given
     * ID will be selected (but not displayed).
     * @param {Boolean} display Optional (false), if true then the selected record will be displayed on the form.
     */
    UsageHelper.prototype.filter = function(key, selectId, display) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_filter_service_item_usage';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            key: key
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            this.filterResults = response;

            $('#filter-usage .results').data('jsp').destroy();
            $('#filter-usage .results').html('');
            $.each(response, function(index, category) {
                var html = this.getFilterHtml(category);
                $('#filter-usage .results').append(html);
            }.bind(this));
            $('#filter-usage .results').jScrollPane({ mouseWheelSpeed: 70 });

            if (response.length === 0) {
                $('#filter-usage .results').html('<em>' + EALang['no_records_found'] + '</em>');
            }

            if (selectId !== undefined) {
                this.select(selectId, display);
            }
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Save a category record to the database (via AJAX post).
     *
     * @param {Object} category Contains the category data.
     */
    UsageHelper.prototype.save = function(category) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_service_item_usage';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            item: JSON.stringify(category)
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            Backend.displayNotification(EALang['service_inventory_saved']);
            this.resetForm();
            $('#filter-usage .key').val('');
            this.filter('', response.id, true);
            BackendServices.updateAvailableCategories();
        }. bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Delete category record.
     *
     * @param Number} id Record ID to be deleted.
     */
    UsageHelper.prototype.delete = function(id) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_delete_service_item_usage';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            usage_id: id
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            Backend.displayNotification(EALang['service_category_deleted']);

            this.resetForm();
            this.filter($('#filter-usage .key').val());
            BackendServices.updateAvailableCategories();
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Display a category record on the form.
     *
     * @param {Object} category Contains the category data.
     */
    UsageHelper.prototype.display = function(item) {
		$('#usage-id').val(item.id);
        $('#usage-appid').val(item.appid);
		$('#usage-itemname').val(item.name);
		$('#usage-usedby').val(item.emfirstname+" "+item.emlastname);
		$('#usage-custname').val(item.custfirstname+" "+item.custlastname);
		$('#usage-quantity').val(item.stock);
    };

    /**
     * Validate category data before save (insert or update).
     *
     * @param {Object} category Contains the category data.
     */
    UsageHelper.prototype.validate = function(item) {
        $('#usage .record-details').find('input, textarea').css('border', '');

        try {
            var missingRequired = false;

			if($("#usage-field-addmode").is(":visible"))
			{
				$('#usage-field-addmode .required').each(function() {
					if ($(this).val() === '' || $(this).val() === undefined) {
						$(this).css('border', '2px solid red');
						missingRequired = true;
					}
				});

				if (missingRequired) {
					throw EALang['fields_are_required'];
				}				
			}else{
				$('#usage-field-editmode .required').each(function() {
					if ($(this).val() === '' || $(this).val() === undefined) {
						$(this).css('border', '2px solid red');
						missingRequired = true;
					}
				});

				if (missingRequired) {
					throw EALang['fields_are_required'];
				}					
			}

            return true;
        } catch(exc) {
            return false;
        }
    };

    /**
     * Bring the category form back to its initial state.
     */
    UsageHelper.prototype.resetForm = function() {
        $('#usage .add-edit-delete-group').show();
        $('#usage .save-cancel-group').hide();
        $('#edit-usage, #delete-usage').prop('disabled', true);

        $('#filter-usage .selected').removeClass('selected');
        $('#filter-usage .results').css('color', '');
        $('#filter-usage button').prop('disabled', false);
		
        $('#usage #usage-field-addmode').hide();
        $('#usage #usage-field-editmode').show();
    };

    /**
     * Get the filter results row HTML code.
     *
     * @param {Object} category Contains the category data.
     *
     * @return {String} Returns the record HTML code.
     */
    UsageHelper.prototype.getFilterHtml = function(category) {
        var html =
                '<div class="usage-row entry" data-id="' + category.id + '">' +
                    '<strong>' + category.name + '</strong>' +
                '</div><hr>';

        return html;
    };

    /**
     * Select a specific record from the current filter results.
     *
     * If the category ID does not exist in the list then no record will be selected.
     *
     * @param {Number} id The record ID to be selected from the filter results.
     * @param {Boolean} display Optional (false), if true then the method will display the record
     * on the form.
     */
    UsageHelper.prototype.select = function(id, display) {
        display = display || false;

        $('#filter-usage .selected').removeClass('selected');

        $('#filter-usage .usage-row').each(function() {
            if ($(this).attr('data-id') === id) {
                $(this).addClass('selected');
                return false;
            }
        });

        if (display) {
            $.each(this.filterResults, function(index, item) {
                if (item.appid === id) {
                    this.display(item);
                    $('#edit-usage, #delete-usage').prop('disabled', false);
                    return false;
                }
            }.bind(this));
        }
    };

    window.UsageHelper = UsageHelper;
})();
