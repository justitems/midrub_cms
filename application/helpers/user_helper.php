<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Name: User Helper
 * Author: Scrisoft
 * Created: 20/11/2017
 * 
 * Here you will find the following functions:
 * get_user_email_by_id - gets the user email by user's id
 * */

if (!function_exists('get_user_email_by_id')) {
    
    /**
     * The function get_user_email_by_id gets user's email by user_id
     * 
     * @param integer $user_id contains the user's id
     * 
     * @return string with email or false
     */
    function get_user_email_by_id($user_id) {
        
        $CI = get_instance();
        
        $email = $CI->user->get_email_by('user_id', $user_id);
        
        if ( $email ) {
            
            return $email;
            
        } else {
        
            return false;
            
        }
        
    }
    
}