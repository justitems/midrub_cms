/*
 * Main javascript file
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
     * Display the process response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.1
     */
    Main.methods.process_payment = function (status, data) {

        // Verify if the success response exists
        if (status === 'success') {

            // Prepare the success message
            var message = '<div class="notification-success">'
                            + '<i class="icon-bell"></i>'
                            + data.message
                        + '</div>';

            // Display success notification
            $('.payment-container .notification').html(message);

            // Verify if redirect exists
            if ( typeof data.success_redirect !== 'undefined' ) {
                
                // Set redirect
                setTimeout(function() {
                    document.location.href = data.success_redirect;
                }, 3000);

            }

        } else {

            // Prepare the success message
            var message = '<div class="notification-error">'
                            + '<i class="icon-bell"></i>'
                            + data.message
                        + '</div>';
            
            // Display error notification
            $('.payment-container .notification').html(message);

            // Verify if redirect exists
            if ( typeof data.error_redirect !== 'undefined' ) {
                
                // Set redirect
                setTimeout(function() {
                    document.location.href = data.error_redirect;
                }, 3000);

            }            

        }
        
    };
   
    /*******************************
    FORMS
    ********************************/
    
    /*******************************
    DEPENDENCIES
    ********************************/

    // Verify if plan exists
    if ( $('.container .input-plan').length > 0 ) {

        paypal_sdk.Buttons({

            createSubscription: function(data, actions) {
            
                return actions.subscription.create({
                
                    'plan_id': $('.container .input-plan').val()
                
                });
            
            },
            
            
            onApprove: function(data, actions) {
            
                // Create an object with form data
                var params = {
                    action: 'process_payment',
                    data: data,
                    plan: $('.container .input-plan').val()
                };

                // Set CSRF
                params[$('.payment-container .process-payment').attr('data-csrf')] = $('input[name="' + $('.payment-container .process-payment').attr('data-csrf') + '"]').val();

                // Make ajax call
                Main.ajax_call(url + 'user/payment-ajax/paypal', 'POST', params, 'process_payment');

                // Display loading animation
                $('.page-loading').fadeIn('slow');
            
            }
        
        
        }).render('#paypal-button-container');

    } else {

        paypal.Button.render({

            env: 'production',
            style: {
                layout: 'vertical',
                size:   'medium',
                shape:  'rect',
                color:  'gold'
            },
            funding: {
                allowed: [
                    paypal.FUNDING.CARD,
                    paypal.FUNDING.CREDIT
                ],
                disallowed: []
            },
            client: {
                production: $('.container .input-client-id').val()
            },
            
            payment: function (data, actions) {
    
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: {
                                    total: $('.container .input-amount').val(),
                                    currency: $('.container .input-currency').val()
                                }
                            }
                        ]
                    }
                });
    
            },
            
            onAuthorize: function (data, actions) {
                return actions.payment.execute()
                .then(function () {
                    
                    // Create an object with form data
                    var params = {
                        action: 'process_payment',
                        data: data
                    };
    
                    // Set CSRF
                    params[$('.payment-container .process-payment').attr('data-csrf')] = $('input[name="' + $('.payment-container .process-payment').attr('data-csrf') + '"]').val();
    
                    // Make ajax call
                    Main.ajax_call(url + 'user/payment-ajax/paypal', 'POST', params, 'process_payment');
    
                    // Display loading animation
                    $('.page-loading').fadeIn('slow');
    
                });
    
            }
            
        }, '#paypal-button-container');

    }

});