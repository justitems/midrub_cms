<?php
/**
 * Admin Pages Inc
 *
 * This file contains the general functions for
 * admin's admin pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Pages as MidrubBaseClassesPages;

if ( !function_exists('md_set_admin_page') ) {
    
    /**
     * The function md_set_admin_page adds admin's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_admin_page($page_slug, $args) {
        
        // Call the admin_pages class
        $admin_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Set admin page in the queue
        $admin_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_admin_pages') ) {
    
    /**
     * The function md_the_admin_pages gets the admin pages
     * 
     * @since 0.0.7.8
     * 
     * @return array with admin pages or boolean false
     */
    function md_the_admin_pages() {
        
        // Call the admin_pages class
        $admin_pages = (new MidrubBaseClassesPages\Admin_pages);

        // Return admin pages
        return $admin_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_admin_page_content') ) {
    
    /**
     * The function md_get_the_admin_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_admin_page_content($page) {
        
        // Call the admin_pages class
        $admin_pages = (new MidrubBaseClassesPages\Admin_pages);

        // List all pages
        foreach ( $admin_pages::$the_pages as $the_admin_page ) {

            if ( isset($the_admin_page[$page]['content']) ) {

                if ( $the_admin_page[$page]['content'] ) {

                    if ( function_exists($the_admin_page[$page]['content']) ) {
                        $the_admin_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}