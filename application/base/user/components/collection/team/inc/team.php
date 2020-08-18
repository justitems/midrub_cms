<?php
/**
 * Team Inc
 *
 * PHP Version 7.2
 *
 * This files contains the general functions for
 * the Team component
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('team_membesrs_total')) {
    
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

if (!function_exists('check_team_role_permission')) {
    
    /**
     * The function check_team_role_permission returns all permissions based on role's ID
     * 
     * @param integer $role_id contains the role's ID
     * @param string $permission contains the requested permission
     * 
     * @return boolean true or false
     */
    function check_team_role_permission($role_id, $permission) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if $all_options property is not empty
        if ( !empty($CI->team_all_role_permissions) ) {
            
            if ( isset($CI->team_all_role_permissions[$permission]) ) {
                return true;
            } else {
                return false;
            }
            
        } else {

            // Get role's permissions
            $permissions = $CI->base_model->get_data_where(
                'teams_roles_permission',
                'permission_id, permission',
                array(
                    'role_id' => $role_id
                )
            );

            // Create new array
            $CI->team_all_role_permissions = array();

            if ($permissions) {

                foreach ($permissions as $perm) {
                    $CI->team_all_role_permissions[$perm['permission']] = $perm['permission_id'];
                }

            }

            if ( isset($CI->team_all_role_permissions[$permission]) ) {
                return true;
            } else {
                return false;
            }
        
        }
        
    }
    
}