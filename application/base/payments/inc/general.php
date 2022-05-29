<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Payments
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('the_incomplete_transaction') ) {
    
    /**
     * The function the_incomplete_transaction returns the incomplete transaction
     * 
     * @since 0.0.8.0
     * 
     * @return array with the incomplete transaction or boolean false
     */
    function the_incomplete_transaction() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if flash data exists
        if ( $CI->session->flashdata('incomplete_transaction') ) {

            // Get incomplete transaction
            $transaction = $CI->session->flashdata('incomplete_transaction');

            // Verify if pay's data exists
            if ( isset($transaction['pay']['amount']) && isset($transaction['pay']['currency']) ) {

                // Prepare data to save
                $transaction_params = array(
                    'user_id' => md_the_user_id(),
                    'amount' => $CI->security->xss_clean($transaction['pay']['amount']),
                    'currency' => $CI->security->xss_clean($transaction['pay']['currency']),
                    'created' => time()
                );

                // Try to save the transaction
                $transaction_id = $CI->base_model->insert('transactions', $transaction_params);

                // Verify if the transaction was created
                if ( $transaction_id ) {

                    // Verify if the transaction has fields
                    if ( !empty($transaction['fields']) ) {

                        // List all fields
                        foreach ( $transaction['fields'] as $field_name => $field_value ) {

                            // Prepare data to save
                            $transaction_field = array(
                                'transaction_id' => $transaction_id,
                                'field_name' => $CI->security->xss_clean($field_name),
                                'field_value' => $CI->security->xss_clean($field_value)
                            );

                            // Try to save the transaction's field
                            $CI->base_model->insert('transactions_fields', $transaction_field);

                        }

                    }

                    // Verify if the transaction has options
                    if ( !empty($transaction['options']) ) {

                        // List all options
                        foreach ( $transaction['options'] as $option_name => $option_value ) {

                            // Prepare data to save
                            $transaction_option = array(
                                'transaction_id' => $transaction_id,
                                'option_name' => $CI->security->xss_clean($option_name),
                                'option_value' => $CI->security->xss_clean($option_value)
                            );

                            // Try to save the transaction's option
                            $CI->base_model->insert('transactions_options', $transaction_option);

                        }
                        
                    }

                    // Set the transaction's id
                    $transaction['transaction_id'] = $transaction_id;

                    // Set transaction data which will be used if gateway uses ajax for a better security
                    $CI->session->set_flashdata('incomplete_transaction_saved', $transaction);

                    // Return transaction
                    return $transaction;

                }

            }

        }

        return false;
        
    }
    
}

if ( !function_exists('get_invoices_option') ) {

    /**
     * The function get_invoices_option gets invoices option
     * 
     * @param string $option_name has the option identifier
     * @param string $template_slug has the template's slug
     * 
     * @return string with option's value or boolean false
     */
    function get_invoices_option($option_name, $template_slug) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Load Base Invoices Model
        $CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_invoices', 'base_invoices');

        // Try to find the option's value
        $md_the_option = $CI->base_invoices->get_invoices_option($option_name, $template_slug);

        // Verify if option exists
        if ( $md_the_option ) {

            return $md_the_option;

        } else {

            return false;

        }
        
    }

}

if ( !function_exists('get_template_field') ) {

    /**
     * The function get_template_field gets template's field by template's slug
     *
     * @param string $template_field has the template's field
     * @param string $template_slug has the template's slug
     * 
     * @return string with field's value or boolean false
     */
    function get_template_field($template_field, $template_slug) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Load Base Invoices Model
        $CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_invoices', 'base_invoices');

        // Try to find the field
        $get_field = $CI->base_invoices->get_template_field($template_field, $template_slug);

        // Verify if field exists
        if ( $get_field ) {

            return $get_field;

        } else {

            return false;

        }
        
    }

}

if ( !function_exists('save_complete_transaction') ) {
    
    /**
     * The function save_complete_transaction saves complete transaction
     * 
     * @param integer $transaction_id contains the transaction's ID
     * @param integer $user_id contains the user's ID
     * @param array $args contains the params to update
     * 
     * @since 0.0.8.0
     * 
     * @return boolean true or false
     */
    function save_complete_transaction($transaction_id, $user_id, $args) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Set transaction's data
        $CI->session->set_flashdata('complete_transaction', array(
            'transaction_id' => $transaction_id
        ));

        // Params array
        $params = array();

        // Verify if net's id exists
        if ( isset($args['net_id']) ) {
            $params['net_id'] = $args['net_id'];
        }

        // Verify if gateway exists
        if ( isset($args['gateway']) ) {
            $params['gateway'] = $args['gateway'];
        }
        
        // Verify if status exists
        if ( isset($args['status']) ) {
            $params['status'] = $args['status'];
        }        

        // Save the error
        $updated = $CI->base_model->update('transactions', array(
            'transaction_id' => $transaction_id,
            'user_id' => $user_id,
        ),
            $params
        );

        // Verify if the invoices generation is enabled
        if ( get_invoices_option('enable_invoices_generation', 'default') ) {

            // Get the invoice body
            $invoice = get_template_field('template_body', 'default');

            // Verify if the invoice's template exists
            if ( $invoice ) {

                // Get template's title
                $template_title = get_template_field('template_title', 'default');

                // Add transaction's ID
                $invoice = str_replace('[transaction_id]', $transaction_id, htmlspecialchars_decode($invoice));
                $template_title = str_replace('[transaction_id]', $transaction_id, $template_title);
                
                // Add date
                $invoice = str_replace('[date]', date('d/m/Y'), $invoice);
                $template_title = str_replace('[date]', date('d/m/Y'), $template_title);

                // Use the base model to get the user's data
                $get_user_data = $CI->base_model->the_data_where(
                    'users',
                    "users.*,
                    (SELECT meta_value FROM users_meta WHERE `meta_name`='country' AND `user_id` = '$user_id') country,
                    (SELECT meta_value FROM users_meta WHERE `meta_name`='city' AND `user_id` = '$user_id') city,
                    (SELECT meta_value FROM users_meta WHERE `meta_name`='address' AND `user_id` = '$user_id') address",
                    array(
                        'users.user_id' => $user_id
                    )
                );

                // Verify if user's data exists
                if ( $get_user_data ) {

                    // Now should be replaced the placeholders
                    $invoice = str_replace('[username]', $get_user_data[0]['username'], $invoice);
                    $invoice = str_replace('[first_name]', $get_user_data[0]['first_name'], $invoice);
                    $invoice = str_replace('[last_name]', $get_user_data[0]['last_name'], $invoice);
                    $invoice = str_replace('[country]', $get_user_data[0]['country'], $invoice);
                    $invoice = str_replace('[city]', $get_user_data[0]['city'], $invoice);
                    $invoice = str_replace('[address]', $get_user_data[0]['address'], $invoice);
                    $invoice = str_replace('[email]', $get_user_data[0]['email'], $invoice);
                    $template_title = str_replace('[username]', $get_user_data[0]['username'], $template_title);
                    $template_title = str_replace('[first_name]', $get_user_data[0]['first_name'], $template_title);
                    $template_title = str_replace('[last_name]', $get_user_data[0]['last_name'], $template_title);
                    $template_title = str_replace('[country]', $get_user_data[0]['country'], $template_title);
                    $template_title = str_replace('[city]', $get_user_data[0]['city'], $template_title);
                    $template_title = str_replace('[address]', $get_user_data[0]['address'], $template_title);
                    $template_title = str_replace('[email]', $get_user_data[0]['email'], $template_title);

                }

                // Use the base model for a simply sql query
                $the_transaction_plan = $CI->base_model->the_data_where(
                    'transactions_options',
                    'plans.*',
                    array(
                        'transactions_options.option_name' => 'plan_id'
                    ),
                    array(),
                    array(),
                    array(array(
                        'table' => 'plans',
                        'condition' => 'transactions_options.option_value=plans.plan_id',
                        'join_from' => 'LEFT'
                    ))
                );

                // Verify if the transaction's plan exists
                if ( $the_transaction_plan ) {

                    // Now should be replaced the placeholders
                    $invoice = str_replace('[plan_name]', $the_transaction_plan[0]['plan_name'], $invoice);
                    $invoice = str_replace('[plan_price]', $the_transaction_plan[0]['plan_price'], $invoice);
                    $invoice = str_replace('[currency_code]', $the_transaction_plan[0]['currency_code'], $invoice);
                    $template_title = str_replace('[plan_name]', $the_transaction_plan[0]['plan_name'], $template_title); 
                    $template_title = str_replace('[plan_price]', $the_transaction_plan[0]['plan_price'], $template_title);
                    $template_title = str_replace('[currency_code]', $the_transaction_plan[0]['currency_code'], $template_title);               

                }

                // Try to find the transaction's fields
                $fields = $CI->base_model->the_data_where('transactions_fields', '*', array('transaction_id' => $transaction_id));
                
                // Verify if the transaction has fields
                if ( $fields ) {

                    // List all fields
                    foreach ( $fields as $field ) {

                        // Replace with fields
                        $invoice = str_replace('{' . $field['field_name'] . '}', $field['field_value'], $invoice);
                        $template_title = str_replace('{' . $field['field_name'] . '}', $field['field_value'], $template_title);

                    }

                }

                // Try to find the transaction
                $get_transaction = $CI->base_model->the_data_where('transactions', 'transactions.*', array('transactions.transaction_id' => $transaction_id));

                // Verify if the transaction exists
                if ( $get_transaction ) {

                    // Set total
                    $invoice = str_replace('[total]', $get_transaction[0]['amount'], $invoice);
                    $template_title = str_replace('[total]', $get_transaction[0]['amount'], $template_title);                    

                    // Get the invoice's taxes
                    $invoice_taxes = get_invoices_option('template_taxes', 'default');   
                    
                    // Verify if taxes exists
                    if ( $invoice_taxes ) {

                        // Calculate the percentage
                        $taxes = ($invoice_taxes / 100) * $get_transaction[0]['amount'];

                        // Set taxes
                        $invoice = str_replace('[taxes]', number_format($taxes, 2), $invoice);
                        $template_title = str_replace('[taxes]', number_format($taxes, 2), $template_title);
                        
                        // Set amount
                        $invoice = str_replace('[amount]', number_format(($get_transaction[0]['amount'] - $taxes), 2), $invoice);
                        $template_title = str_replace('[amount]', number_format(($get_transaction[0]['amount'] - $taxes), 2), $template_title);                         

                    } else {

                        // Set amount
                        $invoice = str_replace('[amount]', $get_transaction[0]['amount'], $invoice);
                        $template_title = str_replace('[amount]', $get_transaction[0]['amount'], $template_title); 

                    }

                }

                // Get all user's options
                $user_options = $CI->base_model->the_data_where('users_meta', '*', array('user_id' => $user_id));

                // Verify if options exists
                if ( $user_options ) {

                    // List all options
                    foreach ( $user_options as $user_option ) {

                        // Set placeholder
                        $invoice = str_replace('[' . $user_option['meta_name'] . ']', $user_option['meta_value'], $invoice);
                        $template_title = str_replace('[' . $user_option['meta_name'] . ']', $user_option['meta_value'], $template_title); 

                    }

                }

                // Create the invoice
                $invoice_data = array(
                    'transaction_id' => $transaction_id,
                    'invoice_date' => date('Y-m-d\TH:i:s.u'),
                    'user_id' => $user_id,
                    'invoice_title' => $template_title,
                    'invoice_text' => $invoice
                );

                // Save the invoice
                $CI->base_model->insert('invoices', $invoice_data);

            }

        }

        // Verify if the transaction was updated
        if ( $updated ) {

            return true;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('create_subscription') ) {
    
    /**
     * The function create_subscription saves a new subscription
     * 
     * @param array $subscription contains the subscribtion
     * 
     * @since 0.0.8.0
     * 
     * @return boolean true or false
     */
    function create_subscription($subscription) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Save user subscription
        md_update_user_option($subscription['user_id'], 'subscription', 1);

        // Try to save the subscription
        if ( $CI->base_model->insert('subscriptions', $subscription) ) {

            return true;

        } else {

            return false;

        }
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_the_js_urls') ) {
    
    /**
     * The function get_the_js_urls gets the js links
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function get_the_js_urls() {

        md_get_the_js_urls();
        
    }
    
}

if ( !function_exists('get_payment_view') ) {
    
    /**
     * The function get_payment_view gets the payment's view
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function get_payment_view() {

        // Verify if view exists
        if ( md_the_data('payment_content_view') ) {

            // Display view
            echo md_the_data('payment_content_view');

        }
        
    }
    
}

if ( !function_exists('get_the_css_urls') ) {
    
    /**
     * The function get_the_css_urls gets the css links
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function get_the_css_urls() {

        md_get_the_css_urls();
        
    }
    
}

if ( !function_exists('md_set_hook') ) {
    
    /**
     * The function md_set_hook registers a hook
     * 
     * @param string $hook_name contains the hook's name
     * @param function $function contains the function to call
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function md_set_hook($hook, $function) {

        md_set_hook($hook, $function);

    }
    
}

if ( !function_exists('run_hook') ) {
    
    /**
     * The function run_hook runs a hook based on hook name
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function run_hook($hook_name, $args) {

        // Run a hook
        md_run_hook($hook_name, $args);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_css_urls') ) {
    
    /**
     * The function set_css_urls sets the css links
     * 
     * @param array $css_url contains the css link parameters
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_css_urls($css_url) {

        md_set_css_urls($css_url);
        
    }
    
}

if ( !function_exists('set_js_urls') ) {
    
    /**
     * The function set_js_urls sets the js links
     * 
     * @param array $js_url contains the js link parameters
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_js_urls($js_url) {

        md_set_js_urls($js_url);
        
    }
    
}

if ( !function_exists('set_the_title') ) {
    
    /**
     * The function set_the_title sets the page's title
     * 
     * @param string $title contains the title
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_the_title($title) {

        md_set_the_title($title);
        
    }
    
}

if ( !function_exists('set_payment_view') ) {
    
    /**
     * The function set_payment_view sets the payment's view
     * 
     * @param array $view contains the view parameters
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_payment_view($view) {

        // Set content view
        md_set_data('payment_content_view', $view);
        
    }
    
}

if ( !function_exists('set_gateway') ) {
    
    /**
     * The function set_gateway adds user's gateways
     * 
     * @param string $gateway_slug contains the gateway's slug
     * @param array $args contains the gateway's arguments
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_gateway($gateway_slug, $args) {

        // Set payments gateway
        md_set_gateway($gateway_slug, $args);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| REGISTER DEFAULT HOOKS
|--------------------------------------------------------------------------
*/