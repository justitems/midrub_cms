<?php
/**
 * General Auth Inc
 *
 * This file contains the general functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');


if ( !function_exists('md_auth_social_access_options') ) {
    
    /**
     * The function md_auth_the_social_access_options returns social access options
     * 
     * @since 0.0.7.8
     * 
     * @return array with social access options
     */
    function md_auth_social_access_options() {
        
        // Default options
        $options = array();

        // Verify if social access is enabled
        if ( !get_option('enable_auth_social_access') ) {

            return $options;

        }

        // List auth social classes
        foreach (glob(MIDRUB_BASE_AUTH . 'social/*.php') as $filename) {

            // Call the class
            $className = str_replace(array(MIDRUB_BASE_AUTH . 'social/', '.php'), '', $filename);

            // Verify if option is enabled
            if (!get_option('enable_auth_' . strtolower($className))) {
                continue;
            }

            // Create an array
            $array = array(
                'MidrubBase',
                'Auth',
                'Social',
                ucfirst($className)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get class info
            $get_info = (new $cl())->get_info();

            // Set option's name
            $get_info->name = $className;

            // Set option
            $options[] = $get_info;

        }

        return $options;
        
    }
    
}