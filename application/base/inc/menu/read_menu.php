<?php
/**
 * Read Menu Inc
 *
 * This file contains the general functions to 
 * read menu for the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_theme_menu') ) {
    
    /**
     * The function md_the_theme_menu gets a menu
     * 
     * @param array $args contains the query arguments
     * 
     * @since 0.0.7.8
     * 
     * @return array with menu's items or boolean false 
     */
    function md_the_theme_menu($args) {
        
        // Get codeigniter object instance
        $CI =& get_instance();

        // Load Base Classifications Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_classifications', 'base_classifications' );

        // Get menu's items
        $items = $CI->base_classifications->get_menu_items($args);

        // Verify if menu has items
        if ( $items ) {

            return $items;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_the_classification') ) {
    
    /**
     * The function md_the_classification gets a classification's items
     * 
     * @param array $args contains the query arguments
     * 
     * @since 0.0.7.9
     * 
     * @return array with classification items or boolean false 
     */
    function md_the_classification($args) {
        
        // Get codeigniter object instance
        $CI =& get_instance();

        // Load Base Classifications Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_classifications', 'base_classifications' );

        // Set type
        $args['type'] = 'contents_classification';

        // Get classification's items
        $items = $CI->base_classifications->get_classifications_by_slug( $args );

        // Verify if the classification has items
        if ( $items ) {

            return $items;

        } else {

            return false;

        }
        
    }
    
}