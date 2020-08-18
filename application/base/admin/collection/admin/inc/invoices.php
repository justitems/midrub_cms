<?php
/**
 * Invoices Inc
 *
 * PHP Version 7.3
 *
 * This files contains the Invoices Inc file
 * with several functions for invoices
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_invoices', 'base_invoices');

        // Try to find the option's value
        $get_option = $CI->base_invoices->get_invoices_option($option_name, $template_slug);

        // Verify if option exists
        if ( $get_option ) {

            return $get_option;

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
        $CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_invoices', 'base_invoices');

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

if ( !function_exists('md_the_invoice_by_id') ) {

    /**
     * The function md_the_invoice_by_id gets all invoice's data
     * 
     * @param integer $invoice_id has the invoice's ID
     * 
     * @return array with invoice or boolean false
     */
    function md_the_invoice_by_id($invoice_id) {

        // Verify if invoice's id is numeric
        if ( is_numeric($invoice_id) ) {

            // Get codeigniter object instance
            $CI = &get_instance();

            // Try to find the invoice
            $get_invoice = $CI->base_model->get_data_where('invoices', 'invoices.*, users.username', array('invoices.invoice_id' => $invoice_id),
                array(),
                array(),
                array(array(
                    'table' => 'users',
                    'condition' => 'invoices.user_id=users.user_id',
                    'join_from' => 'LEFT'
                ))
            );

            // Verify if the invoice exists
            if ( $get_invoice ) {

                return $get_invoice;

            } else {

                return false;

            }

        } else {

            return false;

        }
        
    }

}