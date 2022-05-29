<?php
/**
 * Cms Payments Stripe
 *
 * This file loads the Stripe's gateway
 *
 * @author Scrisoft
 * @package Cms
 * @since 0.0.8.0
 */

// Define the namespace
namespace CmsBase\Payments\Collection\Stripe;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_PAYMENTS_STRIPE') OR define('CMS_BASE_PAYMENTS_STRIPE', CMS_BASE_PAYMENTS . 'collection/stripe/');
defined('CMS_BASE_PAYMENTS_STRIPE_VERSION') OR define('CMS_BASE_PAYMENTS_STRIPE_VERSION', '0.0.5');

// Define the namespaces to use
use CmsBase\Payments\Interfaces as CmsBasePaymentsInterfaces;
use CmsBase\Payments\Collection\Stripe\Controllers as CmsBasePaymentsCollectionStripeControllers;


/*
 * Main class loads the Stripe's gateway
 * 
 * @author Scrisoft
 * @package Cms
 * @since 0.0.8.0
 */
class Main implements CmsBasePaymentsInterfaces\Payments {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method check_availability checks if the gateway is available
     *
     * @return boolean true or false
     */
    public function check_availability() {

    }
    
    /**
     * The public method connect redirects user to the gateway's page
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function connect() {

    }

    /**
     * The public method save saves saves returned user's data
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function save() {

    }

    /**
     * The public method pay makes a payment
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function pay() {

        // Verify if the gateway is enabled
        if ( md_the_option('gateway_stripe_enabled') ) {

            // Instantiate the class
            (new CmsBasePaymentsCollectionStripeControllers\User)->view();
        
        } else {

            // Display 404 page
            show_404();

        }

    } 
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function ajax() {}

    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function cron_jobs() {     
        
    }
    
    /**
     * The public method hooks contains the gateway's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the admin's language files
        $this->CI->lang->load( 'stripe_admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_STRIPE );

        // Load hooks by category
        switch ($category) {

            case 'user_init':
            case 'admin_init':

                // Verify if admin has opened the settings component
                if ( md_the_data('hook') === 'payments' ) {

                    // Require the admin file
                    require_once CMS_BASE_PAYMENTS_STRIPE . '/inc/admin.php';

                }

                break;

        }

    }

    /**
     * The public method guest contains the gateway's access for guests
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function guest() {

        // Request the Stripe's vendor
        require_once CMS_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';

        // Set the configuration's parameters
        \Stripe\Stripe::setApiKey(md_the_option('stripe_secret_key'));

        // Get payload
        $payload = json_decode(file_get_contents('php://input'), true);

        // Verify if subscription exists
        if ( isset($payload['data']['object']['id']) ) {

            // Handle the event
            switch ( $payload['type'] ) {

                case 'customer.subscription.created':

                    // Verify if data exists
                    if ( !empty($payload['data']) ) {

                        // Verify if object exists
                        if ( !empty($payload['data']['object']) ) {

                            // Verify if plan exists
                            if ( !empty($payload['data']['object']['plan']) ) {

                                // Verify if plan's id exists
                                if ( !empty($payload['data']['object']['plan']['id']) ) {

                                    // Get the transaction
                                    $the_transaction = $this->CI->base_model->the_data_where('transactions',
                                    '*',
                                    array(
                                        'net_id' => $payload['data']['object']['items']['data'][0]['price']['id'],
                                        'gateway' => 'stripe'
                                    ));

                                    // Verify if transaction exists
                                    if ( $the_transaction ) {

                                        // Prepare subscription's parameters
                                        $subscription_params = array(
                                            'user_id' => $the_transaction[0]['user_id'],
                                            'net_id' => $payload['data']['object']['id'],
                                            'amount' => $the_transaction[0]['amount'],
                                            'currency' => $the_transaction[0]['currency'],
                                            'gateway' => 'stripe',
                                            'status' => 1,
                                            'last_update' => date('Y-m-d'),
                                            'created' => time()
                                        );

                                        // Save user subscription
                                        md_update_user_option($the_transaction[0]['user_id'], 'subscription', 1);

                                        // Save the subscription
                                        $this->CI->base_model->insert('subscriptions', $subscription_params);

                                    }                                    

                                }

                            }

                        }

                    }
                    
                    break;

                case 'customer.subscription.updated':

                    // Get the subscription saved in the database
                    $subscription = $this->CI->base_model->the_data_where('subscriptions', '*', array(
                        'net_id' => $payload['data']['object']['id'],
                        'gateway' => 'stripe'
                    ));

                    // Verify if subscription exists
                    if ( $subscription ) {

                        // Get the first transaction by subscription
                        $transaction = $this->CI->base_model->the_data_where('transactions', '*', array(
                            'net_id' => $payload['data']['object']['id'],
                            'gateway' => 'stripe'
                        ));

                        // Get the transaction by transaction's id
                        $verify_transaction = $this->CI->base_model->the_data_where('transactions', '*', array(
                            'net_id' => $payload['data']['object']['id'],
                            'gateway' => 'stripe'
                        ));

                        // Verify if transaction exists and is not dupplicate
                        if ( $transaction && ($verify_transaction === FALSE) ) {

                            // Only if is not today created subscription will be saved
                            if ( $subscription[0]['last_update'] !== date('Y-m-d') ) {

                                // Now we have to clone the transaction
                                $tran_array = array(
                                    'user_id' => $transaction[0]['user_id'],
                                    'net_id' => $payload['data']['object']['id'],
                                    'amount' => $transaction[0]['amount'],
                                    'currency' => $transaction[0]['currency'],
                                    'gateway' => $transaction[0]['gateway'],
                                    'status' => $transaction[0]['status'],
                                    'created' => time()
                                );

                                // Save the transaction
                                $transaction_id = $this->CI->base_model->insert('transactions', $tran_array);

                                // Verify if transaction ID exists
                                if ( $transaction_id ) {

                                    // Get all fields
                                    $fields = $this->CI->base_model->the_data_where('transactions_fields', '*', array(
                                        'transaction_id' => $transaction[0]['transaction_id']
                                    ));

                                    // If fields exists should be copied
                                    if ( $fields ) {
                                        
                                        // List all fields
                                        foreach ( $fields as $field ) {

                                            // Now we have to clone the fields
                                            $field_array = array(
                                                'transaction_id' => $transaction_id,
                                                'field_name' => $field['field_name'],
                                                'field_value' => $field['field_value']
                                            );

                                            // Save the transaction's field
                                            $this->CI->base_model->insert('transactions_fields', $field_array);                                        

                                        }

                                    }
                                    
                                    // Get all options
                                    $options = $this->CI->base_model->the_data_where('transactions_options', '*', array(
                                        'transaction_id' => $transaction[0]['transaction_id']
                                    ));

                                    // If options exists should be copied
                                    if ( $options ) {
                                        
                                        // List all options
                                        foreach ( $options as $option ) {

                                            // Now we have to clone the options
                                            $option_array = array(
                                                'transaction_id' => $transaction_id,
                                                'option_name' => $option['option_name'],
                                                'option_value' => $option['option_value']
                                            );

                                            // Save the transaction's option
                                            $this->CI->base_model->insert('transactions_options', $option_array);                                        

                                        }

                                    }

                                }

                            }

                        }

                    }

                    break;

                case 'customer.subscription.deleted':

                    // Get the subscription saved in the database
                    $subscription = $this->CI->base_model->the_data_where('subscriptions', '*', array(
                        'net_id' => $payload['data']['object']['id'],
                        'gateway' => 'stripe'
                    ));

                    // Delete subscription's mark
                    md_delete_user_option($subscription[0]['user_id'], 'subscription');

                    // Verify if subscription exists
                    if ( $subscription ) {

                        // Delete the subscription from the database
                        $this->CI->base_model->delete('subscriptions', array(
                            'net_id' => $payload['data']['object']['id'],
                            'gateway' => 'stripe'
                        ) );

                        // Verify if transaction exists
                        if ( $transaction ) {
                                
                            // Get all options
                            $options = $this->CI->base_model->the_data_where('transactions_options', '*', array(
                                'transaction_id' => $transaction[0]['transaction_id']
                            ));

                            // If options exists should be copied
                            if ( $options ) {
                                
                                // List all options
                                foreach ( $options as $option ) {

                                    // It's a temporary solution but will be improved in future
                                    if ( $option['option_name'] === 'plan_id' ) {

                                        // Reset the plan
                                        $this->CI->base_model->update('users_meta', array(
                                            'user_id' => $subscription[0]['user_id'],
                                            'meta_name' => 'plan'
                                        ), array(
                                            'meta_value' => 1
                                        ));

                                        break;
                                        
                                    }

                                }

                            }

                        }

                    }

                    break;

            }

        }

    }

    /**
     * The public method delete_subscription deletes subscriptions
     * 
     * @param array $subscription contains the subscription's data
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_subscription($subscription) {

        // Verify if the subscription's id exists
        if ( isset($subscription['net_id']) ) {

            // Delete subscription's mark
            md_delete_user_option($subscription['user_id'], 'subscription');

            // Request the Stripe's vendor
            require_once CMS_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';

            // Set the configuration's parameters
            \Stripe\Stripe::setApiKey(md_the_option('stripe_secret_key'));

            // Get the subscription
            $get_subscription = \Stripe\Subscription::retrieve(
                $subscription['net_id']
            );

            // Verify if status exists
            if ( !empty($get_subscription->status) ) {

                // Verify if the status is not cancelled
                if ( $get_subscription->status !== 'canceled' ) {

                    // Delete the subscription
                    $get_subscription->delete();

                }

            }
            
            // Delete the subscription
            $this->CI->base_model->delete('subscriptions', array('gateway' => 'stripe', 'net_id' => $subscription['net_id']));

        }

    }
    
    /**
     * The public method gateway_info contains the gateway's info
     * 
     * @since 0.0.8.0
     * 
     * @return array with gateway's info
     */
    public function gateway_info() {

        // Create and return array
        return array(
            'gateway' => 'Stripe'
        );

    }

}

/* End of file main.php */