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
namespace CmsBase\Admin\Components\Collection\User\Helpers;

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
     * The public method user_save_user_settings saves user settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function user_save_user_settings() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_textareas', 'All Textareas', 'trim');

            // Get data
            $all_textareas = $this->CI->input->post('all_textareas', false);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Counter
                $count = 0;

                // Verify if textareas exists
                if ( $all_textareas ) {
                
                    // List all textareas
                    foreach( $all_textareas as $text ) {

                        if ( empty($text[0]) ) {
                            continue;
                        }

                        // Save option
                        if ( md_update_option($text[0], trim(html_entity_decode($text[1])) ) ) {
                            $count++;
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
     * The public method user_update_settings update the user's settings
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_update_settings() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('checkbox_inputs', 'Checkbox Inputs', 'trim');
            $this->CI->form_validation->set_rules('text_inputs', 'Text Inputs', 'trim');
            
            // Get received data
            $checkbox_inputs = $this->CI->input->post('checkbox_inputs');
            $text_inputs = $this->CI->input->post('text_inputs');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Success counter
                $success_count = 0;

                // Errors counter
                $errors_counter = 0;

                // Verify if checkbox inputs exists
                if ( $checkbox_inputs ) {

                    // Verify if $checkbox_inputs is an array
                    if ( is_array($checkbox_inputs) ) {

                        // List all checkbox inputs
                        foreach ( $checkbox_inputs as $checkbox_input ) {

                            // Verify if the checkbox input has the required parameters
                            if ( !empty($checkbox_input['field']) && isset($checkbox_input['value']) ) {

                                // Try to update the option
                                if ( md_update_option(trim($checkbox_input['field']), trim($checkbox_input['value'])) ) {
                                    $success_count++;
                                } else if ( md_the_option(trim($checkbox_input['field'])) === trim($checkbox_input['value']) ) {
                                    $success_count++;
                                } else {
                                    $errors_counter++;
                                }

                            }

                        }

                    }

                }

                // Verify if text inputs exists
                if ( $text_inputs ) {

                    // Verify if $text_inputs is an array
                    if ( is_array($text_inputs) ) {

                        // List all text inputs
                        foreach ( $text_inputs as $text_input ) {

                            // Verify if the text input has the required parameters
                            if ( !empty($text_input['field']) && isset($text_input['value']) ) {

                                // Try to update the option
                                if ( md_update_option(trim($text_input['field']), trim($text_input['value'])) ) {
                                    $success_count++;
                                } else if ( md_the_option(trim($text_input['field'])) === trim($text_input['value']) ) {
                                    $success_count++;
                                } else {
                                    $errors_counter++;
                                }

                            }

                        }

                    }

                }

                // Verify if the changes were saved
                if ( $success_count && !$errors_counter ) {

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_settings_changes_were_saved')
                    );

                    // Display the success message
                    echo json_encode($data);
                    exit();                         

                }

            }

            // Prepare the error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('user_settings_changes_were_not_saved')
            );

            // Display the error message
            echo json_encode($data); 

        }

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
                $pages = $this->CI->base_contents->the_contents($args);

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
        $selected_pages_role = $this->CI->base_contents->the_contents_by_meta_name('selected_page_role');

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