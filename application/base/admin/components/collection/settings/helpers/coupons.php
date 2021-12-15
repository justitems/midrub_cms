<?php
/**
 * Coupons Helpers
 *
 * This file contains the class Coupons
 * with methods to manage the coupons
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Coupons class provides the methods to manage the coupons
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
*/
class Coupons {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method get_coupon_codes gets coupons codes
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function get_coupon_codes() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            
            // Get received data
            $page = $this->CI->input->post('page')?($this->CI->input->post('page') - 1):0;

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;

                // Get the coupons
                $the_coupons = $this->CI->base_model->the_data_where(
                'coupons',
                '*',
                array(),
                array(),
                array(),
                array(),
                array(
                    'order_by' => array('coupon_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if the coupons exists
                if ( $the_coupons ) {

                    // Get total number of coupons with base model
                    $total = $this->CI->base_model->the_data_where('coupons', 'COUNT(coupon_id) AS total');

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'coupons' => $the_coupons,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'results' => $this->CI->lang->line('settings_results'),
                            'of' => $this->CI->lang->line('settings_of'),
                            'delete' => $this->CI->lang->line('settings_delete')
                        )
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_no_coupon_codes_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method delete_coupon_code deletes coupons codes
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function delete_coupon_code() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('code', 'Code', 'trim|numeric|required');
            
            // Get received data
            $code = $this->CI->input->post('code');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Try to delete the coupon codes
                if ( $this->CI->base_model->delete('coupons', array('coupon_id' => $code)) ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('settings_coupon_code_was_deleted')
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_coupon_code_was_not_deleted')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

}

/* End of file coupons.php */