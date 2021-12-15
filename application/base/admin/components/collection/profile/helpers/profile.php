<?php
/**
 * Profile Helpers
 *
 * This file contains the class profile
 * with methods to manage the profile's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Profile\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Profile class provides the methods to manage the profile's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Profile {
    
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

        // Load Base Teams Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_teams', 'base_teams' );

        // Load the bcrypt library
        $this->CI->load->library('bcrypt');
        
    }

    /**
     * The public method profile_update_general_info updates the general profile's data
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_general_info() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('text_inputs', 'Text Inputs', 'trim');
            $this->CI->form_validation->set_rules('dynamic_dropdowns', 'Dynamic Dropdowns', 'trim');
            
            // Get received data
            $text_inputs = $this->CI->input->post('text_inputs');
            $dynamic_dropdowns = $this->CI->input->post('dynamic_dropdowns');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Allowed fields
                $allowed_fields = array(
                    'profile_first_name',
                    'profile_last_name',
                    'profile_email',
                    'state',
                    'city',
                    'postal_code',
                    'street_number',
                    'country'
                );

                // Success counter
                $success_count = 0;

                // Errors counter
                $errors_counter = 0;

                // Verify if text inputs exists
                if ( $text_inputs ) {

                    // Verify if $text_inputs is an array
                    if ( is_array($text_inputs) ) {

                        // List all text inputs
                        foreach ( $text_inputs as $text_input ) {

                            // Verify if the text input has the required parameters
                            if ( !empty($text_input['field']) && !empty($text_input['value']) ) {

                                // Verify if is allowed the text input
                                if ( in_array($text_input['field'], $allowed_fields) ) {

                                    // Verify if the field is an email
                                    if ( $text_input['field'] === 'profile_email' ) {

                                        // Verify if the email is valid
                                        if (filter_var(trim($text_input['value']), FILTER_VALIDATE_EMAIL)) {

                                            // Get member by email
                                            $the_member = $this->CI->base_model->the_data_where('users', 'user_id', array('email' => trim($text_input['value'])));

                                            // Verify if $the_member is not empty
                                            if ( !empty($the_member) ) {

                                                // Verify if user_id is not of the current member
                                                if ( $the_member[0]['user_id'] !== $this->CI->user_id ) {

                                                    // Prepare error message
                                                    $data = array(
                                                        'success' => FALSE,
                                                        'message' => $this->CI->lang->line('profile_the_email_already_in_use')
                                                    );

                                                    // Display the error message
                                                    echo json_encode($data);
                                                    exit();

                                                }

                                            }

                                            // Verify if a team member has this email
                                            if ($this->CI->base_teams->check_member_email(trim($text_input['value']))) {

                                                // Prepare error message
                                                $data = array(
                                                    'success' => FALSE,
                                                    'message' => $this->CI->lang->line('profile_the_email_already_in_use')
                                                );

                                                // Display the error message
                                                echo json_encode($data);
                                                exit();

                                            }

                                            // Try to update the option
                                            if ( md_update_user_option($this->CI->user_id, 'email', trim($text_input['value'])) ) {
                                                $success_count++;
                                            } else if ( md_the_user_option($this->CI->user_id, 'email') === trim($text_input['value']) ) {
                                                $success_count++;
                                            } else {
                                                $errors_counter++;
                                            }                                            

                                        } else {

                                            // Prepare the error message
                                            $data = array(
                                                'success' => FALSE,
                                                'message' => $this->CI->lang->line('profile_please_enter_valid_email')
                                            );

                                            // Display the error message
                                            echo json_encode($data);
                                            exit();

                                        }

                                    } else if ( ($text_input['field'] === 'profile_first_name') || ($text_input['field'] === 'profile_last_name') ) {

                                        // Try to update the option
                                        if ( md_update_user_option($this->CI->user_id, str_replace('profile_', '', trim($text_input['field'])), trim($text_input['value'])) ) {
                                            $success_count++;
                                        } else if ( md_the_user_option($this->CI->user_id, str_replace('profile_', '', trim($text_input['field']))) === trim($text_input['value']) ) {
                                            $success_count++;
                                        } else {
                                            $errors_counter++;
                                        }                                        

                                    } else {

                                        // Try to update the option
                                        if ( md_update_user_option($this->CI->user_id, trim($text_input['field']), trim($text_input['value'])) ) {
                                            $success_count++;
                                        } else if ( md_the_user_option($this->CI->user_id, trim($text_input['field'])) === trim($text_input['value']) ) {
                                            $success_count++;
                                        } else {
                                            $errors_counter++;
                                        }

                                    }
                                    
                                }

                            }

                        }

                    }

                }

                // Verify if dynamic dropdowns exists
                if ( $dynamic_dropdowns ) {

                    // Verify if $dynamic_dropdowns is an array
                    if ( is_array($dynamic_dropdowns) ) {

                        // List all dynamic dropdowns
                        foreach ( $dynamic_dropdowns as $dynamic_dropdown ) {

                            // Verify if the text input has the required parameters
                            if ( !empty($dynamic_dropdown['field']) && !empty($dynamic_dropdown['value']) ) {

                                // Verify if is allowed the text input
                                if ( in_array($dynamic_dropdown['field'], $allowed_fields) ) {

                                    // Try to update the option
                                    if ( md_update_user_option($this->CI->user_id, trim($dynamic_dropdown['field']), trim($dynamic_dropdown['value'])) ) {
                                        $success_count++;
                                    } else if ( md_the_user_option($this->CI->user_id, trim($dynamic_dropdown['field'])) === trim($dynamic_dropdown['value']) ) {
                                        $success_count++;
                                    } else {
                                        $errors_counter++;
                                    }
                                    
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
                        'message' => $this->CI->lang->line('profile_changes_were_saved')
                    );

                    // Display the success message
                    echo json_encode($data);                         

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_changes_were_not_saved')
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
            'message' => $this->CI->lang->line('profile_an_error_occurred')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method profile_update_preferences updates the profile's preferences
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_preferences() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('dropdowns', 'Dropdowns', 'trim');
            
            // Get received data
            $dropdowns = $this->CI->input->post('dropdowns');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Allowed fields
                $allowed_fields = array(
                    'user_language',
                    'user_time_zone',
                    'user_date_format',
                    'user_time_format',
                    'user_hours_format',
                    'user_first_day',
                );

                // Success counter
                $success_count = 0;

                // Errors counter
                $errors_counter = 0;

                // Verify if dynamic dropdowns exists
                if ( $dropdowns ) {

                    // Verify if $dropdowns is an array
                    if ( is_array($dropdowns) ) {

                        // List all dynamic dropdowns
                        foreach ( $dropdowns as $dropdown ) {

                            // Verify if the text input has the required parameters
                            if ( !empty($dropdown['field']) && !empty($dropdown['value']) ) {

                                // Verify if is allowed the text input
                                if ( in_array($dropdown['field'], $allowed_fields) ) {

                                    // Try to update the option
                                    if ( md_update_user_option($this->CI->user_id, trim($dropdown['field']), trim($dropdown['value'])) ) {
                                        $success_count++;
                                    } else if ( md_the_user_option($this->CI->user_id, trim($dropdown['field'])) === trim($dropdown['value']) ) {
                                        $success_count++;
                                    } else {
                                        $errors_counter++;
                                    }
                                    
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
                        'message' => $this->CI->lang->line('profile_changes_were_saved')
                    );

                    // Display the success message
                    echo json_encode($data);                         

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_changes_were_not_saved')
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
            'message' => $this->CI->lang->line('profile_an_error_occurred')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method profile_update_security updates the profile's password
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_update_security() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('password_inputs', 'Password Inputs', 'trim');
            
            // Get received data
            $password_inputs = $this->CI->input->post('password_inputs');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Allowed fields
                $allowed_fields = array(
                    'profile_password',
                    'profile_repeat_password'
                );

                // Success counter
                $success_count = 0;

                // Errors counter
                $errors_counter = 0;

                // Default profile password
                $profile_password = '';

                // Default profile repeat password
                $profile_repeat_password = '';

                // Verify if password inputs exists
                if ( $password_inputs ) {

                    // Verify if $password_inputs is an array
                    if ( is_array($password_inputs) ) {

                        // List all password inputs
                        foreach ( $password_inputs as $password_input ) {

                            // Verify if the password input has the required parameters
                            if ( !empty($password_input['field']) && !empty($password_input['value']) ) {

                                // Verify if is allowed the password input
                                if ( in_array($password_input['field'], $allowed_fields) ) {

                                    // Verify if the field is profile_password
                                    if ( $password_input['field'] === 'profile_password' ) {
                                        
                                        // Set profile password
                                        $profile_password = trim($password_input['value']);

                                    }

                                    // Verify if the field is profile_repeat_password
                                    if ( $password_input['field'] === 'profile_repeat_password' ) {
                                        
                                        // Set profile repeat password
                                        $profile_repeat_password = trim($password_input['value']);

                                    }                                    
                                    
                                }

                            }

                        }

                    }

                }

                // Verify if the password exists
                if ( empty($profile_password) ) {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_password_is_short')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();                   

                }

                // Verify if the password contains less than 6 characters
                if ( strlen($profile_password) < 6 ) {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_password_is_short')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();                   

                }

                // Verify if the password contains more than 20 characters
                if ( strlen($profile_password) > 20 ) {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_password_is_long')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();                   

                }  
                
                // Verify if the password contains white spaces
                if ( preg_match('/\s/', $profile_password) ) {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_password_white_spaces')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();                   

                }                 
                
                // Verify if the password and repeat password match
                if ( $profile_password !== $profile_repeat_password ) {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_password_not_match')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();                   

                }
                
                // Encrypt the password
                $password = $this->CI->bcrypt->hash_password($profile_password);

                // Try to update the password
                if ( $this->CI->base_model->update('users', array('user_id' => $this->CI->user_id), array('password' => $password)) ) {
                    $success_count++;
                } else {
                    $errors_counter++;
                }

                // Verify if the changes were saved
                if ( $success_count && !$errors_counter ) {

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('profile_changes_were_saved')
                    );

                    // Display the success message
                    echo json_encode($data);                         

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('profile_changes_were_not_saved')
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
            'message' => $this->CI->lang->line('profile_an_error_occurred')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method profile_get_countries gets the countries by search
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function profile_get_countries() {

        // Include General Inc
        require_once CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'inc/general.php'; 

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $key = $this->CI->input->post('key');
          
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Get the countries list
                $countries = the_profile_countries_list();

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
            'message' => $this->CI->lang->line('profile_no_countries_were_found')
        );

        // Display the error message
        echo json_encode($data);

    }

}

/* End of file profile.php */