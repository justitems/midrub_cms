/*
 * Plans javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
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
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
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
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
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
        Main.ajax_call(url + 'user/component-ajax/plans', 'POST', data, 'verify_coupon');
        
    });
    
});