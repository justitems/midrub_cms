<?php
/**
 * Settings Helper
 *
 * This file contains the class Settings
 * with methods to manage the user's settings
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Settings\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class provides the methods to manage the user's settings
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Settings {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method save_user_settings saves user's settings
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function save_user_settings() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_inputs', 'All Inputs', 'trim');
            $this->CI->form_validation->set_rules('all_options', 'All Options', 'trim');
            $this->CI->form_validation->set_rules('selected_options', 'Selected Options', 'trim');

            // Get data
            $all_inputs = $this->CI->input->post('all_inputs');
            $all_options = $this->CI->input->post('all_options');
            $selected_options = $this->CI->input->post('selected_options');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('an_error_occurred')
                );

                echo json_encode($data);

            } else {
                
                $allowed_metas = array(
                    'country',
                    'city',
                    'address',
                    'email_notifications',
                    'notification_tickets',
                    'display_activities',
                    'settings_delete_activities',
                    '24_hour_format',
                    'invoices_by_email',
                    'user_language'
                );

                // Get user settings's pages
                $user_settings_pages = the_user_settings_pages();

                // Vrify if pages exists
                if ( $user_settings_pages ) {

                    // List all pages
                    foreach ( $user_settings_pages as $user_settings_page ) {

                        // Get values
                        $page = array_values($user_settings_page);

                        // Verify if the page as options
                        if ( !empty($page[0]['options']) ) {

                            // List all options
                            foreach ( $page[0]['options'] as $option ) {

                                if ( !isset($allowed_metas[$option['slug']]) ) {

                                    $allowed_metas[] = $option['slug'];

                                }                                

                            }

                        }

                    }

                }
                
                $count = 0;

                if ( $all_inputs ) {
                        
                    foreach( $all_inputs as $input ) {

                        if ( $input[0] === 'email' ) {

                            $email = trim($input[1]);

                            if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {

                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('please_enter_valid_email')
                                );

                                echo json_encode($data);
                                exit();

                            } else {

                                if ( $this->CI->user->check_email( $email, $this->CI->user_id ) ) {

                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('please_enter_valid_email')
                                    );

                                    echo json_encode($data);
                                    exit();

                                } else {

                                    $data = array(
                                        'email' => $email
                                    );

                                    if ( $this->CI->base_model->update_ceil( 'users', array( 'user_id' => $this->CI->user_id ), $data ) ) {

                                        $count++;

                                    }

                                }

                            }

                        } else if ( $input[0] === 'last_name' ) {

                            $data = array(
                                'last_name' => $input[1]
                            );

                            if ( $this->CI->base_model->update_ceil( 'users', array( 'user_id' => $this->CI->user_id ), $data ) ) {

                                $count++;

                            }

                        } else if ( $input[0] === 'first_name' ) {

                            $data = array(
                                'first_name' => $input[1]
                            );

                            if ( $this->CI->base_model->update_ceil( 'users', array( 'user_id' => $this->CI->user_id ), $data ) ) {

                                $count++;

                            }

                        } else if ( in_array( $input[0], $allowed_metas ) ) {

                            if ( update_user_option($this->CI->user_id, $input[0], $input[1]) ) {

                                $count++;

                            }

                        }

                    }
                    
                }
                
                if ( $all_options ) {
                
                    foreach( $all_options as $option ) {

                        if (in_array($option[0], $allowed_metas)) {

                            if ( update_user_option($this->CI->user_id, $option[0], $option[1]) ) {

                                $count++;
                            }

                        }

                    }
                    
                }
                
                if ( $selected_options ) {
                
                    foreach( $selected_options as $selected ) {

                        if (in_array($selected[0], $allowed_metas)) {

                            if ( update_user_option($this->CI->user_id, $selected[0], $selected[1]) ) {

                                $count++;
                            }

                        }

                    } 
                    
                }
                
                if( $count ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('the_changes_were_saved')
                    );

                    echo json_encode($data);                    
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('the_changes_were_not_saved')
                    );

                    echo json_encode($data);                    
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method change_user_password tries to change the user's password
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function change_user_password() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('current_password', 'Current Password', 'trim');
            $this->CI->form_validation->set_rules('new_password', 'New Password', 'trim');
            $this->CI->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim');
            

            // Get data
            $current_password = $this->CI->input->post('current_password');
            $new_password = $this->CI->input->post('new_password');
            $repeat_password = $this->CI->input->post('repeat_password');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('please_fill_all_required_fields')
                );

                echo json_encode($data);

            } else {
                
                // Verify if new password match the repeat password
                if ( $new_password !== $repeat_password ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('password_password')
                    );

                    echo json_encode($data);
                    
                } else if ( $new_password === $current_password ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_password_difference')
                    );

                    echo json_encode($data);                   
                    
                } else if ( ( strlen($new_password) < 6 ) || ( strlen($new_password) > 20 ) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('mm25')
                    );

                    echo json_encode($data);                   
                    
                } else if ( preg_match('/\s/', $new_password) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('mm26')
                    );

                    echo json_encode($data);                
                    
                } else if ( !$this->CI->user->check( $this->CI->session->userdata['username'], $current_password ) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('incorrect_current_password')
                    );

                    echo json_encode($data);                 
                    
                } else {
                    
                    $this->CI->db->where('username', $this->CI->session->userdata['username']);

                    $data = array(
                        'password' => $this->CI->bcrypt->hash_password($new_password)
                    );

                    $this->CI->db->update('users', $data);

                    if ( $this->CI->db->affected_rows() ) {

                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('password_changed')
                        );

                        echo json_encode($data);

                    } else {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('password_not_changed')
                        );

                        echo json_encode($data);                        
                        
                    }
                    
                }
                
            }
            
        }
        
    }

}

/* End of file settings.php */