<?php
/**
 * Ajax Controller
 *
 * This file processes the Updates's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Updates\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Updates\Helpers as CmsBaseAdminCollectionUpdatesHelpers;

/*
 * Ajax class processes the Updates's component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'updates', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_UPDATES );

    }
    
    /**
     * The public method updates_midrub starts to updates the system
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function updates_midrub() {
        
        // Verify if Midrub can be updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Midrub)->verify();
        
    }

    /**
     * The public method download_midrub_updates starts to download the Midrub's updates
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function download_midrub_updates() {
        
        // Download Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Midrub)->download_updates();
        
    }

    /**
     * The public method extract_midrub_updates extracts the Midrub's updates
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function extract_midrub_updates() {
        
        // Extract Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Midrub)->extract_updates();
        
    }

    /**
     * The public method start_midrub_backup starts backup creation
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function start_midrub_backup() {
        
        // Backup
        (new CmsBaseAdminCollectionUpdatesHelpers\Midrub)->start_backup();
        
    }

    /**
     * The public method restore_midrub_backup restores a backup
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function restore_midrub_backup() {
        
        // Restore Backup
        (new CmsBaseAdminCollectionUpdatesHelpers\Midrub)->restore_backup();
        
    }

    /**
     * The public method updates_midrub_app verifies if the app can be updates
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function updates_midrub_app() {
        
        // Verify if the Midrub's app can be updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Apps)->verify();
        
    }

    /**
     * The public method download_app_updates starts to download the app's updates
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function download_app_updates() {
        
        // Download Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Apps)->download_updates();
        
    }

    /**
     * The public method extract_app_updates extracts app's updates
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function extract_app_updates() {
        
        // Extract App Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Apps)->extract_updates();
        
    }

    /**
     * The public method start_app_backup backups the files to updates
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function start_app_backup() {
        
        // Backups the files to updates and save updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Apps)->start_backup();
        
    }

    /**
     * The public method updates_midrub_user_component verifies if the user's component can be updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function updates_midrub_user_component() {
        
        // Verify if the Midrub's user component can be updates
        (new CmsBaseAdminCollectionUpdatesHelpers\User_components)->verify();
        
    }

    /**
     * The public method download_user_component_updates starts to download the user components updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function download_user_component_updates() {
        
        // Download Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\User_components)->download_updates();
        
    }

    /**
     * The public method extract_user_component_updates extracts user components updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function extract_user_component_updates() {
        
        // Extract User Component Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\User_components)->extract_updates();
        
    }

    /**
     * The public method start_user_component_backup backups the files to updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function start_user_component_backup() {
        
        // Backups the files to updates and save updates
        (new CmsBaseAdminCollectionUpdatesHelpers\User_components)->start_backup();
        
    }

    /**
     * The public method updates_midrub_frontend_theme verifies if the frontend theme can be updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function updates_midrub_frontend_theme() {
        
        // Verify if the frontend theme can be updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Frontend_themes)->verify();
        
    }

    /**
     * The public method download_frontend_theme_updates starts to download the frontend theme updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function download_frontend_theme_updates() {
        
        // Download Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Frontend_themes)->download_updates();
        
    }

    /**
     * The public method extract_frontend_theme_updates extracts user theme updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function extract_frontend_theme_updates() {
        
        // Extract User Component Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Frontend_themes)->extract_updates();
        
    }

    /**
     * The public method start_frontend_theme_backup backups the files to updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function start_frontend_theme_backup() {
        
        // Backups the files to updates and save updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Frontend_themes)->start_backup();
        
    }

    /**
     * The public method updates_midrub_plugin verifies if the plugin can be updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function updates_midrub_plugin() {
        
        // Verify if the Midrub's plugin can be updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Plugins)->verify();
        
    }

    /**
     * The public method download_plugin_updates starts to download the plugins updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function download_plugin_updates() {
        
        // Download Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Plugins)->download_updates();
        
    }

    /**
     * The public method extract_plugin_updates extracts plugins updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function extract_plugin_updates() {
        
        // Extract Plugin Updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Plugins)->extract_updates();
        
    }

    /**
     * The public method start_plugin_backup backups the files to updates
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function start_plugin_backup() {
        
        // Backups the files to updates and save updates
        (new CmsBaseAdminCollectionUpdatesHelpers\Plugins)->start_backup();
        
    }

}

/* End of file ajax.php */