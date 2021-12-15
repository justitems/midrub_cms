<?php
/**
 * Update Parts Options Inc
 *
 * This file contains the functions
 * which are making lighter the parent files
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('md_update_user_option_from_parts')) {
    
    /**
     * The function md_update_user_option_from_parts updates the user's options
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * @param string $meta_value contains the user's meta value
     * 
     * @return object or string with meta's value
     */
    function md_update_user_option_from_parts($user_id, $meta_name, $meta_value) {

        if ( empty($meta_name) || empty($meta_value) ) {
            return false;
        }

        $CI = get_instance();

        if ( ($meta_name === 'email') || ($meta_name === 'last_name') || ($meta_name === 'first_name') || ($meta_name === 'role') || ($meta_name === 'status') || ($meta_name === 'last_access') || ($meta_name === 'reset_code') || ($meta_name === 'activate') ) {

            $update = array();

            $update[trim($meta_name)] = trim($meta_value);

            if ( $CI->base_model->update('users', array('user_id' => $user_id), $update) ) {
                return true;
            } else {
                return false;
            }

        } else {

            $md_the_option = $CI->base_model->the_data_where('users_meta', '*', array('user_id' => $user_id, 'meta_name' => trim($meta_name)));

            if ( $md_the_option ) {
    
                if ( $CI->base_model->update('users_meta', array('user_id' => $user_id, 'meta_name' => trim($meta_name)), array('meta_value' => trim($meta_value))) ) {
                    return true;
                } else {
                    return false;
                }
    
            } else {
    
                if ( $CI->base_model->insert('users_meta', array('user_id' => $user_id, 'meta_name' => trim($meta_name), 'meta_value' => trim($meta_value))) ) {
                    return true;
                } else {
                    return false;
                }
    
            }

        }

    }

}

/* End of file update.php */