<?php
/**
 * Additional Inc
 *
 * This file contains the additional functions
 * which can be used optionally
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

if ( !function_exists('the_user_team_pages') ) {
    
    /**
     * The function the_user_team_pages gets team's pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with team's pages
     */
    function the_user_team_pages() {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        return md_the_user_team_pages();
        
    }
    
}

if ( !function_exists('the_frontend_settings_pages') ) {
    
    /**
     * The function the_frontend_settings_pages gets the frontend settings pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with frontend settings pages
     */
    function the_frontend_settings_pages() {

        require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/frontend_settings_pages.php';

        return md_the_frontend_settings_pages();
        
    }
    
}

if ( !function_exists('the_global_variable') ) {
    
    /**
     * The function the_global_variable gets a variable
     * 
     * @param string $key contains the variable's key
     * 
     * @since 0.0.8.2
     * 
     * @return any with variable's value or boolean false
     */
    function the_global_variable($key) {
        
        return md_the_component_variable($key);
        
    }
    
}

if ( !function_exists('the_user_team_pages') ) {
    
    /**
     * The function the_user_team_pages gets team's pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with team's pages
     */
    function the_user_team_pages() {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        return md_the_user_team_pages();
        
    }
    
}

if ( !function_exists('the_user_settings_pages') ) {
    
    /**
     * The function the_user_settings_pages gets settings pages
     * 
     * @since 0.0.8.2
     * 
     * @return array with settings pages
     */
    function the_user_settings_pages() {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_settings_pages.php';

        return md_the_user_settings_pages();
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_user_component_options') ) {
    
    /**
     * The function get_user_component_options gets the user's options
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

if ( !function_exists('get_the_user_team_page_content') ) {
    
    /**
     * The function get_the_user_team_page_content gets page's content
     * 
     * @param string $page contains the page's slug
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_the_user_team_page_content($page) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        md_get_the_user_team_page_content($page);
        
    }
    
}

if ( !function_exists('get_the_frontend_settings_page_content') ) {
    
    /**
     * The function get_the_frontend_settings_page_content gets page's content
     * 
     * @param string $page contains the page's slug
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_the_frontend_settings_page_content($page) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/frontend_settings_pages.php';

        md_get_the_frontend_settings_page_content($page);
        
    }
    
}

if ( !function_exists('get_option_dropdown') ) {
    
    /**
     * The function get_option_dropdown shows dropdown
     * 
     * @param string $name contains the option's name
     * @param array $args contains the dropdown's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_dropdown($name, $args) {

        require_once APPPATH . 'base/inc/options/dropdown.php';

        md_get_option_dropdown($name, $args);
        
    }
    
}

if ( !function_exists('get_option_textarea') ) {
    
    /**
     * The function get_option_textarea shows textarea
     * 
     * @param string $name contains the option's name
     * @param array $args contains the textarea's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_textarea($name, $args) {

        require_once APPPATH . 'base/inc/options/textarea.php';

        md_get_option_textarea($name, $args);
        
    }
    
}

if ( !function_exists('get_option_media') ) {
    
    /**
     * The function get_option_media shows media
     * 
     * @param string $name contains the option's name
     * @param array $args contains the media's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_media($name, $args) {

        require_once APPPATH . 'base/inc/options/media.php';

        md_get_option_media($name, $args);
        
    }
    
}

if ( !function_exists('get_option_checkbox') ) {
    
    /**
     * The function get_option_checkbox shows checkbox
     * 
     * @param string $name contains the option's name
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_checkbox($name) {

        require_once APPPATH . 'base/inc/options/checkbox.php';

        md_get_option_checkbox($name);
        
    }
    
}

if ( !function_exists('get_option_list_items') ) {
    
    /**
     * The function get_option_list_items shows list items
     * 
     * @param string $name contains the option's name
     * @param array $args contains the list items arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_list_items($name, $args) {

        require_once APPPATH . 'base/inc/options/list_items.php';

        md_get_list_items($name, $args);
        
    }
    
}

if ( !function_exists('get_the_user_team_page_content') ) {
    
    /**
     * The function get_the_user_team_page_content gets page's content
     * 
     * @param string $page contains the page's slug
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_the_user_team_page_content($page) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        md_get_the_user_team_page_content($page);
        
    }
    
}

if ( !function_exists('get_the_user_settings_page_content') ) {
    
    /**
     * The function get_the_user_settings_page_content gets page's content
     * 
     * @param string $page contains the page's slug
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_the_user_settings_page_content($page) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_settings_pages.php';

        md_get_the_user_settings_page_content($page);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('add_hook') ) {
    
    /**
     * The function add_hook registers hooks
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function add_hook($hook_name, $args) {

        md_add_hook($hook_name, $args);
        
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

        if ( function_exists('md_set_plans_options') ) {

            md_set_plans_options($args);

        }
        
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

if ( !function_exists('set_frontend_settings_page') ) {
    
    /**
     * The function set_frontend_settings_page registers frotent settings page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_frontend_settings_page($page_slug, $args) {
                                      
        require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/frontend_settings_pages.php';

        md_set_frontend_settings_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('set_user_team_page') ) {
    
    /**
     * The function set_user_team_page registers team's page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_user_team_page($page_slug, $args) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        md_set_user_team_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('set_contents_category_meta') ) {
    
    /**
     * The function set_user_team_page adds contents category meta
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_contents_category_meta($category_slug, $args) {

        require_once MIDRUB_BASE_PATH . 'inc/contents/contents_categories.php';

        md_set_contents_category_meta($category_slug, $args);
        
    }
    
}

if ( !function_exists('set_global_variable') ) {
    
    /**
     * The function set_global_variable registers a global variable
     * 
     * @param string $key contains the variable's key
     * @param any $value contains the variable's value
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_global_variable($key, $value) {

        md_set_component_variable($key, $value);
        
    }
    
}

if ( !function_exists('set_user_team_page') ) {
    
    /**
     * The function set_user_team_page registers team's page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_user_team_page($page_slug, $args) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_team_pages.php';

        md_set_user_team_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('set_user_settings_page') ) {
    
    /**
     * The function set_user_settings_page registers settings page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function set_user_settings_page($page_slug, $args) {

        require_once MIDRUB_BASE_PATH . 'inc/pages/user/user_settings_pages.php';

        md_set_user_settings_page($page_slug, $args);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO PROCESS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('delete_user') ) {
    
    /**
     * The function delete_user deletes a user
     * 
     * @param array $args contains the user's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    function delete_user($args) {

        require_once MIDRUB_BASE_PATH . 'inc/user/general.php';

        return md_delete_user($args);
        
    }
    
}