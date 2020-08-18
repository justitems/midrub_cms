<?php
/**
 * Signin Class
 *
 * This file loads the Signin Class with properties and methods for signin process
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Classes\Signin;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Signin class loads the properties and methods for signin process
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Signin {
    
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

        // Load the Base Users Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_users', 'base_users' );

        // Load Base Plans Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );

        // Load the bcrypt library
        $this->CI->load->library('bcrypt');
        
    }

    /**
     * The public method authenticate_user authenticatea a user
     * 
     * @param array $args contains the user information
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function authenticate_user($args) {

        // Check if user was blocked
        $this->check_block();
        
        // Load Team Model
        $this->CI->load->model('team');

        // Verify if data is correct
        if ( !isset($args['email']) || !isset($args['password']) ) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_the_entered_data_is_wrong')
            );

            echo json_encode($data);
            exit();

        }

        // Verify if user wants sign in with email
        if ( preg_match('/@/i', $args['email']) ) {

            // Get username by email
            $user = $this->CI->base_model->get_data_where('users', 'user_id, username, status, role', array('email' => strtolower($args['email'])));

            // Verify if the email was found in our system
            if ($user) {

                // Check if user and password exists
                if ($this->CI->base_users->check_user($user[0]['username'], $args['password'])) {

                    // First we check if the user account was blocked
                    if ( $user[0]['status'] == 2 ) {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_your_account_is_blocked')
                        );

                        echo json_encode($data);  
                        
                    } else {

                        $this->CI->session->set_userdata('username', $user[0]['username']);

                        // If remember me are unckecked the session will be deleted after two hours
                        if ( !empty($args['remember']) ) {

                            $this->CI->session->set_userdata('autodelete', time() + 7200);
                            
                        }

                        // Verify if user has temporary blocks
                        if ($this->CI->session->userdata('block_user')) {

                            // Delete temporary blocks
                            $this->CI->session->unset_userdata('block_user');

                        }

                        // Verify if is the user
                        if ( $user[0]['role'] < 1 ) {

                            // Verifies if user has a plan
                            $this->check_plan($user[0]['user_id']);

                            // Set redirect
                            $redirect = $this->get_plan_redirect($user[0]['user_id']);                            
    
                        } else {

                            // Set admin redirect
                            $redirect = base_url('admin/home');

                        }

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('auth_you_have_been_successfully_signed_in'),
                            'redirect' => $redirect
                        );

                        // Display the success response
                        echo json_encode($data);

                    }

                } else {

                    // Add a block count
                    $this->block_count();

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                    );

                    echo json_encode($data); 

                }

            } else if ( $this->CI->base_model->get_data_where('teams', 'user_id', array('member_email' => strtolower($args['email']))) ) {

                // Get member
                $team_owner = $this->CI->base_model->get_data_where(
                    'teams',
                    '*',
                    array(
                        'member_email' => strtolower($args['email'])
                    )
                );

                // Verify if Team's owner exists
                if ( $team_owner ) {

                    // Verify if password is correct
                    if ( password_verify($args['password'], $team_owner[0]['member_password'] ) ) {

                        // Get user data
                        $user_data = $this->CI->base_model->get_data_where('users', '*', array(
                            'user_id' => $team_owner[0]['user_id']
                        ));

                        // Verify if user exists
                        if ( $user_data ) {

                            // First we check if the user account was blocked
                            if ( $user_data[0]['status'] == 2 ) {

                                // Display error message
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('auth_your_account_is_blocked')
                                );

                                echo json_encode($data);  
                                
                            } else {

                                // Verify if the member's account is enabled
                                if ($team_owner[0]['status']) {

                                    // Display error message
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('auth_your_account_is_disabled')
                                    );

                                    echo json_encode($data);   
                                    exit();
                                    
                                }

                                // Create the session
                                $this->CI->session->set_userdata('username', $team_owner[0]['member_username']);

                                // Create the team's member session
                                $this->CI->session->set_userdata('member', $team_owner[0]['member_username']);

                                // If remember me are unckecked the session will be deleted after two hours
                                if ( !empty($args['remember']) ) {

                                    $this->CI->session->set_userdata('autodelete', time() + 7200);
                                    
                                }

                                // Verify if user has temporary blocks
                                if ($this->CI->session->userdata('block_user')) {

                                    // Delete temporary blocks
                                    $this->CI->session->unset_userdata('block_user');

                                }

                                if ( $user_data[0]['role'] < 1 ) {

                                    // Verifies if user has a plan
                                    $this->check_plan($user_data[0]['user_id']);

                                    // Set redirect
                                    $redirect = $this->get_plan_redirect($user_data[0]['user_id']);                                    
            
                                } else {

                                    // Set admin redirect
                                    $redirect = base_url('admin/home');

                                }

                                // Prepare the success response
                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('auth_you_have_been_successfully_signed_in'),
                                    'redirect' => $redirect
                                );

                                // Display the success response
                                echo json_encode($data);                                

                            }

                        } else {

                            // Add a block count
                            $this->block_count();

                            // Display error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                            );

                            echo json_encode($data); 

                        }

                    } else {

                        // Add a block count
                        $this->block_count();

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                        );

                        echo json_encode($data); 

                    }

                } else {

                    // Add a block count
                    $this->block_count();

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                    );

                    echo json_encode($data); 

                }

            } else {

                // Add a block count
                $this->block_count();

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                );

                echo json_encode($data); 

            }
            
        } else if ( preg_match('/m_/i', $args['email']) ) {

            // Get the team's owner
            $team_owner = $this->CI->team->check($args['email'], $args['password']);

            if ($team_owner) {

                // Get user data
                $user_data = $this->CI->base_users->get_user_data_by_username($team_owner['username']);

                // First we check if the team's owner was blocked
                if ( $user_data[0]->status === 2 ) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_your_account_is_blocked')
                    );

                    echo json_encode($data);                    

                } else {

                    // Verify if the member's account is enabled
                    if ($team_owner['status']) {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('auth_your_account_is_disabled')
                        );

                        echo json_encode($data);   
                        exit();
                        
                    }

                    // Create the session
                    $this->CI->session->set_userdata('username', $team_owner['member_username']);

                    // Create the team's member session
                    $this->CI->session->set_userdata('member', $team_owner['member_username']);

                    // If remember me are unckecked the session will be deleted after two hours
                    if ( !empty($args['remember']) ) {

                        $this->CI->session->set_userdata('autodelete', time() + 7200);
                    }

                    // Verify if user has temporary blocks
                    if ($this->CI->session->userdata('block_user')) {

                        // Delete temporary blocks
                        $this->CI->session->unset_userdata('block_user');

                    }

                    // Verifies if user has a plan
                    $this->check_plan($user_data[0]->user_id);

                    // Set redirect
                    $redirect = $this->get_plan_redirect($user_data[0]->user_id);

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('auth_you_have_been_successfully_signed_in'),
                        'redirect' => $redirect
                    );

                    // Display the success message
                    echo json_encode($data);                    
                    
                }

            } else {

                // Add a block count
                $this->block_count();

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                );

                echo json_encode($data);  
                
            }

        } else {

            // Check if user and password exists
            if ( $this->CI->base_users->check_user($args['email'], $args['password']) ) {

                // Get user data
                $user_data = $this->CI->base_users->get_user_data_by_username($args['email']);

                // First we check if the user account was blocked
                if ( $user_data[0]->status === 2) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_your_account_is_blocked')
                    );

                    echo json_encode($data);  

                } else {

                    $this->CI->session->set_userdata('username', strtolower($args['email']));

                    // If remember me are unckecked the session will be deleted after two hours
                    if ( !empty($args['remember']) ) {

                        $this->CI->session->set_userdata('autodelete', time() + 7200);
                    }

                    // Verify if user has temporary blocks
                    if ($this->CI->session->userdata('block_user')) {

                        // Delete temporary blocks
                        $this->CI->session->unset_userdata('block_user');

                    }

                    // Default redirect
                    $redirect = base_url('user/app/dashboard');

                    // Verify if is the user
                    if ( $user_data[0]->role < 1 ) {

                        // Verifies if user has a plan
                        $this->check_plan($user_data[0]->user_id);

                        // Set redirect
                        $redirect = $this->get_plan_redirect($user_data[0]->user_id);

                    } else {

                        // Set admin redirect
                        $redirect = base_url('admin/home');

                    }

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('auth_you_have_been_successfully_signed_in'),
                        'redirect' => $redirect
                    );

                    // Display the success response
                    echo json_encode($data); 

                }

            } else {

                // Add a block count
                $this->block_count();

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_user_or_password_is_incorrect')
                );

                echo json_encode($data); 

            }

        }

    } 

    /**
     * The private method block_count will block user
     * 
     * @return void
     */
    private function block_count() {
        
        // Verify if block count exists
        if ( $this->CI->session->userdata('block_user') ) {
            
            // Get number of block counts
            $get_count = $this->CI->session->userdata('block_user');
            
            // Verify the number of block counts in the last hour
            if ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 1 ) ) {
                
                // Add new block
                $this->CI->session->unset_userdata('block_user');
                $session_data = array('time' => time(), 'tried' => 2);
                $this->CI->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 2 ) ) {
                
                // Add new block
                $this->CI->session->unset_userdata('block_user');
                $session_data = array('time' => time(), 'tried' => 3);
                $this->CI->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 3 ) ) {
                
                // Add new block
                $this->CI->session->unset_userdata('block_user');
                $session_data = array('time' => time(), 'tried' => 4);
                $this->CI->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 4 ) ) {
                
                // Add new block
                $this->CI->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 5];
                $this->CI->session->set_userdata('block_user', $session_data);
                
                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_too_many_attempts')
                );

                echo json_encode($data);
                exit();
                
            } else {
                
                // Add new block
                $this->CI->session->unset_userdata('block_user');
                $session_data = array('time' => time(), 'tried' => 1);
                $this->CI->session->set_userdata('block_user', $session_data);
                
            }
            
        } else {
            
            // Add new block
            $session_data = array('time' => time(), 'tried' => 1);
            $this->CI->session->set_userdata('block_user', $session_data);
            
        }
        
    }

    /**
     * The private method block_count checks if the user is already blocked
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    private function check_block() {
        
        // Verify if block session exists
        if ( $this->CI->session->userdata('block_user') ) {
            
            // Get number of blocks
            $get_count = $this->CI->session->userdata('block_user');
            
            // Verify how many times was blocked the user in the last hour
            if ( ($get_count['time'] > time() - 3600) AND ( $get_count['tried'] == 5) ) {
                
                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_too_many_attempts')
                );

                echo json_encode($data);
                exit();
                
            } else {
                
                // Verify how many times was blocked the user in the last hour
                if ( ($get_count['time'] < time() - 3600) ) {
                    
                    // Delete block session
                    $this->CI->session->unset_userdata('block_user');
                    
                }
                
            }
            
        }
        
    }

    /**
     * The private method check_plan verifies if the user has a plan
     * 
     * @param integer $user_id contains the user's id
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    private function check_plan($user_id) {
        
        // Get the user's plan
        $user_plan = get_user_option('plan', $user_id);

        // Verify if user has a plan, if no add default plan
        if ( !$user_plan ) {
            $this->CI->plans->change_plan(1, $user_id);
        }
        
    }

    /**
     * The private method get_plan_redirect gets redirect for the user plan
     * 
     * @param integer $user_id contains the user's id
     * 
     * @since 0.0.8.2
     * 
     * @return string with redirect's url
     */
    private function get_plan_redirect($user_id) {

        // Verify if required redirect exists
        if ( $this->CI->session->userdata('required_redirect') ) {

            // Set required redirect
            $redirect = base_url($this->CI->session->userdata('required_redirect'));

            // Delete the required redirect
            $this->CI->session->unset_userdata('required_redirect');

            return $redirect;

        }
        
        // Get the user's plan
        $plan_id = get_user_option('plan', $user_id);

        // Redirect url
        $redirect_url = base_url('user/app/dashboard');

        // Verify if the plan has a selected user_redirect
        if ( plan_feature( 'user_redirect', $plan_id ) ) {

            // Get user_redirect
            $user_redirect = plan_feature( 'user_redirect', $plan_id );

            // Verify if the redirect is a component
            if ( is_dir(MIDRUB_BASE_USER . 'components/collection/' . $user_redirect . '/') ) {
                
                // Get the component
                $cl = implode('\\', array('MidrubBase', 'User', 'Components', 'Collection', ucfirst($user_redirect), 'Main'));

                // Verify if the component is available
                if ( (new $cl())->check_availability() ) {

                    // Set new redirect
                    $redirect_url = site_url('user/' . $user_redirect);

                }

            } else if ( is_dir(MIDRUB_BASE_USER . 'apps/collection/' . $user_redirect . '/') ) {

                // Get the app
                $cl = implode('\\', array('MidrubBase', 'User', 'Apps', 'Collection', ucfirst($user_redirect), 'Main'));

                // Verify if the app is available
                if ( (new $cl())->check_availability() ) {

                    // Set new redirect
                    $redirect_url = site_url('user/app/' . $user_redirect);

                }

            }
            
        }

        // Return the redirect
        return $redirect_url;
        
    }

}