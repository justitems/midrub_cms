<?php
/**
 * Permissions Class
 *
 * This file loads the Permissions Class with properties used for team
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Classes\Team;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Permissions class loads the properties used for team
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Permissions {
    
    /**
     * Contains and array with saved permissions
     *
     * @since 0.0.7.9
     */
    public static $the_permissions = array(); 

    /**
     * The public method set_permissions adds a collection with permissions to the list
     * 
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_permissions($args) {

        // Verify if collection with permissions is valid
        if ( isset($args['name']) && isset($args['slug']) && isset($args['icon']) && isset($args['fields']) ) {

            // Add permissions to the list
            self::$the_permissions[] = $args;

        }

    } 

    /**
     * The public method load_permissions loads all team's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return array with permissions or boolean false
     */
    public function load_permissions() {

        // Verify if permissions exists
        if ( self::$the_permissions ) {

            return self::$the_permissions;

        } else {

            return false;

        }

    }

}

/* End of file permissions.php */