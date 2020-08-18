<?php
/**
 * Ajax Controller
 *
 * This file processes the app's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Activities\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Activities\Helpers as MidrubBaseUserComponentsCollectionActivitiesHelpers;

/*
 * Ajaz class processes the app's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Ajax {
    
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

        // Load language
        $this->CI->lang->load( 'activities_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_ACTIVITIES );
        
    }

    /**
     * The public method activities_load_activities loads available activities
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function activities_load_activities() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('member_id', 'Member ID', 'trim');
            $this->CI->form_validation->set_rules('type', 'Type', 'trim');
            $this->CI->form_validation->set_rules('order', 'Order', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim');

            // Get data
            $member_id = $this->CI->input->post('member_id', TRUE);
            $type = $this->CI->input->post('type', TRUE);
            $order = $this->CI->input->post('order', TRUE);
            $page = $this->CI->input->post('page', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Verify if page is not false
                if ( !is_numeric($page) ) {
                    $page = 1;
                }
                
                // Set limit
                $limit = 10;
                
                // Decrease page
                $page--;

                // Where parameters
                $where = array(
                    'user_id' => $this->CI->user_id
                );

                // Verify if type exists
                if ( $type ) {

                    // Set type
                    $where['template'] = $type;

                }

                // Verify if member's ID exists
                if ( is_numeric($member_id) ) {

                    // Set member's ID
                    $where['member_id'] = $member_id;

                }

                // Default order
                $order_params = array('activity_id', 'desc');

                // Verify if $order is 1
                if ( $order ) {

                    // Set new order
                    $order = array('template', 'asc');

                }

                // Get all activities
                $get_activities = $this->CI->base_model->get_data_where(
                    'activities',
                    '*',
                    $where,
                    array(),
                    array(),
                    array(),
                    array(
                        'order' => $order_params,
                        'start' => ($page * $limit),
                        'limit' => $limit
                    )
                );
                
                // Verify if activities exists
                if ( $get_activities ) {
                    
                    // All activities array
                    $all_activities = array();

                    // List all activities
                    foreach ( $get_activities as $get_activity ) {
                        
                        // Verify if the app exists
                        if ( file_exists( MIDRUB_BASE_USER . 'apps/collection/' . $get_activity['app'] . '/activities/' . $get_activity['template'] . '.php' ) ) {
                    
                            try {

                                // Create an array
                                $array = array(
                                    'MidrubBase',
                                    'User',
                                    'Apps',
                                    'Collection',
                                    ucfirst($get_activity['app']),
                                    'activities',
                                    ucfirst($get_activity['template'])
                                );       
                
                                // Implode the array above
                                $cl = implode('\\',$array);
                                
                                // Instantiate the class
                                $response = (new $cl())->template( $get_activity['user_id'], $get_activity['member_id'], $get_activity['id'], $get_activity['activity_id'] );
                                
                                $response['time'] = $get_activity['created'];
                                
                                $all_activities[] = $response;
                                
                            } catch (Exception $ex) {
                                
                                continue;
                                
                            }

                        } else {

                            continue;

                        }
                        
                    }

                    // Verify if activities exists
                    if ( $all_activities ) {

                        // Get total activities
                        $get_total = $this->CI->base_model->get_data_where(
                            'activities',
                            'COUNT(activity_id) AS total',
                            $where
                        );

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'activities' => $all_activities,
                            'date' => time(),
                            'total' => $get_total[0]['total'],
                            'page' => $page
                        );

                        // Display the success response
                        echo json_encode($data);
                        exit();

                    }
                    
                }

            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('no_activities_found')
        );

        // Display the error response
        echo json_encode($data);       

    }

    /**
     * The public method load_team_members loads team's members
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function load_team_members() {

        // Loads the team's members
        (new MidrubBaseUserComponentsCollectionActivitiesHelpers\Team)->load_team_members();
        
    }

    /**
     * The public method load_activities_types loads activities types
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function load_activities_types() {

        // Loads the activities types
        (new MidrubBaseUserComponentsCollectionActivitiesHelpers\Types)->load_activities_types();
        
    }
    
}

/* End of file ajax.php */