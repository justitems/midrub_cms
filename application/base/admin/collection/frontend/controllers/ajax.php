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
namespace MidrubBase\Admin\Collection\Frontend\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Require the contents_categories function file
require_once APPPATH . 'base/inc/contents/contents_categories.php';

// Define the namespaces to use
use MidrubBase\Admin\Collection\Frontend\Helpers as MidrubBaseAdminCollectionFrontendHelpers;

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
        $this->CI->lang->load( 'frontend', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_FRONTEND);

        // Load Base Contents Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

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
        (new MidrubBaseAdminCollectionFrontendHelpers\Contents)->save_contents();
        
    }

    /**
     * The public method load_contents_by_category loads contents by category
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function load_contents_by_category() {
        
        // Get contents
        (new MidrubBaseAdminCollectionFrontendHelpers\Contents)->load_contents_by_category();
        
    }  
    
    /**
     * The public method delete_content deletes content by content's id
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function delete_content() {
        
        // Delete content
        (new MidrubBaseAdminCollectionFrontendHelpers\Contents)->delete_content();
        
    } 
    
    /**
     * The public method delete_contents deletes contents by contents ids
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function delete_contents() {
        
        // Delete contents
        (new MidrubBaseAdminCollectionFrontendHelpers\Contents)->delete_contents();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Settings)->settings_auth_pages_list();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Settings)->save_frontend_settings();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Settings)->settings_all_options();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Themes)->load_theme_templates();
        
    }

    /**
     * The public method activate_theme activates a theme
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function activate_theme() {
        
        // Activate theme
        (new MidrubBaseAdminCollectionFrontendHelpers\Themes)->activate();
        
    }

    /**
     * The public method deactivate_theme deactivates a theme
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function deactivate_theme() {
        
        // Deactivate theme
        (new MidrubBaseAdminCollectionFrontendHelpers\Themes)->deactivate();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Themes)->upload_theme();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Themes)->unzipping_zip();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Menu)->new_menu_item();
        
    }

    /**
     * The public method save_menu_items saves menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function save_menu_items() {
        
        // Save menu items
        (new MidrubBaseAdminCollectionFrontendHelpers\Menu)->save_menu_items();
        
    }

    /**
     * The public method get_menu_items gets menu's items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function get_menu_items() {
        
        // Gets menu items
        (new MidrubBaseAdminCollectionFrontendHelpers\Menu)->get_menu_items();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Menu)->load_selected_pages();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Url)->generate_url_slug();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Social)->save_auth_social_data();
        
    }

    /**
     * The public method load_multimedia loads the user's multimedia
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function load_multimedia() {
        
        // Load media
        (new MidrubBaseAdminCollectionFrontendHelpers\Multimedia)->load_multimedia();
        
    }

    /**
     * The public method upload_media_in_storage uploads media in storage
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function upload_media_in_storage() {
        
        // Save data
        (new MidrubBaseAdminCollectionFrontendHelpers\Multimedia)->upload_media_in_storage();
        
    }

    /**
     * The public method delete_media_item deletes media items
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function delete_media_item() {
        
        // Delete items
        (new MidrubBaseAdminCollectionFrontendHelpers\Multimedia)->delete_media_item();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->get_classification_data();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->create_new_classification_item();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->load_classifications();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->selected_classification_item();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->delete_classification();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->get_classification_parents();
        
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
        (new MidrubBaseAdminCollectionFrontendHelpers\Classification)->get_content_classifications();
        
    }
 
}

/* End of file ajax.php */