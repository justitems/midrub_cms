<?php
/**
 * Reset Class
 *
 * This file loads the Reset Class with properties and methods for reset password process
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Classes\Reset;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Email as MidrubBaseClassesEmail;

/*
 * Reset class loads the properties and methods for reset process
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Reset {
    
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

        // Load the Base Users Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_users', 'base_users' );
        
    }

    /**
     * The public method authenticate_user authenticatea a user
     * 
     * @param string $email contains the user's email
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function reset_password($email) {

        // Load Notifications Model
        $this->CI->load->model('notifications');

        // Check if email address exists in database
        if ( $this->CI->base_users->get_user_ceil('email', $email ) ) {

            // Get username by email
            $user = $this->CI->base_model->get_data_where('users', 'user_id, username, status', array('email' => strtolower($email)));

            // Get reset code
            $reset = uniqid();

            // Add update code
            $add_reset = $this->CI->base_model->update_ceil('users', array('email' => $email), array('reset_code' => $reset));

            // Send password reset confirmation email
            if ($add_reset) {

                // Create data to send
                $notification_args = array(
                    '[username]' => $user[0]['username'],
                    '[site_name]' => $this->CI->config->item('site_name'),
                    '[reset_link]' => '<a href="' . base_url() . 'auth/change-password?reset=' . $reset . '&f=' . $user[0]['user_id'] . '">'. base_url() . 'auth/change-password?reset=' . $reset . '&f=' . $user[0]['user_id'] . '</a>',
                    '[login_address]' => '<a href="' . $this->CI->config->item('login_url') . '">' . $this->CI->config->item('login_url') . '</a>',
                    '[site_url]' => '<a href="' . base_url() . '">' . base_url() . '</a>'
                );

                // Get the welcome-message-with-confirmation notification template
                $template = $this->CI->notifications->get_template('password-reset', $notification_args);

                // Check if the template exists
                if ($template) {

                    // Create email
                    $email_args = array(
                        'from_name' => $this->CI->config->item('site_name'),
                        'from_email' => $this->CI->config->item('contact_mail'),
                        'to_email' => $email,
                        'subject' => $template['title'],
                        'body' => $template['body']
                    );

                    // Send template
                    if ( (new MidrubBaseClassesEmail\Send())->send_mail($email_args) ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('auth_password_instructions_was_sent')
                        );

                        echo json_encode($data);

                    } else {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_an_error_occurred')
                        );

                        echo json_encode($data);

                    }

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_an_error_occurred')
                    );

                    echo json_encode($data);

                }

            } else {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_email_password_request_once_24_hours')
                );

                echo json_encode($data);
                
            }

        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_email_address_was_not_found')
            );

            echo json_encode($data);

        }

    } 

}
