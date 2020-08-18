<?php
/**
 * Midrub Base Rest Authorize
 *
 * This file contains the class Authorize
 * with methods to autorize a REST call
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Rest\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Authorize class with methods to autorize a REST call
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Authorize {

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method init tries to authorize a REST Call
     *
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function init() {
        
        // Check if the current user is admin and if session exists
        $this->_check_session($this->CI->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();

        // Get parameters
        $application_id = $this->CI->input->get('application_id', TRUE);
        $application_secret = $this->CI->input->get('application_secret', TRUE);
        $redirect_uri = $this->CI->input->get('redirect_uri', TRUE);
        $response_type = $this->CI->input->get('response_type', TRUE);
        $scope = $this->CI->input->get('scope', TRUE);
        
        // Verify if Application Id is correct
        if ( !$application_id || !is_numeric($application_id) ) {

            echo json_encode(array(
                'status' => FALSE,
                'message' => $this->CI->lang->line('api_app_id_is_not_valid')
            ));

            exit();
            
        } else {
            
            // Get application by id
            $application = $this->CI->base_rest->get_application($application_id);
            
            if (!$application) {
                
                echo json_encode(array(
                    'status' => FALSE,
                    'message' => $this->CI->lang->line('api_app_id_is_not_valid')
                ));

                exit();                
                
            }
            
        }

        // Verify if the scopes are valid
        if ( !is_array($scope) ) {

            $scope = explode(',', $scope);

        } else if ( !$scope ) {

             echo json_encode(array(
                 'status' => FALSE,
                 'message' => $this->CI->lang->line('api_missing_scope')
            )); 

            exit();
            
        }
        
        // Verify if Application Secret is correct
        if ( !$application_secret ) {
            
             echo json_encode(array(
                 'status' => FALSE,
                 'message' => $this->CI->lang->line('api_app_secret_is_not_valid')
            )); 

            exit();
            
        } else {
            
            if ( $application_secret !== md5($application[0]->application_id . '-' . $application[0]->user_id) ) {
                
                echo json_encode(array(
                    'status' => FALSE,
                    'message' => $this->CI->lang->line('api_app_secret_is_not_valid')
                )); 
                
                exit();                
                
            }
            
        }
        
        // Verify if redirect url is correct
        if ( !$redirect_uri || (filter_var($redirect_uri, FILTER_VALIDATE_URL) === FALSE) ) {
            
            echo json_encode(array(
                'status' => FALSE,
                'message' => $this->CI->lang->line('api_redirect_url_is_not_valid')
            ));
            
            exit();
            
        } else {
            
            if ( $redirect_uri !== $application[0]->redirect_url ) {
                
                echo json_encode(array(
                    'status' => FALSE,
                    'message' => $this->CI->lang->line('api_redirect_url_is_not_valid')
                )); 
                
                exit();            
                
            }
            
        }
        
        // Verify if response type is correct
        if ( $response_type !== 'code' ) {

            echo json_encode(array(
                'status' => FALSE,
                'message' => $this->CI->lang->line('api_response_type_is_wrong')
            ));             

            exit();
            
        }  
        
        // Get unique code
        $code = $this->CI->user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());
        
        // Save the authorization code
        $code_id = $this->CI->base_rest->save_application_authorization_code($this->CI->user_id, $application_id, $code);
        
        if( !$code_id ) {            

            echo json_encode(array(
                'status' => FALSE,
                'message' => $this->CI->lang->line('api_error_occured')
            ));            
            
            exit();            
            
        }
        
        // Get application's permissions
        $permissions = $this->CI->base_rest->get_application_permissions($application_id);

        $array_permissions = array();
        
        if ( $permissions ) {
            
            foreach ( $permissions as $permission ) {
                $array_permissions[] = $permission->permission_slug;
            }
            
        }        
        
        $all_permissions = array();

        // Get permissions
        $permissions = $this->the_api_permissions();

        if ( $permissions ) {

            foreach ($permissions as $permission) {

                if ( !in_array($permission['slug'], $array_permissions) || !in_array($permission['slug'], $scope) ) {

                    continue;

                } else {

                    // Save the authorization code permission
                    $this->CI->base_rest->save_application_authorization_code_permission( $code_id, $permission['slug'] );

                }

                if ( !in_array($permission['user_allow'], $all_permissions) ) {

                    $all_permissions[] = $permission['user_allow'];

                }

            }

        }
        
        // Delete application's permissions by user
        $this->CI->base_rest->delete_application_permissions( $this->CI->user_id, $application_id );
        
        // Load view/oauth/authorize.php file
        $this->CI->load->view('oauth/authorize', array(
            'application' => $application[0],
            'all_permissions' => $all_permissions,
            'code' => $code
        ));
        
    }

    /**
     * The private method the_api_permissions gets available Api's permissions
     * 
     * @return array with permissions
     */
    private function the_api_permissions() {

        // Require the Rest Permissions Inc
        require_once MIDRUB_BASE_PATH . 'inc/rest/api_permissions.php';

        // List all user's components
        foreach ( glob(MIDRUB_BASE_PATH . 'user/components/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Load components hooks
            $this->load_component_apps('Components', ucfirst($app), 'load_hooks', 'rest_init');

        }

        // List all user's apps
        foreach ( glob(MIDRUB_BASE_PATH . 'user/apps/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Load apps hooks
            $this->load_component_apps('Apps', ucfirst($app), 'load_hooks', 'rest_init');
        }

        // Get api's permissions
        $permissions = md_the_admin_api_permissions();

        // Verify if Api's permissions exists
        if ( $permissions ) {
            return $permissions;
        } else {
            return array();
        }
        
    }

    /**
     * The private method load_component_apps loads a component or app
     * 
     * @param string $type contains the component's type
     * @param string $slug contains the component's slug
     * @param string $method contains the component's method
     * @param string $method_var contains the component's method var
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_component_apps($type, $slug, $method, $method_var=NULL) {

        // Create an array
        $array = array(
            'MidrubBase',
            'User',
            ucfirst($type),
            'Collection',
            ucfirst($slug),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Get method
        (new $cl())->$method($method_var);
        
    }

    /**
     * The private method _check_unconfirmed_account checks if the current user's account is confirmed
     * 
     * @return void
     */
    private function _check_unconfirmed_account() {

        // Verify if member is a user
        if ($this->CI->user_role < 1) {

            // Verify if user has unpaid invoice
            if (get_user_option('nonpaid')) {
                redirect('/upgrade');
            }

            // If session exists, redirect user
            if ( md_the_user_session() ) {

                if ( md_the_user_session()['status'] < 1 ) {

                    redirect('/user/unconfirmed-account');

                }
                
            }

        }
        
    }
    
    /**
     * The public method _check_session verifies if the session exists and if session is empty will redirect to home page
     * 
     * @param integer $role contains the user role
     * @param integer $is contains the allowed user id
     * 
     * @return void
     */
    public function _check_session($role=NULL, $is=NULL) {
        
        // Check if session exist
        if ( !isset( $this->CI->session->userdata['username'] ) ) {
            
            // Register the page session
            $this->CI->session->set_userdata('required_redirect', '/oauth2/authorize');
            
            // Set the sign in page
            $sign_in = the_url_by_page_role('sign_in') ? the_url_by_page_role('sign_in') : site_url('auth/signin');

            // Redirect the login page
            redirect($sign_in);
            
        } elseif ( ( $is === 0 ) AND ( $role != $is) ) {

            redirect('/admin/home');
            
        }
        
    }
    
}

