<?php
/**
 * Users Options
 *
 * This file contains the class Users
 * with all users admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Users class provides the users admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class Users {
    
    /**
     * Class variables
     *
     * @since 0.0.7.6
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.6
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method get_options provides all Admin's general settings
     * 
     * @since 0.0.7.6
     * 
     * @return array with settings
     */ 
    public function get_options() {
        
        // Array with all Admin's general settings
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'enable_registration',
                'title' => $this->CI->lang->line('enable_user_signup'),
                'description' => $this->CI->lang->line('enable_user_signup_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'enable_new_user_notification',
                'title' => $this->CI->lang->line('receive_notification_about_new_users'),
                'description' => $this->CI->lang->line('receive_notification_about_new_users_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'signup_confirm',
                'title' => $this->CI->lang->line('enable_confirmation_email'),
                'description' => $this->CI->lang->line('enable_confirmation_email_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'signup_limit',
                'title' => $this->CI->lang->line('restrict_signup_by_ip'),
                'description' => $this->CI->lang->line('restrict_signup_by_ip_description')
            )
            
        );
        
    }

}

