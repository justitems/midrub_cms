<?php
/**
 * Ajax Controller
 *
 * This file processes the Settings's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace  MidrubBase\Admin\Collection\Settings\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Settings\Helpers as MidrubBaseAdminCollectionSettingsHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.6
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.6
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        if ( file_exists( MIDRUB_BASE_ADMIN_SETTINGS . '/language/' . $this->CI->config->item('language') . '/settings_lang.php' ) ) {
            $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SETTINGS . '/' );
        }
        
    }
    
    /**
     * The public method save_admin_options saves the admin's settings
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function save_admin_settings() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Settings)->save_admin_settings();
        
    }
    
    /**
     * The public method load_referrals_reports loads referrals reports
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function load_referrals_reports() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Referrals)->load_referrals_reports();
        
    }
    
    /**
     * The public method load_referrers_list loads referrers list
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function load_referrers_list() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Referrals)->load_referrers_list();
        
    }
    
    /**
     * The public method referral_pay_gains pays user gains
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function referral_pay_gains() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Referrals)->referral_pay_gains();
        
    }
    
    /**
     * The public method update_api_permission_settings saves permission status
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function update_api_permission_settings() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->update_api_permission_settings();
        
    }    

    /**
     * The public method create_new_api_app creates a new application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function create_new_api_app() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->create_new_api_app();
        
    }
    
    /**
     * The public method update_api_app updates an application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function update_api_app() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->update_api_app();
        
    }    

    /**
     * The public method load_api_applications loads the api's list
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function load_api_applications() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->load_applications_list();
        
    }    
    
    /**
     * The public method delete_api_application deletes an application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function delete_api_application() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->delete_api_application();
        
    }
    
    /**
     * The public method manage_api_application get application's details
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function manage_api_application() {
        
        (new MidrubBaseAdminCollectionSettingsHelpers\Oauth)->manage_api_application();
        
    }
 
}

/* End of file ajax.php */