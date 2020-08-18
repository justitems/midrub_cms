<?php
/**
 * Midrub Base
 *
 * This file loads the Midrub's Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_PATH') OR define('MIDRUB_BASE_PATH', APPPATH . 'base/');

// Require the autoload's plugin file
require_once MIDRUB_BASE_PATH . 'autoload.php';

// Require the General Inc
require_once MIDRUB_BASE_PATH . 'inc/general.php';

// Require the Additional Inc
require_once MIDRUB_BASE_PATH . 'inc/additional.php';

// Define the namespaces to use
use MidrubBase\User\Main as MidrubBaseUserMain;

/*
 * MidrubBase is the base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class MidrubBase {

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI, $base_sections = array(
        'admin',
        'user',
        'auth',
        'frontend'
    );

    /**
     * Initialise the Class
     * 
     * @param $category contains the hooks category
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     *
     * @since 0.0.7.8
     */
    public function __construct($category, $static_slug=NULL, $dynamic_slug=NULL) {

        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Base Model
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_model', 'base_model' );

        // Load Base Contents Model
        $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents');

        // Verify if username exists
        if ( isset( $this->CI->session->userdata['username'] ) ) {

            // Load Base Model
            $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_users', 'base_users');

            // Get user data
            $user_data = $this->CI->base_users->get_user_data_by_username($this->CI->session->userdata['username']);

            // Verify if user exists
            if ( $user_data ) {

                // Set user data
                md_set_component_variable('user_data', (array)$user_data[0]);

                // Set user_id
                $this->CI->user_id = $user_data[0]->user_id;

                // Set user_role
                $this->CI->user_role = $user_data[0]->role;

                // Set user_status
                $this->CI->user_status = $user_data[0]->status;

                // Get user language
                $user_lang = get_user_option('user_language');

                // Verify if user has selected a language
                if ($user_lang) {
                    md_set_config_item('language', $user_lang);
                }       

            }
            
        } else {

            // Require the inc file
            require_once APPPATH . 'base/inc/translation/general.php';

            // Set language
            md_set_language();

        }

        // Load hooks by category
        $this->load_hooks($category, $static_slug, $dynamic_slug);

        // Get hooks category
        if ( $category === "admin_init" ) {

            // Require the dashboard inc file
            require_once APPPATH . 'base/inc/dashboard/general.php';

        }
        
    }
    
    /**
     * The public method init loads the base's components
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * 
     * @since 0.0.7.8
     * 
     * 
     * @return void
     */
    public function init($static_slug=NULL, $dynamic_slug=NULL, $additional_slug=NULL) {

        // Create an array
        $array = array(
            'MidrubBase',
            ucfirst($static_slug),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);
        
        // Instantiate the section's init
        (new $cl())->init($dynamic_slug, $additional_slug);

    }
    
    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @param string $type contains the component's type
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function ajax_init($type, $component) {

        // Create an array
        $array = array(
            'MidrubBase',
            ucfirst($type),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\',$array);      
        
        // Instantiate the section's ajax controller
        (new $cl())->ajax_init($component);
        
    }

    /**
     * The public method rest_init processes the rest's calls
     * 
     * @since 0.0.7.8
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * 
     * @return void
     */
    public function rest_init($static_slug=NULL, $dynamic_slug=NULL, $additional_slug=NULL) {

        // Create an array
        $array = array(
            'MidrubBase',
            'Rest',
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Default $method value
        $method = '';

        // Detect $method's value
        switch ( $static_slug ) {
            case 'oauth2':
                $method = 'init';
            break;
            case 'rest-app':
                $method = 'init';
            break;
            default:
                show_404();
            break;            
        }
        
        // Instantiate the component's view
        (new $cl())->$method($static_slug, $dynamic_slug, $additional_slug);
        
    }

    /**
     * The public method guest loads the guest's method
     * 
     * @param string $dynamic_slug contains a dynamic url's slug
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function guest($dynamic_slug) {

        // Load guest method
        (new MidrubBaseUserMain())->guest($dynamic_slug);

    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.7.8
     * 
     * @param string $category contains the hooks category
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * @return void
     */
    public function load_hooks($category, $static_slug=NULL, $dynamic_slug=NULL) {

        // Set component
        if ( $dynamic_slug ) {

            // Set current component
            md_set_component_variable('component', $dynamic_slug);

        } else {

            // Set current component
            md_set_component_variable('component', $static_slug);

        }

        // List all base's sections
        foreach ($this->base_sections as $section) {

            if ( ( $section === 'user' ) &&  ( $category === 'frontend_init' ) ) {
                continue;
            } else if ( ( $section === 'frontend' ) &&  ( $category === 'user_init' ) ) {
                continue;
            }

            // Create an array
            $array = array(
                'MidrubBase',
                ucfirst($section),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Register hooks
            (new $cl())->load_hooks($category);

        }

    }
    
}

/* End of file main.php */