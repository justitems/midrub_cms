<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used for translation in Frontend and Auth
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_language') ) {
    
    /**
     * The function md_get_language verifies if language exists
     * 
     * @param string $language contains the language
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_language($language) {

        if ( is_dir(APPPATH . 'language/' . $language . '/') ) {
            md_set_config_item('language', $language);
        }
        
    }
    
}

if ( !function_exists('md_set_language') ) {
    
    /**
     * The function md_set_language sets the language
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_language() {

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

            // Get the browser language
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            // List all languages
            switch ($lang) {

                case 'en':
                    md_get_language('english');
                    break;

                case 'it':
                    md_get_language('italian');
                    break;
                    
            }

        }
        
    }
    
}