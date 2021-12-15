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
     * 
     * @since   0.0.8.4
     */    
    Main.notifications_load_system_errors =  function (page) {

        // Prepare data to send
        var data = {
            action: 'notifications_load_system_errors',
            page: page
        };

        // Verify if a selected error type exists
        if ( $('.notifications-page .notifications-errors-type-btn').attr('data-type') ) {

            // Set selected error type
            data['error_type'] = $('.notifications-page .notifications-errors-type-btn').attr('data-type');

        }

        // Verify if a selected user exists
        if ( $('.notifications-page .notifications-advanced-filters-users-btn').attr('data-user') ) {

            // Set selected user
            data['user'] = $('.notifications-page .notifications-advanced-filters-users-btn').attr('data-user');

        }
        
        // Set the CSRF field
        data[$('.notifications-page').attr('data-csrf')] = $('.notifications-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_system_errors_response');
        
    };

    /*
     * Display the users alerts pagination
     *
     * @param string id contains the box identifier
     * @param integer total contains the total results 
     * 
     * @since   0.0.8.4
     */
    Main.show_system_errors_pagination = function( id, total ) {
        
        // Empty pagination
        $( id + ' .pagination' ).empty();
        
        // Verify if page is not 1
        if ( parseInt(Main.pagination.page) > 1 ) {
            
            var bac = parseInt(Main.pagination.page) - 1;
            var pages = '<li>'
                            + '<a href="#" data-page="' + bac + '">'
                                + translation.mm128
                            + '</a>'
                        + '</li>';
            
        } else {
            
            var pages = '<li class="pagehide">'
                            + '<a href="#">'
                                + translation.mm128
                            + '</a>'
                        + '</li>';
            
        }
        
        // Count pages
        var tot = parseInt(total) / 20;
        tot = Math.ceil(tot) + 1;
        
        // Calculate start page
        var from = (parseInt(Main.pagination.page) > 2) ? parseInt(Main.pagination.page) - 2 : 1;
        
        // List all pages
        for ( var p = from; p < parseInt(tot); p++ ) {
            
            // Verify if p is equal to current page
            if ( p === parseInt(Main.pagination.page) ) {
                
                // Display current page
                pages += '<li class="active">'
                            + '<a data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else if ( (p < parseInt(Main.pagination.page) + 3) && (p > parseInt(Main.pagination.page) - 3) ) {
                
                // Display page number
                pages += '<li>'
                            + '<a href="#" data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else if ( (p < 6) && (Math.round(tot) > 5) && ((parseInt(Main.pagination.page) === 1) || (parseInt(Main.pagination.page) === 2)) ) {
                
                // Display page number
                pages += '<li>'
                            + '<a href="#" data-page="' + p + '">'
                                + p
                            + '</a>'
                        + '</li>';
                
            } else {
                
                break;
                
            }
            
        }
        
        // Verify if current page is 1
        if (p === 1) {
            
            // Display current page
            pages += '<li class="active">'
                        + '<a data-page="' + p + '">'
                            + p
                        + '</a>'
                    + '</li>';
            
        }
        
        // Set the next page
        var next = parseInt( Main.pagination.page );
        next++;
        
        // Verify if next page should be displayed
        if (next < Math.round(tot)) {
            
            $( id + ' .pagination' ).html( pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>' );
            
        } else {
            
            $( id + ' .pagination' ).html( pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>' );
            
        }
        
    };

    /*
     * Load system errors types
     * 
     * @since   0.0.8.4
     */    
    Main.notifications_load_system_errors_types =  function () {

        // Prepare data to send
        var data = {
            action: 'notifications_load_system_errors_types',
            key: $('.notifications-page #notifications-errors-types .notifications-search-errors-types').val()
        };
        
        // Set the CSRF field
        data[$('.notifications-page').attr('data-csrf')] = $('.notifications-page').attr('data-csrf-value');

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_display_system_errors_types_response');
        
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
        
        // Set the CSRF field
        data[$('.notifications-page').attr('data-csrf')] = $('.notifications-page').attr('data-csrf-value');

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
     * Detects errors types dropdown click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.4
     */     
    $('.notifications-page #notifications-errors-types').on('show.bs.dropdown', function () {

        // Load system errors types
        Main.notifications_load_system_errors_types();

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
     * Search for system errors types
     * 
     * @since   0.0.8.3
     */
    $(document).on('keyup', '.notifications-page #notifications-errors-types .notifications-search-errors-types', function () {
        
        // Load system errors types
        Main.notifications_load_system_errors_types();
        
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
     * @since   0.0.8.4
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');

        // Display results
        switch ($(this).closest('ul').attr('data-type')) {

            case 'system-errors':

                // Load system errors by page
                Main.notifications_load_system_errors(page);
                
                // Display loading animation
                $('.page-loading').fadeIn('slow');              

                break;

        }
        
    });

    /*
     * Delete system error
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.notifications-page .notifications-delete-alert', function (e) {
        e.preventDefault();
        
        // Get alert's id
        var alert_id = $(this).closest('.notifications-alerts-single').attr('data-alert');

        // Prepare data to send
        var data = {
            action: 'notifications_delete_system_error',
            alert: alert_id
        };

        // Set the CSRF field
        data[$('.notifications-page').attr('data-csrf')] = $('.notifications-page').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_delete_system_errors_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Delete multiple users alerts
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.notifications-page .notifications-delete-errors', function (e) {
        e.preventDefault();

        // Define the alerts ids variable
        var alerts_ids = [];
        
        // Get selected users alerts ids
        $('.notifications-page .notifications-list-errors li input[type="checkbox"]:checkbox:checked').each(function () {
            alerts_ids.push($(this).closest('.notifications-alerts-single').attr('data-alert'));
        });

        // Prepare data to send
        var data = {
            action: 'notifications_delete_system_errors',
            alerts: alerts_ids
        };

        // Set the CSRF field
        data[$('.notifications-page').attr('data-csrf')] = $('.notifications-page').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/notifications', 'POST', data, 'notifications_delete_system_errors_response');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*
     * Detect all errors selection
     * 
     * @since   0.0.8.4
     */ 
    $( document ).on( 'click', '.notifications-page #notifications-errors-select-all', function () {
        
        // Run after 500 mileseconds
        setTimeout(function(){
            
            // Verify if slect all is checked
            if ( $( '.notifications-page #notifications-errors-select-all' ).is(':checked') ) {

                // Check all
                $( '.notifications-page .notifications-list-errors li input[type="checkbox"]' ).prop('checked', true);

            } else {

                // Uncheck all
                $( '.notifications-page .notifications-list-errors li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });

    /*
     * Detect when an error type is selected
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.notifications-page .notifications-errors-types-list li a', function (e) {
        e.preventDefault();
        
        // Set error type
        $(this).closest('.dropdown').find('.notifications-errors-type-btn').attr('data-type', $(this).attr('data-type'));

        // Set error type text
        $(this).closest('.dropdown').find('.notifications-errors-type-btn').text($(this).text());

        // Remove the selected user
        $('.notifications-page .notifications-advanced-filters-users-btn').removeAttr('data-user');

        // Set all users text
        $('.notifications-page .notifications-advanced-filters-users-btn').text(words.all_users);

        // Hide the collapse
        $( '.notifications-page #notifications-advanced-filters' ).collapse('hide');

        // Load system errors by page
        Main.notifications_load_system_errors(1);
        
    });

    /*
     * Detect when a user is selected
     * 
     * @since   0.0.8.4
     */
    $(document).on('click', '.notifications-page .notifications-errors-users-list li a', function (e) {
        e.preventDefault();
        
        // Set user's id
        $(this).closest('.dropdown').find('.notifications-advanced-filters-users-btn').attr('data-user', $(this).attr('data-user'));

        // Set user's name
        $(this).closest('.dropdown').find('.notifications-advanced-filters-users-btn').text($(this).text());

        // Load system errors by page
        Main.notifications_load_system_errors(1);
        
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

        // Hide Pagination
        $('.notifications-page .pagination-area').hide();  

        // Uncheck all selected alerts
        $( '.notifications-page #notifications-errors-select-all' ).prop('checked', false)

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Set the current page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_system_errors_pagination('.notifications-page', data.total);

            // All alerts
            var all_alerts = '';
            
            // List all alerts
            for ( var a = 0; a < data.alerts.length; a++ ) {

                // Set start user's area
                var user_area = '<div class="col-lg-2 col-md-4 col-xs-4">';

                // Verify if user's id exists
                if ( data.alerts[a].user_id ) {

                    // Verify if a selected error type exists
                    if ( $('.notifications-page .notifications-errors-type-btn').attr('data-type') ) {

                        // Show the collapse
                        $( '.notifications-page #notifications-advanced-filters' ).collapse('show');

                    }

                    // Get user's name
                    var name = (data.alerts[a].first_name)?data.alerts[a].first_name + ' ' + data.alerts[a].last_name:data.alerts[a].username;  

                    // Add user to user's area
                    user_area += '<a href="' + url + 'admin/members?p=all_members&amp;member=118" class="notifications-alert-user">'
                        + '<i class="material-icons-outlined">'
                            + 'person_outline'
                        + '</i>'
                        + name
                    + '</a>';

                } else {

                    // Verify if a selected error type exists
                    if ( $('.notifications-page .notifications-errors-type-btn').attr('data-type') ) {

                        // Hide the collapse
                        $( '.notifications-page #notifications-advanced-filters' ).collapse('hide');

                    }

                }

                // Set end user's area
                user_area += '</div>';
                
                // Set start error's type area
                var error_type_area = '<div class="col-lg-1 col-md-2 col-xs-2">';

                // Verify if error's type exists
                if ( data.alerts[a].error_type ) {

                    // Set error type
                    error_type_area += ' <span class="label label-default">'
                        + data.alerts[a].error_type
                    + '</span>';

                }

                // Set end error's type area
                error_type_area += '</div>';                

                // Set template
                all_alerts += '<li class="notifications-alerts-single" data-alert="' + data.alerts[a].alert_id + '">'
                    + '<div class="row">'
                        + '<div class="col-lg-8 col-md-6 col-xs-6">'
                            + '<div class="checkbox-option-select">'
                                + '<input id="notifications-alert-single-' + data.alerts[a].alert_id + '" name="notifications-alert-single-' + data.alerts[a].alert_id + '" data-id="' + data.alerts[a].alert_id + '" type="checkbox">'
                                + '<label for="notifications-alert-single-' + data.alerts[a].alert_id + '"></label>'
                            + '</div>'
                            + '<a href="' + url + 'admin/notifications?p=system_errors&alert=' + data.alerts[a].alert_id + '">'
                                + data.alerts[a].alert_name
                            + '</a>'
                        + '</div>'
                        + user_area
                        + error_type_area
                        + '<div class="col-lg-1 col-md-2 col-xs-2 text-right">'
                            + '<div class="btn-group">'
                                + '<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    + '<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots-vertical" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'
                                        + '<path fill-rule="evenodd" d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />'
                                    + '</svg>'
                                + '</button>'
                                + '<ul class="dropdown-menu">'
                                    + '<li>'
                                        + '<a href="#" class="notifications-delete-alert">'
                                            + '<i class="icon-trash"></i>'
                                            + data.words.delete
                                        + '</a>'
                                    + '</li>'
                                + '</ul>'
                            + '</div>'
                        + '</div>'
                    + '</div>'
                + '</li>';

            }

            // Get the page
            var page = ( (data.page - 1) < 1)?1:((data.page - 1) * 20);

            // Get results to
            var to = ((parseInt(page) * 20) < data.total)?(parseInt(data.page) * 20):data.total;

            // Display the errors alerts
            $('.notifications-page .notifications-list-errors').html(all_alerts);

            // Display start listing
            $('.notifications-page .pagination-from').text(page);  
            
            // Display end listing
            $('.notifications-page .pagination-to').text(to);  

            // Display total items
            $('.notifications-page .pagination-total').text(data.total);

            // Show Pagination
            $('.notifications-page .pagination-area').show();  
            
        } else {
            
            // Set no data found message
            var no_data = '<li>'
                                + data.message
                            + '</li>';

            // Display the no data found message
            $('.notifications-page .notifications-list-errors').html(no_data);   
            
        }

    }

    /*
     * Display the system errors deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.notifications_delete_system_errors_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all system errors by page
            Main.notifications_load_system_errors(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the system errors types response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.4
     */
    Main.methods.notifications_display_system_errors_types_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Types container
            var types = '';

            // List all errors types
            for ( var e = 0; e < data.errors_types.length; e++ ) {

                // Set type
                types += '<li class="list-group-item">'
                    + '<a href="#" data-type="' + data.errors_types[e].field_value + '">'
                        + data.errors_types[e].field_value
                    + '</a>'
                + '</li>';

            }

            // Display the types
            $('.notifications-page #notifications-errors-types .notifications-errors-types-list').html(types);
            
        } else {
            
            // Create the no errors types message
            var no_errors_types = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';
            
            // Display the types
            $('.notifications-page #notifications-errors-types .notifications-errors-types-list').html(no_errors_types);
            
        }

    };

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
            var no_errors_users = '<li class="list-group-item no-results-found">'
                + data.message
            + '</li>';
            
            // Display the users
            $('.notifications-page #notifications-advanced-filters-users .notifications-errors-users-list').html(no_errors_users);
            
        }

    };

    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/
 
});