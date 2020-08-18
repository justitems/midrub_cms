<?php
/**
 * Invoices Helper
 *
 * This file contains the class Invoices
 * with methods to manage the user's Invoices
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Settings\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Invoices class provides the methods to manage the user's invoices
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Invoices {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Invoices Model
        $this->CI->load->model('invoice');

    }

    /**
     * The public method settings_load_invoices returns user's invoices by page
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function settings_load_invoices() {
        
        // Get page's input
        $page = $this->CI->input->get('page');
        
        // Set the limit
        $limit = 10;
        $page--;
        
        // Now get total number of invoices
        $total = $this->CI->invoice->get_invoices( $page * $limit, $limit, $this->CI->user_id, 0, 0, false );

        // Now get all invoices
        $invoices = $this->CI->invoice->get_invoices( $page * $limit, $limit, $this->CI->user_id, 0, 0, true );

        if ( $invoices ) {

            echo json_encode(array(
                    'success' => TRUE,
                    'invoices' => $invoices,
                    'total' => $total,
                    'page' => ($page + 1),
                    'paid' => $this->CI->lang->line('paid')
                )
            );

        } else {
            
            echo json_encode(array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_invoices_found')
                )
            );
            
        }
        
    }

}

/* End of file invoices.php */