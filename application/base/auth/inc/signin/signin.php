<?php
/**
 * Signin Auth Inc
 *
 * This file contains the signin functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Classes\Signin as MidrubBaseAuthClassesSignin;

if ( !function_exists('md_auth_authenticate_user') ) {
    
    /**
     * The function md_auth_authenticate_user authenticate a user
     * 
     * @param array $args contains the user information
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_auth_authenticate_user($args) {
        
        // Call the sign class
        $signin = (new MidrubBaseAuthClassesSignin\Signin);

        // Try to authenticate
        $signin->authenticate_user($args);
        
    }
    
}