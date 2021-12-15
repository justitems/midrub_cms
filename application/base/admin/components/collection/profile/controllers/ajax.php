<?php
/**
 * Ajax Controller
 *
 * This file processes the Profile's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Profile\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Profile\Helpers as CmsBaseAdminComponentsCollectionProfileHelpers;

/*
 * Ajax class processes the Profile component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'profile', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PROFILE);

    }

    /**
     * The public method profile_change_profile_image changes the profile's image
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_change_profile_image() {

        // Upload image
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Media)->profile_change_profile_image();
        
    } 

    /**
     * The public method profile_remove_profile_image removes the profile's image
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_remove_profile_image() {

        // Removes image
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Media)->profile_remove_profile_image();
        
    } 

    /**
     * The public method profile_update_general_info updates the general profile's data
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_general_info() {

        // Save data
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Profile)->profile_update_general_info();
        
    } 

    /**
     * The public method profile_update_preferences updates the profile's preferences
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_preferences() {

        // Save data
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Profile)->profile_update_preferences();
        
    } 

    /**
     * The public method profile_update_security updates the profile's password
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_security() {

        // Save data
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Profile)->profile_update_security();
        
    } 

    /**
     * The public method profile_get_countries gets the countries list
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_get_countries() {

        // Gets the countries
        (new CmsBaseAdminComponentsCollectionProfileHelpers\Profile)->profile_get_countries();
        
    } 

}

/* End of file ajax.php */