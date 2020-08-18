<?php
/**
 * Midrub Update
 *
 * This file loads the Update component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Update;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN_UPDATE') OR define('MIDRUB_BASE_ADMIN_UPDATE', MIDRUB_BASE_PATH . 'admin/collection/update/');
defined('MIDRUB_BASE_ADMIN_UPDATE_VERSION') OR define('MIDRUB_BASE_ADMIN_UPDATE_VERSION', '0.0.193');

// Define the namespaces to use
use MidrubBase\Admin\Interfaces as MidrubBaseAdminInterfaces;
use MidrubBase\Admin\Collection\Update\Controllers as MidrubBaseAdminCollectionUpdateControllers;

/*
 * Main class loads the update component loader
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
        (new MidrubBaseAdminCollectionUpdateControllers\Init)->view();
        
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
            (new MidrubBaseAdminCollectionUpdateControllers\Ajax)->$action();

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
     * The public method component_info contains the Update component's info
     * 
     * @since 0.0.8.0
     * 
     * @return array with Update component's information
     */
    public function component_info() {
        
        // Load the component's language files
        $this->CI->lang->load( 'update', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_UPDATE );
        
        // Return component information
        return array(
            'app_name' => $this->CI->lang->line('update'),
            'display_app_name' => $this->CI->lang->line('update'),
            'component_slug' => 'update',
            'component_icon' => '<i class="far fa-edit"></i>',
            'version' => '0.0.1',
            'required_version' => '0.0.8.0'
        );
        
    }

}

/* End of file main.php */