<?php
/**
 * Admin Options Inc
 *
 * This file contains the admin functions with 
 * options for user's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Components as MidrubBaseClassesComponents;

if ( !function_exists('md_set_admin_component_options') ) {
    
    /**
     * The function md_set_admin_component_options adds component's options for admin
     * 
     * @param array $args contains the component's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_admin_component_options($args) {
        
        // Call the admin_options class
        $admin_options = (new MidrubBaseClassesComponents\Admin_options);

        // Set component's options in the queue
        $admin_options->set_options($args);
        
    }
    
}

if ( !function_exists('md_the_admin_component_options') ) {
    
    /**
     * The function md_the_admin_component_options gets the component's options
     * 
     * @since 0.0.7.9
     * 
     * @return array with component's options or boolean false
     */
    function md_the_admin_component_options() {

        // Call the admin_options class
        $admin_options = (new MidrubBaseClassesComponents\Admin_options);

        // Return component's options
        return $admin_options->load_options();
        
    }
    
}

if ( !function_exists('md_get_admin_component_options') ) {
    
    /**
     * The function md_get_admin_component_options generates component's options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_admin_component_options() {
        
        // Get component's options
        $component_options = md_the_admin_component_options();

        // Verify if component's options exists
        if ( $component_options ) {

            // Lista all options
            foreach ( $component_options as $component_option ) {

                // Verify if class has the method
                if ( method_exists((new MidrubBaseClassesComponents\Admin_options_templates), $component_option['type']) ) {

                    // Set the method to call
                    $method = $component_option['type'];

                    // Display input
                    echo (new MidrubBaseClassesComponents\Admin_options_templates)->$method($component_option);
                    
                }

            }

        }
        
    }
    
}

/* End of file admin_options.php */