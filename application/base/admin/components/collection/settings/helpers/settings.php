<?php
/**
 * Settings Helpers
 *
 * This file contains the class Settings
 * with methods to manage the admin's settings
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class provides the methods to manage the admin's settings
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Settings {
    
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
     * The public method settings_save_admin_settings saves the admin's settings
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function settings_save_admin_settings() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_dropdowns', 'All Dropdowns', 'trim');
            $this->CI->form_validation->set_rules('all_textareas', 'All Textareas', 'trim');

            // Get data
            $all_dropdowns = $this->CI->input->post('all_dropdowns', TRUE);
            $all_textareas = $this->CI->input->post('all_textareas', false);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Counter
                $count = 0;
                
                // Verify if dropdowns exists
                if ( $all_dropdowns ) {
                
                    // List all dropdowns
                    foreach( $all_dropdowns as $dropdown ) {

                        // Verify if the required fields exists
                        if ( !isset($dropdown[0]) || !isset($dropdown[1]) ) {
                            continue;
                        }

                        // Delete existing option
                        if ( md_delete_option($dropdown[0]) ) {
                            $count++;
                        }

                        // If if value is not null
                        if ( $dropdown[1] ) {

                            // Save option
                            if ( md_update_option($dropdown[0], trim(html_entity_decode($dropdown[1])) ) ) {
                                $count++;
                            }

                        }
                        
                    }
                
                }

                // Verify if textareas exists
                if ( $all_textareas ) {
                
                    // List all textareas
                    foreach( $all_textareas as $option => $value ) {

                        // Verify if the required fields exists
                        if ( !isset($value[0]) || !isset($value[1]) ) {
                            continue;
                        }

                        // Delete existing option
                        if ( md_delete_option($value[0]) ) {
                            $count++;
                        }

                        // If if value is not null
                        if ( $value[1] ) {

                            // Save option
                            if ( md_update_option($value[0], trim(html_entity_decode($value[1])) ) ) {
                                $count++;
                            }

                        }
                        
                    }
                
                }
                
                // Verify if the data was updated
                if ( $count ) {
                    
                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('settings_changes_were_saved')
                    );

                    // Display the success response
                    echo json_encode($data); 
                    exit();
                    
                }
                
            }
            
        }
        
        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_changes_were_not_saved')
        );

        // Display the error response
        echo json_encode($data);  
        
    }

}

/* End of file settings.php */