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
namespace CmsBase\Auth\Classes\Reset;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the User General Inc
require_once CMS_BASE_USER . 'inc/general.php';

// Define the namespaces to use
use CmsBase\Classes\Email as CmsBaseClassesEmail;

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
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_users', 'base_users' );
        
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
            $user = $this->CI->base_model->the_data_where('users', 'user_id, username, first_name, last_name, status', array('email' => strtolower($email)));

            // Get reset code
            $reset = uniqid();

            // Add update code
            $add_reset = $this->CI->base_model->update_ceil('users', array('email' => $email), array('reset_code' => $reset));

            // Send password reset confirmation email
            if ($add_reset) {

                // Placeholders
                $placeholders = array('[username]', '[first_name]', '[last_name]', '[website_name]', '[reset_url]', '[login_url]', '[website_url]');

                // Get the change password url
                $change_password = md_the_url_by_page_role('change_password') ? md_the_url_by_page_role('change_password') : site_url('auth/change-password');

                // Replacers
                $replacers = array(
                    $user[0]['username'],
                    $user[0]['first_name'],
                    $user[0]['last_name'],
                    $this->CI->config->item('site_name'),
                    $change_password . '?reset=' . $reset . '&f=' . $user[0]['user_id'],
                    md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin'),
                    site_url()
                );

                // Default subject
                $subject = $this->CI->lang->line('auth_password_reset');

                // Default body
                $body = $this->CI->lang->line('auth_password_reset_instructions');

                // Get reset template
                $reset_template = the_admin_notifications_email_template('reset_password_email_template', $this->CI->config->item('language'));

                // Verify if $reset_template exists
                if ( $reset_template ) {

                    // New subject
                    $subject = $reset_template[0]['template_title'];

                    // New body
                    $body = $reset_template[0]['template_body'];

                }

                // Create email
                $email_args = array(
                    'from_name' => $this->CI->config->item('site_name'),
                    'from_email' => $this->CI->config->item('contact_mail'),
                    'to_email' => $email,
                    'subject' => str_replace($placeholders, $replacers, $subject),
                    'body' => str_replace($placeholders, $replacers, $body)
                );

                // Send template
                if ( (new CmsBaseClassesEmail\Send())->send_mail($email_args) ) {

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