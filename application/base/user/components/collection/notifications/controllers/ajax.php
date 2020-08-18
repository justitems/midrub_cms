<?php
/**
 * Ajax Controller
 *
 * This file processes the component's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Notifications\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Notifications\Helpers as MidrubBaseUserComponentsCollectionNotificationsHelpers;

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

        // Load language
        $this->CI->lang->load( 'notifications_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS );

        // Load Notifications Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_model', 'notifications_model' );
        
    }

    /**
     * The public method load_notifications_by_page loads notifications by page
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_notifications_by_page() {
        
        // Load notifications
        (new MidrubBaseUserComponentsCollectionNotificationsHelpers\Notifications)->load_notifications_by_page();
        
    } 

    /**
     * The public method delete_notification deletes notifications
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_notification() {
        
        // Delete notifications
        (new MidrubBaseUserComponentsCollectionNotificationsHelpers\Notifications)->delete_notification();
        
    } 
    
}
