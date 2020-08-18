<?php
/**
 * Api Permissions Inc
 *
 * This file contains the functions with 
 * processed permissions list
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Rest as MidrubBaseClassesRest;

if ( !function_exists('md_set_admin_api_permissions') ) {
    
    /**
     * The function md_set_admin_api_permissions adds api's permissions in the queue
     * 
     * @param array $args contains the api's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_admin_api_permissions($args) {

        // Call the permissions class
        $permissions = (new MidrubBaseClassesRest\Permissions);

        // Set app's permissions in the queue
        $permissions->set_permissions($args);
        
    }
    
}

if ( !function_exists('md_the_admin_api_permissions') ) {
    
    /**
     * The function md_the_admin_api_permissions gets the app's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return array with api's permissions or boolean false
     */
    function md_the_admin_api_permissions() {

        // Call the permissions class
        $permissions = (new MidrubBaseClassesRest\Permissions);

        // Return app's permissions
        return $permissions->load_permissions();
        
    }
    
}

/* End of file api_permissions.php */