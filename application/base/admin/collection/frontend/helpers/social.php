<?php
/**
 * Social Helper
 *
 * This file contains the class Social
 * with methods to manage the auth social's data
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Frontend\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Social class provides the methods to manage the auth social's data
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Social {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method save_auth_social_data save social's settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function save_auth_social_data() {

        // Count success saving data
        $count = 0;

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_inputs', 'All Inputs', 'trim');
            $this->CI->form_validation->set_rules('all_options', 'All Options', 'trim');

            // Get received data
            $all_inputs = $this->CI->input->post('all_inputs');
            $all_options = $this->CI->input->post('all_options');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if inputs exists
                if ( $all_inputs ) {

                    // Get inputs
                    $inputs = array_values($all_inputs);

                    // List all inputs
                    foreach ( $inputs as $input ) {

                        // Delete existing option
                        if ( delete_option($input[0]) ) {
                            $count++;
                        }

                        // If if value is not null
                        if ( $input[1] ) {

                            // Save option
                            if ( update_option($input[0], trim(html_entity_decode($input[1])) ) ) {
                                $count++;
                            }

                        }

                    }

                }

                // Verify if options exists
                if ( $all_options ) {

                    // Get options
                    $options = array_values($all_options);

                    // List all options
                    foreach ( $options as $option ) {

                        // Delete existing option
                        if ( delete_option($option[0]) ) {
                            $count++;
                        }

                        // If if value is not null
                        if ( $option[1] ) {

                            // Save option
                            if ( update_option($option[0], trim(html_entity_decode($option[1])) ) ) {
                                $count++;
                            }

                        }

                    }

                }

            }

        }

        // Verify if options were deleted or saved
        if ($count) {

            // Display success message
            $data = array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('frontend_settings_changes_were_saved')
            );

            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('frontend_settings_changes_were_not_saved')
            );

            echo json_encode($data);
        }

    }

}

/* End of file social.php */