<?php
/**
 * Transactions Helper
 *
 * This file contains the class Transactions
 * with methods to manage the payments transactions
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Transactions class provides the methods to manage the payments transactions
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
*/
class Transactions {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method load_payments_transactions loads payments transactions
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function load_payments_transactions() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('member_id', 'Member ID', 'trim|numeric|required');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $member_id = $this->CI->input->post('member_id');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;
                $page--;

                // Use the base model for a simply sql query
                $get_transactions = $this->CI->base_model->the_data_where('transactions', '*',
                array(
                    'user_id' => $member_id
                ),
                array(),
                array(),
                array(),
                array(
                    'order_by' => array('transaction_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if transactions exists
                if ( $get_transactions ) {

                    // Get total number of transactions with base model
                    $total = $this->CI->base_model->the_data_where('transactions', 'COUNT(transaction_id) AS total',
                    array(
                        'user_id' => $member_id
                    ),
                    array(),
                    array());

                    // Display transactions
                    $data = array(
                        'success' => TRUE,
                        'transactions' => $get_transactions,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'success' => $this->CI->lang->line('members_success'),
                            'incomplete' => $this->CI->lang->line('members_incomplete'),
                            'error' => $this->CI->lang->line('members_error'),
                            'delete' => $this->CI->lang->line('members_delete'),
                            'of' => $this->CI->lang->line('members_of'),
                            'results' => $this->CI->lang->line('members_results')
                        )
                    );

                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('members_no_data_found_to_show')
        );

        echo json_encode($data);
        
    }

}

/* End of file transactions.php */