<?php
/**
 * Team helper
 *
 * This file contains the methods
 * for team's pagge
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('team_members_total')) {
    
    /**
     * The function team_members_total returns total number of user's team members
     * 
     * @return integer with number of team's members
     */
    function team_members_total() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        // Count total number of team's members and return
        return $CI->team->get_members($CI->user_id);
        
    }
    
}

if (!function_exists('team_new_member')) {
    
    /**
     * The function team_new_member creates a new member
     * 
     * @return void
     */
    function team_new_member() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        if ( team_members_total() >= plan_feature('teams') ) {
            
            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line( 'reached_maximum_number_allowed_members' )
            );

            echo json_encode($data);
            exit();
            
        }
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('username', 'Username', 'trim|min_length[6]|required');
            $CI->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $CI->form_validation->set_rules('role', 'Role', 'trim|integer|required');
            $CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $CI->form_validation->set_rules('about', 'About', 'trim');
            $CI->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|required');

            // Get data
            $username = $CI->input->post('username');
            $email = $CI->input->post('email');
            $role = $CI->input->post('role');
            $status = $CI->input->post('status');
            $about = $CI->input->post('about');
            $password = $CI->input->post('password');

            // Check form validation
            if ($CI->form_validation->run() === false) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line( 'username_password_short' )
                );

                echo json_encode($data);

            } else {
                
                // Verify if email address already exists
                if ( $CI->team->check_member_email( $email ) ) {
                    
                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line( 'email_used_another_team_member' )
                    );

                    echo json_encode($data);   
                    exit();
                }

                // Save the member
                if ( $CI->team->save_member( $CI->user_id, $username, $email, $role, $status, $about, $password ) ) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line( 'mm206' )
                    );

                    echo json_encode($data);                           

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line( 'mm207' )
                    );

                    echo json_encode($data);                         

                }

            }

        }
        
    }
    
}

if (!function_exists('team_update_member')) {
    
    /**
     * The function team_update_member updates member's info
     * 
     * @return void
     */
    function team_update_member() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('username', 'Username', 'trim|min_length[6]|required');
            $CI->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $CI->form_validation->set_rules('role', 'Role', 'trim|integer|required');
            $CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $CI->form_validation->set_rules('about', 'About', 'trim');
            $CI->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|required');

            // Get data
            $username = $CI->input->post('username');
            $email = $CI->input->post('email');
            $role = $CI->input->post('role');
            $status = $CI->input->post('status');
            $about = $CI->input->post('about');
            $password = $CI->input->post('password');

            // Check form validation
            if ($CI->form_validation->run() === false) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line( 'username_password_short' )
                );

                echo json_encode($data);

            } else {
                
                // Verify if email address already exists
                $check_email = $CI->team->check_member_email( $email );
                
                if ( $check_email ) {
                    
                    if ( $check_email[0]->member_username != $username ) {
                    
                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line( 'email_used_another_team_member' )
                        );

                        echo json_encode($data);   
                        exit();
                    
                    }
                    
                }

                // Save the member
                if ( $CI->team->update_member( $CI->user_id, $username, $email, $role, $status, $about, $password ) ) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line( 'mm208' )
                    );

                    echo json_encode($data);                           

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line( 'mm209' )
                    );

                    echo json_encode($data);                         

                }

            }

        }
        
    }
    
}

if (!function_exists('team_all_members')) {
    
    /**
     * The function team_all_members returns all team's members
     * 
     * @return void
     */
    function team_all_members() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        // Get page's input
        $page = $CI->input->get('page');
        
        // Set the limit
        $limit = 100;
        $page--;
        
        // Count number of members
        $total = $CI->team->get_members($CI->user_id);
        
        // Get members
        $get_members = $CI->team->get_members( $CI->user_id, $page * $limit, $limit );
        
        // If members exists
        if ( $get_members ) {
            
            $members = array();
            
            foreach ( $get_members as $member ) {
                
                $members[] = array(
                    'member_id' => $member->member_id,
                    'username' => $member->member_username,
                    'picture' => '//gravatar.com/avatar/' . md5($member->member_email) . '?s=200'
                );
                
            }
            
            // Display success message
            $data = array(
                'success' => TRUE,
                'total' => $total,
                'members' => $members
            );
            
            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line( 'mu323' )
            );

            echo json_encode($data);                         

        }
        
    }
    
}

if (!function_exists('team_member_info')) {
    
    /**
     * The function team_member_info returns the member's info
     * 
     * @return void
     */
    function team_member_info() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        // Get member_id's input
        $member_id = $CI->input->get('member_id');
        
        // Get member details
        $get_member = $CI->team->get_member( $CI->user_id, $member_id );
        
        // If members exists
        if ( $get_member ) {
            
            // Display success message
            $data = array(
                'success' => TRUE,
                'member_info' => $get_member,
                'date' => time(),
                'never' => $CI->lang->line( 'mu326' )
            );
            
            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line( 'mm3' )
            );

            echo json_encode($data);                         

        }
        
    }
    
}

if (!function_exists('team_member_delete')) {
    
    /**
     * The function team_member_delete deletes a team's member
     * 
     * @return void
     */
    function team_member_delete() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Team Model
        $CI->load->model('team');
        
        // Get member_id's input
        $member_id = $CI->input->get('member_id');
        
        // Delete member
        $delete_member = $CI->team->delete_member( $CI->user_id, $member_id );
        
        // Verify if the member was deleted
        if ( $delete_member ) {
            
            // Display success message
            $data = array(
                'success' => TRUE,
                'message' => $CI->lang->line( 'team_member_deleted' )
            );
            
            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line( 'team_member_not_deleted' )
            );

            echo json_encode($data);                         

        }
        
    }
    
}