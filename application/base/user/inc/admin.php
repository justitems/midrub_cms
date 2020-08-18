<?php
/**
 * Admin Inc
 *
 * This file contains the admin functions
 * used in the User's panel when runs admin_init
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_admin_app_options') ) {
    
    /**
     * The function set_admin_app_options registers options for Admin's
     * 
     * @param string $app_slug contains the app's slug
     * @param array $args contains the app's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_admin_app_options($app_slug, $args=array()) {

        // Require the Admin Apps Options Inc
        require_once MIDRUB_BASE_PATH . 'inc/apps/admin_options.php';

        // Register Admin's Apps App Options
        md_set_admin_app_options($app_slug, $args);
        
    }
    
}

if ( !function_exists('set_user_component_options') ) {
    
    /**
     * The function set_user_component_options registers options for admin
     * 
     * @param string $component_slug contains the component's slug
     * @param array $args contains the component's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_user_component_options($component_slug, $args=array()) {

        // Require the User's Components Options Inc
        require_once MIDRUB_BASE_PATH . 'inc/components/user_options.php';

        // Register User's Components Options
        md_set_user_component_options($component_slug, $args);
        
    }
    
}

if ( !function_exists('set_admin_api_permissions') ) {
    
    /**
     * The function set_admin_api_permissions adds api's permissions in the queue
     * 
     * @param array $args contains the api's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_admin_api_permissions($args) {

        // Require the Rest Permissions Inc
        require_once MIDRUB_BASE_PATH . 'inc/rest/api_permissions.php';

        // Register Admin's Components Options
        md_set_admin_api_permissions($args);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| REGISTER DEFAULT HOOKS
|--------------------------------------------------------------------------
*/