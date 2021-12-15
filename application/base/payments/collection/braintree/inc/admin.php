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
 * @since 0.0.8.0z
 */
md_set_gateway(
    'braintree',
    array(
        'gateway_name' => $CI->lang->line('braintree'),
        'gateway_icon' => '<i class="fas fa-credit-card"></i>',
        'gateway_color' => '#202020',
        'fields' => array (

            array(
                'field_slug' => 'gateway_braintree_enabled',
                'field_type' => 'checkbox',
                'field_words' => array(
                    'field_title' => $CI->lang->line('braintree_enable'),
                    'field_description' => $CI->lang->line('braintree_enable_description')
                ),
                'field_params' => array(
                    'checked' => md_the_option('gateway_braintree_enabled')?md_the_option('gateway_braintree_enabled'):0
                )

            ),
            array(
                'field_slug' => 'braintree_merchant_id',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('braintree_merchant_id'),
                    'field_description' => $CI->lang->line('braintree_merchant_id_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_merchant'),
                    'value' => md_the_option('braintree_merchant_id')?md_the_option('braintree_merchant_id'):'',
                    'disabled' => false
                )

            ),
            array(
                'field_slug' => 'braintree_merchant_account_id',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('braintree_merchant_account_id'),
                    'field_description' => $CI->lang->line('braintree_merchant_account_id_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_merchant_account_id'),
                    'value' => md_the_option('braintree_merchant_account_id')?md_the_option('braintree_merchant_account_id'):'',
                    'disabled' => false
                )

            ),            
            array(
                'field_slug' => 'braintree_public_key',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('braintree_public_key'),
                    'field_description' => $CI->lang->line('braintree_public_key_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_api_key'),
                    'value' => md_the_option('braintree_public_key')?md_the_option('braintree_public_key'):'',
                    'disabled' => false
                )

            ),
            array(
                'field_slug' => 'braintree_private_key',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('braintree_private_key'),
                    'field_description' => $CI->lang->line('braintree_private_key_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('braintree_enter_api_private_key'),
                    'value' => md_the_option('braintree_private_key')?md_the_option('braintree_private_key'):'',
                    'disabled' => false
                )

            )
            
        )

    )

);