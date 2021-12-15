<?php
/**
 * Signup Class
 *
 * This file loads the Signup Class with properties and methods for signup process
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Classes\Signup;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the User General Inc
require_once CMS_BASE_USER . 'inc/general.php';

// Define the namespaces to use
use CmsBase\Classes\Email as CmsBaseClassesEmail;

/*
 * Signup class loads the properties and methods for signup process
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Signup {
    
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

        // Load Base Plans Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );

        // Load the bcrypt library
        $this->CI->load->library('bcrypt');
        
    }

    /**
     * The public method save_user_data saves user data
     * 
     * @param array $args contains the user information
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function save_user_data($args) {

        // Verify if data is correct
        if ( !isset($args['username']) || !isset($args['email']) || !isset($args['password']) ) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_invalid_value')
            );

            echo json_encode($data);
            exit();

        }

        // Check if the password has less than six characters
        if ( (strlen($args['username']) < 6) || (strlen($args['password']) < 6) ) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_username_or_password_too_short')
            );

            echo json_encode($data);
            
        } else if ( strlen($args['password']) > 20 ) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_password_to_short_or_long')
            );

            echo json_encode($data);
            

        } elseif (preg_match('/\s/', $args['username']) || preg_match('/\s/', $args['password'])) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_usename_password_without_white_spaces')
            );

            echo json_encode($data);

        } elseif ($this->CI->base_users->get_user_ceil('email', $args['email'])) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_email_was_found_in_the_database')
            );

            echo json_encode($data);

        } elseif ($this->CI->base_users->get_user_ceil('username', $args['username'])) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_username_already_in_use')
            );

            echo json_encode($data);
            
        } else {

            // Create $user_args array
            $user_args = array();

            // Set the user name
            $user_args['username'] = $args['username'];

            // Set the email
            $user_args['email'] = $args['email'];

            // Set the password
            $user_args['password'] = $this->CI->bcrypt->hash_password($args['password']);

            // Verify if role exists
            if ( isset($args['role']) ) {

                // Set the role
                $user_args['role'] = $args['role'];

            } else {

                // Set the default role
                $user_args['role'] = 0;

            }

            // Verify if first name exists
            if ( isset($args['first_name']) ) {

                // Set first name
                $user_args['first_name'] = $args['first_name'];

            }

            // Verify if last name exists
            if ( isset($args['last_name']) ) {

                // Set last name
                $user_args['last_name'] = $args['last_name'];

            }

            // Verify if user should confirm his signup
            if ( md_the_option('signup_confirm') AND !isset($args['status']) ) {
            
                // Set the status
                $user_args['status'] = 0;
                
            } else {

                // Set the default status
                $user_args['status'] = 1;                

            }

            // Set date when user joined
            $user_args['date_joined'] = date('Y-m-d H:i:s');

            // Set user's ip
            $user_args['ip_address'] = $this->CI->input->ip_address();

            // Save the user
            $user_id = $this->CI->base_model->insert('users', $user_args);

            // Verify if user has signed up successfully
            if ( $user_id ) {

                // Default plan's id
                $plan_id = 1;

                // Verify if user has selected a plan
                if (isset($args['plan_id'])) {

                    // Get plan's data
                    $plan_data = $this->CI->base_plans->get_plan($args['plan_id']);

                    // Verify if plan exists
                    if ($plan_data) {

                        // Set selected plan_id
                        $plan_id = $args['plan_id'];

                        // Set the user plan
                        $this->CI->base_plans->change_plan($plan_id, $user_id);

                    }

                } else {

                    // Get plan's data
                    $plan_data = $this->CI->base_plans->get_plan($plan_id);

                }

                // Verify if user has a paid plan
                if ( (int)$plan_data[0]['plan_price'] && !$plan_data[0]['trial'] ) {

                    // Set non paid data for the user
                    md_update_user_option($user_id, 'nonpaid', 1);

                }

                // Verify if the user has a referrer
                if ( $this->CI->session->userdata('referrer') ) {
                        
                    // Get referrer
                    $referrer = base64_decode( $this->CI->session->userdata('referrer') );
                    
                    // Verify if referrer is valid
                    if ( is_numeric( $referrer ) ) {
                        
                        // Load Referrals Model
                        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_referrals', 'base_referrals' );
                        
                        // Save referral
                        $this->CI->base_referrals->save_referrals($referrer, $user_id, $plan_id);
                        
                        // Delete session
                        $this->CI->session->unset_userdata('referrer');
                        
                    }
                    
                }

                // Set first name
                $first_name = isset($args['first_name'])?$args['first_name']:'';
    
                // Set last name
                $last_name = isset($args['last_name'])?$args['last_name']:'';                

                // Verify if the administrator wants to receive a notification about new users
                if ( md_the_option('enable_new_user_notification') ) {

                    // Placeholders
                    $placeholders = array('[username]', '[first_name]', '[last_name]', '[login_url]');

                    // Replacers
                    $replacers = array(
                        $args['username'],
                        $first_name,
                        $last_name,
                        md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin')
                    );

                    // Default subject
                    $subject = $this->CI->lang->line('auth_signup_new_user_notification_title');

                    // Default body
                    $body = $this->CI->lang->line('auth_signup_new_user_notification_content');

                    // Get welcome template
                    $reset_template = the_admin_notifications_email_template('signup_new_user_notification', $this->CI->config->item('language'));

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
                        'to_email' => $this->CI->config->item('notification_mail'),
                        'subject' => str_replace($placeholders, $replacers, $subject),
                        'body' => str_replace($placeholders, $replacers, $body)
                    );

                    // Send notification template
                    (new CmsBaseClassesEmail\Send())->send_mail($email_args);

                }

                // Verify if user has provided social account
                if ($this->CI->session->userdata('social_account') && $this->CI->session->userdata('social_network')) {

                    // Create social params
                    $social_params = array(
                        'user_id' => $user_id,
                        'network_name' => $this->CI->session->userdata('social_network'),
                        'net_id' => $this->CI->session->userdata('social_account'),
                        'created' => time()
                    );

                    // Save the social params
                    $this->CI->base_model->insert('users_social', $social_params);

                }

                // Metas container
                $metas = array(
                    array(
                        'meta_name' => 'event_scope',
                        'meta_value' => $user_id
                    ),
                    array(
                        'meta_name' => 'title',
                        'meta_value' => $first_name . ' ' . $last_name . ' ' . $this->CI->lang->line('auth_has_been_joined')
                    ),
                    array(
                        'meta_name' => 'font_icon',
                        'meta_value' => 'member_add'
                    )
                    
                );

                // Create the event
                md_create_admin_dashboard_event(
                    array(
                        'event_type' => 'new_member',
                        'metas' => $metas
                    )

                );

                // Check if sign up need confirm
                if ( md_the_option('signup_confirm') ) {

                    // Create activation code
                    $activate = time();

                    // Save activation code in user's data from database
                    $add_activate = $this->CI->base_model->update( 'users', array('email' => $args['email']), array('activate' => $activate) );

                    // Verify if the activation code was saved
                    if ( !$add_activate ) {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_signup_success_but_no_confirmation_sent')
                        );

                        echo json_encode($data);
                        exit();

                    }

                    // Placeholders
                    $placeholders = array('[username]', '[first_name]', '[last_name]', '[website_name]', '[confirmation_url]', '[login_url]', '[website_url]');

                    // Get the confirmation url
                    $confirmation = md_the_url_by_page_role('confirmation') ? md_the_url_by_page_role('confirmation') : site_url('auth/confirmation');

                    // Replacers
                    $replacers = array(
                        $args['username'],
                        $first_name,
                        $last_name,
                        $this->CI->config->item('site_name'),
                        $confirmation . '?code=' . $activate . '&f=' . $user_id,
                        md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin'),
                        site_url()
                    );

                    // Default subject
                    $subject = $this->CI->lang->line('auth_welcome_confirmation_title');

                    // Default body
                    $body = $this->CI->lang->line('auth_welcome_confirmation_content');

                    // Get welcome template
                    $reset_template = the_admin_notifications_email_template('signup_welcome_confirmation', $this->CI->config->item('language'));

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
                        'to_email' => $args['email'],
                        'subject' => str_replace($placeholders, $replacers, $subject),
                        'body' => str_replace($placeholders, $replacers, $body)
                    );

                    // Send notification template
                    if ( (new CmsBaseClassesEmail\Send())->send_mail($email_args) ) {

                        // Default redirect
                        $redirect = $this->get_plan_redirect($user_id);

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('auth_signup_success_signup_confirmation'),
                            'redirect' => $redirect
                        );

                        echo json_encode($data);

                    } else {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_signup_success_but_no_confirmation_sent')
                        );

                        echo json_encode($data);

                    }

                } else {

                    // Default redirect
                    $redirect = $this->get_plan_redirect($user_id);

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('auth_signup_success_signup'),
                        'redirect' => $redirect
                    );

                    // Display the success message
                    echo json_encode($data);

                    // Placeholders
                    $placeholders = array('[username]', '[first_name]', '[last_name]', '[website_name]', '[login_url]', '[website_url]');

                    // Replacers
                    $replacers = array(
                        $args['username'],
                        $first_name,
                        $last_name,
                        $this->CI->config->item('site_name'),
                        md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin'),
                        site_url()
                    );

                    // Default subject
                    $subject = $this->CI->lang->line('auth_welcome_no_confirmation_title');

                    // Default body
                    $body = $this->CI->lang->line('auth_welcome_no_confirmation_content');

                    // Get welcome template
                    $reset_template = the_admin_notifications_email_template('signup_welcome_no_confirmation', $this->CI->config->item('language'));

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
                        'to_email' => $args['email'],
                        'subject' => str_replace($placeholders, $replacers, $subject),
                        'body' => str_replace($placeholders, $replacers, $body)
                    );

                    // Send notification template
                    (new CmsBaseClassesEmail\Send())->send_mail($email_args);

                }

            } else {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_signup_failed_signup')
                );

                echo json_encode($data);
                
            }

        }

    }

    /**
     * The private method get_plan_redirect gets redirect for the user plan
     * 
     * @param integer $user_id contains the user's id
     * 
     * @since 0.0.8.2
     * 
     * @return string with redirect's url
     */
    private function get_plan_redirect($user_id) {

        // Redirect url
        $redirect_url = md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin');

        // Return the redirect
        return $redirect_url;
        
    }

}
