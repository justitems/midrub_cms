<?php
/**
 * Rest General Inc
 *
 * This file contains the general functions
 * used to process the rest calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('rest_verify_token') ) {
    
    /**
     * The function rest_verify_token verifies if access token is valid
     * 
     * @param array $permissions contains the required permissions
     * 
     * @since 0.0.7.9
     * 
     * @return integer with user's id or false
     */
    function rest_verify_token( $permissions ) {

        // Verify if access token is valid
        return (new MidrubBase\Rest\Classes\Security())->verify_token($permissions);
        
    }
    
}

/* End of file general.php */