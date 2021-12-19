<?php
/**
 * Midrub Admin Plugins
 *
 * This file loads the Admin Plugins component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Plugins;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_PLUGINS') OR define('CMS_BASE_ADMIN_COMPONENTS_PLUGINS', CMS_BASE_PATH . 'admin/components/collection/plugins/');
defined('CMS_BASE_ADMIN_COMPONENTS_PLUGINS_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_PLUGINS_VERSION', '0.4');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Plugins\Controllers as CmsBaseAdminComponentsCollectionPluginsControllers;

/*
 * Main class loads the Plugins component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the Plugins panel
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionPluginsControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.4
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
            (new CmsBaseAdminComponentsCollectionPluginsControllers\Ajax)->$action();

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
     * @since 0.0.8.4
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load hooks by category
        switch ($category) {

            case 'init':
                
                // Require the Plugins Init Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'inc/plugins_init.php';           

                break;

            case 'admin_init':

                // Require the plugins_hooks file
                require_once CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'inc/plugins_hooks.php';

                // Verify if plugins has opened the plugins's component
                if ( md_the_data('component') === 'plugins' ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'plugins', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PLUGINS);                    

                    // Require the Plugins Init Hooks Inc file
                    require_once CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'inc/plugins_init_hooks.php';    

                    // Require the plugins_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'inc/plugins_pages.php';

                }

                break;

        }

    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.8.4
     * 
     * @return array with admin component's information
     */
    public function component_info() {
        
        // Return component information
        return array(
            'component_name' => 'Plugins',
            'component_slug' => 'plugins',
            'component_icon' => '<i class="icon-calculator"></i>',
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */