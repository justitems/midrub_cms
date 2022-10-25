<?php
/**
 * Midrub Admin Frontend
 *
 * This file loads the Admin Frontend component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_FRONTEND') OR define('CMS_BASE_ADMIN_COMPONENTS_FRONTEND', APPPATH . 'base/admin/components/collection/frontend/');
defined('CMS_BASE_ADMIN_COMPONENTS_FRONTEND_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_FRONTEND_VERSION', '0.0.67');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Frontend\Controllers as CmsBaseAdminComponentsCollectionFrontendControllers;

/*
 * Main class loads the Frontend component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the user panel
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionFrontendControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.5
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
            (new CmsBaseAdminComponentsCollectionFrontendControllers\Ajax)->$action();

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
     * @since 0.0.8.5
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load hooks by category
        switch ($category) {

            case 'init':

                // Require the init functions file
                require_once CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'inc/frontend_init.php';

                break;
            case 'auth_init':
            case 'frontend_init':

            
                break;
            case 'admin_init':

                // Require the contents_categories functions file
                require_once CMS_BASE_PATH . 'inc/contents/contents_categories.php';

                // Require the frontend_hooks functions file
                require_once CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'inc/frontend_hooks.php'; 

                // Verify if user has opened the frontend component
                if ( md_the_data('component') === 'frontend' ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'frontend', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND);

                    // Require the contents_categories file
                    require_once CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'inc/contents_categories.php';

                    // Require the frontend_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'inc/frontend_pages.php';

                }

                break;

        }

    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.8.5
     * 
     * @return array with admin component's information
     */
    public function component_info() {

        // Load the component's language files
        get_instance()->lang->load( 'frontend_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND );
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('frontend'),
            'component_slug' => 'frontend',
            'component_icon' => md_the_admin_icon(array('icon' => 'frontend')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */