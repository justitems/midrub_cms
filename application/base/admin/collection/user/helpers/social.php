<?php
/**
 * Social Helper
 *
 * This file contains the class Social
 * with methods to manage the social's data
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\User\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Social class provides the methods to manage the social's data
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Social {
    
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
     * The public method save_social_data save social's settings
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function save_social_data() {

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
                'message' => $this->CI->lang->line('user_settings_changes_were_saved')
            );

            echo json_encode($data);
            
        } else {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('user_settings_changes_were_not_saved')
            );

            echo json_encode($data);
        }

    }

    /**
     * The public method upload_network uploads network
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function upload_network() {

        // Verify if post data was sent
        if ( $this->CI->input->post() ) {
            
            // Get file type
            $type = $this->CI->security->xss_clean($_FILES['file']['type']);

            // Supported formats
            $check_format = array('application/x-zip-compressed', 'application/zip');  
            
            if ( !in_array($type, $check_format) ) {
                
                // Prepare the error message
                $message = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_error_occurred') . ': ' . $this->CI->lang->line('user_no_supported_format')
                );

                // Display the error message
                echo json_encode($message);
                exit();
                
            }

            // Generate a new file name
            $zip_file = time();

            // Delete all files first
            $this->delete_files();

            // Verify the if the folder temp exists
            if ( !is_dir(MIDRUB_BASE_ADMIN_USER . 'temp') ) {
                mkdir(MIDRUB_BASE_ADMIN_USER . 'temp', 0777);
            }

            // Upload the network
            $config['upload_path'] = MIDRUB_BASE_ADMIN_USER . 'temp';
            $config['file_name'] = $zip_file;
            $config['file_ext_tolower'] = TRUE;
            $this->CI->load->library('upload', $config);
            $this->CI->upload->initialize($config);
            $this->CI->upload->set_allowed_types('*');

            // Upload file 
            if ( $this->CI->upload->do_upload('file') ) {
                
                // Verify if the ZIP file was upoaded
                if ( file_exists($config['upload_path'] . '/' . $zip_file . '.zip') ) {
                    
                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_unzipping'),
                        'file_name' => $zip_file
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();
                    
                }

            }


        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_error_occurred_request')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method unzipping_zip extract the network
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function unzipping_zip() {

        // Verify if file_name exists
        if ( is_numeric($this->CI->input->get('file_name')) ) {

            // Verify if file exists
            if ( file_exists(MIDRUB_BASE_ADMIN_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip') ) {

                // Call the ZipArchive class
                $zip = new \ZipArchive;

                // Try to open the zip
                if ($zip->open(MIDRUB_BASE_ADMIN_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip') === TRUE) {

                    // Extract the zip
                    $zip->extractTo(MIDRUB_BASE_ADMIN_USER . 'temp/');

                    // Close the ZipArchive class
                    $zip->close();

                    // Verify if the installation.json exists
                    if ( file_exists(MIDRUB_BASE_ADMIN_USER . 'temp/installation.json') ) {

                        // Delete the uploaded network
                        unlink(MIDRUB_BASE_ADMIN_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip');

                        // Get the installation file
                        $installation = json_decode(file_get_contents(MIDRUB_BASE_ADMIN_USER . 'temp/installation.json'), true);

                        // Verify if the php file exists
                        if ( isset($installation['php']) && isset($installation['category']) ) {

                            // Verify if this is a network
                            if ( $installation['category'] === 'networks' ) {

                                // Verify if the php zip file exists
                                if ( file_exists(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['php']) ) {

                                    // Call the ZipArchive class
                                    $zip = new \ZipArchive;

                                    // Try to open the zip
                                    if ($zip->open(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['php']) === TRUE) {

                                        // First verify if files exists
                                        if ( $zip->numFiles > 0 ) {

                                            // Verify if the network is already installed
                                            if ( file_exists(MIDRUB_BASE_PATH . 'user/networks/' . $zip->getNameIndex(0)) ) {

                                                // Prepare the error message
                                                $data = array(
                                                    'success' => FALSE,
                                                    'message' => $this->CI->lang->line('user_network_already_installed')
                                                );

                                                // Display the error message
                                                echo json_encode($data);

                                                // Close the ZipArchive class
                                                $zip->close();                                            
                                                exit();
                                                
                                            } else {

                                                // Extract the zip
                                                $zip->extractTo(MIDRUB_BASE_PATH . 'user/networks/');

                                                // Prepare the succes message
                                                $data = array(
                                                    'success' => TRUE,
                                                    'message' => $this->CI->lang->line('user_network_was_installed')
                                                );

                                                // Display the success message
                                                echo json_encode($data);                                    

                                                // Close the ZipArchive class
                                                $zip->close();

                                                exit();

                                            }

                                        }

                                        // Close the ZipArchive class
                                        $zip->close();

                                    }

                                }

                            } else {

                                // Prepare the error message
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('user_network_not_supported')
                                );

                                // Display the error message
                                echo json_encode($data);
                                exit();
                                
                            }

                        } else {

                            // Prepare the error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('user_network_can_not_be_installed')
                            );

                            // Display the error message
                            echo json_encode($data);
                            exit();
                            
                        }

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('user_network_can_not_be_installed')
                        );

                        // Display the error message
                        echo json_encode($data);
                        exit();

                    }

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_error_occurred_request')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method delete_files deletes all files from the temp directory
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function delete_files() {

        // List of name of files inside 
        // specified folder 
        $files = glob(MIDRUB_BASE_ADMIN_USER . 'temp/*');  
        
        // Deleting all the files in the list 
        foreach($files as $file) { 
        
            if( is_file($file) ) { 
            
                // Delete the given file 
                unlink($file);  

            }

        } 

    }

}

/* End of file social.php */