/*
 * Main Confirmation javascript file
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
     * Show change email input
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.main .change-email-area', function (e) {
        e.preventDefault();

        // Hide the button
        $(this).fadeOut('slow');

        setTimeout(function() {

            $('.main .change-email').fadeIn('slow');

        }, 300);
        
    });

    /*
     * Resend confirmation code
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $(document).on('click', '.main .resend-confirmation-code', function (e) {
        e.preventDefault();

        // Define data to send
        var data = {
            action: 'resend_confirmation_code'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/confirmation', 'GET', data, 'resend_confirmation_code');
        
    });
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display change email response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.change_email = function ( status, data ) {

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

            // Wait 3 seconds
            setTimeout(function() {

                // Hide notification
                $('.main .notification').remove();

                if ( status === 'success' ) {

                    // Empty email field
                    $('.form-confirmation .email').val('');

                }

            }, 3000);

        }

    };

    /*
     * Display resend confirmation code response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.8
     */
    Main.methods.resend_confirmation_code = function ( status, data ) {

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

            // Wait 3 seconds
            setTimeout(function() {

                // Hide notification
                $('.main .notification').remove();

            }, 3000);

        }

    };
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Change Email
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.8
     */
    $('.main .form-confirmation').submit(function (e) {
        e.preventDefault();

        // Get email
        var email = $('.form-confirmation .email').val();

        // Define data to send
        var data = {
            action: 'change_email',
            email: email
        };

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/confirmation', 'POST', data, 'change_email');

    });
    
    /*******************************
    DEPENDENCIES
    ********************************/

 
});