<?php
/**
 * Code Helper
 *
 * This file contains the class Code
 * with methods to process the coupon codes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Upgrade\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Code class provides the methods to process the coupon codes
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
*/
class Code {
    
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
     * The public method verify_coupon verifies if a coupon code is valid
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function verify_coupon() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('code', 'Code', 'trim');

            // Get data
            $code = $this->CI->input->post('code');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('upgrade_coupon_code_missing')
                );

                echo json_encode($data);

            } else {
                
                // Get coupon code
                $coupon_code = $this->CI->base_model->get_data_where('coupons', '*', array('code' => $code));
                
                // Verify if the coupon code exists
                if ( $coupon_code ) {

                    // Verify if the coupon code could be used only once and was used 1
                    if ( ($coupon_code[0]['type'] > 0) && ($coupon_code[0]['count'] > 0) ) {

                        // Prepare the response
                        $response = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('upgrade_coupon_code_is_not_valid')
                        );
                        
                        // Display response
                        echo json_encode( $response );   

                    } else {

                        // Set transaction's discount'
                        $this->CI->session->set_flashdata('transaction_discount', array(
                            'discount_value' => $coupon_code[0]['value'],
                            'discount_code' => $code
                        ));

                        // Prepare the response
                        $response = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('upgrade_coupon_code_is_valid'),
                            'value' => $coupon_code[0]['value'],
                            'words' => array(
                                'discount' => $this->CI->lang->line('upgrade_discount')
                            )
                        );
                        
                        // Display response
                        echo json_encode( $response );

                    }
                    
                } else {

                    // Prepare the response
                    $response = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('upgrade_coupon_code_is_not_valid')
                    );
                    
                    // Display response
                    echo json_encode( $response );            

                }
                
            }
            
        }
        
    }

}

/* End of file code.php */