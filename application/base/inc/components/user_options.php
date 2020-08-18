<?php
/**
 * User Options Inc
 *
 * This file contains the user functions with 
 * options for user's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Components as MidrubBaseClassesComponents;

if ( !function_exists('md_set_user_component_options') ) {
    
    /**
     * The function md_set_user_component_options adds component's options for user
     * 
     * @param string $component_slug contains the component's slug
     * @param array $args contains the component's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_user_component_options($component_slug, $args=array()) {
        
        // Call the user_options class
        $user_options = (new MidrubBaseClassesComponents\User_options);

        // Get codeigniter object instance
        $CI =& get_instance();

        // Verify if component's slug is not null
        if ( $component_slug === $CI->input->get('component', true) ) {

            // Set component's options in the queue
            $user_options->set_options($args);

        // Return component's options


        }
        
    }
    
}

if ( !function_exists('md_the_user_component_options') ) {
    
    /**
     * The function md_the_user_component_options gets the component's options
     * 
     * @since 0.0.7.9
     * 
     * @return array with component's options or boolean false
     */
    function md_the_user_component_options() {

        // Call the user_options class
        $user_options = (new MidrubBaseClassesComponents\User_options);

        // Return component's options
        return $user_options->load_options();
        
    }
    
}

if ( !function_exists('md_get_user_component_options') ) {
    
    /**
     * The function md_get_user_component_options generates component's options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_user_component_options() {

        // Get component's options
        $component_options = md_the_user_component_options();

        // Verify if component's options exists
        if ( $component_options ) {

            // Lista all options
            foreach ( $component_options as $component_option ) {

                // Verify if class has the method
                if ( method_exists((new MidrubBaseClassesComponents\User_options_templates), $component_option['type']) ) {

                    // Set the method to call
                    $method = $component_option['type'];

                    // Display input
                    echo (new MidrubBaseClassesComponents\User_options_templates)->$method($component_option);
                    
                }

            }

        }
        
    }
    
}

/* End of file user_options.php */