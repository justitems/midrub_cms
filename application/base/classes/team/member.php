<?php
/**
 * Member Class
 *
 * This file loads the Member Class with methods used for team
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Team;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Member class loads the methods used for team
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Member {

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method the_name gets the member's name
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * 
     * @since 0.0.8.5
     * 
     * @return string with member name or boolean
     */
    public function the_name($user_id, $member_id) {

        // Verify if member_id is not 0
        if ( !empty($member_id) ) {

            // Get the member
            $the_member = $this->CI->base_model->the_data_where(
                'teams',
                'teams.member_username, first_name.meta_value AS member_first_name, last_name.meta_value AS member_last_name',
                array(
                    'teams.user_id' => $user_id,
                    'teams.member_id' => $member_id
                ),
                array(),
                array(),
                array(
                    array(
                        'table' => 'teams_meta first_name',
                        'condition' => "teams.member_id=first_name.member_id AND first_name.meta_name='first_name'",
                        'join_from' => 'LEFT'
                    ), array(
                        'table' => 'teams_meta last_name',
                        'condition' => "teams.member_id=last_name.member_id AND last_name.meta_name='last_name'",
                        'join_from' => 'LEFT'
                    )
                )
            );    

            // Verify if the member exists
            if ( !empty($the_member) ) {

                return !empty($the_member[0]['member_first_name'])?$the_member[0]['member_first_name'] . ' ' . $the_member[0]['member_last_name']:$the_member[0]['member_username'];

            } else {

                return FALSE;

            }

        } else {

            // Get the user
            $the_user = $this->CI->base_model->the_data_where(
                'users',
                '*',
                array(
                    'user_id' => $user_id
                )
            );    

            // Verify if the user exists
            if ( !empty($the_user) ) {

                return !empty($the_user[0]['first_name'])?$the_user[0]['first_name'] . ' ' . $the_user[0]['last_name']:$the_user[0]['username'];

            } else {

                return FALSE;

            }

        }

    }

}

/* End of file member.php */