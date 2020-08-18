<?php
/**
 * Process Helpers
 * 
 * PHP Version 7.3
 *
 * This file contains the class Process
 * with methods to process the Stripe Payments
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Stripe\Helpers;

use Exception;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

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

        // Request the Stripe's vendor
        require_once MIDRUB_BASE_PAYMENTS_STRIPE . 'vendor/autoload.php';
        
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
        \Stripe\Stripe::setApiKey(get_option('stripe_secret_key'));

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
            $this->CI->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
            $this->CI->form_validation->set_rules('card_number', 'Card Number', 'trim|required');
            $this->CI->form_validation->set_rules('expiration', 'Expiration', 'trim|required');
            $this->CI->form_validation->set_rules('cvv', 'CVV', 'trim|required');
            $this->CI->form_validation->set_rules('subscription', 'Subscription', 'trim');
            $this->CI->form_validation->set_rules('source_id', 'Source ID', 'trim');
            
            // Get data
            $full_name = $this->CI->input->post('full_name', TRUE);
            $card_number = $this->CI->input->post('card_number', TRUE);
            $expiration = $this->CI->input->post('expiration', TRUE);
            $cvv = $this->CI->input->post('cvv', TRUE);
            $subscription = $this->CI->input->post('subscription', TRUE);
            $source_id = $this->CI->input->post('source_id', TRUE);
            
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

                // Prepare the expiration
                $exp = explode('/', $expiration);

                // Verify if should be created a subscription
                if ( $subscription ) {

                    try {

                        // Create a Customer:
                        $customer = \Stripe\Customer::create(
                            array(
                                'source' => $source_id,
                                'email' => $get_user[0]['email']
                            )
                        );

                    } catch (Exception $ex) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('stripe_customer_was_not_saved')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }

                    try {

                        // Add credit card
                        \Stripe\Customer::createSource(
                            $customer->id,
                            array(
                                'source' => array(
                                    'object' => 'card',
                                    'number' => $card_number,
                                    'exp_month' => $exp[0],
                                    'exp_year' => $exp[1],
                                    'cvc' => $cvv
                                )

                            )

                        );

                    } catch (Exception $ex) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('stripe_credit_card_was_not_saved')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }

                    try {

                        // Try to create a subscription
                        $subscription = \Stripe\Subscription::create(array(
                            'customer' => $customer->id,
                            'items' => array(

                                array(
                                    'plan' => $transaction['options']['plan_id']
                                )

                            )

                        ));

                    } catch (Exception $ex) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $ex->getMessage()
                        );
        
                        // Display the error response
                        echo json_encode($data);
                        exit();
                        
                    }

                    // Verify if the subscription was created
                    if ( $subscription->id ) {

                        // We need to delete the previous subscription
                        $get_subscriptions = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                            'user_id' => $this->CI->user_id
                        ));

                        // Verify if old subscribtions exists
                        if ( $get_subscriptions ) {

                            // List all subscriptions
                            foreach ( $get_subscriptions as $get_subscription ) {
                                
                                // Create an array
                                $array = array(
                                    'MidrubBase',
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
                                'net_id' => $subscription->id,
                                'gateway' => 'stripe',
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

                        // Try to save the subscription
                        $subscription_create = create_subscription(array(
                            'user_id' => $this->CI->user_id,
                            'net_id' => $subscription->id,
                            'gateway' => 'stripe',
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

                    } else {

                        // Save transaction error
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'gateway' => 'stripe',
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

                    }

                } else {

                    try {

                        // Create a Customer:
                        $customer = \Stripe\Customer::create(
                            array(
                                'source' => $source_id,
                                'email' => $get_user[0]['email']
                            )
                        );

                    } catch (Exception $ex) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('stripe_customer_was_not_saved')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }

                    // Charge array
                    $charge = array(
                        'amount' => ($transaction['pay']['amount'] * 100),
                        'currency' => $transaction['pay']['currency'],
                        'customer' => $customer->id
                    );

                    

                    // Verify if charge exists
                    if ( $source_id ) {

                        // Set source
                        $charge['source'] = $source_id;

                    } else {

                        // Set card
                        $charge['card'] = array(
                            'number' => $card_number,
                            'exp_month' => $exp[0],
                            'exp_year' => $exp[1],
                            'cvc' => $cvv
                        );

                    }

                    try {

                        // Get the response
                        $response = \Stripe\Charge::create($charge);

                    } catch (Exception $ex) {

                        // Save transaction error
                        save_complete_transaction(
                            $transaction['transaction_id'],
                            $this->CI->user_id,
                            array(
                                'gateway' => 'stripe',
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
                    if ( $response->id ) {

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
                                'net_id' => $response->id,
                                'gateway' => 'stripe',
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

                    }

                }
                
            }
            
        }
        
    }
    
}

/* End of file process.php */