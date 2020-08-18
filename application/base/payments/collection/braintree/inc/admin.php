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

            array (
                'type' => 'checkbox_input',
                'slug' => 'braintree',
                'label' => $CI->lang->line('braintree_enable'),
                'label_description' => $CI->lang->line('braintree_enable_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'braintree_merchant_id',
                'label' => $CI->lang->line('braintree_merchant_id'),
                'label_description' => $CI->lang->line('braintree_merchant_id_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'braintree_merchant_account_id',
                'label' => $CI->lang->line('braintree_merchant_account_id'),
                'label_description' => $CI->lang->line('braintree_merchant_account_id_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'braintree_public_key',
                'label' => $CI->lang->line('braintree_public_key'),
                'label_description' => $CI->lang->line('braintree_public_key_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'braintree_private_key',
                'label' => $CI->lang->line('braintree_private_key'),
                'label_description' => $CI->lang->line('braintree_private_key_description')
            )
            
        )

    )

);