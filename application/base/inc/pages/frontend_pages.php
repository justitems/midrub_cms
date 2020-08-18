<?php
/**
 * Frontend Pages Inc
 *
 * This file contains the general functions for
 * admin's frontend pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Pages as MidrubBaseClassesPages;

if ( !function_exists('md_set_frontend_page') ) {
    
    /**
     * The function md_set_frontend_page adds frontend's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_frontend_page($page_slug, $args) {
        
        // Call the frontend_pages class
        $frontend_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Set frontend page in the queue
        $frontend_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_frontend_pages') ) {
    
    /**
     * The function md_the_frontend_pages gets the frontend pages
     * 
     * @since 0.0.7.8
     * 
     * @return array with frontend pages or boolean false
     */
    function md_the_frontend_pages() {
        
        // Call the frontend_pages class
        $frontend_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Return frontend pages
        return $frontend_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_frontend_page_content') ) {
    
    /**
     * The function md_get_the_frontend_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_frontend_page_content($page) {
        
        // Call the frontend_pages class
        $frontend_pages = (new MidrubBaseClassesPages\Admin_pages);

        // List all pages
        foreach ( $frontend_pages::$the_pages as $the_frontend_page ) {

            if ( isset($the_frontend_page[$page]['content']) ) {

                if ( $the_frontend_page[$page]['content'] ) {

                    if ( function_exists($the_frontend_page[$page]['content']) ) {
                        $the_frontend_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}