<?php
/**
 * Media Helpers
 *
 * This file contains the class Media
 * with methods to manage the media files in the Frontend component 
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Media as CmsBaseClassesMedia;

/*
 * Media class provides the methods to manage the frontend's image
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Media {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get CodeIgniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method frontend_upload_content_media uploads a media file
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function frontend_upload_content_media() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Verify if the file was uploaded
            if ( empty($_FILES['files']) ) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('frontend_an_error_occurred')
                );

                // Display the error response
                echo json_encode($data);
                exit();                    

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

            // Get user storage
            $user_storage = md_the_user_option($this->CI->user_id, 'user_storage');

            // Temporary storage
            $temp_storage = ($user_storage?$user_storage:0);

            // Verify if the uploaded file is an image
            if ( !in_array($_FILES['files']['type'][0], array('video/mp4', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif')) ) {

                // Set cover
                $cover = file_get_contents($_FILES['files']['tmp_name'][0]);                    

            } else {

                // Set default cover
                $cover = file_get_contents(base_url('assets/img/no-image.png'));

            }

            // Set file's data
            $_FILES['file']['name'] = $_FILES['files']['name'][0];
            $_FILES['file']['type'] = $_FILES['files']['type'][0];
            $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][0];
            $_FILES['file']['error'] = $_FILES['files']['error'][0];
            $_FILES['file']['size'] = $_FILES['files']['size'][0];

            // Upload media
            $response = (new CmsBaseClassesMedia\Upload)->upload_to_admin(array(
                'cover' => $cover,
                'allowed_extensions' => array('video/mp4', 'image/png', 'image/jpg', 'image/jpeg', 'image/gif')
            ), true);

            // Verify if the file was uploaded
            if ( !empty($response['success']) ) {

                // Get file type
                $get_type = explode('/', $_FILES['file']['type']);

                // Get the file url
                $file_url = $this->CI->base_model->the_data_where(
                'medias',
                '*',
                array(
                    'media_id' => $response['media_id']
                ));

                // Prepare response
                $message = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('frontend_file_uploaded_successfully'),
                    'file_url' => $file_url?$file_url[0]['body']:base_url('assets/img/no-image.png')                    
                );

                // Display the response
                echo json_encode($message);

            } else {

                // Display error
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => !empty($response['message'])?$response['message']:$this->CI->lang->line('frontend_file_not_uploaded')
                ));

            }

            exit();

        }
        
        // Prepare response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_file_not_uploaded')
        );

        // Prepare response
        echo json_encode($data);
        
    }

}

/* End of file media.php */