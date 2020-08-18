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

            array (
                'type' => 'checkbox_input',
                'slug' => 'paypal',
                'label' => $CI->lang->line('paypal_enable'),
                'label_description' => $CI->lang->line('paypal_enable_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'paypal_client_id',
                'label' => $CI->lang->line('paypal_client_id'),
                'label_description' => $CI->lang->line('paypal_client_id_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'paypal_client_secret',
                'label' => $CI->lang->line('paypal_client_secret'),
                'label_description' => $CI->lang->line('paypal_client_secret_description')
            )
            
        )

    )

);