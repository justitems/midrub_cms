<?php
/**
 * Components Helper
 *
 * This file contains the class Components
 * with methods to manage the components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\User\Helpers;

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Components class provides the methods to manage the components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Components
{

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
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();

    }

    /**
     * The public method settings_components_and_apps_list list all components and apps
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function settings_components_and_apps_list() {

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

                // Apps array
                $apps = array();

                // List all user's apps
                foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

                    // Get the directory's name
                    $app = trim(basename($directory) . PHP_EOL);

                    // Verify if the app is enabled
                    if ( !get_option('app_' .  $app. '_enable') ) {
                        continue;
                    }

                    // Create an array
                    $array = array(
                        'MidrubBase',
                        'User',
                        'Apps',
                        'Collection',
                        ucfirst($app),
                        'Main'
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Get app's info
                    $info = (new $cl())->app_info();

                    if ( preg_match("/{$key}/i", $info['app_name']) ) {

                        // Add info to app
                        $apps[] = array(
                            'name' => $info['app_name'],
                            'slug' => $info['app_slug']
                        );

                    }

                    // Max number 10
                    if ( count($apps) > 9 ) {
                        break;
                    }

                }

                // List all user's components
                foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

                    // Get the directory's name
                    $component = trim(basename($directory) . PHP_EOL);

                    // Verify if the component is enabled
                    if ( !get_option('component_' . $component . '_enable') ) {
                        continue;
                    }

                    // Create an array
                    $array = array(
                        'MidrubBase',
                        'User',
                        'Components',
                        'Collection',
                        ucfirst($component),
                        'Main'
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Get component's info
                    $info = (new $cl())->component_info();

                    if ( preg_match("/{$key}/i", $info['component_name']) ) {

                        // Add info to component
                        $apps[] = array(
                            'name' => $info['component_name'],
                            'slug' => $info['component_slug']
                        );

                    }

                    // Max number 10
                    if ( count($apps) > 9 ) {
                        break;
                    }

                }

                // Verify if apps exists
                if ( $apps ) {

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'drop_class' => $drop_class,
                        'apps' => $apps
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
     * The public method load_selected_components loads the list with selected components and apps
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_selected_components() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('component_slugs', 'Component Slugs', 'trim');

            // Get received data
            $component_slugs = $this->CI->input->post('component_slugs');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Verify if component slugs exists
                if ( $component_slugs ) {

                    // All components
                    $components = array();

                    // List all user's apps
                    foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

                        // Get the directory's name
                        $app = trim(basename($directory) . PHP_EOL);

                        // Create an array
                        $array = array(
                            'MidrubBase',
                            'User',
                            'Apps',
                            'Collection',
                            ucfirst($app),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\', $array);

                        // Get app's info
                        $info = (new $cl())->app_info();

                        // Verify if app's slug is in the list
                        if ( in_array($info['app_slug'], $component_slugs) ) {

                            // Add info to list
                            $components[] = array(
                                'name' => $info['app_name'],
                                'slug' => $info['app_slug']
                            );

                        }

                    }

                    // List all user's components
                    foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

                        // Get the directory's name
                        $component = trim(basename($directory) . PHP_EOL);

                        // Create an array
                        $array = array(
                            'MidrubBase',
                            'User',
                            'Components',
                            'Collection',
                            ucfirst($component),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\', $array);

                        // Get component's info
                        $info = (new $cl())->component_info();

                        // Verify if component's slug is in the list
                        if (in_array($info['component_slug'], $component_slugs)) {

                            // Add info to list
                            $components[] = array(
                                'name' => $info['component_name'],
                                'slug' => $info['component_slug']
                            );

                        }

                    }

                    if ( $components ) {

                        $data = array(
                            'success' => TRUE,
                            'components' => $components
                        );

                        echo json_encode($data);
                    }
                    
                }

            }

        }

    }

    /**
     * The public method upload_component uploads component
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function upload_component() {

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

            // Upload the component
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
            'message' => $this->CI->lang->line('update_error_occurred_request')
        );

        // Display the error message
        echo json_encode($data);

    }

    /**
     * The public method unzipping_zip extract the component
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */ 
    public function unzipping_zip() {

        // Verify if file_name exists
        if ( is_numeric($this->CI->input->get('file_name', TRUE)) ) {

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

                        // Delete the uploaded component
                        unlink(MIDRUB_BASE_ADMIN_USER . 'temp/' . $this->CI->input->get('file_name') . '.zip');

                        // Get the installation file
                        $installation = json_decode(file_get_contents(MIDRUB_BASE_ADMIN_USER . 'temp/installation.json'), true);

                        // Verify if the php file exists
                        if ( isset($installation['php']) && isset($installation['category']) ) {

                            // Verify if this is a user's component
                            if ( $installation['category'] === 'user_component' ) {

                                // Verify if the php zip file exists
                                if ( file_exists(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['php']) ) {

                                    // Call the ZipArchive class
                                    $zip = new \ZipArchive;

                                    // Try to open the zip
                                    if ($zip->open(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['php']) === TRUE) {

                                        // First verify if files exists
                                        if ( $zip->numFiles > 0 ) {

                                            // Verify if the app is already installed
                                            if ( is_dir(MIDRUB_BASE_PATH . 'user/components/collection/' . $zip->getNameIndex(0)) ) {

                                                // Prepare the error message
                                                $data = array(
                                                    'success' => FALSE,
                                                    'message' => $this->CI->lang->line('user_component_already_installed')
                                                );

                                                // Display the error message
                                                echo json_encode($data);

                                                // Close the ZipArchive class
                                                $zip->close();                                            
                                                exit();
                                                
                                            } else {

                                                // Extract the zip
                                                $zip->extractTo(MIDRUB_BASE_PATH . 'user/components/collection/');

                                                // Verify if the app is installed
                                                if ( is_dir(MIDRUB_BASE_PATH . 'user/components/collection/' . $zip->getNameIndex(0)) ) {

                                                    // Verify if the assets file exists
                                                    if ( isset($installation['assets']) ) {

                                                        // Verify if the assets file exists
                                                        if ( file_exists(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['assets']) ) {

                                                            // Call the ZipArchive class
                                                            $zip = new \ZipArchive;

                                                            // Try to open the zip
                                                            if ($zip->open(MIDRUB_BASE_ADMIN_USER . 'temp/' . $installation['assets']) === TRUE) {

                                                                // First verify if files exists
                                                                if ( $zip->numFiles > 0 ) {

                                                                    // Verify if the app is already installed
                                                                    if ( is_dir(FCPATH . 'assets/base/user/components/collection/' . $zip->getNameIndex(0)) ) {

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
                                                                        $zip->extractTo(FCPATH . 'assets/base/user/components/collection/');

                                                                        // Verify if the assets were installed
                                                                        if ( !is_dir(FCPATH . 'assets/base/user/components/collection/' . $zip->getNameIndex(0)) ) {

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
                                                    'message' => $this->CI->lang->line('user_the_component_was_installed')
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

                            }  else {

                                // Prepare the error message
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('user_component_not_supported')
                                );

                                // Display the error message
                                echo json_encode($data);
                                exit();
                                
                            }

                        } else {

                            // Prepare the error message
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('user_component_can_not_be_installed')
                            );

                            // Display the error message
                            echo json_encode($data);
                            exit();
                            
                        }

                    } else {

                        // Prepare the error message
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('user_component_can_not_be_installed')
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
        foreach ( $files as $file ) { 
        
            if( is_file($file) ) { 
            
                // Delete the given file 
                unlink($file);  

            }

        } 

    }

}

/* End of file components.php */
