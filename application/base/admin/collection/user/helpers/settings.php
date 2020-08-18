<?php
/**
 * Settings Helpers
 *
 * This file contains the class Settings
 * with methods to manage the user's settings
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\User\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class provides the methods to manage the user's settings
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
     * The public method settings_auth_pages_list list all auth's pages
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function settings_auth_pages_list() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('drop_class', 'Dropdown Class', 'trim');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get received data
            $drop_class = $this->CI->input->post('drop_class');
            $key = $this->CI->input->post('key');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Prepare arguments for request
                $args = array(
                    'start' => 0,
                    'limit' => 10,
                    'key' => $key
                );

                // Get all contents
                $pages = $this->CI->base_contents->get_contents($args);

                // Verify if auth's pages exists
                if ($pages) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'drop_class' => $drop_class,
                        'pages' => $pages
                    );

                    echo json_encode($data);
                    exit();
                    
                }

            }

            // Display error message
            $data = array(
                'success' => FALSE,
                'drop_class' => $drop_class,
                'message' => $this->CI->lang->line('user_no_data_found_to_show')
            );

            echo json_encode($data); 

        }

    }

    /**
     * The public method save_user_settings saves user settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function save_user_settings() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_dropdowns', 'All Dropdowns', 'trim');

            // Get data
            $all_dropdowns = $this->CI->input->post('all_dropdowns');
            $all_textareas = $this->CI->input->post('all_textareas');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                $count = 0;
                
                // Verify if dropdowns exists
                if ( $all_dropdowns ) {
                
                    // List all dropdowns
                    foreach( $all_dropdowns as $dropdown ) {

                        // Try to delete existing contents meta
                        $this->CI->base_model->delete('contents_meta', array('meta_name' => 'selected_page_role', 'meta_value' => $dropdown[0]));

                        // Try to save contents meta
                        if (md_update_contents_meta($dropdown[1], 'selected_page_role', $dropdown[0])) {

                            // Verify if role is home page
                            if ($dropdown[0] === 'settings_home_page') {
                                update_option('settings_home_page', trim($dropdown[1]) );
                            }

                            $count++;

                        }
                        
                    }
                
                }

                // Verify if textareas exists
                if ( $all_textareas ) {
                
                    // List all textareas
                    foreach( $all_textareas as $option => $value ) {

                        // Delete existing option
                        if ( delete_option($value[0]) ) {
                            $count++;
                        }

                        // If if value is not null
                        if ( $value[1] ) {

                            // Save option
                            if ( update_option($value[0], trim(html_entity_decode($value[1])) ) ) {
                                $count++;
                            }

                        }
                        
                    }
                
                }

                if ( $count ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_settings_changes_were_saved')
                    );

                    echo json_encode($data); 
                    exit();
                    
                }

            }

        }

        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_settings_changes_were_not_saved')
        );

        echo json_encode($data);  

    } 
    
    /**
     * The public method settings_all_options gets all selected options
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function settings_all_options() {

        // Prepare response
        $response = array();

        // Get selected pages
        $selected_pages_role = $this->CI->base_contents->get_contents_by_meta_name('selected_page_role');

        // Verify if selected pages exists
        if ( $selected_pages_role ) {
            $response['pages_by_role'] = $selected_pages_role;
        }

        $data = array(
            'success' => TRUE,
            'response' => $response
        );

        echo json_encode($data);  

    } 

}

/* End of file settings.php */