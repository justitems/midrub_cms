<?php
/**
 * Storage Init Hooks Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions which
 * are runned when the Settings component loads
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Settings\Classes as CmsBaseAdminComponentsCollectionSettingsClasses;

if ( !function_exists('the_storage_locations') ) {
    
    /**
     * The function the_storage_locations gets the storage locations
     * 
     * @since 0.0.8.4
     * 
     * @return array with storage locations or boolean false
     */
    function the_storage_locations() {
        
        // Call the storage_locations class
        $storage_locations = (new CmsBaseAdminComponentsCollectionSettingsClasses\Storage_locations);

        // Return storage locations
        return $storage_locations->the_locations();
        
    }
    
}

// Register a storage's location
set_storage_location (
    'local',
    array(
        'location_name' => get_instance()->lang->line('settings_local'),
        'location_icon' => '<i class="material-icons-outlined">'
            . 'other_houses'
        . '</i>',
        'location_enabled' => function () {
            return true;
        },
        'location_upload' => function ($params) {

            // Get CodeIgniter object instance
            $CI =& get_instance();

            // Set default user's ID
            $user_id = $CI->user_id;

            // Verify if user's ID exists
            if ( !empty($params['user_id']) ) {

                // Set new user's ID
                $user_id = $params['user_id'];

            }

            // Generate a new file name
            $file_name = uniqid() . '-' . time();

            // Set the location for upload
            $config['upload_path'] = 'assets/share';

            // Set file's name
            $config['file_name'] = $file_name;

            // Set upload's configuration
            $CI->load->library('upload', $config);

            // Initialise the configuration
            $CI->upload->initialize($config);

            // Allow all formats
            $CI->upload->set_allowed_types('*');

            // Set upload
            $data['upload_data'] = '';

            // Upload file 
            if ( $CI->upload->do_upload('file') ) {

                // Get uploaded file
                $data['upload_data'] = $CI->upload->data();
                
                // Set read permission
                chmod(FCPATH . 'assets/share/' . $data['upload_data']['file_name'], 0644); 
                
                // Save the cover on the server
                $filename_path = $file_name . '-cover.png';
                
                // Open the file
                $fop = fopen( FCPATH . 'assets/share/' . $filename_path, 'wb' );
                
                // Decode the cover output
                $decode_data = explode( ',', str_replace( '[removed]', 'data:image/png;base64,', $params['cover']) );
                
                // Save cover
                fwrite( $fop, base64_decode( $decode_data[ 1 ] ) );
                
                // Close the opened file
                fclose( $fop );

                // Verify if user's storage exists
                if ( !empty($params['total_storage']) ) {

                    // Update the user storage
                    md_update_user_option( $user_id, 'user_storage', $params['total_storage'] );

                }
                
                // Verify if the file exists
                if ( file_exists(FCPATH . 'assets/share/' . $filename_path) ) {
                    
                    // Set read permission
                    chmod(FCPATH . 'assets/share/' . $filename_path, 0644); 

                    // Set cover
                    $cover = $CI->config->base_url() . 'assets/share/' . $filename_path;
                    
                }

                // Get file type
                $get_type = explode('/', $_FILES['file']['type']);

                // Save media in the database
                $last_id = md_save_media(
                    array(
                        'user_id' => $user_id,
                        'name' => $_FILES['file']['name'],
                        'body' => $CI->config->base_url() . 'assets/share/' . $data['upload_data']['file_name'],
                        'cover' => $cover,
                        'size' => $_FILES['file']['size'],
                        'type' => $get_type[0]
                    )
                );
                
                // Last id
                if ( $last_id ) {

                    // Prepare success response
                    $response = array(
                        'success' => TRUE,
                        'media_id' => $last_id,
                        'media_cover' => $cover,
                        'message' => $CI->lang->line('media_file_uploaded_successfully')
                    );

                    // Verify if user's storage exists
                    if ( !empty($params['total_storage']) ) {

                        // Set the user storage
                        $response['user_storage'] = md_calculate_size($params['total_storage']);

                    }                    
                    
                    // Return success response
                    return $response;                        
                    
                }

            }
            
            // Return error response
            return array(
                'success' => FALSE,
                'message' => $CI->lang->line('media_an_error_has_occurred') . ': ' . $CI->lang->line('media_file_not_uploaded')
            );
            
        },
        'location_delete' => function ($media) {

            // Get CodeIgniter object instance
            $CI =& get_instance();

            // Get file path
            $filename = str_replace(base_url(), FCPATH, $media[0]['body']);

            // Verify if the file is on the server
            if ( file_exists($filename) ) {
                            
                try {
                    
                    // Get file data
                    $info = new \SplFileInfo( $filename );                    

                    // Delete file 
                    @unlink($filename);
                    
                    // Delete cover
                    @unlink( str_replace('.' . $info->getExtension(), '-cover.png', $filename) );
                    
                    // Verify if the file was deleted
                    if ( !file_exists($filename) ) {
                    
                        // Prepare response
                        return array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('media_file_was_deleted')
                        );
                        
                    } else {
                        
                        // Prepare response
                        return array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('media_file_was_deleted')
                        );
                        
                    }

                } catch ( \Exception $e ) {
                    
                    // Prepare response
                    return array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('media_an_error_has_occurred') . ': ' . $e->getMessage()
                    );

                }

            } else {

                // Prepare response
                return array(
                    'success' => TRUE,
                    'message' => $CI->lang->line('media_file_was_deleted')
                );

            }

        }

    )

);

/* End of file storage_init_hooks.php */