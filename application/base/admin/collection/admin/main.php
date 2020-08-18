<?php
/**
 * Midrub Admin
 *
 * This file loads the Admin component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Admin;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_ADMIN') OR define('MIDRUB_BASE_ADMIN_ADMIN', MIDRUB_BASE_PATH . 'admin/collection/admin/');
defined('MIDRUB_BASE_ADMIN_ADMIN_VERSION') OR define('MIDRUB_BASE_ADMIN_ADMIN_VERSION', '0.0.2');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\Admin\Controllers as MidrubBaseAdminCollectionAdminControllers;

/*
 * Main class loads the admin component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Main implements MidrubBaseAdminInterfaces\Admin {
    
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
        (new MidrubBaseAdminCollectionAdminControllers\Init)->view();
        
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

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {

            // Call method if exists
            (new MidrubBaseAdminCollectionAdminControllers\Ajax)->$action();

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
     * @since 0.0.8.0
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the component's language files
        $this->CI->lang->load( 'admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_ADMIN );

        // Load hooks by category
        switch ($category) {

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Require the admin_pages functions file
                require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/admin_pages.php';

                // Verify if admin has opened the admin component
                if ( md_the_component_variable('component') === 'admin' ) {

                    // Require the admin_pages file
                    require_once MIDRUB_BASE_ADMIN_ADMIN . '/inc/admin_pages.php';

                }

                break;

        }

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
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.8.0
     * 
     * @return array with admin component's information
     */
    public function component_info() {
        
        // Load the component's language files
        $this->CI->lang->load( 'admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_ADMIN );
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('admin'),
            'display_app_name' => $this->CI->lang->line('admin'),
            'component_slug' => 'admin',
            'component_icon' => '<i class="far fa-edit"></i>',
            'version' => '0.0.1',
            'required_version' => '0.0.8.0'
        );
        
    }

}

/* End of file main.php */