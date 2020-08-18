<?php
/**
 * Advanced Options
 *
 * This file contains the class Advanced
 * with all advanced admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Advanced class provides the advanced admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class Advanced {
    
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
                'type' => 'text',
                'name' => 'upload_limit',
                'title' => $this->CI->lang->line('upload_limit'),
                'description' => $this->CI->lang->line('upload_limit_description'),
                'input_type' => 'number',
                'default_value' => 6
            ), array (
                'type' => 'text',
                'name' => 'tickets_limit',
                'title' => $this->CI->lang->line('users_can_open_ticket'),
                'description' => $this->CI->lang->line('users_can_open_ticket_description'),
                'input_type' => 'number',
                'default_value' => 24
            ), array (
                'type' => 'text',
                'name' => 'rss_process_limit',
                'title' => $this->CI->lang->line('number_rss_feeds_cron'),
                'description' => $this->CI->lang->line('number_rss_feeds_cron_description'),
                'input_type' => 'number',
                'default_value' => 1
            ), array (
                'type' => 'text',
                'name' => 'schedule_interval_limit',
                'title' => $this->CI->lang->line('scheduling_interval_accounts'),
                'description' => $this->CI->lang->line('scheduling_interval_accounts_description'),
                'input_type' => 'number',
                'default_value' => 5
            ), array (
                'type' => 'checkbox',
                'name' => 'user_smtp',
                'title' => $this->CI->lang->line('users_will_use_smtp'),
                'description' => $this->CI->lang->line('users_will_use_smtp_description')
            )
            
        );
        
    }

}

