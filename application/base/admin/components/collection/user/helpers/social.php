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
namespace CmsBase\Admin\Components\Collection\User\Helpers;

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
     * The public method user_save_social_data saves social configuration data
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_save_social_data() {

        // Count success saving data
        $count = 0;

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_dropdowns', 'All Dropdowns', 'trim');
            $this->CI->form_validation->set_rules('all_textareas', 'All Textareas', 'trim');

            // Get received data
            $all_dropdowns = $this->CI->input->post('all_dropdowns', TRUE);
            $all_textareas = $this->CI->input->post('all_textareas', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if dropdowns exists
                if ( $all_dropdowns ) {

                    // List all dropdowns
                    foreach( $all_dropdowns as $dropdown ) {

                        if ( empty($dropdown[0]) ) {
                            continue;
                        }

                        // Save option
                        if ( md_update_option($dropdown[0], trim(strip_tags($dropdown[1])) ) ) {
                            $count++;
                        }

                    }

                }

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
            if ( !is_dir(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp') ) {
                mkdir(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp', 0777);
            }

            // Upload the network
            $config['upload_path'] = CMS_BASE_ADMIN_COMPONENTS_USER . 'temp';
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
            if ( file_exists(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip') ) {

                // Call the ZipArchive class
                $zip = new \ZipArchive;

                // Try to open the zip
                if ($zip->open(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip') === TRUE) {

                    // Extract the zip
                    $zip->extractTo(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/');

                    // Close the ZipArchive class
                    $zip->close();

                    // Verify if the installation.json exists
                    if ( file_exists(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/installation.json') ) {

                        // Delete the uploaded network
                        unlink(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip');

                        // Get the installation file
                        $installation = json_decode(file_get_contents(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/installation.json'), true);

                        // Verify if the php file exists
                        if ( isset($installation['php']) && isset($installation['category']) ) {

                            // Verify if this is a network
                            if ( $installation['category'] === 'networks' ) {

                                // Verify if the php zip file exists
                                if ( file_exists(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['php']) ) {

                                    // Call the ZipArchive class
                                    $zip = new \ZipArchive;

                                    // Try to open the zip
                                    if ($zip->open(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['php']) === TRUE) {

                                        // Set network dir
                                        $network_dir = basename($zip->getNameIndex(0));

                                        // First verify if files exists
                                        if ( $zip->numFiles > 0 ) {

                                            // Verify if the network is already installed
                                            if ( file_exists(CMS_BASE_PATH . 'user/networks/' . $network_dir) ) {

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
                                                $zip->extractTo(CMS_BASE_PATH . 'user/networks/collection/');

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
        $files = glob(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/*');  
        
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