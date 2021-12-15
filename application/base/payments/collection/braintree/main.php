<?php
/**
 * Midrub Payments Braintree
 *
 * This file loads the Braintree's gateway
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the namespace
namespace CmsBase\Payments\Collection\Braintree;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_PAYMENTS_BRAINTREE') OR define('CMS_BASE_PAYMENTS_BRAINTREE', CMS_BASE_PAYMENTS . 'collection/braintree/');
defined('CMS_BASE_PAYMENTS_BRAINTREE_VERSION') OR define('CMS_BASE_PAYMENTS_BRAINTREE_VERSION', '0.0.2');

// Define the namespaces to use
use CmsBase\Payments\Interfaces as CmsBasePaymentsInterfaces;
use CmsBase\Payments\Collection\Braintree\Controllers as CmsBasePaymentsCollectionBraintreeControllers;


/*
 * Main class loads the Braintree's gateway
 * 
 * @author Scrisoft
 * @package Midrub
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
        if ( md_the_option('braintree') ) {

            // Instantiate the class
            (new CmsBasePaymentsCollectionBraintreeControllers\User)->view();
        
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
            (new CmsBasePaymentsCollectionBraintreeControllers\Ajax)->$action();
            
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
        (new CmsBasePaymentsCollectionBraintreeControllers\Cron)->subscriptions();        
        
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
        $this->CI->lang->load( 'braintree_admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_BRAINTREE );

        // Load hooks by category
        switch ($category) {

            case 'user_init':
            case 'admin_init':

                // Verify if admin has opened the settings component
                if ( ( md_the_data('component') === 'settings' ) || ( md_the_data('component') === 'plans' ) || ( md_the_data('component') === 'upgrade' ) ) {

                    // Require the admin file
                    require_once CMS_BASE_PAYMENTS_BRAINTREE . '/inc/admin.php';

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

        if ( $this->CI->input->post('bt_signature', TRUE) && $this->CI->input->post('bt_payload', TRUE) ) {

            // Require the Braintree class
            require_once CMS_BASE_PAYMENTS_BRAINTREE . 'vendor/braintree/braintree_php/lib/Braintree.php';

            // Set the Braintree configuration
            $config = new \Braintree_Configuration([
                'environment' => 'production',
                'merchantId' => md_the_option('braintree_merchant_id'),
                'publicKey' => md_the_option('braintree_public_key'),
                'privateKey' => md_the_option('braintree_private_key')
            ]);

            // Get the gateway
            $gateway = new \Braintree\Gateway($config);

            // Get webhook
            $webhookNotification = $gateway->webhookNotification()->parse(
                $this->CI->input->post('bt_signature', TRUE), $this->CI->input->post('bt_payload', TRUE)
            );

            // Verify if webhook notification exists
            if ( $webhookNotification ) {

                // Get the subscription's ID
                $subscription_id = $webhookNotification->subscription->id;

                // Get the subscription saved in the database
                $subscription = $this->CI->base_model->the_data_where('subscriptions', '*', array(
                    'net_id' => $subscription_id,
                    'gateway' => 'braintree'
                ));

                // Verify if subscription exists
                if ( $subscription ) {

                    // Get the first transaction by subscription
                    $transaction = $this->CI->base_model->the_data_where('transactions', '*', array(
                        'net_id' => $subscription_id,
                        'gateway' => 'braintree'
                    ));

                    // Verify if kind is success
                    if ( $webhookNotification->kind === 'subscription_charged_successfully' ) {

                        // Get the transaction by transaction's id
                        $verify_transaction = $this->CI->base_model->the_data_where('transactions', '*', array(
                            'net_id' => $webhookNotification->subscription->transactions[0]->id,
                            'gateway' => 'braintree'
                        ));

                        // Verify if transaction exists and is not dupplicate
                        if ( $transaction && ($verify_transaction === FALSE) ) {

                            // Only if is not today created subscription will be saved
                            if ( $subscription[0]['last_update'] !== date('Y-m-d') ) {

                                // Now we have to clone the transaction
                                $tran_array = array(
                                    'user_id' => $transaction[0]['user_id'],
                                    'net_id' => $webhookNotification->subscription->transactions[0]->id,
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

                                    // Save transaction success
                                    save_complete_transaction(
                                        $transaction_id,
                                        $transaction[0]['user_id'],
                                        array(
                                            'net_id' => $webhookNotification->subscription->transactions[0]->id,
                                            'gateway' => 'Braintree',
                                            'status' => 1
                                        )
                                    );

                                }

                            }

                        }

                    } else {
                        
                        // Delete the subscription from the database
                        $this->CI->base_model->delete('subscriptions', array(
                            'net_id' => $subscription_id,
                            'gateway' => 'braintree'
                        ) );

                        // Delete subscription's mark
                        md_delete_user_option($subscription[0]['user_id'], 'subscription');     

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

                }

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

            // Require the Braintree class
            require_once CMS_BASE_PAYMENTS_BRAINTREE . 'vendor/braintree/braintree_php/lib/Braintree.php';

            // Set the Braintree configuration
            $config = new \Braintree_Configuration([
                'environment' => 'production',
                'merchantId' => md_the_option('braintree_merchant_id'),
                'publicKey' => md_the_option('braintree_public_key'),
                'privateKey' => md_the_option('braintree_private_key')
            ]);

            // Get the gateway
            $gateway = new \Braintree\Gateway($config);

            // Delete the subscription
            $gateway->subscription()->cancel($subscription['net_id']);

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
        $this->CI->lang->load( 'braintree_admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_BRAINTREE );

        // Create and return array
        return array(
            'gateway' => $this->CI->lang->line('braintree'),
            'configuration' => array(
                array(
                    'type' => 'text_input',
                    'slug' => 'braintree_merchant_id',
                    'label' => $this->CI->lang->line('braintree_merchant_id')
                ),
                array(
                    'type' => 'text_input',
                    'slug' => 'braintree_public_key',
                    'label' => $this->CI->lang->line('braintree_public_key')
                ),
                array(
                    'type' => 'text_input',
                    'slug' => 'braintree_private_key',
                    'label' => $this->CI->lang->line('braintree_private_key')
                )

            )
            
        );

    }

}
