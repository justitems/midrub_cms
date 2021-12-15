<?php
/**
 * Frontend Themes Helper
 *
 * This file contains the class Frontend_themes
 * with methods to manage the Frontend Themes updates
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Updates\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Frontend_themes class provides the methods to manage the Frontend Themes updates
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
*/
class Frontend_themes {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI, $copied = array(), $theme_dir;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method verify verifies if the updates code is valid
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function verify() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('code', 'Code', 'trim');
            $this->CI->form_validation->set_rules('slug', 'Slug', 'trim');
            
            // Get received data
            $code = $this->CI->input->post('code');
            $slug = $this->CI->input->post('slug');
           
            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('updates_error_occurred')
                );

                // Display error message
                echo json_encode($data);                
                exit();

            } else {

                // Verify if theme exists
                if ( is_dir(APPPATH . 'base/frontend/themes/' . $slug) ) {

                    // Set theme's dir
                    $this->theme_dir = APPPATH . 'base/frontend/themes/' . $slug;

                    // Get theme's configuration
                    $info = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/' . $slug . '/config.json'), TRUE);

                    // theme array
                    $theme = array();

                    // Updates code
                    $updates_code = '';

                    // Verify if updates's code is required
                    if (  !empty($info['updates_code']) ) {

                        // Set updates's code requirements
                        $theme['updates_code'] = $info['updates_code'];

                    } else {

                        // Set updates's code requirements
                        $theme['updates_code'] = false;
                    }

                    // Verify if code exists
                    if ( !empty($theme['updates_code']) && !$code ) {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_code_missing')
                        );

                        // Display error message
                        echo json_encode($data);                
                        exit();
                        
                    } else if ( !empty($theme['updates_code']) && $code ) {

                        // Set updates code
                        $updates_code = '?l=' . $code;

                    }

                    // Verify if updates's url exists
                    if (  !empty($info['updates_url']) ) {

                        // Set updates url
                        $theme['updates_url'] = $info['updates_url'];

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_url_missing')
                        );

                        // Display error message
                        echo json_encode($data);                
                        exit();                        

                    }

                    // Get the updates
                    $get_updates = json_decode(get($theme['updates_url'] . $updates_code), true);

                    // Verify if url exists
                    if ( isset($get_updates['url']) ) {

                        // Prepare success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('updates_downloading'),
                            'code' => $code,
                            'slug' => $slug
                        );

                        // Display success response
                        echo json_encode($data);    

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_code_wrong')
                        );
                        
                        // Display error message
                        echo json_encode($data);

                    }

                    exit();

                } else {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('updates_theme_can_not_be_updatesd')
                    );

                    // Display error message
                    echo json_encode($data);                
                    exit();

                }
                
            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('updates_error_occurred')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method download_updates downloads the Midrub's updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function download_updates() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('code', 'Code', 'trim');
            $this->CI->form_validation->set_rules('slug', 'Slug', 'trim');
            
            // Get received data
            $code = $this->CI->input->post('code');
            $slug = $this->CI->input->post('slug');
           
            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('updates_error_occurred')
                );

                // Display error message
                echo json_encode($data);                
                exit();

            } else {

                // Verify if theme exists
                if ( is_dir(APPPATH . 'base/frontend/themes/' . $slug) ) {

                    // Set theme's dir
                    $this->theme_dir = APPPATH . 'base/frontend/themes/' . $slug;

                    // Get theme's configuration
                    $info = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/' . $slug . '/config.json'), TRUE);

                    // theme array
                    $theme = array();

                    // Updates code
                    $updates_code = '';

                    // Verify if updates's code is required
                    if (  !empty($info['updates_code']) ) {

                        // Set updates's code requirements
                        $theme['updates_code'] = $info['updates_code'];

                    } else {

                        // Set updates's code requirements
                        $theme['updates_code'] = false;
                    }

                    if ( !empty($theme['updates_code']) && !$code ) {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_code_missing')
                        );

                        // Display error message
                        echo json_encode($data);                
                        exit();
                        
                    } else if ( !empty($theme['updates_code']) && $code ) {

                        // Set updates code
                        $updates_code = '?l=' . $code;

                    }

                    // Verify if updates's url exists
                    if (  isset($info['updates_url']) ) {

                        // Set updates url
                        $theme['updates_url'] = $info['updates_url'];

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_url_missing')
                        );

                        // Display error message
                        echo json_encode($data);                
                        exit();                        

                    }

                    // Get the updates
                    $get_updates = json_decode(get($theme['updates_url'] . $updates_code), true);

                    // Verify if url exists
                    if ( isset($get_updates['url']) ) {

                        // New Zip name
                        $new_zip = $this->theme_dir . '/download.zip';                        

                        // If download.zip exists, delete
                        if ( file_exists($new_zip) ) {

                            // Delete
                            unlink($new_zip);

                        }

                        // Verify again if the zip was deleted, otherwise error
                        if ( file_exists($new_zip) ) {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('updates_zip_not_deleted')
                            );
                            
                            // Display error message
                            echo json_encode($data);
                            exit();

                        }

                        // Try to download the zip
                        file_put_contents($new_zip, fopen($get_updates['url'], 'r'));

                        // Verify if the zip was dpwloaded
                        if ( !file_exists($new_zip) ) {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('updates_updates_not_downloaded')
                            );
                            
                            // Display error message
                            echo json_encode($data);
                            exit();

                        }

                        // If the temp directory doesn't exists, create one
                        if ( !is_dir($this->theme_dir . '/temp') ) {

                            // Create
                            if ( !mkdir($this->theme_dir . '/temp', 0755, true) ) {

                                // Prepare error message 
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('updates_failed_to_create_directory')
                                );
                                
                                // Display error message
                                echo json_encode($data);
                                exit();                                

                            }    

                        }

                        // Prepare success response
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('updates_unzipping'),
                            'slug' => $slug
                        );

                        // Display success response
                        echo json_encode($data);

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_code_wrong')
                        );
                        
                        // Display error message
                        echo json_encode($data);

                    }

                    exit();

                } else {

                    // Prepare error message 
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('updates_theme_can_not_be_updatesd')
                    );

                    // Display error message
                    echo json_encode($data);                
                    exit();

                }
                
            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('updates_error_occurred')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method extract_updates extracts the Midrub's updates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function extract_updates() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('slug', 'Slug', 'trim');
            
            // Get received data
            $slug = $this->CI->input->post('slug');
           
            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('updates_error_occurred')
                );

                // Display error message
                echo json_encode($data);                
                exit();

            } else {

                // Verify if theme exists
                if ( is_dir(APPPATH . 'base/frontend/themes/' . $slug) ) {

                    // Set theme's dir
                    $this->theme_dir = APPPATH . 'base/frontend/themes/' . $slug;
        
                    // Zip name
                    $zip_name = $this->theme_dir . '/download.zip'; 

                    // Verify again if the zip exists, otherwise error
                    if ( !file_exists($zip_name) ) {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_zip_missing')
                        );
                        
                        // Display error message
                        echo json_encode($data);
                        exit();

                    }

                    // If the temp directory exists
                    if ( !is_dir($this->theme_dir . '/temp') ) {
                    
                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_failed_to_create_directory')
                        );
                        
                        // Display error message
                        echo json_encode($data);
                        exit();  
                    
                    }

                    // Call the ZipArchive class
                    $zip = new \ZipArchive;

                    // Try to open the zip
                    if ( $zip->open($zip_name) === TRUE ) {
                        
                        // Extract the zip
                        $zip->extractTo($this->theme_dir . '/temp/');

                        // Close the ZipArchive class
                        $zip->close();

                        // Verify if the updates.json exists
                        if ( file_exists($this->theme_dir . '/temp/updates.json') ) {

                            // Get files to updates
                            $updates = json_decode(file_get_contents($this->theme_dir . '/temp/updates.json'), true);

                            // Verify if the updates has files
                            if ( isset($updates['files']) ) {

                                // List all files
                                foreach ( $updates['files'] as $file ) {

                                    // Verify file exists
                                    if ( !file_exists($this->theme_dir . '/temp/' . $file) ) {

                                        // Prepare error message 
                                        $data = array(
                                            'success' => FALSE,
                                            'message' => $this->CI->lang->line('updates_updates_stoped')
                                        );
                                        
                                        // Display error message
                                        echo json_encode($data);
                                        exit();

                                    }

                                }

                                // Prepare success response
                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('updates_backup_creating'),
                                    'slug' => $slug
                                );

                                // Display success response
                                echo json_encode($data); 

                            } else {

                                // Prepare error message 
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('updates_updates_json_wrong')
                                );
                                
                                // Display error message
                                echo json_encode($data);
                                
                            }

                        } else {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('updates_updates_json_missing')
                            );
                            
                            // Display error message
                            echo json_encode($data);
                            
                        }
                    
                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_extract_zip_failed')
                        );
                        
                        // Display error message
                        echo json_encode($data);

                    }

                }

            }

        }   

    }

    /**
     * The public method start_backup starts backup creation
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function start_backup() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('slug', 'Slug', 'trim');
            
            // Get received data
            $slug = $this->CI->input->post('slug');
           
            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('updates_error_occurred')
                );

                // Display error message
                echo json_encode($data);                
                exit();

            } else {

                // Verify if theme exists
                if ( is_dir(APPPATH . 'base/frontend/themes/' . $slug) ) {

                    // Set theme's dir
                    $this->theme_dir = APPPATH . 'base/frontend/themes/' . $slug;

                    // If the backup directory exists, delete
                    if ( is_dir($this->theme_dir . '/backup') ) {

                        $files = new \RecursiveIteratorIterator(
                            new \RecursiveDirectoryIterator($this->theme_dir . '/backup', \RecursiveDirectoryIterator::SKIP_DOTS),
                            \RecursiveIteratorIterator::CHILD_FIRST
                        );
                        foreach ( $files as $fileinfo ) {
                            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                            $todo($fileinfo->getRealPath());
                        }

                        unset($files);

                        rmdir($this->theme_dir . '/backup');

                    }

                    // If the backup directory doesn't exists, create one
                    if ( !is_dir($this->theme_dir . '/backup') ) {

                        // Create
                        if ( !mkdir($this->theme_dir . '/backup', 0755, true) ) {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('updates_failed_to_create_backup_directory')
                            );

                            // Display error message
                            echo json_encode($data);
                            exit();

                        }

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_failed_to_delete_backup_directory')
                        );

                        // Display error message
                        echo json_encode($data);
                        exit();
                        
                    }

                    // Verify if the updates.json exists
                    if ( file_exists($this->theme_dir . '/temp/updates.json') ) {

                        // Get files to updates
                        $updates = json_decode(file_get_contents($this->theme_dir . '/temp/updates.json'), true);

                        // Verify if the updates has files
                        if ( isset($updates['files']) ) {

                            // Set the main directory
                            $dir = $this->theme_dir . '/temp';

                            // List all files
                            foreach ( $updates['files'] as $file ) {

                                // Add path
                                $file = str_replace($dir, '', $file);

                                // Backup url
                                $cfile = $this->theme_dir . '/backup/' . $file;

                                // Get dirname
                                $route = dirname($file);

                                // Get path
                                $explode = explode('/', $route . '/');

                                // Check if the file is new or old
                                if ( file_exists($file) ) {

                                    // Verify if directory exists
                                    if ( count($explode) > 1)  {

                                        // Backup directory
                                        $folder_route = $this->theme_dir . '/backup/';

                                        // Create directory
                                        $this->create_directories($explode, $folder_route, $route);
                                        
                                    }

                                    // Verify if the file was copied
                                    if ( !copy($file, $cfile) ) {

                                        // Abort the updates and restore files
                                        $this->restore_backup($this->theme_dir);

                                    }

                                    // If will be found an error, will be restore all files
                                    $this->copied[] = $cfile;
                                }

                                // First will be created the directories if not exists
                                $this->create_directories($explode, "", $route);

                                // Then will be copied the file
                                if ( !copy($dir . '/' . $file, FCPATH . $file) ) {

                                    // Abort the updates and restore files
                                    $this->restore_backup($this->theme_dir);

                                }

                            }

                            // Prepare success response
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('updates_theme_was_updatesd')
                            );

                            // Display success response
                            echo json_encode($data);

                            // Verify if old updates.json exists
                            if ( file_exists($this->theme_dir . '/updates.json') ) {

                                // Delete the existing updates.json
                                unlink($this->theme_dir . '/updates.json');

                            }

                            // Copy the updates.json in the main directory
                            copy($this->theme_dir . '/temp/updates.json', $this->theme_dir . '/updates.json');

                            // Create the updates.json in the backup directory
                            file_put_contents($this->theme_dir . '/backup/backup.json', json_encode(array(
                                'files' => $this->copied
                            ), JSON_PRETTY_PRINT));

                            // Verify if old download.zip exists
                            if ( file_exists($this->theme_dir . '/download.zip') ) {

                                // Delete the existing download.zip
                                unlink($this->theme_dir . '/download.zip');

                            }                    

                            // Delete the temp directory
                            $files = new \RecursiveIteratorIterator(
                                new \RecursiveDirectoryIterator($this->theme_dir . '/temp', \RecursiveDirectoryIterator::SKIP_DOTS),
                                \RecursiveIteratorIterator::CHILD_FIRST
                            );
                            
                            foreach ( $files as $fileinfo ) {
                                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                                $todo($fileinfo->getRealPath());
                            }
                
                            unset($files);
                
                            rmdir($this->theme_dir . '/temp');

                            // Delete the updates record
                            $this->CI->base_model->delete('updates', array('slug' => $slug));

                        } else {

                            // Prepare error message 
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('updates_updates_json_wrong')
                            );
                            
                            // Display error message
                            echo json_encode($data);
                            
                        }

                    } else {

                        // Prepare error message 
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('updates_updates_json_missing')
                        );
                        
                        // Display error message
                        echo json_encode($data);
                        
                    }

                }

            }

        }
        
    }

    /**
     * The public method restore_backup restores the backup
     * 
     * @param string $theme_dir contains the theme's path 
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    public function restore_backup($theme_dir) {

        // This variable all files that not were restored
        $not_restored = array();        
        
        // Check if files were saved in the array $this->copied
        if ( $this->copied ) {

            // next restore them
            foreach ($this->copied as $file) {

                // Check if the $file was backuped
                if ( $file ) {

                    // restore it
                    if ( !copy($file, str_replace($theme_dir . '/backup/', '', $file)) ) {

                        $not_restored[] = $file;

                    }

                }

            }

            // Verify if all files was restored
            if ( !$not_restored ) {
                
                // Prepare error message 
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('updates_all_files_were_restored')
                );
                
                // Display error message
                echo json_encode($data);
                exit();
                
            }

        } else if ( file_exists($theme_dir . '/backup/backup.json') ) {

            // Get last version
            $get_last = json_decode(file_get_contents($theme_dir . '/backup/backup.json'), TRUE);

            // Verify if version exists
            if ( isset($get_last['files']) ) {

                // Errors counter
                $error_check = 0;

                // List all files
                foreach ( $get_last['files'] as $file ) {

                    // Verify if the file exists
                    if ( file_exists($file) ) {

                        // Get file
                        $cfile = str_replace($theme_dir . '/backup/', '', $file);

                        // Try to copy
                        if ( !copy($file, FCPATH . $cfile) ) {

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
                        'message' => $this->CI->lang->line('updates_backup_was_restored')
                    );
                    
                    // Display success message
                    echo json_encode($data);
                    
                    $files = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($theme_dir . '/backup', \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::CHILD_FIRST
                    );
                    foreach ( $files as $fileinfo ) {
                        $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                        $todo($fileinfo->getRealPath());
                    }
        
                    unset($files);
        
                    rmdir($theme_dir . '/backup');

                    // Verify if old updates.json exists
                    if ( file_exists($theme_dir . '/updates.json') ) {

                        // Delete the existing updates.json
                        unlink($theme_dir . '/updates.json');

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
                'message' => $this->CI->lang->line('updates_some_files_were_not_restored')
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
     * @since 0.0.8.3
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
     * @since 0.0.8.3
     * 
     * @return void
     */ 
    protected function create_dir($dir) {

        // Check if directory already exists
        if (!is_dir($dir)) {

            // Create directory
            if (!mkdir($dir, 0755)) {

                // Abort the updates and restore files
                $this->restore_backup($this->theme_dir);

            }

        }

    }

}

/* End of file frontend_themes.php */