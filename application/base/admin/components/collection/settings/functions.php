<?php
/**
 * Settings Functions
 *
 * PHP Version 7.3
 *
 * I've created this file to store several generic 
 * functions called in the view's files
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('api_permission_status') ) {

    /**
     * The function api_permission_status verifies the permission status
     * 
     * @param string $permission contains the permission's slug
     * 
     * @return integer with permission's status
     */
    function api_permission_status( $permission ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load the settings model
        $CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'models/', 'Oauth_permissions_model', 'oauth_permissions_model' );
        
        // Get permission's status
        $status = $CI->oauth_permissions_model->get_permission( $permission );
        
        if ( $status ) {
            
            return $status[0]->status;
            
        } else {
            
            return '0';
            
        }
        
    }

}

if ( !function_exists('settings_menu_item_active') ) {

    /**
     * The function settings_menu_item_active verifies if current menu's item is active
     * 
     * @param string $menu_item contains the menu item
     * 
     * @return void
     */
    function settings_menu_item_active($menu_item=NULL) {

        // Get codeigniter object instance
        $CI = get_instance();

        // Get requested page
        $page = $CI->input->get('p', TRUE);

        // Verify if page is equal to menu_item
        if ( $page === $menu_item ) {
            echo ' class="active"';
        } elseif ( !$page && !$menu_item ) {
            echo ' class="active"';
        }

    }

}

if ( !function_exists('the_settings_list_permissions') ) {

    /**
     * The function the_settings_list_permissions gets the available permissions
     * 
     * @return array with permissions
     */
    function the_settings_list_permissions() {

        // Require the Rest Permissions Inc
        require_once CMS_BASE_PATH . 'inc/rest/api_permissions.php';

        // Get codeigniter object instance
        $CI = get_instance();

        // Get api's permissions
        return md_the_admin_api_permissions();

    }

}