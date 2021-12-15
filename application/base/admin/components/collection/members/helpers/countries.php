<?php
/**
 * Countries Helpers
 *
 * This file contains the class countries
 * with methods to read the countries list
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Countries class provides the methods to read the countries list
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Countries {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get CodeIgniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method members_get_countries gets the countries by search
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function members_get_countries() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $key = $this->CI->input->post('key');
          
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Get the countries list
                $countries = the_members_countries_list();

                // The countries container
                $the_countries = array();

                // List all countries
                foreach ( $countries as $code => $name ) {

                    // Verify if the $name meets the request
                    if ( preg_match("/{$key}/i", $name ) ) {

                        // Set country
                        $the_countries[] = array(
                            'id' => $code,
                            'name' => $name
                        );

                    }

                    // Verify if $the_countries has 10 countries
                    if ( count($the_countries) > 9 ) {
                        break;
                    }

                }

                // Verify if the container is not empty
                if ( $the_countries ) {

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'countries' => $the_countries
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
            'message' => $this->CI->lang->line('members_no_countries_were_found')
        );

        // Display the error message
        echo json_encode($data);

    }

}

/* End of file countries.php */