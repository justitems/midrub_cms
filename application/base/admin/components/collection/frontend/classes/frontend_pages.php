<?php
/**
 * Frontend_pages Pages Class
 *
 * This file loads the Frontend_pages Class with properties used to displays pages in the Frontend component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Classes;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Frontend_pages class loads the general properties used to displays pages in the Frontend component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Frontend_pages {
    
    /**
     * Contains and array with saved pages
     *
     * @since 0.0.8.5
     */
    public static $the_pages = array(); 

    /**
     * The public method set_page adds page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function set_page($page_slug, $args) {

        // Verify if the page has valid fields
        if ( $page_slug && isset($args['page_name']) && isset($args['page_icon']) ) {

            self::$the_pages[][$page_slug] = $args;
            
        }

    } 

    /**
     * The public method the_pages gets all pages
     * 
     * @since 0.0.8.5
     * 
     * @return array with pages or boolean false
     */
    public function the_pages() {

        // Verify if pages exists
        if ( self::$the_pages ) {

            return self::$the_pages;

        } else {

            return false;

        }

    }

}

/* End of file frontend_pages.php */