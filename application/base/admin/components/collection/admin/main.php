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
namespace CmsBase\Admin\Components\Collection\Admin;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_ADMIN') OR define('CMS_BASE_ADMIN_COMPONENTS_ADMIN', CMS_BASE_PATH . 'admin/components/collection/admin/');
defined('CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION', '0.0.4');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Admin\Controllers as CmsBaseAdminComponentsCollectionAdminControllers;

/*
 * Main class loads the admin component loader
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
        (new CmsBaseAdminComponentsCollectionAdminControllers\Init)->view();
        
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
            (new CmsBaseAdminComponentsCollectionAdminControllers\Ajax)->$action();

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

        // Load hooks by category
        switch ($category) {

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Require the admin_pages functions file
                require_once CMS_BASE_PATH . 'inc/pages/administrator/admin_pages.php';

                // Require the admin_menu file
                require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . '/inc/admin_menu.php';                 

                // Verify if admin has opened the admin component
                if ( md_the_data('component') === 'admin' ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_ADMIN );

                    // Require the admin_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . '/inc/admin_pages.php';

                    // Require the admin_hooks file
                    require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . '/inc/admin_hooks.php';                    

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
        get_instance()->lang->load( 'admin_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_ADMIN );
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('admin'),
            'component_slug' => 'admin',
            'component_icon' => md_the_admin_icon(array('icon' => 'admin')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */