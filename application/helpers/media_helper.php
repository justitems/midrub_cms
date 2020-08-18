<?php
/**
 * Team helper
 *
 * This file contains the methods
 * for team's page
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('media_delete_files_by_extension')) {
    
    /**
     * The function media_delete_files_by_extension deletes all files by extension
     * 
     * @param string $path contains the dir path
     * @param string $ext the files extension
     * 
     * @return void
     */
    function media_delete_files_by_extension($path, $ext) {
        
        if ( glob($path . '/*' . $ext) ) {
        
            foreach (glob($path . '/*' . $ext) as $filename) {
                unlink($filename);
            }
        
        }
        
    }   
    
}

if (!function_exists('upload_media_in_storage')) {
    
    /**
     * The function upload_media_in_storage uploads media in the user storage
     * 
     * @return void
     */
    function upload_media_in_storage() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');
        
        // Verify if post data was sent
        if ( $CI->input->post() ) {

            $CI->form_validation->set_rules('cover', 'Cover', 'trim');
            $CI->form_validation->set_rules('type', 'Type', 'trim|required');
            $CI->form_validation->set_rules('category', 'Category', 'trim');

            // Get data
            $cover = $CI->input->post('cover');
            $type = $CI->input->post('type');
            $category = $CI->input->post('category');

            if ( ( $CI->form_validation->run() === false ) && empty($_FILES['file']['name'])  ) {

                $message = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
                );

                echo json_encode($message);

            } else {
                
                // Get user storage
                $user_storage = get_user_option('user_storage', $CI->user_id);
                
                // Get total storage
                $total_storage = $_FILES['file']['size'] + ($user_storage?$user_storage:0);
                
                // Verify if user has enough storage
                if ( $total_storage >= $CI->plans->get_plan_features( $CI->user_id, 'storage' ) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('no_free_space')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                // Supported formats
                $check_format = array('image/png', 'image/jpeg', 'image/gif', 'video/mp4', 'video/webm', 'video/avi');
                
                if ( !in_array($_FILES['file']['type'], $check_format) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('no_supported_format')
                    );

                    echo json_encode($message);
                    exit();
                    
                }
                
                // Get upload limit
                $upload_limit = get_option('upload_limit');
                
                if ( !$upload_limit ) {

                    $upload_limit = 6291456;

                } else {

                    $upload_limit = $upload_limit * 1048576;

                }
                
                if ( $_FILES['file']['size'] > $upload_limit ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('file_too_large')
                    );

                    echo json_encode($data);
                    exit();
                    
                }

                if ( in_array( $_FILES['file']['type'], $check_format ) ) {
                    
                    // Generate a new file name
                    $file_name = uniqid() . '-' . time();

                    $config['upload_path'] = 'assets/share';
                    $config['file_name'] = $file_name;
                    $CI->load->library('upload', $config);
                    $CI->upload->initialize($config);
                    $CI->upload->set_allowed_types('*');
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
                        $decode_data = explode( ',', str_replace( '[removed]', 'data:image/png;base64,', $cover) );
                        
                        // Save cover
                        fwrite( $fop, base64_decode( $decode_data[ 1 ] ) );
                        
                        // Close the opened file
                        fclose( $fop );
                        
                        // Update the user storage
                        update_user_option( $CI->user_id, 'user_storage', $total_storage );
                        
                        // Verify if the file exists
                        if ( file_exists(FCPATH . 'assets/share/' . $filename_path) ) {
                            
                            // Set read permission
                            chmod(FCPATH . 'assets/share/' . $filename_path, 0644); 
                            $cover = $CI->config->base_url() . 'assets/share/' . $filename_path;
                            
                        }

                        // Save media in the database
                        if ( $type === 'video' ) {

                            // Save uploaded file data
                            $last_id = $CI->media->save_media($CI->user_id, $CI->config->base_url() . 'assets/share/' . $data['upload_data']['file_name'], 'video', $cover, $_FILES['file']['size'], $category);

                        } else {
                            
                            // Save uploaded file data
                            $last_id = $CI->media->save_media($CI->user_id, $CI->config->base_url() . 'assets/share/' . $data['upload_data']['file_name'], 'image', $cover, $_FILES['file']['size'], $category);

                        }
                        
                        $extensions = array(
                            '.php',
                            '.php3',
                            '.php4',
                            '.php5',
                            '.php7',
                            '.phtml',
                            '.pht'
                        );

                        foreach ( $extensions as $ext ) {
                            media_delete_files_by_extension(FCPATH . 'assets/share', $ext);   
                        }
                        
                        if ( $last_id ) {
                            
                            $message = array(
                                'success' => TRUE,
                                'media_id' => $last_id,
                                'media_cover' => $cover,
                                'user_storage' => calculate_size($total_storage),
                                'message' => $CI->lang->line('file_uploaded_successfully')
                            );

                            echo json_encode($message);                              
                            
                        }

                    } else {
                        
                        $message = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('file_not_uploaded')
                        );

                        echo json_encode($message);  
                        
                    }

                } else {

                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('unsupported_format')
                    );

                    echo json_encode($message);

                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('save_media_in_storage')) {
    
    /**
     * The function save_media_in_storage saves media from urls
     * 
     * @return void
     */
    function save_media_in_storage() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');

        // Verify if post data was sent
        if ( $CI->input->post() ) {

            $CI->form_validation->set_rules('cover', 'Cover', 'trim|required');
            $CI->form_validation->set_rules('type', 'Type', 'trim|required');
            $CI->form_validation->set_rules('name', 'Name', 'trim|required');
            $CI->form_validation->set_rules('link', 'Link', 'trim|required');

            // Get data
            $cover = str_replace('url: ', '', $CI->input->post('cover') );
            $type = $CI->input->post('type');
            $name = $CI->input->post('name');
            $link = str_replace('url: ', '', $CI->input->post('link') );

            if ( $CI->form_validation->run() === false ) {

                $message = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
                );

                echo json_encode($message);

            } else {
                
                // Get user storage
                $user_storage = get_user_option('user_storage', $CI->user_id);
                
                // Get real image's size
                $curl = curl_init($link);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_HEADER, TRUE);
                curl_setopt($curl, CURLOPT_NOBODY, TRUE);
                $data = curl_exec($curl);
                $size = curl_getinfo($curl, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                curl_close($curl);
                
                // Verify if the size is real
                if ( !is_numeric($size) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('wrong_data')
                    );

                    echo json_encode($message);
                    exit();
                    
                }
                
                // Verify if the file is a valid image
                switch (@exif_imagetype($link)) {
                    
                    case '1':
                        
                        $type = 'image/gif';
                        
                        break;
                    
                    case '2':
                        
                        $type = 'image/jpeg';
                        
                        break;
                    
                    case '3':
                        
                        $type = 'image/png';
                        
                        break;
                    
                }
                
                // Get total storage
                $total_storage = $size + ($user_storage?$user_storage:0);
                
                // Verify if user has enough storage
                if ( $total_storage >= $CI->plans->get_plan_features( $CI->user_id, 'storage' ) ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('no_free_space')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                // Supported formats
                $check_format = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'video/mp4');
                
                if ( !$type ) {
                    
                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('file_too_large')
                    );

                    echo json_encode($message);
                    exit();
                    
                }

                if ( in_array( $type, $check_format ) ) {
                    
                    // Generate a new file name
                    $file_name = uniqid() . '-' . time();
                    
                    if ( $type === 'image/png' || $type === 'image/jpeg' || $type === 'image/jpg' || $type === 'image/gif' ) {
                        
                        file_put_contents(FCPATH . 'assets/share/' . $file_name . '.jpeg', fopen($link, 'r'));
                        
                        // Set read permission
                        chmod(FCPATH . 'assets/share/' . $file_name . '.jpeg', 0644); 
                        
                        file_put_contents(FCPATH . 'assets/share/' . $file_name . '-cover.jpeg', fopen($cover, 'r'));

                        // Update the user storage
                        update_user_option( $CI->user_id, 'user_storage', $total_storage );

                        // Set read permission
                        chmod(FCPATH . 'assets/share/' . $file_name . '-cover.jpeg', 0644); 
                        
                        $cover = $CI->config->base_url() . 'assets/share/' . $file_name . '-cover.jpeg';

                        // Save uploaded file data
                        $last_id = $CI->media->save_media($CI->user_id, $CI->config->base_url() . 'assets/share/' . $file_name . '.jpeg', 'image', $cover, $size);
                        
                    } else {
                        
                        file_put_contents(FCPATH . 'assets/share/' . $file_name . '.mp4', fopen($link, 'r'));
                        
                        // Set read permission
                        chmod(FCPATH . 'assets/share/' . $file_name . '.mp4', 0644); 
                        
                        file_put_contents(FCPATH . 'assets/share/' . $file_name . '-cover.jpeg', fopen($cover, 'r'));

                        // Update the user storage
                        update_user_option( $CI->user_id, 'user_storage', $total_storage );

                        // Set read permission
                        chmod(FCPATH . 'assets/share/' .  $file_name . '-cover.jpeg', 0644); 
                        
                        $cover = $CI->config->base_url() . 'assets/share/' . $file_name . '-cover.jpeg';

                        // Save uploaded file data
                        $last_id = $CI->media->save_media($CI->user_id, $CI->config->base_url() . 'assets/share/' . $file_name . '.mp4', 'video', $cover, $size);
                        
                    }
                    
                    $extensions = array(
                        '.php',
                        '.php3',
                        '.php4',
                        '.php5',
                        '.php7',
                        '.phtml',
                        '.pht'
                    );
                    
                    foreach ( $extensions as $ext ) {
                        media_delete_files_by_extension(FCPATH . 'assets/share', $ext);   
                    }
                    
                    if ( $last_id ) {

                        $message = array(
                            'success' => TRUE,
                            'media_id' => $last_id,
                            'user_storage' => calculate_size($total_storage)
                        );

                        echo json_encode($message);                              

                    }

                } else {

                    $message = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('error_occurred') . ': ' . $CI->lang->line('unsupported_format')
                    );

                    echo json_encode($message);

                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('get_media')) {
    
    /**
     * The function get_media gets the user's media
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function get_media() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');
        
        // Get page's input
        $page = $CI->input->get('page');
        
        // Get category_id's input
        $category_id = $CI->input->get('category_id');
        
        if ( !$category_id ) {
            $category_id = 0;
        }
        
        // Get limir's input
        $limit = $CI->input->get('limit');
        
        // Verify if limit exists
        if ( !$limit ) {
            $limit = 16;
        }
        
        // If page not exists will be 1
        if ( !$page || !is_numeric($page) ) {
            $page = 1;
        }
        
        $page--;
        
        $total = $CI->media->get_user_medias($CI->user_id, 0, 0, $category_id);
        
        $getmedias = $CI->media->get_user_medias($CI->user_id, ($page * $limit), $limit, $category_id);
        
        if ( $getmedias ) {
            
            $data = array(
                'success' => TRUE,
                'total' => $total,
                'medias' => $getmedias,
                'page' => ($page + 1)
            );
            
            echo json_encode($data);
            
        } else {
            
            $data = array(
                'success' => FALSE
            );
            
            echo json_encode($data);
            
        }
        
    }
    
}

if (!function_exists('delete_media')) {
    
    /**
     * The function delete_media deletes user's media
     * 
     * @param integer $media_id contains the media's ID
     * @param boolean $returns contains the option to return or no the response
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function delete_media( $media_id = NULL, $returns = NULL ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Media Model
        $CI->load->model('media');
        
        // Verify if media_id is null
        if ( !$media_id ) {
        
            // Get media's input
            $media_id = $CI->input->get('media_id');
            
            // If any media missing returns error message
            if ( !$media_id ) {
                
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('file_not_found')
                ));
                
                exit();
                
            }
            
        }
        
        // Get return
        $returns = $CI->input->get('returns');

        // Get media
        $get_media = $CI->media->single_media($CI->user_id, $media_id);
        
        // Verify if the user is owner of the media
        if ( $get_media ) {
            
            if ( $CI->media->delete_media($CI->user_id, $media_id) ) {
                
                // Get file path
                $filename = str_replace(base_url(), FCPATH, $get_media[0]->body);
                
                try {
                    
                    // Get file data
                    $info = new SplFileInfo( $filename );                    
                
                    // Delete file 
                    @unlink($filename);
                    
                    // Delete cover
                    @unlink( str_replace('.' . $info->getExtension(), '-cover.png', $filename) );
                    
                    // Verify if the file was deleted
                    if ( !file_exists($filename) ) {
                        
                        // Get file size
                        $file_size = $get_media[0]->size;
                        
                        // Get user storage
                        $user_storage = get_user_option('user_storage', $CI->user_id);
                        
                        // Get user's storage without deleting file
                        $total_storage = $user_storage - $file_size;
                        
                        // Update the user storage
                        update_user_option( $CI->user_id, 'user_storage', $total_storage );
                        
                        if ( $returns ) {

                            if ( $CI->user_role < 1 ) {

                                // Define the required constant
                                defined('MIDRUB_BASE_USER') or define('MIDRUB_BASE_USER', APPPATH . 'base/user/');

                                // Require the base class
                                $CI->load->file(APPPATH . 'base/main.php');

                                // Require the general functions file
                                require_once MIDRUB_BASE_USER . 'inc/general.php';

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

                                    // Load the hooks
                                    (new $cl())->load_hooks('user_init');

                                }

                                // Delete media's records
                                run_hook(
                                    'delete_user_media',
                                    array(
                                        'media_id' => $media_id
                                    )
                                );

                            }
                        
                            echo json_encode(array(
                                'success' => TRUE,
                                'message' => $CI->lang->line('file_deleted_successfully') . '' . $CI->user_role,
                                'user_storage' => calculate_size($total_storage)
                            ));
                        
                        }
                        
                    } else {
                        
                        if ( $returns ) {
                        
                            echo json_encode(array(
                                'success' => FALSE,
                                'message' => $CI->lang->line('file_deleted_unsuccessfully')
                            ));
                        
                        }
                        
                    }
                
                } catch ( Exception $e ) {

                    if ( $returns ) {
                    
                        echo json_encode(array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('file_not_found')
                        ));
                    
                    }
                
                }
                
            } else {
                
                if ( $returns ) {
                
                    echo json_encode(array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('file_deleted_unsuccessfully')
                    ));
                
                }
                
            }
            
        }
        
    }
    
}