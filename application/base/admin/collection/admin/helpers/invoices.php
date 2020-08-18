<?php
/**
 * Invoices Helper
 *
 * This file contains the class Invoices
 * with methods to manage the invoices
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
 * Invoices class provides the methods to manage the payments Invoices
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
*/
class Invoices {
    
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

        // Load Base Invoices Model
        $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_invoices', 'base_invoices');
        
    }

    /**
     * The public method save_invoice_settings saves invoice settings
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function save_invoice_settings() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('title', 'Title', 'trim');
            $this->CI->form_validation->set_rules('taxes', 'Taxes', 'trim');
            $this->CI->form_validation->set_rules('body', 'Body', 'trim');
            $this->CI->form_validation->set_rules('all_options', 'All Options', 'trim');

            // Get data
            $title = $this->CI->input->post('title', TRUE);
            $taxes = $this->CI->input->post('taxes', TRUE);
            $body = $this->CI->security->xss_clean($this->CI->input->post('body', FALSE));
            $all_options = $this->CI->input->post('all_options', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Delete template
                $this->CI->base_model->delete('invoices_templates', array('template_slug' => 'default'));

                // Delete all template's options
                $this->CI->base_model->delete('invoices_options', array('template_slug' => 'default'));

                // First of all try to update the template
                $template_save = $this->CI->base_invoices->update_invoices_template(trim($title), trim($body), 'default');

                // Verify if the template was saved successfully
                if ( $template_save ) {

                    // If title exists means the template exists
                    if ( $title ) {

                        // Success count
                        $success_count = 0;

                        // Unsuccess count
                        $unsuccess_count = 0;

                        // Verify if options exists
                        if ($all_options) {

                            // List all options
                            foreach ($all_options as $option) {

                                // Verify if data was saved
                                if ($this->CI->base_invoices->save_invoices_option(trim($option[0]), trim($option[1]), 'default')) {
                                    $success_count++;
                                } else {
                                    $unsuccess_count++;
                                }

                            }

                        }

                        // Verify if taxes exists
                        if ( is_numeric($taxes) ) {

                            // Verify if data was saved
                            if ($this->CI->base_invoices->save_invoices_option('template_taxes', trim($taxes), 'default')) {
                                $success_count++;
                            } else {
                                $unsuccess_count++;
                            }
                            
                        }

                        // Verify if some options were not saved
                        if ( $unsuccess_count ) {

                            // Prepare error response
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('admin_changes_were_saved_without_options')
                            );

                            // Display error response
                            echo json_encode($data); 
                            
                        } else {

                            // Prepare success response
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('admin_changes_were_saved')
                            );

                            // Display success response
                            echo json_encode($data); 

                        }


                    } else {

                        // Prepare success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('admin_changes_were_saved')
                        );

                        // Display success response
                        echo json_encode($data); 

                    }
                    
                    exit();
                    
                }

            }

        }

        // Prepare error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('admin_changes_were_not_saved')
        );

        // Display error response
        echo json_encode($data);  

    }

    /**
     * The public method load_payments_invoices loads invoices
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function load_payments_invoices() {
        
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
                $get_invoices = $this->CI->base_model->get_data_where('invoices', 'invoices.invoice_id, invoices.invoice_title, users.user_id, users.username',
                array(),
                array(),
                array('users.username' => $this->CI->db->escape_like_str($key)),
                array(array(
                    'table' => 'users',
                    'condition' => 'invoices.user_id=users.user_id',
                    'join_from' => 'LEFT'
                )),
                array(
                    'order' => array('invoices.invoice_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if invoices exists
                if ( $get_invoices ) {

                    // Get total number of invoices with base model
                    $total = $this->CI->base_model->get_data_where('invoices', 'COUNT(invoices.invoice_id) AS total',
                    array(),
                    array(),
                    array('users.username' => $this->CI->db->escape_like_str($key)),
                    array(array(
                        'table' => 'users',
                        'condition' => 'invoices.user_id=users.user_id',
                        'join_from' => 'LEFT'
                    )));

                    // Display invoices
                    $data = array(
                        'success' => TRUE,
                        'invoices' => $get_invoices,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'success' => $this->CI->lang->line('admin_success'),
                            'incomplete' => $this->CI->lang->line('admin_incomplete'),
                            'error' => $this->CI->lang->line('admin_error'),
                            'delete' => $this->CI->lang->line('admin_delete'),
                            'account_deleted' => $this->CI->lang->line('admin_account_deleted')
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
     * The public method delete_invoice deletes invoice by invoice's id
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function delete_invoice() {
        
        // Get invoice_id's input
        $invoice_id = $this->CI->input->get('invoice_id', TRUE);  

        // Verify if invoice's id exists
        if ( $invoice_id ) {

            // Delete invoice
            $delete = $this->CI->base_model->delete('invoices', array(
                'invoice_id' => $invoice_id
            ));

            // Verify if the invoice was deleted
            if ( $delete ) {

                // Delete invoices records
                md_run_hook(
                    'delete_invoice',
                    array(
                        'invoice_id' => $invoice_id
                    )
                );

                // Display success message
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('admin_invoice_was_deleted')
                );

                echo json_encode($data);
                exit();

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('admin_invoice_was_not_deleted')
        );

        echo json_encode($data); 

    }

    /**
     * The public method delete_invoices deletes invoices by invoices ids
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function delete_invoices() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('invoices_ids', 'invoices Ids', 'trim');
           
            // Get received data
            $invoices_ids = $this->CI->input->post('invoices_ids');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if invoices ids exists
                if ( $invoices_ids ) {

                    // Ccount number of deleted invoices
                    $count = 0;

                    // List all invoices
                    foreach ( $invoices_ids as $id ) {

                        // Delete invoice
                        if ( $this->CI->base_model->delete('invoices', array(
                            'invoice_id' => $id
                        ) ) ) {

                            // Delete invoices records
                            md_run_hook(

                                'delete_invoice',

                                array(
                                    'invoice_id' => $id
                                )

                            );

                            $count++;

                        }

                    }

                    if ( $count > 0 ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('admin_invoices_were_deleted')
                        );

                        echo json_encode($data);
                        exit();

                    }

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('admin_please_select_at_least_one_invoice')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('admin_invoices_were_not_deleted')
        );

        echo json_encode($data); 

    }


}

/* End of file invoices.php */