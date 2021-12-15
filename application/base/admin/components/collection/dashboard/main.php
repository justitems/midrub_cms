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
namespace CmsBase\Admin\Components\Collection\Dashboard;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_DASHBOARD') OR define('CMS_BASE_ADMIN_COMPONENTS_DASHBOARD', CMS_BASE_PATH . 'admin/components/collection/dashboard/');
defined('CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION', '0.0.399999999');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Dashboard\Controllers as CmsBaseAdminComponentsCollectionDashboardControllers;

/*
 * Main class loads the dashboard component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
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
        (new CmsBaseAdminComponentsCollectionDashboardControllers\Init)->view();
        
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
            (new CmsBaseAdminComponentsCollectionDashboardControllers\Ajax)->$action();

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
        
        // Load hooks by category
        switch ($category) {

            case 'init':
                
                require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/dashboard_init.php';

                break;

            case 'admin_init':
                        
                require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/dashboard_hooks.php'; 

                // Verify if user has opened the dashboard component
                if ( md_the_data('component') === 'dashboard' ) {
                    require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/dashboard_widgets.php'; 
                }

                break;

        }

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
        get_instance()->lang->load( 'dashboard_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_DASHBOARD );

        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('dashboard'),
            'component_slug' => 'dashboard',
            'component_icon' => md_the_admin_icon(array('icon' => 'home')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */