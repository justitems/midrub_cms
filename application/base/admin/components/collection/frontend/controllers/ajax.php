<?php
/**
 * Ajax Controller
 *
 * This file processes the Frontend's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Require the contents_categories function file
require_once APPPATH . 'base/inc/contents/contents_categories.php';

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Frontend\Helpers as CmsBaseAdminComponentsCollectionFrontendHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'frontend', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND);

        // Load Base Contents Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

    }
    
    /**
     * The public method create_new_content creates new content
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function create_new_content() {
        
        // Save contents
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Contents)->save_contents();
        
    }

    /**
     * The public method frontend_get_contents_by_category gets contents by category
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_get_contents_by_category() {
        
        // Get contents
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Contents)->frontend_get_contents_by_category();
        
    }  
    
    /**
     * The public method frontend_delete_content deletes content by content's id
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_delete_content() {
        
        // Delete content
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Contents)->frontend_delete_content();
        
    } 
    
    /**
     * The public method frontend_delete_contents deletes contents by contents ids
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_delete_contents() {
        
        // Delete contents
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Contents)->frontend_delete_contents();
        
    } 
    
    /**
     * The public method settings_auth_pages_list gets auth pages
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function settings_auth_pages_list() {
        
        // Get auth pages
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Settings)->settings_auth_pages_list();
        
    }

    /**
     * The public method save_frontend_settings saves settings changes
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function save_frontend_settings() {
        
        // Saves frontend settings
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Settings)->save_frontend_settings();
        
    }
    
    /**
     * The public method settings_all_options loads selected options
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function settings_all_options() {
        
        // Loads options
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Settings)->settings_all_options();
        
    }

    /**
     * The public method load_theme_templates loads theme's templates
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function load_theme_templates() {
        
        // Loads options
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Themes)->load_theme_templates();
        
    }

    /**
     * The public method frontend_enable_theme enables a theme
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_enable_theme() {
        
        // Enable theme
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Themes)->frontend_enable_theme();
        
    }

    /**
     * The public method frontend_disable_theme disables a theme
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_disable_theme() {
        
        // Disable theme
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Themes)->frontend_disable_theme();
        
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
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Themes)->upload_theme();
        
    }

    /**
     * The public method unzipping_zip extract the theme from the zip
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function unzipping_zip() {
        
        // Extract the theme
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Themes)->unzipping_zip();
        
    }

    /**
     * The public method new_menu_item creates a new menu item
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function new_menu_item() {
        
        // Get menu's item parameters
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Menu)->new_menu_item();
        
    }

    /**
     * The public method frontend_save_menu_items saves menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_save_menu_items() {
        
        // Save menu items
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Menu)->frontend_save_menu_items();
        
    }

    /**
     * The public method frontend_get_menu_items gets menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function frontend_get_menu_items() {
        
        // Gets menu items
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Menu)->frontend_get_menu_items();
        
    }

    /**
     * The public method load_selected_pages gets selected pages
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function load_selected_pages() {
        
        // Gets selected pages
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Menu)->load_selected_pages();
        
    }  

    /**
     * The public method generate_url_slug generate url's slug
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function generate_url_slug() {
        
        // Generate url's slug
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Url)->generate_url_slug();
        
    }
    
    /**
     * The public method save_auth_social_data saves social auth data
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function save_auth_social_data() {
        
        // Save data
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Social)->save_auth_social_data();
        
    }

    /**
     * The public method frontend_upload_content_media uploads a media file
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_upload_content_media() {
        
        // Upload media
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Media)->frontend_upload_content_media();
        
    }

    /**
     * The public method frontend_change_auth_logo changes the logo for the auth's section
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_change_auth_logo() {
        
        // Change the auth's logo
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Media)->frontend_change_auth_logo();
        
    }

    /**
     * The public method frontend_remove_auth_logo removes the logo for the auth's section
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_remove_auth_logo() {
        
        // Remove the auth's logo
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Media)->frontend_remove_auth_logo();
        
    }

    /**
     * The public method get_classification_data gets classification's data
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_classification_data() {
        
        // Display classification's data
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->get_classification_data();
        
    }

    /**
     * The public method create_new_classification_option saves classification's item
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_new_classification_option() {
        
        // Save classification's data
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->create_new_classification_item();
        
    }

    /**
     * The public method load_classifications gets classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_classifications() {
        
        // Request classification's items
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->load_classifications();
        
    }

    /**
     * The public method selected_classification_item gets selected classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function selected_classification_item() {
        
        // Request selected classification's items
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->selected_classification_item();
        
    }

    /**
     * The public method delete_classification delete classification's item from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_classification() {
        
        // Delete item
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->delete_classification();
        
    }

    /**
     * The public method get_classification_parents gets classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_classification_parents() {
        
        // Get parents
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->get_classification_parents();
        
    }

    /**
     * The public method get_content_classifications gets content's classifications from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_content_classifications() {
        
        // Get classifications
        (new CmsBaseAdminComponentsCollectionFrontendHelpers\Classification)->get_content_classifications();
        
    }
 
}

/* End of file ajax.php */