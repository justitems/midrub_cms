<?php
/**
 * General Auth Inc
 *
 * This file contains the general functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_auth_social_access_options') ) {
    
    /**
     * The function md_auth_the_social_access_options returns social access options
     * 
     * @since 0.0.8.5
     * 
     * @return array with social access options
     */
    function md_auth_social_access_options() {
        
        // Default options
        $options = array();

        // Verify if social access is enabled
        if ( !md_the_option('auth_enable_social_login') ) {
            return $options;
        }

        // List auth social classes
        foreach (glob(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/*.php') as $filename) {

            // Call the class
            $network_slug = str_replace(array(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/', '.php'), '', $filename);

            // Verify if option is enabled
            if (!md_the_option('auth_network_' . $network_slug . '_enabled')) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'Admin',
                'Components',
                'Collection',
                'Frontend',
                'Networks',
                'Collection',
                ucfirst($network_slug)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get class info
            $the_info = (new $cl())->info();

            // Set option's name
            $the_info['network_slug'] = $network_slug;

            // Set option
            $options[] = $the_info;

        }

        return $options;
        
    }
    
}

/* End of file general.php */