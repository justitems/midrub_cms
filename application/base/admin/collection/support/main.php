<?php
/**
 * Midrub Admin Support
 *
 * This file loads the Admin Support component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Support;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_SUPPORT') OR define('MIDRUB_BASE_ADMIN_SUPPORT', MIDRUB_BASE_PATH . 'admin/collection/support/');
defined('MIDRUB_BASE_ADMIN_SUPPORT_VERSION') OR define('MIDRUB_BASE_ADMIN_SUPPORT_VERSION', '0.1');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\Support\Controllers as MidrubBaseAdminCollectionSupportControllers;

/*
 * Main class loads the Support component loader
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
     * The public method init loads the component's main page in the Support panel
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new MidrubBaseAdminCollectionSupportControllers\Init)->view();
        
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
            (new MidrubBaseAdminCollectionSupportControllers\Ajax)->$action();

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
        $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SUPPORT);

        // Load hooks by category
        switch ($category) {

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Require the support_pages functions file
                require_once MIDRUB_BASE_PATH . 'inc/pages/administrator/support_pages.php';

                // Verify if support has opened the support's component
                if ( md_the_component_variable('component') === 'support' ) {

                    // Require the support_pages file
                    require_once MIDRUB_BASE_ADMIN_SUPPORT . 'inc/support_pages.php';

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
        $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SUPPORT);
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('support'),
            'display_app_name' => $this->CI->lang->line('support'),
            'component_slug' => 'support',
            'component_icon' => '<i class="icon-question"></i>',
            'version' => MIDRUB_BASE_ADMIN_SUPPORT_VERSION,
            'required_version' => '0.0.7.9'
        );
        
    }

}

/* End of file main.php */