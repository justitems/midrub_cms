<?php
/**
 * Apps Helpers
 *
 * This file contains the class Apps
 * with methods to manage the apps
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Apps class provides the methods to manage install and manage the apps
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
*/
class Apps {
    
    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method upload_app uploads app
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function upload_app() {

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

            // Upload the app
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
     * The public method unzipping_zip extract the app
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

                        // Delete the uploaded app
                        unlink(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip');

                        // Get the installation file
                        $installation = json_decode(file_get_contents(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/installation.json'), true);

                        // Verify if the php file exists
                        if ( isset($installation['php']) ) {

                            // Verify if the php zip file exists
                            if ( file_exists(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['php']) ) {

                                // Call the ZipArchive class
                                $zip = new \ZipArchive;

                                // Try to open the zip
                                if ($zip->open(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['php']) === TRUE) {

                                    // First verify if files exists
                                    if ( $zip->numFiles > 0 ) {

                                        // Verify if the app is already installed
                                        if ( is_dir(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0)) ) {

                                            // Prepare the error message
                                            $data = array(
                                                'success' => FALSE,
                                                'message' => $this->CI->lang->line('user_app_already_installed')
                                            );

                                            // Display the error message
                                            echo json_encode($data);

                                            // Close the ZipArchive class
                                            $zip->close();                                            
                                            exit();
                                            
                                        } else {

                                            // Extract the zip
                                            $zip->extractTo(CMS_BASE_PATH . 'user/apps/collection/');

                                            // Verify if models directory exists
                                            if ( is_dir(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0) . '/models/') ) {

                                                // List all available models
                                                foreach ( glob(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0) . '/models/*.php') as $filename ) {

                                                    // Get the class's name
                                                    $className = str_replace(array(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0) . '/models/', '.php'), '', $filename);

                                                    // Load the model
                                                    $this->CI->load->ext_model(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0) . '/models/', ucfirst($className), $className );

                                                }

                                            }

                                            // Verify if the app is installed
                                            if ( is_dir(CMS_BASE_PATH . 'user/apps/collection/' . $zip->getNameIndex(0)) ) {

                                                // Verify if the assets file exists
                                                if ( isset($installation['assets']) ) {

                                                    // Verify if the assets file exists
                                                    if ( file_exists(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['assets']) ) {

                                                        // Call the ZipArchive class
                                                        $zip = new \ZipArchive;

                                                        // Try to open the zip
                                                        if ($zip->open(CMS_BASE_ADMIN_COMPONENTS_USER . 'temp/' . $installation['assets']) === TRUE) {

                                                            // First verify if files exists
                                                            if ( $zip->numFiles > 0 ) {

                                                                // Verify if the app is already installed
                                                                if ( is_dir(FCPATH . 'assets/base/user/apps/collection/' . $zip->getNameIndex(0)) ) {

                                                                    // Prepare the error message
                                                                    $data = array(
                                                                        'success' => FALSE,
                                                                        'message' => $this->CI->lang->line('user_app_php_installed')
                                                                    );

                                                                    // Display the error message
                                                                    echo json_encode($data);

                                                                    // Close the ZipArchive class
                                                                    $zip->close();                                            
                                                                    exit();
                                                                    
                                                                } else {

                                                                    // Extract the zip
                                                                    $zip->extractTo(FCPATH . 'assets/base/user/apps/collection/');

                                                                    // Verify if the assets were installed
                                                                    if ( !is_dir(FCPATH . 'assets/base/user/apps/collection/' . $zip->getNameIndex(0)) ) {

                                                                        // Prepare the error message
                                                                        $data = array(
                                                                            'success' => FALSE,
                                                                            'message' => $this->CI->lang->line('user_app_php_installed')
                                                                        );

                                                                        // Display the error message
                                                                        echo json_encode($data);

                                                                        // Close the ZipArchive class
                                                                        $zip->close();                                            
                                                                        exit();

                                                                    }

                                                                }

                                                            }

                                                        }

                                                    }

                                                }

                                            }

                                            // Prepare the succes message
                                            $data = array(
                                                'success' => TRUE,
                                                'message' => $this->CI->lang->line('user_the_app_was_installed')
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
                                'message' => $this->CI->lang->line('user_app_can_not_be_installed')
                            );

                            // Display the error message
                            echo json_encode($data);
                            exit();
                            
                        }

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('user_app_can_not_be_installed')
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

/* End of file apps.php */