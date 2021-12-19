<?php
/**
 * Notifications Component
 *
 * This file loads the Notifications component
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
namespace CmsBase\Admin\Components\Collection\Notifications;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS') OR define('CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS', CMS_BASE_PATH . 'admin/components/collection/notifications/');
defined('CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION') OR define('CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION', '0.0.8');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;
use CmsBase\Admin\Components\Collection\Notifications\Controllers as CmsBaseAdminComponentsCollectionNotificationsControllers;

/*
 * Main class loads the Notifications component loader
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
        (new CmsBaseAdminComponentsCollectionNotificationsControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
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
            (new CmsBaseAdminComponentsCollectionNotificationsControllers\Ajax)->$action();

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
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Verify if action parameter exists
        if ( (substr($this->CI->input->post('action', TRUE), 0, 21) === 'create_email_template') || (substr($this->CI->input->post('action', TRUE), 0, 21) === 'update_email_template') ) {

            // Set component
            md_set_data('component', 'notifications');

        }

        // Load hooks by category
        switch ($category) {

            case 'init':
                
                // Require the Notifications Init Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_init.php';           

                break;

            case 'admin_init':

                // Load the component's language files
                $this->CI->lang->load( 'notifications', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );

                // Require the Notifications Init Hooks Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_init_hooks.php';                  

                // Require the Notifications Hooks Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_hooks.php';                   

                // Require the Notifications Pages Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . '/inc/notifications_pages.php';  

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
     * The public method component_info contains the Notifications component's info
     * 
     * @return array with Notifications component's information
     */
    public function component_info() {
        
        // Return component information
        return array(
            'component_name' => get_instance()->lang->line('notifications'),
            'component_slug' => 'notifications',
            'component_icon' => md_the_admin_icon(array('icon' => 'notifications')),
            'version' => CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION,
            'min_version' => '0.0.8.5',
            'max_version' => '0.0.8.5'
        );
        
    }

}

/* End of file main.php */