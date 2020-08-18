<?php
/**
 * Ajax Controller
 *
 * This file processes the app's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Settings\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Settings\Helpers as MidrubBaseUserComponentsCollectionSettingsHelpers;

/*
 * Ajaz class processes the app's ajax calls
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
     * The public method save_user_settings saves user's settings
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function save_user_settings() {
        
        // Save user settings
        (new MidrubBaseUserComponentsCollectionSettingsHelpers\Settings)->save_user_settings();
        
    } 

    /**
     * The public method change_user_password tries to change the user's password
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function change_user_password() {
        
        // Change user's password
        (new MidrubBaseUserComponentsCollectionSettingsHelpers\Settings)->change_user_password();
        
    } 

    /**
     * The public method settings_load_invoices returns user's invoices by page
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function settings_load_invoices() {
        
        // Load invoices
        (new MidrubBaseUserComponentsCollectionSettingsHelpers\Invoices)->settings_load_invoices();
        
    }     
    
}
