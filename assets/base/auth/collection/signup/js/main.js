/*
 * Main Signup javascript file
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
    $( 'input[type="text"], input[type="password"], input[type="email"]' ).change(function() {

        // Verify if text, email and password is valid
        if ( $('.form-content input[type="text"]')[0].checkValidity() && $('.form-content input[type="email"]')[0].checkValidity() && $('.form-content input[type="password"]')[0].checkValidity() && $('.form-content #agre-terms').is(':checked') ) {
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
    $( '.form-content #agre-terms' ).click(function() {

        // Verify if text, email and password is valid
        if ( $('.form-content input[type="text"]')[0].checkValidity() && $('.form-content input[type="email"]')[0].checkValidity() && $('.form-content input[type="password"]')[0].checkValidity() && $('.form-content #agre-terms').is(':checked') ) {
            $('.form-content button[type="submit"]').addClass('is-ready');
        } else {
            $('.form-content button[type="submit"]').removeClass('is-ready');
        }

    }); 
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display new user creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.save_new_user = function ( status, data ) {

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

                if ( status === 'success' ) {

                    // Reset the form
                    $('.form-content .form-signup')[0].reset();

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
     * Register a new user
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.form-content .form-signup').submit(function (e) {
        e.preventDefault();

        // Get first name
        var first_name = $('.form-signup .first-name').val();

        // Get last name
        var last_name = $('.form-signup .last-name').val();

        // Get username
        var username = $('.form-signup .username').val();

        // Get email
        var email = $('.form-signup .email').val();

        // Get password
        var password = $('.form-signup .password').val();

        // Get plan
        var plan_id = $('.form-signup .selected-plan').val();

        // Define data to send
        var data = {
            action: 'save_new_user',
            first_name: first_name,
            last_name: last_name,
            username: username,
            email: email,
            password: password,
            plan_id: plan_id
        };

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/signup', 'POST', data, 'save_new_user');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});