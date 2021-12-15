<?php
/**
 * Themes Helpers
 *
 * This file contains the class Themes
 * with methods to manage the user's themes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Themes class provides the methods to manage the user's themes
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Themes {
    
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

        // Require the general themes functions
        require_once APPPATH . 'base/inc/themes/user.php';
        
    }

    /**
     * The public method enable enables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function enable() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('theme_slug', 'Theme Slug', 'trim|required');
            
            // Get received data
            $theme_slug = $this->CI->input->post('theme_slug');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if theme exists
                if ( md_the_user_themes() ) {

                    // List all themes
                    foreach (md_the_user_themes() as $theme) {

                        // Verify if theme slug is rqual to $theme_slug
                        if ( $theme['slug'] === $theme_slug ) {

                            // Try to enable the theme
                            if ( md_update_option('themes_enabled_user_theme', $theme['slug']) ) {

                                // Display success message
                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('user_the_theme_was_enabled')
                                );

                                echo json_encode($data);
                                exit();

                            }

                        }

                    }

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_the_theme_was_not_enabled')
        );

        echo json_encode($data);


    }

    /**
     * The public method disable disables a theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function disable() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('theme_slug', 'Theme Slug', 'trim|required');
            
            // Get received data
            $theme_slug = $this->CI->input->post('theme_slug');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if theme exists
                if ( md_the_user_themes() ) {

                    // List all themes
                    foreach (md_the_user_themes() as $theme) {

                        // Verify if theme slug is rqual to $theme_slug
                        if ( $theme['slug'] === $theme_slug ) {

                            // Try to disable the theme
                            if ( md_delete_option('themes_enabled_user_theme') ) {

                                // Display success message
                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('user_the_theme_was_disabled')
                                );

                                echo json_encode($data);
                                exit();

                            }

                        }

                    }

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_the_theme_was_not_disabled')
        );

        echo json_encode($data);


    }
    
    /**
     * The public method upload_theme uploads theme
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function upload_theme() {

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

            // Upload the theme
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
     * The public method unzipping_zip extract the theme
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

                        // Delete the uploaded theme
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

                                        // Set theme's name
                                        $theme_name = dirname($zip->getNameIndex(0));

                                        // Verify if the app is already installed
                                        if ( is_dir(CMS_BASE_PATH . 'user/themes/collection/' . $theme_name) ) {

                                            // Prepare the error message
                                            $data = array(
                                                'success' => FALSE,
                                                'message' => $this->CI->lang->line('user_theme_already_installed')
                                            );

                                            // Display the error message
                                            echo json_encode($data);

                                            // Close the ZipArchive class
                                            $zip->close();                                            
                                            exit();
                                            
                                        } else {

                                            // Extract the zip
                                            $zip->extractTo(CMS_BASE_PATH . 'user/themes/collection/');

                                            // Verify if the app is installed
                                            if ( is_dir(CMS_BASE_PATH . 'user/themes/collection/' . $theme_name) ) {

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
                                                                if ( is_dir(FCPATH . 'assets/base/user/themes/collection/' . $theme_name) ) {

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
                                                                    $zip->extractTo(FCPATH . 'assets/base/user/themes/collection/');

                                                                    // Verify if the assets were installed
                                                                    if ( !is_dir(FCPATH . 'assets/base/user/themes/collection/' . $theme_name) ) {

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
                                                'message' => $this->CI->lang->line('user_the_theme_was_installed')
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
                                'message' => $this->CI->lang->line('user_theme_can_not_be_installed')
                            );

                            // Display the error message
                            echo json_encode($data);
                            exit();
                            
                        }

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('user_theme_can_not_be_installed')
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
        foreach ( $files as $file ) { 
        
            if( is_file($file) ) { 
            
                // Delete the given file 
                unlink($file);  

            }

        } 

    }

}

/* End of file themes.php */