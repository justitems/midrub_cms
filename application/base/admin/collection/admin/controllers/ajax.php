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
namespace MidrubBase\Admin\Collection\Admin\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Admin\Helpers as MidrubBaseAdminCollectionAdminHelpers;

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
        (new MidrubBaseAdminCollectionAdminHelpers\Transactions)->load_payments_transactions();
        
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
        (new MidrubBaseAdminCollectionAdminHelpers\Transactions)->delete_transaction();
        
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
        (new MidrubBaseAdminCollectionAdminHelpers\Transactions)->delete_transactions();
        
    } 

    /**
     * The public method save_invoice_settings saves the invoice's template
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function save_invoice_settings() {
        
        // Save invoice's template
        (new MidrubBaseAdminCollectionAdminHelpers\Invoices)->save_invoice_settings();
        
    }
    
    /**
     * The public method load_payments_invoices loads the invoices
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_payments_invoices() {
        
        // Loads invoices by page
        (new MidrubBaseAdminCollectionAdminHelpers\Invoices)->load_payments_invoices();
        
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
        (new MidrubBaseAdminCollectionAdminHelpers\Invoices)->delete_invoice();
        
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
        (new MidrubBaseAdminCollectionAdminHelpers\Invoices)->delete_invoices();
        
    } 

}

/* End of file ajax.php */