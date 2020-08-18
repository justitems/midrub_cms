/*
 * Invoices Settings javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/

    /*******************************
    ACTIONS
    ********************************/

    /*
     * Display save button
     * 
     * @since   0.0.8.1
     */
    $(document).on('change', '.admin-page .admin-textarea-input, .admin-page .admin-text-input', function (e) {
        e.preventDefault();

        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    });

    /*
     * Display save changes button
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.1
     */
    $(document).on('change', '.admin-page .admin-option-checkbox', function (e) {
        
        // Display save button
        $('.settings-save-changes').fadeIn('slow');
        
    }); 

    /*
     * Save settings
     * 
     * @since   0.0.8.1
     */ 
    $( document ).on( 'click', '.settings-save-changes', function () {
        
        // Hide save button
        $('.settings-save-changes').fadeOut('slow');
        
        // Get all options
        var options = $('.admin-page .admin-option-checkbox').length;
        
        // All options array
        var all_options = [];
        
        // List all options
        for ( var o = 0; o < options; o++ ) {
            
            // Verify if the checkbox is checked
            if ( $('.admin-page .admin-option-checkbox').eq(o).is(':checked') ) {
                
                // Set option value
                all_options[$('.admin-page .admin-option-checkbox').eq(o).attr('id')] = 1;
                
            } else {

                // Set option value
                all_options[$('.admin-page .admin-option-checkbox').eq(o).attr('id')] = 0;
                
            }
            
        }
        
        // Prepare data to send
        var data = {
            action: 'save_invoice_settings',
            title: $('.admin-page #template_title').val(),
            taxes: $('.admin-page #template_taxes').val(),
            body: $('.admin-page .admin-textarea-input').val(),
            all_options: Object.entries(all_options)
        };
        
        // Set CSRF
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/admin', 'POST', data, 'save_invoice_settings');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
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

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {

            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };


    /*******************************
    FORMS
    ********************************/
   

    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Hide loading animation
    $('.page-loading').fadeOut('slow');
 
});