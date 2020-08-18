<?php
/**
 * Auth Components Inc
 *
 * This file contains the methods for auth's components
 * and loaded only when is required to save resources
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_auth_components') ) {
    
    /**
     * The function md_the_auth_components gets auth's components
     * 
     * @param string $component is optionally and if exists will return only it
     * 
     * @since 0.0.7.8
     * 
     * @return array with auth's components or boolean false
     */
    function md_the_auth_components($component=NULL) {

        $all_components = array();

        // List all auth components
        foreach (glob(APPPATH . 'base/auth/collection/*', GLOB_ONLYDIR) as $dir) {

            // Get the component_dir
            $component_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'Auth',
                'Collection',
                ucfirst($component_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get the component's info
            $component_info = (new $cl())->component_info();

            if (isset($component_info['display_component_name'])) {

                if ( $component ) {

                    if ( $component === $component_dir ) {

                        return array(
                            'slug' => $component_dir,
                            'name' => $component_info['display_component_name']
                        );

                    }

                } else {

                    $all_components[] = array(
                        'slug' => $component_dir,
                        'name' => $component_info['display_component_name']
                    );

                }

            }

        }

        if ( $all_components ) {
            
            return $all_components;

        } else {

            return false;

        }
        
    }
    
}