<?php
/**
 * Hooks Inc
 *
 * This file contains the hooks functions
 * used to register hooks
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('the_user_component_option') ) {
    
    /**
     * The function the_user_component_option returns user's options
     * 
     * @since 0.0.7.9
     * 
     * @return array with user's options or boolean false
     */
    function the_user_component_options() {

        require_once MIDRUB_BASE_PATH . 'inc/components/user_options.php';

        return md_the_user_component_options();
        
    }
    
}

if ( !function_exists('the_member_permissions') ) {
    
    /**
     * The function the_member_permissions returns the member's permissions
     * 
     * @param integer $role_id contains the role's id
     * 
     * @since 0.0.7.9
     * 
     * @return string with permissions
     */
    function the_member_permissions($role_id) {

        require_once MIDRUB_BASE_PATH . 'inc/team/permissions.php';

        return md_the_member_permissions($role_id);
        
    }
    
}

if ( !function_exists('the_plans_usage') ) {
    
    /**
     * The function the_plans_usage returns the plan's usage
     * 
     * @since 0.0.8.0
     * 
     * @return array with plan's usage
     */
    function the_plans_usage() {

        require_once MIDRUB_BASE_PATH . 'inc/plans/usage.php';

        return md_the_plans_usage();
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_user_component_options') ) {
    
    /**
     * The function get_menu generates a menu
     * 
     * @param array $option contains an array with option
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_user_component_options($option) {

        require_once MIDRUB_BASE_PATH . 'inc/components/user_options.php';

        md_get_user_component_options($option);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_user_component_options') ) {
    
    /**
     * The function set_user_component_options registers options
     * 
     * @param array $args contains the array with options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_user_component_options($args) {

        require_once MIDRUB_BASE_PATH . 'inc/components/user_options.php';

        md_set_user_component_options($args);
        
    }
    
}

if ( !function_exists('set_user_settings_options') ) {
    
    /**
     * The function set_user_settings_options registers settings options
     * 
     * @param array $args contains the array with options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_user_settings_options($args) {

        require_once MIDRUB_BASE_PATH . 'inc/components/user_options.php';

        md_set_user_component_options($args);
        
    }
    
}

if ( !function_exists('set_plans_options') ) {
    
    /**
     * The function set_plans_options registers plans options
     * 
     * @param array $args contains the array with options
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_plans_options($args) {

        md_set_plans_options($args);
        
    }
    
}

if ( !function_exists('set_member_permissions') ) {
    
    /**
     * The function set_member_permissions registers team's permissions
     * 
     * @param array $args contains the array with permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_member_permissions($args) {

        require_once MIDRUB_BASE_PATH . 'inc/team/permissions.php';

        md_set_member_permissions($args);
        
    }
    
}

if ( !function_exists('set_plans_usage') ) {
    
    /**
     * The function set_plans_usage registers plan's usage
     * 
     * @param array $args contains the array with plan's usage
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function set_plans_usage($args) {

        require_once MIDRUB_BASE_PATH . 'inc/plans/usage.php';

        md_set_plans_usage($args);
        
    }
    
}