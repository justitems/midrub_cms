/*
 * Invoices Settings javascript file
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
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', 'body .theme-save-changes .theme-save-changes-btn', function () {
        
        // Get all options
        var options = $('.admin-page .theme-field-checkbox').length;
        
        // All options array
        var all_options = [];
        
        // List all options
        for ( var o = 0; o < options; o++ ) {
            
            // Verify if the checkbox is checked
            if ( $('.admin-page .theme-field-checkbox').eq(o).is(':checked') ) {
                
                // Set option value
                all_options[$('.admin-page .theme-field-checkbox').eq(o).closest('.list-group-item').attr('data-field')] = 1;
                
            } else {

                // Set option value
                all_options[$('.admin-page .theme-field-checkbox').eq(o).closest('.list-group-item').attr('data-field')] = 0;
                
            }
            
        }
        
        // Prepare data to send
        var data = {
            action: 'save_invoice_settings',
            title: $('.admin-page .theme-settings-options .list-group-item[data-field="template_title"] .theme-text-input-1').val(),
            taxes: $('.admin-page .theme-settings-options .list-group-item[data-field="template_taxes"] .theme-text-input-1').val(),
            body: $('.admin-page .theme-settings-options .list-group-item[data-field="template_body"] .theme-textarea-1').val(),
            all_options: Object.entries(all_options)
        };
        
		// Set CSRF
        data[$('.main').attr('data-csrf')] = $('.main').attr('data-csrf-value');
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'save_invoice_settings', 'ajax_onprogress');

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
     * @since   0.0.8.1
     */
    Main.methods.save_invoice_settings = function ( status, data ) { 

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
 
});