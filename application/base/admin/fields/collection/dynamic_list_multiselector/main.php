<?php
/**
 * Base Admin Dynamic List Multi Selector
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Dynamic_list_multiselector;

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
        if ( !empty($field['field_params']['button_text']) && !empty($field['field_params']['placeholder']) ) {

            // Selected items
            $selected_items = '';

            // Verify if selected items key exists
            if ( !empty($field['field_params']['selected_items']) ) {

                if ( is_array($field['field_params']['selected_items']) ) {

                    // List the selected items
                    foreach ( $field['field_params']['selected_items'] as $item ) {

                        // Verify if the item has the required parameters
                        if ( isset($item['item_id']) && isset($item['item_name']) ) {

                            // Add the item to the list
                            $selected_items .= '<li>'
                                . '<a href="#" data-id="' . $item['item_id'] . '">'
                                    . $item['item_name']
                                . '</a>'
                            . '</li>';

                        }

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
                    . '<div class="dropdown theme-multiselector-dropdown-1">'
                        . '<button '
                            . 'type="button" '
                            . 'class="btn btn-secondary d-flex justify-content-between align-items-start" '
                            . 'aria-expanded="false" '
                            . 'data-bs-toggle="dropdown" '
                            . 'data-bs-auto-close="outside" '
                            . '>'
                            . '<span>'
                                . $field['field_params']['button_text']
                            . '</span>'
                            . md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'default-multiselector-dropdown-arrow-icon'))
                        . '</button>'
                        . '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                            . '<div>'
                                . '<ul class="default-multiselector-dropdown-selected-items-list">'
                                    . $selected_items
                                . '</ul>'
                            . '</div>'                        
                            . '<input type="text" placeholder="' . $field['field_params']['placeholder'] . '" autocomplete="nope" class="default-multiselector-dropdown-search-for-items" />'
                            . '<div>'
                                . '<ul class="list-group default-multiselector-dropdown-items-list">'
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