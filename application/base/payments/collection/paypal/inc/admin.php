<?php
/**
 * Admin Pages Functions
 *
 * PHP Version 7.3
 *
 * This files contains the admin's pages
 * methods used in admin -> admin
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Get codeigniter object instance
$CI = &get_instance();

/**
 * The public method md_set_gateway adds the gateway in admin's settings page
 * 
 * @since 0.0.8.1
 */
md_set_gateway(
    'paypal',
    array(
        'gateway_name' => $CI->lang->line('paypal'),
        'gateway_icon' => '<i class="icon-paypal"></i>',
        'gateway_color' => '#0070ba',
        'fields' => array (

            array(
                'field_slug' => 'gateway_paypal_enabled',
                'field_type' => 'checkbox',
                'field_words' => array(
                    'field_title' => $CI->lang->line('paypal_enable'),
                    'field_description' => $CI->lang->line('paypal_enable_description')
                ),
                'field_params' => array(
                    'checked' => md_the_option('gateway_paypal_enabled')?md_the_option('gateway_paypal_enabled'):0
                )

            ),
            array(
                'field_slug' => 'paypal_client_id',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('paypal_client_id'),
                    'field_description' => $CI->lang->line('paypal_client_id_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_client_id'),
                    'value' => md_the_option('paypal_client_id')?md_the_option('paypal_client_id'):'',
                    'disabled' => false
                )

            ),
            array(
                'field_slug' => 'paypal_client_secret',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('paypal_client_secret'),
                    'field_description' => $CI->lang->line('paypal_client_secret_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_client_secret'),
                    'value' => md_the_option('paypal_client_secret')?md_the_option('paypal_client_secret'):'',
                    'disabled' => false
                )

            )
            
        )

    )

);