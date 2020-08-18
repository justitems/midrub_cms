/*
 * Api javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
 
    /*
     * Load api applications list
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.7
    */
    Main.load_api_applications = function (page) {
        
        var data = {
            action: 'load_api_applications',
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'load_api_applications');
        
    }; 

   
    /*******************************
    ACTIONS
    ********************************/
    
    /*
     * Detect dropdown change
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .dropdown-menu a', function (e) {
        e.preventDefault();
        
        // Get status text
        var status = $(this).text();
        
        // Get status type
        var status_type = $(this).attr('data-type');
        
        // Get permission
        var permission = $(this).closest('.btn-group').attr('data-permission');
        
        // Add new status
        $(this).closest('.btn-group').find('.btn-secondary').text(status);
        
        // Add new status type
        $(this).closest('.btn-group').find('.btn-secondary').attr('data-type', status_type);
        
        var data = {
            action: 'update_api_permission_settings',
            permission: permission,
            status: status_type
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'update_api_permission_settings');
        
    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'all-applications':
                Main.load_api_applications(page);
                break;           
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Delete api application
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .delete-api-application', function (e) {
        e.preventDefault();
        
        // Get application's id
        var application_id = $(this).closest('li').attr('data-id');
        
        var data = {
            action: 'delete_api_application',
            application_id: application_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'GET', data, 'delete_api_application');
        
    });
    
    /*
     * Get update api application modal
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */    
    $( document ).on( 'click', 'body .manage-api-application', function (e) {
        e.preventDefault();
        
        // Get application's id
        var application_id = $(this).closest('li').attr('data-id');
        
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
    $( document ).on( 'click', 'body #new-application .application-list-permissions .select-app-permission, body #update-application .application-list-permissions .select-app-permission', function (e) {
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
     * Display permission change response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.update_api_permission_settings = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    }; 
    
    /*
     * Display application creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.7
     */
    Main.methods.create_new_api_app = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset form
            $('body .api-create-new-app')[0].reset();
            
            // Remove selected permissions
            $('body #new-application .application-list-permissions .select-app-permission').removeClass('btn-success');
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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

        // Verify if the success response exists
        if ( status === 'success' ) { 
            
            Main.pagination.page = data.page;
            Main.show_pagination('#api-applications', data.total);
            
            var all_applications = '';
            
            // List all applications
            for ( var r = 0; r < data.applications.length; r++ ) {
                        
                all_applications += '<li data-id="' + data.applications[r].application_id + '">'
                                        + '<div class="row">'
                                            + '<div class="col-xs-7">'
                                                + '<h3>'
                                                    + data.applications[r].application_name
                                                + '</h3>'
                                                + '<p>'
                                                    + '<a href="' + url + 'admin/users#' + data.applications[r].user_id + '">'
                                                        + '<i class="fas fa-user"></i>'
                                                        + data.applications[r].username
                                                    + '</a>'
                                                + '</p>'
                                            + '</div>'
                                            + '<div class="col-xs-5">'
                                                + '<div class="btn-group" role="group" aria-label="Manage App">'
                                                    + '<button type="button" class="btn btn-default manage-api-application">'
                                                        + '<i class="icon-login"></i>'
                                                        + data.words.manage
                                                    + '</button>'
                                                    + '<button type="button" class="btn btn-default delete-api-application">'
                                                        + '<i class="icon-trash"></i>'
                                                    + '</button>'
                                                + '</div>'
                                            + '</div>'                                       
                                        + '</div>'
                                    + '</li>';
                
            }
            
            // Display applications
            $('.settings .api-apps-list').html(all_applications);
            
        } else {
            
            var no_applications = '<li>'
                                    + data.message
                                + '</li>';
                    
            // Display message
            $('.settings .api-apps-list').html(no_applications);
            
            // Empty pagination
            $('#api-applications .pagination').empty();
            
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

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load Api Applications
            Main.load_api_applications(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
            
            // Display Modal
            $("#update-application").modal();
            
            // Display application's title
            $("#update-application .application_name").val(data.application[0].application_name);
            
            // Display redirect url
            $("#update-application .application_redirect_url").val(data.application[0].redirect_url);

            // Display cancel redirect url
            $("#update-application .application_cancel_url").val(data.application[0].cancel_url);
            
            // Add application's id
            $("#update-application").attr('data-id', data.application[0].application_id); 
            $("#update-application .application_app_id").val(data.application[0].application_id);
            
            // Add application's secret
            $("#update-application .application_app_secret").val(data.secret_key);
            
            // Remove selected permissions
            $('body #update-application .application-list-permissions .select-app-permission').removeClass('btn-success');
            
            if ( data.permissions.length ) {

                for ( var o = 0; o < data.permissions.length; o++ ) {

                    $('body #update-application .application-list-permissions .select-app-permission[data-permission="' + data.permissions[o].permission_slug + '"]').addClass('btn-success');

                }
                
            }
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
     $(document).on('submit', '#new-application .api-create-new-app', function (e) {
        e.preventDefault();
        
        var all_permissions = [];
        
        // Get all permissions
        var permissions = $('body #new-application .application-list-permissions .select-app-permission').length;
        
        for ( var o = 0; o < permissions; o++ ) {
            
            if ( $('body #new-application .application-list-permissions .select-app-permission').eq(o).hasClass('btn-success') ) {
                
                all_permissions.push($('body #new-application .application-list-permissions .select-app-permission').eq(o).attr('data-permission'));
                
            }
            
        }

        // Create an object with form data
        var data = {
            action: 'create_new_api_app',
            application_name: $(this).find('.application_name').val(),
            all_permissions: all_permissions,
        };

        // Verify if redirect url isn't empty
        if ( $(this).find('.application_redirect_url').val() ) {
            data['redirect_url'] = 'url: ' + $(this).find('.application_redirect_url').val();
        }

        // Verify if cancel redirect url isn't empty
        if ( $(this).find('.application_app_cancel_redirect').val() ) {
            data['cancel_redirect'] = 'url: ' + $(this).find('.application_app_cancel_redirect').val();
        }        
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'create_new_api_app');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 
    
    /*
     * Update an api app
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.7
     */
     $(document).on('submit', '#update-application .api-update-app', function (e) {
        e.preventDefault();
        
        var all_permissions = [];
        
        // Get all permissions
        var permissions = $('body #update-application .application-list-permissions .select-app-permission').length;
        
        for ( var o = 0; o < permissions; o++ ) {
            
            if ( $('body #update-application .application-list-permissions .select-app-permission').eq(o).hasClass('btn-success') ) {
                
                all_permissions.push($('body #update-application .application-list-permissions .select-app-permission').eq(o).attr('data-permission'));
                
            }
            
        }

        // Create an object with form data
        var data = {
            action: 'update_api_app',
            application_id: $(this).closest('.modal').attr('data-id'),
            application_name: $(this).find('.application_name').val(),
            all_permissions: all_permissions
        };
        
        // Verify if redirect url isn't empty
        if ( $(this).find('.application_redirect_url').val() ) {
            data['redirect_url'] = 'url: ' + $(this).find('.application_redirect_url').val();
        }

        // Verify if cancel redirect url isn't empty
        if ( $(this).find('.application_app_cancel_redirect').val() ) {
            data['cancel_redirect'] = 'url: ' + $(this).find('.application_app_cancel_redirect').val();
        }  
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'update_api_app');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    
    /*******************************
    DEPENDENCIES
    ********************************/


    // Load Api Applications
    if ( $('body .api-apps-list').length > 0 ) {
        
        Main.load_api_applications(1);
        
    }
    
});