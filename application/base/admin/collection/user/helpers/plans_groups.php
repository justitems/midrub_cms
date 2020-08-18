<?php
/**
 * Plans Groups Helper
 *
 * This file contains the class Plans_groups
 * with methods to manage the plans's data
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\User\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans_groups class provides the methods to manage the plans's groups
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
*/
class Plans_groups {
    
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

        // Load Base Plans Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );

        // Load User Plans Groups Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_USER . 'models/', 'User_plans_groups_model', 'user_plans_groups_model' );        
        
    }

    /**
     * The public method create_plans_group creates a new plans group
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function create_plans_group() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('group_name', 'Group Name', 'trim|required');

            // Get data
            $group_name = $this->CI->input->post('group_name');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Prepare the error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_plan_group_too_short')
                );

                // Display the error message
                echo json_encode($data);
                exit();

            } else {

                // Prepare the group data
                $group = array(
                    'group_name' => $group_name,
                    'created' => time()
                );

                // Save group
                $group_id = $this->CI->base_model->insert('plans_groups', $group);

                // Verify if was saved the group
                if ( $group_id ) {
                    
                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_plan_group_was_saved')
                    );

                    // Display the success message
                    echo json_encode($data);
                    exit();              
                    
                }
                
            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_plan_group_was_not_saved')
        );

        // Display the error message
        echo json_encode($data);   
        
    }

    /**
     * The public method load_all_plans_groups loads groups by page
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function load_all_plans_groups() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $key = $this->CI->input->post('key');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;
                $page--;

                // Get groups by page
                $get_groups = $this->CI->base_model->get_data_where(
                    'plans_groups',
                    '*',
                    array(),
                    array(),
                    array('group_name' => $this->CI->db->escape_like_str($key)),
                    array(),
                    array(
                        'order' => array('group_id', 'asc'),
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );

                // Verify if groups exists
                if ( $get_groups ) {

                    // Get total groups
                    $groups = $this->CI->base_model->get_data_where(
                        'plans_groups',
                        'COUNT(group_id) AS total',
                        array(),
                        array(),
                        array('group_id' => $this->CI->db->escape_like_str($key))
                    );

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'groups' => $get_groups,
                        'total' => $groups[0]['total'],
                        'page' => ($page + 1)
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_no_plans_groups_found')
        );

        // Display the error message
        echo json_encode($data);
        exit();
        
    }

    /**
     * The public method delete_plans_group deletes plans groups
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */ 
    public function delete_plans_group() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('group_id', 'Group ID', 'trim|numeric|required');
           
            // Get received data
            $group_id = $this->CI->input->post('group_id', TRUE);
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Delete the plans group
                $delete_group = $this->CI->base_model->delete('plans_groups', array(
                    'group_id' => $group_id
                ));

                // Verify if the plans group was deleted
                if ( $delete_group ) {

                    // Delete the plans group records
                    $this->CI->base_model->delete('plans_meta', array(
                        'meta_name' => 'plans_group',
                        'meta_value' => $group_id
                    ));

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_plan_group_was_deleted')
                    );

                    // Display the success message
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_plan_group_was_not_deleted')
        );

        // Display the error message
        echo json_encode($data); 

    }

}

/* End of file plans_groups.php */