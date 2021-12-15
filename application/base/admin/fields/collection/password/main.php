<?php
/**
 * Base Admin Password
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Password;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;

/*
 * Main class loads the Base Admin field loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Main implements CmsBaseAdminInterfaces\Fields {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method the_field gets the admin's field
     * 
     * @param array $field contains the field's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with the field
     */
    public function the_field($field) {
        
        // Verify if placeholder exists
        if ( !empty($field['field_params']['placeholder']) ) {

            // Set field value
            $value = !empty($field['field_params']['value'])?' value="' . $field['field_params']['value'] . '"':'';

            // Set field disabled
            $disabled = !empty($field['field_params']['disabled'])?' disabled':'';            

            // Return the field
            return '<li class="list-group-item d-flex justify-content-between align-items-start" data-field="' . $field['field_slug'] . '">'
                . '<div class="ms-2 me-auto">'
                    . '<div class="fw-bold">'
                        . $field['field_words']['field_title']
                    . '</div>'
                    . $field['field_words']['field_description']
                . '</div>'
                . '<div class="me-2">'
                    . '<input type="password"' . $value . ' placeholder="' . $field['field_params']['placeholder'] . '" autocomplete="nope"' . $disabled . ' class="form-control theme-password-input-1">'
                . '</div>'
            . '</li>';

        }
        
    }

}

/* End of file main.php */