<?php
/**
 * Members Pages Inc
 *
 * This file contains the general functions for
 * admin's members pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Pages\Administrator as CmsBaseClassesPagesAdministrator;

if ( !function_exists('md_set_members_page') ) {
    
    /**
     * The function md_set_members_page adds members's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function md_set_members_page($page_slug, $args) {
        
        // Call the members_pages class
        $members_pages = (new CmsBaseClassesPagesAdministrator\Members_pages);

        // Set members page in the queue
        $members_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_members_pages') ) {
    
    /**
     * The function md_the_members_pages gets the members pages
     * 
     * @since 0.0.8.3
     * 
     * @return array with members pages or boolean false
     */
    function md_the_members_pages() {
        
        // Call the members_pages class
        $members_pages = (new CmsBaseClassesPagesAdministrator\Members_pages);

        // Return members pages
        return $members_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_members_page_content') ) {
    
    /**
     * The function md_get_the_members_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function md_get_the_members_page_content($page) {

        // Call the members_pages class
        $members_pages = (new CmsBaseClassesPagesAdministrator\Members_pages);

        // List all pages
        foreach ( $members_pages::$the_pages as $the_members_page ) {

            if ( isset($the_members_page[$page]['content']) ) {

                if ( $the_members_page[$page]['content'] ) {

                    if ( function_exists($the_members_page[$page]['content']) ) {
                        $the_members_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}