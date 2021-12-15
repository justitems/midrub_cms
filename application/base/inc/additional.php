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

        require_once CMS_BASE_PATH . 'inc/components/user_options.php';

        return md_the_user_component_options();
        
    }
    
}

if ( !function_exists('the_members_pages') ) {
    
    /**
     * The function the_members_pages gets members pages
     * 
     * @since 0.0.8.3
     * 
     * @return array with members pages
     */
    function the_members_pages() {

        require_once CMS_BASE_PATH . 'inc/pages/administrator/members_pages.php';

        return md_the_members_pages();
        
    }
    
}

if ( !function_exists('md_the_cache') ) {
    
    /**
     * The function md_the_cache returns the cache
     * 
     * @param string $cache_id contains the cache's id
     * 
     * @since 0.0.8.3
     * 
     * @return string with the cache
     */
    function md_the_cache($cache_id) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load driver
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        // Get cache
        return $CI->cache->get($cache_id);
        
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

        require_once CMS_BASE_PATH . 'inc/components/user_options.php';

        md_get_user_component_options($option);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_set_hook') ) {
    
    /**
     * The function md_set_hook registers hooks
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_hook($hook_name, $args) {

        md_set_hook($hook_name, $args);
        
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
        require_once CMS_BASE_PATH . 'inc/components/user_options.php';

        // Register User's Components Options
        md_set_user_component_options($component_slug, $args);
        
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

if ( !function_exists('set_contents_category_meta') ) {
    
    /**
     * The function set_user_team_page adds contents category meta
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_contents_category_meta($category_slug, $args) {

        require_once CMS_BASE_PATH . 'inc/contents/contents_categories.php';

        md_set_contents_category_meta($category_slug, $args);
        
    }
    
}

if ( !function_exists('set_contents_category_option') ) {
    
    /**
     * The function set_contents_category_option adds contents category option
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_contents_category_option($category_slug, $args) {

        require_once CMS_BASE_PATH . 'inc/contents/contents_categories.php';

        md_set_contents_category_option($category_slug, $args);
        
    }
    
}

if ( !function_exists('set_contents_meta_field') ) {
    
    /**
     * The function set_contents_meta_field sets contents meta field
     * 
     * @param string $method contains the method's name
     * @param function $function contains the function
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    function set_contents_meta_field($method, $function) {

        require_once CMS_BASE_PATH . 'inc/contents/contents_categories.php';

        md_set_contents_meta_field($method, $function);
        
    }
    
}

if ( !function_exists('set_contents_meta_fields') ) {
    
    /**
     * The function set_contents_meta_fields adds admin contents meta fields in the queue
     * 
     * @param string $meta_name contains the meta's name
     * @param string $meta_slug contains the meta's slug
     * @param array $args contains the admin contents meta fields
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_contents_meta_fields($meta_name, $meta_slug, $args) {

        require_once CMS_BASE_PATH . 'inc/contents/contents_categories.php';

        md_set_contents_meta_fields($meta_name, $meta_slug, $args);
        
    }
    
}

if ( !function_exists('set_members_page') ) {
    
    /**
     * The function set_members_page registers members page
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_members_page($page_slug, $args) {

        require_once CMS_BASE_PATH . 'inc/pages/administrator/members_pages.php';

        md_set_members_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('md_create_cache') ) {
    
    /**
     * The function md_create_cache saves cache
     * 
     * @param string $cache_id contains the cache's id
     * @param string $cache_value contains the cache's value
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function md_create_cache($cache_id, $cache_value) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load driver
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        // Save cache
        $CI->cache->save($cache_id, $cache_value, 604800);
        
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

        require_once CMS_BASE_PATH . 'inc/user/general.php';

        return md_delete_user($args);
        
    }
    
}

if ( !function_exists('md_delete_cache') ) {
    
    /**
     * The function md_delete_cache deletes the cache
     * 
     * @param string $cache_id contains the cache's id
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    function md_delete_cache($cache_id) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load driver
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        // Delete cache
        return $CI->cache->delete($cache_id);
        
    }
    
}