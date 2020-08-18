<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name: Smtp Helper
 * Author: Scrisoft
 * Created: 02/08/2018
 * Here you will find the following functions:
 * get_user_email_by_id - gets the user email
 * */
if (!function_exists('get_user_email_by_id')) {
    
    function get_user_email_by_id($user_id) {
        $CI = get_instance();
        // Load User Model
        $CI->load->model('user');
        
        $email = $CI->user->get_email_by('user_id', $user_id);
        
        if ( $email ) {
            
            return $email;
            
        } else {
        
            return false;
            
        }
        
    }
    
}
