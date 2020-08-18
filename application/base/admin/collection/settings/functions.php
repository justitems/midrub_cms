<?php
/**
 * Settings Functions
 *
 * PHP Version 5.6
 *
 * I've created this file to store several generic 
 * functions called in the view's files
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
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
        $CI->load->ext_model( MIDRUB_BASE_ADMIN_SETTINGS . 'models/', 'Oauth_permissions_model', 'oauth_permissions_model' );
        
        // Get permission's status
        $status = $CI->oauth_permissions_model->get_permission( $permission );
        
        if ( $status ) {
            
            return $status[0]->status;
            
        } else {
            
            return '0';
            
        }
        
    }

}

if ( !function_exists('settings_load_options') ) {

    /**
     * The function settings_load_options generates html from imported settings array 
     * 
     * @param string $class_name contains the Options class name
     * 
     * @return void
     */
    function settings_load_options( $class_name ) {

        // Create an array
        $array = array(
            'MidrubBase',
            'Admin',
            'Collection',
            'Settings',
            'Options',
            ucfirst($class_name)
        );

        // Implode the array above
        $cl = implode('\\', $array);
        
        // Display Settings options
        echo (new MidrubBase\Admin\Classes\Settings)->process((new $cl())->get_options());
        
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

if ( !function_exists('settings_list_permissions') ) {

    /**
     * The function settings_list_permissions displays the list with available permissions
     * 
     * @return void
     */
    function settings_list_permissions() {

        // Require the Rest Permissions Inc
        require_once MIDRUB_BASE_PATH . 'inc/rest/api_permissions.php';

        // Get codeigniter object instance
        $CI = get_instance();

        // Get api's permissions
        $permissions = md_the_admin_api_permissions();

        // Verify if Api permissions exists
        if ( $permissions ) {

            foreach ($permissions as $permission) {

                $status = api_permission_status($permission['slug']);

                $selected = $CI->lang->line('settings_private');

                switch ($status) {

                    case '1':

                        $selected = $CI->lang->line('settings_by_request');

                        break;

                    case '2':

                        $selected = $CI->lang->line('settings_public');

                        break;

                }

                echo '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10 col-md-10 col-xs-10">'
                            . '<h4>'
                                . $permission['name'] . ' (' . $permission['slug'] . ')'
                            . '</h4>'
                            . '<p>'
                                . $permission['description']
                            . '</p>'
                        . '</div>'
                        . '<div class="col-lg-2 col-md-2 col-xs-2">'
                            . '<div class="btn-group" data-permission="' . $permission['slug'] . '">'
                                . '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdown-' . $permission['slug'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                    . $selected
                                . '</button>'
                                . '<div class="dropdown-menu" aria-labelledby="dropdown-' . $permission['slug'] . '">'
                                    . '<a class="dropdown-item" href="#" data-type="0">'
                                        . $CI->lang->line('settings_private')
                                    . '</a>'
                                    . '<a class="dropdown-item" href="#" data-type="1">'
                                        . $CI->lang->line('settings_by_request')
                                    . '</a>'
                                    . '<a class="dropdown-item" href="#" data-type="2">'
                                        . $CI->lang->line('settings_public')
                                    . '</a>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';

            }
            
        }

    }

}

if ( !function_exists('settings_list_permissions_for_apps') ) {

    /**
     * The function settings_list_permissions_for_apps displays the list with available permissions in the app's modal
     * 
     * @return void
     */
    function settings_list_permissions_for_apps() {

        // Require the Rest Permissions Inc
        require_once MIDRUB_BASE_PATH . 'inc/rest/api_permissions.php';

        // Get api's permissions
        $permissions = md_the_admin_api_permissions();

        // Verify if Api permissions exists
        if ( $permissions ) {

            $permissions_list = array();

            foreach ( $permissions as $permission ) {

                if ( in_array($permission['slug'], $permissions_list) ) {
                    continue;
                } else {
                    $permissions_list[] = $permission['slug'];
                }

                echo '<li>'
                        . '<button class="btn btn-default select-app-permission" type="button" data-permission="' . $permission['slug'] . '">'
                            . $permission['slug']
                        . '</button>'
                    . '</li>';

            }
            
        }

    }

}