<?php
/**
 * Smtp Options
 *
 * This file contains the class Smtp
 * with all smtp admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Smtp class provides the smtp admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class Smtp {
    
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
                'name' => 'smtp-enable',
                'title' => $this->CI->lang->line('enable_smtp'),
                'description' => $this->CI->lang->line('enable_smtp_description')
            ), array (
                'type' => 'text',
                'name' => 'smtp-protocol',
                'title' => $this->CI->lang->line('smtp_protocol'),
                'description' => $this->CI->lang->line('smtp_protocol_description')
            ), array (
                'type' => 'text',
                'name' => 'smtp-host',
                'title' => $this->CI->lang->line('smtp_host'),
                'description' => $this->CI->lang->line('smtp_host_description')
            ), array (
                'type' => 'text',
                'name' => 'smtp-port',
                'title' => $this->CI->lang->line('smtp_port'),
                'description' => $this->CI->lang->line('smtp_port_description')
            ), array (
                'type' => 'text',
                'name' => 'smtp-username',
                'title' => $this->CI->lang->line('smtp_username'),
                'description' => $this->CI->lang->line('smtp_username_description')
            ), array (
                'type' => 'text',
                'name' => 'smtp-password',
                'title' => $this->CI->lang->line('smtp_password'),
                'description' => $this->CI->lang->line('smtp_password_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'smtp-ssl',
                'title' => $this->CI->lang->line('smtp_ssl'),
                'description' => $this->CI->lang->line('smtp_ssl_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'smtp-tls',
                'title' => $this->CI->lang->line('smtp_tsl'),
                'description' => $this->CI->lang->line('smtp_ssl_description')
            )
            
        );
        
    }

}

