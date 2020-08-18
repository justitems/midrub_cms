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
    $( '.form-content input[type="password"]' ).change(function() {

        // Verify if password is valid
        if ( $('.form-content #new-password')[0].checkValidity() && $('.form-content #repeat-password')[0].checkValidity() ) {
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
    $( '.form-content input[type="password"]' ).keyup(function() {

        // Verify if password is valid
        if ( $('.form-content #new-password')[0].checkValidity() && $('.form-content #repeat-password')[0].checkValidity() ) {
            $('.form-content button[type="submit"]').addClass('is-ready');
        } else {
            $('.form-content button[type="submit"]').removeClass('is-ready');
        }

    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display change password response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.change_password = function ( status, data ) {

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
     * Change password
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.form-content .form-change-password').submit(function (e) {
        e.preventDefault();

        // Get new password
        var new_password = $('.form-content .form-change-password .new-password').val();

        // Get repeat password
        var repeat_password = $('.form-content .form-change-password .repeat-password').val();

        // Get reset code
        var reset_code = $('.form-content .form-change-password .reset-code').val();

        // Get user_id
        var user_id = $('.form-content .form-change-password .user-id').val();

        // Define data to send
        var data = {
            action: 'change_password',
            new_password: new_password,
            repeat_password: repeat_password,
            reset_code: reset_code,
            user_id: user_id
        };

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/change-password', 'POST', data, 'change_password');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});