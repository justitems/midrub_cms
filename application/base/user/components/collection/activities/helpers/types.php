<?php
/**
 * Types Helper
 *
 * This file contains the class Types
 * with methods to manage the types
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Activities\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Types class provides the methods to manage the types
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
*/
class Types {
    
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

    }

    /**
     * The public method load_activities_types loads activities types
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function load_activities_types() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get data
            $key = $this->CI->input->post('key', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Get types
                $get_types = $this->CI->base_model->get_data_where('activities', 'DISTINCT(template)',
                array('user_id' => $this->CI->user_id),
                array(),
                array('template' => $this->CI->db->escape_like_str($key)));

                // Verify if types exists
                if ( $get_types ) {
                        
                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'types' => $get_types
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
            'message' => $this->CI->lang->line( 'activities_no_members_found' )
        );

        // Display the error message
        echo json_encode($data);   
        
    }

}

/* End of file types.php */