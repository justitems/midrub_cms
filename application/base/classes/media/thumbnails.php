<?php
/**
 * Media Thumbnails Class
 *
 * This file loads the Thumbnails class with methods to create media thumbnails
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Media;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Thumbnails class loads the methods to create media thumbnails
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Thumbnails {

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

        // Load language
        $this->CI->lang->load( 'medias', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PATH );
        
    }

    /**
     * The public method image_thumbnail_from_url creates images thumbnails from url
     * 
     * @param string $url contains the image's url
     * 
     * @since 0.0.8.5
     * 
     * @return string with url or boolean
     */
    public function image_thumbnail_from_url($url) {

        // Sanitize the url
        $url = filter_var($url, FILTER_SANITIZE_URL);
        
        // Verify if the url is not valid
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            
            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_url_is_not_valid')
            );
            
        }
        
        // Get the url's information
        $the_url_information = get_headers($url, true);
        
        // Verify if the url's information exists
        if ( empty($the_url_information) ) {
            
            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_url_cannot_be_reached')
            );            
            
        }
        
        // Organize the url information
        $the_url_data = array_change_key_case($the_url_information, CASE_LOWER);

        // Verify if content length is valid
        if ( empty($the_url_data['content-length']) ) {

            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_content_length_parameter_missing')
            );

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

        // Verify if the url is large
        if ( $the_url_data['content-length'][1] > $upload_limit ) {

            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_file_too_large_for_downloadig')
            );
            
        }
        
        // Verify if content type is valid
        if ( empty($the_url_data['content-type']) ) {

            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_content_type_parameter_missing')
            );

        }


        // Verify if content-type is an array
        if ( is_array($the_url_data['content-type']) ) {

            // Prepare content-type
            $content_type = array_intersect($the_url_data['content-type'], array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'));

            // Verify if the cover has supported format
            if ( empty($content_type) ) {

                // Return the error response
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('media_file_format_is_not_supported')
                );
                
            }
            
            // Set the image extension
            $image_ext = str_replace(array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'), array('.jpeg', '.jpg', '.png', '.gif'), $content_type);            

        } else {

            // Verify if the cover has supported format
            if ( !in_array($the_url_data['content-type'], array('image/jpeg', 'image/jpg', 'image/png', 'image/gif')) ) {

                // Return the error response
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('media_file_format_is_not_supported')
                );
                
            }
            
            // Set the image extension
            $image_ext = str_replace(array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'), array('.jpeg', '.jpg', '.png', '.gif'), $the_url_data['content-type']);

        }
        
        try {
            
            // Set thumb path
            $thumb_path = 'assets/share/' . uniqid(time()) . $image_ext;

            // Initiate Imagick
            $thumb = new \Imagick($url);

            // Resize the image
            $thumb->resizeImage(250, 250, \Imagick::FILTER_LANCZOS, 1);

            // Save the thumbnail
            $thumb->writeImage($thumb_path);
            
            // Close session
            $thumb->destroy();

            // Verify image's source exists
            if ( file_exists($thumb_path) ) {

                // Return the success response
                return array(
                    'success' => TRUE,
                    'thumbnail_url' => base_url($thumb_path)
                );                

            } else {

                // Return the error response
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('media_thumbnail_was_not_created')
                );

            }

        } catch (\Throwable $t) {
            
            // Return the error response
            return array(
                'success' => FALSE,
                'message' => $t->getMessage()
            );

        }

    }

}

/* End of file thumbnails.php */