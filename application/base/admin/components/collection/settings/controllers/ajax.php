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
namespace  CmsBase\Admin\Components\Collection\Settings\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Settings\Helpers as CmsBaseAdminComponentsCollectionSettingsHelpers;

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
        $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SETTINGS );
        
    }
    
    /**
     * The public method settings_save_admin_settings saves the admin's settings
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function settings_save_admin_settings() {
        
        // Save
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Settings)->settings_save_admin_settings();
        
    }

    /**
     * The public method settings_get_storage_dropdown_items loads the storage's dropdown items
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function settings_get_storage_dropdown_items() {
        
        // Get the items
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Storage)->settings_get_storage_dropdown_items();
        
    }

    /**
     * The public method get_coupon_codes gets coupons codes
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function get_coupon_codes() {
        
        // Get coupon codes
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Coupons)->get_coupon_codes();
        
    }

    /**
     * The public method delete_coupon_code deletes coupons codes
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function delete_coupon_code() {
        
        // Delete coupon codes
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Coupons)->delete_coupon_code();
        
    }
    
    /**
     * The public method load_referrals_reports loads referrals reports
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function load_referrals_reports() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Referrals)->load_referrals_reports();
        
    }
    
    /**
     * The public method load_referrers_list loads referrers list
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function load_referrers_list() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Referrals)->load_referrers_list();
        
    }
    
    /**
     * The public method referral_pay_gains pays user gains
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function referral_pay_gains() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Referrals)->referral_pay_gains();
        
    }  

    /**
     * The public method create_new_api_app creates a new application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function create_new_api_app() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Oauth)->create_new_api_app();
        
    }
    
    /**
     * The public method update_api_app updates an application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function update_api_app() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Oauth)->update_api_app();
        
    }    

    /**
     * The public method load_api_applications loads the api's list
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function load_api_applications() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Oauth)->load_applications_list();
        
    }    
    
    /**
     * The public method delete_api_application deletes an application
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function delete_api_application() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Oauth)->delete_api_application();
        
    }
    
    /**
     * The public method manage_api_application get application's details
     * 
     * @since 0.0.7.7
     * 
     * @return void
     */
    public function manage_api_application() {
        
        (new CmsBaseAdminComponentsCollectionSettingsHelpers\Oauth)->manage_api_application();
        
    }    
 
}

/* End of file ajax.php */