<?php
/**
 * Midrub Auth Signup
 *
 * This file loads the Auth Signup Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Signup;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Interfaces as CmsBaseAuthInterfaces;
use CmsBase\Auth\Collection\Signup\Controllers as CmsBaseAuthCollectionSignupControllers;

// Define the component's path
defined('CMS_BASE_AUTH_SIGNUP') OR define('CMS_BASE_AUTH_SIGNUP', APPPATH . 'base/auth/collection/signup/');

// Define the component's version
defined('CMS_BASE_AUTH_SIGNUP_VERSION') OR define('CMS_BASE_AUTH_SIGNUP_VERSION', '0.0.4');

/*
 * Main class loads the Signup Auth's component
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

            // Get the session
            $the_session = md_the_user_session();

            // Verify if the session exists
            if ( !empty($the_session['user_id']) && empty($the_session['role']) ) {

                // Redirect user to network
                (new CmsBaseAuthCollectionSignupControllers\Social)->connect($this->CI->uri->segment('3'));

            } else {

                // Display 404 page
                show_404();

            }

        } else {

            if ( $this->CI->uri->segment('3') ) {

                // Get the session
                $the_session = md_the_user_session();

                // Verify if the session exists
                if ( !empty($the_session['user_id']) && empty($the_session['role']) ) {

                    // Get access token
                    (new CmsBaseAuthCollectionSignupControllers\Social)->login($this->CI->uri->segment('3'));

                } else {

                    // Display 404 page
                    show_404();
    
                }

            } else {

                // Verify if signup is disabled
                if ( !md_the_option('enable_registration') ) {

                    // Display 404 page
                    show_404();

                }

                // Instantiate the class
                (new CmsBaseAuthCollectionSignupControllers\Init)->view();

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
            (new CmsBaseAuthCollectionSignupControllers\Ajax)->$action();

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

                // Verify if user has opened the frontend component
                if ( (md_the_data('component') === 'frontend') && ($this->CI->input->get('component', true) === 'signup') ) {

                    // Load the component's language files
                    $this->CI->lang->load( 'admin_signup', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNUP);

                    // Require the contents_categories file
                    require_once CMS_BASE_AUTH_SIGNUP . '/inc/contents_categories.php';

                } else if (md_the_data('component') === 'notifications') {

                    // Load the component's language files
                    $this->CI->lang->load( 'admin_signup', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNUP);

                    // Require the email_templates file
                    require_once CMS_BASE_AUTH_SIGNUP . 'inc/email_templates.php';

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
        $this->CI->lang->load( 'admin_signup', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNUP . '/' );
        
        // Return component information
        return array(
            'component_info' => $this->CI->lang->line('signup'),
            'display_component_name' => $this->CI->lang->line('signup'),
            'component_slug' => 'signup',
            'component_icon' => '<i class="fas fa-user-plus"></i>',
            'version' => CMS_BASE_AUTH_SIGNUP_VERSION,
            'required_version' => '0.0.7.8'
        );
        
    }

}

/* End of file main.php */