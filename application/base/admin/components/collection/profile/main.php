<?php
/**
 * Midrub Admin Profile
 *
 * This file loads the Admin Profile component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Profile;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_PROFILE') OR define('CMS_BASE_ADMIN_COMPONENTS_PROFILE', CMS_BASE_PATH . 'admin/components/collection/profile/');
defined('CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION', '0.18');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Profile\Controllers as CmsBaseAdminComponentsCollectionProfileControllers;

/*
 * Main class loads the Profile component loader
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
     * The public method init loads the component's main page in the Profile panel
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionProfileControllers\Init)->view();
        
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

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {

            // Call method if exists
            (new CmsBaseAdminComponentsCollectionProfileControllers\Ajax)->$action();

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
     * @since 0.0.8.5
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load hooks by category
        switch ($category) {

            case 'admin_init':
                
                // Require the profile hooks init
                require_once CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'inc/profile_hooks.php'; 

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
        get_instance()->lang->load( 'profile_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PROFILE );
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('profile'),
            'component_slug' => 'profile',
            'component_icon' => md_the_admin_icon(array('icon' => 'my_profile')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */