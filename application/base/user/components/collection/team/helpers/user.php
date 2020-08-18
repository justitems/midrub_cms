<?php
/**
 * User Helper
 *
 * This file contains the class User
 * with some methods for user
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Team\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class provides some methods for user
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
*/
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method delete_user deletes user's team
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function delete_user($user_id) {

        // Delete team's members
        $this->CI->base_model->delete('teams', array(
            'user_id' => $user_id
        ));

        // Get user's roles 
        $get_roles = $this->CI->base_model->get_data_where('teams_roles', 'role_id', array(
            'user_id' => $user_id
        ));

        // Verify if roles exists
        if ( $get_roles ) {

            foreach ( $get_roles as $role ) {

                // Try to delete the team's role
                $this->CI->base_model->delete('teams_roles', array(
                    'role_id' => $role['role_id']
                ));

                // Try to delete the role's permissions
                $this->CI->base_model->delete('teams_roles_permission', array(
                    'role_id' => $role['role_id']
                ));

            } 

        }
        
    }

}

/* End of file user.php */