/*
 * Main javascript file
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
   
    /*******************************
    ACTIONS
    ********************************/
    
    /*
     * Save settings
     * 
     * @since   0.0.8.5
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all dropdowns
        var dropdowns = $('.settings-page .theme-dynamic-dropdown').length;
        
        var all_dropdowns = [];

        if (dropdowns > 0) {

            for (var d = 0; d < dropdowns; d++) {

                if ($('.settings-page .theme-dynamic-dropdown').eq(d).attr('data-id')) {

                    all_dropdowns[$('.settings-page .theme-dynamic-dropdown').eq(d).closest('.list-group-item').attr('data-field')] = $('.settings-page .theme-dynamic-dropdown').eq(d).attr('data-id');

                }

            }

        }

        // Get all text inputs
        var text_inputs = $('.settings-page .theme-text-input-1').length;
        
        var all_textareas = [];

        if (text_inputs > 0) {

            for (var t = 0; t < text_inputs; t++) {

                all_textareas[$('.settings-page .theme-text-input-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.settings-page .theme-text-input-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }

        // Get all checkboxes inputs
        var checkboxes = $('.settings-page .theme-field-checkbox').length;

        // Verify if checkboxes exists
        if (checkboxes > 0) {

            for ( var c = 0; c < checkboxes; c++ ) {

                if ( $('.settings-page .theme-field-checkbox').eq(c).is(':checked') ) {
                
                    all_textareas[$('.settings-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 1;
                    
                } else {
                    
                    all_textareas[$('.settings-page .theme-field-checkbox').eq(c).closest('.list-group-item').attr('data-field')] = 0;
                    
                }

            }

        }

        // Get all textareas
        var textareas = $('.settings-page .theme-textarea-1').length;

        // Verify if textareas exists
        if (textareas > 0) {

            // List all textareas
            for (var t = 0; t < textareas; t++) {

                // Append textarea's value
                all_textareas[$('.settings-page .theme-textarea-1').eq(t).closest('.list-group-item').attr('data-field')] = $('.settings-page .theme-textarea-1').eq(t).val().replace(/</g,"&lt;").replace(/>/g,"&gt;");

            }

        }
        
        // Prepare data
        var data = {
            action: 'settings_save_admin_settings',
            all_dropdowns: Object.entries(all_dropdowns),
            all_textareas: Object.entries(all_textareas)
        };
        
        // Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/settings', 'POST', data, 'settings_save_admin_settings_response', 'ajax_onprogress');
        
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
     * @since   0.0.7.6
     */
    Main.methods.settings_save_admin_settings_response = function ( status, data ) { 

        // Remove progress bar
        Main.remove_progress_bar();

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.show_alert('success', data.message, 1500, 2000);

            // Hide the save button
            $('body .theme-save-changes').slideUp('slow');
            
        } else {

            // Display alert
            Main.show_alert('error', data.message, 1500, 2000);
            
        }
        
    };
   
    /*******************************
    FORMS
    ********************************/
    

    
    /*******************************
    DEPENDENCIES
    ********************************/
    
});