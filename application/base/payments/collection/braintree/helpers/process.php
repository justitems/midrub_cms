<?php
/**
 * Process Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Process
 * with methods to process the Braintree Payments
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Braintree\Helpers;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Braintree class
require_once MIDRUB_BASE_PAYMENTS_BRAINTREE . 'vendor/braintree/braintree_php/lib/Braintree.php';

/*
 * Process class provides the methods to process the payments
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
*/
class Process {
    
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
        
    }

    //-----------------------------------------------------
    // Main class's methods
    //-----------------------------------------------------
    
    /**
     * The public method prepare prepares a payment
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function prepare() {

        // Set the configuration's parameters
        \Braintree_Configuration::environment('production');
        \Braintree_Configuration::merchantId(get_option('braintree_merchant_id'));
        \Braintree_Configuration::publicKey(get_option('braintree_public_key'));
        \Braintree_Configuration::privateKey(get_option('braintree_private_key'));

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
            $this->CI->form_validation->set_rules('nonce', 'Nonce', 'trim');
            $this->CI->form_validation->set_rules('subscription', 'Subscription', 'trim');
            
            // Get data
            $nonce = $this->CI->input->post('nonce', TRUE);
            $subscription = $this->CI->input->post('subscription', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('please_fill_all_required_fields')
                );

                // Verify if transaction has redirect
                if (isset($transaction['options']['error_redirect'])) {
                    $data['error_redirect'] = $transaction['options']['error_redirect'];
                }

                echo json_encode($data);   
                
            } else {

                // Get the user's email
                $get_user = $this->CI->base_model->get_data_where('users', '*', array(
                    'user_id' => $this->CI->user_id
                ));

                // Verify if should be created a subscription
                if ( $subscription ) {

                    try {

                        // Try to create a subscription
                        $customer = \Braintree\Customer::createNoValidate();

                        $paymentMethodResult = \Braintree_PaymentMethod::create([
                            'paymentMethodNonce' => $nonce,
                            'customerId' => $customer->id,
                            'options' => ['verifyCard' => true]
                        ]);

                        // Get subscription's ID
                        $subscriptionId = strval(rand());

                        // Create subscription
                        $create = \Braintree\Subscription::create(
                            array(
                                'id' => $subscriptionId,
                                'paymentMethodToken' => $paymentMethodResult->paymentMethod->token,
                                'planId' => $transaction['options']['plan_id'],
                                'price' => $transaction['pay']['amount']
                            )
                        );

                    } catch (Exception $ex) {

                        // Save transaction error
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'gateway' => 'braintree',
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
                            'message' => $create->message
                        );
        
                        // Display the error response
                        echo json_encode($data); 
                        exit();

                    }

                    // Verify if the subscription was created
                    if ( $create->success ) {

                        // Save transaction success
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'net_id' => $subscriptionId,
                                'gateway' => 'Braintree',
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
                            'net_id' => $subscriptionId,
                            'gateway' => 'braintree',
                            'status' => 1,
                            'last_update' => date('Y-m-d'),
                            'created' => time()
                        ));

                        // If the subscription was not saved successfully change the success message
                        if ( !$subscription_create ) {
                            $data['message'] = $this->CI->lang->line('payment_was_accepted_but_not_saved');
                        }
        
                        // Display the success response
                        echo json_encode($data);  

                    }

                } else {

                    try {

                        // Get the response
                        $response = \Braintree_Transaction::sale(
                            array(
                                'amount' => $transaction['pay']['amount'],
                                'paymentMethodNonce' => $nonce,
                                'customer' => array(
                                    'email' => $get_user[0]['email'],
                                    'company' => 'Company name'
                                ),
                                'options' => array(
                                    'skipAdvancedFraudChecking' => true
                                )

                            )

                        );

                    } catch (Exception $ex) {

                        // Save transaction error
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'gateway' => 'braintree',
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
                            'message' => $ex->getMessage()
                        );
        
                        // Display the error response
                        echo json_encode($data);  
                        exit();

                    }

                    // Verify if the transaction was processed successfully
                    if ( $response->success ) {

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

                        // Save transaction success
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'net_id' => $response->transaction->id,
                                'gateway' => 'braintree',
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
                        
                        // Submit for settlement after success
                        \Braintree_Transaction::submitForSettlement($response->transaction->id);

                    }

                }
                
            }
            
        }
        
    }
    
}

/* End of file process.php */