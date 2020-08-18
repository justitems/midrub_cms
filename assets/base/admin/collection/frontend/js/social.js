/*
 * Social javascript file
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
     * Display save changes button
     * 
     * @since   0.0.7.8
     */
    $(document).on('keyup', 'body .auth-text-input', function () {

        // Display save button
        $('.auth-social-save-changes').fadeIn('slow');
        
    }); 
    
    /*
     * Display save changes button
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('change', 'body .auth-social-option-checkbox', function (e) {
        
        // Display save button
        $('.auth-social-save-changes').fadeIn('slow');
        
    }); 

    /*
     * Save menu's items
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */ 
    $( document ).on( 'click', '.auth-social-save-changes', function (e) {
        e.preventDefault();
        
        // Hide save button
        $('.auth-social-save-changes').fadeOut('slow');
        
        // Get all inputs
        var inputs = $('.frontend-page .auth-text-input').length;
        
        var all_inputs = [];
        
        for ( var i = 0; i < inputs; i++ ) {
            
            all_inputs[$('.frontend-page .auth-text-input').eq(i).attr('id')] = $('.frontend-page .auth-text-input').eq(i).val();
            
        }

        // Get all options
        var options = $('.frontend-page .auth-social-option-checkbox').length;
        
        var all_options = [];
        
        for ( var o = 0; o < options; o++ ) {
            
            if ( $('.frontend-page .auth-social-option-checkbox').eq(o).is(':checked') ) {
                
                all_options[$('.frontend-page .auth-social-option-checkbox').eq(o).attr('id')] = 1;
                
            } else {
                
                all_options[$('.frontend-page .auth-social-option-checkbox').eq(o).attr('id')] = 0;
                
            }
            
        }

        // Prepare data to send
        var data = {
            action: 'save_auth_social_data',
            all_inputs: Object.entries(all_inputs),
            all_options: Object.entries(all_options)
        };
        
        data[$('.save-settings').attr('data-csrf')] = $('input[name="' + $('.save-settings').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/frontend', 'POST', data, 'save_auth_social_data');

        // Show loading animation
        $('.page-loading').fadeIn('slow');
        
    });

    /*******************************
    RESPONSES
    ********************************/ 

    /*
     * Display social saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.save_auth_social_data = function ( status, data ) {

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