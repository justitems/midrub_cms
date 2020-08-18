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

    /*
     * Verify the the form is ready
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
    */
   $( '.form-content input[type="email"]' ).change(function() {

        // Verify if email is valid
        if ( $('.form-content input[type="email"]')[0].checkValidity() ) {
            $('.form-content button[type="submit"]').addClass('is-ready');
        } else {
            $('.form-content button[type="submit"]').removeClass('is-ready');
        }

    });

    /*
     * Verify the the form is ready
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.2
    */
   $( '.form-content input[type="email"]' ).keyup(function() {

    // Verify if email is valid
    if ( $('.form-content input[type="email"]')[0].checkValidity() ) {
        $('.form-content button[type="submit"]').addClass('is-ready');
    } else {
        $('.form-content button[type="submit"]').removeClass('is-ready');
    }

});
   
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

            // Verify if the response is success
            if ( status === 'success' ) {

                // Prepare message
                var message = '<div class="alert alert-primary" role="alert">'
                        + data.message
                    + '</div>';

            } else {

                // Prepare message
                var message = '<div class="alert alert-danger" role="alert">'
                        + data.message
                    + '</div>';

            }

            // Display message
            $('.form-content .alerts-status').html(message);

            // Wait 3 seconds
            setTimeout(function() {

                // Hide message
                $('.form-content .alerts').remove();

            }, 3000);

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
    $('.form-content .form-reset').submit(function (e) {
        e.preventDefault();

        // Get email
        var email = $('.form-reset .email').val();

        // Define data to send
        var data = {
            action: 'reset_password',
            email: email
        };

        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/reset', 'POST', data, 'reset');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});