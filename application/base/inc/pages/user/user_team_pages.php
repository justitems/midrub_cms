<?php
/**
 * User Team Pages Inc
 *
 * This file contains the functions
 * to register and diplay the team's pages
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Pages as MidrubBaseClassesPages;

if ( !function_exists('md_set_user_team_page') ) {
    
    /**
     * The function md_set_user_team_page adds user's pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_set_user_team_page($page_slug, $args) {

        // Call the user_team_pages class
        $user_team_pages = (new MidrubBaseClassesPages\Team);

        // Set user page in the queue
        $user_team_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_user_team_pages') ) {
    
    /**
     * The function md_the_user_team_pages gets the user pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with user pages or boolean false
     */
    function md_the_user_team_pages() {
        
        // Call the user_team_pages class
        $user_team_pages = (new MidrubBaseClassesPages\Team);

        // Return user pages
        return $user_team_pages->load_pages();
        
    }
    
}

if ( !function_exists('md_get_the_user_team_page_content') ) {
    
    /**
     * The function md_get_the_user_team_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_get_the_user_team_page_content($page) {
        
        // Call the user_team_pages class
        $user_team_pages = (new MidrubBaseClassesPages\Team);

        // List all pages
        foreach ( $user_team_pages::$the_pages as $the_user_team_page ) {

            if ( isset($the_user_team_page[$page]['content']) ) {

                if ( $the_user_team_page[$page]['content'] ) {

                    if ( function_exists($the_user_team_page[$page]['content']) ) {
                        $the_user_team_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}