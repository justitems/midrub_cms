<?php
/**
 * Team Helper
 *
 * This file contains the class Team
 * with methods to manage the team
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Activities\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Team class provides the methods to manage the team
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
*/
class Team {
    
    /**
     * Class variables
     *
     * @since 0.0.8.2
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.2
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method load_team_members loads team's members
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function load_team_members() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get data
            $key = $this->CI->input->post('key', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Members by username
                $members_by_username = $this->CI->base_model->get_data_where(
                    'teams',
                    '*',
                    array(
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array('member_username' => $this->CI->db->escape_like_str($key))
                );

                // Members by first name
                $members_by_first_name = $this->CI->base_model->get_data_where(
                    'teams_meta',
                    'teams_meta.member_id',
                    array(
                        'user_id' => $this->CI->user_id,
                        'teams_meta.meta_name' => 'first_name'
                    ),
                    array(),
                    array('teams_meta.meta_value' => $this->CI->db->escape_like_str($key)),
                    array(array(
                        'table' => 'teams',
                        'condition' => 'teams_meta.member_id=teams.member_id',
                        'join_from' => 'LEFT'
                    ))
                );

                // Members by last name
                $members_by_last_name = $this->CI->base_model->get_data_where(
                    'teams_meta',
                    'teams_meta.member_id',
                    array(
                        'user_id' => $this->CI->user_id,
                        'teams_meta.meta_name' => 'last_name'
                    ),
                    array(),
                    array('teams_meta.meta_value' => $this->CI->db->escape_like_str($key)),
                    array(array(
                        'table' => 'teams',
                        'condition' => 'teams_meta.member_id=teams.member_id',
                        'join_from' => 'LEFT'
                    ))
                );

                // Members ids array
                $ids = array();

                // Verify if $members_by_username is not empty
                if ( $members_by_username ) {

                    // List found members
                    foreach ( $members_by_username as $member ) {

                        // Set member's id
                        $ids[] = $member['member_id'];

                    }

                }

                // Verify if $members_by_first_name is not empty
                if ( $members_by_first_name ) {

                    // List found members
                    foreach ( $members_by_first_name as $member ) {

                        // Verify if member already exists
                        if ( in_array($member['member_id'], $ids) ) {
                            continue;
                        }

                        // Set member's id
                        $ids[] = $member['member_id'];

                    }

                }

                // Verify if $members_by_last_name is not empty
                if ( $members_by_last_name ) {

                    // List found members
                    foreach ( $members_by_last_name as $member ) {

                        // Verify if member already exists
                        if ( in_array($member['member_id'], $ids) ) {
                            continue;
                        }

                        // Set member's id
                        $ids[] = $member['member_id'];

                    }

                }

                // Verify if members exists
                if ( $ids ) {

                    // Get all members
                    $get_members = $this->CI->base_model->get_data_where(
                        'teams',
                        '*',
                        array(),
                        array('member_id', $ids),
                        array(),
                        array(),
                        array(
                            'order' => array('member_id', 'desc'),
                            'start' => 0,
                            'limit' => 10
                        )
                    );
                    
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
                                'username' => $username
                            );
                            
                        }
                        
                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'members' => $members
                        );
                        
                        // Display the success response
                        echo json_encode($data);
                        exit();
                        
                    }

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line( 'activities_no_members_found' )
        );

        // Display the error message
        echo json_encode($data);   
        
    }

}

/* End of file team.php */