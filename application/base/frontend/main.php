<?php
/**
 * Midrub Base Frontend
 *
 * This file loads the Midrub's Frontend Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Frontend;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_FRONTEND') OR define('CMS_BASE_FRONTEND', APPPATH . 'base/frontend/');

// Require the General Themes Inc file
require_once CMS_BASE_FRONTEND . 'inc/general.php';

// Require the General Frontend Inc file
require_once CMS_BASE_PATH . 'inc/auth/general.php';

/*
 * Main is the frontend's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Main {

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI, $templates_dir = 'templates';

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
     * The public method init loads the frontend's theme
     * 
     * @since 0.0.7.8
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * 
     * @return void
     */
    public function init($static_slug=NULL, $dynamic_slug=NULL) {

        // Load the component's language files
        $this->CI->lang->load( 'frontend_default', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_FRONTEND );

        if ( $static_slug && md_the_data('theme_path') ) {

            // Verify if $dynamic_slug is not null
            if ( $dynamic_slug ) {
                $url_slug = $static_slug . '/' . $dynamic_slug;
                $this->templates_dir = $static_slug;
            } else {
                $url_slug = $static_slug;
            }

            // Return content by content's ID
            $content = $this->CI->base_contents->the_content('', $url_slug);

            if ($content) {

                if ( md_the_option('settings_home_page') !== $content[0]['content_id'] ) {

                    // Set the content's ID
                    md_set_data('content_id', $content[0]['content_id']); 

                    // Load template
                    $this->load_template($content, 'templates');

                } else {

                    // Redirect to home page
                    redirect('/');

                }

            }

            // Verify $static_slug is search
            if ( strpos($static_slug, 'search-') !== false ) {

                if ( $dynamic_slug ) {

                    $contents_category = str_replace('search-', '', $static_slug);

                    if ( file_exists(md_the_data('theme_path') . 'contents/' . $contents_category . '/search.php') ) {
        
                        // Set the content's category
                        md_set_data('contents_category', $contents_category);

                        // Set the search's key
                        md_set_data('search_key', $this->CI->security->xss_clean($dynamic_slug));

                        // Get contents by page
                        $this->load_template('', 'search');
        
                    }

                }
                
            } else if ( file_exists(md_the_data('theme_path') . 'contents/classifications/' . $static_slug . '.php') ) {

                // Load Base Classification Model
                $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_classifications', 'base_classifications');

                // Get classification's item
                $item = md_the_db_request(
                    'classifications',
                    'classifications.classification_id, classifications.classification_parent, classifications_meta.meta_value as name',
                    array(
                        'classifications_meta.meta_slug' => $dynamic_slug,
                        'classifications_meta.meta_name' => 'name',
                        'classifications.classification_type' => 'contents_classification'
                    ),
                    array(),
                    array(),
                    array(
                        array(
                            'table' => 'classifications_meta',
                            'condition' => 'classifications.classification_id=classifications_meta.classification_id',
                            'join_from' => 'LEFT'
                        )
                    )
                );

                // Require the Classifications Themes Inc file
                require_once CMS_BASE_FRONTEND . 'inc/classifications.php';

                if ($item) {

                    // Set the static's slug
                    md_set_data('classification_slug', $static_slug);

                    // Set the item's slug
                    md_set_data('classification_item_slug', $dynamic_slug);

                    // Set the item's id
                    md_set_data('classification_item_id', $item[0]['classification_id']);

                    // Set the item's parent
                    md_set_data('classification_item_name', $item[0]['name']);

                    // Set the item's parent
                    md_set_data('classification_item_parent', $item[0]['classification_parent']);

                    // Get contents by page
                    $this->load_template('', 'classifications');

                }

            }

        } else {

            // Get selected page by role
            $selected_page = $this->CI->base_contents->the_contents_by_meta_name('selected_page_role', 'settings_home_page');

            // Verify if page exists
            if ($selected_page && md_the_data('theme_path') ) {

                // Return content by content's ID
                $content = $this->CI->base_contents->the_content($selected_page[0]['content_id']);

                if ($content) {

                    // Set the content's ID
                    md_set_data('content_id', $content[0]['content_id']); 

                    // Load template
                    $this->load_template($content, 'templates');

                }

            } else {

                // Redirect to sign in page
                redirect(md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin'));

            }

        }

        // Display 404 page
        show_404();
        
    }
    
    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @since 0.0.7.8
     * 
     * @param string $component contains the base's component
     * 
     * @return void
     */
    public function ajax_init($component) {

        // Get activated theme's slug
        $theme_slug = str_replace('-', '_', md_the_option('themes_enabled_theme'));

        // Verify if a theme is enabled
        if ($theme_slug) {

            // Verify if theme's ajax
            if ( is_dir(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/core/ajax/') ) {

                // Require the theme's ajax
                foreach (glob(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/core/ajax/' . '*.php') as $filename) {
                    require_once $filename;
                }

                // Get action's get input
                $action = $this->CI->input->get('action');

                if (!$action) {
                    $action = $this->CI->input->post('action');
                }

                try {

                    // Call function if exists
                    $action();
        
                } catch (Exception $ex) {
        
                    $data = array(
                        'success' => FALSE,
                        'message' => $ex->getMessage()
                    );
        
                    echo json_encode($data);
        
                }

            }

        }
        
    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.7.8
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the create menu inc file
        require_once CMS_BASE_PATH . 'inc/menu/create_menu.php';        

        // Get activated theme's slug
        $theme_slug = str_replace('-', '_', md_the_option('themes_enabled_theme'));

        // Verify if a theme is enabled
        if ($theme_slug) {

            // Set the theme's path
            md_set_data('theme_path', CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/'); 

            // Verify if the theme has language files
            if (is_dir(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/language/' . $this->CI->config->item('language') . '/')) {

                // Load all language files
                foreach (glob(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/language/' . $this->CI->config->item('language') . '/' . '*.php') as $filename) {

                    $this->CI->lang->load( str_replace(array(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/language/' . $this->CI->config->item('language') . '/', '_lang.php'), '', $filename), $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/' );

                }

            }

            // Load hooks by category
            switch ($category) {

                case 'admin_init':

                    if (file_exists(CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/core/hooks/admin_init.php')) {

                        // Require the admin's hooks file
                        require_once CMS_BASE_FRONTEND . 'themes/collection/' . $theme_slug . '/core/hooks/admin_init.php';
                    }

                    break;
                    
            }
            
        }

    }

    /**
     * The public method load_template loads theme's template
     * 
     * @param object $content contains the content's object
     * @param string $type contains the template's type
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function load_template($content, $type) {

        // Require the Menu Inc file
        require_once CMS_BASE_FRONTEND . 'inc/menu.php';

        if ( $type === 'templates' ) {
            md_set_single_content($content);
        }

        // Load theme's inc files
        if ( is_dir(md_the_data('theme_path') . 'core/inc/') ) {

            foreach ( glob(md_the_data('theme_path') . 'core/inc/*.php') as $filename ) {
                require_once $filename;
            }
            
        }

        switch ( $type ) {

            case 'search':

                // Set the title
                md_set_the_title(str_replace('-', ' ', md_the_data('search_key')));

                // Load search's template
                $template_path = md_the_theme_template_load('contents/' . md_the_data('contents_category') . '/search');

                if ( $template_path ) {

                    require_once $template_path;
                    exit();

                }

                break;

            case 'templates':

                // Load theme template
                $template_path = md_the_theme_template_load('contents/' . $this->templates_dir . '/' . $content[0]['contents_template']);

                if ($template_path) {

                    require_once $template_path;
                    exit();
                    
                }

                break;

            case 'classifications':

                // Load classification's template
                $template_path = md_the_theme_template_load('contents/classifications/' . md_the_data('classification_slug'));

                if ($template_path) {

                    require_once $template_path;
                    exit();

                }

                break;

        }

    }
    
}

/* End of file main.php */