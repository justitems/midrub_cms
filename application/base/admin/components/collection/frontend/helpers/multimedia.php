<?php
/**
 * Multimedia Helper
 *
 * This file contains the class Multimedia
 * with methods to manage the admin's multimedia
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Multimedia class provides the methods to manage the admin's multimedia
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Multimedia {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Base Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_model', 'base_model');

        // Load Media Model
        $this->CI->load->model('medias');
        
    }
    
    /**
     * The public method load_multimedia loads multimedia by page
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_multimedia() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');

            // Get received data
            $page = $this->CI->input->post('page');

            // Check form validation
            if ( $this->CI->form_validation->run() !== false ) {

                // Set default limit
                $limit = 12;

                // If page not exists will be 1
                if ( $page < 1 ) {
                    $page = 1;
                }

                // Decrease the page
                $page--;

                // Get total number of medias
                $total = $this->CI->media->get_user_medias(md_the_user_id(), 0, 0);

                // Get the media files
                $getmedias = $this->CI->media->get_user_medias(md_the_user_id(), ($page * $limit), $limit);

                // Verify if media files exists
                if ( $getmedias ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'total' => $total,
                        'medias' => $getmedias,
                        'page' => ($page + 1)
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_multimedia_no_files_found')
        );

        // Display the error message
        echo json_encode($data); 

    }

    /**
     * The public method upload_media_in_storage uploads media in user storage
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function upload_media_in_storage() {

        // Verify if post data was sent
        if ( $this->CI->input->post() ) {

            $this->CI->form_validation->set_rules('cover', 'Cover', 'trim');
            $this->CI->form_validation->set_rules('type', 'Type', 'trim|required');

            // Get data
            $cover = $this->CI->input->post('cover');
            $type = $this->CI->input->post('type');

            if ( ( $this->CI->form_validation->run() === false ) && empty($_FILES['file']['name'])  ) {

                $message = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('frontend_error_occurred') . ': ' . $this->CI->lang->line('frontend_wrong_data')
                );

                echo json_encode($message);

            } else {

                // Supported formats
                $check_format = array('image/png', 'image/jpeg', 'image/gif', 'video/mp4', 'video/webm', 'video/avi');
                
                if ( !in_array($_FILES['file']['type'], $check_format) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('frontend_error_occurred') . ': ' . $this->CI->lang->line('frontend_no_supported_format')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                if ( in_array( $_FILES['file']['type'], $check_format ) ) {
                    
                    // Generate a new file name
                    $file_name = uniqid() . '-' . time();

                    $config['upload_path'] = 'assets/share';
                    $config['file_name'] = $file_name;
                    $this->CI->load->library('upload', $config);
                    $this->CI->upload->initialize($config);
                    $this->CI->upload->set_allowed_types('*');
                    $data['upload_data'] = '';

                    // Upload file 
                    if ( $this->CI->upload->do_upload('file') ) {

                        // Get uploaded file
                        $data['upload_data'] = $this->CI->upload->data();
                        
                        // Set read permission
                        chmod(FCPATH . 'assets/share/' . $data['upload_data']['file_name'], 0644); 
                        
                        // Save the cover on the server
                        $filename_path = $file_name . '-cover.png';
                        
                        // Open the file
                        $fop = fopen( FCPATH . 'assets/share/' . $filename_path, 'wb' );
                        
                        // Decode the cover output
                        $decode_data = explode( ',', str_replace( '[removed]', 'data:image/png;base64,', $cover) );
                        
                        // Save cover
                        fwrite( $fop, base64_decode( $decode_data[ 1 ] ) );
                        
                        // Close the opened file
                        fclose( $fop );
                        
                        // Verify if the file exists
                        if ( file_exists(FCPATH . 'assets/share/' . $filename_path) ) {
                            
                            // Set read permission
                            chmod(FCPATH . 'assets/share/' . $filename_path, 0644); 
                            $cover = $this->CI->config->base_url() . 'assets/share/' . $filename_path;
                            
                        }

                        // Save media in the database
                        if ( $type === 'video' ) {

                            // Save uploaded file data
                            $last_id = $this->CI->media->save_media(md_the_user_id(), $this->CI->config->base_url() . 'assets/share/' . $data['upload_data']['file_name'], 'video', $cover, $_FILES['file']['size']);

                        } else {
                            
                            // Save uploaded file data
                            $last_id = $this->CI->media->save_media(md_the_user_id(), $this->CI->config->base_url() . 'assets/share/' . $data['upload_data']['file_name'], 'image', $cover, $_FILES['file']['size']);

                        }
                        
                        if ( $last_id ) {
                            
                            $message = array(
                                'success' => TRUE,
                                'media_id' => $last_id,
                                'message' => $this->CI->lang->line('frontend_file_uploaded_successfully')
                            );

                            echo json_encode($message);                              
                            
                        }

                    } else {
                        
                        $message = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('frontend_error_occurred') . ': ' . $this->CI->lang->line('frontend_file_not_uploaded')
                        );

                        echo json_encode($message);  
                        
                    }

                } else {

                    $message = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('frontend_error_occurred') . ': ' . $this->CI->lang->line('frontend_no_supported_format')
                    );

                    echo json_encode($message);

                }
                
            }
            
        }

    }

    /**
     * The public method delete_media_item deletes item's id
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function delete_media_item() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('item_id', 'Item ID', 'trim|numeric|required');

            // Get received data
            $media_id = $this->CI->input->post('item_id', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Get media
                $get_media = $this->CI->media->single_media(md_the_user_id(), $media_id);

                // Verify if the user is owner of the media
                if ( $get_media ) {
                    
                    // Delete media
                    if ( $this->CI->media->delete_media(md_the_user_id(), $media_id) ) {
                        
                        // Get file path
                        $filename = str_replace(base_url(), FCPATH, $get_media[0]->body);

                        // Get file data
                        $info = new \SplFileInfo( $filename );                    
                    
                        // Delete file 
                        @unlink($filename);
                        
                        // Delete cover
                        @unlink( str_replace('.' . $info->getExtension(), '-cover.png', $filename) );
                        
                        // Verify if the file was deleted
                        if ( !file_exists($filename) ) {
                            
                            // Prepare the success response
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('frontend_media_was_deleted')
                            );

                            // Display the success response
                            echo json_encode($data);
                            exit();
                            
                        }

                    }

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_media_was_not_deleted')
        );

        // Display the error message
        echo json_encode($data); 

    }

}

/* End of file multimedia.php */