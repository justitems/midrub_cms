<?php
/**
 * Process Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Process
 * with methods to process the Paypal Payments
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Paypal\Helpers;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Process class provides the methods to process the payments
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
*/
class Process {
    
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
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------
    
    /**
     * The public method prepare prepares a payment
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function prepare() {

        // Get incomplete transaction
        $transaction = $this->CI->session->flashdata('incomplete_transaction_saved');

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
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('data', 'Data', 'trim');
            $this->CI->form_validation->set_rules('plan', 'Plan', 'trim');
            
            // Get data
            $data = $this->CI->input->post('data', TRUE);
            $plan = $this->CI->input->post('plan', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('payment_was_not_accepted')
                );

                // Verify if transaction has redirect
                if (isset($transaction['options']['error_redirect'])) {
                    $data['error_redirect'] = $transaction['options']['error_redirect'];
                }

                echo json_encode($data);   
                
            } else {              

                // Verify if subscribtion exists
                if ( isset($data['subscriptionID']) ) {

                    // Verify if the subscribtion exists
                    $subscription = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                        'net_id' => $data['subscriptionID'],
                        'gateway' => 'paypal'
                    ));
                    
                    if ( $subscription ) {

                        // Save transaction error
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'gateway' => 'paypal',
                                'status' => 2
                            )
                        );

                        // Verify if transaction has redirect
                        if ( isset($transaction['options']['error_redirect']) ) {
                            $response['error_redirect'] = $transaction['options']['error_redirect'];
                        }

                        // Prepare the error response
                        $response = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('an_error_has_occurred')
                        );
        
                        // Display the error response
                        echo json_encode($response);  
                        exit();

                    } else {

                        // Save transaction success
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'net_id' => $data['orderID'],
                                'gateway' => 'PayPal',
                                'status' => 1
                            )
                        );

                        // Prepare the success response
                        $response = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('payment_was_accepted')
                        );

                        // Verify if transaction has redirect
                        if ( isset($transaction['options']['success_redirect']) ) {
                            $response['success_redirect'] = $transaction['options']['success_redirect'];
                        }

                        // We need to delete the previous subscription
                        $subscriptions = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                            'user_id' => $this->CI->user_id
                        ));

                        // Verify if old subscribtions exists
                        if ( $subscriptions ) {

                            // List all subscriptions
                            foreach ( $subscriptions as $subscription ) {
                                
                                // Create an array
                                $array = array(
                                    'MidrubBase',
                                    'Payments',
                                    'Collection',
                                    ucfirst($subscription['gateway']),
                                    'Main'
                                );

                                // Implode the array above
                                $cl = implode('\\', $array);

                                // Delete subscribtion
                                (new $cl())->delete_subscription($subscription);

                            }

                            // Delete the subscription from the database
                            $this->CI->base_model->delete('subscriptions', array(
                                'user_id' => $this->CI->user_id,
                            ) );

                        }

                        // Try to save the subscription
                        $subscription_create = create_subscription(array(
                            'user_id' => $this->CI->user_id,
                            'net_id' => $data['subscriptionID'],
                            'gateway' => 'paypal',
                            'status' => 1,
                            'last_update' => date('Y-m-d'),
                            'created' => time()
                        ));

                        // If the subscription was not saved successfully change the success message
                        if ( !$subscription_create ) {
                            $response['message'] = $this->CI->lang->line('payment_was_accepted_but_not_saved');
                        }
        
                        // Display the success response
                        echo json_encode($response);
                        exit();

                    }

                } else {

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

                        // First get the payment's details
                        $curl = curl_init('https://api.paypal.com/v1/payments/payment/' . $data['paymentID']);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token_response['access_token']));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                        $payment_response = json_decode(curl_exec($curl), true);
                        curl_close($curl);
                        
                        // First verify the state
                        if ( isset($payment_response['state']) ) {

                            if ( $payment_response['state'] === 'approved' ) {

                                // Verify if amount exists
                                if ( isset($payment_response['transactions'][0]['amount']['total']) ) {

                                    // Verify if is expected amount
                                    if ( ($payment_response['transactions'][0]['amount']['total'] === $transaction['pay']['amount']) && ($payment_response['transactions'][0]['amount']['currency'] === $transaction['pay']['currency']) ) {

                                        // Save transaction success
                                        save_complete_transaction(
                                            $transaction['transaction_id'],
                                            $this->CI->user_id,
                                            array(
                                                'net_id' => $payment_response['id'],
                                                'gateway' => 'paypal',
                                                'status' => 1
                                            )
                                        );

                                        // Prepare the success response
                                        $data = array(
                                            'success' => TRUE,
                                            'message' => $this->CI->lang->line('payment_was_accepted')
                                        );

                                        // Verify if transaction has redirect
                                        if ( isset($transaction['options']['success_redirect']) ) {
                                            $data['success_redirect'] = $transaction['options']['success_redirect'];
                                        }
                        
                                        // Display the success response
                                        echo json_encode($data);
                                        exit();

                                    }

                                }

                            }

                        }

                    }

                }
                
            }
            
        }

        // Save transaction error
        save_complete_transaction(
            $transaction['transaction_id'],
            $this->CI->user_id,
            array(
                'gateway' => 'paypal',
                'status' => 2
            )
        );

        // Verify if transaction has redirect
        if ( isset($transaction['options']['error_redirect']) ) {
            $data['error_redirect'] = $transaction['options']['error_redirect'];
        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('payment_was_not_accepted')
        );

        // Display the error response
        echo json_encode($data);
        
    }
    
}

/* End of file process.php */