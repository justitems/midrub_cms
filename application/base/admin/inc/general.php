<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Classes as CmsBaseAdminClasses;

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_the_admin_icon') ) {
    
    /**
     * The function md_the_admin_icon gets the admin icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon or boolean
     */
    function md_the_admin_icon($params) {

        // Call the icons class
        return (new CmsBaseAdminClasses\Icons)->the_icon($params);

    }
    
}

if ( !function_exists('md_the_admin_menu') ) {
    
    /**
     * The function md_the_admin_menu gets the admin's menu
     * 
     * @param array $params contains the item's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return array with menu
     */
    function md_the_admin_menu($params = array()) {

        // Call the menu class
        return (new CmsBaseAdminClasses\Menu)->the_items($params);

    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_get_admin_fields') ) {
    
    /**
     * The function md_get_admin_fields shows the admin fields
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_get_admin_fields($params) {

        // Call the fields class
        (new CmsBaseAdminClasses\Fields)->get_fields($params);

    }
    
}

if ( !function_exists('md_get_admin_view') ) {
    
    /**
     * The function md_get_admin_view gets the admin view
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function md_get_admin_view() {

        // Verify if view exists
        if ( md_the_data('admin_content_view') ) {

            // Display view
            echo md_the_data('admin_content_view');

        }
        
    }
    
}

if ( !function_exists('md_get_admin_quick_guide') ) {
    
    /**
     * The function md_get_admin_quick_guide shows quick guide
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_get_admin_quick_guide($params) {

        // Call the quick_guide class
        (new CmsBaseAdminClasses\Quick_guide)->get_quick_guide($params);

    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_admin_view') ) {
    
    /**
     * The function set_admin_view sets the admin's view
     * 
     * @param array $view contains the view parameters
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function set_admin_view($view) {

        // Set content view
        md_set_data('admin_content_view', $view);
        
    }
    
}

/* End of file general.php */