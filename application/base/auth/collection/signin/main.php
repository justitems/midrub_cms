<?php
/**
 * Midrub Auth Signin
 *
 * This file loads the Auth Signin Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Signin;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Interfaces as CmsBaseAuthInterfaces;
use CmsBase\Auth\Collection\Signin\Controllers as CmsBaseAuthCollectionSigninControllers;

// Define the component's path
defined('CMS_BASE_AUTH_SIGNIN') OR define('CMS_BASE_AUTH_SIGNIN', APPPATH . 'base/auth/collection/signin/');

// Define the component's version
defined('CMS_BASE_AUTH_SIGNIN_VERSION') OR define('CMS_BASE_AUTH_SIGNIN_VERSION', '0.0.3');

/*
 * Main class loads the Signin Auth's component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Main implements CmsBaseAuthInterfaces\Auth {
    
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

        // Verify if connect parameter exists
        if ( $this->CI->uri->segment('3') && !$this->CI->input->server('QUERY_STRING') ) {

            // Redirect user to network
            (new CmsBaseAuthCollectionSigninControllers\Social)->connect($this->CI->uri->segment('3'));

        } else {

            if ( $this->CI->uri->segment('3') ) {

                // Get access token
                $response = (new CmsBaseAuthCollectionSigninControllers\Social)->login($this->CI->uri->segment('3'));

                if ( $response ) {

                    // Set auth error
                    md_set_data('auth_error', $response['message']);

                }

            } else {

                // Instantiate the class
                (new CmsBaseAuthCollectionSigninControllers\Init)->view();

            }

        }
        
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
            (new CmsBaseAuthCollectionSigninControllers\Ajax)->$action();

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

        // Register the hooks by category
        switch ( $category ) {

            case 'admin_init':

                // Register the hooks for administrator
                md_set_hook(
                    'admin_init',
                    function ($args) {

                        // Verify if user has opened the frontend component
                        if ( (md_the_data('component') === 'frontend') && ($this->CI->input->get('component', true) === 'signin') ) {

                            // Load the component's language files
                            $this->CI->lang->load( 'admin_signin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNIN );

                            // Require the contents_categories file
                            require_once CMS_BASE_AUTH_SIGNIN . 'inc/contents_categories.php';

                        }

                    }

                );                

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
        $this->CI->lang->load( 'admin_signin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNIN );
        
        // Return component information
        return array(
            'component_info' => $this->CI->lang->line('auth_signin'),
            'display_component_name' => $this->CI->lang->line('auth_signin'),
            'component_slug' => 'signin',
            'component_icon' => '<i class="fas fa-sign-in-alt"></i>',
            'version' => CMS_BASE_AUTH_SIGNIN_VERSION,
            'required_version' => '0.0.7.8'
        );
        
    }

}

/* End of file main.php */