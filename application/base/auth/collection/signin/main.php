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
namespace MidrubBase\Auth\Collection\Signin;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Interfaces as MidrubBaseAuthInterfaces;
use MidrubBase\Auth\Collection\Signin\Controllers as MidrubBaseAuthCollectionSigninControllers;

// Define the component's path
defined('MIDRUB_BASE_AUTH_SIGNIN') OR define('MIDRUB_BASE_AUTH_SIGNIN', APPPATH . 'base/auth/collection/signin/');

// Define the component's version
defined('MIDRUB_BASE_AUTH_SIGNIN_VERSION') OR define('MIDRUB_BASE_AUTH_SIGNIN_VERSION', '0.0.3');

/*
 * Main class loads the Signin Auth's component
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

        // Verify if connect parameter exists
        if ( $this->CI->uri->segment('3') && !$this->CI->input->server('QUERY_STRING') ) {

            // Redirect user to network
            (new MidrubBaseAuthCollectionSigninControllers\Social)->connect($this->CI->uri->segment('3'));

        } else {

            if ( $this->CI->uri->segment('3') ) {

                // Get access token
                $response = (new MidrubBaseAuthCollectionSigninControllers\Social)->login($this->CI->uri->segment('3'));

                if ( $response ) {

                    // Set auth error
                    md_set_component_variable('auth_error', $response['message']);

                }

            } else {

                // Instantiate the class
                (new MidrubBaseAuthCollectionSigninControllers\Init)->view();

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
            (new MidrubBaseAuthCollectionSigninControllers\Ajax)->$action();

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
                add_hook(
                    'admin_init',
                    function ($args) {

                        // Verify if user has opened the frontend component
                        if ( (the_global_variable('component') === 'frontend') && ($this->CI->input->get('component', true) === 'signin') ) {

                            // Load the component's language files
                            $this->CI->lang->load( 'admin_signin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_SIGNIN );

                            // Require the contents_categories file
                            require_once MIDRUB_BASE_AUTH_SIGNIN . 'inc/contents_categories.php';

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
        $this->CI->lang->load( 'admin_signin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_SIGNIN );
        
        // Return component information
        return array(
            'component_info' => $this->CI->lang->line('auth_signin'),
            'display_component_name' => $this->CI->lang->line('auth_signin'),
            'component_slug' => 'signin',
            'component_icon' => '<i class="fas fa-sign-in-alt"></i>',
            'version' => MIDRUB_BASE_AUTH_SIGNIN_VERSION,
            'required_version' => '0.0.7.8'
        );
        
    }

}
