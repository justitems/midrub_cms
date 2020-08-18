/*
 * Main Upgrade javascript file
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
     * Display if the coupon code is correct
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.0
     */
    Main.methods.verify_coupon = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

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
            
            // Set the plan price
            var plan_price = $( '.gateways-page .container-fluid' ).attr( 'data-price' );

            // Set discount
            var discount = plan_price/100*data.value;
            
            // Calculate discount
            var result = plan_price - discount;
            
            // Set new price
            $( '.plan-price' ).text( result.toFixed(2) );
            
            // Set the discount
            $( '.discount-price' ).text( '(' + data.words.discount + ' ' + data.value + '%)' );
            
            // Empty current coupon code field
            $( '.code' ).val( '' );
            
        } else {
            
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
    $('.main .verify-coupon-code').submit(function (e) {
        e.preventDefault();
        
        // Get coupon's code
        var code = $(this).find('.code').val();
        
        // Prepare data to send
        var data = {
            action: 'verify_coupon',
            code: code
        };
        
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'auth/ajax/upgrade', 'POST', data, 'verify_coupon');
        
    });

 
});