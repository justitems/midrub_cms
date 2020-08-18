<?php
/**
 * User Helpers
 *
 * This file contains the class User
 * with methods to manage the user confirmation methods
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Confirmation\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Email as MidrubBaseClassesEmail;

/*
 * User class provides the methods to manage the user confirmation methods
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
     * The public method change_email changes the user email
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function change_email() {

        // Get user session
        $user_session = md_the_user_session();

        // Verify if session exists
        if ( isset($user_session['user_id']) ) {

            // Check if data was submitted
            if ($this->CI->input->post()) {

                // Add form validation
                $this->CI->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

                // Get received data
                $email = $this->CI->input->post('email');

                // Check form validation
                if ($this->CI->form_validation->run() === false) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_confirmation_wrong_email')
                    );

                    echo json_encode($data);

                } else {

                    if ( $email === $user_session['email'] ) {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_confirmation_please_enter_different_email')
                        );

                        echo json_encode($data);
                        exit();

                    } else {

                        // Get user's email
                        $get_email = $this->CI->base_model->get_data_where(

                            'users',
                            'email',

                            array(
                                'email' => $email
                            )

                        );

                        if ( $get_email ) {

                            // Display error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('auth_confirmation_another_user_has_email')
                            );

                            echo json_encode($data);
                            exit();                         

                        }

                        // Get member's email
                        $get_member_email = $this->CI->base_model->get_data_where(

                            'teams',
                            'member_email',

                            array(
                                'member_email' => $email
                            )

                        );

                        if ( $get_member_email ) {

                            // Display error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('auth_confirmation_another_team_member_has_email')
                            );

                            echo json_encode($data);
                            exit();                         

                        }

                        // Try to save email
                        $save_email = $this->CI->base_model->update_ceil('users', array('user_id' => $user_session['user_id']), array('email' => $email));

                        if ( $save_email ) {

                            // Load Notifications Model
                            $this->CI->load->model('notifications');

                            // Create activation code
                            $activate = time();

                            // Save activation code in user's data from database
                            $add_activate = $this->CI->base_model->update_ceil('users', array('user_id' => $user_session['user_id']), array('activate' => $activate));

                            // Prepare notification
                            $notification_args = array(
                                '[username]' => $user_session['username'],
                                '[site_name]' => $this->CI->config->item('site_name'),
                                '[confirmation_link]' => '<a href="' . base_url() . 'auth/confirmation?code=' . $activate . '&f=' . $user_session['user_id'] . '">' . base_url() . 'auth/confirmation?code=' . $activate . '&f=' . $user_session['user_id'] . '</a>'
                            );

                            // Get the welcome-message-with-confirmation notification template
                            $template = $this->CI->notifications->get_template('welcome-message-with-confirmation', $notification_args);

                            // Verify if notification's template exists
                            if ($template) {

                                // Create email
                                $email_args = array(
                                    'from_name' => $this->CI->config->item('site_name'),
                                    'from_email' => $this->CI->config->item('contact_mail'),
                                    'to_email' => $email,
                                    'subject' => $template['title'],
                                    'body' => $template['body']
                                );

                                // Send notification template
                                if ((new MidrubBaseClassesEmail\Send())->send_mail($email_args)) {

                                    // Display success message
                                    $data = array(
                                        'success' => TRUE,
                                        'message' => $this->CI->lang->line('auth_confirmation_the_email_was_changed')
                                    );

                                    echo json_encode($data);

                                } else {

                                    // Display error message
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('auth_confirmation_the_email_was_changed_but_no_confirmation')
                                    );

                                    echo json_encode($data);
                                }

                                exit();

                            }

                        } else {

                            // Display error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('auth_confirmation_the_email_was_not_changed')
                            );

                            echo json_encode($data);

                        }

                    }

                }
                
            }

        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_confirmation_please_sign_in')
            );

            echo json_encode($data);

        }
        
    }

    /**
     * The public method resend_confirmation_code resends confirmation code
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function resend_confirmation_code() {

        // Get user session
        $user_session = md_the_user_session();

        // Verify if session exists
        if ( isset($user_session['user_id']) ) {

            // Load Notifications Model
            $this->CI->load->model('notifications');

            // Create activation code
            $activate = time();

            if ( is_numeric($user_session['activate']) ) {

                if ( ($user_session['activate'] + 3600) > $activate ) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_confirmation_resend_once_hour')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

            // Save activation code in user's data from database
            $add_activate = $this->CI->base_model->update_ceil('users', array('user_id' => $user_session['user_id']), array('activate' => $activate));

            // Prepare notification
            $notification_args = array(
                '[username]' => $user_session['username'],
                '[site_name]' => $this->CI->config->item('site_name'),
                '[confirmation_link]' => '<a href="' . base_url() . 'auth/confirmation?code=' . $activate . '&f=' . $user_session['user_id'] . '">' . base_url() . 'auth/confirmation?code=' . $activate . '&f=' . $user_session['user_id'] . '</a>'
            );

            // Get the welcome-message-with-confirmation notification template
            $template = $this->CI->notifications->get_template('welcome-message-with-confirmation', $notification_args);

            // Verify if notification's template exists
            if ($template) {

                // Create email
                $email_args = array(
                    'from_name' => $this->CI->config->item('site_name'),
                    'from_email' => $this->CI->config->item('contact_mail'),
                    'to_email' => $user_session['email'],
                    'subject' => $template['title'],
                    'body' => $template['body']
                );

                // Send notification template
                if ((new MidrubBaseClassesEmail\Send())->send_mail($email_args)) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('auth_confirmation_the_confirmation_code_was_sent')
                    );

                    echo json_encode($data);
                    
                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_confirmation_the_confirmation_code_was_not_sent')
                    );

                    echo json_encode($data);

                }

            }

        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_confirmation_please_sign_in')
            );

            echo json_encode($data);

        }
        
    }

}

/* End of file user.php */