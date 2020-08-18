<?php
/**
 * Midrub Base Admin
 *
 * This file loads the Midrub's Admin Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin;

// Define the namespaces to use
use MidrubBase\Classes as MidrubBaseClasses;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_ADMIN') OR define('MIDRUB_BASE_ADMIN', APPPATH . 'base/admin/');

// Require the general functions file
require_once MIDRUB_BASE_ADMIN . 'inc/general.php';

/*
 * Main is the admin's base loader
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

    }
    
    /**
     * The public method init loads the admin's components
     * 
     * @since 0.0.7.8
     * 
     * @param string $static_slug contains static url's slug
     * @param string $component contains the component's name
     * 
     * 
     * @return void
     */
    public function init($static_slug, $component=NULL) {

        // If $component is null, show 404
        if ( !$component ) {
            show_404();
        }

        // Verify if user is admin
        if ( $this->CI->user_role !== '1' ) {
            redirect('/');
        }

        // Load Admin Helper
        $this->CI->load->helper('admin_helper');

        // Set current component
        md_set_component_variable('component', $component);

        // Load component
        $this->load_component($component, 'init');
        
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

        // Verify if user is admin
        if ( $this->CI->user_role !== '1' ) {
            exit();
        }

        // Load component
        $this->load_component($component, 'ajax');
        
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

        // Load required language files
        $this->CI->lang->load( 'default_admin', $this->CI->config->item('language') );
        $this->CI->lang->load( 'default_alerts', $this->CI->config->item('language') );

        if ( $category === 'admin_init' ) {

            // Include plans options
            require_once MIDRUB_BASE_PATH . 'inc/plans/options.php'; 

        }

        // Register all admin components hooks
        foreach (glob(MIDRUB_BASE_ADMIN . 'collection/*', GLOB_ONLYDIR) as $dir) {

            // Get the dir name
            $com_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'Admin',
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
     * The private method load_component loads an admin component based on parameters
     * 
     * @since 0.0.7.8
     * 
     * @param string $component contains the component's name
     * @param string $method contains the component's method
     * 
     * @return void
     */
    public function load_component($component, $method) {

        // Run the administrator's hooks
        md_run_hook('admin_init', array());

        // Create an array
        $array = array(
            'MidrubBase',
            'Admin',
            'Collection',
            ucfirst($component),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        if ( is_dir(MIDRUB_BASE_ADMIN . 'collection/' . $component . '/') ) {

            // Instantiate the component's view
            (new $cl())->$method();

        } else {

            // Display 404 page
            show_404();
            
        }
        
    }    
    
}

/* End of file main.php */