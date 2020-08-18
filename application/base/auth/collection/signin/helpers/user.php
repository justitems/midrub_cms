<?php
/**
 * User Helpers
 *
 * This file contains the class User
 * with methods to manage the user signin
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Signin\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class provides the methods to manage the user signin
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
     * The public method sign_in registers a user session
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function sign_in() {       
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->CI->form_validation->set_rules('remember', 'Remember', 'trim');
            
            // Get received data
            $email = $this->CI->input->post('email');
            $password = $this->CI->input->post('password');
            $remember = $this->CI->input->post('remember');

            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_signin_the_entered_data_is_wrong')
                );

                echo json_encode($data);
                exit();

            } else {

                // Require the signin functions file
                require_once MIDRUB_BASE_AUTH . 'inc/signin/signin.php';

                // Prepare data to send
                $args = array(
                    'email' => $email,
                    'password' => $password,
                    'remember' => $remember
                );

                // Try to authenticate a user
                md_auth_authenticate_user($args);
                
            }
            
        }
        
    }

}

/* End of file user.php */