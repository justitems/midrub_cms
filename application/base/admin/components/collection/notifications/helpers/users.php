<?php
/**
 * Users
 *
 * This file contains the class Users
 * with methods to shows the alerts users
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Notifications\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Users class provides the methods to shows the alerts users
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
*/
class Users {
    
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

        // Load the component's language files
        $this->CI->lang->load( 'notifications', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );
        
    }

    //-----------------------------------------------------
    // Ajax's methods for Users Helper
    //-----------------------------------------------------

    /**
     * The public method notifications_load_all_alert_users loads alert's users by page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_all_alert_users() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alert', 'Alert', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            
            // Get received data
            $alert = $this->CI->input->post('alert');
            $page = is_numeric($this->CI->input->post('page'))?($this->CI->input->post('page') - 1):0;
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;

                // Get the alert's users
                $alert_users = $this->CI->base_model->the_data_where(
                'notifications_alerts_users',
                'notifications_alerts_users.banner_seen, notifications_alerts_users.page_seen, notifications_alerts_users.created, users.*',
                array(
                    'notifications_alerts_users.alert_id' => $alert
                ),
                array(),
                array(),
                array(
                    array(
                        'table' => 'users',
                        'condition' => 'notifications_alerts_users.user_id=users.user_id',
                        'join_from' => 'LEFT'
                    )
                ),
                array(
                    'order_by' => array('notifications_alerts_users.alert_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if the alert has users
                if ( $alert_users ) {

                    // Get total number of users alerts with base model
                    $total = $this->CI->base_model->the_data_where(
                    'notifications_alerts_users',
                    'COUNT(alert_id) AS total',
                    array(
                        'notifications_alerts_users.alert_id' => $alert
                    ));

                    // Members container
                    $members = array();

                    // List members
                    foreach ( $alert_users as $get_member ) {

                        // Set member
                        $members[] = array(
                            'user_id' => $get_member['user_id'],
                            'username' => $get_member['username'],
                            'email' => $get_member['email'],
                            'last_name' => $get_member['last_name'],
                            'first_name' => $get_member['first_name'],
                            'role' => $get_member['role'],
                            'status' => $get_member['status'],
                            'time_joined' => strtotime($get_member['date_joined']),
                            'avatar' => '//www.gravatar.com/avatar/' . md5($get_member['email']),
                            'banner_seen' => $get_member['banner_seen'],
                            'page_seen' => $get_member['page_seen'],
                            'created' => $get_member['created']
                        );

                    }

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'users' => $members,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'current_time' => time(),
                        'words' => array(
                            'banner_seen' => $this->CI->lang->line('notifications_banner_seen'),
                            'banner_unseen' => $this->CI->lang->line('notifications_banner_unseen'),
                            'page_seen' => $this->CI->lang->line('notifications_page_seen'),
                            'page_unseen' => $this->CI->lang->line('notifications_page_unseen'),
                            'inactive' => $this->CI->lang->line('notifications_inactive'),
                            'active' => $this->CI->lang->line('notifications_active'),
                            'blocked' => $this->CI->lang->line('notifications_blocked')                  
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
            'message' => $this->CI->lang->line('notifications_no_users_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

}

/* End of file users.php */