/*
 * Main Signin javascript file
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
   $( '.form-content input[type="text"], .form-content input[type="password"], .form-content input[type="email"]' ).change(function() {

        // Set input
        var input = $('.form-content input[type="text"]')[0];            

        // Verify if email input exists
        if ( $('.form-content input[type="email"]').length > 0 ) {

            // Set input
            input = $('.form-content input[type="email"]')[0];

        }

        // Verify if email and password is valid
        if ( input.checkValidity() && $('.form-content input[type="password"]')[0].checkValidity() ) {
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
   $( '.form-content input[type="text"], .form-content input[type="password"], .form-content input[type="email"]' ).keyup(function() {

        // Set input
        var input = $('.form-content input[type="text"]')[0];            

        // Verify if email input exists
        if ( $('.form-content input[type="email"]').length > 0 ) {

            // Set input
            input = $('.form-content input[type="email"]')[0];

        }

        // Verify if email and password is valid
        if ( input.checkValidity() && $('.form-content input[type="password"]')[0].checkValidity() ) {
            $('.form-content button[type="submit"]').addClass('is-ready');
        } else {
            $('.form-content button[type="submit"]').removeClass('is-ready');
        }

    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display sign in response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.sign_in = function ( status, data ) {

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
                $('.form-content .alert').remove();

                // Verify if the response is success
                if ( status === 'success' ) {

                    // Redirect user
                    document.location.href = data.redirect;

                }

            }, 3000);

        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Sign In
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.form-content .form-signin').submit(function (e) {
        e.preventDefault();    

        // Default remember value
        var remember = 0;
        
        // Check if remember checkbox is checked
        if ( $('.form-signin .remember-me').is(':checked') ) {    
            remember = 1;
        }

        // Get email
        var email = $('.form-signin .email').val();

        // Get password
        var password = $('.form-signin .password').val();

        // Define data to send
        var data = {
            action: 'sign_in',
            email: email,
            password: password,
            remember: remember
        };

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/signin', 'POST', data, 'sign_in');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});