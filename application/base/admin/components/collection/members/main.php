<?php
/**
 * Members Component
 *
 * This file loads the Members component
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_MEMBERS') OR define('CMS_BASE_ADMIN_COMPONENTS_MEMBERS', CMS_BASE_PATH . 'admin/components/collection/members/');
defined('CMS_BASE_ADMIN_COMPONENTS_MEMBERS_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_MEMBERS_VERSION', '0.0.6');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Members\Controllers as CmsBaseAdminComponentsCollectionMembersControllers;

/*
 * Main class loads the Members component loader
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Main implements CmsBaseAdminInterfaces\Components {
    
    /**
     * Class variables
     */
    protected
            $CI;

    /**
     * Initialise the Class
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method init loads the component's main page in the admin panel
     * 
     * @return void
     */
    public function init() {
        
        // Instantiate the class
        (new CmsBaseAdminComponentsCollectionMembersControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
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
            (new CmsBaseAdminComponentsCollectionMembersControllers\Ajax)->$action();

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
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load hooks by category
        switch ($category) {

            case 'init':
                
                // Require the Members Init Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/members_init.php';           

                break;

            case 'auth_init':
            case 'frontend_init':

            
                break;

            case 'admin_init':

                // Load the component's language files
                $this->CI->lang->load( 'members', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_MEMBERS );

                // Require the Members Hooks Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/members_hooks.php';                     

                // Verify if is the members's component
                if ( md_the_data('component') === 'members' ) {

                    // Require the members_pages file
                    require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . '/inc/members_pages.php';

                    // Require the Members Init Hooks Inc file
                    require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/members_init_hooks.php';     

                } else if (md_the_data('component') === 'notifications') {

                    // Require the email_templates file
                    require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/email_templates.php';

                }

                break;

        }

    }

    /**
     * The public method api_call processes the api's calls
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the Members component's info
     * 
     * @return array with Members component's information
     */
    public function component_info() {
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('members'),
            'component_slug' => 'members',
            'component_icon' => md_the_admin_icon(array('icon' => 'members')),
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */