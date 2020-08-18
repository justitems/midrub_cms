<?php
/**
 * Plans Limits Helper
 *
 * This file contains the class Plans_limits
 * with all app's limits for plans
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Collection\Dashboard\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans_limits class provides the app's limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Plans_limits {
    
    /**
     * Class variables
     *
     * @since 0.0.7.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method get_limits return array with all plan's limits
     * 
     * @since 0.0.7.4
     * 
     * @return array with limits
     */ 
    public function get_limits() {
        
        // Array with all admin's options
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'app_dashboard',
                'title' => $this->CI->lang->line('enable_app'),
                'description' => $this->CI->lang->line('if_is_enabled_plan')
            )
            
        );
        
    }

}

