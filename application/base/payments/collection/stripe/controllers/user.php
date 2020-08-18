<?php
/**
 * User Controller
 *
 * This file loads the Payment's view
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments\Collection\Stripe\Controllers;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the Storage app loader
 * 
 * @author Scrisoft
 * @package Midrub
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
        $this->CI->lang->load( 'stripe_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_PAYMENTS_STRIPE );
        
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

        // Set Main Midrub JS
        set_js_urls(array(base_url('assets/js/main.js')));

        // Set Stripe JS
        set_js_urls(array('//js.stripe.com/v2/'));    
        
        // Set Stripe Checkout JS
        set_js_urls(array('//cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.0/featherlight.min.js'));            
        
        // Set Stripe App JS
        set_js_urls(array(base_url('assets/base/payments/collection/stripe/js/main.js?ver=' . MIDRUB_BASE_PAYMENTS_STRIPE_VERSION)));

        // Get the incomplete transaction
        $incomplete_transaction = the_incomplete_transaction();

        /**

        // Get transaction's ID
        $transaction = $this->CI->input->get('transaction', TRUE);

        // Verify if transaction exists
        if ( is_numeric($transaction) ) {
            
            // Get transaction
            $get_transaction = $this->CI->base_model->get_data_where('transactions', '*', array(
                'transaction_id' => $transaction,
                'user_id' => $this->CI->user_id,
                'status <' => 1
            ));

            // Verify if the transaction exists
            if ( $get_transaction ) {

                // Fields
                $fields = array();

                // Options
                $options = array();

                // Try to find the transaction's fields
                $get_fields = $this->CI->base_model->get_data_where('transactions_fields', '*', array('transaction_id' => $transaction));
                
                // Verify if the transaction has fields
                if ( $get_fields ) {

                    // List all fields
                    foreach ( $get_fields as $field ) {

                        // Set field
                        $fields[$field['field_name']] = $field['field_value'];

                    }

                }

                // Try to find the transaction's options
                $get_options = $this->CI->base_model->get_data_where('transactions_options', '*', array('transaction_id' => $transaction));
                
                // Verify if the transaction has options
                if ( $get_options ) {

                    // List all options
                    foreach ( $get_options as $option ) {

                        // Set option
                        $options[$option['option_name']] = $option['option_value'];

                    }

                }

                // Register transaction
                $incomplete_transaction = array(
                    'transaction_id' => $transaction,
                    'pay' => array(
                        'amount' => $get_transaction[0]['amount'],
                        'currency' => $get_transaction[0]['currency']
                    ),
                    'fields' => $fields,
                    'options' => $options
                );

                // Set transaction data
                $this->CI->session->set_flashdata('incomplete_transaction', $incomplete_transaction);

            }

        }

        **/
        
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

                    // Set recurring_payments
                    $params['recurring_payments'] = true;

                }

            }

            // Set views params
            set_payment_view(
                $this->CI->load->ext_view(
                    MIDRUB_BASE_PAYMENTS_STRIPE . 'views',
                    'main',
                    $params,
                    true
                )

            );

        } else {

            // Set views params
            set_payment_view(
                $this->CI->load->ext_view(
                    MIDRUB_BASE_PAYMENTS_STRIPE . 'views',
                    'expired',
                    array(),
                    true
                )

            );

        }
        
    }

}
