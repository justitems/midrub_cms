<?php
/**
 * User Controller
 *
 * This file loads the Payment's view
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Paypal\Controllers;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the Storage app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'paypal_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_PAYPAL );
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function view() {

        // Set the page's title
        set_the_title($this->CI->lang->line('paypal'));

        // Set Boostrap's styles
        set_css_urls(array('stylesheet', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', 'text/css', 'all'));

        // Set PayPal's styles
        set_css_urls(array('stylesheet', base_url('assets/base/payments/collection/paypal/styles/css/styles.css?ver=' . MIDRUB_BASE_PAYMENTS_PAYPAL_VERSION), 'text/css', 'all'));

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

        // Set PayPal's JS LIBS
        set_js_urls(array('//www.paypalobjects.com/api/checkout.js'));
        set_js_urls(array('//js.braintreegateway.com/web/3.33.0/js/client.min.js'));
        set_js_urls(array('//js.braintreegateway.com/web/3.33.0/js/paypal-checkout.min.js'));    
        
        // Set PayPal JS
        set_js_urls(array(base_url('assets/base/payments/collection/paypal/js/main.js?ver=' . MIDRUB_BASE_PAYMENTS_PAYPAL_VERSION)));

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

                    // Verify the plan's ID exists
                    if ( isset($incomplete_transaction['options']['plan_id']) ) {

                        // First get the token
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.paypal.com/v1/oauth2/token',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_USERPWD => get_option('paypal_client_id') . ':' . get_option('paypal_client_secret'),
                        CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                        CURLOPT_HTTPHEADER => array(
                                'Accept: application/json',
                                'Accept-Language: en_US'
                            )
                        ));

                        $token_response = json_decode(curl_exec($curl), true);
                        curl_close($curl);

                        // Verify if access token exists
                        if ( isset($token_response['access_token']) ) {

                            // Product params for request
                            $product_params = array(
                                'name' => 'Plan ' . $incomplete_transaction['options']['plan_id'],
                                'type' => 'SERVICE'
                            );

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, 'https://api.paypal.com/v1/catalogs/products');
                            curl_setopt($curl, CURLOPT_POST, 1);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($product_params));
                            curl_setopt(
                                $curl,
                                CURLOPT_HTTPHEADER,
                                array(
                                    'Content-Type: application/json',
                                    'Authorization: Bearer ' . $token_response['access_token'],
                                    'PayPal-Request-Id: plan_' . $incomplete_transaction['options']['plan_id']
                                )
                            );
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            $product_response = json_decode( curl_exec ($curl), true);
                            curl_close ($curl);
                            
                            // Verify if the product was created
                            if ( isset($product_response['id']) ) {

                                // Plan params for request
                                $plan_params = array(
                                    'name' => 'Plan ' . $incomplete_transaction['options']['plan_id'],
                                    'product_id' => $product_response['id'],
                                    'billing_cycles' => array(                                       
                                        array(
                                            'pricing_scheme' => array(
                                                'fixed_price' => array(
                                                    'currency_code' => $incomplete_transaction['pay']['currency'],
                                                    'value' => $incomplete_transaction['pay']['amount']
                                                )
                                            ),
                                            'frequency' => array(
                                                'interval_unit' => 'MONTH',
                                                'interval_count' => 1
                                            ),
                                            'sequence' => 1,
                                            'total_cycles' => 1,
                                            'tenure_type' => 'TRIAL'
                                        ),                                        
                                        array(
                                            'pricing_scheme' => array(
                                                'fixed_price' => array(
                                                    'currency_code' => $incomplete_transaction['pay']['currency'],
                                                    'value' => $incomplete_transaction['pay']['amount']
                                                )
                                            ),
                                            'frequency' => array(
                                                'interval_unit' => 'MONTH',
                                                'interval_count' => 1
                                            ),
                                            'sequence' => 2,
                                            'total_cycles' => 999,
                                            'tenure_type' => 'REGULAR'
                                        )
                                    ),
                                    'payment_preferences' => array(
                                        "service_type" => "PREPAID",
                                        'auto_bill_outstanding' => true,
                                        'setup_fee_failure_action' => 'CONTINUE',
                                        'payment_failure_threshold' => 3
                                    ),
                                    'quantity_supported' => true

                                );

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, 'https://api.paypal.com/v1/billing/plans');
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($plan_params));
                                curl_setopt(
                                    $ch,
                                    CURLOPT_HTTPHEADER,
                                    array(
                                        'Content-Type: application/json',
                                        'Authorization: Bearer ' . $token_response['access_token'],
                                        'Prefer: return=representation'
                                    )
                                );
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $plan_response = json_decode( curl_exec ($ch), true);
                                curl_close ($ch);                    

                                // Verify if the plan was created
                                if ( isset($plan_response['id']) ) {

                                    // Set Plan Id
                                    $params['plan_id'] = $plan_response['id'];

                                    // Set recurring_payments
                                    $params['recurring_payments'] = true;

                                }

                            }

                        }

                    }

                }

            }

            try {

                // Set views params
                set_payment_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_PAYMENTS_PAYPAL . 'views',
                        'main',
                        $params,
                        true
                    )

                );

            } catch (Exception $ex) {

                // Set views params
                set_payment_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_PAYMENTS_PAYPAL . 'views',
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
                    MIDRUB_BASE_PAYMENTS_PAYPAL . 'views',
                    'expired',
                    array(),
                    true
                )

            );

        }
        
    }

}
