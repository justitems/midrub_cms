<?php
/**
 * Midrub Payments Paypal
 *
 * This file loads the Paypal's gateway
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the namespace
namespace CmsBase\Payments\Collection\Paypal;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_PAYMENTS_PAYPAL') OR define('CMS_BASE_PAYMENTS_PAYPAL', CMS_BASE_PAYMENTS . 'collection/paypal/');
defined('CMS_BASE_PAYMENTS_PAYPAL_VERSION') OR define('CMS_BASE_PAYMENTS_PAYPAL_VERSION', '0.0.2');

// Define the namespaces to use
use CmsBase\Payments\Interfaces as CmsBasePaymentsInterfaces;
use CmsBase\Payments\Collection\Paypal\Controllers as CmsBasePaymentsCollectionPaypalControllers;


/*
 * Main class loads the Paypal's gateway
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Main implements CmsBasePaymentsInterfaces\Payments {
    
    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
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
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function connect() {

    }

    /**
     * The public method save saves saves returned user's data
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function save() {

    }

    /**
     * The public method pay makes a payment
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function pay() {

        // Verify if the gateway is enabled
        if ( md_the_option('gateway_paypal_enabled') ) {

            // Instantiate the class
            (new CmsBasePaymentsCollectionPaypalControllers\User)->view();
        
        } else {

            // Display 404 page
            show_404();

        }

    } 
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.1
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
            (new CmsBasePaymentsCollectionPaypalControllers\Ajax)->$action();
            
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
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function cron_jobs() {}
    
    /**
     * The public method hooks contains the gateway's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the admin's language files
        $this->CI->lang->load( 'paypal_admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_PAYPAL );

        // Load hooks by category
        switch ($category) {

            case 'user_init':
            case 'admin_init':

                // Verify if admin has opened the settings component
                if ( md_the_data('hook') === 'payments' ) {

                    // Require the admin file
                    require_once CMS_BASE_PAYMENTS_PAYPAL . '/inc/admin.php';

                }

                break;

        }

    }

    /**
     * The public method guest contains the gateway's access for guests
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function guest() {

        if ( md_the_option('paypal_client_id') && md_the_option('paypal_client_secret') ) {

            $raw_post_data = json_decode(file_get_contents('php://input'), true);

            if ( isset($raw_post_data['event_type']) ) {

                // Get the subscription saved in the database
                $subscription = $this->CI->base_model->the_data_where('subscriptions', '*', array(
                    'net_id' => $raw_post_data['resource']['id'],
                    'gateway' => 'paypal'
                ));

                // Verify if subscription exists
                if ( $subscription ) {

                    // Get the first transaction by subscription
                    $transaction = $this->CI->base_model->the_data_where('transactions', '*', array(
                        'user_id' => $subscription[0]['user_id'],
                        'gateway' => 'paypal',
                        'status' => 1
                    ));

                    switch( $raw_post_data['event_type'] ) {

                        case 'BILLING.SUBSCRIPTION.CANCELLED':

                            // Delete the subscription from the database
                            $this->CI->base_model->delete('subscriptions', array(
                                'net_id' => $raw_post_data['resource']['id'],
                                'gateway' => 'paypal'
                            ) );

                            // Delete subscription's mark
                            md_delete_user_option($subscription[0]['user_id'], 'subscription');

                            break;

                        case 'BILLING.SUBSCRIPTION.RENEWED':

                            // Verify if transaction exists
                            if ( $transaction ) {

                                // Now we have to clone the transaction
                                $tran_array = array(
                                    'user_id' => $transaction[0]['user_id'],
                                    'net_id' => $raw_post_data['id'],
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
                                            'net_id' => $raw_post_data['id'],
                                            'gateway' => 'PayPal',
                                            'status' => 1
                                        )
                                    );

                                }

                            }

                            break;

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
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function delete_subscription($subscription) {

        // Verify if the subscription's id exists
        if ( isset($subscription['net_id']) ) {

            // Delete subscription's mark
            md_delete_user_option($subscription['user_id'], 'subscription');

            if ( md_the_option('paypal_client_id') && md_the_option('paypal_client_secret') ) {

                // Set api url
                $api_url = md_the_option('paypal_sandbox_enabled')?'https://api-m.sandbox.paypal.com/v1/':'https://api.paypal.com/v1/';

                // Init CURL
                $curl = curl_init();

                // Set CURL params
                curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url . 'oauth2/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_USERPWD => md_the_option('paypal_client_id') . ':' . md_the_option('paypal_client_secret'),
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Accept-Language: en_US'
                    )
                ));

                // Get the token response
                $token_response = json_decode(curl_exec($curl), true);

                // Close the CURL session
                curl_close($curl);

                // Verify if access token exists
                if ( isset($token_response['access_token']) ) {

                    // Deletion reason
                    $deletion_params = array(
                        'reason' => 'Item out of stock'
                    );

                    // Init the CURL session
                    $curl = curl_init();

                    // Set URL
                    curl_setopt($curl, CURLOPT_URL, $api_url . 'billing/subscriptions/' . $subscription['net_id'] . '/suspend');

                    // Enable post
                    curl_setopt($curl, CURLOPT_POST, 1);

                    // Set fields
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($deletion_params));

                    // Set header
                    curl_setopt(
                        $curl,
                        CURLOPT_HTTPHEADER,
                        array(
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $token_response['access_token']
                        )
                    );

                    // Execute the request
                    curl_exec ($curl);

                    // Close the CURL session
                    curl_close ($curl);

                }

            }

        }

    }
    
    /**
     * The public method gateway_info contains the gateway's info
     * 
     * @since 0.0.8.1
     * 
     * @return array with gateway's info
     */
    public function gateway_info() {

        // Create and return array
        return array(
            'gateway' => 'PayPal'
        );

    }

}
