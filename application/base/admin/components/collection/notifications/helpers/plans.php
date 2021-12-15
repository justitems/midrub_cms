<?php
/**
 * Plans Helper
 *
 * This file contains the class Plans
 * with methods to manage the plans's data
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

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans class provides the methods to manage the plans's data
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
*/
class Plans {
    
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

        // Load Base Plans Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );
        
    }

    //-----------------------------------------------------
    // Ajax's methods for Plans Helper
    //-----------------------------------------------------

    /**
     * The public method notifications_load_all_plans loads plans by page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_all_plans() {
        
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

                // Prepare arguments for request
                $args = array(
                    'start' => ($page * $limit),
                    'limit' => $limit,
                    'key' => $key
                );
                
                // Get plans by page
                $plans = $this->CI->base_plans->get_plans($args);

                // Verify if plans exists
                if ( $plans ) {

                    // Get total plans
                    $total = $this->CI->base_plans->get_plans(array(
                        'key' => $key
                    ));                    

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'plans' => $plans,
                        'total' => $total,
                        'page' => ($page + 1),
                        'words' => array(
                            'of' => $this->CI->lang->line('notifications_of'),
                            'results' => $this->CI->lang->line('notifications_results')
                        )
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
            'message' => $this->CI->lang->line('notifications_no_plans_found')
        );

         // Display the error message
        echo json_encode($data);
        exit();
        
    }

    /**
     * The public method notifications_load_selected_plans loads all selected plans
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_selected_plans() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plans', 'Plans', 'trim');
            $this->CI->form_validation->set_rules('alert', 'Alert', 'trim');
            
            // Get received data
            $plans = $this->CI->input->post('plans');
            $alert = $this->CI->input->post('alert');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if selected plans exists
                if ( $plans ) {

                    // Get selected plans
                    $the_plans = $this->CI->base_model->the_data_where(
                        'plans',
                        '*',
                        array(),
                        array('plan_id', $plans)
                    );

                    // Verify if the plans were found
                    if ( $the_plans ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'plans' => $the_plans
                        );

                        // Display the success response
                        echo json_encode($data);
                        exit();

                    }

                } else {

                    // Get the alert's filters
                    $the_filters = $this->CI->base_model->the_data_where(
                        'notifications_alerts_filters',
                        '*',
                        array('alert_id' => $alert)
                    );
                    
                    // Verify if alert's filters exists
                    if ( $the_filters ) {

                        // Set plans
                        $plans = unserialize($the_filters[0]['filter_value']);

                        // Get selected plans
                        $the_plans = $this->CI->base_model->the_data_where(
                            'plans',
                            '*',
                            array(),
                            array('plan_id', $plans)
                        );

                        // Verify if the plans were found
                        if ( $the_plans ) {

                            // Prepare the success response
                            $data = array(
                                'success' => TRUE,
                                'plans' => $the_plans
                            );

                            // Display the success response
                            echo json_encode($data);
                            exit();

                        }                        

                    }

                }

            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_no_plans_were_selected')
        );

         // Display the error message
        echo json_encode($data);
        exit();
        
    }

    /**
     * The public method notifications_load_users_alert_plans gets users alert's plans
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_users_alert_plans() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alert', 'Alert', 'trim|numeric|integer');
            
            // Get received data
            $alert = $this->CI->input->post('alert');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Get filter plans
                $the_filter_plans = $this->CI->base_model->the_data_where(
                    'notifications_alerts_filters',
                    '*',
                    array(
                        'alert_id' => $alert,
                        'filter_name' => 'plans'
                    )
                );

                // Verify if the filter plans exists
                if ( $the_filter_plans ) {

                    // Get selected plans
                    $the_plans = $this->CI->base_model->the_data_where(
                        'plans',
                        '*',
                        array(),
                        array('plan_id', unserialize($the_filter_plans[0]['filter_value']))
                    );

                    // Verify if the plans were found
                    if ( $the_plans ) {

                        // Prepare the success response
                        $data = array(
                            'success' => TRUE,
                            'plans' => $the_plans
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
            'message' => $this->CI->lang->line('notifications_no_plans_were_selected')
        );

         // Display the error message
        echo json_encode($data);
        exit();
        
    }

}

/* End of file plans.php */