<?php
/**
 * User Themes Inc
 *
 * This file contains the user functions
 * used for the Midrub's themes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_user_themes') ) {
    
    /**
     * The function md_the_user_themes returns the Midrub's user themes
     * 
     * @since 0.0.7.9
     * 
     * @return array with themes
     */
    function md_the_user_themes() {

        $all_themes = array();

        // List all themes
        foreach (glob(APPPATH . 'base/user/themes/*', GLOB_ONLYDIR) as $dir) {

            // Get directory name
            $theme = str_replace('_', '-', trim(basename($dir) . PHP_EOL));

            // Verify if theme has config.json file
            if ( file_exists($dir . '/config.json') ) {

                // Get file content
                $config = json_decode(file_get_contents($dir . '/config.json'), true);

                // Verify if config.json has correct value
                if ( isset($config['name']) && isset($config['description']) && isset($config['version']) ) {

                    // Default theme
                    $screenshot = '';

                    // Verify if the theme has screenshot
                    if ( file_exists(FCPATH . 'assets/base/user/themes/' . $theme . '/screenshot.png') ) {
                        
                        // Set screenshot
                        $screenshot = base_url('assets/base/user/themes/' . $theme . '/screenshot.png');

                    }

                    // Add theme
                    $all_themes[] = array(
                        'name' => $config['name'],
                        'description' => $config['description'],
                        'version' => $config['version'],
                        'screenshot' => $screenshot,
                        'slug' => $theme
                    );

                } else {

                    continue;

                }

            } else {

                continue;

            }


        }

        return $all_themes;
        
    }
    
}