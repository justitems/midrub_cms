<?php
/**
 * Midrub Base Auth
 *
 * This file loads the Midrub's Auth Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_AUTH') OR define('MIDRUB_BASE_AUTH', APPPATH . 'base/auth/');

// Require the contents_read function file
require_once APPPATH . 'base/inc/contents/contents_read.php';

// Require the auth contents functions file
require_once MIDRUB_BASE_PATH . 'auth/inc/contents/contents.php';

// Require the auth general functions file
require_once MIDRUB_BASE_PATH . 'auth/inc/general.php';

/*
 * Main is the auth's base loader
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
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the language files
        if ( file_exists( MIDRUB_BASE_AUTH . '/language/' . $this->CI->config->item('language') . '/auth_lang.php' ) ) {
            $this->CI->lang->load( 'auth', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH . '/' );
        }
        
    }
    
    /**
     * The public method init loads the auth's components
     * 
     * @since 0.0.7.8
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * 
     * @return void
     */
    public function init($static_slug, $dynamic_slug) {

        // If $dynamic_slug is null, show 404
        if ( !$dynamic_slug ) {
            show_404();
        }

        // Default component value
        $component = $dynamic_slug;

        // Get page component by page slug
        $get_component = $this->CI->base_model->get_data_where('contents', 'content_id, contents_component', array('contents_slug' => 'auth/' . $component));

        // Verify if the component was found
        if ( $get_component ) {

            // Set component
            $component = $get_component[0]['contents_component'];

        }

        // Prepare the component
        $component = str_replace('-', '_', $component);

        // Verify if component exists
        if ( !is_dir( APPPATH . 'base/auth/collection/' . $component ) ) {

            // Display 404 page
            show_404();

        }

        // Set current component
        md_set_component_variable('component', $component);

        // Verify which component we have
        switch ( $component ) {

            case 'signup':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_sign_up_page');  

                break;

            case 'signin':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_sign_in_page');  

                break;

            case 'reset':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_reset_password_page');  

                break;

            case 'upgrade':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_upgrade_page');  

                break;

            case 'change_password':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_change_password_page');  

                break;
                
            case 'confirmation':

                // Load component
                $this->load_component($component, 'init', 'settings_auth_confirmation_page');  

                break;

            default:

                // Load component based on content's id
                $this->load_component_by_content_id($component, $get_component[0]['content_id']);  

                break;

        }
        
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

        // Verify which component we have
        switch ( $component ) {

            case 'signup':

                // Load component
                $this->load_component($component, 'ajax', 'settings_auth_sign_up_page');  

                break;

            case 'signin':

                // Load component
                $this->load_component($component, 'ajax', 'settings_auth_sign_in_page');  

                break;

            case 'reset':

                // Load component
                $this->load_component($component, 'ajax', 'settings_auth_reset_password_page');  

                break; 

            case 'confirmation':

                // Load component
                $this->load_component($component, 'ajax', 'settings_auth_confirmation_page');  

                break;

            default:

                // Load component
                $this->load_component($component, 'ajax');  

                break;

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

        // Register all auth components hooks
        foreach (glob(MIDRUB_BASE_PATH . 'auth/collection/*', GLOB_ONLYDIR) as $dir) {

            // Get the dir name
            $com_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'Auth',
                'Collection',
                ucfirst($com_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Register hooks
            (new $cl())->load_hooks($category);

        }

    }

    /**
     * The private method load_component loads an auth component based on parameters
     * 
     * @since 0.0.7.8
     * 
     * @param string $component contains the component's name
     * @param string $method contains the component's method
     * @param string $role_value contains the role of the page
     * 
     * @return void
     */
    public function load_component($component, $method, $role_value=null) {

        // Verify if $role_value is not value
        if ($role_value) {

            // Get page if exists
            $page = the_selected_page_by_role('selected_page_role', $role_value);

            // Verify if page exists
            if ($page) {

                // Set content value
                md_set_single_content($page);

                // Set new component's value
                $component = $page[0]['contents_component'];

            }

        }

        // Create an array
        $array = array(
            'MidrubBase',
            'Auth',
            'Collection',
            ucfirst($component),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Instantiate the component's view
        (new $cl())->$method();
        
    }
    
    /**
     * The private method load_component_by_content_id
     * 
     * @since 0.0.7.8
     * 
     * @param string $component contains the component's name
     * @param integer $content_id contains the content's id
     * 
     * @return void
     */
    public function load_component_by_content_id($component, $content_id) {

        // Get content by content's ID
        $get_content = md_the_single_content($content_id);

        // Verify if content exists
        if ( $get_content ) {

            // Set content value
            md_set_single_content($get_content);

        } else {

            // Display 404 page
            show_404();

        }

        // Create an array
        $array = array(
            'MidrubBase',
            'Auth',
            'Collection',
            ucfirst($component),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Instantiate the component's view
        (new $cl())->init();
        
    }
    
}

/* End of file main.php */