<?php
/**
 * User Helpers
 *
 * This file contains the class User
 * with methods to manage the user signup
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Signup\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class provides the methods to manage the user signup
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
     * The public method save_new_user saves a new user
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function save_new_user() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->CI->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->CI->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
            $this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim|required');
            
            // Get received data
            $first_name = $this->CI->input->post('first_name');
            $last_name = $this->CI->input->post('last_name');
            $username = $this->CI->input->post('username');
            $email = $this->CI->input->post('email');
            $password = $this->CI->input->post('password');

            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_signup_invalid_user_data')
                );

                echo json_encode($data);
                exit();

            } else {

                // Require the signup functions file
                require_once MIDRUB_BASE_AUTH . 'inc/signup/signup.php';

                // Prepare data to send
                $args = array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password
                );

                // Try to save user data
                md_auth_save_user_data($args);
                
            }
            
        }
        
    }

}

/* End of file user.php */