<?php
/**
 * Contents Helpers
 *
 * This file contains the class Contents
 * with methods to manage the frontend's contents
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Frontend\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Contents class provides the methods to manage the frontend's contents
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Contents {
    
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
        
    }
    
    /**
     * The public method save_content saves the frontend's contents
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function save_contents() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('contents_category', 'Contents Category', 'trim|required');
            $this->CI->form_validation->set_rules('contents_component', 'Contents Component', 'trim');
            $this->CI->form_validation->set_rules('theme_template', 'Theme Template', 'trim');
            $this->CI->form_validation->set_rules('contents_static_url_slug', 'Contents Static Url Slug', 'trim');
            $this->CI->form_validation->set_rules('contents_slug', 'Contents Slug', 'trim');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('content_id', 'Content ID', 'trim');
            $this->CI->form_validation->set_rules('classifications', 'Classifications', 'trim');

            // Get all languages
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);

            // List all languages
            foreach ( $languages as $language ) {

                // Get language directory
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Add validation
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');

            }
            
            // Get received data
            $contents_category = $this->CI->input->post('contents_category');
            $contents_component = $this->CI->input->post('contents_component');
            $theme_template = $this->CI->input->post('theme_template');
            $contents_static_url_slug = $this->CI->input->post('contents_static_url_slug');
            $contents_slug = $this->CI->input->post('contents_slug');
            $status = $this->CI->input->post('status');
            $content_id = $this->CI->input->post('content_id');
            $classifications = $this->CI->input->post('classifications');

            // Empty langs array
            $langs = array();

            // List all languages
            foreach ( $languages as $language ) {

                // Get language directory
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Get language value
                $langs[$only_dir] = $this->CI->input->post($only_dir);
                
                // Verify if title exists
                if ( !$langs[$only_dir]['content_title'] ) {
                    
                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('frontend_contents_title_is_required')
                    );

                    echo json_encode($data);
                    exit();
                
                }
                
            }

            // Check form validation
            if ($this->CI->form_validation->run() === false || !$langs || $status < 0 || $status > 1 ) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('frontend_submitted_data_is_not_valid')
                );

                echo json_encode($data);
                exit();

            } else {

                // Verify if content_id exists
                if ( $content_id ) {

                    // Delete contents meta based on content's id
                    $this->CI->base_model->delete('contents_meta', array('content_id' => $content_id, 'meta_name !=' => 'selected_page_role'));                  

                } else {

                    // Save the content
                    $content_id = $this->CI->base_contents->save_content($this->CI->user_id, $contents_category, $contents_component, '', $theme_template, $status);

                }
                
                // Verify if the content was saved
                if ( $content_id ) {

                    // Verify if content's slug exists
                    if ( $contents_slug ) {

                        // Verify if static slug exists
                        if ( $contents_static_url_slug ) {
                            $contents_slug = $contents_static_url_slug . '/' . $contents_slug;
                        }

                        // Add contents slug
                        $this->CI->base_model->update_ceil('contents', array('content_id' => $content_id), array(
                            'contents_slug' => $contents_slug,
                            'status' => $status
                        ));
                        
                        // Update contents where is required
                        md_run_hook(
                            'update_content',
                            array(
                                'content_id' => $content_id,
                                'contents_slug' => $contents_slug,
                                'status' => $status
                            )
                        );

                    } else {

                        // Set contents slug
                        $contents_slug =  $content_id;

                        // Verify if static slug exists
                        if ( $contents_static_url_slug ) {
                            $contents_slug = $contents_static_url_slug . '/' . $contents_slug;
                        }

                        // Add contents slug
                        $this->CI->base_model->update_ceil('contents', array('content_id' => $content_id), array(
                            'contents_slug' => $contents_slug,
                            'status' => $status
                        ));

                        // Update contents where is required
                        md_run_hook(
                            'update_content',
                            array(
                                'content_id' => $content_id,
                                'contents_slug' => $contents_slug,
                                'status' => $status
                            )
                        );

                    }
                    
                    // Count data saved
                    $c = 0;
                    
                    // List all languages
                    foreach ( $langs as $key => $value ) {

                        // Get metas
                        $metas = array_keys($value);

                        // Verify if $metas is not empty
                        if ($metas) {

                            // List all metas
                            foreach ($metas as $meta) {

                                // Verify if meta is default title or body 
                                if ( ($meta === 'content_title') || ($meta === 'content_body') ) {

                                    // Save the content meta
                                    if ($this->CI->base_contents->save_content_meta($content_id, '', $meta, $value[$meta], '', $key)) {
                                        $c++;
                                    }

                                } else {

                                    // Verify if meta has correct format
                                    if (isset($value[$meta]['meta']) && isset($value[$meta]['value'])) {

                                        // Meta value
                                        $meta_value = trim(is_array($value[$meta]['value'])?serialize($value[$meta]['value']):$value[$meta]['value']);

                                        // Meta extra
                                        $meta_extra = '';

                                        if ( isset($value[$meta]['extra']) ) {
                                            $meta_extra = trim($value[$meta]['extra']);

                                            if ( $value[$meta]['meta'] === 'selected_page' ) {

                                                // Get slug
                                                $url_slug = $this->CI->base_model->get_data_where('contents', 'contents_slug', array(
                                                    'content_id' => $meta_extra
                                                ));
    
                                                if ($url_slug) {
                                                    $meta_value = $url_slug[0]['contents_slug'];
                                                }
    
                                            }

                                        }

                                        // Save the content meta
                                        if ($this->CI->base_contents->save_content_meta($content_id, $value[$meta]['meta'], $meta, $meta_value, $meta_extra, $key)) {
                                            $c++;
                                        }

                                    }

                                }

                            }
                            
                        }
                        
                    }

                    // Delete contents classifications based on content's id
                    $this->CI->base_model->delete('contents_classifications', array('content_id' => $content_id));  

                    // Verify if classifications exists
                    if ( $classifications ) {

                        foreach ( $classifications as $classification ) {

                            $contents_classification = array(
                                'content_id' => $content_id,
                                'classification_slug' => $classification['meta'],
                                'classification_value' => $classification['value']
                            );

                            // Save the contents classifications
                            if ( $this->CI->base_model->insert('contents_classifications', $contents_classification) ) {
                                $c++;
                            }

                        }

                    }
                    
                    if ( $c > 0 ) {
                        
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('frontend_contents_was_saved'),
                            'content_id' => $content_id
                        );

                        echo json_encode($data);                         
                        
                    } else {
                    
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('frontend_contents_was_not_saved')
                        );

                        echo json_encode($data);                    

                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method load_contents_by_category loads contents by category
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_contents_by_category() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('contents_category', 'Contents Category', 'trim|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $contents_category = $this->CI->input->post('contents_category');
            $key = $this->CI->input->post('key');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 20;
                $page--;

                // Prepare arguments for request
                $args = array(
                    'contents_category' => $contents_category,
                    'start' => ($page * $limit),
                    'limit' => $limit,
                    'key' => $key
                );
                
                // Get contents by page
                $contents = $this->CI->base_contents->get_contents( $args );

                // Verify if contents exists
                if ( $contents ) {

                    // Prepare arguments for request
                    $args = array(
                        'contents_category' => $contents_category,
                        'key' => $key
                    );                    

                    // Get total number of contents
                    $total = $this->CI->base_contents->get_contents($args);

                    // Display contents
                    $data = array(
                        'success' => TRUE,
                        'contents' => $contents,
                        'total' => $total,
                        'page' => ($page + 1),
                        'words' => array(
                            'publish' => $this->CI->lang->line('frontend_publish'),
                            'draft' => $this->CI->lang->line('frontend_draft'),
                            'delete' => $this->CI->lang->line('frontend_delete')
                        )
                    );

                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_data_found_to_show')
        );

        echo json_encode($data);
        
    } 
    
    /**
     * The public method delete_content deletes content by content's id
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function delete_content() {
        
        // Get content_id's input
        $content_id = $this->CI->input->get('content_id', TRUE);  

        // Verify if content's id exists
        if ( $content_id ) {

            // Delete content
            $delete = $this->CI->base_contents->delete_content($content_id);

            if ( $delete ) {

                // Delete contents records
                md_run_hook(
                    'delete_content',
                    array(
                        'content_id' => $content_id
                    )
                );

                // Display success message
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('frontend_content_was_deleted')
                );

                echo json_encode($data);
                exit();

            }
            
        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_content_was_not_deleted')
        );

        echo json_encode($data); 

    }

    /**
     * The public method delete_contents deletes contents by contents ids
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function delete_contents() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('contents_ids', 'Contents Ids', 'trim');
           
            // Get received data
            $contents_ids = $this->CI->input->post('contents_ids');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if contents ids exists
                if ( $contents_ids ) {

                    // Ccount number of deleted contents
                    $count = 0;

                    // List all contents
                    foreach ( $contents_ids as $id ) {

                        // Delete content
                        if ($this->CI->base_contents->delete_content($id)) {

                            // Delete contents records
                            md_run_hook(

                                'delete_content',

                                array(
                                    'content_id' => $id
                                )

                            );

                            $count++;

                        }

                    }

                    if ( $count > 0 ) {

                        // Display success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('frontend_contents_were_deleted')
                        );

                        echo json_encode($data);
                        exit();

                    }

                } else {

                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('frontend_please_select_at_least_one_content')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_contents_were_not_deleted')
        );

        echo json_encode($data); 

    }

}

/* End of file contents.php */