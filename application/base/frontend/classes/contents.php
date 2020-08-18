<?php
/**
 * Contents Class
 *
 * This file loads the Contents Class with methods for contents
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Contents class loads the methods for contents
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Contents {

    /**
     * The public method the_contents_list gets the contents's list
     * 
     * @param array $args contains the arguments to request
     * 
     * @since 0.0.8.1
     * 
     * @return object with contents list or boolean false
     */
    public function the_contents_list($args = array()) {

        // Verify if contents list exists
        if ( md_the_component_variable('contents_list') ) {

            // Gets contents_list's component variable
            return md_the_component_variable('contents_list');

        }

        // Set the limit
        $limit = 20;

        // Verify if limit exists
        if ( isset($args['limit']) ) {

            // Set limit
            $limit = $args['limit'];

        }

        // Set page
        $page = md_the_component_variable('page')?((md_the_component_variable('page') - 1) * $limit):0;

        // Get the instance
        $CI =& get_instance();

        // Args to request
        $r_args = array(
            'start' => $page,
            'limit' => $limit
        );

        // Set classification's ID
        $classification_id = md_the_component_variable('classification_item_id');

        // Verify if classification's ID exists
        if ( isset($args['classification_id']) ) {

            // Set classification's ID
            $r_args['classification_value'] = $args['classification_id'];

        } else if ( $classification_id ) {

            // Set classification's ID
            $r_args['classification_value'] = md_the_component_variable('classification_item_id');
            
        }

        // Verify if is search
        if ( md_the_component_variable('search_key') ) {

            $r_args['key'] = preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9 -]+#'), array('-', ''), md_the_component_variable('search_key'));

        }

        // Get contents by page
        $contents = $CI->base_contents->get_contents($r_args, 'classifications');

        // Set contents's list
        md_set_component_variable('contents_list', $contents);

        // Set contents's display limit
        md_set_component_variable('contents_display_limit', $limit);

        // Verify if contents exists
        if ( $contents ) {

            // Verify for classification
            if ( isset($r_args['classification_value']) ) {

                // Get total contents
                $total = $CI->base_contents->get_contents(array(
                    'classification_value' => md_the_component_variable('classification_item_id'),
                ), 'classifications');

                // Set page url
                md_set_component_variable('contents_pagination_url', site_url($contents[0]['classification_slug'] . '/' . $contents[0]['classification_meta_slug'] . '/page/')); 
                
            } else {

                // Get total contents
                $total = $CI->base_contents->get_contents(array(
                    'key' => preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9 -]+#'), array('-', ''), md_the_component_variable('search_key'))
                ), 'classifications');

                // Set page url
                md_set_component_variable('contents_pagination_url', site_url('search-' . md_the_component_variable('contents_category') . '/' . md_the_component_variable('search_key') . '/page/')); 

            }

            // Set contents's display total
            md_set_component_variable('contents_display_total', $total);

        } else {

            // Set contents's display total
            md_set_component_variable('contents_display_total', 0);

        }

        // Gets contents_list's component variable
        return md_the_component_variable('contents_list');

    }

    /**
     * The public method the_content_meta_list gets single content meta list
     * 
     * @param string $meta_name contains the meta's name
     * @param string $language contains the language
     * 
     * @since 0.0.8.1
     * 
     * @return array with meta's value or boolean false
     */
    public function the_content_meta_list($meta_name, $language = NULL) {

        $list = md_the_single_content_meta($meta_name, $language);

        $array = array();

        if ( $list ) {

            $list_dec = unserialize($list);

            if ( $list_dec ) {

                $row = 0;

                for ( $l = 0; $l < count($list_dec); $l++ ) {

                    if ( $list_dec[$l]['meta'] === $list_dec[0]['meta'] && $l > 0 ) {
                        $row++;
                    }

                    $array[$row][$list_dec[$l]['meta']] = $list_dec[$l]['value'];

                }

            }

        }

        if ( $array ) {
            return $array;
        } else {
            return false;
        }

    }

}
