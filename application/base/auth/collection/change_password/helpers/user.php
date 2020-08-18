<?php
/**
 * User Helpers
 *
 * This file contains the class User
 * with methods to manage the user change password methods
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Change_password\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class provides the methods to manage the user change password methods
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method change_password changes the user password
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function change_password() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('new_password', 'New Password', 'trim|required');
            $this->CI->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim|required');
            $this->CI->form_validation->set_rules('reset_code', 'Reset Code', 'trim|required');
            $this->CI->form_validation->set_rules('user_id', 'User ID', 'trim|numeric|required');
            
            // Get received data
            $new_password = $this->CI->input->post('new_password');
            $repeat_password = $this->CI->input->post('repeat_password');
            $reset_code = $this->CI->input->post('reset_code');
            $user_id = $this->CI->input->post('user_id');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if passwords match
                if ( $new_password !== $repeat_password ) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_change_password_password_does_not_match')
                    );

                    echo json_encode($data);
                    exit();

                } else {

                    // Require the change functions file
                    require_once MIDRUB_BASE_AUTH . 'inc/change/change.php';

                    // Try to change the password
                    md_auth_change_password($user_id, $reset_code, $new_password);
                    exit();

                }
                
            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('auth_change_password_please_enter_valid_password')
        );

        echo json_encode($data);
        
    }

}

/* End of file user.php */