<?php
/**
 * Contents Read Inc
 *
 * This file contains the contents functions
 * only to set and read content
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Contents as MidrubBaseClassesContents;

if ( !function_exists('md_the_single_content') ) {
    
    /**
     * The function md_the_single_content returns single content's content by content's ID or slug
     * 
     * @param integer $content_id contains the content's id
     * @param string $contents_slug contains the contents slug
     * 
     * @since 0.0.7.8
     * 
     * @return object with content's content or boolean false
     */
    function md_the_single_content($content_id=NULL, $contents_slug=NULL) {

        // Get codeigniter object instance
        $CI =& get_instance();

        // Load Base Contents Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

        // Get content by content_id
        $content = $CI->base_contents->get_content($content_id, $contents_slug);

        // Verify if content exists
        if ( $content ) {

            return $content;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_set_single_content') ) {
    
    /**
     * The function md_set_single_content set content
     * 
     * @param object $content contains the content's data
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_single_content($content) {

        // Call the contents_read class
        $contents_read = (new MidrubBaseClassesContents\Contents_read);

        // Set content in the queue
        $contents_read->set_single_content($content);
        
    }
    
}

if ( !function_exists('md_the_single_content_meta') ) {
    
    /**
     * The function md_the_single_content_meta gets content's meta based on parameters
     * 
     * @param string $meta_name contains the meta's name
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with meta's value or boolean false
     */
    function md_the_single_content_meta($meta_name, $language = NULL) {

        // Verify if language missing
        if ( !$language ) {

            // Get codeigniter object instance
            $CI = &get_instance();

            // Set language
            $language = $CI->config->item('language');

        }
        
        // Call the contents_read class
        $contents_read = (new MidrubBaseClassesContents\Contents_read);

        // Verify if content exists
        if ( $contents_read::$the_single_content ) {

            $value = '';

            foreach ( $contents_read::$the_single_content as $meta ) {

                if ( ($meta['meta_name'] === $meta_name) && ($meta['language'] === $language) ) {

                    $value = $meta['meta_value'];

                }

            }

            if ( $value ) {

                return $value;

            } else {

                return false;

            }

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_get_single_content_meta') ) {
    
    /**
     * The function md_get_single_content_meta gets content's meta based on parameters
     * 
     * @param string $meta_name contains the meta's name
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_single_content_meta($meta_name, $language=NULL) {
        
        // Get meta's value if exists
        $meta_value = md_the_single_content_meta($meta_name, $language);

        if ( $meta_value ) {

            echo $meta_value;

        }

    }
    
}
