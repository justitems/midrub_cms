<?php
/**
 * Base Admin Dynamic List
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Dynamic_list;

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
        if ( !empty($field['field_params']['button_text']) && isset($field['field_params']['button_value']) && !empty($field['field_params']['placeholder']) ) {   
            
            // Set button's ID
            $button_id = !empty($field['field_params']['button_value'])?'data-id="' . $field['field_params']['button_value'] . '"':'';

            // Return the field
            return '<li class="list-group-item d-flex justify-content-between align-items-start" data-field="' . $field['field_slug'] . '">'
                . '<div class="ms-2 me-auto">'
                    . '<div class="fw-bold">'
                        . $field['field_words']['field_title']
                    . '</div>'
                    . $field['field_words']['field_description']
                . '</div>'
                . '<div class="me-2">'
                    . '<div class="dropdown theme-dropdown-1">'
                        . '<button '
                            . 'type="button" '
                            . 'class="btn btn-secondary d-flex justify-content-between align-items-start theme-dynamic-dropdown" '
                            . 'aria-expanded="false" '
                            . 'data-bs-toggle="dropdown" '
                            . $button_id
                            . '>'
                            . '<span>'
                                . $field['field_params']['button_text']
                            . '</span>'
                            . md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon'))
                        . '</button>'
                        . '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                            . '<input type="text" placeholder="' . $field['field_params']['placeholder'] . '" autocomplete="nope" class="theme-dropdown-search-for-items" />'
                            . '<div>'
                                . '<ul class="list-group theme-dropdown-items-list">'
                                . '</ul>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>'
            . '</li>';

        }
        
    }

}

/* End of file main.php */