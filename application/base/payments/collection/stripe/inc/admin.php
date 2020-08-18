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

            array (
                'type' => 'checkbox_input',
                'slug' => 'stripe',
                'label' => $CI->lang->line('stripe_enable'),
                'label_description' => $CI->lang->line('stripe_enable_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'stripe_secret_key',
                'label' => $CI->lang->line('stripe_secret_key'),
                'label_description' => $CI->lang->line('stripe_secret_key_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'stripe_public_key',
                'label' => $CI->lang->line('stripe_public_key'),
                'label_description' => $CI->lang->line('stripe_public_key_description')
            )
            
        )

    )

);