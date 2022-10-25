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
namespace CmsBase\Admin\Components\Collection\Support;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_SUPPORT') OR define('CMS_BASE_ADMIN_COMPONENTS_SUPPORT', CMS_BASE_PATH . 'admin/components/collection/support/');
defined('CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION', '0.4');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Support\Controllers as CmsBaseAdminComponentsCollectionSupportControllers;

/*
 * Main class loads the Support component loader
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
     * The public method init loads the component's main page in the Support panel
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionSupportControllers\Init)->view();
        
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
            (new CmsBaseAdminComponentsCollectionSupportControllers\Ajax)->$action();

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

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Load the component's language files
                $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SUPPORT);

                // Require the support_pages functions file
                require_once CMS_BASE_PATH . 'inc/pages/administrator/support_pages.php';

                // Verify if support has opened the support's component
                if ( md_the_data('component') === 'support' ) {

                    // Require the support_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'inc/support_pages.php';

                } else if (md_the_data('component') === 'notifications') {

                    // Require the email_templates file
                    require_once CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'inc/email_templates.php';

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
        
        // Return component information
        return array(
            'component_name' => 'Support',
            'component_slug' => 'support',
            'component_icon' => '<i class="icon-question"></i>',
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */