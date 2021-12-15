<?php
/**
 * Admin Themes Inc
 *
 * This file contains the functions
 * used for the admin's themes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_admin_themes') ) {
    
    /**
     * The function the_admin_themes returns the admin's themes
     * 
     * @since 0.0.8.4
     * 
     * @return array with themes
     */
    function the_admin_themes() {

        $all_themes = array();

        // List all themes
        foreach (glob(APPPATH . 'base/admin/themes/collection/*', GLOB_ONLYDIR) as $dir) {

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
                    if ( file_exists(FCPATH . 'assets/base/admin/themes/collection/' . $theme . '/screenshot.png') ) {
                        
                        // Set screenshot
                        $screenshot = base_url('assets/base/admin/themes/collection/' . $theme . '/screenshot.png');

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

/* End of file themes.php */