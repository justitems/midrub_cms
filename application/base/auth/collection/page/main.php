<?php
/**
 * Midrub Auth Page
 *
 * This file loads the Auth Page Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Page;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Classes as MidrubBaseAuthClasses;
use MidrubBase\Auth\Interfaces as MidrubBaseAuthInterfaces;
use MidrubBase\Auth\Collection\Page\Controllers as MidrubBaseAuthCollectionPageControllers;

// Define the component's path
defined('MIDRUB_BASE_AUTH_PAGE') OR define('MIDRUB_BASE_AUTH_PAGE', APPPATH . 'base/auth/collection/page');

// Define the component's version
defined('MIDRUB_BASE_AUTH_PAGE_VERSION') OR define('MIDRUB_BASE_AUTH_PAGE_VERSION', '0.0.1');

/*
 * Main class loads the Page Auth's component
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
        (new MidrubBaseAuthCollectionPageControllers\Init)->view();
        
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
            (new MidrubBaseAuthCollectionPageControllers\Ajax)->$action();

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
        if ( file_exists( MIDRUB_BASE_AUTH_PAGE . '/language/' . $this->CI->config->item('language') . '/admin_page_lang.php' ) ) {
            $this->CI->lang->load( 'admin_page', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_PAGE . '/' );
        }
        
        // Return component information
        return array(
            'component_info' => $this->CI->lang->line('auth_page'),
            'display_component_name' => $this->CI->lang->line('auth_page'),
            'component_slug' => 'page',
            'component_icon' => '<i class="fas fa-user-plus"></i>',
            'version' => MIDRUB_BASE_AUTH_PAGE_VERSION,
            'required_version' => '0.0.7.8'
        );
        
    }

}
