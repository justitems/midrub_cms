<?php
/**
 * Save Inc
 *
 * This file contains the functions to save media in the database
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_save_media') ) {
    
    /**
     * The function md_save_media saves media's files
     * 
     * @param array $params contains the file's parameters
     * 
     * @since 0.0.8.4
     * 
     * @return integer with last inserted ID or boolean false
     */
    function md_save_media( $params ) {

        // Get codeigniter object instance
        $CI = get_instance();

        // Verify if the default keys exists
        if ( !empty($params['user_id']) && !empty($params['name']) && !empty($params['body']) && !empty($params['cover']) && !empty($params['size']) && !empty($params['type']) ) {

            // Media parameters
            $media_params = array(
                'user_id' => $params['user_id'],
                'name' => $params['name'],
                'body' => $params['body'],
                'cover' => $params['cover'],
                'size' => $params['size'],
                'type' => $params['type'],
                'extension' => $params['extension'],
                'created' => time()
            );

            // Try to save the media's file and get the last id
            $last_id = $CI->base_model->insert('medias', $media_params);

            // Verify if the file was saved
            if ( $last_id ) {

                return $last_id;

            } else {

                return false;

            }

        } else {

            return false;

        }
        
    }
    
}