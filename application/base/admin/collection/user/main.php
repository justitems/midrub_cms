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
namespace MidrubBase\Admin\Collection\User;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_USER') OR define('MIDRUB_BASE_ADMIN_USER', MIDRUB_BASE_PATH . 'admin/collection/user/');
defined('MIDRUB_BASE_ADMIN_USER_VERSION') OR define('MIDRUB_BASE_ADMIN_USER_VERSION', '0.0.3');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\User\Controllers as MidrubBaseAdminCollectionUserControllers;

/*
 * Main class loads the User component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Main implements MidrubBaseAdminInterfaces\Admin {
    
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
        (new MidrubBaseAdminCollectionUserControllers\Init)->view();
        
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

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {

            // Call method if exists
            (new MidrubBaseAdminCollectionUserControllers\Ajax)->$action();

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
     * @since 0.0.7.9
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the component's language files
        $this->CI->lang->load( 'user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_USER );

        // Load hooks by category
        switch ($category) {

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Require the user_pages functions file
                require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/user_pages.php';

                // Verify if user has opened the user component
                if ( md_the_component_variable('component') === 'user' ) {

                    // Require the user_pages file
                    require_once MIDRUB_BASE_ADMIN_USER . '/inc/user_pages.php';

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
        $this->CI->lang->load( 'user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_USER );
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('user'),
            'display_app_name' => $this->CI->lang->line('user'),
            'component_slug' => 'user',
            'component_icon' => '<i class="far fa-edit"></i>',
            'version' => '0.0.1',
            'required_version' => '0.0.7.9'
        );
        
    }

}

/* End of file main.php */