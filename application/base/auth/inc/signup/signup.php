<?php
/**
 * Signup Auth Inc
 *
 * This file contains the signup functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Classes\Signup as MidrubBaseAuthClassesSignup;

if ( !function_exists('md_auth_save_user_data') ) {
    
    /**
     * The function md_auth_save_user_data saves user's data
     * 
     * @param array $args contains the user information
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_auth_save_user_data($args) {
        
        // Call the signup class
        $signup = (new MidrubBaseAuthClassesSignup\Signup);

        // Try to register
        $signup->save_user_data($args);
        
    }
    
}