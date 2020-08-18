<?php
/**
 * General Options
 *
 * This file contains the class General
 * with all general admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Options;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * General class provides the general admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class General {
    
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
                'name' => 'enable_multilanguage',
                'title' => $this->CI->lang->line('enable_multilanguage'),
                'description' => $this->CI->lang->line('enable_multilanguage_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'disable-tickets',
                'title' => $this->CI->lang->line('disable_tickets'),
                'description' => $this->CI->lang->line('disable_tickets_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'enable-notifications-email',
                'title' => $this->CI->lang->line('send_notifications_by_email'),
                'description' => $this->CI->lang->line('send_notifications_by_email_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'hide_plan_usage',
                'title' => $this->CI->lang->line('hide_plan_usage'),
                'description' => $this->CI->lang->line('hide_plan_usage_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'hide_invoices',
                'title' => $this->CI->lang->line('hide_invoices'),
                'description' => $this->CI->lang->line('hide_invoices_description')
            )
            
        );
        
    }

}

