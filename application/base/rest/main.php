<?php
/**
 * Midrub Base Rest
 *
 * This file loads the Midrub's Base Rest
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Rest;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_REST') OR define('MIDRUB_BASE_REST', APPPATH . 'base/rest/');

// Define the namespaces to use
use MidrubBase\Rest\Classes as MidrubBaseRestClasses;

// Require the general inc file
require_once MIDRUB_BASE_REST . 'inc/general.php';

/*
 * Main is the rest's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Main {

    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the rest language file
        $this->CI->lang->load('base_rest', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_REST);

        // Load Base Rest Model
        $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_rest', 'base_rest');

    }
    
    /**
     * The public method init loads the admin's components
     * 
     * @since 0.0.7.9
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * 
     * 
     * @return void
     */
    public function init( $static_slug, $dynamic_slug = NULL, $additional_slug=NULL ) {

        // Load the REST's class
        if ( ( $static_slug === 'oauth2' ) && ( $dynamic_slug === 'authorize' ) ) {

            // Load the REST's authorize class 
            (new MidrubBaseRestClasses\Authorize())->init();            

        } else if ( ( $static_slug === 'oauth2' ) && ( $dynamic_slug === 'token' ) ) {

            // Load the REST's token class 
            (new MidrubBaseRestClasses\Token())->init();

        }  else if ( ( $static_slug === 'rest-app' ) && !empty($dynamic_slug) && !empty($additional_slug) ) {

            // Load the App REST's method class 
            (new MidrubBaseRestClasses\App_rest())->init($dynamic_slug, $additional_slug);

        } else {

            // Display the 404 error
            show_404();

        }
        
    }

}

/* End of file main.php */