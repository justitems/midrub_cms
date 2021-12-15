<?php
/**
 * Delete Class
 *
 * This file loads the Delete Class with methods to delete media files from the user's storage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Classes\Media;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Delete class loads the methods to delete media files from the user's storage
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */
class Delete {

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
     * The public method delete_file deletes a file from the user's storage
     * 
     * @param array $params contains the file's data
     * @param boolean $return contains the return option
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function delete_file($params, $return=FALSE) {

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

        // Verify if the media_id exists
        if ( empty($params['media_id']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_media_id_missing')
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
        $user_id = $this->CI->user_id;

        // Verify if user's ID exists
        if ( !empty($params['user_id']) ) {

            // Set new user's ID
            $user_id = $params['user_id'];

        }

        // Set default user's role
        $user_role = $this->CI->user_role;

        // Verify if user's role exists
        if ( !empty($params['role_id']) ) {

            // Set new user's role
            $user_role = $params['role_id'];

        }        

        // Use the base model to get the media
        $media = $this->CI->base_model->the_data_where('medias', '*', array('media_id' => $params['media_id'], 'user_id' => $user_id) );

        // Verify if media file exists
        if ( !$media ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_media_missing')
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

        // Try to delete the file
        if ( $this->CI->base_model->delete('medias', array('media_id' => $params['media_id'], 'user_id' => $user_id) ) ) {

            // Verify if member has user's role
            if ( $user_role < 1 ) {

                // List all user's apps
                foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

                    // Get the directory's name
                    $app = trim(basename($directory) . PHP_EOL);

                    // Create an array
                    $array = array(
                        'CmsBase',
                        'User',
                        'Apps',
                        'Collection',
                        ucfirst($app),
                        'Main'
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Load the hooks
                    (new $cl())->load_hooks('user_init');

                }

            }

            // Delete media's records
            md_run_hook(
                'delete_user_media',
                $params
            );

            // Get file size
            $file_size = $media[0]['size'];
            
            // Get user storage
            $user_storage = md_the_user_option($user_id, 'user_storage');

            // Verify if the $user_storage is higher than 0
            if ( $user_storage ) {
            
                // Get user's storage without deleting file
                $total_storage = (int)$user_storage - (int)$file_size;

                // Verify if $total_storage is not positive
                if ( !$total_storage ) {
                    $total_storage = '0';
                }

                // Set new user's storage
                $user_storage = $total_storage;
                
                // Update the user storage
                md_update_user_option( $user_id, 'user_storage', $total_storage );

            }
            
            // Try to delete the file
            $delete = $location_data[0][$storage_location]['location_delete']($media);

            // Verify if the file was deleted
            if ( !empty($delete['success']) ) {

                // Set storage
                $delete['user_storage'] = md_calculate_size($user_storage);

            }

            // Verify if the data should be returned
            if ( $return ) {

                // Return the data
                return $delete;

            } else {

                // Display the response
                echo json_encode($delete);
                exit();

            }

        }
        
        // Prepare response
        $message = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_file_not_deleted')
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

}

/* End of file delete.php */