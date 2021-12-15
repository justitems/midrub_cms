<?php
/**
 * Ajax Controller
 *
 * This file processes the User's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\User\Helpers as CmsBaseAdminComponentsCollectionUserHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method user_save_social_data saves social configuration data
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_save_social_data() {
        
        // Save data
        (new CmsBaseAdminComponentsCollectionUserHelpers\Social)->user_save_social_data();
        
    }

    /**
     * The public method upload_network uploads an network to be installed
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function upload_network() {
        
        // Uploads network
        (new CmsBaseAdminComponentsCollectionUserHelpers\Social)->upload_network();
        
    }

    /**
     * The public method unzipping_network_zip extract the network from the zip
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function unzipping_network_zip() {
        
        // Extract the network
        (new CmsBaseAdminComponentsCollectionUserHelpers\Social)->unzipping_zip();
        
    }

    /**
     * The public method create_new_plan creates a new plan
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_new_plan() {
        
        // Create new plan
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans)->create_new_plan();
        
    }

    /**
     * The public method user_update_a_plan updates a plan
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_update_a_plan() {
        
        // Update a plan
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans)->user_update_a_plan();
        
    }

    /**
     * The public method load_all_plans loads plans
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_all_plans() {
        
        // Loads plans
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans)->load_all_plans();
        
    }

    /**
     * The public method delete_plans deletes plans
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_plans() {
        
        // Deletes plans
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans)->delete_plans();
        
    }

    /**
     * The public method create_plans_group creates a plans group
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function create_plans_group() {
        
        // Create group
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans_groups)->create_plans_group();
        
    }

    /**
     * The public method load_all_plans_groups loads groups by page
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function load_all_plans_groups() {
        
        // Loads groups
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans_groups)->load_all_plans_groups();
        
    }

    /**
     * The public method delete_plans_group deletes plans groups
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function delete_plans_group() {
        
        // Deletes groups
        (new CmsBaseAdminComponentsCollectionUserHelpers\Plans_groups)->delete_plans_group();
        
    }

    /**
     * The public method new_menu_item creates a new menu item
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function new_menu_item() {
        
        // Get menu's item parameters
        (new CmsBaseAdminComponentsCollectionUserHelpers\Menu)->new_menu_item();
        
    }

    /**
     * The public method save_menu_items saves menu's items
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function save_menu_items() {
        
        // Save menu items
        (new CmsBaseAdminComponentsCollectionUserHelpers\Menu)->save_menu_items();
        
    }

    /**
     * The public method user_get_menu_items gets menu's items
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function user_get_menu_items() {
        
        // Gets menu items
        (new CmsBaseAdminComponentsCollectionUserHelpers\Menu)->user_get_menu_items();
        
    }

    /**
     * The public method settings_components_and_apps_list gets components and apps
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function settings_components_and_apps_list() {
        
        // Gets components and apps
        (new CmsBaseAdminComponentsCollectionUserHelpers\Components)->settings_components_and_apps_list();
        
    }

    /**
     * The public method load_selected_components gets components and apps
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_selected_components() {
        
        // Gets components and apps
        (new CmsBaseAdminComponentsCollectionUserHelpers\Components)->load_selected_components();
        
    }

    /**
     * The public method upload_component uploads an component to be installed
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function upload_component() {
        
        // Uploads component
        (new CmsBaseAdminComponentsCollectionUserHelpers\Components)->upload_component();
        
    }

    /**
     * The public method unzipping_component_zip extract the component from the zip
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function unzipping_component_zip() {
        
        // Extract the component
        (new CmsBaseAdminComponentsCollectionUserHelpers\Components)->unzipping_zip();
        
    }

    /**
     * The public method user_enable_theme enables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function user_enable_theme() {
        
        // Enable theme
        (new CmsBaseAdminComponentsCollectionUserHelpers\Themes)->enable();
        
    }

    /**
     * The public method user_disable_theme disables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function user_disable_theme() {
        
        // Disable theme
        (new CmsBaseAdminComponentsCollectionUserHelpers\Themes)->disable();
        
    }

    /**
     * The public method upload_theme uploads an theme to be installed
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function upload_theme() {
        
        // Uploads theme
        (new CmsBaseAdminComponentsCollectionUserHelpers\Themes)->upload_theme();
        
    }

    /**
     * The public method unzipping_theme_zip extract the theme from the zip
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function unzipping_theme_zip() {
        
        // Extract the theme
        (new CmsBaseAdminComponentsCollectionUserHelpers\Themes)->unzipping_zip();
        
    }

    /**
     * The public method user_save_user_settings saves user changes
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function user_save_user_settings() {
        
        // Saves user settings
        (new CmsBaseAdminComponentsCollectionUserHelpers\Settings)->user_save_user_settings();
        
    }

    /**
     * The public method user_update_settings update the user's settings
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_update_settings() {
        
        // Updates user's settings
        (new CmsBaseAdminComponentsCollectionUserHelpers\Settings)->user_update_settings();
        
    }

    /**
     * The public method upload_app uploads an app to be installed
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function upload_app() {
        
        // Uploads App
        (new CmsBaseAdminComponentsCollectionUserHelpers\Apps)->upload_app();
        
    }

    /**
     * The public method unzipping_zip extract the app from the zip
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function unzipping_zip() {
        
        // Extract the app
        (new CmsBaseAdminComponentsCollectionUserHelpers\Apps)->unzipping_zip();
        
    }

    /**
     * The public method user_change_user_logo changes the user's logo
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_change_user_logo() {
        
        // Change the user's logo
        (new CmsBaseAdminComponentsCollectionUserHelpers\Media)->user_change_user_logo();
        
    }

    /**
     * The public method user_remove_logo removes the user's logo
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_remove_logo() {
        
        // Remove the user's logo
        (new CmsBaseAdminComponentsCollectionUserHelpers\Media)->user_remove_logo();
        
    }

}

/* End of file ajax.php */