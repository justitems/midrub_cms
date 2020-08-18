<?php
/**
 * Transactions Helper
 *
 * This file contains the class Transactions
 * with methods to manage the payments transactions
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Admin\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Transactions class provides the methods to manage the payments transactions
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
*/
class Transactions {
    
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
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $key = $this->CI->input->post('key');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 20;
                $page--;

                // Use the base model for a simply sql query
                $get_transactions = $this->CI->base_model->get_data_where('transactions', '*', array(),
                array(),
                array('transaction_id' => $this->CI->db->escape_like_str($key)),
                array(),
                array(
                    'order' => array('transaction_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if transactions exists
                if ( $get_transactions ) {

                    // Get total number of transactions with base model
                    $total = $this->CI->base_model->get_data_where('transactions', 'COUNT(transaction_id) AS total', array(),
                    array(),
                    array('transaction_id' => $this->CI->db->escape_like_str($key)));

                    // Display transactions
                    $data = array(
                        'success' => TRUE,
                        'transactions' => $get_transactions,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'success' => $this->CI->lang->line('admin_success'),
                            'incomplete' => $this->CI->lang->line('admin_incomplete'),
                            'error' => $this->CI->lang->line('admin_error'),
                            'delete' => $this->CI->lang->line('admin_delete')
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
            'message' => $this->CI->lang->line('admin_no_data_found_to_show')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method delete_transaction deletes transaction by transaction's id
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function delete_transaction() {
        
        // Get transaction_id's input
        $transaction_id = $this->CI->input->get('transaction_id', TRUE);  

        // Verify if transaction's id exists
        if ( $transaction_id ) {

            // Delete transaction
            $delete = $this->CI->base_model->delete('transactions', array(
                'transaction_id' => $transaction_id
            ));

            // Verify if the transaction was deleted
            if ( $delete ) {

                // Delete transaction's fields
                $this->CI->base_model->delete('transactions_fields', array(
                    'transaction_id' => $transaction_id
                ));

                // Delete transaction's options
                $this->CI->base_model->delete('transactions_options', array(
                    'transaction_id' => $transaction_id
                ));

                // Delete transactions records
                md_run_hook(
                    'delete_transaction',
                    array(
                        'transaction_id' => $transaction_id
                    )
                );

                // Display success message
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('admin_transaction_was_deleted')
                );

                echo json_encode($data);
                exit();

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('admin_transaction_was_not_deleted')
        );

        echo json_encode($data); 

    }

    /**
     * The public method delete_transactions deletes transactions by transactions ids
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function delete_transactions() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('transactions_ids', 'transactions Ids', 'trim');
           
            // Get received data
            $transactions_ids = $this->CI->input->post('transactions_ids');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if transactions ids exists
                if ( $transactions_ids ) {

                    // Ccount number of deleted transactions
                    $count = 0;

                    // List all transactions
                    foreach ( $transactions_ids as $id ) {

                        // Delete transaction
                        if ( $this->CI->base_model->delete('transactions', array(
                            'transaction_id' => $id
                        ) ) ) {

                            // Delete transaction's fields
                            $this->CI->base_model->delete('transactions_fields', array(
                                'transaction_id' => $id
                            ));

                            // Delete transaction's options
                            $this->CI->base_model->delete('transactions_options', array(
                                'transaction_id' => $id
                            ));

                            // Delete transactions records
                            md_run_hook(

                                'delete_transaction',

                                array(
                                    'transaction_id' => $id
                                )

                            );

                            $count++;

                        }

                    }

                    if ( $count > 0 ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('admin_transactions_were_deleted')
                        );

                        echo json_encode($data);
                        exit();

                    }

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('admin_please_select_at_least_one_transaction')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('admin_transactions_were_not_deleted')
        );

        echo json_encode($data); 

    }

}

/* End of file transactions.php */