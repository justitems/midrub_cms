<?php
/**
 * Password Change Auth Inc
 *
 * This file contains the password change functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Classes\Change as MidrubBaseAuthClassesChange;

if ( !function_exists('md_auth_change_password') ) {
    
    /**
     * The function md_auth_change_password changes user password
     * 
     * @param integer $user_id contains the user's id
     * @param string $reset_code contains the reset code
     * @param string $new_password contains the new password
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_auth_change_password($user_id, $reset_code, $new_password) {
        
        // Call the reset class
        $reset = (new MidrubBaseAuthClassesChange\Change);

        // Try to reset the password
        $reset->change_password($user_id, $reset_code, $new_password);
        
    }
    
}