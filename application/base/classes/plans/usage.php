<?php
/**
 * Usage Class
 *
 * This file loads the Usage Class with properties used to display plan's usage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Classes\Plans;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Usage class loads the properties used to display plan's usage
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Usage {
    
    /**
     * Contains and array with saved usage
     *
     * @since 0.0.8.0
     */
    public static $the_usage = array(); 

    /**
     * The public method set_usage adds a collection with plan's usage to the list
     * 
     * @param array $args contains the plan's usage
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function set_usage($args) {

        if ( $args ) {

            foreach ( $args as $arg ) {

                // Verify if collection with plan's usage is valid
                if ( isset($arg['name']) && isset($arg['value']) && isset($arg['limit']) && isset($arg['left']) ) {

                    // Add usage to the list
                    self::$the_usage[] = $arg;

                }

            }

        }

    } 

    /**
     * The public method load_usage loads all apps usage
     * 
     * @since 0.0.8.0
     * 
     * @return array with usage or boolean false
     */
    public function load_usage() {

        // Verify if usage exists
        if ( self::$the_usage ) {

            return self::$the_usage;

        } else {

            return false;

        }

    }

}

/* End of file usage.php */