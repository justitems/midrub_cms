<?php
/**
 * User Controller
 *
 * This file loads the Payment's view
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Braintree\Controllers;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Braintree class
require_once MIDRUB_BASE_PAYMENTS_BRAINTREE . 'vendor/braintree/braintree_php/lib/Braintree.php';

/*
 * User class loads the Storage app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'braintree_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_BRAINTREE );
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function view() {

        // Set the page's title
        set_the_title($this->CI->lang->line('braintree'));

        // Set Boostrap's styles
        set_css_urls(array('stylesheet', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', 'text/css', 'all'));

        // Set Braintree's styles
        set_css_urls(array('stylesheet', base_url('assets/base/payments/collection/braintree/styles/css/styles.css?ver=' . MIDRUB_BASE_PAYMENTS_BRAINTREE_VERSION), 'text/css', 'all'));

        // Simple Line Icons
        set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css', 'text/css', 'all'));

        // Set jQuery JS
        set_js_urls(array(base_url('assets/js/jquery.min.js')));
        
        // Set Popper JS
        set_js_urls(array('//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'));
        
        // Set Bootstrap JS
        set_js_urls(array('//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'));   

        // Set Main Midrub JS
        set_js_urls(array(base_url('assets/js/main.js')));        

        // Set Braintree's JS LIBS
        set_js_urls(array('//js.braintreegateway.com/web/3.29.0/js/client.min.js'));
        set_js_urls(array('//js.braintreegateway.com/web/3.29.0/js/three-d-secure.js'));
        set_js_urls(array('//js.braintreegateway.com/web/3.29.0/js/hosted-fields.js'));    
        
        // Set Braintree JS
        set_js_urls(array(base_url('assets/base/payments/collection/braintree/js/main.js?ver=' . MIDRUB_BASE_PAYMENTS_BRAINTREE_VERSION)));

        // Get the incomplete transaction
        $incomplete_transaction = the_incomplete_transaction();

        // Verify if incomplete transaction exists
        if ( $incomplete_transaction ) {

            // Params array
            $params = array(
                'transaction_id' => $incomplete_transaction['transaction_id'],
                'amount' => $incomplete_transaction['pay']['amount'],
                'currency' => $incomplete_transaction['pay']['currency']
            );

            // Verify if isset currency sign
            if ( isset($incomplete_transaction['pay']['sign']) ) {

                // Set currency sign
                $params['sign'] = $incomplete_transaction['pay']['sign'];

            }

            // Verify if isset recurring_payments
            if ( isset($incomplete_transaction['options']['recurring_payments']) ) {

                if ( $incomplete_transaction['options']['recurring_payments'] === 'on' ) {

                    // Set recurring_payments
                    $params['recurring_payments'] = true;

                }

            }

            try {

                // Set the Braintree configuration
                $config = new \Braintree_Configuration([
                    'environment' => 'production',
                    'merchantId' => get_option('braintree_merchant_id'),
                    'publicKey' => get_option('braintree_public_key'),
                    'privateKey' => get_option('braintree_private_key')
                ]);

                // Get the gateway
                $gateway = new \Braintree\Gateway($config);

                // Get token
                $clientToken = $gateway->clientToken()->generate(array(
                    'merchantAccountId' => get_option('braintree_merchant_account_id')
                ));

                // Verify if token exists
                if ( $clientToken ) {

                    // Set token
                    $params['token'] = $clientToken;

                }

                // Set views params
                set_payment_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_PAYMENTS_BRAINTREE . 'views',
                        'main',
                        $params,
                        true
                    )

                );

            } catch (Exception $ex) {

                // Set views params
                set_payment_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_PAYMENTS_BRAINTREE . 'views',
                        'error',
                        array(
                            'error' => $ex->getMessage()
                        ),
                        true
                    )

                );

            }

        } else {

            // Set views params
            set_payment_view(
                $this->CI->load->ext_view(
                    MIDRUB_BASE_PAYMENTS_BRAINTREE . 'views',
                    'expired',
                    array(),
                    true
                )

            );

        }
        
    }

}
