<?php
/**
 * Midrub Admin Settings
 *
 * This file loads the Admin Settings component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_SETTINGS') OR define('CMS_BASE_ADMIN_COMPONENTS_SETTINGS', APPPATH . 'base/admin/components/collection/settings/');
defined('CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION', '0.0.8');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Settings\Controllers as CmsBaseAdminComponentsCollectionSettingsControllers;

// Require the functions file
require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . '/functions.php';

/*
 * Main class loads the Settings component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the user panel
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionSettingsControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function ajax() {
        
        // Get action's get input
        $action = $this->CI->input->get('action');

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {

            // Call method if exists
            (new CmsBaseAdminComponentsCollectionSettingsControllers\Ajax)->$action();

        } catch (Exception $ex) {

            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );

            echo json_encode($data);

        }
        
    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.7.8
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Verify if action parameter exists
        if ( $this->CI->input->post('action', TRUE) ) {

            if ( substr($this->CI->input->post('action', TRUE), 0, 8) === 'settings' ) {

                // Set loaded app
                md_set_data('component', 'settings');

            }

        }

        // Load hooks by category
        switch ($category) {

            case 'init':
                
                // Require the Storage Init Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'inc/storage_init.php';           

                break;

            case 'admin_init':

                // Require the settings_hooks file
                require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'inc/settings_hooks.php';

                // Verify if is loaded the Settings component
                if ( md_the_data('component') === 'settings' ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SETTINGS);               

                    // Require the Storage Init Hooks Inc file
                    require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'inc/storage_init_hooks.php';

                }

                break;

        }

    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.7.8
     * 
     * @return array with admin component's information
     */
    public function component_info() {
        
        // Return component information
        return array(
            'component_name' => 'Settings',
            'component_slug' => 'settings',
            'component_icon' => '<i class="fas fa-cog"></i>',
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */