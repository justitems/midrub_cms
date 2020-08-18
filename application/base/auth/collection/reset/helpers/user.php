<?php
/**
 * User Helpers
 *
 * This file contains the class User
 * with methods to manage the user reset methods
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Reset\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class provides the methods to manage the user reset methods
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
     * The public method reset_password resets the user password
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function reset_password() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            
            // Get received data
            $email = $this->CI->input->post('email');

            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_reset_wrong_email')
                );

                echo json_encode($data);
                exit();

            } else {

                // Require the reset functions file
                require_once MIDRUB_BASE_AUTH . 'inc/reset/reset.php';

                // Try to reset the password
                md_auth_reset_password($email);
                
            }
            
        }
        
    }

}

/* End of file user.php */