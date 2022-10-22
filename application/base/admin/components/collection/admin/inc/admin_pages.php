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
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
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
        'page_icon' => md_the_admin_icon(array('icon' => 'transactions')),
        'content' => 'md_get_admin_page_transactions',
        'css_urls' => array(),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/admin/js/transactions.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION))
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
            require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'inc/transactions.php';

            // Set styles
            md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/admin/styles/css/transactions.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION), 'text/css', 'all'));

            // Include transaction view for admin
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/transaction.php');

        } else {

            // Include transactions view for admin
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/transactions.php');

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
        'page_icon' => md_the_admin_icon(array('icon' => 'invoices')),
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
        require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'inc/invoices.php';

        // Verify if invoice template exists
        if ( $CI->input->get('template', true) ) {

            // Settings Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/components/collection/admin/js/invoices-settings.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION)));

            // Include invoice template view for admin
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/invoices/template.php');

        } else if ( $CI->input->get('faq', true) ) {

            // Faq Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/components/collection/admin/js/invoices-faq.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION)));

            // Include faq for the invoice template
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/invoices/faq.php');

        } else {

            // Main Invoices Js
            md_set_js_urls(array(base_url('assets/base/admin/components/collection/admin/js/invoices.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION)));

            // Include invoices view for admin
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/invoices.php');

        }
        
    }

}

/**
 * The public method md_set_admin_page adds a admin's page in the admin panel
 * 
 * @since 0.0.8.4
 */
md_set_admin_page(
    'themes',
    array(
        'page_name' => $CI->lang->line('admin_themes'),
        'page_icon' => md_the_admin_icon(array('icon' => 'grid')),
        'content' => 'md_get_admin_page_themes',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/admin/styles/css/themes.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/admin/js/themes.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION))
        )  
    )
);

if ( !function_exists('md_get_admin_page_themes') ) {

    /**
     * The function md_get_admin_page_themes displays the themes page
     * 
     * @return void
     */
    function md_get_admin_page_themes() {

        // Get codeigniter object instance
        $CI = &get_instance();

        if ( $CI->input->get('directory', true) ) {

            // Include themes directory view for user
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/themes_directory.php');

        } else {

            // Require the Admin Themes Inc
            require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'inc/themes.php';

            // Include themes view for administrator
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views/themes.php');

        }
        
    }

}

/* End of file admin_pages.php */