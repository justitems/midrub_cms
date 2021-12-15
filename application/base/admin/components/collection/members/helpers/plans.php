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
namespace CmsBase\Admin\Components\Collection\Members\Helpers;

// Constants
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

    /**
     * The public method members_get_plans gets the plans list
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function members_get_plans() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $key = $this->CI->input->post('key');
          
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Response array
                $response = array();

                // Prepare arguments for request
                $args = array(
                    'start' => 0,
                    'limit' => 10,
                    'key' => $key
                );
                
                // Get plans
                $plans = $this->CI->base_plans->get_plans($args);

                // Verify if plans exists
                if ( $plans ) {

                    // Items array
                    $items = array();

                    // List all plans
                    foreach ( $plans as $plan ) {

                        // Verify if the plan's name meets the request
                        if ( preg_match("/{$key}/i", $plan['plan_name']) ) {

                            // Set item
                            $items[] = array(
                                'id' => $plan['plan_id'],
                                'name' => $plan['plan_name']
                            );

                        }

                        // Only 10
                        if ( count($items) > 9 ) {
                            break;
                        }

                    }

                    // Verify if plans exists
                    if ( $items ) {

                        // Prepare the success message
                        $data = array(
                            'success' => TRUE,
                            'plans' => $items
                        );

                        // Display the success message
                        echo json_encode($data);

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('members_no_plans_found')
                        );

                        // Display the error message
                        echo json_encode($data);     
                        
                    }

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('members_no_plans_found')
                    );

                    // Display the error message
                    echo json_encode($data);                

                }

                exit(); 

            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('members_error_has_occurred')
        );

        // Display the error message
        echo json_encode($data);

    }

}

/* End of file plans.php */