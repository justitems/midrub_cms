<?php
/**
 * Rest Permissions Class
 *
 * This file loads the Permissions Class with properties used to process the Api's permissions
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Classes\Rest;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Permissions class loads the properties used to process the Api's permissions
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
     * @param array $params contains the api's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_permissions($params) {

        // Verify if options exists
        if ( $params ) {
            
            // Verify for required parameters
            if ( !empty($params['permission_slug']) && !empty($params['permission_name']) && !empty($params['permission_description']) && !empty($params['permission_allow_text']) ) {

                // Set permission
                self::$the_permissions[] = $params;

            }

        }

    } 

    /**
     * The public method load_permissions loads all permissions
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