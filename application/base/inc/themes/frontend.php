<?php
/**
 * Frontend Themes Inc
 *
 * This file contains the frontend themes functions
 * used for the Midrub's
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_frontend_themes') ) {
    
    /**
     * The function md_the_frontend_themes returns the Midrub's frontend themes
     * 
     * @since 0.0.7.8
     * 
     * @return array with themes
     */
    function md_the_frontend_themes() {

        $all_themes = array();

        // List all themes
        foreach (glob(APPPATH . 'base/frontend/themes/*', GLOB_ONLYDIR) as $dir) {

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
                    if ( file_exists(FCPATH . 'assets/base/frontend/themes/' . $theme . '/screenshot.png') ) {
                        
                        // Set screenshot
                        $screenshot = base_url('assets/base/frontend/themes/' . $theme . '/screenshot.png');

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

if ( !function_exists('md_the_frontend_theme_templates') ) {
    
    /**
     * The function md_the_frontend_theme_templates returns the Midrub frontend theme's templates
     * 
     * @param string $theme_slug contains the theme's slug
     * 
     * @since 0.0.7.8
     * 
     * @return array with themes
     */
    function md_the_frontend_theme_templates($theme_slug = NULL) {

        // Gets all contents categories
        $all_categories = md_the_contents_categories();

        // Verify if categories exists
        if ( $all_categories ) {

            // All templates
            $all_templates =  array();            

            // List all categories
            foreach ($all_categories as $category) {

                // Get category slug
                $slug = array_keys($category);

                // Verify if category has templates_path
                if (isset($category[$slug[0]]['templates_path'])) {

                    // List all templates
                    foreach (glob($category[$slug[0]]['templates_path'] . '*.php') as $filename) {

                        // Get name
                        $template_name = str_replace(array($category[$slug[0]]['templates_path'], '.php'), '', $filename);

                        // Get template info
                        $all_templates[] = array(
                            'slug' => $template_name,
                            'name' => ucwords(str_replace('_', ' ', $template_name))
                        );

                    }

                    

                }

            }

            return $all_templates;

        }

        return false;
        
    }
    
}