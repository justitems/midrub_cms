<?php
/**
 * Menu Inc
 *
 * This file contains the function to
 * display the frontend's menu
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Frontend\Classes as CmsBaseFrontendClasses;

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_get_frontend_menu') ) {
    
    /**
     * The function md_get_frontend_menu generates a menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function md_get_frontend_menu($menu_slug, $args) {

        // Display menu
        (new CmsBaseFrontendClasses\Menu)->md_get_menu($menu_slug, $args);
        
    }
    
}

/* End of file menu.php */