<?php
/**
 * Admin Options Inc
 *
 * This file contains the admin functions with 
 * options for user's apps
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Apps as CmsBaseClassesApps;

if ( !function_exists('md_set_admin_app_options') ) {
    
    /**
     * The function md_set_admin_app_options adds app's options for admin
     * 
     * @param string $app_slug contains the app's slug
     * @param array $args contains the app's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_admin_app_options($app_slug, $args = array()) {

        // Call the admin_options class
        $admin_options = (new CmsBaseClassesApps\Admin_options);
            // Get codeigniter object instance
            $CI =& get_instance();

        // If args missing hide
        if ( $args ) {
        
            // Verify if app's slug is not null
            if ( $app_slug === $CI->input->get('app', true) ) {

                // Set app's options in the queue
                $admin_options->set_options($args);

            }

        }
        
    }
    
}

if ( !function_exists('md_the_admin_app_options') ) {
    
    /**
     * The function md_the_admin_app_options gets the app's options
     * 
     * @since 0.0.7.9
     * 
     * @return array with app's options or boolean false
     */
    function md_the_admin_app_options() {

        // Call the admin_options class
        $admin_options = (new CmsBaseClassesApps\Admin_options);

        // Return app's options
        return $admin_options->load_options();
        
    }
    
}

/* End of file admin_options.php */