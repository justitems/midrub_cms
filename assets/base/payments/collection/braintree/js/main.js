/*
 * Main javascript file
*/
jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url =  $('meta[name=url]').attr('content');

    /*
     * Components
     */
    var components = {
        client: null,
        threeDSecure: null,
        hostedFields: null,
    };

    /*
     * Saves a payment
     * 
     * @param object nonce contains a nonce object
     * 
     * @since   0.0.8.0
     */
    Main.save_payment = function (nonce) {
        
        // Create an object with form data
        var data = {
            action: 'process_payment'
        };

        // Verify if nonce exists
        if ( nonce ) {

            // Set nonce
            data['nonce'] = nonce;
            
        }

        // Verify if the subscription's input exists
        if ( $('.payment-container #recurring-payments').length > 0 ) {

            // Verify if user wants a subscription
            if ( $('.payment-container #recurring-payments').is(':checked') ) {
                data['subscription'] = 1;
            }

        }

        // Set CSRF
        data[$('.payment-container .process-payment').attr('data-csrf')] = $('input[name="' + $('.payment-container .process-payment').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/payment-ajax/braintree', 'POST', data, 'process_payment');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    };
    
    /*******************************
    METHODS
    ********************************/  

    /*
     * Show iframe
     * 
     * @param object err contains the error object
     * @param html iframe contains the iframe
     * 
     * @since   0.0.8.0
     */ 
    Main.addFrame = function(err, iframe) {

        // Empty the modal body
        $('#load-authorization .modal-body').empty();

        // Add Iframe
        $('#load-authorization .modal-body').append(iframe);

        // Show Authorization modal
        $('#load-authorization').modal('show');

    }

    /*
     * Close iframe
     * 
     * @since   0.0.8.0
     */ 
    Main.removeFrame = function () {

        // Hide Authorization modal
        $('#load-authorization').modal('hide');        

    }
   
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Detect media pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */ 
    $( document ).on( 'keyup', '.payment-container input[type="text"]', function (e) {
        e.preventDefault();

        // Remove active-fields class
        $('.card .card-owner, .card .card-number, .card .card-expiry-date, .card .card-secure').removeClass('active-field');

        if ( $('.card').hasClass('show-behind') && !$(this).hasClass('card-input-security') ) {

            // Remove show behind class
            $('.card').removeClass('show-behind');

        }

        // Process data based on input's class
        if ( $(this).hasClass('card-input-first-name') ) {

            // Set active class
            $('.card .card-owner').addClass('active-field');

            // Set name
            $('.card .card-owner').text($(this).val());

        }
        
    });
      
   
   
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display the process response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.8.0
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

    braintree.client.create({
        authorization: token
    }, onClientCreate);

    function onClientCreate(err, client) {

        if (err) {
            console.log(err);
            return;
        }

        components.client = client;

        braintree.hostedFields.create({
            client: client,
            fields: {
                number: {
                    selector: '#number',
                    placeholder: '4000 0000 0000 0002'
                },
                cvv: {
                    selector: '#cvv',
                    placeholder: '123'
                },
                expirationDate: {
                    selector: '#date',
                    placeholder: '01 / 20'
                }
            }

        }, onComponent('hostedFields'));      

        braintree.threeDSecure.create({
            client: client
        }, onComponent('threeDSecure'));

    }

    function onComponent(name) {

        return function (err, component) {

            if (err) {
                alert(err.message);
                return;
            }

            components[name] = component;

            if (components.threeDSecure && components.hostedFields) {
                
                components.hostedFields.on('focus', function (event) {

                    // Remove active-fields class
                    $('.card .card-owner, .card .card-number, .card .card-expiry-date, .card .card-secure').removeClass('active-field');

                    if ( $('.card').hasClass('show-behind') && !$(this).hasClass('card-input-security') ) {

                        // Remove show behind class
                        $('.card').removeClass('show-behind');
            
                    }

                    // Display field on preview
                    if ( event.emittedBy === 'number' ) {
            
                        // Set active class
                        $('.card .card-number').addClass('active-field');
            
                    } else if ( event.emittedBy === 'expirationDate' ) {
            
                        // Set active class
                        $('.card .card-expiry-date').addClass('active-field');
            
                    } else if ( event.emittedBy === 'cvv' ) {
                
                        if ( !$('.card').hasClass('show-behind') ) {
            
                            // Add show behind class
                            $('.card').addClass('show-behind');
            
                        }
            
                        // Set active class
                        $('.card .card-secure').addClass('active-field');
            
                    }

                });

                components.hostedFields.on('blur', function (event) {

                    // Remove active-fields class
                    $('.card .card-owner, .card .card-number, .card .card-expiry-date, .card .card-secure').removeClass('active-field');

                    if ( $('.card').hasClass('show-behind') && !$(this).hasClass('card-input-security') ) {

                        // Remove show behind class
                        $('.card').removeClass('show-behind');
            
                    }

                    // Display field on preview
                    if ( event.emittedBy === 'number' ) {
            
                        // Set active class
                        $('.card .card-number').addClass('active-field');
            
                    } else if ( event.emittedBy === 'expirationDate' ) {
            
                        // Set active class
                        $('.card .card-expiry-date').addClass('active-field');
            
                    } else if ( event.emittedBy === 'cvv' ) {
                
                        if ( !$('.card').hasClass('show-behind') ) {
            
                            // Add show behind class
                            $('.card').addClass('show-behind');
            
                        }
            
                        // Set active class
                        $('.card .card-secure').addClass('active-field');
            
                    }

                });                

            }

        }

    }
   
    /*******************************
    FORMS
    ********************************/

    /*
     * Process the Braintree Payment
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $(document).on('submit', '.payment-container .process-payment', function (e) {
        e.preventDefault();

        components.hostedFields.tokenize(function (err, payload) {

            // Verify if error exists
            if (err) {

                // Prepare the success message
                var message = '<div class="notification-error">'
                                + '<i class="icon-bell"></i>'
                                + err.message
                            + '</div>';
                
                // Display error notification
                $('.payment-container .notification').html(message);

                return;
            }

            components.threeDSecure.verifyCard({
                amount: $('.card-input-amount').val(),
                nonce: payload.nonce,
                addFrame: Main.addFrame,
                removeFrame: Main.removeFrame
            }, function (err, verification) {

                if (err) {

                    // Prepare the success message
                    var message = '<div class="notification-error">'
                                    + '<i class="icon-bell"></i>'
                                    + err.message
                                + '</div>';
                    
                    // Display error notification
                    $('.payment-container .notification').html(message);
                    return;
                    
                }

                // Save payment
                Main.save_payment(verification.nonce);

            });

        });

    });
    
    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    
});