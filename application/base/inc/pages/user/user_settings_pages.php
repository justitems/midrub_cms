<?php
/**
 * User Settings Pages Inc
 *
 * This file contains the functions
 * to register and diplay the Settings pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Pages as MidrubBaseClassesPages;

if ( !function_exists('md_set_user_settings_page') ) {
    
    /**
     * The function md_set_user_settings_page adds user's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_set_user_settings_page($page_slug, $args) {

        // Call the user_settings_pages class
        $user_settings_pages = (new MidrubBaseClassesPages\Settings);

        // Set user page in the queue
        $user_settings_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_user_settings_pages') ) {
    
    /**
     * The function md_the_user_settings_pages gets the user pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with user pages or boolean false
     */
    function md_the_user_settings_pages() {
        
        // Call the user_settings_pages class
        $user_settings_pages = (new MidrubBaseClassesPages\Settings);

        // Return user pages
        return $user_settings_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_user_settings_page_content') ) {
    
    /**
     * The function md_get_the_user_settings_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_get_the_user_settings_page_content($page) {
        
        // Call the user_settings_pages class
        $user_settings_pages = (new MidrubBaseClassesPages\Settings);

        // List all pages
        foreach ( $user_settings_pages::$the_pages as $the_user_settings_page ) {

            if ( isset($the_user_settings_page[$page]['content']) ) {

                if ( $the_user_settings_page[$page]['content'] ) {

                    if ( function_exists($the_user_settings_page[$page]['content']) ) {
                        $the_user_settings_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}