<?php
/**
 * Reset Auth Inc
 *
 * This file contains the reset functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Classes\Reset as MidrubBaseAuthClassesReset;

if ( !function_exists('md_auth_reset_password') ) {
    
    /**
     * The function md_auth_reset_password resets user password
     * 
     * @param string $email contains the user's email
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_auth_reset_password($email) {
        
        // Call the reset class
        $reset = (new MidrubBaseAuthClassesReset\Reset);

        // Try to reset the password
        $reset->reset_password($email);
        
    }
    
}