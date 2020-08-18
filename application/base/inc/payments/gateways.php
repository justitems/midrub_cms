<?php
/**
 * Gateways Inc
 *
 * This file contains the base methods 
 * for the payments gateways
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Payments as MidrubBaseClassesPayments;

if ( !function_exists('md_set_gateway') ) {
    
    /**
     * The function md_set_gateway adds user's gateways
     * 
     * @param string $gateway_slug contains the gateway's slug
     * @param array $args contains the gateway's arguments
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function md_set_gateway($gateway_slug, $args) {
        
        // Call the gateways class
        $gateways = (new MidrubBaseClassesPayments\Gateways);

        // Set user gateway in the queue
        $gateways->set_gateway($gateway_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_gateways') ) {
    
    /**
     * The function md_the_gateways gets the user gateways
     * 
     * @since 0.0.8.0
     * 
     * @return array with user gateways or boolean false
     */
    function md_the_gateways() {
        
        // Call the gateways class
        $gateways = (new MidrubBaseClassesPayments\Gateways);

        // Return user gateways
        return $gateways->load_gateways();
        
    }
    
}

if ( !function_exists('md_get_gateway_fields') ) {
    
    /**
     * The function md_get_gateway_fields generates html for the gateway fields
     * 
     * @param array $fields contains the list with fields
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_gateway_fields($fields = array()) {

        // Verify if fields array is not empty
        if ( $fields ) {

            // Lista all fields
            foreach ( $fields as $field ) {

                // Verify if class has the method
                if ( method_exists((new MidrubBaseClassesPayments\Gateways_options_templates), $field['type']) ) {

                    // Set the method to call
                    $method = $field['type'];

                    // Display input
                    echo (new MidrubBaseClassesPayments\Gateways_options_templates)->$method($field);
                    
                }

            }

        }
        
    }
    
}