<?php
/**
 * Upload Class
 *
 * This file loads the Upload Class with methods to upload media files in the user's storage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Classes\Media;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Media Save Inc file
require_once CMS_BASE_PATH . 'inc/media/save.php';

/*
 * Upload class loads the methods to upload media files in the user's storage
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */
class Upload {

    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get CodeIgniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'medias', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PATH );

        // Verify if the Settings component exists
        if ( defined('CMS_BASE_ADMIN_COMPONENTS_SETTINGS') ) {

            // Load the component's language files
            $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SETTINGS);               

            // Require the Storage Init Hooks Inc file
            require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'inc/storage_init_hooks.php';

        }
        
    }

    /**
     * The public method upload uploads files in the user's storage
     * 
     * @param array $params contains the file's data
     * @param boolean $return contains the return option
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function upload($params, $return=FALSE) {

        // Verify if the cover exists
        if ( empty($params['cover']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_file_cover_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }

        // Set default user's ID
        $user_id = md_the_user_id();

        // Verify if user's ID exists
        if ( !empty($params['user_id']) ) {

            // Set new user's ID
            $user_id = $params['user_id'];

        }

        // Verify if any user's ID exists
        if ( empty($user_id) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_user_id_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if the allowed_extensions parameter exists
        if ( empty($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }
        
        // Verify if the allowed_extensions parameter is array
        if ( !is_array($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if category exists
        if ( empty($params['category']) ) {
            $params['category'] = 0;
        }
                
        // Get user storage
        $params['user_storage'] = md_the_user_option($user_id, 'user_storage');
        
        // Get total storage
        $params['total_storage'] = $_FILES['file']['size'] + ($params['user_storage']?$params['user_storage']:0);

        // Get plan's storage
        $the_storage = $this->CI->base_model->the_data_where(
        'plans_meta',
        'meta_value AS storage',
        array(
            'plan_id' => md_the_user_option($user_id, 'plan'),
            'meta_name' => 'storage'
        ));

        // Prepare plan's storage
        $plan_storage = $the_storage?$the_storage:0;
        
        // Verify if user has enough storage
        if ( $params['total_storage'] >= $plan_storage ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_free_space')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Get upload limit
        $upload_limit = md_the_option('upload_limit');
        
        // Verify for upload limit
        if ( !$upload_limit ) {

            // Set default limit
            $upload_limit = 6291456;

        } else {

            // Set wanted limit
            $upload_limit = $upload_limit * 1048576;

        }
        
        // Verify if the file size has allowed size
        if ( $_FILES['file']['size'] > $upload_limit ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_file_too_large')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the file has supported format
        if ( !in_array($_FILES['file']['type'], $params['allowed_extensions']) ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_supported_format')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Get the storage's location
        $storage_location = md_the_option('storage_location');

        // Get the locations
        $the_locations = the_storage_locations();

        // Verify if storage's locations exists
        if ( !$the_locations ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_locations_were_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the storage's location exists
        if ( !$storage_location ) {        

            // Try to update the option
            if ( md_update_option('storage_location', 'local') ) {

                // Set default storage's location
                $storage_location = 'local';

            }

        }

        // Verify if the storage's location exists
        if ( !$storage_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }         

        }

        // Set where location
        $where = array('location_slug' => $storage_location);

        // Get the location
        $the_location = array_filter(array_map(function($location) use($where){
            
            // Verify if is required location
            if ( $where['location_slug'] === key($location) ) {

                return array(
                    'location_slug' => $location
                );

            }

        }, $the_locations));

        // Verify if the location exists
        if ( !$the_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }

        // Get the location's data
        $location_data = array_column($the_location, 'location_slug');

        // Verify if location's data exists
        if ( empty($location_data[0][$storage_location]) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
        }

        // Verify if the storage's location has the upload option
        if ( empty($location_data[0][$storage_location]['location_upload']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_upload_option')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Try to upload the file
        $upload = $location_data[0][$storage_location]['location_upload']($params);

        // Verify if the file was uploaded
        if ( !empty($upload['success']) ) {

            // Set media's ID
            $params['media_id'] = $upload['media_id'];

            // Set media's cover
            $params['media_cover'] = $upload['media_cover'];

            // Run hook
            md_run_hook('upload_media', $params);
                
            // Extensions list
            $extensions = array(
                '.php',
                '.php3',
                '.php4',
                '.php5',
                '.php7',
                '.phtml',
                '.pht'
            );

            // List all extensions
            foreach ( $extensions as $ext ) {
                $this->delete_files(FCPATH . 'assets/share', $ext);   
            } 

            // Verify if the data should be returned
            if ( $return ) {

                // Return the upload's data
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);

            }

        } else {

            // Verify if the data should be returned
            if ( $return ) {

                // Return the upload's data
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);

            }    

        }

    }

    /**
     * The public method upload_to_admin uploads files in the admin's storage
     * 
     * @param array $params contains the file's data
     * @param boolean $return contains the return option
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function upload_to_admin($params, $return=FALSE) {

        // Verify if the cover exists
        if ( empty($params['cover']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_file_cover_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }

        // Set default user's ID
        $user_id = md_the_user_id();

        // Verify if user's ID exists
        if ( !empty($params['user_id']) ) {

            // Set new user's ID
            $user_id = $params['user_id'];

        }

        // Verify if any user's ID exists
        if ( empty($user_id) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_user_id_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if the allowed_extensions parameter exists
        if ( empty($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }
        
        // Verify if the allowed_extensions parameter is array
        if ( !is_array($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if category exists
        if ( empty($params['category']) ) {
            $params['category'] = 0;
        }
        
        // Get upload limit
        $upload_limit = md_the_option('upload_limit');
        
        // Verify for upload limit
        if ( !$upload_limit ) {

            // Set default limit
            $upload_limit = 6291456;

        } else {

            // Set wanted limit
            $upload_limit = $upload_limit * 1048576;

        }
        
        // Verify if the file size has allowed size
        if ( $_FILES['file']['size'] > $upload_limit ) {
            
            // Prepare response
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_file_too_large')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the file has supported format
        if ( !in_array($_FILES['file']['type'], $params['allowed_extensions']) ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_supported_format')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Get the storage's location
        $storage_location = md_the_option('storage_location');

        // Get the locations
        $the_locations = the_storage_locations();

        // Verify if storage's locations exists
        if ( !$the_locations ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_locations_were_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the storage's location exists
        if ( !$storage_location ) {        

            // Try to update the option
            if ( md_update_option('storage_location', 'local') ) {

                // Set default storage's location
                $storage_location = 'local';

            }

        }

        // Verify if the storage's location exists
        if ( !$storage_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }         

        }

        // Set where location
        $where = array('location_slug' => $storage_location);

        // Get the location
        $the_location = array_filter(array_map(function($location) use($where){
            
            // Verify if is required location
            if ( $where['location_slug'] === key($location) ) {

                return array(
                    'location_slug' => $location
                );

            }

        }, $the_locations));

        // Verify if the location exists
        if ( !$the_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }

        // Get the location's data
        $location_data = array_column($the_location, 'location_slug');

        // Verify if location's data exists
        if ( empty($location_data[0][$storage_location]) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
        }

        // Verify if the storage's location has the upload option
        if ( empty($location_data[0][$storage_location]['location_upload']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_upload_option')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Try to upload the file
        $upload = $location_data[0][$storage_location]['location_upload']($params);

        // Verify if the file was uploaded
        if ( !empty($upload['success']) ) {

            // Set media's ID
            $params['media_id'] = $upload['media_id'];

            // Set media's cover
            $params['media_cover'] = $upload['media_cover'];

            // Run hook
            md_run_hook('upload_media', $params);
                
            // Extensions list
            $extensions = array(
                '.php',
                '.php3',
                '.php4',
                '.php5',
                '.php7',
                '.phtml',
                '.pht'
            );

            // List all extensions
            foreach ( $extensions as $ext ) {
                $this->delete_files(FCPATH . 'assets/share', $ext);   
            } 

            // Verify if the data should be returned
            if ( $return ) {

                // Return the upload's data
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);

            }

        } else {

            // Verify if the data should be returned
            if ( $return ) {

                // Return the upload's data
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);

            }    

        }

    }

    /**
     * The public method delete_files deletes all files by extension
     * 
     * @param string $path contains the dir path
     * @param string $ext the files extension
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_files($path, $ext) {

        // Verify if files exists
        if ( glob($path . '/*' . $ext) ) {
        
            // List all files
            foreach (glob($path . '/*' . $ext) as $filename) {
                unlink($filename);
            }
        
        }

    }

}

/* End of file upload.php */