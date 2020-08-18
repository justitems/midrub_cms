/*
 * Main javascript file
*/
jQuery(document).ready( function ($) {
    'use strict';
    
    /*
     * Get the website's url
     */
    var url = $('meta[name=url]').attr('content');
    
    /*******************************
    METHODS
    ********************************/

    /*
     * Saves a payment
     * 
     * @param string source_id contains the source's ID
     * 
     * @since   0.0.8.0
     */
    Main.save_payment = function (source_id) {
        
        // Create an object with form data
        var data = {
            action: 'process_payment',
            full_name: $('.payment-container .process-payment').find('.card-input-first-name').val(),
            card_number: $('.payment-container .process-payment').find('.card-input-number').val(),
            expiration: $('.payment-container .process-payment').find('.card-input-expiration').val(),
            cvv: $('.payment-container .process-payment').find('.card-input-security').val()
        };

        // Verify if the subscription's input exists
        if ( $('.payment-container #recurring-payments').length > 0 ) {

            // Verify if user wants a subscription
            if ( $('.payment-container #recurring-payments').is(':checked') ) {
                data['subscription'] = 1;
            }

        }

        // Verify if source's ID exists
        if ( source_id ) {

            // Set source's ID
            data['source_id'] = source_id;
            
        }

        // Set CSRF
        data[$('.payment-container .process-payment').attr('data-csrf')] = $('input[name="' + $('.payment-container .process-payment').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/payment-ajax/stripe', 'POST', data, 'process_payment');

        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    };
   
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

        } else if ( $(this).hasClass('card-input-number') ) {

            // Allow only numbers
            var only_numbers = $(this).val().replace(/[^0-9.]/g, '').replace(/(.{4})/g, '$1 ').substr(0, 20);
            
            // Set value
            $(this).val(only_numbers);

            // Set active class
            $('.card .card-number').addClass('active-field');

            // Set card number
            $('.card .card-number').text($(this).val());

        } else if ( $(this).hasClass('card-input-expiration') ) {

            // Allow only numbers
            var only_numbers = $(this).val().replace(/[^0-9.]/g, '').replace(/(.{2})/g, '$1/').substr(0, 5);
            
            // Set value
            $(this).val(only_numbers);

            // Set active class
            $('.card .card-expiry-date').addClass('active-field');

            // Set expiration date
            $('.card .card-expiry-date').text($(this).val());

        } else if ( $(this).hasClass('card-input-security') ) {

            if ( !$('.card').hasClass('show-behind') ) {

                // Add show behind class
                $('.card').addClass('show-behind');

            }

            // Set active class
            $('.card .card-secure').addClass('active-field');

            // Set secure code
            $('.card .card-secure').text($(this).val().substr(0, 3));

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

    /*
     * Create a source
     * 
     * @param object status contains the status
     * @param object response contains the response
     * 
     * @since   0.0.8.0
     */
    function stripeCardSourceResponseHandler(status, response) {

        // If is an error
        if (response.error) {

            // Prepare the success message
            var message = '<div class="notification-error">'
                + '<i class="icon-bell"></i>'
                + response.error.message
                + '</div>';

            // Display error notification
            $('.payment-container .notification').html(message);

        } else {

            // Get the source ID:
            var cardSource = response.id;

            // Get amount
            var amount = parseInt($('.payment-container .card-input-amount').val());

            // Get currency
            var currency = $('.payment-container .card-input-currency').val();

            // Create a 3D Secure Source
            Stripe.source.create({
                type: 'three_d_secure',
                amount: (amount * 100),
                currency: currency,
                three_d_secure: {
                    card: cardSource
                },
                redirect: {
                    return_url: url + 'loading.html'
                }
                
            }, stripe3DSecureSourceResponseHandler);

        }

    };    

    /*
     * Verify if the card supports 3d verification
     * 
     * @param object status contains the status
     * @param object response contains the response
     * 
     * @since   0.0.8.0
     */
    function stripe3DSecureSourceResponseHandler(status, response) {

        if (response.error) {

            // Prepare the error message
            var message = '<div class="notification-error">'
                            + '<i class="icon-bell"></i>'
                            + response.error.message
                        + '</div>';
            
            // Display error notification
            $('.payment-container .notification').html(message);
            return;

        }

        // check the 3DS source's status
        if (response.status == 'chargeable') {

            // Save payment
            Main.save_payment();
            return;

        } else if (response.status != 'pending') {

            // Save payment
            Main.save_payment();
            return;

        }

        Stripe.source.poll(
            response.id,
            response.client_secret,
            stripe3DSStatusChangedHandler
        );

        $.featherlight({
            iframe: response.redirect.url,
            iframeWidth: window.innerWidth,
            iframeHeight: window.innerHeight
        });

    }
        
    function stripe3DSStatusChangedHandler(status, source) {
console.log([status, source]);
        if (source.status == 'chargeable') {
            
            $.featherlight.current().close();

            // Save payment
            Main.save_payment(source.id);

            return;

        } else if (source.status == 'failed') {

            // Prepare the success message
            var message = '<div class="notification-error">'
                            + '<i class="icon-bell"></i>'
                            + words.secure_authentication_failed
                        + '</div>';
            
            // Display error notification
            $('.payment-container .notification').html(message);
            

        } else if (source.status != 'pending') {

            // Prepare the success message
            var message = '<div class="notification-error">'
                            + '<i class="icon-bell"></i>'
                            + unexpected_ecure_status + ': ' + source.status
                        + '</div>';
            
            // Display error notification
            $('.payment-container .notification').html(message);            

        }

    }
   
    /*******************************
    FORMS
    ********************************/

    /*
     * Process the Stripe Payment
     * 
     * @param object e with global object
     * 
     * @since   0.0.8.0
     */
    $(document).on('submit', '.payment-container .process-payment', function (e) {
        e.preventDefault();

        // Set the publishable key
        Stripe.setPublishableKey(words.public_key);

        // Create a source
        Stripe.source.create({
            type: 'card',
            card: {
                number: $(this).find('.card-input-number').val(),
                cvc: $(this).find('.card-input-security').val(),
                exp_month: 10,
                exp_year: 20
            }
        }, stripeCardSourceResponseHandler);

    });
    
    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    
});