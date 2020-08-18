<?php

/**
 * Cron Controller
 *
 * This file processes the gateway's cron job calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Braintree\Controllers;

// Constants
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Cron class processes the gateway's cron job calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

class Cron
{

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
        $this->CI = &get_instance();

        // Load language
        $this->CI->lang->load( 'braintree_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_BRAINTREE );

    }

    /**
     * The public method subscriptions verifies subscription
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function subscriptions() {

        // Require the Braintree class
        require_once MIDRUB_BASE_PAYMENTS_BRAINTREE . 'vendor/braintree/braintree_php/lib/Braintree.php';

        // Get subscriptions with base model
        $subscriptions = $this->CI->base_model->get_data_where('subscriptions', '*', array(
            'gateway' => 'braintree',
            'last_update !=' => date('Y-m-d')
        ));

        // Verify if the subscriptions exists
        if ( $subscriptions ) {

            $config = new \Braintree_Configuration([
                'environment' => 'production',
                'merchantId' => get_option('braintree_merchant_id'),
                'publicKey' => get_option('braintree_public_key'),
                'privateKey' => get_option('braintree_private_key')
            ]);

            $gateway = new \Braintree\Gateway($config);

            // List all subscriptions
            foreach ( $subscriptions as $subscription ) {
/**
                $collection = $gateway->transaction()->search(array(
                    \Braintree_TransactionSearch::creditCardNumber()->is('4111111111111111')
                ));

                foreach($collection as $transaction) {
                    echo $transaction->id . '<br>';
                }
**/
                // Update the date
                /**$this->CI->base_model->update('subscriptions', array(
                    'subscription_id' => $subscription['subscription_id']
                ), array(
                    'last_update' => date('Y-m-d')
                ));**/

                // Get the subscription
                // $subscription = $gateway->subscription()->find($subscription['net_id']);

                // var_dump($subscription->status);

            }

        }

        exit();

    }

}

/* End of file cron.php */