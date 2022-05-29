<?php
/**
 * User Controller
 *
 * This file loads the Payment's view
 *
 * @author Scrisoft
 * @package Cms
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Payments\Collection\Stripe\Controllers;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Used Classes
use Slim\Http\Request;
use Slim\Http\Response;
use Stripe\Stripe;

/*
 * User class loads the Storage app loader
 * 
 * @author Scrisoft
 * @package Cms
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
        $this->CI->lang->load( 'stripe_user', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_STRIPE );

        // Request the Stripe's vendor
        require_once CMS_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';

        // Verify if transaction exists
        if ( $this->CI->input->get('transaction') ) {

            // Get the transaction
            $transaction = $this->CI->session->userdata('code_' . $this->CI->input->get('transaction'));

            // Verify if incomplete transaction exists
            if ( !$transaction ) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('transaction_expired_go_back')
                );

                // Verify if transaction has redirect
                if (isset($transaction['options']['error_redirect'])) {
                    $data['error_redirect'] = $transaction['options']['error_redirect'];
                }

                // Display the error response
                echo json_encode($data); 
                exit();

            }

            // We need to delete the previous subscription
            $get_subscriptions = $this->CI->base_model->the_data_where('subscriptions', '*', array(
                'user_id' => $this->CI->user_id,
                'created <' => (time() < 60)
            ));

            // Verify if old subscribtions exists
            if ( $get_subscriptions ) {

                // List all subscriptions
                foreach ( $get_subscriptions as $get_subscription ) {
                    
                    // Create an array
                    $array = array(
                        'CmsBase',
                        'Payments',
                        'Collection',
                        ucfirst($get_subscription['gateway']),
                        'Main'
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Delete subscribtion
                    (new $cl())->delete_subscription($get_subscription);

                }

                // Delete the subscription from the database
                $this->CI->base_model->delete('subscriptions', array(
                    'user_id' => $this->CI->user_id,
                ) );

            }

            // Save transaction success
            save_complete_transaction(
                $transaction['transaction_id'],
                $this->CI->user_id,
                array(
                    'net_id' => $transaction['options']['price'],
                    'gateway' => 'stripe',
                    'status' => 1
                )
            );

            // Redirect
            redirect($transaction['options']['success_redirect']);

        }
        
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
        set_the_title($this->CI->lang->line('stripe'));

        // Set Boostrap's styles
        set_css_urls(array('stylesheet', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', 'text/css', 'all'));

        // Set Stripe's styles
        set_css_urls(array('stylesheet', base_url('assets/base/payments/collection/stripe/styles/css/styles.css'), 'text/css', 'all'));

        // Simple Line Icons
        set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css', 'text/css', 'all'));

        set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.0/featherlight.min.css', 'text/css', 'all'));

        // Set jQuery JS
        set_js_urls(array(base_url('assets/js/jquery.min.js')));
        
        // Set Popper JS
        set_js_urls(array('//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'));
        
        // Set Bootstrap JS
        set_js_urls(array('//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'));   

        // Set Main Cms JS
        set_js_urls(array(base_url('assets/js/main.js')));

        // Set Stripe JS
        set_js_urls(array('//js.stripe.com/v2/'));    
        
        // Set Stripe Checkout JS
        set_js_urls(array('//cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.0/featherlight.min.js'));            
        
        // Set Stripe App JS
        set_js_urls(array(base_url('assets/base/payments/collection/stripe/js/main.js?ver=' . CMS_BASE_PAYMENTS_STRIPE_VERSION)));

        // Get the incomplete transaction
        $incomplete_transaction = the_incomplete_transaction();
        
        // Verify if incomplete transaction exists
        if ( $incomplete_transaction ) {

            // Set the configuration's parameters
            $stripe = new \Stripe\StripeClient(md_the_option('stripe_secret_key'));

            // Verify if plan's ID exists
            if ( !empty($incomplete_transaction['options']['plan_id']) ) {

                // Use the base model for a simply sql query
                $the_transaction_plan = $this->CI->base_model->the_data_where(
                    'plans',
                    '*',
                    array(
                        'plan_id' => $incomplete_transaction['options']['plan_id']
                    )
                );

                // Verify if the plan was found
                if ( $the_transaction_plan ) {

                    // Create a product
                    $product = $stripe->products->create(array(
                        'name' => $the_transaction_plan[0]['plan_name']
                    ));

                    // Verify if the product was created
                    if ( !empty($product->id) ) {

                        // Set plan's period
                        $period = ($the_transaction_plan[0]['period'] < 32)?array('interval' => 'month'):array('interval' => 'year');

                        // Create the price
                        $price = $stripe->prices->create(array(
                                'unit_amount' => str_replace(array('.', ','), array(), $incomplete_transaction['pay']['amount']),
                                'currency' => $incomplete_transaction['pay']['currency'],
                                'recurring' => $period,
                                'product' => $product->id,                            
                            )
                        );

                        // Verify if price exists
                        if ( !empty($price->id) ) {

                            // Set code
                            $code = uniqid();

                            // Save the price id
                            $save_price = $this->CI->base_model->update('transactions',
                                array(
                                    'transaction_id' => $incomplete_transaction['transaction_id']
                                ),
                                array(
                                    'net_id' => $price->id,
                                    'gateway' => 'stripe'
                                )
                            );

                            // Verify if the price was saved
                            if ( $save_price ) {

                                // Set the price
                                $incomplete_transaction['options']['price'] = $price->id;

                                // Register a session
                                $this->CI->session->set_userdata('code_' . $code, $incomplete_transaction);

                                // Create a session
                                $session = $stripe->checkout->sessions->create(array(
                                    'success_url' => site_url('payments/stripe/pay') . '?transaction=' . $code,
                                    'cancel_url' => $incomplete_transaction['options']['error_redirect'],
                                    'line_items' => array(
                                        array(
                                            'price' => $price->id,
                                            'quantity' => 1   
                                        )                               
                                    ),
                                    'mode' => 'subscription'
                                ));

                                // Verify if the session was created
                                if ( !empty($session->url) ) {

                                    // Redirect
                                    redirect($session->url);

                                } else {

                                    // Set views params
                                    set_payment_view(
                                        $this->CI->load->ext_view(
                                            CMS_BASE_PAYMENTS_STRIPE . 'views',
                                            'main',
                                            array(
                                                'message' => $this->CI->lang->line('stripe_session_not_created')
                                            ),
                                            true
                                        )

                                    );                                

                                }

                            } else {

                                // Set views params
                                set_payment_view(
                                    $this->CI->load->ext_view(
                                        CMS_BASE_PAYMENTS_STRIPE . 'views',
                                        'main',
                                        array(
                                            'message' => $this->CI->lang->line('stripe_session_not_created')
                                        ),
                                        true
                                    )

                                );  

                            }

                        } else {

                            // Set views params
                            set_payment_view(
                                $this->CI->load->ext_view(
                                    CMS_BASE_PAYMENTS_STRIPE . 'views',
                                    'main',
                                    array(
                                        'message' => $this->CI->lang->line('stripe_price_not_created')
                                    ),
                                    true
                                )

                            );

                        }

                    } else {

                        // Set views params
                        set_payment_view(
                            $this->CI->load->ext_view(
                                CMS_BASE_PAYMENTS_STRIPE . 'views',
                                'main',
                                array(
                                    'message' => $this->CI->lang->line('stripe_product_not_created')
                                ),
                                true
                            )

                        );

                    }

                } else {

                    // Set views params
                    set_payment_view(
                        $this->CI->load->ext_view(
                            CMS_BASE_PAYMENTS_STRIPE . 'views',
                            'main',
                            array(
                                'message' => $this->CI->lang->line('stripe_plan_not_found')
                            ),
                            true
                        )

                    );

                }

            } else {

                // Set views params
                set_payment_view(
                    $this->CI->load->ext_view(
                        CMS_BASE_PAYMENTS_STRIPE . 'views',
                        'main',
                        array(
                            'message' => $this->CI->lang->line('stripe_plan_not_found')
                        ),
                        true
                    )

                );

            }

        } else {

            // Set views params
            set_payment_view(
                $this->CI->load->ext_view(
                    CMS_BASE_PAYMENTS_STRIPE . 'views',
                    'expired',
                    array(),
                    true
                )

            );

        }
        
    }

}

/* End of file user.php */