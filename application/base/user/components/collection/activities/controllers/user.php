<?php
/**
 * User Controller
 *
 * This file loads the Activities component in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Activities\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the Dashboard app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load language
        $this->CI->lang->load( 'activities_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_ACTIVITIES );
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set the page's title
        set_the_title($this->CI->lang->line('activities'));

        // Set the Activities's styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/components/collection/activities/styles/css/styles.css?ver=' . MIDRUB_BASE_USER_COMPONENTS_ACTIVITIES_VERSION), 'text/css', 'all'));
        
        // Set the Main Activities Js
        set_js_urls(array(base_url('assets/base/user/components/collection/activities/js/activities.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_ACTIVITIES_VERSION)));
        
        // Set views params
        set_user_view(
            $this->CI->load->ext_view(
                MIDRUB_BASE_USER_COMPONENTS_ACTIVITIES . 'views',
                'main',
                array(),
                true
            )
        );
        
    }
    
}

/* End of file user.php */