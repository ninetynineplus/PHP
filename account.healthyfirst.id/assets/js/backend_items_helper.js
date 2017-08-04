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
     * ItemsHelper Class
     *
     * This class contains the core method implementations that belong to the categories tab
     * of the backend services page.
     *
     * @class ItemsHelper
     */
    function ItemsHelper() {
        this.filterResults = {};
    };

    /**
     * Binds the default event handlers of the item tab.
     */
    ItemsHelper.prototype.bindEventHandlers = function() {
        var instance = this;

        /**
         * Event: Filter item Cancel Button "Click"
         */
        $('#filter-items .clear').click(function() {
            $('#filter-items .key').val('');
            instance.filter('');
            instance.resetForm();
        });

        /**
         * Event: Filter items Form "Submit"
         */
        $('#filter-items form').submit(function() {
            var key = $('#filter-items .key').val();
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
        $(document).on('click', '.item-row', function() {
            if ($('#filter-items .filter').prop('disabled')) {
                $('#filter-items .results').css('color', '#AAA');
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
            $('#filter-items .selected').removeClass('selected');
            $(this).addClass('selected');
            $('#edit-item, #delete-item').prop('disabled', false);
        });

        /**
         * Event: Add Category Button "Click"
         */
        $('#add-item').click(function() {
            instance.resetForm();
            $('#items .add-edit-delete-group').hide();
            $('#items .save-cancel-group').show();
            $('#items .record-details').find('input, textarea').prop('readonly', false);
            $('#filter-items button').prop('disabled', true);
            $('#filter-items .results').css('color', '#AAA');
        });

        /**
         * Event: Edit Category Button "Click"
         */
        $('#edit-item').click(function() {
            $('#items .add-edit-delete-group').hide();
            $('#items .save-cancel-group').show();
            $('#items .record-details').find('input, textarea').prop('readonly', false);

            $('#filter-items button').prop('disabled', true);
            $('#filter-items .results').css('color', '#AAA');
        });

        /**
         * Event: Delete Category Button "Click"
         */
        $('#delete-item').click(function() {
            var categoryId = $('#item-id').val();

            var messageBtns = {};
            messageBtns[EALang['delete']] = function() {
                instance.delete(categoryId);
                $('#message_box').dialog('close');
            };
            messageBtns[EALang['cancel']] = function() {
                $('#message_box').dialog('close');
            };

            GeneralFunctions.displayMessageBox('Delete Item',
                    EALang['delete_record_prompt'], messageBtns);
        });

        /**
         * Event: items Save Button "Click"
         */
        $('#save-item').click(function() {
            var item = {
                name: $('#item-name').val(),
                description: $('#item-description').val(),
				stock: $('#item-stock').val()
            };

            if ($('#item-id').val() !== '') {
                item.id = $('#item-id').val();
            }

            if (!instance.validate(item)) {
                return;
            }

            instance.save(item);
        });

        /**
         * Event: Cancel item Button "Click"
         */
        $('#cancel-item').click(function() {
            var id = $('#item-id').val();
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
    ItemsHelper.prototype.filter = function(key, selectId, display) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_filter_service_items';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            key: key
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            this.filterResults = response;

            $('#filter-items .results').data('jsp').destroy();
            $('#filter-items .results').html('');
            $.each(response, function(index, category) {
                var html = this.getFilterHtml(category);
                $('#filter-items .results').append(html);
            }.bind(this));
            $('#filter-items .results').jScrollPane({ mouseWheelSpeed: 70 });

            if (response.length === 0) {
                $('#filter-items .results').html('<em>' + EALang['no_records_found'] + '</em>');
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
    ItemsHelper.prototype.save = function(category) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_save_service_item';
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
            $('#filter-items .key').val('');
            this.filter('', response.id, true);
            BackendServices.updateAvailableCategories();
        }. bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Delete category record.
     *
     * @param Number} id Record ID to be deleted.
     */
    ItemsHelper.prototype.delete = function(id) {
        var postUrl = GlobalVariables.baseUrl + '/index.php/backend_api/ajax_delete_service_item';
        var postData = {
            csrfToken: GlobalVariables.csrfToken,
            item_id: id
        };

        $.post(postUrl, postData, function(response) {
            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                return;
            }

            Backend.displayNotification(EALang['service_item_deleted']);

            this.resetForm();
            this.filter($('#filter-items .key').val());
            BackendServices.updateAvailableCategories();
        }.bind(this), 'json').fail(GeneralFunctions.ajaxFailureHandler);
    };

    /**
     * Display a category record on the form.
     *
     * @param {Object} category Contains the category data.
     */
    ItemsHelper.prototype.display = function(item) {
        $('#item-id').val(item.id);
        $('#item-name').val(item.name);
        $('#item-description').val(item.description);
		$('#item-stock').val(item.stock);
    };

    /**
     * Validate category data before save (insert or update).
     *
     * @param {Object} category Contains the category data.
     */
    ItemsHelper.prototype.validate = function(item) {
        $('#items .record-details').find('input, textarea').css('border', '');

        try {
            var missingRequired = false;

            $('#items .required').each(function() {
                if ($(this).val() === '' || $(this).val() === undefined) {
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
     * Bring the category form back to its initial state.
     */
    ItemsHelper.prototype.resetForm = function() {
        $('#items .add-edit-delete-group').show();
        $('#items .save-cancel-group').hide();
        $('#items .record-details').find('input, textarea').val('');
        $('#items .record-details').find('input, textarea').prop('readonly', true);
        $('#edit-category, #delete-category').prop('disabled', true);

        $('#filter-items .selected').removeClass('selected');
        $('#filter-items .results').css('color', '');
        $('#filter-items button').prop('disabled', false);
    };

    /**
     * Get the filter results row HTML code.
     *
     * @param {Object} category Contains the category data.
     *
     * @return {String} Returns the record HTML code.
     */
    ItemsHelper.prototype.getFilterHtml = function(category) {
        var html =
                '<div class="item-row entry" data-id="' + category.id + '">' +
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
    ItemsHelper.prototype.select = function(id, display) {
        display = display || false;

        $('#filter-items .selected').removeClass('selected');

        $('#filter-items .item-row').each(function() {
            if ($(this).attr('data-id') === id) {
                $(this).addClass('selected');
                return false;
            }
        });

        if (display) {
            $.each(this.filterResults, function(index, item) {
                if (item.id === id) {
                    this.display(item);
                    $('#edit-item, #delete-item').prop('disabled', false);
                    return false;
                }
            }.bind(this));
        }
    };

    window.ItemsHelper = ItemsHelper;
})();
