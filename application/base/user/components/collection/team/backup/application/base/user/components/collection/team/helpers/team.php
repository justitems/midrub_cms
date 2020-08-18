<?php
/**
 * Team Helper
 *
 * This file contains the class Team
 * with methods to manage the team
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Team\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Email as MidrubBaseClassesEmail;

/*
 * Team class provides the methods to manage the team
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Team {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load Team Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_teams', 'base_teams' );

        // Load the Base Users Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_users', 'base_users' );

        // Load the Teams Members Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_TEAM . 'models/', 'Teams_members', 'teams_members' );  

    }

    /**
     * The public method team_new_member creates a new member
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_new_member() {
        
        if ( team_members_total() >= plan_feature('teams') ) {
            
            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line( 'reached_maximum_number_allowed_members' )
            );

            echo json_encode($data);
            exit();
            
        }
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('role_id', 'Role ID', 'trim');
            $this->CI->form_validation->set_rules('first_name', 'First Name', 'trim');
            $this->CI->form_validation->set_rules('last_name', 'Last Name', 'trim');
            $this->CI->form_validation->set_rules('username', 'Username', 'trim|min_length[6]|required');
            $this->CI->form_validation->set_rules('email', 'Email', 'trim');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|required');
            $this->CI->form_validation->set_rules('notification', 'Notification', 'trim');

            // Get data
            $role_id = $this->CI->input->post('role_id', TRUE);
            $first_name = $this->CI->input->post('first_name', TRUE);
            $last_name = $this->CI->input->post('last_name', TRUE);
            $username = $this->CI->input->post('username', TRUE);
            $email = $this->CI->input->post('email', TRUE);
            $status = $this->CI->input->post('status', TRUE);
            $password = $this->CI->input->post('password', TRUE);
            $notification = $this->CI->input->post('notification', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line( 'username_password_short' )
                );

                // Display the error response
                echo json_encode($data);

            } else {

                // Verify if the role is numeric
                if ( !is_numeric($role_id) ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('please_select_a_role')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Verify if the user is the owner of the role
                $get_role = $this->CI->base_model->get_data_where('teams_roles', 'role_id', array(
                    'role_id' => $role_id,
                    'user_id' => $this->CI->user_id
                ));

                if ( !$get_role ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('you_are_not_the_role_owner')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Verify if the email is valid
                if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'role_email_address_not_valid' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();                    

                }
                
                // Verify if email address already exists in teams
                if ( $this->CI->base_teams->check_member_email( $email ) ) {
                    
                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'email_used_another_team_member' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();
                }

                // Verify if email address already exists in users
                $get_email = $this->CI->base_model->get_data_where('users', 'user_id', array(
                    'email' => $email
                ));

                // Verify if the email exists
                if ( $get_email ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'email_used_another_team_member' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();

                }

                // Verify if the status is valid
                if ( ($status !== '0') && ($status !== '1') ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'please_select_a_status' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();
                    
                }

                // Save the member
                $member_id = $this->CI->base_teams->save_member( $this->CI->user_id, $username, $email, $role_id, $status, '', $password );

                // Verify if the member was saved
                if ( $member_id ) {

                    // Verify if first name exists
                    if ( $first_name ) {

                        // Save the first name
                        $this->update_teams_meta($member_id, 'first_name', trim($first_name));

                    }

                    // Verify if last name exists
                    if ( $last_name ) {

                        // Save the last name
                        $this->update_teams_meta($member_id, 'last_name', trim($last_name));

                    }

                    // Verify if notification exists
                    if ( $notification ) {

                        // Get user's data from the users table
                        $get_user = $this->CI->base_model->get_data_where('users',
                        '*',
                        array(
                            'user_id' => $this->CI->user_id
                        ));

                        // Verify if user exists
                        if ( $get_user ) {

                            // Get team owner name
                            $name = ($get_user[0]['first_name'])?$get_user[0]['first_name'] . ' ' . $get_user[0]['last_name'] : $get_user[0]['username']; 

                            // Body
                            $body = '<p>' . $this->CI->lang->line('you_can_login_here') . ': ' . site_url() . '</p>'
                                    . '<p>' . $name . ' ' . $this->CI->lang->line('has_added_you_his_team') . '</p>'
                                    . '<p>' . $this->CI->lang->line('use_this_data_for_login') . ':</p>'
                                    . '<p>' . $this->CI->lang->line('member_email') . ': ' . $email . '</p>'
                                    . '<p>' . $this->CI->lang->line('member_password') . ': ' . $password . '</p>'
                                    . '<p>' . $this->CI->lang->line('cheers') . '</p>'
                                    . '<p>' . str_replace('[site_name]', $this->CI->config->item('site_name'), $this->CI->lang->line('the_site_team')) . '</p>';

                            // Create email
                            $email_args = array(
                                'from_name' => $this->CI->config->item('site_name'),
                                'from_email' => $this->CI->config->item('contact_mail'),
                                'to_email' => $email,
                                'subject' => $this->CI->lang->line( 'your_account_has_been_successfully_created' ),
                                'body' => $body
                            );

                            // Send email
                            (new MidrubBaseClassesEmail\Send())->send_mail($email_args);

                        }

                    }

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line( 'member_was_saved_successfully' ),
                        'words' => array(
                            'select_a_role' => $this->CI->lang->line( 'select_a_role' ),
                            'select_a_status' => $this->CI->lang->line( 'select_a_status' )
                        )
                    );

                    // Display the success response
                    echo json_encode($data);                           

                } else {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'member_was_not_saved_successfully' )
                    );

                    // Display the error response
                    echo json_encode($data);                         

                }

            }

        }
        
    }

    /**
     * The public method team_update_member updates member's info
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_update_member() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('member_id', 'Member ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('first_name', 'First Name', 'trim');
            $this->CI->form_validation->set_rules('last_name', 'Last Name', 'trim');
            $this->CI->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->CI->form_validation->set_rules('role_id', 'Role ID', 'trim');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim');
            $this->CI->form_validation->set_rules('about', 'About', 'trim');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim');
            $this->CI->form_validation->set_rules('notification', 'Notification', 'trim');

            // Get data
            $member_id = $this->CI->input->post('member_id', TRUE);
            $first_name = $this->CI->input->post('first_name', TRUE);
            $last_name = $this->CI->input->post('last_name', TRUE);
            $email = $this->CI->input->post('email', TRUE);
            $role_id = $this->CI->input->post('role_id', TRUE);
            $status = $this->CI->input->post('status', TRUE);
            $about = $this->CI->input->post('about', TRUE);
            $password = $this->CI->input->post('password', TRUE);
            $notification = $this->CI->input->post('notification', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line( 'role_email_address_not_valid' )
                );

                // Display the error response
                echo json_encode($data);

            } else {

                // Verify if the role is numeric
                if ( !is_numeric($role_id) ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('please_select_a_role')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Verify if the user is the owner of the role
                $get_role = $this->CI->base_model->get_data_where('teams_roles', 'role_id', array(
                    'role_id' => $role_id,
                    'user_id' => $this->CI->user_id
                ));

                if ( !$get_role ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('you_are_not_the_role_owner')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Verify if the email is valid
                if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'role_email_address_not_valid' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();                    

                }
                
                // Get email address
                $check_email = $this->CI->base_teams->check_member_email( trim($email) );
                
                // Verify if the email address is valid
                if ( $check_email ) {
                    
                    // Verify if the email is not of the current member
                    if ( $check_email[0]->member_id != $member_id ) {
                    
                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line( 'email_used_another_team_member' )
                        );

                        // Display the error response
                        echo json_encode($data);   
                        exit();
                    
                    }
                    
                }

                // Get email from the users table
                $get_email = $this->CI->base_model->get_data_where('users', 'user_id', array(
                    'email' => trim($email)
                ));

                // Verify if email address already exists in users table
                if ( $get_email ) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'email_used_another_team_member' )
                    );

                    // Display the error response
                    echo json_encode($data);   
                    exit();

                }

                // Verify if the password exists
                if ( $password ) {

                    // Verify if the password is short
                    if ( strlen($password) < 6 ) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('password_short')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }
                    
                }

                // About variable
                $about_member = '';

                // Verify if about's data exists
                if ( $about ) {

                    // Set about member's data
                    $about_member = $about;

                }

                // Save the member
                if ( $this->CI->base_teams->update_member( $member_id, $this->CI->user_id, $email, $role_id, $status, $about_member, $password ) ) {

                    // Verify if the password was changed
                    if ( $password ) {

                        // Verify if notification exists
                        if ( $notification ) {

                            // Get user's data from the users table
                            $get_user = $this->CI->base_model->get_data_where('users',
                            '*',
                            array(
                                'user_id' => $this->CI->user_id
                            ));

                            // Verify if user exists
                            if ( $get_user ) {

                                // Get team owner name
                                $name = ($get_user[0]['first_name'])?$get_user[0]['first_name'] . ' ' . $get_user[0]['last_name'] : $get_user[0]['username']; 

                                // Body
                                $body = '<p>' . $this->CI->lang->line('you_can_login_here') . ': ' . site_url() . '</p>'
                                        . '<p>' . $name . ' ' . $this->CI->lang->line('has_changed_your_password') . '</p>'
                                        . '<p>' . $this->CI->lang->line('use_this_data_for_login') . ':</p>'
                                        . '<p>' . $this->CI->lang->line('member_email') . ': ' . $email . '</p>'
                                        . '<p>' . $this->CI->lang->line('member_password') . ': ' . $password . '</p>'
                                        . '<p>' . $this->CI->lang->line('cheers') . '</p>'
                                        . '<p>' . str_replace('[site_name]', $this->CI->config->item('site_name'), $this->CI->lang->line('the_site_team')) . '</p>';

                                // Create email
                                $email_args = array(
                                    'from_name' => $this->CI->config->item('site_name'),
                                    'from_email' => $this->CI->config->item('contact_mail'),
                                    'to_email' => $email,
                                    'subject' => $this->CI->lang->line( 'your_account_password_was_changed' ),
                                    'body' => $body
                                );

                                // Send email
                                (new MidrubBaseClassesEmail\Send())->send_mail($email_args);

                            }

                        }

                    }

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line( 'member_was_updated_successfully' ),
                        'words' => array(
                            'select_a_role' => $this->CI->lang->line( 'select_a_role' ),
                            'select_a_status' => $this->CI->lang->line( 'select_a_status' )
                        )
                    );

                    echo json_encode($data);                           

                } else {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'member_was_not_updated_successfully' )
                    );

                    // Display the error response
                    echo json_encode($data);                         

                }

                exit();

            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line( 'an_error_occurred' )
        );

        // Display the error response
        echo json_encode($data);   
        
    }

    /**
     * The public method team_all_members returns all team's members
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_all_members() {
        
        // Get page's input
        $page = $this->CI->input->get('page');
        
        // Set the limit
        $limit = 10;
        $page--;
        
        // Count number of members
        $total = $this->CI->base_teams->get_members($this->CI->user_id);
        
        // Get members
        $get_members = $this->CI->base_teams->get_members( $this->CI->user_id, $page * $limit, $limit );
        
        // If members exists
        if ( $get_members ) {

            // Members ids array
            $member_ids = array();

            // List all members
            foreach ( $get_members as $member ) {
                
                // Add member's ID to array
                $member_ids[] = $member['member_id'];
                
            }
            
            // Members meta array
            $members_meta = array();

            // Get members meta
            $get_metas = $this->CI->base_model->get_data_where('teams_meta', '*',
            array(),
            array('member_id', $member_ids));

            // Verify if metas exists
            if ( $get_metas ) {

                // List all metas
                foreach ( $get_metas as $meta ) {

                    // Verify if meta_name is first_name or last_name
                    if ( ($meta['meta_name'] === 'first_name') || ($meta['meta_name'] === 'last_name') ) {

                        // Verify if member's id exists
                        if ( isset($members_meta[$meta['member_id']]) ) {

                            // Set last name
                            $members_meta[$meta['member_id']] = $members_meta[$meta['member_id']] . ' ' . $meta['meta_value'];

                        } else {

                            // Set first name
                            $members_meta[$meta['member_id']] = $meta['meta_value'];

                        }

                    }

                }
                
            }
            
            // Members array
            $members = array();
            
            // List all members
            foreach ( $get_members as $member ) {

                // Set username
                $username = $member['member_username'];
                
                // Verify if user has first and last name
                if ( isset($members_meta[$member['member_id']]) ) {

                    // Set first and last name
                    $username = $members_meta[$member['member_id']];
                    
                }

                // Add member to array
                $members[] = array(
                    'member_id' => $member['member_id'],
                    'username' => $username,
                    'status' => $member['status'],
                    'role' => $member['role'],
                    'picture' => '//gravatar.com/avatar/' . md5($member['member_email']) . '?s=200',
                    'date_joined' => strtotime($member['date_joined']),
                    'last_access' => strtotime($member['last_access'])
                );
                
            }
            
            // Prepare the success response
            $data = array(
                'success' => TRUE,
                'total' => $total,
                'members' => $members,
                'page' => ($page + 1),
                'time' => time(),
                'words' => array(
                    'never' => $this->CI->lang->line( 'never' ),
                    'active' => $this->CI->lang->line( 'active' ),
                    'inactive' => $this->CI->lang->line( 'inactive' ),
                    'status' => $this->CI->lang->line( 'status' ),
                    'results' => $this->CI->lang->line( 'results' ),
                    'of' => $this->CI->lang->line( 'of' )
                )
            );
            
            // Display the success response
            echo json_encode($data);
            
        } else {

            // Prepare the error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line( 'no_members_found' )
            );

            // Display the error message
            echo json_encode($data);                         

        }
        
    }

    /**
     * The public method team_member_info returns the member's info
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_member_info() {
        
        // Get member_id's input
        $member_id = $this->CI->input->get('member_id');
        
        // Get member details
        $get_member = $this->CI->base_teams->get_member( $this->CI->user_id, $member_id );
        
        // If members exists
        if ( $get_member ) {
            
            // Display success message
            $data = array(
                'success' => TRUE,
                'member_info' => $get_member,
                'date' => time(),
                'never' => $this->CI->lang->line( 'never' )
            );
            
            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line( 'an_error_occurred' )
            );

            echo json_encode($data);                         

        }

    }

    /**
     * The public method team_member_delete deletes a team's member
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_member_delete() {

        // Get member_id's input
        $member_id = $this->CI->input->get('member_id');
        
        // Delete member
        $delete_member = $this->CI->base_teams->delete_member( $this->CI->user_id, $member_id );
        
        // Verify if the member was deleted
        if ( $delete_member ) {
            
            // Display success message
            $data = array(
                'success' => TRUE,
                'message' => $this->CI->lang->line( 'team_member_deleted' )
            );
            
            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line( 'team_member_not_deleted' )
            );

            echo json_encode($data);                         

        }

    }

    /**
     * The public method members_action_execute executes actions for members
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function members_action_execute() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('selected_action', 'Selected Action', 'trim');
            $this->CI->form_validation->set_rules('selected_members', 'Selected Members', 'trim');

            // Get data
            $selected_action = $this->CI->input->post('selected_action', TRUE);
            $selected_members = $this->CI->input->post('selected_members', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if members were selected
                if ( !$selected_members ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'please_select_a_member' )
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Members array
                $members = array();

                // List all members
                foreach ( $selected_members as $selected_member ) {

                    // Verify if $selected_member is numeric
                    if ( is_numeric($selected_member) ) {
                        $members[] = $selected_member;
                    }

                }

                // Verify if members exists
                if ( !$members ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'please_select_a_member' )
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Counter
                $count = 0;
                
                // Execute actions
                switch ( $selected_action ) {

                    case '0':

                        // List the members
                        foreach ( $members as $member ) {

                            // Enable member
                            if ( $this->CI->base_model->update('teams', array('member_id' => $member, 'user_id' => $this->CI->user_id), array('status' => 0) ) ) {
                                $count++;
                            }

                        }

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => str_replace('(number)', $count, $this->CI->lang->line( 'action_was_applied_successfully' ))
                        );

                        // Display the success response
                        echo json_encode($data);
                        exit();

                        break;

                    case '1':

                        // List the members
                        foreach ( $members as $member ) {

                            // Enable member
                            if ( $this->CI->base_model->update('teams', array('member_id' => $member, 'user_id' => $this->CI->user_id), array('status' => 1) ) ) {
                                $count++;
                            }

                        }

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => str_replace('(number)', $count, $this->CI->lang->line( 'action_was_applied_successfully' ))
                        );

                        // Display the success response
                        echo json_encode($data);
                        exit();

                        break;
    
                    case '2':

                        // List the members
                        foreach ( $members as $member ) {

                            // Enable member
                            if ( $this->CI->base_model->delete('teams', array('member_id' => $member, 'user_id' => $this->CI->user_id) ) ) {
                                $count++;
                            }

                        }

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $count . $this->CI->lang->line( 'members_were_deleted' )
                        );

                        // Display the success response
                        echo json_encode($data);
                        exit();

                        break;

                }


            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line( 'an_error_occurred' )
        );

        // Display the error response
        echo json_encode($data);     

    }

    /**
     * The public method update_teams_meta updates a teams meta
     * 
     * @param integer $member_id contains the teams ID
     * @param string $name contains the meta's name
     * @param string $value contains the meta's value
     * @param string $extra contains the meta's extra
     * 
     * @since 0.0.8.2
     * 
     * @return boolean true or false
     */
    public function update_teams_meta($member_id, $name, $value, $extra=NULL) {

        // Get teams meta
        $get_teams_meta = $this->CI->base_model->get_data_where(
            'teams_meta',
            'meta_id',
            array(
                'member_id' => $member_id,
                'meta_name' => $name
            )
        );

        // Verify if the meta exists
        if ( $get_teams_meta ) {

            // Prepare the where data
            $where = array(
                'meta_id' => $get_teams_meta[0]['meta_id']
            );

            // Prepare the update's data
            $update = array(
                'meta_value' => $value
            );

            // Verify if extra exists
            if ( $extra ) {

                // Set the meta's extra
                $update['meta_extra'] = $extra;

            }

            // Update the teams meta
            if (  $this->CI->base_model->update('teams_meta', $where, $update) ) {
                return true;
            } else {
                return false;
            }

        } else {

            // Prepare the meta
            $meta_args = array(
                'member_id' => $member_id,
                'meta_name' => $name,
                'meta_value' => $value
            );

            // Verify if extra exists
            if ( $extra ) {

                // Set the meta's extra
                $meta_args['meta_extra'] = $extra;

            }

            // Save the teams meta by using the Base's Model
            if ( $this->CI->base_model->insert('teams_meta', $meta_args) ) {
                return true;
            } else {
                return false;
            }
            
        }

    }

}

/* End of file team.php */