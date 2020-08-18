<?php
/**
 * Midrub Helper
 *
 * This file contains the class Midrub
 * with methods to manage the Midrub's updates
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Update\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Midrub class provides the methods to manage the Midrub's updates
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
*/
class Midrub {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI, $copied = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method verify verifies if the update code is valid
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function verify() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Prepare success response
            $data = array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('update_downloading')
            );

            // Display success response
            echo json_encode($data);
            exit();
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('update_error_occurred')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method download_update downloads the Midrub's update
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function download_update() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Get the update
            $get_update = json_decode(get('https://raw.githubusercontent.com/scrisoft/midrub_cms/master/updates.json'), true);

            // Verify if url exists
            if ( isset($get_update['url']) ) {

                // New Zip name
                $new_zip = 'download.zip';                        

                // If download.zip exists, delete
                if ( file_exists(FCPATH . $new_zip) ) {

                    // Delete
                    unlink(FCPATH . $new_zip);

                }

                // Verify again if the zip was deleted, otherwise error
                if ( file_exists(FCPATH . $new_zip) ) {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('update_zip_not_deleted')
                    );
                    
                    // Display error message
                    echo json_encode($data);
                    exit();

                }

                // Try to download the zip
                file_put_contents($new_zip, fopen($get_update['url'], 'r'));

                // Verify if the zip was dpwloaded
                if ( !file_exists(FCPATH . $new_zip) ) {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('update_update_not_downloaded')
                    );
                    
                    // Display error message
                    echo json_encode($data);
                    exit();

                }
                
                // If the temp directory doesn't exists, create one
                if ( !is_dir('temp') ) {
                
                    // Create
                    if ( !mkdir('temp', 0755, true) ) {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('update_failed_to_create_directory')
                        );
                        
                        // Display error message
                        echo json_encode($data);
                        exit();                                

                    }    
                
                }

                // Prepare success response
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('update_unzipping')
                );

                // Display success response
                echo json_encode($data);
                exit();

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('update_error_occurred')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method extract_update extracts the Midrub's update
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function extract_update() {
        
        // Zip name
        $zip_name = 'download.zip'; 

        // Verify again if the zip exists, otherwise error
        if ( !file_exists(FCPATH . $zip_name) ) {

            // Prepare error message 
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('update_zip_missing')
            );
            
            // Display error message
            echo json_encode($data);
            exit();

        }

        // If the temp directory exists
        if ( !is_dir('temp') ) {
        
            // Prepare error message 
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('update_failed_to_create_directory')
            );
            
            // Display error message
            echo json_encode($data);
            exit();  
        
        }

        // Call the ZipArchive class
        $zip = new \ZipArchive;

        // Try to open the zip
        if ($zip->open(FCPATH . $zip_name) === TRUE) {
            
            // Extract the zip
            $zip->extractTo('temp/');

            // Close the ZipArchive class
            $zip->close();

            // Verify if the update.json exists
            if ( file_exists('temp/update.json') ) {

                // Get files to update
                $update = json_decode(file_get_contents('temp/update.json'), true);

                // Verify if the update has files
                if ( isset($update['files']) ) {

                    // List all files
                    foreach ( $update['files'] as $file ) {

                        // Verify file exists
                        if ( !file_exists(FCPATH . 'temp/' . $file) ) {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('update_update_stoped')
                            );
                            
                            // Display error message
                            echo json_encode($data);
                            exit();

                        }

                    }

                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('update_backup_creating')
                    );

                    // Display success response
                    echo json_encode($data); 

                } else {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('update_update_json_wrong')
                    );
                    
                    // Display error message
                    echo json_encode($data);
                    
                }

            } else {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('update_update_json_missing')
                );
                
                // Display error message
                echo json_encode($data);
                
            }
        
        } else {

            // Prepare error message 
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('update_extract_zip_failed')
            );
            
            // Display error message
            echo json_encode($data);

        }
        
    }

    /**
     * The public method start_backup starts backup creation
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function start_backup() {

        // If the backup directory exists, delete
        if ( is_dir('backup') ) {

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator('backup', \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ( $files as $fileinfo ) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }

            unset($files);

            rmdir('backup');

        }

        // If the backup directory doesn't exists, create one
        if ( !is_dir('backup') ) {

            // Create
            if ( !mkdir('backup', 0755, true) ) {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('update_failed_to_create_backup_directory')
                );

                // Display error message
                echo json_encode($data);
                exit();

            }

        } else {

            // Prepare error message 
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('update_failed_to_delete_backup_directory')
            );

            // Display error message
            echo json_encode($data);
            exit();
            
        }

            // Verify if the update.json exists
            if ( file_exists('temp/update.json') ) {

                // Get files to update
                $update = json_decode(file_get_contents('temp/update.json'), true);

                // Verify if the update has files
                if ( isset($update['files']) ) {

                    // Set the main directory
                    $dir = FCPATH . 'temp';

                    // List all files
                    foreach ( $update['files'] as $file ) {

                        // Add path
                        $file = str_replace($dir, '', $file);

                        // Backup url
                        $cfile = 'backup/' . $file;

                        // Get dirname
                        $route = dirname($file);

                        // Get path
                        $explode = explode('/', $route . '/');

                        // Check if the file is new or old
                        if ( file_exists($file) ) {

                            // Verify if directory exists
                            if ( count($explode) > 1)  {

                                // Backup directory
                                $folder_route = 'backup/';

                                // Create directory
                                $this->create_directories($explode, $folder_route, $route);
								
                            }

                            // Verify if the file was copied
                            if ( !copy($file, $cfile) ) {

                                // Abort the update and restore files
                                $this->restore_backup();

                            }

                            // If will be found an error, will be restore all files
                            $this->copied[] = $cfile;
                        }

                        // First will be created the directories if not exists
                        $this->create_directories($explode, "", $route);

                        // Then will be copied the file
                        if ( !copy($dir . '/' . $file, $file) ) {

                            // Abort the update and restore files
                            $this->restore_backup();

                        }

                    }

                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('update_midrub_was_updated')
                    );

                    // Display success response
                    echo json_encode($data); 

                    // Delete the update record
                    $this->CI->base_model->delete('updates', array('slug' => 'midrub'));

                    // Verify if old update.json exists
                    if ( file_exists('update.json') ) {

                        // Delete the existing update.json
                        unlink('update.json');

                    }

                    // Copy the update.json in the main directory
                    copy('temp/update.json', 'update.json');

                    // Create the update.json in the backup directory
                    file_put_contents('backup/backup.json', json_encode(array(
                        'files' => $this->copied
                    ), JSON_PRETTY_PRINT));

                    // Verify if old download.zip exists
                    if ( file_exists(FCPATH . 'download.zip') ) {

                        // Delete the existing download.zip
                        unlink(FCPATH . 'download.zip');

                    }                    

                    // Delete the temp directory
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator('temp', \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::CHILD_FIRST
                    );
                    
                    foreach ( $files as $fileinfo ) {
                        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                        $todo($fileinfo->getRealPath());
                    }
        
                    unset($files);
        
                    rmdir('temp');

                } else {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('update_update_json_wrong')
                    );
                    
                    // Display error message
                    echo json_encode($data);
                    
                }

            } else {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('update_update_json_missing')
                );
                
                // Display error message
                echo json_encode($data);
                
            }
        
    }

    /**
     * The public method restore_backup restores the backup
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    public function restore_backup() {

        // This variable all files that not were restored
        $not_restored = array();        
        
        // Check if files were saved in the array $this->copied
        if ( $this->copied ) {

            // next restore them
            foreach ($this->copied as $file) {

                // Check if the $file was backuped
                if ( $file ) {

                    // restore it
                    if ( !copy($file, str_replace('backup/', '', $file)) ) {

                        $not_restored[] = $file;

                    }

                }

            }

            // Verify if all files was restored
            if ( !$not_restored ) {
                
                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('update_all_files_were_restored')
                );
                
                // Display error message
                echo json_encode($data);
                exit();
                
            }

        } else if ( file_exists('backup/backup.json') ) {

            // Get last version
            $get_last = json_decode(file_get_contents('backup/backup.json'), TRUE);

            // Verify if version exists
            if ( isset($get_last['files']) ) {

                // Errors counter
                $error_check = 0;

                // List all files
                foreach ( $get_last['files'] as $file ) {

                    // Verify if the file exists
                    if ( file_exists($file) ) {

                        // Get file
                        $cfile = str_replace('backup/', '', $file);

                        // Try to copy
                        if ( !copy($file, $cfile) ) {

                            $error_check++;
                            
                        }

                    } else {

                        $error_check++;
                    }

                }

                // Verify if the backup was restored
                if ($error_check == 0) {

                    // Prepare success message 
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('update_backup_was_restored')
                    );
                    
                    // Display success message
                    echo json_encode($data);
                    
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator('backup', \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::CHILD_FIRST
                    );
                    foreach ( $files as $fileinfo ) {
                        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                        $todo($fileinfo->getRealPath());
                    }
        
                    unset($files);
        
                    rmdir('backup');

                    // Verify if old update.json exists
                    if ( file_exists('update.json') ) {

                        // Delete the existing update.json
                        unlink('update.json');

                    }

                    exit();

                }

            }
            
        }

        // Some of files were not been restored
        if ( $not_restored ) {

            // Prepare error message 
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('update_some_files_were_not_restored')
            );
            
            // Display error message
            echo json_encode($data);            

        }

    }

    /**
     * The protected method create_directories creates the missing directories
     * 
     * @param string $explode contains the clean directory path
     * @param string $folder_route contains option the backup directory's path
     * @param string $path contains the real path
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    protected function create_directories($explode, $folder_route = NULL, $route) {

        // Verify if the folder exists
        if ( !is_dir($folder_route . $route) ) {

            // Creates all directies if not exists
            foreach ($explode as $dir) {

                // Get folder path
                $folder_route = ($folder_route != NULL) ? $folder_route . "/" . $dir : $dir;

                // Verify if path is valid
                if ( strlen($folder_route) > 0)  {

                    // Create the directory
                    $this->create_dir($folder_route);

                }

            }

        }

    }

    /**
     * The protected method create_directories creates the missing directories
     * 
     * @param string $dir contains the real path
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */ 
    protected function create_dir($dir) {

        // Check if directory already exists
        if (!is_dir($dir)) {

            // Create directory
            if (!mkdir($dir, 0755)) {

                // Abort the update and restore files
                $this->restore_backup();

            }

        }

    }

}

/* End of file midrub.php */