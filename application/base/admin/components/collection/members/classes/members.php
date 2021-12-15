<?php
/**
 * Members Class
 *
 * This file loads the Members class with methods to register the fields
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Members class loads the properties used to collect the members fields for the Members component
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.5
 */
class Members {
    
    /**
     * Contains and array with saved fields
     *
     * @since 0.0.8.5
     */
    public static $the_fields = array(); 

    /**
     * The public method set_field registers a members field
     * 
     * @param array $params contains the contents field's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function set_field($params) {

        // Verify if the field has valid parameters
        if ( isset($params['field_slug']) && isset($params['field_type']) ) {

            self::$the_fields[] = $params;
            
        }

    }

    /**
     * The public method the_fields gets all members fields
     * 
     * @since 0.0.8.5
     * 
     * @return array with fields or boolean false
     */
    public function the_fields() {

        // Verify if fields exists
        if ( self::$the_fields ) {

            return self::$the_fields;

        } else {

            return array();

        }

    }

}

/* End of file members.php */