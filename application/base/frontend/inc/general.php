<?php
/**
 * General Themes Inc
 *
 * This file contains the general themes functions
 * used in the themes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Contents as CmsBaseClassesContents;
use CmsBase\Frontend\Classes as CmsBaseFrontendClasses;

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_the_contents_list') ) {
    
    /**
     * The function md_the_contents_list gets the contents's list
     * 
     * @param array $args contains the arguments to request
     * 
     * @since 0.0.8.1
     * 
     * @return object with contents list or boolean false
     */
    function md_the_contents_list($args = array()) {

        // Get the contents list
        return (new CmsBaseFrontendClasses\Contents)->the_contents_list($args);
        
    }
    
}

if ( !function_exists('md_trim_content') ) {
    
    /**
     * The function md_trim_content shorts contents
     * 
     * @param string $content contains the string
     * @param integer $length contains the string length
     * 
     * @since 0.0.8.5
     * 
     * @return object with content
     */
    function md_trim_content($content, $length) {

        // Short content
        return (new CmsBaseFrontendClasses\Contents)->trim_content($content, $length);
        
    }
    
}

if ( !function_exists('md_the_date') ) {
    
    /**
     * The function md_the_date formates the timestamp to date
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with date or boolean false
     */
    function md_the_date($params) {

        // Format the date
        return (new CmsBaseFrontendClasses\Datetime)->the_date($params);
        
    }
    
}

if ( !function_exists('md_the_theme_path') ) {
    
    /**
     * The function md_the_theme_path gets the theme path
     * 
     * @since 0.0.7.8
     * 
     * @return string with theme path
     */
    function md_the_theme_path() {
        
        // Gets the theme_path's component variable
        return md_the_data('theme_path');
        
    }
    
}

if ( !function_exists('md_the_theme_uri') ) {
    
    /**
     * The function md_the_theme_uri gets the theme's uri
     * 
     * @since 0.0.7.8
     * 
     * @return string with theme's uri
     */
    function md_the_theme_uri() {
        
        // Gets the theme's uri
        return str_replace(array(APPPATH, '_'), array( base_url() . 'assets/', '-'), md_the_data('theme_path') );
        
    }
    
}

if ( !function_exists('md_the_theme_template_load') ) {
    
    /**
     * The function md_the_theme_template_load loads the theme template if exists
     * 
     * @param string $contents_template contains the template's slug
     * 
     * @since 0.0.7.8
     * 
     * @return string with template path or boolean false
     */
    function md_the_theme_template_load($contents_template) {

        // Load the theme's template file
        if (file_exists(md_the_theme_path() . $contents_template . '.php')) {

            return md_the_theme_path() . $contents_template . '.php';

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_the_content_meta') ) {
    
    /**
     * The function md_the_content_meta gets single content meta
     * 
     * @param string $meta_name contains the meta's name
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with meta's value or boolean false
     */
    function md_the_content_meta($meta_name, $language = NULL) {

        return md_the_single_content_meta($meta_name, $language);
        
    }
    
}

if ( !function_exists('md_the_content_created_time') ) {
    
    /**
     * The function md_the_content_created_time gets the created time
     * 
     * @since 0.0.8.5
     * 
     * @return string with content
     */
    function md_the_content_created_time() {

        return md_the_date(array('time' => md_the_single_content_info('created'), 'format' => '1'));
        
    }
    
}

if ( !function_exists('md_the_content_meta_list') ) {
    
    /**
     * The function md_the_content_meta_list gets single content meta list
     * 
     * @param string $meta_name contains the meta's name
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return array with meta's value or boolean false
     */
    function md_the_content_meta_list($meta_name, $language = NULL) {

        // Get the contents meta
        return (new CmsBaseFrontendClasses\Contents)->the_content_meta_list($meta_name, $language);
        
    }
    
}

if ( !function_exists('md_the_classification') ) {
    
    /**
     * The function md_the_classification gets classification's items by slug
     * 
     * @param array $args contains the query arguments
     * 
     * @since 0.0.7.8
     * 
     * @return array with classification's items or boolean false 
     */
    function md_the_classification($args) {

        // Require the Read Menu Inc file
        require_once APPPATH . 'base/inc/menu/read_menu.php';

        // Classification's items
        return md_the_contents_classification($args);
        
    }
    
}

if ( !function_exists('md_the_url_by_page_role') ) {
    
    /**
     * The function md_the_url_by_page_role gets the page url by role
     * 
     * @param string $type contains the role
     * 
     * @since 0.0.7.8
     * 
     * @return string with url or boolean false
     */
    function md_the_url_by_page_role($type) {

        // Get codeigniter object instance
        $CI =& get_instance();

        // Get selected pages
        $selected_pages = md_the_data('selected_pages_by_role');

        if ( !$selected_pages ) {

            // Get selected pages by role
            $selected_pages = $CI->base_contents->the_contents_by_meta_name('selected_page_role');

            // Set pages
            md_set_data('selected_pages_by_role', $selected_pages);
        
        }

        if ( $selected_pages ) {

            foreach ( $selected_pages as $selected_page ) {

                if ( $selected_page->meta_value === 'settings_auth_' . $type . '_page' ) {

                    return site_url($selected_page->contents_slug);

                }

            }

        }

        return false;
        
    }
    
}

if ( !function_exists('md_start_form') ) {
    
    /**
     * The function md_start_form starts form
     * 
     * @param string $url contains the form's url
     * @param array $args contains the form's parameters
     * 
     * @since 0.0.7.8
     * 
     * @return string with form data
     */
    function md_start_form($url, $args) {

        // Get the instance
        $CI =& get_instance();

        // CSRF token
        $args['data-csrf'] = $CI->security->get_csrf_token_name();

        return form_open($url, $args);
        
    }
    
}

if ( !function_exists('md_the_content_id') ) {
    
    /**
     * The function md_the_content_id gets the content's ID
     * 
     * @since 0.0.7.8
     * 
     * @return integer with content's ID or boolean false
     */
    function md_the_content_id() {

        return md_the_data('content_id');
        
    }
    
}

if ( !function_exists('md_the_content_url') ) {
    
    /**
     * The function md_the_content_url returns the content's url
     * 
     * @since 0.0.7.9
     * 
     * @return string with url or boolean false
     */
    function md_the_content_url() {

        // Call the contents_read class
        $contents_read = (new CmsBaseClassesContents\Contents_read);

        // Verify if content exists
        if ( $contents_read::$the_single_content ) {
            return site_url($contents_read::$the_single_content[0]['contents_slug']);
        } else {
            return false;
        }
    
    }
    
}

if ( !function_exists('md_the_db_request') ) {
    
    /**
     * The function md_the_db_request makes requests to the database
     * 
     * @param string $table contains the database's table
     * @param string $select contains ceils to select
     * @param array $where contains where option
     * @param array $where_in contains where in parameters
     * @param array $like contains the like parameters
     * @param array $joins contains the tables to join
     * @param array $order_limit contains the order and limits parameters
     * 
     * @since 0.0.7.9
     * 
     * @return array with data or boolean false
     */
    function md_the_db_request($table, $select, $where=array(), $where_in=array(), $like=array(), $joins = array(), $order_limit = array()) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get category's childrens
        return $CI->base_model->the_data_where($table, $select, $where, $where_in, $like, $joins, $order_limit);

    }
    
}

if ( !function_exists('md_the_db_insert') ) {
    
    /**
     * The function md_the_db_insert adds new data in the database
     * 
     * @param string $table contains the database's table
     * @param array $args contains the array with arguments to insert
     * 
     * @since 0.0.8.1
     * 
     * @return integer with last inserted id or boolean false
     */
    function md_the_db_insert($table, $args) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Insert data
        return $CI->base_model->insert($table, $args);

    }
    
}

if ( !function_exists('md_the_db_update') ) {
    
    /**
     * The function md_the_db_update makes updates to the database
     * 
     * @param string $table contains the database's table
     * @param array $where contains where option
     * @param array $update contains array with params to update
     * 
     * @since 0.0.8.1
     * 
     * @return array with boolean true or false
     */
    function md_the_db_update($table, $where, $update) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Update
        return $CI->base_model->update($table, $where, $update);

    }
    
}

if ( !function_exists('md_the_pagination') ) {
    
    /**
     * The function md_the_pagination provides the information to generate the pagination
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.1
     * 
     * @return array with pagination's data
     */
    function md_the_pagination($params = array()) {

        // Get the pagination
        return (new CmsBaseFrontendClasses\Pagination)->the_pagination($params);
        
    }
    
}

if ( !function_exists('md_the_replacers') ) {
    
    /**
     * The function md_the_replacers replaces the placeholders
     * 
     * @param string $content contains the content
     * 
     * @since 0.0.8.1
     * 
     * @return string with content
     */
    function md_the_replacers($content) {

        // Get the replacers
        return (new CmsBaseFrontendClasses\Replacers)->the_replacers($content);
        
    }
    
}

if ( !function_exists('md_the_classification_breadcrumb') ) {
    
    /**
     * The function md_the_classification_breadcrumb generates the classification's breadcrumb
     * 
     * @since 0.0.7.9
     * 
     * @return array with items
     */
    function md_the_classification_breadcrumb() {

        // Get classification's breadcrumb
        return (new CmsBaseFrontendClasses\Breadcrumb)->the_classification_breadcrumb();
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_get_pagination') ) {
    
    /**
     * The function md_get_pagination displays the pagination
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    function md_get_pagination($params = array()) {

        // Display pagination
        (new CmsBaseFrontendClasses\Pagination)->get_pagination($params);
      
    }

}

if ( !function_exists('md_get_theme_part') ) {
    
    /**
     * The function md_get_theme_part gets the theme's part files
     * 
     * @param string $part contains the theme's part
     * @param string $directory contains the part's directory
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_theme_part($part, $directory='parts/') {

        // Load the theme's part file
        if (file_exists(md_the_theme_path() . 'contents/' . $directory . $part . '.php')) {

            require_once md_the_theme_path() . 'contents/' . $directory . $part . '.php';

        }
        
    }
    
}

if ( !function_exists('md_the_site_name') ) {
    
    /**
     * The function md_the_site_name gets the site's name from config
     * 
     * @since 0.0.8.5
     * 
     * @return string with site name
     */
    function md_the_site_name() {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        return $CI->config->item('site_name');
        
    }
    
}

if ( !function_exists('md_get_the_string') ) {
    
    /**
     * The function md_get_the_string gets the theme's string
     * 
     * @param string $string_key contains the key of the string
     * @param boolean $return contains the return status
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_string($string_key, $return=FALSE) {

        // Get the string
        $CI =& get_instance();

        if ( $CI->lang->line($string_key) ) {

            if ( $return ) {
                return $CI->lang->line($string_key);
            } else {

                echo $CI->lang->line($string_key);

            }

        }
        
    }
    
}

if ( !function_exists('md_get_the_language_file') ) {
    
    /**
     * The function md_get_the_language_file gets the language's file
     * 
     * @param string $dir_path contains the language's directory
     * @param string $file_name contains the language file name
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_the_language_file($dir_path, $file_name) {

        // Get the string
        $CI =& get_instance();

        // Load the language file
        if (file_exists($dir_path . $CI->config->item('language') . '/' . $file_name . '_lang.php')) {
            $CI->lang->load($file_name, $CI->config->item('language'), FALSE, TRUE, md_the_theme_path());
        }
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_set_replacer') ) {
    
    /**
     * The function md_set_replacer registers a replacer
     * 
     * @param string $slug contains the replacer's slug
     * @param function $function contains the function
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    function md_set_replacer($slug, $function) {

        // Get replacers
        $replacers = md_the_data('content_replacer');

        if ( !isset($replacers[$slug]) ) {

            $replacers[$slug] = $function;

            // Set the replacer
            md_set_data('content_replacer', $replacers);

        }
        
    }
    
}

/* End of file general.php */