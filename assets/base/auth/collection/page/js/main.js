/*
 * Main Reset javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get website url
    var url =  $('meta[name=url]').attr('content');
    
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
     * Display reset password response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.reset = function ( status, data ) {

        // Verify if message exists
        if ( data.message ) {

            // Prepare notification
            var notification = '<div class="notification">'
                    + data.message
                + '</div>';

            // Display notification
            $('section').after(notification);

            // Add show class
            $('.main .notification').addClass('show');

            // Wait 5 seconds
            setTimeout(function() {

                // Hide notification
                $('.main .notification').remove();

            }, 5000);

        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Reset
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.main .form-reset').submit(function (e) {
        e.preventDefault();

        // Get email
        var email = $('.form-reset .email').val();

        // Define data to send
        var data = {
            action: 'reset_password',
            email: email
        };

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/reset', 'POST', data, 'reset');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});