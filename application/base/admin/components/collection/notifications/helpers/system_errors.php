<?php
/**
 * System Errors Helper
 *
 * This file contains the class System_errors
 * with methods to manage the system errors alerts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Notifications\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * System_errors class provides the methods to manage the system errors alerts
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
*/
class System_errors {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Notifications system errors Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_alerts_model', 'notifications_alerts_model' );

        // Load the alerts language file
        $this->CI->lang->load( 'notifications_alerts', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );
        
    }

    //-----------------------------------------------------
    // Ajax's methods for system errors Helper
    //-----------------------------------------------------

    /**
     * The public method notifications_load_system_errors loads system errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_load_system_errors() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('user', 'User', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $user = $this->CI->input->post('user');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;
                $page--;

                // Set where condition
                $where = array(
                    'notifications_alerts.alert_type' => 3
                );

                // Set join condition
                $join = array(
                    array(
                        'table' => 'notifications_alerts_fields',
                        'condition' => "notifications_alerts.alert_id=notifications_alerts_fields.alert_id AND notifications_alerts_fields.field_name='error_type'",
                        'join_from' => 'LEFT'
                    ),
                    array(
                        'table' => 'notifications_alerts_users',
                        'condition' => 'notifications_alerts.alert_id=notifications_alerts_users.alert_id',
                        'join_from' => 'LEFT'
                    )
                );

                // Verify if user exists
                if ( $user ) {

                    // Set user
                    $where['notifications_alerts_users.user_id'] = $user;

                }

                // Use the base model for a simply sql query
                $system_errorss = $this->CI->base_model->the_data_where(
                'notifications_alerts',
                'notifications_alerts.*, notifications_alerts_fields.field_value AS error_type',
                $where,
                array(),
                array(),
                $join,
                array(
                    'order_by' => array('notifications_alerts.alert_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if system errors exists
                if ( $system_errorss ) {

                    // Get total number of system errors with base model
                    $total = $this->CI->base_model->the_data_where(
                    'notifications_alerts',
                    'COUNT(notifications_alerts.alert_id) AS total',
                    $where,
                    array(),
                    array(),
                    $join
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'alerts' => $system_errorss,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'delete' => $this->CI->lang->line('notifications_delete'),
                            'of' => $this->CI->lang->line('notifications_of'),
                            'results' => $this->CI->lang->line('notifications_results')
                        )
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_no_alerts_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method notifications_load_system_errors_users loads users which have errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_load_system_errors_users() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $key = $this->CI->input->post('key');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set where parameters
                $where = array(
                    'page' => 0,
                    'limit' => 5
                );

                // Verify if key exists
                if ( $key ) {

                    // Set key
                    $where['key'] = trim($key);

                }

                // Get the users
                $the_users = $this->CI->notifications_alerts_model->the_errors_users($where);

                // Verify if users exists
                if ( $the_users ) {

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'users' => $the_users
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_no_users_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method notifications_delete_system_error deletes a system error
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_delete_system_error() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alert', 'Alert', 'trim|numeric|required');
           
            // Get received data
            $alert = $this->CI->input->post('alert');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Try to delete a system error
                $response = $this->delete_system_errors($alert);

                // Verify if the system error was deleted
                if ( !empty($response['success']) ) {

                    // Prepare success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('notifications_system_errors_was_deleted_successfully')
                    );

                    // Display the success message
                    echo json_encode($data);

                } else {

                    // Prepare error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_system_errors_was_not_deleted_successfully')
                    );

                    // Delete the error message
                    echo json_encode($data);

                }

                exit();

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_an_error_occured')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method notifications_delete_system_errors deletes bulk system errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_delete_system_errors() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alerts', 'Alerts', 'trim');
           
            // Get received data
            $alerts = $this->CI->input->post('alerts');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if at least an alert was selected
                if ( $alerts ) {

                    // Count number of deleted system errors
                    $count = 0;

                    // List all system errors
                    foreach ( $alerts as $alert ) {

                        // Try to delete the system error
                        $response = $this->delete_system_errors($alert);

                        // Verify if the system error was deleted
                        if ( !empty($response['success']) ) {
                            $count++;
                        }

                    }

                    // Prepare success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $count . ' ' . $this->CI->lang->line('notifications_system_errors_were_deleted')
                    );

                    // Display the success message
                    echo json_encode($data);

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_please_select_at_least_error')
                    );

                    // Display the error message
                    echo json_encode($data);

                }

                exit();

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_an_error_occured')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    //-----------------------------------------------------
    // General's methods for System Errors Helper
    //-----------------------------------------------------

    /**
     * The protected method delete_system_errors deletes a system error
     * 
     * @param integer $alert_id contains the system error's ID
     * 
     * @since 0.0.8.4
     * 
     * @return array with response
     */
    protected function delete_system_errors($alert_id) {

        // Try to delete the system error
        if ( $this->CI->base_model->delete('notifications_alerts', array('alert_id' => $alert_id, 'alert_type' => 3)) ) {

            // Delete the alert's fields
            $this->CI->base_model->delete('notifications_alerts_fields', array('alert_id' => $alert_id));

            // Delete the alert's filters
            $this->CI->base_model->delete('notifications_alerts_filters', array('alert_id' => $alert_id));            
            
            // Prepare success message
            return array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('members_member_was_deleted')
            );
            
        } else {
            
            // Prepare error message
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('members_member_was_not_deleted')
            );
            
        }

    }

}

/* End of file system_errors.php */