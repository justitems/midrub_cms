<?php
/**
 * Midrub Payments Stripe
 *
 * This file loads the Stripe's gateway
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the namespace
namespace MidrubBase\Payments\Collection\Stripe;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_PAYMENTS_STRIPE') OR define('MIDRUB_BASE_PAYMENTS_STRIPE', MIDRUB_BASE_PAYMENTS . 'collection/stripe/');
defined('MIDRUB_BASE_PAYMENTS_STRIPE_VERSION') OR define('MIDRUB_BASE_PAYMENTS_STRIPE_VERSION', '0.0.1999997');

// Define the namespaces to use
use MidrubBase\Payments\Interfaces as MidrubBasePaymentsInterfaces;
use MidrubBase\Payments\Collection\Stripe\Controllers as MidrubBasePaymentsCollectionStripeControllers;


/*
 * Main class loads the Stripe's gateway
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Main implements MidrubBasePaymentsInterfaces\Payments {
    
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
        if ( get_option('stripe') ) {

            // Instantiate the class
            (new MidrubBasePaymentsCollectionStripeControllers\User)->view();
        
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
    public function ajax() {    
        
        // Get action's get input
        $action = $this->CI->input->get('action');

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {
            
            // Call method if exists
            (new MidrubBasePaymentsCollectionStripeControllers\Ajax)->$action();
            
        } catch (Exception $ex) {
            
            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );
            
            echo json_encode($data);
            
        }

    }

    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function cron_jobs() {

        // Process the subscriptions
        (new MidrubBasePaymentsCollectionStripeControllers\Cron)->subscriptions();        
        
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
        $this->CI->lang->load( 'stripe_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_STRIPE );

        // Load hooks by category
        switch ($category) {

            case 'user_init':
            case 'admin_init':

                // Verify if admin has opened the settings component
                if ( ( md_the_component_variable('component') === 'settings' ) || ( md_the_component_variable('component') === 'plans' ) || ( md_the_component_variable('component') === 'upgrade' ) ) {

                    // Require the admin file
                    require_once MIDRUB_BASE_PAYMENTS_STRIPE . '/inc/admin.php';

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
        require_once MIDRUB_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';

        // Set the configuration's parameters
        \Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

        // Get payload
        $payload = json_decode(file_get_contents('php://input'), true);

        // Verify if subscription exists
        if ( isset($payload['data']['object']['id']) ) {

            // Handle the event
            switch ( $payload['type'] ) {

                case 'customer.subscription.updated':

                    // Get the subscribtion saved in the database
                    $subscription = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                        'net_id' => $payload['data']['object']['id'],
                        'gateway' => 'stripe'
                    ));

                    // Verify if subscribtion exists
                    if ( $subscription ) {

                        // Get the first transaction by subscribtion
                        $transaction = $this->CI->base_model->get_data_where('transactions', '*', array(
                            'net_id' => $payload['data']['object']['id'],
                            'gateway' => 'stripe'
                        ));

                        // Get the transaction by transaction's id
                        $verify_transaction = $this->CI->base_model->get_data_where('transactions', '*', array(
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
                                    $fields = $this->CI->base_model->get_data_where('transactions_fields', '*', array(
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
                                    $options = $this->CI->base_model->get_data_where('transactions_options', '*', array(
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

                    // Get the subscribtion saved in the database
                    $subscription = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                        'net_id' => $payload['data']['object']['id'],
                        'gateway' => 'stripe'
                    ));

                    // Verify if subscribtion exists
                    if ( $subscription ) {

                        // Delete the subscription from the database
                        $this->CI->base_model->delete('subscriptions', array(
                            'net_id' => $payload['data']['object']['id'],
                            'gateway' => 'stripe'
                        ) );

                        // Verify if transaction exists
                        if ( $transaction ) {
                                
                            // Get all options
                            $options = $this->CI->base_model->get_data_where('transactions_options', '*', array(
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

            // Request the Stripe's vendor
            require_once MIDRUB_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';

            // Set the configuration's parameters
            \Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

            // Get the subscription
            $get_subscription = \Stripe\Subscription::retrieve(
                $subscription['net_id']
            );
            
            // Delete the subscription
            $get_subscription->delete();

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

        // Load language
        $this->CI->lang->load( 'stripe_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_STRIPE );

        // Create and return array
        return array(
            'gateway' => $this->CI->lang->line('Stripe'),
            'configuration' => array(
                array(
                    'type' => 'text_input',
                    'slug' => 'stripe_merchant_id',
                    'label' => $this->CI->lang->line('stripe_merchant_id')
                ),
                array(
                    'type' => 'text_input',
                    'slug' => 'stripe_public_key',
                    'label' => $this->CI->lang->line('stripe_public_key')
                ),
                array(
                    'type' => 'text_input',
                    'slug' => 'stripe_private_key',
                    'label' => $this->CI->lang->line('stripe_private_key')
                ),
            )
        );

    }

}
