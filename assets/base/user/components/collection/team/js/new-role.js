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

    /*******************************
    RESPONSES
    ********************************/
    
    /*
     * Display role creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
     */
    Main.methods.team_create_role = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Reset form
            $('.create-role .role-name').val('');

            // Redirect after 3 seconds
            setTimeout(function() {

                // Redirect to the role's page
                document.location.href = url + 'user/team?p=roles&role=' + data.role_id;

            }, 3000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);            
            
        }

    };
   
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new team's role
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.2
     */
    $('.create-role .new-role').submit(function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'team_create_role',
            role: $('.create-role .role-name').val()
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/component-ajax/team', 'POST', data, 'team_create_role');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
 
});