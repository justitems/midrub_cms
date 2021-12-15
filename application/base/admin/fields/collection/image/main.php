<?php
/**
 * Base Admin Image
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Image;

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

        // Upload link
        $upload_link = '';

        // Set the image
        $image = '<span class="iconify" data-icon="fluent:image-copy-20-regular"></span>';

        // Verify if the parameter field_params exists
        if ( !empty($field['field_params']) ) {

            // Verify if the modal parameter exists
            if ( !empty($field['field_params']['modal']) ) {

                // Set upload link
                $upload_link = ' data-bs-toggle="modal" data-bs-target="' . $field['field_params']['modal'] . '"';

                // Verify if src exists
                if ( !empty($field['field_params']['src']) ) {

                    // Set image
                    $image = '<img src="' . $field['field_params']['src'] . '" alt="Midrub" width="32">';

                }

            }

        }

        // Return the field
        return '<li class="list-group-item d-flex justify-content-between align-items-start" data-field="' . $field['field_slug'] . '">'
            . '<div class="ms-2 me-auto">'
                . '<div class="fw-bold">'
                    . $field['field_words']['field_title']
                . '</div>'
                . $field['field_words']['field_description']
            . '</div>'
            . '<div class="me-2">'
                . '<div class="card theme-image-field">'
                    . '<div class="card-header">'
                        . $image
                    . '</div>'
                    . '<div class="card-body">'
                        . '<button type="button" class="btn btn-light"' . $upload_link . '>'
                            . $this->CI->lang->line('admin_upload')
                        . '</button>'
                        . '<button type="button" class="btn btn-danger admin-field-remove-image">'
                            . $this->CI->lang->line('admin_remove')
                        . '</button>'                        
                    . '</div>'
                . '</div>'
            . '</div>'
        . '</li>';
        
    }

}

/* End of file main.php */