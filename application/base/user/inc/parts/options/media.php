<?php
/**
 * Media Parts Options Inc
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

if (!function_exists('md_the_user_image_from_parts')) {
    
    /**
     * The function md_the_user_image_from_parts gets the user's image
     * 
     * @param integer $user_id contains the user_id
     * 
     * @return array with image or boolean false
     */
    function md_the_user_image_from_parts($user_id) {

        $image_id = md_the_user_option($user_id, 'profile_image');

        if ( $image_id ) {

            $CI = get_instance();

            $the_media = $CI->base_model->the_data_where('medias', '*', array('media_id' => $image_id, 'user_id' => $user_id));

            return $the_media;

        }

        return false;

    }

}

/* End of file media.php */