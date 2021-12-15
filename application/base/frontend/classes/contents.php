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
namespace CmsBase\Frontend\Classes;

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
     * @param array $params contains the arguments to request
     * 
     * @since 0.0.8.1
     * 
     * @return object with contents list or boolean false
     */
    public function the_contents_list($params = array()) {

        // Verify if contents list exists
        if ( md_the_data('contents_list') ) {

            // Gets contents_list's component variable
            return md_the_data('contents_list');

        }

        // Set the limit
        $limit = 20;

        // Verify if limit exists
        if ( isset($params['limit']) ) {

            // Set limit
            $limit = $params['limit'];

        }

        // Set contents's display limit
        md_set_data('contents_display_limit', $limit);

        // Set page
        $page = md_the_data('page')?(md_the_data('page') - 1):0;
        
        if ( isset($params['page']) ) {
            if ( is_numeric($params['page']) ) {
                md_set_data('page', $params['page']);
                $page = ($params['page'] - 1);
            }
        }

        // Get the instance
        $CI =& get_instance();

        // Params to request
        $r_params = array(
            'start' => $page?(($params['page'] - 1) * $limit):0,
            'limit' => $limit
        );


        // Set classification's ID
        $classification_id = md_the_data('classification_item_id');

        // Verify if classification's ID exists
        if ( isset($params['classification_id']) ) {

            // Set classification's ID
            $r_params['classification_value'] = $params['classification_id'];

        } else if ( $classification_id ) {

            // Set classification's ID
            $r_params['classification_value'] = md_the_data('classification_item_id');
            
        } else if ( isset($params['classification_slug']) ) {

            // Set classification's slug
            $r_params['classification_slug'] = $params['classification_slug'];
            
        }

        // Verify if contents category exists
        if ( isset($params['contents_category']) ) {

            // Set contents category
            $r_params['contents_category'] = $params['contents_category'];

        }        

        // Verify if classification's metas exists
        if ( isset($params['content_metas']) ) {

            // Set classification's metas
            $r_params['content_metas'] = $params['content_metas'];

        }  
        
        // Verify if content's body exists
        if ( isset($params['content_body']) ) {

            // Set content's body
            $r_params['content_body'] = $params['content_body'];

        }          

        // Verify if is search
        if ( md_the_data('search_key') ) {

            $r_params['key'] = preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9 -]+#'), array('-', ''), md_the_data('search_key'));

        }

        // Get contents by page
        $contents = $CI->base_contents->the_contents($r_params, 'classifications');

        // Set contents's list
        md_set_data('contents_list', $contents);

        // Verify if contents exists
        if ( $contents ) {

            unset($r_params['start']);
            unset($r_params['limit']);

            // Verify for classification
            if ( isset($r_params['classification_value']) ) {

                // Get total contents
                $total = $CI->base_contents->the_contents($r_params, 'classifications');

                // Set page url
                md_set_data('contents_pagination_url', site_url($contents[0]['classification_slug'] . '/' . $contents[0]['classification_meta_slug'] . '/page/')); 
                
            } else {

                // Get total contents
                $total = $CI->base_contents->the_contents($r_params, 'classifications');

                // Set page url
                md_set_data('contents_pagination_url', site_url('search-' . md_the_data('contents_category') . '/' . md_the_data('search_key') . '/page/')); 

            }

            // Set contents's display total
            md_set_data('contents_display_total', $total);

        } else {

            // Set contents's display total
            md_set_data('contents_display_total', 0);

        }

        // Gets contents_list's component variable
        return md_the_data('contents_list');

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

    /**
     * The public method trim_content shorts contents
     * 
     * @param string $content contains the string
     * @param integer $length contains the string length
     * 
     * @since 0.0.8.5
     * 
     * @return string with content
     */
    public function trim_content($content, $length) {

        return mb_strimwidth($content, 0, $length, '...');
        
    }

}

/* End of file contents.php */