<?php
/**
 * General Theme Ajax
 *
 * This file contains the main theme's ajax functions
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Media as CmsBaseClassesMedia;

if ( !function_exists('theme_get_integrations_search_results') ) {
    
    /**
     * The function theme_get_integrations_search_results processes ajax submission
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_get_integrations_search_results() {

        // Get the string
        $CI =& get_instance();

        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('key', 'Key', 'trim|required');
            
            // Get received data
            $key = $CI->input->post('key');

            // Check form validation
            if ($CI->form_validation->run() !== false ) {

                // Get the integrations
                $the_integrations = md_the_db_request(
                    'contents',
                    'contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
                    array(
                        'contents_meta.language' => $CI->config->item('language'),
                        'contents_meta.meta_name' => 'content_title',
                        'contents.status' => 1,
                        'contents.contents_category' => 'integrations'
                    ),
                    array(),
                    array('contents_meta.meta_value' => $CI->db->escape_like_str($key)),
                    array(
                        array(
                            'table' => 'contents_meta',
                            'condition' => 'contents.content_id=contents_meta.content_id',
                            'join_from' => 'LEFT'
                        )              
                    ),
                    array(
                        'order_by' => array('contents.content_id', 'desc'),
                        'start' => 0,
                        'limit' => 10
                    )
                    
                );

                // Verify if the integrations exists
                if ( $the_integrations ) {

                    // Integrations container
                    $integrations = array();

                    // List the integrations
                    foreach ($the_integrations as $integration) {

                        // Append integration to the container
                        $integrations[] = array(
                            'title' => $integration['meta_value'],
                            'url' => site_url($integration['contents_slug'])
                        );

                    }

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'integrations' => $integrations
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_no_integrations_were_found')
        );

        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_get_articles_search_results') ) {
    
    /**
     * The function theme_get_articles_search_results processes ajax submission
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_get_articles_search_results() {

        // Get the string
        $CI =& get_instance();

        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('key', 'Key', 'trim|required');
            
            // Get received data
            $key = $CI->input->post('key');

            // Check form validation
            if ($CI->form_validation->run() !== false ) {

                // Get the articles
                $the_articles = md_the_db_request(
                    'contents',
                    'contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
                    array(
                        'contents_meta.language' => $CI->config->item('language'),
                        'contents_meta.meta_name' => 'content_title',
                        'contents.status' => 1,
                        'contents.contents_category' => 'support_articles'
                    ),
                    array(),
                    array('contents_meta.meta_value' => $CI->db->escape_like_str($key)),
                    array(
                        array(
                            'table' => 'contents_meta',
                            'condition' => 'contents.content_id=contents_meta.content_id',
                            'join_from' => 'LEFT'
                        )              
                    ),
                    array(
                        'order_by' => array('contents.content_id', 'desc'),
                        'start' => 0,
                        'limit' => 10
                    )
                    
                );

                // Verify if the articles exists
                if ( $the_articles ) {

                    // articles container
                    $articles = array();

                    // List the articles
                    foreach ($the_articles as $article) {

                        // Append article to the container
                        $articles[] = array(
                            'title' => $article['meta_value'],
                            'url' => site_url($article['contents_slug'])
                        );

                    }

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'articles' => $articles
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_no_articles_were_found')
        );

        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_get_posts_search_results') ) {
    
    /**
     * The function theme_get_posts_search_results processes ajax submission
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_get_posts_search_results() {

        // Get the string
        $CI =& get_instance();

        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('key', 'Key', 'trim|required');
            
            // Get received data
            $key = $CI->input->post('key');

            // Check form validation
            if ($CI->form_validation->run() !== false ) {

                // Get the posts
                $the_posts = md_the_db_request(
                    'contents',
                    'contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status',
                    array(
                        'contents_meta.language' => $CI->config->item('language'),
                        'contents_meta.meta_name' => 'content_title',
                        'contents.status' => 1,
                        'contents.contents_category' => 'posts'
                    ),
                    array(),
                    array('contents_meta.meta_value' => $CI->db->escape_like_str($key)),
                    array(
                        array(
                            'table' => 'contents_meta',
                            'condition' => 'contents.content_id=contents_meta.content_id',
                            'join_from' => 'LEFT'
                        )              
                    ),
                    array(
                        'order_by' => array('contents.content_id', 'desc'),
                        'start' => 0,
                        'limit' => 10
                    )
                    
                );

                // Verify if posts exists
                if ( $the_posts ) {

                    // Posts container
                    $posts = array();

                    // List the posts
                    foreach ($the_posts as $post) {

                        // Append post to container
                        $posts[] = array(
                            'title' => $post['meta_value'],
                            'url' => site_url($post['contents_slug'])
                        );

                    }

                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'posts' => $posts
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_no_posts_were_found')
        );

        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_get_features') ) {
    
    /**
     * The function theme_get_features gets the features
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_get_features() {

        // Get the string
        $CI =& get_instance();

        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('categories', 'Categories', 'trim');
            
            // Get received data
            $categories = $CI->input->post('categories');

            // Check form validation
            if ($CI->form_validation->run() !== false ) {

                // Verify if categories exists
                if ( $categories ) {

                    // Load the CRM Theme Model
                    $CI->load->ext_model( md_the_theme_path() . 'models/', 'Crm_theme_model', 'crm_theme_model' );
                    
                    // Get contents
                    $the_contents = $CI->crm_theme_model->the_features_list($categories);
                    
                    // Verify if contents exists
                    if ( $the_contents ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'contents' => $the_contents,
                            'words' => array(
                                'read_more' => $CI->lang->line('theme_read_more')
                            )                            
                        );

                        echo json_encode($data);
                        exit();                        

                    }

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_no_features_were_found')
        );

        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_get_careers') ) {
    
    /**
     * The function theme_get_careers gets the careers
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_get_careers() {

        // Get the string
        $CI =& get_instance();

        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('categories', 'Categories', 'trim');
            
            // Get received data
            $categories = $CI->input->post('categories');

            // Check form validation
            if ($CI->form_validation->run() !== false ) {

                // Verify if categories exists
                if ( $categories ) {

                    // Load the CRM Theme Model
                    $CI->load->ext_model( md_the_theme_path() . 'models/', 'Crm_theme_model', 'crm_theme_model' );
                    
                    // Get contents
                    $the_contents = $CI->crm_theme_model->the_careers_list($categories);
                    
                    // Verify if contents exists
                    if ( $the_contents ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'contents' => $the_contents,
                            'words' => array(
                                'read_more' => $CI->lang->line('theme_read_more')
                            )                            
                        );

                        echo json_encode($data);
                        exit();                        

                    }

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_no_careers_were_found')
        );

        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_change_frontend_logo') ) {
    
    /**
     * The function theme_change_frontend_logo changes the website frontend logo
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_change_frontend_logo() {

        // Get the session
        $the_session = md_the_user_session();

        // Verify if the session exists
        if ( $the_session ) {

            // Verify if role is administrator
            if ( !empty($the_session['role']) ) {

                // Get the string
                $CI =& get_instance();

                // Check if data was submitted
                if ($CI->input->post()) {

                    // Verify if the file was uploaded
                    if ( empty($_FILES['files']) ) {

                        // Prepare the error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('theme_an_error_occurred')
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

                    // Verify if the uploaded file is an image
                    if ( !in_array($_FILES['files']['type'][0], array('image/jpeg', 'image/jpg', 'image/png')) ) {

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
                        'allowed_extensions' => array('image/png', 'image/jpg', 'image/jpeg')
                    ), true);

                    // Verify if the file was uploaded
                    if ( !empty($response['success']) ) {

                        // Change the website logo
                        md_update_option('frontend_theme_logo', $response['media_id']);

                        // Get file type
                        $get_type = explode('/', $_FILES['file']['type']);

                        // Get the file url
                        $file_url = $CI->base_model->the_data_where(
                        'medias',
                        '*',
                        array(
                            'media_id' => $response['media_id']
                        ));

                        // Prepare response
                        $message = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('theme_website_logo_was_changed'),
                            'media_id' => $response['media_id'],
                            'file_url' => $file_url?$file_url[0]['body']:base_url('assets/img/no-image.png')                    
                        );

                        // Display the response
                        echo json_encode($message);

                    } else {

                        // Display error
                        echo json_encode(array(
                            'success' => FALSE,
                            'message' => !empty($response['message'])?$response['message']:$CI->lang->line('theme_website_logo_was_not_changed')
                        ));

                    }

                    exit();

                }

            }

        }
        
        // Prepare response
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('theme_website_logo_was_not_changed')
        );

        // Prepare response
        echo json_encode($data);
        
    }
    
}

if ( !function_exists('theme_remove_website_logo') ) {
    
    /**
     * The function theme_remove_website_logo removes the website frontend logo
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function theme_remove_website_logo() {

        // Get the session
        $the_session = md_the_user_session();

        // Verify if the session exists
        if ( $the_session ) {

            // Verify if role is administrator
            if ( !empty($the_session['role']) ) {

                // Get the string
                $CI =& get_instance();

                // Check if data was submitted
                if ($CI->input->post()) {

                    // Try to delete the website logo
                    if ( md_delete_option('frontend_theme_logo') ) {

                        // Prepare response
                        $message = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('theme_website_logo_was_removed')                 
                        );

                        // Display the response
                        echo json_encode($message);

                    } else {

                        // Prepare response
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('theme_website_logo_was_not_removed')
                        );

                        // Prepare response
                        echo json_encode($data);

                    }

                    exit();

                }

            }

        }
        
        // Prepare response
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('profile_an_error_occurred')
        );

        // Prepare response
        echo json_encode($data);
        
    }
    
}

/* End of file main.php */