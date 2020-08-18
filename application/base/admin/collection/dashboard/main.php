<?php
/**
 * Midrub Dashboard
 *
 * This file loads the Dashboard component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Dashboard;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_DASHBOARD') OR define('MIDRUB_BASE_ADMIN_DASHBOARD', MIDRUB_BASE_PATH . 'admin/collection/dashboard/');
defined('MIDRUB_BASE_ADMIN_DASHBOARD_VERSION') OR define('MIDRUB_BASE_ADMIN_DASHBOARD_VERSION', '0.0.1');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\Dashboard\Controllers as MidrubBaseAdminCollectionDashboardControllers;

/*
 * Main class loads the dashboard component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Main implements MidrubBaseAdminInterfaces\Admin {
    
    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the admin panel
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new MidrubBaseAdminCollectionDashboardControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.1
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
            (new MidrubBaseAdminCollectionDashboardControllers\Ajax)->$action();

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
     * @since 0.0.8.1
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
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the Dashboard component's info
     * 
     * @since 0.0.8.1
     * 
     * @return array with Dashboard component's information
     */
    public function component_info() {
        
        // Load the component's language files
        $this->CI->lang->load( 'dashboard', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_DASHBOARD );
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('dashboard'),
            'display_app_name' => $this->CI->lang->line('dashboard'),
            'component_slug' => 'dashboard',
            'component_icon' => '<i class="icon-speedometer"></i>',
            'version' => MIDRUB_BASE_ADMIN_DASHBOARD_VERSION,
            'required_version' => '0.0.8.1'
        );
        
    }

}

/* End of file main.php */