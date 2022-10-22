/*
 * Errors Alerts JavaScript file
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
     * Load system errors by page
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.8.5
     */    
    Main.notifications_load_system_errors =  function (page, progress) {

        // Prepare data to send
        var data = {
            action: 'notifications_load_system_errors',
            page: page
        };

        // Verify if a selected user exists
        if ( $('.notifications-page .notifications-advanced-filters-users-btn > .btn-secondary').attr('data-user') ) {

            // Set selected user
            data['user'] = $('.notifications-page .notifications-advanced-filters-users-btn > .btn-secondary').attr('data-user');

        }

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_system_errors_response', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_system_errors_response');

        }
        
    };

    /*
     * Load users which have errors
     * 
     * @since   0.0.8.4
     */    
    Main.notifications_load_system_errors_users =  function () {

        // Prepare data to send
        var data = {
            action: 'notifications_load_system_errors_users',
            key: $('.notifications-page #notifications-advanced-filters-users .notifications-search-errors-users').val()
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_system_errors_users_response');
        
    };

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Load default content
     * 
     * @since   0.0.8.4 
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

        } else {

            // Load system errors by page
            Main.notifications_load_system_errors(1);

        }

    });
    
    /*
     * Detects users filters dropdown click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */     
    $('.notifications-page #notifications-advanced-filters-users').on('show.bs.dropdown', function () {

        // Load users which have errors
        Main.notifications_load_system_errors_users();        

    });

    /*
     * Search for users
     * 
     * @since   0.0.8.4
     */
    $(document).on('keyup', '.notifications-page #notifications-advanced-filters-users .notifications-search-errors-users', function () {
        
        // Load users which have errors
        Main.notifications_load_system_errors_users();  
        
    });

    /*
     * Detects pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.5
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'system-errors':
                
                // Load system errors by page
                Main.notifications_load_system_errors(page, 1);         

                break;

        }
        
    });

    /*
     * Detect when a user is selected
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.notifications-page .notifications-errors-users-list li a', function (e) {
        e.preventDefault();
        
        // Set user's id
        $(this).closest('.dropdown').find('.btn-secondary').attr('data-user', $(this).attr('data-user'));

        // Set user's name
        $(this).closest('.dropdown').find('.btn-secondary > span').text($(this).text());

        // Load system errors by page
        Main.notifications_load_system_errors(1);
        
    });

    /*
     * Detect checkbox check
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.notifications-page .theme-list > .card-body input[type="checkbox"]', function () {

        // Show the action
        if ( $('.notifications-page .theme-list > .card-body :checkbox:checked').length > 0 ) {

            // Show actions
            $('.notifications-page .card-actions').slideDown('slow');

            // Set selected items
            $('.notifications-page .theme-list .theme-list-selected-items p').html($('.notifications-page .theme-list > .card-body :checkbox:checked').length + ' ' + words.selected_items);

        } else {

            // Hide actions
            $('.notifications-page .card-actions').slideUp('slow');
            
        }
        
    });

    /*
     * Delete system errors by id
     * 
     * @since   0.0.8.5
     */
    $(document).on('click', '.notifications-page .notifications-delete-alerts', function (e) {
        e.preventDefault();

        // Define the alerts ids variable
        var alerts_ids = [];

        // Get selected alerts ids
        $('.notifications-page .theme-list > .card-body input[type="checkbox"]:checkbox:checked').each(function () {
            alerts_ids.push($(this).closest('.card-alert').attr('data-alert'));
        });

        // Prepare data to send
        var data = {
            action: 'notifications_delete_system_errors',
            alerts: alerts_ids
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');    
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_delete_alerts_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display system errors
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.notifications_display_system_errors_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.notifications-page .theme-list > .card-footer').hide();

        // Hide actions
        $('.notifications-page .card-actions').slideUp('slow');

        // Verify if the success response exists
        if ( status === 'success' ) {

            // All alerts
            var all_alerts = '';
            
            // List all alerts
            for ( var a = 0; a < data.alerts.length; a++ ) {

                // Set start error's type area
                var error_type_area = '';

                // Verify if error's type exists
                if ( data.alerts[a].error_type ) {

                    // Set error type
                    error_type_area = ' <span class="badge bg-light theme-badge-1">'
                        + data.alerts[a].error_type
                    + '</span>';

                }

                // Set alert
                all_alerts += '<div class="card theme-box-1 card-alert" data-alert="' + data.alerts[a].alert_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-9 col-md-4 col-xs-4">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="theme-checkbox-input-1">'
                                        + '<label for="notifications-alerts-single-' + data.alerts[a].alert_id + '">'
                                            + '<input type="checkbox" id="notifications-alerts-single-' + data.alerts[a].alert_id + '" data-content="' + data.alerts[a].alert_id + '">'
                                            + '<span class="theme-checkbox-checkmark"></span>'
                                        + '</label>'
                                    + '</div>'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="' + url + 'admin/notifications?p=system_errors&alert=' + data.alerts[a].alert_id + '">'
                                                + data.alerts[a].alert_name
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-3 col-md-4 col-xs-4 text-end">'
                                + error_type_area                               
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
     * Display users which have errors response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.notifications_display_system_errors_users_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Users container
            var users = '';

            // List all users
            for ( var u = 0; u < data.users.length; u++ ) {

                // Set name
                var name = (data.users[u].first_name)?data.users[u].first_name + ' ' + data.users[u].last_name:data.users[u].username;

                // Set user
                users += '<li class="list-group-item">'
                    + '<a href="#" data-user="' + data.users[u].user_id + '">'
                        + name
                    + '</a>'
                + '</li>';

            }

            // Display the users
            $('.notifications-page #notifications-advanced-filters-users .notifications-errors-users-list').html(users);
            
        } else {
            
            // Create the no users message
            var no_errors_users = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';
            
            // Display the users
            $('.notifications-page #notifications-advanced-filters-users .notifications-errors-users-list').html(no_errors_users);
            
        }

    };

    /*
     * Display alerts deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.notifications_delete_alerts_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load all system errors by page
            Main.notifications_load_system_errors(1);
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };
 
});