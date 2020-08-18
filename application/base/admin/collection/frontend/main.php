<?php
/**
 * Midrub Admin Frontend
 *
 * This file loads the Admin Frontend component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Frontend;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_FRONTEND') OR define('MIDRUB_BASE_ADMIN_FRONTEND', APPPATH . 'base/admin/collection/frontend/');
defined('MIDRUB_BASE_ADMIN_FRONTEND_VERSION') OR define('MIDRUB_BASE_ADMIN_FRONTEND_VERSION', '0.0.3992');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\Frontend\Controllers as MidrubBaseAdminCollectionFrontendControllers;

/*
 * Main class loads the Frontend component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Main implements MidrubBaseAdminInterfaces\Admin {
    
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
        (new MidrubBaseAdminCollectionFrontendControllers\Init)->view();
        
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
            (new MidrubBaseAdminCollectionFrontendControllers\Ajax)->$action();

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

        // Load the component's language files
        $this->CI->lang->load( 'frontend', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_FRONTEND);

        // Load hooks by category
        switch ($category) {

            case 'auth_init':
            case 'frontend_init':

            
                break;
            case 'admin_init':

                // Require the contents_categories functions file
                require_once MIDRUB_BASE_PATH . 'inc/contents/contents_categories.php';

                // Require the frontend_pages functions file
                require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/frontend_pages.php';

                // Verify if user has opened the frontend component
                if ( md_the_component_variable('component') === 'frontend' ) {

                    // Require the contents_categories file
                    require_once MIDRUB_BASE_ADMIN_FRONTEND . 'inc/contents_categories.php';

                    // Require the frontend_pages file
                    require_once MIDRUB_BASE_ADMIN_FRONTEND . 'inc/frontend_pages.php';

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
        
        // Load the component's language files
        $this->CI->lang->load( 'frontend', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_FRONTEND );
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('frontend'),
            'display_app_name' => $this->CI->lang->line('frontend'),
            'component_slug' => 'frontend',
            'component_icon' => '<i class="far fa-edit"></i>',
            'version' => '0.0.1',
            'required_version' => '0.0.7.8'
        );
        
    }

}

/* End of file main.php */