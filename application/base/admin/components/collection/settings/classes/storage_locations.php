<?php
/**
 * Storage Locations Class
 *
 * This file loads the Storage_locations Class with properties used to displays storage's locations
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */

// Define the location namespace
namespace CmsBase\Admin\Components\Collection\Settings\Classes;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Storage_locations class loads the general properties used to displays storage's locations
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */
class Storage_locations {
    
    /**
     * Contains and array with saved locations
     *
     * @since 0.0.8.4
     */
    public static $the_locations = array(); 

    /**
     * The public method set_location adds location
     * 
     * @param string $location_slug contains the location's slug
     * @param array $args contains the location's arguments
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function set_location($location_slug, $args) {

        // Verify if the location has valid fields
        if ( $location_slug && isset($args['location_name']) && isset($args['location_icon']) ) {

            // Set the location in the queue
            self::$the_locations[][$location_slug] = $args;
            
        }

    } 

    /**
     * The public method the_locations returns all locations
     * 
     * @since 0.0.8.4
     * 
     * @return array with locations or boolean false
     */
    public function the_locations() {

        // Verify if locations exists
        if ( self::$the_locations ) {

            // Set all locations
            return self::$the_locations;

        } else {

            return false;

        }

    }

}

/* End of file storage_locations.php */