<?php
/**
 * Options Class
 *
 * This file loads the Options Class with properties used to display plans options in the admin panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Classes\Plans;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Options class loads the properties used to display plans options in the admin panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Options {
    
    /**
     * Contains and array with saved options
     *
     * @since 0.0.7.9
     */
    public static $the_options = array(); 

    /**
     * The public method set_options adds a collection with options to the list
     * 
     * @param array $params contains the page's arguments
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_options($params) {

        // Verify if collection with options is valid
        if ( isset($params['name']) && isset($params['slug']) && isset($params['icon']) && isset($params['fields']) ) {

            // Add options to the list
            self::$the_options[] = $params;

        }

    } 

    /**
     * The public method load_options loads all apps options
     * 
     * @since 0.0.7.9
     * 
     * @return array with options or boolean false
     */
    public function load_options() {

        // Verify if options exists
        if ( self::$the_options ) {

            return self::$the_options;

        } else {

            return false;

        }

    }

}

/* End of file options.php */