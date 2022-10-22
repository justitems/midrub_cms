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

                    // Verify if first textarea is smtp protocol
                    if ( $all_textareas[0][0] === 'smtp_protocol' ) {

                        // Smtp configuration
                        $smtp_configuration = array();

                        // Enable smtp
                        $smtp_enabled = 0;

                        // List the textareas
                        foreach( $all_textareas as $option => $value ) {

                            // Verify if the required fields exists
                            if ( empty($value[0]) || !isset($value[1]) ) {
                                continue;
                            }
                            
                            // Add smtp configuration
                            if ( $value[0] === 'smtp_protocol' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }

                                // Verify if the protocol is valid
                                if ( !in_array($value[1], array('smtp', 'sendmail', 'mail')) ) {
                                    continue;
                                }

                                // Add protocol
                                $smtp_configuration['protocol'] = trim($value[1]);

                            } else if ( $value[0] === 'smtp_host' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Set the host
                                $smtp_configuration['smtp_host'] = trim($value[1]);

                            } else if ( $value[0] === 'smtp_port' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Set the port
                                $smtp_configuration['smtp_port'] = trim($value[1]);

                            } else if ( $value[0] === 'smtp_username' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Set the username
                                $smtp_configuration['smtp_user'] = trim($value[1]);

                            } else if ( $value[0] === 'smtp_password' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Set the password
                                $smtp_configuration['smtp_pass'] = trim($value[1]);

                            } else if ( $value[0] === 'smtp_enabled' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Enable smtp
                                $smtp_enabled = 1;

                            } else if ( $value[0] === 'smtp_ssl' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   
                                
                                // Enable ssl
                                $smtp_configuration['smtp_ssl'] = 1;

                            } else if ( $value[0] === 'smtp_tls' ) {

                                // Verify if value exists
                                if ( empty($value[1]) ) {
                                    continue;
                                }   

                                // Verify if ssl is enabled
                                if ( !empty($smtp_configuration['smtp_ssl']) ) {

                                    // Prepare error response
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('settings_smtp_ssl_tls_wrong')
                                    );

                                    // Display the error response
                                    echo json_encode($data); 
                                    exit();  
                                    
                                }
                                
                                // Enable tsl
                                $smtp_configuration['smtp_tls'] = 1;

                            }

                        }

                        // Verify if smtp is enabled
                        if ( $smtp_enabled ) {

                            // Verify if the required fields exists
                            if ( empty($smtp_configuration['protocol']) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('settings_smtp_protocol_wrong_value')
                                );

                                // Display the error response
                                echo json_encode($data); 
                                exit(); 
                                
                            } else if ( empty($smtp_configuration['smtp_host']) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('settings_smtp_host_wrong_value')
                                );

                                // Display the error response
                                echo json_encode($data); 
                                exit();   

                            } else if ( empty($smtp_configuration['smtp_port']) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('settings_smtp_port_wrong_value')
                                );

                                // Display the error response
                                echo json_encode($data); 
                                exit(); 

                            } else if ( !empty($smtp_configuration['smtp_user']) && !empty($smtp_configuration['smtp_pass']) ) {

                                // Set smtpauth
                                $smtp_configuration['smtpauth'] = true;

                            }

                            // Set mailtype
                            $smtp_configuration['mailtype'] = 'html';

                            // Set charset
                            $smtp_configuration['charset'] = 'utf-8'; 
                            
                            // Set priority
                            $smtp_configuration['priority'] = '1';

                            // Set newline
                            $smtp_configuration['newline'] = '\r\n';  
                            
                            // Load Sending Email Class
                            $this->CI->load->library('email', $smtp_configuration);

                            // Set sender
                            $this->CI->email->from($this->CI->config->item('contact_mail'), $this->CI->config->item('site_name'));

                            // Set receiver
                            $this->CI->email->to($this->CI->config->item('notification_mail'));

                            // Set subject
                            $this->CI->email->subject($this->CI->lang->line('settings_subject_for_testing'));

                            // Set message
                            $this->CI->email->message($this->CI->lang->line('settings_you_have_received_email_for_testing'));

                            // Send email
                            if ( !$this->CI->email->send() ) {

                                // Start
                                ob_start();
                                
                                // Debug
                                $this->CI->email->print_debugger();

                                // Get debug
                                $get_debug = ob_get_contents();

                                // Close
                                ob_end_flush();

                                // Verify if errors exists
                                if ( $get_debug ) {
                                    
                                    // Prepare error response
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => strip_tags(preg_split('#\r?\n#', $get_debug, 0)[0])
                                    );

                                    // Display the error response
                                    echo json_encode($data); 
                                    exit();                                 

                                } else {

                                    // Prepare error response
                                    $data = array(
                                        'success' => FALSE,
                                        'message' => $this->CI->lang->line('settings_smtp_configuration_wrong')
                                    );

                                    // Display the error response
                                    echo json_encode($data); 
                                    exit(); 
                                    
                                }

                            }

                        }

                    }        
                
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