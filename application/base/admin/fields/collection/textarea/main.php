<?php
/**
 * Base Admin Textarea
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Textarea;

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

        // Set placeholder
        $placeholder = !empty($field['field_params']['placeholder'])?' placeholder="' . $field['field_params']['placeholder'] . '"':'';

        // Set field value
        $value = !empty($field['field_params']['value'])?$field['field_params']['value']:'';         

        // Return the field
        return '<li class="list-group-item d-flex justify-content-between align-items-start" data-field="' . $field['field_slug'] . '">'
            . '<div class="ms-2 me-auto">'
                . '<div class="fw-bold">'
                    . $field['field_words']['field_title']
                . '</div>'
                . $field['field_words']['field_description']
            . '</div>'
            . '<div class="me-2">'
                . '<textarea ' . $placeholder . ' class="form-control theme-textarea-1">' . $value . '</textarea>'
            . '</div>'
        . '</li>';
        
    }

}

/* End of file main.php */