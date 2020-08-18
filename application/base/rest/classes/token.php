<?php
/**
 * Midrub Base Rest Token
 *
 * This file contains the class Token
 * with methods to generate access token
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
 * Token class with methods to generate access token
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Token {

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
     * The public method init tries to generate a token
     *
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function init() {
        
        if ( $this->CI->input->post() ) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('application_id', 'Client ID', 'trim|required');
            $this->CI->form_validation->set_rules('application_secret', 'Client Secret', 'trim|required');
            $this->CI->form_validation->set_rules('redirect_uri', 'Redirect Uri', 'trim');
            $this->CI->form_validation->set_rules('username', 'Username', 'trim|strtolower');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim');
            $this->CI->form_validation->set_rules('code', 'Code', 'trim');
            $this->CI->form_validation->set_rules('grant_type', 'Grant Type', 'trim|required');
            $this->CI->form_validation->set_rules('mobile_installed', 'Mobile Installed', 'trim');
            
            // get data
            $application_id = $this->CI->input->post('application_id');
            $application_secret = $this->CI->input->post('application_secret');
            $redirect_uri = $this->CI->input->post('redirect_uri');
            $username = $this->CI->input->post('username');
            $password = $this->CI->input->post('password');
            $code = $this->CI->input->post('code');
            $grant_type = $this->CI->input->post('grant_type');
            $mobile_installed = $this->CI->input->post('mobile_installed');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                echo json_encode(array(
                    'status' => FALSE,
                    'message' => $this->CI->lang->line('api_no_permissions_to_access_page')
                ));
                
            } else {
                
                switch ( $grant_type ) {
                    
                    case 'password':
                        
                        // Get application by id
                        $application = $this->CI->base_rest->get_application($application_id);

                        if (!$application) {

                            echo json_encode(array(
                                'status' => FALSE,
                                'message' => $this->CI->lang->line('api_app_id_is_not_valid')
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

                        // Check if user was blocked
                        $this->block_count();

                        // Verify if the user is member of a team
                        if (preg_match('/@/i', $username)) {

                            // Get username by email
                            $username = $this->CI->user->get_username_by_email($username);

                            // Verify if the email was found in our system
                            if ($username) {

                                // Check if user and password exists
                                if ( $this->CI->user->check($username, $password) ) {

                                    // Get user status
                                    $user_status = $this->CI->user->check_status_by_username(strtolower($username));

                                    // First we check if the user account was blocked
                                    if ( $user_status > 1 ) {

                                        echo json_encode(array(
                                            'status' => FALSE,
                                            'message' => $this->CI->lang->line('api_your_account_is_blocked')
                                        ));

                                        exit();

                                    } else {

                                        // Get application's permissions
                                        $permissions = $this->CI->base_rest->get_application_permissions($application_id);

                                        // Get user_id by username
                                        $user_id = $this->CI->user->get_user_id_by_username($username);

                                        // Verify if user account is unconfirmed
                                        if ($user_status < 1) {

                                            echo json_encode(array(
                                                'status' => FALSE,
                                                'message' => $this->CI->lang->line('api_unconfirmed_account')
                                            ));

                                            exit();
                                        }

                                        // Verify if user has a unpaid invoice
                                        if (get_user_option('nonpaid', $user_id)) {

                                            echo json_encode(array(
                                                'status' => FALSE,
                                                'message' => $this->CI->lang->line('api_unpaid_invoice')
                                            ));

                                            exit();

                                        }

                                        // Save settings about installed mobile app
                                        if ($mobile_installed) {
                                            update_user_option($user_id, 'mobile_installed', 1);
                                        }

                                        // Generate access token token
                                        $token = $user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());

                                        // Save the oauth token
                                        $token_id = $this->CI->base_rest->save_oauth_token($application_id, $user_id, $token);

                                        // Verify if the token was saved
                                        if (!$token_id) {

                                            echo json_encode(array(
                                                'status' => FALSE,
                                                'message' => $this->CI->lang->line('api_error_occured')
                                            ));

                                            exit();
                                        }

                                        if ($permissions) {

                                            foreach ($permissions as $permission) {

                                                // Save the oauth token permission
                                                $this->CI->base_rest->save_oauth_token_permission($token_id, $permission->permission_slug);
                                            }

                                        }

                                        // Delete the user's old access tokens
                                        $this->CI->base_rest->delete_access_tokens($user_id, $token_id);

                                        echo json_encode(array(
                                            'status' => TRUE,
                                            'username' => $username,
                                            'access_token' => $token,
                                            'message' => $this->CI->lang->line('api_you_have_been_successfully')

                                        ));

                                        exit();

                                    }

                                } else if ( $this->CI->base_model->get_data_where('teams', 'user_id', array('member_email' => strtolower($username))) ) {

                                    // Get member
                                    $team_owner = $this->CI->base_model->get_data_where('teams', '*', array('member_email' => strtolower($username)));

                                    // Verify if Team's owner exists
                                    if ( $team_owner ) {

                                        // Get user data
                                        $user_data = $this->CI->base_model->get_data_where('users', '*', array(
                                            'user_id' => $team_owner[0]['user_id']
                                        ));
                        
                                        // Verify if user exists
                                        if ( $user_data ) {

                                            // Check if user and password exists
                                            if ($this->CI->base_users->check_user($user_data[0]['username'], $password)) {

                                                // Get application's permissions
                                                $permissions = $this->CI->base_rest->get_application_permissions($application_id);

                                                // Get user_id by username
                                                $user_id = $user_data[0]['user_id'];

                                                // Get user status
                                                $user_status = $user_data[0]['status'];

                                                // First we check if the user account was blocked
                                                if ( $user_status > 1 ) {

                                                    echo json_encode(array(
                                                        'status' => FALSE,
                                                        'message' => $this->CI->lang->line('api_your_account_is_blocked')
                                                    ));

                                                    exit();  

                                                }

                                                // Verify if user account is unconfirmed
                                                if ( $user_status < 1 ) {

                                                    echo json_encode(array(
                                                        'status' => FALSE,
                                                        'message' => $this->CI->lang->line('api_unconfirmed_account')
                                                    ));

                                                    exit();  

                                                }                                

                                                // Verify if user has a unpaid invoice
                                                if ( get_user_option('nonpaid', $user_id) ) {
                            
                                                    echo json_encode(array(
                                                        'status' => FALSE,
                                                        'message' => $this->CI->lang->line('api_unpaid_invoice')
                                                    ));

                                                    exit(); 
                                                    
                                                }

                                                // Verify if the member's account is enabled
                                                if ($team_owner[0]['status']) {

                                                    echo json_encode(array(
                                                        'status' => FALSE,
                                                        'message' => $this->CI->lang->line('your_account_is_disabled')
                                                    ));

                                                    exit();                                     

                                                }

                                                // Save settings about installed mobile app
                                                if ( $mobile_installed ) {
                                                    update_user_option($user_id, 'mobile_installed', 1);
                                                }

                                                // Generate access token token
                                                $token = $user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());

                                                // Save the oauth token
                                                $token_id = $this->CI->base_rest->save_oauth_token($application_id, $user_id, $token);

                                                // Verify if the token was saved
                                                if (!$token_id) {

                                                    echo json_encode(array(
                                                        'status' => FALSE,
                                                        'message' => $this->CI->lang->line('api_error_occured')
                                                    ));

                                                    exit();
                                                }

                                                if ($permissions) {

                                                    foreach ($permissions as $permission) {

                                                        // Save the oauth token permission
                                                        $this->CI->base_rest->save_oauth_token_permission($token_id, $permission->permission_slug);
                                                    }

                                                }

                                                // Delete the user's old access tokens
                                                $this->CI->base_rest->delete_access_tokens($user_id, $token_id);

                                                echo json_encode(array(
                                                    'status' => TRUE,
                                                    'username' => $user_data[0]['username'],
                                                    'access_token' => $token,
                                                    'message' => strip_tags($this->CI->lang->line('api_you_have_been_successfully'))

                                                ));

                                            } else {

                                                // Set a new user block
                                                $this->block_count();

                                                echo json_encode(array(
                                                    'status' => FALSE,
                                                    'message' => strip_tags($this->CI->lang->line('api_usrname_password_wrong'))
                                                ));

                                                exit();   

                                            }

                                        }

                                    }
                    
                                } else {

                                    $this->block_count();

                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_usrname_password_wrong')
                                    ));

                                    exit();                                    

                                }

                            } else {

                                // Set a new user block
                                $this->block_count();

                                echo json_encode(array(
                                    'status' => FALSE,
                                    'message' => $this->CI->lang->line('please_ensure_correct_credientials')
                                ));

                                exit();                                 

                            }

                        } elseif (preg_match('/m_/i', $username)) {

                            // Load Team Model
                            $this->CI->load->model('team');

                            // Get the team's owner
                            $team_owner = $this->CI->team->check($username, $password);

                            if ($team_owner) {

                                // Get application's permissions
                                $permissions = $this->CI->base_rest->get_application_permissions($application_id);

                                // Get user_id by username
                                $user_id = $this->CI->user->get_user_id_by_username($team_owner['username']);

                                // Get user status
                                $user_status = $this->CI->user->check_status_by_username(strtolower($team_owner['username']));

                                // First we check if the user account was blocked
                                if ( $user_status > 1 ) {

                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_your_account_is_blocked')
                                    ));

                                    exit();  

                                }

                                // Verify if user account is unconfirmed
                                if ( $user_status < 1 ) {

                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_unconfirmed_account')
                                    ));

                                    exit();  

                                }                                

                                // Verify if user has a unpaid invoice
                                if ( get_user_option('nonpaid', $user_id) ) {
            
                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_unpaid_invoice')
                                    ));

                                    exit(); 
                                    
                                }

                                // Verify if the member's account is enabled
                                if ($team_owner['status']) {

                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('your_account_is_disabled')
                                    ));

                                    exit();                                     

                                }

                                // Save settings about installed mobile app
                                if ( $mobile_installed ) {
                                    update_user_option($user_id, 'mobile_installed', 1);
                                }

                                // Generate access token token
                                $token = $user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());

                                // Save the oauth token
                                $token_id = $this->CI->base_rest->save_oauth_token($application_id, $user_id, $token);

                                // Verify if the token was saved
                                if (!$token_id) {

                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_error_occured')
                                    ));

                                    exit();
                                }

                                if ($permissions) {

                                    foreach ($permissions as $permission) {

                                        // Save the oauth token permission
                                        $this->CI->base_rest->save_oauth_token_permission($token_id, $permission->permission_slug);
                                    }

                                }

                                // Delete the user's old access tokens
                                $this->CI->base_rest->delete_access_tokens($user_id, $token_id);

                                echo json_encode(array(
                                    'status' => TRUE,
                                    'username' => $team_owner['username'],
                                    'access_token' => $token,
                                    'message' => strip_tags($this->CI->lang->line('api_you_have_been_successfully'))

                                ));

                                exit();

                            } else {

                                // Set a new user block
                                $this->block_count();

                                echo json_encode(array(
                                    'status' => FALSE,
                                    'message' => strip_tags($this->CI->lang->line('api_usrname_password_wrong'))
                                ));

                                exit();   

                            }

                        } else {

                            // Check if user and password exists
                            if ($this->CI->user->check($username, $password)) {

                                // Get user status
                                $user_status = $this->CI->user->check_status_by_username(strtolower($username));

                                // First we check if the user account was blocked
                                if ( $user_status > 1 ) {

                                    $this->block_count();
                                    echo json_encode(array(
                                        'status' => FALSE,
                                        'message' => $this->CI->lang->line('api_your_account_is_blocked')
                                    ));

                                    exit();

                                } else {

                                    // Get application's permissions
                                    $permissions = $this->CI->base_rest->get_application_permissions($application_id);

                                    // Get user_id by username
                                    $user_id = $this->CI->user->get_user_id_by_username($username);

                                    // Verify if user account is unconfirmed
                                    if ($user_status < 1) {

                                        echo json_encode(array(
                                            'status' => FALSE,
                                            'message' => $this->CI->lang->line('api_unconfirmed_account')
                                        ));

                                        exit();
                                    }

                                    // Verify if user has a unpaid invoice
                                    if (get_user_option('nonpaid', $user_id)) {

                                        echo json_encode(array(
                                            'status' => FALSE,
                                            'message' => $this->CI->lang->line('api_unpaid_invoice')
                                        ));

                                        exit();

                                    }

                                    // Save settings about installed mobile app
                                    if ($mobile_installed) {
                                        update_user_option($user_id, 'mobile_installed', 1);
                                    }

                                    // Generate access token token
                                    $token = $user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());

                                    // Save the oauth token
                                    $token_id = $this->CI->base_rest->save_oauth_token($application_id, $user_id, $token);

                                    // Verify if the token was saved
                                    if (!$token_id) {

                                        echo json_encode(array(
                                            'status' => FALSE,
                                            'message' => $this->CI->lang->line('api_error_occured')
                                        ));

                                        exit();
                                    }

                                    if ($permissions) {

                                        foreach ($permissions as $permission) {

                                            // Save the oauth token permission
                                            $this->CI->base_rest->save_oauth_token_permission($token_id, $permission->permission_slug);

                                        }

                                    }

                                    // Delete the user's old access tokens
                                    $this->CI->base_rest->delete_access_tokens($user_id, $token_id);

                                    echo json_encode(array(
                                        'status' => TRUE,
                                        'username' => $username,
                                        'access_token' => $token,
                                        'message' => strip_tags($this->CI->lang->line('api_you_have_been_successfully'))

                                    ));

                                    exit();
                                }

                            } else {

                                // Set a new user block
                                $this->block_count();

                                echo json_encode(array(
                                    'status' => FALSE,
                                    'message' => strip_tags($this->CI->lang->line('api_usrname_password_wrong'))
                                ));

                                exit();
                            }
                        }
                        
                        break;
                        
                    case 'authorization_code':
                        
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
                        
                        if ( !$code ) {
                            
                            echo json_encode(array(
                                'status' => FALSE,
                                'message' => $this->CI->lang->line('api_authorization_code_not_valid')
                            ));

                            exit();                              
                            
                        }
                        
                        // Verify authorization code
                        $authorization_check = $this->CI->base_rest->check_authorization_code($application_id, $code);

                        if ( $authorization_check ) {

                            // Generate access token token
                            $token = $authorization_check[0]->user_id . '_' . sha1(rand()) . sha1(rand()) . sha1(rand());

                            // Save the oauth token
                            $token_id = $this->CI->base_rest->save_oauth_token($application_id, $authorization_check[0]->user_id, $token);
                         
                            foreach ( $authorization_check as $permission ) {
                                
                                // Save the oauth token permission
                                $this->CI->base_rest->save_oauth_token_permission($token_id, $permission->permission_slug);
                                
                            }
                            
                            // Delete the authorization codes
                            $this->CI->base_rest->delete_authorization_codes($authorization_check[0]->user_id);

                            // Delete the user's old access tokens
                            $this->CI->base_rest->delete_access_tokens($authorization_check[0]->user_id, $token_id);
                            
                            echo json_encode(array(
                                    'status' => TRUE,
                                    'access_token' => $token
                                ));

                            exit();                             
                            
                        } else {
                            
                            echo json_encode(array(
                                'status' => FALSE,
                                'message' => $this->CI->lang->line('api_authorization_code_not_valid')
                            ));

                            exit();                             
                            
                        }
                        
                        break;
                        
                    default:
                        
                        echo json_encode(array(
                            'status' => FALSE,
                            'message' => $this->CI->lang->line('api_grant_type_not_valid')
                        ));
                        
                        break;
                    
                }
                
            }
            
        }
        
    }

    /**
     * The private method block_count checks if the user is already blocked
     * 
     * @return void
     */
    private function block_count()
    {

        // Get user ip
        $user_ip = $this->CI->input->ip_address();

        // Set block_user variable
        $block_user = array();

        $this->CI->db->select('data');
        $this->CI->db->from('ci_sessions');
        $this->CI->db->where(array('ip_address' => $user_ip));
        $this->CI->db->like('data', 'block');
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {

            $user_data = $query->result();

            $vars = explode('block_user|', $user_data[0]->data);

            $block_user = unserialize($vars[1]);
        }

        if ($block_user) {

            if (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 5)) {

                // Display message
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_failed_access_token')
                ));

                exit();

            } else {

                if (($block_user['time'] < time() - 3600)) {

                    // Delete user session by ip
                    $this->CI->db->delete('ci_sessions', array('ip_address' => $user_ip));

                }

            }

        }

    }
    
}

