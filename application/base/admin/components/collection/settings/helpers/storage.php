<?php
/**
 * Storage Helpers
 *
 * This file contains the class Storage
 * with methods to manage the settings's storage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Storage class provides the methods to manage the settings's storage
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
*/
class Storage {
    
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
        
    }
    
    /**
     * The public method settings_get_storage_dropdown_items loads the storage's dropdown items
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function settings_get_storage_dropdown_items() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get received data
            $key = $this->CI->input->post('key');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Get the locations
                $the_locations = the_storage_locations();

                // Verify if the locations exists
                if ( $the_locations ) {
                    
                    // Locations container
                    $locations = array();

                    // List all found locations
                    foreach ( $the_locations as $location ) {

                        // Verify if the location is available
                        if ( !$location[key($location)]['location_enabled']() ) {
                            continue;
                        }

                        // Verify if key exists
                        if ( !empty($key) ) {

                            // Verify if key search exists in the location's name
                            if ( strpos(strtolower($location[key($location)]['location_name']), strtolower(trim($key))) === false ) {
                                continue;
                            }

                        }

                        // Set location
                        $locations[] = array(
                            'location_id' => key($location),
                            'location_name' => $location[key($location)]['location_name']
                        );

                        // Verify if locations is 10
                        if ( count($locations) > 9 ) {
                            continue;
                        }

                    }

                    // Verify if locations were found
                    if ( $locations ) {

                        // Prepare success message
                        $data = array(
                            'success' => TRUE,
                            'locations' => $locations
                        );

                        // Display the success message
                        echo json_encode($data);
                        exit();

                    }

                }

            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_no_data_found_to_show')
        );

        // Display the error response
        echo json_encode($data); 

    }

}

/* End of file storage.php */