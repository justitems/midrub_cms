<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Classes as CmsBaseAdminClasses;

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_set_admin_menu_item') ) {
    
    /**
     * The function md_set_admin_menu_item registers a new menu's item
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_set_admin_menu_item($params) {

        // Set menu's item
        (new CmsBaseAdminClasses\Menu)->set_item($params);
        
    }
    
}

/* End of file init.php */