<?php
/**
 * Ajax Controller
 *
 * This file processes the Admin's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Admin\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Admin\Helpers as CmsBaseAdminComponentsCollectionAdminHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method load_payments_transactions loads payments transactions
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function load_payments_transactions() {
        
        // Get transactions
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Transactions)->load_payments_transactions();
        
    }

    /**
     * The public method delete_transaction deletes transaction by transaction's id
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_transaction() {
        
        // Delete transaction
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Transactions)->delete_transaction();
        
    } 
    
    /**
     * The public method delete_transactions deletes transactions by transactions ids
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_transactions() {
        
        // Delete transactions
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Transactions)->delete_transactions();
        
    } 

    /**
     * The public method change_transaction_status changes the transaction's status
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function change_transaction_status() {
        
        // Change status
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Transactions)->change_transaction_status();
        
    } 

    /**
     * The public method save_invoice_settings saves the invoice's template
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function save_invoice_settings() {
        
        // Save invoice's template
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Invoices)->save_invoice_settings();
        
    }
    
    /**
     * The public method load_payments_invoices loads the invoices
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function load_payments_invoices() {
        
        // Loads invoices by page
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Invoices)->load_payments_invoices();
        
    }

    /**
     * The public method delete_invoice deletes invoice by invoice's id
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_invoice() {
        
        // Delete invoice
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Invoices)->delete_invoice();
        
    } 
    
    /**
     * The public method delete_invoices deletes invoices by invoices ids
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_invoices() {
        
        // Delete invoices
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Invoices)->delete_invoices();
        
    }

    /**
     * The public method enable_theme enables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function enable_theme() {
        
        // Enable theme
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Themes)->enable();
        
    }

    /**
     * The public method disable_theme disables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function disable_theme() {
        
        // Disable theme
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Themes)->disable();
        
    }

    /**
     * The public method upload_theme uploads an theme to be installed
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function upload_theme() {
        
        // Uploads theme
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Themes)->upload_theme();
        
    }

    /**
     * The public method unzipping_theme_zip extract the theme from the zip
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function unzipping_theme_zip() {
        
        // Extract the theme
        (new CmsBaseAdminComponentsCollectionAdminHelpers\Themes)->unzipping_zip();
        
    }

}

/* End of file ajax.php */