<?php
/**
 * Midrub Auth Change Password
 *
 * This file loads the Auth Change Password Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Change_password;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Interfaces as MidrubBaseAuthInterfaces;
use MidrubBase\Auth\Collection\Change_password\Controllers as MidrubBaseAuthCollectionChangePasswordControllers;

// Define the component's path
defined('MIDRUB_BASE_AUTH_CHANGE_PASSWORD') OR define('MIDRUB_BASE_AUTH_CHANGE_PASSWORD', APPPATH . 'base/auth/collection/change_password');

// Define the component's version
defined('MIDRUB_BASE_AUTH_CHANGE_PASSWORD_VERSION') OR define('MIDRUB_BASE_AUTH_CHANGE_PASSWORD_VERSION', '0.0.2');

/*
 * Main class loads the Change Password Auth's component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Main implements MidrubBaseAuthInterfaces\Auth {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method user loads the component's main page
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function init() {

        // Instantiate the class
        (new MidrubBaseAuthCollectionChangePasswordControllers\Init)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.8
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
            (new MidrubBaseAuthCollectionChangePasswordControllers\Ajax)->$action();

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
     * @since 0.0.7.8
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the component's language files
        if ( file_exists( MIDRUB_BASE_AUTH_CHANGE_PASSWORD . '/language/' . $this->CI->config->item('language') . '/auth_change_password_lang.php' ) ) {
            $this->CI->lang->load( 'auth_change_password', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_CHANGE_PASSWORD . '/' );
        }

        // Load hooks by category
        switch ($category) {

            case 'admin_init':

                // Verify if user has opened the frontend component
                if ( (md_the_component_variable('component') === 'frontend') && ($this->CI->input->get('component', true) === 'change_password') ) {

                    // Require the contents_categories file
                    require_once MIDRUB_BASE_AUTH_CHANGE_PASSWORD . '/inc/contents_categories.php';

                }

                break;
                
        }

    }

    /**
     * The public method cron_jobs processes the cron jobs methods if exists
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function cron_jobs() {

    } 

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function api_call() {

    }
    
    /**
     * The public method component_info contains the component's info
     * 
     * @since 0.0.7.8
     * 
     * @return array with component's information
     */
    public function component_info() {
        
        // Load the component's language files
        if ( file_exists( MIDRUB_BASE_AUTH_CHANGE_PASSWORD . '/language/' . $this->CI->config->item('language') . '/admin_change_password_lang.php' ) ) {
            $this->CI->lang->load( 'admin_change_password', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_CHANGE_PASSWORD . '/' );
        }
        
        // Return component information
        return array(
            'component_info' => $this->CI->lang->line('auth_change_password'),
            'display_component_name' => $this->CI->lang->line('auth_change_password'),
            'component_slug' => 'change_password',
            'component_icon' => '<i class="fas fa-window-restore"></i>',
            'version' => MIDRUB_BASE_AUTH_CHANGE_PASSWORD_VERSION,
            'required_version' => '0.0.7.8'
        );
        
    }

}
