<?php
/**
 * Midrub Updates
 *
 * This file loads the Updates component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Updates;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_UPDATES') OR define('CMS_BASE_ADMIN_COMPONENTS_UPDATES', CMS_BASE_PATH . 'admin/components/collection/updates/');
defined('CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION', '0.0.5');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Updates\Controllers as CmsBaseAdminCollectionUpdatesControllers;

/*
 * Main class loads the updates component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the admin panel
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminCollectionUpdatesControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function ajax() {
        
        // Get action's get input
        $action = $this->CI->input->get('action');

        // Verify if get action parameter exists
        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {

            // Call method if exists
            (new CmsBaseAdminCollectionUpdatesControllers\Ajax)->$action();

        } catch (\Throwable $ex) {
            
            // Prepare the error message
            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );
            
            // Display the error message
            echo json_encode($data);
            
        }
        
    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.8.0
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {



    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the Updates component's info
     * 
     * @since 0.0.8.0
     * 
     * @return array with Updates component's information
     */
    public function component_info() {
        
        // Return component information
        return array(
            'component_name' => 'Updates',
            'component_slug' => 'updates',
            'component_icon' => '<i class="far fa-edit"></i>',
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */