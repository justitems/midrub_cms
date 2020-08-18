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
 * The public method md_set_admin_page adds a admin's page in the admin panel
 * 
 * @since 0.0.8.0
 */
md_set_admin_page(
    'transactions',
    array(
        'page_name' => $CI->lang->line('admin_transactions'),
        'page_icon' => '<i class="fas fa-file-invoice-dollar"></i>',
        'content' => 'md_get_admin_page_transactions',
        'css_urls' => array(),
        'js_urls' => array(
            array(base_url('assets/base/admin/collection/admin/js/transactions.js?ver=' . MIDRUB_BASE_ADMIN_ADMIN_VERSION))
        )  
    )
);

if ( !function_exists('md_get_admin_page_transactions') ) {

    /**
     * The function md_get_admin_page_transactions displays the transactions page
     * 
     * @return void
     */
    function md_get_admin_page_transactions() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if transactions single exists
        if ( $CI->input->get('transaction', true) ) {

            // Require the Transactions Inc
            require_once MIDRUB_BASE_ADMIN_ADMIN . 'inc/transactions.php';

            // Set styles
            md_set_css_urls(array('stylesheet', base_url('assets/base/admin/collection/admin/styles/css/transactions.css?ver=' . MIDRUB_BASE_ADMIN_ADMIN_VERSION), 'text/css', 'all'));

            // Include transaction view for admin
            md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/transaction.php');

        } else {

            // Include transactions view for admin
            md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/transactions.php');

        }
        
    }

}

/**
 * The public method md_set_admin_page adds a admin's page in the admin panel
 * 
 * @since 0.0.8.0
 */
md_set_admin_page(
    'invoices',
    array(
        'page_name' => $CI->lang->line('admin_invoices'),
        'page_icon' => '<i class="fas fa-file-invoice"></i>',
        'content' => 'md_get_admin_page_invoices',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('md_get_admin_page_invoices') ) {

    /**
     * The function md_get_admin_page_invoices displays the invoices page
     * 
     * @return void
     */
    function md_get_admin_page_invoices() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Require the Invoices Inc
        require_once MIDRUB_BASE_ADMIN_ADMIN . 'inc/invoices.php';

        // Verify if invoice template exists
        if ( $CI->input->get('template', true) ) {

            // Settings Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/collection/admin/js/invoices-settings.js?ver=' . MIDRUB_BASE_ADMIN_ADMIN_VERSION)));

            // Include invoice template view for admin
            md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/invoices/template.php');

        } else if ( $CI->input->get('faq', true) ) {

            // Faq Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/collection/admin/js/invoices-faq.js?ver=' . MIDRUB_BASE_ADMIN_ADMIN_VERSION)));

            // Include faq for the invoice template
            md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/invoices/faq.php');

        } else {

            // Main Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/collection/admin/js/invoices.js?ver=' . MIDRUB_BASE_ADMIN_ADMIN_VERSION)));

            // Include invoices view for admin
            md_include_component_file(MIDRUB_BASE_ADMIN_ADMIN . 'views/invoices.php');

        }
        
    }

}