/*
 * Users Alerts JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Load plans by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.3
     */    
    Main.notifications_load_all_plans = function (page) {

        // Prepare data to send
        var data = {
            action: 'notifications_load_all_plans',
            page: page,
            key: $('#notifications-users-alert-filters-plans-filter .notifications-search-for-plans').val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_all_plans_response');
        
    };

    /*
     * Load all selected plans
     * 
     * @since   0.0.8.3
     */    
    Main.notifications_load_selected_plans = function () {

        // Verify if the list exists
        if ( typeof Main.alerts_filters_plans === 'undefined' ) {

            // Set array
            Main.alerts_filters_plans = [];

        }

        // Prepare data to send
        var data = {
            action: 'notifications_load_selected_plans',
            plans: Main.alerts_filters_plans
        };

        // Verify if user's alert exists
        if ( $('.notifications-page .notifications-users-alert').attr('data-alert') ) {

            // Set user's alert
            data['alert'] = $('.notifications-page .notifications-users-alert').attr('data-alert');

        }
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_selected_plans');
        
    };

    /*
     * Load users alerts by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.3
     */    
    Main.notifications_load_users_alerts =  function (page, progress) {

        // Prepare data to send
        var data = {
            action: 'notifications_load_users_alerts',
            key: $('.notifications-page .notifications-search-alerts').val(),
            page: page
            
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_users_alerts', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_users_alerts');

        }
        
    };

    /*
     * Load plans for a users alert
     * 
     * @since   0.0.8.3
     */    
    Main.notifications_load_users_alert_plans =  function () {

        // Prepare data to send
        var data = {
            action: 'notifications_load_users_alert_plans',
            alert: $('.notifications-page .notifications-users-alert').attr('data-alert')
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_users_alert_plans');
        
    };

    /*
     * Load alert's users by page
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.8.3
     */    
    Main.notifications_load_alert_users = function (page) {

        // Prepare data to send
        var data = {
            action: 'notifications_load_all_alert_users',
            alert: $('.notifications-page .notifications-users-alert').attr('data-alert'),
            page: page
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_all_alert_users_response');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.3 
     */
    $(function () {

        // Get all summernote's editors
        var editors = $(document).find('.summernote-editor');

        // Verify if the page contains editors
        if (editors.length > 0) {

            // List all editors
            for (var e = 0; e < editors.length; e++) {

                // Display editor
                $(editors[e]).summernote('code', $(editors[e]).closest('.row').find('.summernote-editor-textarea').val());

            }

            // Verify if is the alert's page
            if ( $('.notifications-page .notifications-users-alert').attr('data-alert') ) {
                
                // Load all alert's users
                Main.notifications_load_alert_users(1);

                // Load the selected plans
                Main.notifications_load_selected_plans();

            }

        } else {

            // Load all users alerts by page
            Main.notifications_load_users_alerts(1);

        }

    });

    /*
     * Detect when the Plans Filter modal opens
     * 
     * @since   0.0.8.3
     */     
    $('#notifications-users-alert-filters-plans-filter').on('show.bs.modal', function () {

        // Load plans by page  
        Main.notifications_load_all_plans(1);

    });

    /*
     * Detect when the Languages Filter modal opens
     * 
     * @since   0.0.8.3
     */     
    $('#notifications-users-alert-filters-languages-filter').on('show.bs.modal', function () {

        // List all checked languages
        $('.notifications-page .notifications-selected-languages-list > li').each(function() {
            $( '#notifications-users-alert-filters-languages-filter input[data-language="' + $(this).attr('data-language') + '"]' ).prop('checked', true);
        });

    });

    /*
     * Detect when the Plans Filter modal closes
     * 
     * @since   0.0.8.3
     */     
    $('#notifications-users-alert-filters-plans-filter').on('hide.bs.modal', function () {

        // Verify if the list exists
        if ( typeof Main.alerts_filters_plans !== 'undefined' ) {

            // Load the selected plans
            Main.notifications_load_selected_plans();

        }

    });

    /*
     * Detect when the Languages Filter modal closes
     * 
     * @since   0.0.8.3
     */     
    $('#notifications-users-alert-filters-languages-filter').on('hide.bs.modal', function () {

        // Verify if the list exists
        if ( typeof Main.alerts_filters_languages !== 'undefined' ) {

            // Verify if laguages were selected
            if ( Main.alerts_filters_languages.length > 0 ) {

                // All languages
                var all_languages = '';
                
                // List all languages
                for ( var l = 0; l < Main.alerts_filters_languages.length; l++ ) {

                    // Set language
                    all_languages += '<li data-language="' + Main.alerts_filters_languages[l] + '">'
                        + '<p>'
                            + Main.alerts_filters_languages[l].charAt(0).toUpperCase() + Main.alerts_filters_languages[l].slice(1)
                        + '</p>'
                    + '</li>';

                }

                // Display languages
                $('.notifications-page .notifications-users-alert-filters .notifications-selected-languages-list').html(all_languages);
                
            } else {  
                
                // Set no selected languages message
                var no_data = '<li class="default-card-box-no-items-found">'
                                    + words.no_languages_were_selected
                                + '</li>';

                // Display the no selected languages message
                $('.notifications-page .notifications-users-alert-filters .notifications-selected-languages-list').html(no_data);   
                
            }

        }

    });

    /*
     * Search for user alerts
     * 
     * @since   0.0.8.3
     */
    $(document).on('keyup', '.notifications-page .notifications-search-alerts', function () {
        
        // Load all users alerts by page
        Main.notifications_load_users_alerts(1);
        
    });

    /*
     * Search for plans
     * 
     * @since   0.0.8.3
     */
    $(document).on('keyup', '#notifications-users-alert-filters-plans-filter .notifications-search-for-plans', function () {
        
        // Load plans by page  
        Main.notifications_load_all_plans(1);
        
    });

    /*
     * Detect when a plan is selected or unselected
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $(document).on('change', '#notifications-users-alert-filters-plans-filter .notifications-users-alert-filters-plans-filter-list [type="checkbox"]', function (e) {
        
        // Verify if plan exists
        if ( $(this).attr('data-plan') ) {

            // Verify if the list exists
            if ( typeof Main.alerts_filters_plans === 'undefined' ) {

                // Set array
                Main.alerts_filters_plans = [];

            }

            // Verify if the checkbox is checked
            if ( $( this ).is(':checked') ) {

                // Set plan
                Main.alerts_filters_plans.push($(this).attr('data-plan'));

            } else {

                // Search for plan
                var index = Main.alerts_filters_plans.indexOf($(this).attr('data-plan'));

                // Verify if the plan exists
                if (index !== -1) {

                    // Remove plan
                    Main.alerts_filters_plans.splice(index, 1);

                }

            }

        }
        
    });
    
    /*
     * Detect when a language is selected or unselected
     * 
     * @since   0.0.8.3
     */
    $(document).on('change', '#notifications-users-alert-filters-languages-filter .notifications-users-alert-filters-languages-filter-list [type="checkbox"]', function () {
        
        // Verify if language exists
        if ( $(this).attr('data-language') ) {

            // Verify if the list exists
            if ( typeof Main.alerts_filters_languages === 'undefined' ) {

                // Set array
                Main.alerts_filters_languages = [];

            }

            // Verify if the checkbox is checked
            if ( $( this ).is(':checked') ) {

                // Set language
                Main.alerts_filters_languages.push($(this).attr('data-language'));

            } else {

                // Search for language
                var index = Main.alerts_filters_languages.indexOf($(this).attr('data-language'));

                // Verify if the language exists
                if (index !== -1) {

                    // Remove language
                    Main.alerts_filters_languages.splice(index, 1);

                }

            }

        }
        
    });

    /*
     * Detects pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'plans':
                
                // Load plans by page  
                Main.notifications_load_all_plans(page);            

                break;

            case 'users-alerts':

                // Load all users alerts by page
                Main.notifications_load_users_alerts(page, 1);             

                break;

            case 'alert-users':

                // Load all alert's users
                Main.notifications_load_alert_users(page);            

                break;

        }
        
    });

    /*
     * Select alert type
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */    
    $( document ).on( 'click', '.notifications-page .notifications-select-alert-type > .btn-secondary', function (e) {
        e.preventDefault();
        
        // First remove the selected button
        $(this).closest('.notifications-select-alert-type').find('.btn-secondary').attr('aria-expanded', 'false');

        // Add selected class
        $(this).attr('aria-expanded', 'true').blur();

        // Hide all tabs
        $($(this).attr('data-bs-tab')).closest('.tab-content').find('> .tab-pane').removeClass('active show');

        // Show tab
        $($(this).attr('data-bs-tab')).addClass('active show');
        
    });

    /*
     * Delete users alert
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.notifications-page .notifications-delete-alert', function (e) {
        e.preventDefault();
        
        // Get alert's id
        var alert_id = $(this).closest('.notifications-alerts-single').attr('data-alert');

        // Prepare data to send
        var data = {
            action: 'notifications_delete_users_alert',
            alert: alert_id
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_delete_users_alert_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Delete multiple users alerts
     * 
     * @since   0.0.8.3
     */
    $(document).on('click', '.notifications-page .notifications-delete-alerts', function (e) {
        e.preventDefault();

        // Define the alerts ids variable
        var alerts_ids = [];
        
        // Get selected users alerts ids
        $('.notifications-page .notifications-list-alerts li input[type="checkbox"]:checkbox:checked').each(function () {
            alerts_ids.push($(this).closest('.notifications-alerts-single').attr('data-alert'));
        });

        // Prepare data to send
        var data = {
            action: 'notifications_delete_users_alerts',
            alerts: alerts_ids
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_delete_users_alerts_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Detect all members selection
     * 
     * @since   0.0.8.3
     */ 
    $( document ).on( 'click', '.notifications-page #notifications-alerts-select-all', function () {
        
        // Run after 500 mileseconds
        setTimeout(function(){
            
            // Verify if slect all is checked
            if ( $( '.notifications-page #notifications-alerts-select-all' ).is(':checked') ) {

                // Check all
                $( '.notifications-page .notifications-list-alerts li input[type="checkbox"]' ).prop('checked', true);

            } else {

                // Uncheck all
                $( '.notifications-page .notifications-list-alerts li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });
   
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display users alerts
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_display_users_alerts = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.notifications-page .theme-list > .card-footer').hide();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All alerts
            var all_alerts = '';
            
            // List all alerts
            for ( var a = 0; a < data.alerts.length; a++ ) {

                // Default alert's type
                var alert_type = '<span class="badge bg-light theme-badge-1">'
                                + data.words.news
                            + '</span>';

                // Verify if the alert's type is not default
                if ( parseInt(data.alerts[a].alert_type) === 1 ) {

                    // Set new alert type
                    alert_type = '<span class="badge bg-primary theme-badge-1">'
                                    + data.words.promo
                                + '</span>';         

                } else if ( parseInt(data.alerts[a].alert_type) === 2 ) {

                    // Set new alert type
                    alert_type = '<span class="badge bg-info theme-badge-1">'
                                    + data.words.fixed
                                + '</span>';         

                }

                // Set alert
                all_alerts += '<div class="card theme-box-1 card-alert" data-alert="' + data.alerts[a].alert_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-6">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="notifications-alerts-single-' + data.alerts[a].alert_id + '">'
                                            + '<input type="checkbox" id="notifications-alerts-single-' + data.alerts[a].alert_id + '" data-content="' + data.alerts[a].alert_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/notifications?p=users_alerts&alert=' + data.alerts[a].alert_id + '">'
                                                + data.alerts[a].alert_name
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-3 text-center">'
                                + alert_type                                
                            + '</div>'                            
                            + '<div class="col-3 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="frontend-delete-content">'
                                                + words.icon_delete
                                                + data.words.delete
                                            + '</a>'
                                        + '</li>'
                                    + '</ul>'
                                + '</div>'                                
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</div>';

            }

            // Display alerts
            $('.notifications-page .theme-list > .card-body').html(all_alerts);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.notifications-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.notifications-page .theme-list', data.total);

            // Show pagination
            $('.notifications-page .theme-list > .card-footer').show();           
            
        } else {
            
            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.notifications-page .theme-list > .card-body').html(no_data);     
            
        }

    }

    /*
     * Display plans by page
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_display_all_plans_response = function ( status, data ) {

        // Uncheck all checkboxes
        $( '#notifications-users-alert-filters-plans-filter input[type="checkbox"]' ).prop('checked', false);
        
        // Hide the pagination
        $('#notifications-users-alert-filters-plans-filter .modal-footer').hide();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Verify if the list exists
            if ( typeof Main.alerts_filters_plans === 'undefined' ) {

                // Set array
                Main.alerts_filters_plans = [];

            }

            // All plans
            var all_plans = '';
            
            // List all plans
            for ( var p = 0; p < data.plans.length; p++ ) {

                // Checked var
                var checked = '';

                // Search for plan
                var index = Main.alerts_filters_plans.indexOf(data.plans[p].plan_id);

                // Verify if the plan is checked
                if ( index !== -1 ) {

                    // Set checked
                    checked = ' checked';

                }            

                // Set plan
                all_plans += '<li>'
                    + '<div class="row">'
                        + '<div class="col-xs-12 d-flex justify-content-start position-relative">'
                            + '<div class="checkbox-option-select theme-checkbox-input-1">'
                                + '<label for="notifications-users-alert-filters-plans-filter-plan-' + data.plans[p].plan_id + '">'
                                    + '<input type="checkbox" name="notifications-users-alert-filters-plans-filter-plan-' + data.plans[p].plan_id + '" id="notifications-users-alert-filters-plans-filter-plan-' + data.plans[p].plan_id + '" data-plan="' + data.plans[p].plan_id + '"' + checked + ' />'
                                    + '<span class="theme-checkbox-checkmark"></span>'
                                + '</label>'
                            + '</div>'
                            + '<span>'
                                + data.plans[p].plan_name
                            + '</span>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Display plans
            $('#notifications-users-alert-filters-plans-filter .notifications-users-alert-filters-plans-filter-list').html(all_plans);

            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('#notifications-users-alert-filters-plans-filter .modal-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('#notifications-users-alert-filters-plans-filter', data.total);

            // Show pagination
            $('#notifications-users-alert-filters-plans-filter .modal-footer').show(); 
            
            // List all checked plans
            $('.notifications-page .notifications-selected-plans-list > li').each(function() {
                $( '#notifications-users-alert-filters-plans-filter input[data-plan="' + $(this).attr('data-plan') + '"]' ).prop('checked', true);
            });
            
        } else {  
            
            // Set no data found message
            var no_data = '<li class="no-results-found">'
                                + data.message
                            + '</li>';

            // Display plans
            $('#notifications-users-alert-filters-plans-filter .notifications-users-alert-filters-plans-filter-list').html(no_data);   
            
        }

    };

    /*
     * Display all selected plans
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_display_selected_plans = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All plans
            var all_plans = '';
            
            // List all plans
            for ( var p = 0; p < data.plans.length; p++ ) {

                // Set plan
                all_plans += '<li data-plan="' + data.plans[p].plan_id + '">'
                    + '<p>'
                        + data.plans[p].plan_name
                    + '</p>'
                + '</li>';

            }

            // Display plans
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-plans-list').html(all_plans);
            
        } else {  
            
            // Set no selected plans message
            var no_data = '<li class="default-card-box-no-items-found">'
                                + data.message
                            + '</li>';

            // Display the no selected plans message
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-plans-list').html(no_data);   
            
        }

    };

    /*
     * Displays the users alerts creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_create_users_alert_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000); 

            // Reset the form
            $('.notifications-page .notifications-create-users-alert')[0].reset();

            // Get all summernote's editors
            var editors = $(document).find('.summernote-editor');

            // Verify if the page contains editors
            if (editors.length > 0) {

                // List all editors
                for (var e = 0; e < editors.length; e++) {

                    // Reset editor
                    $(editors[e]).summernote('code', '');

                }

            }

            // Set no selected plans message
            var no_plans = '<li class="default-card-box-no-items-found">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';

            // Display the no selected plans message
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-plans-list').html(no_plans);   

            // Set no selected languages message
            var no_languages = '<li class="default-card-box-no-items-found">'
                                + words.no_languages_were_selected
                            + '</li>';

            // Display the no selected languages message
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-languages-list').html(no_languages);

            // Verify if plans object is selected
            if ( typeof Main.alerts_filters_plans !== 'undefined' ) {

                // Delete plans object
                delete Main.alerts_filters_plans;

            }
            
        } else {  

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }

    };

    /*
     * Display the users alert deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_delete_users_alert_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all users alerts by page
            Main.notifications_load_users_alerts(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the users alerts deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_delete_users_alerts_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all users alerts by page
            Main.notifications_load_users_alerts(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the users alert plans
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_display_users_alert_plans = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All plans
            var all_plans = '';
            
            // List all plans
            for ( var p = 0; p < data.plans.length; p++ ) {

                // Set plan
                all_plans += '<li data-plan="' + data.plans[p].plan_id + '">'
                    + data.plans[p].plan_name
                + '</li>';

            }

            // Display plans
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-plans-list').html(all_plans);
            
        } else {  
            
            // Set no selected plans message
            var no_data = '<li class="default-card-box-no-items-found">'
                                + data.message
                            + '</li>';

            // Display the no selected plans message
            $('.notifications-page .notifications-users-alert-filters .notifications-selected-plans-list').html(no_data);   
            
        }

    };

    /*
     * Display the alert's users
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.3
     */
    Main.methods.notifications_display_all_alert_users_response = function ( status, data ) {

        // Hide the pagination
        $('.notifications-page .notifications-users-alert .pagination-area').hide();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Users container
            var users = '';

            // List found users
            for ( var u = 0; u < data.users.length; u++ ) {

                // Set name
                var name = (data.users[u].first_name)?data.users[u].first_name + ' ' + data.users[u].last_name:data.users[u].username;

                // Set banner activity
                var banner_activity = (parseInt(data.users[u].banner_seen) > 0)?'<span class="label label-default">' + data.words.banner_seen + '</span>':'<span class="label label-light">' + data.words.banner_unseen + '</span>';

                // Set page activity
                var page_activity = (parseInt(data.users[u].page_seen) > 0)?'<span class="label label-primary">' + data.words.page_seen + '</span>':'<span class="label label-light">' + data.words.page_unseen + '</span>';

                // User's status
                var member_status = '<span class="notifications-user-status-active">'
                    + data.words.active
                + '</span>';

                // Verify if status is inactive
                if ( parseInt(data.users[u].status) === 0 ) {

                    // New member's status
                    member_status = '<span class="notifications-user-status-inactive">'
                        + data.words.inactive
                    + '</span>';                    

                } else if ( parseInt(data.users[u].status) === 2 ) {

                    // New member's status
                    member_status = '<span class="notifications-user-status-blocked">'
                        + data.words.blocked
                    + '</span>';                    

                }

                // Add user to container
                users += '<li class="notifications-user-single">'
                    + '<div class="row">'
                        + '<div class="col-lg-5 col-md-4 col-xs-4">'
                            + '<div class="media">'
                                + '<div class="media-left">'
                                    + '<img class="mr-3" src="' + data.users[u].avatar + '" alt="User Avatar" />'
                                + '</div>'
                                + '<div class="media-body">'
                                    + '<h5 class="mt-0">'
                                        + '<a href="' + url + 'admin/members?p=all_members&member=' + data.users[u].user_id + '">'
                                            + name
                                        + '</a>'
                                    + '</h5>'
                                + member_status
                                + '</div>'
                            + '</div>'
                        + '</div>'
                        + '<div class="col-lg-2 col-md-2 col-xs-2">'
                            + '<div class="notifications-user-activity">'
                                + banner_activity
                            + '</div>'
                        + '</div>'                        
                        + '<div class="col-lg-2 col-md-2 col-xs-2">'
                            + '<div class="notifications-user-activity">'
                                + page_activity
                            + '</div>'
                        + '</div>'
                        + '<div class="col-lg-3 col-md-3 col-xs-3">'
                            + '<div class="notifications-user-seen-time">'
                                + '<span>'
                                    + Main.calculate_time(data.users[u].created, data.current_time).replace(/<[^>]*>?/gm, '')
                                + '</span>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Display users
            $('.notifications-page .notifications-users-alert .notifications-list-users').html(users);

            // Get the page
            var page = ( (data.page - 1) < 1)?1:((data.page - 1) * 20);

            // Get results to
            var to = ((parseInt(page) * 20) < data.total)?(parseInt(data.page) * 20):data.total;

            // Display start listing
            $('.notifications-page .notifications-users-alert .pagination-area .pagination-from').text(page);  
            
            // Display end listing
            $('.notifications-page .notifications-users-alert .pagination-area .pagination-to').text(to);  

            // Display total users
            $('.notifications-page .notifications-users-alert .pagination-area .pagination-total').text(data.total);

            // Show the pagination
            $('.notifications-page .notifications-users-alert .pagination-area').show();
            
        } else {  
            
            // Create the no users message
            var no_users = '<li class="default-card-box-no-items-found">'
                + data.message
            + '</li>';

            // Display the no users message
            $('.notifications-page .notifications-users-alert .notifications-list-users').html(no_users);            
            
        }

    };

    /*******************************
    FORMS
    ********************************/

    /*
     * Create a users alert
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.3
     */
    $('.notifications-page .notifications-create-users-alert').submit(function (e) {
        e.preventDefault();

        // Prepare data to send
        var data = {
            action: 'notifications_create_users_alert',
            alert_name: $(this).find('#notifications-alert-name').val()
        };

        // Verify if alert's type is selected
        if ( $(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').length > 0 ) {

            // Set alert type
            data['alert_type'] = $(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-type');

            // Get all banner's editors
            var banner_editors = $($(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-bs-tab')).find('.tab-all-banner-editors > .tab-pane');

            // Verify if banner editors exists
            if ( banner_editors.length > 0 ) {

                // Banners containers
                var banners = [];
                
                // List all banner's editors
                for ( var b = 0; b < banner_editors.length; b++ ) {

                    // Set banner language
                    banners[$(banner_editors[b]).find('.summernote-editor').attr('data-dir')] = []

                    // Add banners to the list
                    banners[$(banner_editors[b]).find('.summernote-editor').attr('data-dir')].push($(banner_editors[b]).find('.summernote-editor').summernote('code'));
                    
                }

                // Set the alert banners
                data['alert_banner'] = Object.entries(banners);

            }

            // Verify if the banner enable checkbox exists
            if ( $($(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-bs-tab')).find('#notifications-alert-enable-banner').length > 0 ) {

                // Verify if the banner is enabled
                if ( $($(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-bs-tab')).find('#notifications-alert-enable-banner').is(':checked') ) {

                    // Set alert's banner as enabled
                    data['alert_banner_enabled'] = 1;                    

                } else {

                    // Set alert's banner as disabled
                    data['alert_banner_enabled'] = 0;   

                }

            }

            // Get all page's editors
            var page_editors = $($(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-bs-tab')).find('.tab-all-page-editors > .tab-pane');
            
            // Verify if pages exists
            if ( page_editors.length > 0 ) {

                // Page title container
                var page_title = [];

                // Page container
                var page = [];                

                // List all page's editors
                for ( var p = 0; p < page_editors.length; p++ ) {

                    // Verify if page title already exists
                    if ( typeof data['alert_page_title'] === 'undefined' ) {
                        data['alert_page_title'] = [];
                    }

                    // Verify if page content already exists
                    if ( typeof data['alert_page'] === 'undefined' ) {
                        data['alert_page'] = [];
                    }
                    
                    // Set page title language
                    page_title[$(page_editors[p]).find('.summernote-editor').attr('data-dir')] = [];

                    // Set page content language
                    page[$(page_editors[p]).find('.summernote-editor').attr('data-dir')] = [];

                    // Set page title
                    page_title[$(page_editors[p]).find('.summernote-editor').attr('data-dir')].push($(page_editors[p]).find('.notifications-alert-page-title').val());

                    // Set page content
                    page[$(page_editors[p]).find('.summernote-editor').attr('data-dir')].push($(page_editors[p]).find('.summernote-editor').summernote('code'));
                    
                }

                // Set the page title to data
                data['alert_page_title'] = Object.entries(page_title);

                // Set the page content to data
                data['alert_page'] = Object.entries(page);

            }

            // Verify if the alert's page is enabled
            if ( $($(this).find('.notifications-select-alert-type > .btn-secondary[aria-expanded="true"]').attr('data-bs-tab')).find('.notifications-alert-page-enabled').is(':checked') ) {

                // Set alert's page as enabled
                data['alert_page_enabled'] = 1;                    

            } else {

                // Set alert's page as disabled
                data['alert_page_enabled'] = 0;   

            }            

        }

        // Get selected plans filters
        var plans_filters = $(this).find('.notifications-users-alert-filters .notifications-selected-plans-list > [data-plan]');
        
        // Verify if plans filters are selected
        if ( plans_filters.length > 0 ) {

            // Plans container
            var plans = [];

            // List plans
            for ( var p = 0; p < plans_filters.length; p++ ) {

                // Set plan
                plans.push($(plans_filters[p]).attr('data-plan'));

            }

            // Set plans to data
            data['plans'] = plans;

        }

        // Get selected language filters
        var languages_filters = $(this).find('.notifications-users-alert-filters .notifications-selected-languages-list > [data-language]');
        
        // Verify if language filters are selected
        if ( languages_filters.length > 0 ) {

            // Languages container
            var languages = [];

            // List languages
            for ( var l = 0; l < languages_filters.length; l++ ) {

                // Set language
                languages.push($(languages_filters[l]).attr('data-language'));

            }

            // Set languages to data
            data['languages'] = languages;

        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_create_users_alert_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
 
});