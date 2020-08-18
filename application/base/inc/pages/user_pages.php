<?php
/**
 * User Pages Inc
 *
 * This file contains the general functions for
 * admin's user pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Pages as MidrubBaseClassesPages;

if ( !function_exists('md_set_user_page') ) {
    
    /**
     * The function md_set_user_page adds user's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_user_page($page_slug, $args) {
        
        // Call the user_pages class
        $user_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Set user page in the queue
        $user_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_user_pages') ) {
    
    /**
     * The function md_the_user_pages gets the user pages
     * 
     * @since 0.0.7.8
     * 
     * @return array with user pages or boolean false
     */
    function md_the_user_pages() {
        
        // Call the user_pages class
        $user_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Return user pages
        return $user_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_user_page_content') ) {
    
    /**
     * The function md_get_the_user_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_user_page_content($page) {
        
        // Call the user_pages class
        $user_pages = (new MidrubBaseClassesPages\Admin_pages);

        // List all pages
        foreach ( $user_pages::$the_pages as $the_user_page ) {

            if ( isset($the_user_page[$page]['content']) ) {

                if ( $the_user_page[$page]['content'] ) {

                    if ( function_exists($the_user_page[$page]['content']) ) {
                        $the_user_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}