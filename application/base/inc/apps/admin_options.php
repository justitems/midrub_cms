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
use MidrubBase\Classes\Apps as MidrubBaseClassesApps;

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
        $admin_options = (new MidrubBaseClassesApps\Admin_options);
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
        $admin_options = (new MidrubBaseClassesApps\Admin_options);

        // Return app's options
        return $admin_options->load_options();
        
    }
    
}

if ( !function_exists('md_get_admin_app_options') ) {
    
    /**
     * The function md_get_admin_app_options generates app's options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_admin_app_options() {
        
        // Get app's options
        $app_options = md_the_admin_app_options();

        // Verify if app's options exists
        if ( $app_options ) {

            // Lista all options
            foreach ( $app_options as $app_option ) {

                // Verify if class has the method
                if ( method_exists((new MidrubBaseClassesApps\Admin_options_templates), $app_option['type']) ) {

                    // Set the method to call
                    $method = $app_option['type'];

                    // Display input
                    echo (new MidrubBaseClassesApps\Admin_options_templates)->$method($app_option);
                    
                }

            }

        }
        
    }
    
}

/* End of file admin_options.php */