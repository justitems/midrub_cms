<?php
/**
 * Ajax Controller
 *
 * This file processes the Update's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Update\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Update\Helpers as MidrubBaseAdminCollectionUpdateHelpers;

/*
 * Ajax class processes the Update's component's ajax calls
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
        $this->CI->lang->load( 'update', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_UPDATE );

    }
    
    /**
     * The public method update_midrub starts to update the system
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function update_midrub() {
        
        // Verify if Midrub can be updated
        (new MidrubBaseAdminCollectionUpdateHelpers\Midrub)->verify();
        
    }

    /**
     * The public method download_midrub_update starts to download the Midrub's update
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function download_midrub_update() {
        
        // Download Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Midrub)->download_update();
        
    }

    /**
     * The public method extract_midrub_update extracts the Midrub's update
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function extract_midrub_update() {
        
        // Extract Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Midrub)->extract_update();
        
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
        (new MidrubBaseAdminCollectionUpdateHelpers\Midrub)->start_backup();
        
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
        (new MidrubBaseAdminCollectionUpdateHelpers\Midrub)->restore_backup();
        
    }

    /**
     * The public method update_midrub_app verifies if the app can be updated
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function update_midrub_app() {
        
        // Verify if the Midrub's app can be updated
        (new MidrubBaseAdminCollectionUpdateHelpers\Apps)->verify();
        
    }

    /**
     * The public method download_app_update starts to download the app's update
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function download_app_update() {
        
        // Download Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Apps)->download_update();
        
    }

    /**
     * The public method extract_app_update extracts app's update
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function extract_app_update() {
        
        // Extract App Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Apps)->extract_update();
        
    }

    /**
     * The public method start_app_backup backups the files to update
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function start_app_backup() {
        
        // Backups the files to update and save update
        (new MidrubBaseAdminCollectionUpdateHelpers\Apps)->start_backup();
        
    }

    /**
     * The public method update_midrub_user_component verifies if the user's component can be updated
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function update_midrub_user_component() {
        
        // Verify if the Midrub's user component can be updated
        (new MidrubBaseAdminCollectionUpdateHelpers\User_components)->verify();
        
    }

    /**
     * The public method download_user_component_update starts to download the user components update
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function download_user_component_update() {
        
        // Download Update
        (new MidrubBaseAdminCollectionUpdateHelpers\User_components)->download_update();
        
    }

    /**
     * The public method extract_user_component_update extracts user components update
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function extract_user_component_update() {
        
        // Extract User Component Update
        (new MidrubBaseAdminCollectionUpdateHelpers\User_components)->extract_update();
        
    }

    /**
     * The public method start_user_component_backup backups the files to update
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function start_user_component_backup() {
        
        // Backups the files to update and save update
        (new MidrubBaseAdminCollectionUpdateHelpers\User_components)->start_backup();
        
    }

    /**
     * The public method update_midrub_frontend_theme verifies if the frontend theme can be updated
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function update_midrub_frontend_theme() {
        
        // Verify if the frontend theme can be updated
        (new MidrubBaseAdminCollectionUpdateHelpers\Frontend_themes)->verify();
        
    }

    /**
     * The public method download_frontend_theme_update starts to download the frontend theme update
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function download_frontend_theme_update() {
        
        // Download Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Frontend_themes)->download_update();
        
    }

    /**
     * The public method extract_frontend_theme_update extracts user theme update
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function extract_frontend_theme_update() {
        
        // Extract User Component Update
        (new MidrubBaseAdminCollectionUpdateHelpers\Frontend_themes)->extract_update();
        
    }

    /**
     * The public method start_frontend_theme_backup backups the files to update
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function start_frontend_theme_backup() {
        
        // Backups the files to update and save update
        (new MidrubBaseAdminCollectionUpdateHelpers\Frontend_themes)->start_backup();
        
    }


}

/* End of file ajax.php */