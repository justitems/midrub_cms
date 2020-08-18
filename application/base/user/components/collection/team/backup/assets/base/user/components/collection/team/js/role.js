/*
 * New Role javascript file
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
     * Detect when permission is enabled/disabled
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */     
    $(document).on('click', '.role .permission-checkbox', function (e) {

        // Get role's id
        var role_id = $(this).attr('data-role');

        // Get permission
        var permission = $(this).attr('data-permission');

        // Create an object with form data
        var data = {
            action: 'save_role_permission',
            role_id: role_id,
            permission: permission
        };
        
        // Set CSRF
        data[$('.role .update-role').attr('data-csrf')] = $('input[name="' + $('.role .update-role').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'save_role_permission');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');

    });

    /*******************************
    RESPONSES
    ********************************/

    /*
     * Display permission saving response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.save_role_permission = function ( status, data ) {

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
 
});