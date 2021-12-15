/*
 * Api javascript file
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
     * Load api applications list
     * 
     * @param integer page contains the page number
     * @param integer progress contains the progress option
     * 
     * @since   0.0.7.7
    */
    Main.load_api_applications = function (page, progress) {
        
        // Prepare the data
        var data = {
            action: 'load_api_applications',
            page: page
        };

        // Verify if progress exists
        if ( typeof progress !== 'undefined' ) {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'load_api_applications', 'ajax_onprogress');

            // Set progress bar
            Main.set_progress_bar();

        } else {

            // Make ajax call
            Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'load_api_applications');

        }
        
    }; 

   
    /*******************************
    ACTIONS
    ********************************/

    /*
    * Load default content
    *
    * @since   0.0.8.5
    */
    $(function () {

        // Load Api Applications
        if ( $('body .settings-new-api-app').length > 0 ) {
            
            // Get the api's apps
            Main.load_api_applications(1);
            
        }

    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .theme-pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'applications':
                Main.load_api_applications(page, 1);
                break;           
            
        }
        
    });
    
    /*
     * Delete api application
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .settings-delete-application', function (e) {
        e.preventDefault();
        
        // Get application's id
        var application_id = $(this).closest('.card-application').attr('data-application');
        
        // Prepare data
        var data = {
            action: 'delete_api_application',
            application_id: application_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'delete_api_application');
        
    });
    
    /*
     * Get api application modal
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .card-application .settings-show-application', function (e) {
        e.preventDefault();
        
        // Get application's id
        var application_id = $(this).closest('.card-application').attr('data-application');
        
        // Prepare data to send
        var data = {
            action: 'manage_api_application',
            application_id: application_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'manage_api_application');
        
    });    
    
    /*
     * Select/Unselect application's permissions
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body #settings-new-application .settings-application-list-permissions .settings-select-app-permission, body #settings-update-application .settings-application-list-permissions .settings-select-app-permission', function (e) {
        e.preventDefault();
        
        if ( $(this).hasClass('btn-success') ) {
            
            $(this).removeClass('btn-success');
            
        } else {
            
            $(this).addClass('btn-success');
            
        }
        
    });
   
    /*******************************
    RESPONSES
    ********************************/
    
    /*
     * Display application creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.create_new_api_app = function ( status, data ) { 

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Reset form
            $('body .settings-api-create-new-app')[0].reset();
            
            // Remove selected permissions
            $('body #settings-new-application .settings-application-list-permissions .settings-select-app-permission').removeClass('btn-success');
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display application update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.update_api_app = function ( status, data ) {
        
        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display api applications list
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.load_api_applications = function ( status, data ) { 

        // Remove progress bar
        Main.remove_progress_bar();

        // Hide pagination
        $('.settings-page .theme-list > .card-footer').hide(); 

        // Verify if the success response exists
        if ( status === 'success' ) { 
            
            // All applications container
            var all_applications = '';
            
            // List all applications
            for ( var r = 0; r < data.applications.length; r++ ) {

                // Add application to the container
                all_applications += '<div class="card theme-box-1 card-application" data-application="' + data.applications[r].application_id + '">'
                    + '<div class="card-header">'
                        + '<div class="row">'
                            + '<div class="col-lg-7 col-md-5 col-xs-5">'
                                + '<div class="media d-flex justify-content-start">'
                                    + '<div class="media-body">'
                                        + '<h5>'
                                            + '<a href="#" class="settings-show-application">'
                                                + data.applications[r].application_name
                                            + '</a>'
                                        + '</h5>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                            + '<div class="col-lg-4 col-md-4 col-xs-4">'
                                + '<a href="' + url + 'admin/members?p=all_members&member=' + data.applications[r].user_id + '" class="settings-application-author">'
                                    + words.icon_person
                                    + data.applications[r].username
                                + '</a>'
                            + '</div>'
                            + '<div class="col-lg-1 col-md-2 col-xs-2 text-end">'
                                + '<div class="btn-group theme-dropdown-2">'
                                    + '<button type="button" class="btn dropdown-toggle text-end" aria-haspopup="true" aria-expanded="false" data-bs-toggle="dropdown">'
                                        + words.icon_more
                                    + '</button>'
                                    + '<ul class="dropdown-menu">'
                                        + '<li>'
                                            + '<a href="#" class="settings-delete-application">'
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
            
            // Display applications
            $('.settings-page .theme-list > .card-body').html(all_applications);   
            
            // Set limit
            let limit = ((data.page * 10) < data.total)?(data.page * 10):data.total;

            // Set text
            $('.settings-page .theme-list > .card-footer h6').html((((data.page - 1) * 10) + 1) + '-' + limit + ' ' + data.words.of + ' ' + data.total + ' ' + data.words.results);

            // Set page
            Main.pagination.page = data.page;

            // Display the pagination
            Main.show_pagination('.settings-page .theme-list', data.total);

            // Show pagination
            $('.settings-page .theme-list > .card-footer').show();  
            
        } else {

            // Set no data found message
            var no_data = '<p class="theme-box-1 theme-list-no-results-found">'
                                + data.message
                            + '</p>';

            // Display the no data found message
            $('.settings-page .theme-list > .card-body').html(no_data);    
            
        }
        
    };
    
    /*
     * Display application deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.delete_api_application = function ( status, data ) { 

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display application's update modal
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.manage_api_application = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Reset form
            $("#settings-update-application .settings-api-update-application")[0].reset();
            
            // Display Modal
            $("#settings-update-application").modal('show');
            
            // Display application's title
            $("#settings-update-application .settings-application-name").val(data.application[0].application_name);
            
            // Display redirect url
            $("#settings-update-application .settings-application-redirect").val(data.application[0].redirect_url);

            // Display cancel redirect url
            $("#settings-update-application .settings-application-redirect-cancel").val(data.application[0].cancel_url);
            
            // Add application's id
            $("#settings-update-application").attr('data-id', data.application[0].application_id); 
            $("#settings-update-application .settings-application-id").val(data.application[0].application_id);
            
            // Add application's secret
            $("#settings-update-application .settings-application-secret").val(data.secret_key);
            
            // Remove selected permissions
            $('body #settings-update-application .settings-application-list-permissions .settings-select-app-permission').removeClass('btn-success');
            
            if ( data.permissions.length ) {

                for ( var o = 0; o < data.permissions.length; o++ ) {

                    $('body #settings-update-application .settings-application-list-permissions .settings-select-app-permission[data-permission="' + data.permissions[o].permission_slug + '"]').addClass('btn-success');

                }
                
            }
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
   
    /*******************************
    FORMS
    ********************************/
    
    /*
     * Create a new api app
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */
     $(document).on('submit', '#settings-new-application .settings-api-create-new-app', function (e) {
        e.preventDefault();
        
        var all_permissions = [];
        
        // Get all permissions
        var permissions = $('body #settings-new-application .settings-application-list-permissions .settings-select-app-permission').length;
        
        for ( var o = 0; o < permissions; o++ ) {
            
            if ( $('body #settings-new-application .settings-application-list-permissions .settings-select-app-permission').eq(o).hasClass('btn-success') ) {
                
                all_permissions.push($('body #settings-new-application .settings-application-list-permissions .settings-select-app-permission').eq(o).attr('data-permission'));
                
            }
            
        }

        // Create an object with form data
        var data = {
            action: 'create_new_api_app',
            application_name: $(this).find('.settings-application-name').val(),
            all_permissions: all_permissions,
        };

        // Verify if redirect url isn't empty
        if ( $(this).find('.settings-application-redirect').val() ) {
            data['redirect_url'] = 'url: ' + $(this).find('.settings-application-redirect').val();
        }

        // Verify if cancel redirect url isn't empty
        if ( $(this).find('.settings-application-redirect-cancel').val() ) {
            data['cancel_redirect'] = 'url: ' + $(this).find('.settings-application-redirect-cancel').val();
        }        
        
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'create_new_api_app', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 
    
    /*
     * Update an api app
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */
     $(document).on('submit', '#settings-update-application .settings-api-update-application', function (e) {
        e.preventDefault();
        
        var all_permissions = [];
        
        // Get all permissions
        var permissions = $('body #settings-update-application .settings-application-list-permissions .settings-select-app-permission').length;
        
        for ( var o = 0; o < permissions; o++ ) {
            
            if ( $('body #settings-update-application .settings-application-list-permissions .settings-select-app-permission').eq(o).hasClass('btn-success') ) {
                
                all_permissions.push($('body #settings-update-application .settings-application-list-permissions .settings-select-app-permission').eq(o).attr('data-permission'));
                
            }
            
        }

        // Create an object with form data
        var data = {
            action: 'update_api_app',
            application_id: $(this).closest('.modal').attr('data-id'),
            application_name: $(this).find('.settings-application-name').val(),
            all_permissions: all_permissions
        };
        
        // Verify if redirect url isn't empty
        if ( $(this).find('.settings-application-redirect').val() ) {
            data['redirect_url'] = 'url: ' + $(this).find('.settings-application-redirect').val();
        }

        // Verify if cancel redirect url isn't empty
        if ( $(this).find('.settings-application-redirect-cancel').val() ) {
            data['cancel_redirect'] = 'url: ' + $(this).find('.settings-application-redirect-cancel').val();
        } 
        
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'update_api_app', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
    
});