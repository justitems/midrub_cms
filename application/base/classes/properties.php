<?php
/**
 * Properties Class
 *
 * This file loads the Properties Class with properties used in the base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Properties class loads the general properties used in the base components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Properties {
    
    /**
     * Contains and array with one value
     *
     * @since 0.0.7.8
     */
    public static $the_single_property = array();    

    /**
     * Contains and array with multiple values
     *
     * @since 0.0.7.8
     */
    public static $the_multilpe_properties = array();

    /**
     * The public method set_the_single_property sets one value for a key
     * 
     * @param string $key contains the key
     * @param string $value contains the value
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_the_single_property($key, $value) {

        self::$the_single_property[$key] = $value;

    }   

    /**
     * The public method set_the_multiple_properties sets multiple values for a key
     * 
     * @param string $key contains the key
     * @param string $value contains the value
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_the_multiple_properties($key, $value) {

        if ( !isset(self::$the_multilpe_properties[$key]) ) {
            self::$the_multilpe_properties[$key] = array();
        }

        self::$the_multilpe_properties[$key][] = $value;

    }  

}
