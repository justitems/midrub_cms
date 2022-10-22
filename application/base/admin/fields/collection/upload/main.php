<?php
/**
 * Base Admin Upload
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Upload;

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

        // Verify if field's slug exists
        if ( empty($field['field_slug']) ) {
            return;
        }

        // Verify if the field params required exists
        if ( empty($field['field_params']['url']) || empty($field['field_params']['action']) || empty($field['field_params']['extensions']) ) {
            return;
        }

        // Extra fields
        $extra_fields = '';

        // Verify if extra fields exists
        if ( !empty($field['field_params']['extra_fields']) ) {

            // Verify if extra fields is an array
            if ( is_array($field['field_params']['extra_fields']) ) {

                // List extra fields
                foreach ( $field['field_params']['extra_fields'] as $extra_field ) {

                    // Verify if required fields exists
                    if ( !empty($extra_field['field_slug']) && isset($extra_field['field_value']) ) {

                        // Set field
                        $extra_fields .= '<input type="text" name="' . $extra_field['field_slug'] . '" value="' . $extra_field['field_value'] . '">';

                    }

                }              

            }

        }

        // Return the field
        return '<li class="list-group-item" data-field="' . $field['field_slug'] . '">'
            . '<div class="m-2 me-auto">'
                . '<div class="fw-bold">'
                    . $field['field_words']['field_title']
                . '</div>'
                . $field['field_words']['field_description']
            . '</div>'
            . '<div class="m-2 mt-3">'
                . '<div class="theme-drag-and-drop-files" data-upload-form-url="' . $field['field_params']['url'] . '" data-upload-form-action="' . $field['field_params']['action'] . '" data-supported-extensions="' . $field['field_params']['extensions'] . '">'
                    . '<div data-for="form">'
                        . $extra_fields
                    . '</div>'
                . '</div>'
            . '</div>'
        . '</li>';
        
    }

}

/* End of file main.php */