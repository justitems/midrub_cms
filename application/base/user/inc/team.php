<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the User's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('verify_team_role_permission') ) {
    
    /**
     * The function verify_team_role_permission verifies if member has permission
     * 
     * @param string $permission contains the requested permission
     * 
     * @since 0.0.7.9
     * 
     * @return boolean true or false
     */
    function verify_team_role_permission($permission) {

        // Get codeigniter object instance
        $CI =& get_instance();

        // Verify if $all_options property is not empty
        if ( !empty($CI->team_role_permissions) ) {
            
            if ( isset($CI->team_role_permissions[$permission]) ) {
                return true;
            } else {
                return false;
            }
            
        } else {

            // Get role's permissions
            $permissions = $CI->base_model->get_data_where(
                'teams_roles_permission',
                'teams_roles_permission.permission_id, teams_roles_permission.permission',
                array(
                    'teams.member_username' => $CI->session->userdata['member']
                ),
                array(),
                array(),
                array(
                    array(
                        'table' => 'teams',
                        'condition' => 'teams_roles_permission.role_id=teams.role_id',
                        'join_from' => 'LEFT'
                    )
                )
            );

            // Create new array
            $CI->team_role_permissions = array();

            if ($permissions) {

                foreach ($permissions as $perm) {
                    $CI->team_role_permissions[$perm['permission']] = $perm['permission_id'];
                }

            }

            if ( isset($CI->team_role_permissions[$permission]) ) {
                return true;
            } else {
                return false;
            }
        
        }

    }

}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| REGISTER DEFAULT HOOKS
|--------------------------------------------------------------------------
*/