/*
 * Apps javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
   
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display checkbox option response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.app_option_checkbox = function ( status, data ) {

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
     * Display input save value response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.app_option_text = function ( status, data ) {

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
    ACTIONS
    ********************************/
   
    /*
     * Enable options
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.app .app-option-checkbox', function () {

        var data = {
            action: 'app_option_checkbox',
            id: $(this).attr('id')
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/options', 'GET', data, 'app_option_checkbox');
        
    });
    
    /*
     * Save input value
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.app .app-option-input', function () {

        var data = {
            action: 'app_option_text',
            id: $(this).attr('id'),
            value: $(this).val()
        };
        
        data[$('.app-options').attr('data-csrf')] = $('input[name="' + $('.app-options').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/options', 'POST', data, 'app_option_text');
        
    });    
 
});