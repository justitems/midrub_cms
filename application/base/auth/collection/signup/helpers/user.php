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

        // Load the component's language files
        $this->CI->lang->load( 'auth_signup', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_SIGNUP);

        // Load Base Auth Social Model
        $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_auth_social', 'base_auth_social');
        
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
            if ( get_option('auth_enable_username_input') ) {
                $this->CI->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
            } else {
                $this->CI->form_validation->set_rules('username', 'Username', 'trim');
            }
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

                // Prepare the error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_signup_invalid_user_data')
                );

                // Display the error message
                echo json_encode($data);
                exit();    

            } else {

                // Verify if user has provided social account
                if ($this->CI->session->userdata('social_account') && $this->CI->session->userdata('social_network')) {

                    // Get user
                    $get_user = $this->CI->base_model->get_data_where(
                        'users_social',
                        '*',
                        array(
                            'network_name' => $this->CI->session->userdata('social_network'),
                            'net_id' => $this->CI->session->userdata('social_account')
                        )
                    );

                    // Verify if the user was found
                    if ( $get_user ) {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_signup_social_account_was_found')
                        );

                        // Display the error message
                        echo json_encode($data);
                        exit();                        

                    }

                }

                // Verify if username is not required
                if ( !get_option('auth_enable_username_input') ) {

                    // Set email as username
                    $username = $email;

                }

                // Require the signup functions file
                require_once MIDRUB_BASE_AUTH . 'inc/signup/signup.php';

                // Prepare data to send
                $args = array(
                    'first_name' => trim($first_name),
                    'last_name' => trim($last_name),
                    'username' => trim($username),
                    'email' => trim($email),
                    'password' => trim($password)
                );

                // Verify if user has selected a plan
                if ($this->CI->session->userdata('selected_plan')) {

                    // Verify if the plan exists and it is public
                    if ( $this->CI->base_model->get_data_where('plans', 'plan_id', array('plan_id' => $this->CI->session->userdata('selected_plan'), 'visible <' => 1)) ) {

                        // Set Plan's ID
                        $args['plan_id'] = $this->CI->session->userdata('selected_plan');

                    }

                }

                // Try to save user data
                md_auth_save_user_data($args);
                
            }
            
        }
        
    }

}

/* End of file user.php */