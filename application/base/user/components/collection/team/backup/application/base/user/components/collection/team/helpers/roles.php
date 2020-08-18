<?php
/**
 * Roles Helper
 *
 * This file contains the class Roles
 * with methods to manage the Roles
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Team\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Roles class provides the methods to manage the roles
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Roles {
    
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
        
        // Load the Teams Roles Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_TEAM . 'models/', 'Teams_roles', 'teams_roles' );

    }

    /**
     * The public method team_create_role creates a new role
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_create_role() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('role', 'Role', 'trim|required');

            // Get data
            $role = $this->CI->input->post('role');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line( 'please_enter_a_valid_role' )
                );

                echo json_encode($data);

            } else {

                // Prepare params to save
                $params = array(
                    'user_id' => $this->CI->user_id,
                    'role' => $role
                );

                // Create the role
                $role_id = $this->CI->base_model->insert('teams_roles', $params);

                // Save the member
                if ( $role_id ) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line( 'role_was_saved_successfully' ),
                        'role_id' => $role_id
                    );

                    echo json_encode($data);                           

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'role_was_not_saved_successfully' )
                    );

                    echo json_encode($data);                         

                }

            }

        }
        
    }

    /**
     * The public method save_role_permission saves role's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function save_role_permission() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('role_id', 'Role ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('permission', 'Permission', 'trim|required');

            // Get data
            $role_id = $this->CI->input->post('role_id');
            $permission = $this->CI->input->post('permission');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line( 'an_error_occurred' )
                );

                echo json_encode($data);

            } else {

                // Verify if the user is the owner of the role
                $get_role = $this->CI->base_model->get_data_where('teams_roles', 'role_id', array(
                    'role_id' => $role_id,
                    'user_id' => $this->CI->user_id
                ));

                if ( !$get_role ) {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('you_are_not_the_role_owner')
                    );

                    echo json_encode($data);
                    exit();
                    
                }

                // Verify if the permission was already added
                $get_permission = $this->CI->base_model->get_data_where('teams_roles_permission', 'permission_id', array(
                    'role_id' => $role_id,
                    'permission' => $permission
                ));

                if (!$get_permission) {

                    // Prepare params to save
                    $params = array(
                        'role_id' => $role_id,
                        'permission' => $permission
                    );

                    // Save the permission
                    if ($this->CI->base_model->insert('teams_roles_permission', $params)) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('permission_was_added_successfully')
                        );

                        echo json_encode($data);

                    } else {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('permission_was_not_added_successfully')
                        );

                        echo json_encode($data);
                    }

                } else {

                    // Prepare params
                    $params = array(
                        'role_id' => $role_id,
                        'permission' => $permission
                    );

                    // Remove the permission
                    if ($this->CI->base_model->delete('teams_roles_permission', $params)) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('permission_was_removed_successfully')
                        );

                        echo json_encode($data);
                        
                    } else {

                        // Display error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('permission_was_not_removed_successfully')
                        );

                        echo json_encode($data);

                    }

                }

            }

        }
        
    }

    /**
     * The public method team_all_roles loads the team's roles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function team_all_roles() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric');

            // Get data
            $key = $this->CI->input->post('key', TRUE);
            $page = $this->CI->input->post('page', TRUE);
            
            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Verify if page exists
                if ( !is_numeric($page) ) {
                    $page = 1;
                }

                // Set the limit
                $limit = 10;
                $page--;

                // Get roles
                $get_roles = $this->CI->teams_roles->get_roles(array(
                    'user_id' => $this->CI->user_id,
                    'page' => ($page * $limit),
                    'limit' => $limit                    
                ));
                
                // If roles exists
                if ( $get_roles ) {

                    // Count number of roles
                    $total = $this->CI->base_model->get_data_where('teams_roles', 'role_id, role',
                    array(
                        'user_id' => $this->CI->user_id
                    ),
                    array(),
                    array(
                        'role' => $this->CI->db->escape_like_str($key)
                    ));
                    
                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'total' => count($total),
                        'roles' => $get_roles,
                        'page' => ($page + 1),
                        'words' => array(
                            'results' => $this->CI->lang->line( 'results' ),
                            'of' => $this->CI->lang->line( 'of' ),
                            'members' => strtolower($this->CI->lang->line( 'members' ))
                        )
                    );
                    
                    // Display the succes response
                    echo json_encode($data);
                    exit();
                    
                }

            }

        }
        
        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line( 'no_roles_found' )
        );

        // Display the error message
        echo json_encode($data);    
        
    }

    /**
     * The public method roles_action_execute executes actions for roles
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function roles_action_execute() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('selected_action', 'Selected Action', 'trim');
            $this->CI->form_validation->set_rules('selected_roles', 'Selected Roles', 'trim');

            // Get data
            $selected_action = $this->CI->input->post('selected_action', TRUE);
            $selected_roles = $this->CI->input->post('selected_roles', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if members were selected
                if ( !$selected_roles ) {

                    // Prepare the error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line( 'please_select_a_role' )
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                    
                }

                // Counter
                $count = 0;
                
                // Execute actions
                switch ( $selected_action ) {
    
                    case '2':

                        // List the roles
                        foreach ( $selected_roles as $role ) {

                            // Verify if the role is numeric
                            if ( is_numeric($role) ) {

                                // Delete role
                                if ( $this->CI->base_model->delete('teams_roles', array('role_id' => $role, 'user_id' => $this->CI->user_id) ) ) {

                                    // Try to delete the role's permissions
                                    $this->CI->base_model->delete('teams_roles_permission', array(
                                        'role_id' => $role
                                    ));

                                    // Try to delete the members which has the role
                                    $this->CI->base_model->delete('teams', array(
                                        'role_id' => $role
                                    ));

                                    $count++;

                                }

                            }

                        }

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $count . $this->CI->lang->line( 'roles_were_deleted' )
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

}

/* End of file roles.php */