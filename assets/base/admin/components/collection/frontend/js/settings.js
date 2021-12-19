/*
 * Frontend Settings javascript file
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
     * Get pages by category
     * 
     * @param string drop_class contains the dropdown's class
     * 
     * @since   0.0.7.8
     */    
    Main.frontend_settings_load_pages_by_category =  function (drop_class) {

        // Prepare data
        var data = {
            action: 'settings_auth_pages_list',
            drop_class: drop_class,
            key: $('.frontend-page .theme-settings-options .list-group-item[data-field="' + drop_class + '"] .theme-dropdown-search-for-items').val()
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_settings_display_pages_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    };

    /*
     * Load selected options
     * 
     * @since   0.0.7.8
     */    
    Main.load_selected_settings =  function () {

        // Prepare data
        var data = {
            action: 'settings_all_options'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'GET', data, 'settings_all_options');
        
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

        // Load selected options
        Main.load_selected_settings();

    });

    /*
     * Search pages by category
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', '.frontend-page .theme-settings-options .list-group-item .theme-dropdown-search-for-items', function () {

        // Verify if an event was already scheduled
        if ( typeof Main.queue !== 'undefined' ) {

            // Clear previous timout
            clearTimeout(Main.queue);

        }

        // Schedule event
        Main.schedule_event(function() {

            // Load pages
            Main.frontend_settings_load_pages_by_category($(this).closest('.list-group-item').attr('data-field'));

        }, 1000);  
        
    });

    /*
     * Get auth pages
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.frontend-page .theme-dynamic-dropdown', function (e) {
        e.preventDefault();

        // Load pages
        Main.frontend_settings_load_pages_by_category($(this).closest('.list-group-item').attr('data-field'));
        
    });  
    
    /*
     * Save settings
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all dropdowns
        var dropdowns = $('.frontend-page .theme-dynamic-dropdown').length;
        
        var all_dropdowns = [];

        if (dropdowns > 0) {

            for (var d = 0; d < dropdowns; d++) {

                if ($('.frontend-page .theme-dynamic-dropdown').eq(d).attr('data-id')) {

                    all_dropdowns[$('.frontend-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')] = $('.frontend-page .theme-dynamic-dropdown').eq(d).attr('data-id');

                }

            }

        }

        // Get all text inputs
        var text_inputs = $('.frontend-page .theme-text-input-1').length;
        
        var all_textareas = [];

        if (text_inputs > 0) {

            for (var t = 0; t < text_inputs; t++) {

                all_textareas[$('.frontend-page .theme-text-input-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.frontend-page .theme-text-input-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.frontend-page .theme-field-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            for ( var c = 0; c < checkboxes; c++ ) {

                if ( $('.frontend-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    all_textareas[$('.frontend-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    all_textareas[$('.frontend-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }

        // Get all textareas
        var textareas = $('.frontend-page .theme-textarea-1').length;

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.frontend-page .theme-textarea-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.frontend-page .theme-textarea-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }
        
        // Prepare data to send
        var data = {
            action: 'save_frontend_settings',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'save_frontend_settings', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });

    /*
     * Detect auth logo remove
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.frontend-page [data-field="auth_logo"] .admin-field-remove-image', function () {
        
        // Prepare data to send
        var data = {
            action: 'frontend_remove_auth_logo'
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'frontend_remove_auth_logo_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display auth pages
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.frontend_settings_display_pages_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Pages list
            var pages = '';

            // List all pages
            for ( var p = 0; p < data.pages.length; p++ ) {

                // Add page to the list
                pages += '<li class="list-group-item">'
                    + '<a href="#" data-id="' + data.pages[p].content_id + '">'
                        + data.pages[p].content_title
                    + '</a>'
                + '</li>';

            }

            // Display all pages
            $('.frontend-page .theme-settings-options .list-group-item[data-field="' + data.drop_class + '"] .dropdown .theme-dropdown-items-list').html(pages);
            
        } else {

            // Prepare the no contents found message
            var message = '<li class="list-group-item">'
                + '<p>'
                    + data.message
                + '</p>'
            + '</li>';

            // Display no contents found message
            $('.frontend-page .theme-settings-options .list-group-item[data-field="' + data.drop_class + '"] .dropdown .theme-dropdown-items-list').html(message);
            
        }

    };
 
    /*
     * Display settings saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.save_frontend_settings = function ( status, data ) { 

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Hide the save button
            $('body .theme-save-changes').slideUp('slow');

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };

    /*
     * Display selected options
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.settings_all_options = function ( status, data ) { 

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Verify if pages by role exists
            if ( typeof data.response.pages_by_role !== 'undefined' ) {

                // List all pages
                for (let index = 0; index < data.response.pages_by_role.length; index++) {
                    
                    // Verify if class exists
                    if ( $('.frontend-page .theme-settings-options .list-group-item[data-field="' + data.response.pages_by_role[index].meta_value + '"]').length > 0 ) {

                        // Set text
                        $('.frontend-page .theme-settings-options .list-group-item[data-field="' + data.response.pages_by_role[index].meta_value + '"] .theme-dynamic-dropdown > span').text(data.response.pages_by_role[index].title);

                        // Set content's id
                        $('.frontend-page .theme-settings-options .list-group-item[data-field="' + data.response.pages_by_role[index].meta_value + '"] .theme-dynamic-dropdown').attr('data-id', data.response.pages_by_role[index].content_id);

                    }

                }

            }
            
        }
        
    };

    /*
     * Display the logo change for the auth section
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_change_auth_logo = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);   

            // Set the user image
            $('.frontend-page .theme-image-field > .card-header').html('<img src="' + data.file_url + '" alt="Auth Logo" width="32">');

            // Close modal
            $('#frontend-upload-auth-logo-modal .btn-close').click();
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }

    };

    /*
     * Display the remove logo response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.frontend_remove_auth_logo_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Reset the auth logo
            Main.reset_field_image('.frontend-page [data-field="auth_logo"]');
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }
        
    };
 
});