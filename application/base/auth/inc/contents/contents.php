<?php
/**
 * Contents Auth Inc
 *
 * This file contains the contents functions
 * used in auth's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_selected_page_by_role') ) {
    
    /**
     * The function the_selected_page_by_role gets page by role
     * 
     * @param string $type contains the role's type
     * @param string $role contains the role of the requested page
     * 
     * @since 0.0.7.8
     * 
     * @return object with content's data or boolean false
     */
    function the_selected_page_by_role($type, $role) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load Base Contents Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

        // Get selected page by role
        $selected_page = $CI->base_contents->get_contents_by_meta_name($type, $role);

        // Verify if page exists
        if ( $selected_page ) {

            // Return content by content's ID
            return $CI->base_contents->get_content($selected_page[0]['content_id']);

        }
        
        return false;
        
    }
    
}

if ( !function_exists('the_url_by_page_role') ) {
    
    /**
     * The function the_url_by_page_role gets the page url by role
     * 
     * @param string $type contains the role
     * 
     * @since 0.0.7.8
     * 
     * @return string with url or boolean false
     */
    function the_url_by_page_role($type) {

        // Get codeigniter object instance
        $CI =& get_instance();

        // Get selected pages
        $selected_pages = md_the_component_variable('selected_pages_by_role');

        if ( !$selected_pages ) {

            // Get selected pages by role
            $selected_pages = $CI->base_contents->get_contents_by_meta_name('selected_page_role');

            // Set pages
            md_set_component_variable('selected_pages_by_role', $selected_pages);
        
        }

        if ( $selected_pages ) {

            foreach ( $selected_pages as $selected_page ) {

                if ( $selected_page['meta_value'] === 'settings_auth_' . $type . '_page' ) {

                    return site_url($selected_page['contents_slug']);

                }

            }

        }

        return false;
        
    }
    
}