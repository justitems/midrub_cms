/*
 * Settings JavaScript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');

    /*******************************
    ACTIONS
    ********************************/
    
    /*
     * Save settings
     * 
     * @since   0.0.7.9
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all textareas
        var textareas = $('.user-page .theme-textarea-1').length;
        
        // All textareas container
        var all_textareas = [];

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.user-page .theme-textarea-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.user-page .theme-textarea-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.user-page .theme-field-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            // List all checkboxes
            for ( var c = 0; c < checkboxes; c++ ) {

                if ( $('.user-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    all_textareas[$('.user-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    all_textareas[$('.user-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }
        
        // Prepare data to send
        var data = {
            action: 'user_save_user_settings',
            all_textareas: Object.entries(all_textareas)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_save_user_settings_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    }); 

    /*
     * Detect user logo remove
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', '.user-page [data-field="user_logo"] .admin-field-remove-image', function () {
        
        // Prepare data to send
        var data = {
            action: 'user_remove_logo'
        };

		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');     
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/user', 'POST', data, 'user_remove_logo_response', 'ajax_onprogress');

        // Set progress bar
        Main.set_progress_bar();
        
    });
   
    /*******************************
    RESPONSES
    ********************************/
 
    /*
     * Display settings saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.9
     */
    Main.methods.user_save_user_settings_response = function ( status, data ) { 

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
     * Display the logo change for the user's panel
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.5
     */
    Main.methods.user_change_user_logo = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);   

            // Set the user image
            $('.user-page .theme-image-field > .card-header').html('<img src="' + data.file_url + '" alt="User Logo" width="32">');

            // Close modal
            $('#user-upload-logo-modal .btn-close').click();
            
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
    Main.methods.user_remove_logo_response = function ( status, data ) {

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Reset the user logo
            Main.reset_field_image('.user-page [data-field="user_logo"]');
            
        } else {
            
            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);

        }
        
    };
 
});