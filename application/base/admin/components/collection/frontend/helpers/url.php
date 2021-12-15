<?php
/**
 * Url Helper
 *
 * This file contains the class Url
 * with methods to manage the contents urls
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
 * Url class provides the methods to manage the contents urls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Url {
    
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
        
    }
    
    /**
     * The public method generate_url_slug generates url's slug
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function generate_url_slug() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('url_slug', 'Url Slug', 'trim');
            $this->CI->form_validation->set_rules('category_slug', 'Category Slug', 'trim');

            // Get received data
            $url_slug = $this->CI->input->post('url_slug');
            $category_slug = $this->CI->input->post('category_slug');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Remove non allowed characters
                $new_slug = preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9 -]+#'), array('-', ''), $url_slug);

                // Verify if url's slug is still valid
                if ($new_slug) {

                    // Prepare url's slug
                    $new_slug = strtolower(str_replace(' ', '-', $new_slug));

                    // If the slug already exists will generate a new slug
                    for ($e = 0; $e < 1000; $e++) {

                        // If $e is bigger than 0, will be renamed the slug
                        if ($e > 0) {

                            $slugs = explode('-', $new_slug);

                            if ( count($slugs) > 0 ) {

                                end($slugs);
                                $key = key($slugs);

                                if ( is_numeric($slugs[$key]) ) {
                                    $slugs[$key] = $e;
                                    $new_slug = implode('-', $slugs);
                                } else {
                                    $slugs[$key] = $slugs[$key] . '-' . $e;
                                    $new_slug = implode('-', $slugs);                                    
                                }

                            } else {

                                $new_slug = $new_slug . '-' . $e;                                

                            }

                        }

                        // Prepare params
                        $params = array(
                            'contents_slug' => $new_slug
                        );

                        // Verify if category exists
                        if ($category_slug) {
                            $params['contents_slug'] = $category_slug . '/' . $params['contents_slug'];
                        }

                        // Get slug
                        $url_slug = $this->CI->base_model->the_data_where('contents', 'contents_slug', $params);

                        // Verify if slug doesn't exists
                        if (!$url_slug) {
                            break;
                        }
                        
                    }

                    // Display error message
                    $data = array(
                        'success' => TRUE,
                        'slug' => $new_slug
                    );

                    echo json_encode($data);
                    exit();

                }

            }


        }

        // Display error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_slug_not_supported')
        );

        echo json_encode($data); 

    }

}

/* End of file url.php */