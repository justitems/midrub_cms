<?php
/**
 * Midrub Admin User
 *
 * This file loads the Admin User component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_USER') OR define('CMS_BASE_ADMIN_COMPONENTS_USER', CMS_BASE_PATH . 'admin/components/collection/user/');
defined('CMS_BASE_ADMIN_COMPONENTS_USER_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_USER_VERSION', '0.0.7');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\User\Controllers as CmsBaseAdminComponentsCollectionUserControllers;

/*
 * Main class loads the User component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the user panel
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionUserControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.9
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
            (new CmsBaseAdminComponentsCollectionUserControllers\Ajax)->$action();

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
     * @since 0.0.7.9
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load hooks by category
        switch ($category) {

            case 'admin_init':

                // Require the user_hooks functions file
                require_once CMS_BASE_ADMIN_COMPONENTS_USER . 'inc/user_hooks.php'; 

                // Require the user_pages functions file
                require_once CMS_BASE_PATH . 'inc/pages/administrator/user_pages.php';

                // Verify if user has opened the user component
                if ( md_the_data('component') === 'user' ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'user', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_USER );

                    // Require the user_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_USER . '/inc/user_pages.php';

                }

                break;

        }

    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.7.9
     * 
     * @return array with admin component's information
     */
    public function component_info() {

        // Load the component's language files
        get_instance()->lang->load( 'user_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_USER );
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('user'),
            'component_slug' => 'user',
            'component_icon' => md_the_admin_icon(array('icon' => 'user')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */