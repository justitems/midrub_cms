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
    'stripe',
    array(
        'gateway_name' => $CI->lang->line('stripe'),
        'gateway_icon' => '<i class="fab fa-cc-stripe"></i>',
        'gateway_color' => '#6772e5',
        'fields' => array (

            array(
                'field_slug' => 'gateway_stripe_enabled',
                'field_type' => 'checkbox',
                'field_words' => array(
                    'field_title' => $CI->lang->line('paypal_enable'),
                    'field_description' => $CI->lang->line('paypal_enable_description')
                ),
                'field_params' => array(
                    'checked' => md_the_option('gateway_stripe_enabled')?md_the_option('gateway_stripe_enabled'):0
                )

            ),
            array(
                'field_slug' => 'stripe_secret_key',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('stripe_secret_key'),
                    'field_description' => $CI->lang->line('stripe_secret_key_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('stripe_enter_secret_key'),
                    'value' => md_the_option('stripe_secret_key')?md_the_option('stripe_secret_key'):'',
                    'disabled' => false
                )

            ),
            array(
                'field_slug' => 'stripe_public_key',
                'field_type' => 'text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('stripe_public_key'),
                    'field_description' => $CI->lang->line('stripe_public_key_description')
                ),
                'field_params' => array(
                    'placeholder' => $CI->lang->line('stripe_enter_public_key'),
                    'value' => md_the_option('stripe_public_key')?md_the_option('stripe_public_key'):'',
                    'disabled' => false
                )

            )
            
        )

    )

);