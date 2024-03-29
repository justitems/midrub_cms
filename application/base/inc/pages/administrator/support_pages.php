<?php
/**
 * Support Pages Inc
 *
 * This file contains the general functions for
 * admin's support pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Pages as CmsBaseClassesPages;

if ( !function_exists('md_set_support_page') ) {
    
    /**
     * The function md_set_support_page adds support's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_support_page($page_slug, $args) {
        
        // Call the support_pages class
        $support_pages = (new CmsBaseClassesPages\Main);

        // Set support page in the queue
        $support_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_support_pages') ) {
    
    /**
     * The function md_the_support_pages gets the support pages
     * 
     * @since 0.0.7.8
     * 
     * @return array with support pages or boolean false
     */
    function md_the_support_pages() {
        
        // Call the support_pages class
        $support_pages = (new CmsBaseClassesPages\Main);

        // Return support pages
        return $support_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_support_page_content') ) {
    
    /**
     * The function md_get_the_support_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_support_page_content($page) {
        
        // Call the support_pages class
        $support_pages = (new CmsBaseClassesPages\Main);

        // List all pages
        foreach ( $support_pages::$the_pages as $the_support_page ) {

            if ( isset($the_support_page[$page]['content']) ) {

                if ( $the_support_page[$page]['content'] ) {

                    if ( function_exists($the_support_page[$page]['content']) ) {
                        $the_support_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}