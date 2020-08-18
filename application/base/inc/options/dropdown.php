<?php
/**
 * Dropdown Inc
 *
 * This file contains the methods for dropdown's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_option_dropdown') ) {
    
    /**
     * The function md_get_option_dropdown displays the dropdown's option
     * 
     * @param string $name contains the option's name
     * @param array $args contains the dropdown's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_option_dropdown($name, $args) {

        // Get search input
        $search_input = '';

        // Verify if search is enabled
        if ( isset($args['search']) ) {

            if ( $args['search'] ) {

                $search_input = '<div class="card-head">'
                                    . '<input type="text" class="search-dropdown-items settings-dropdown-search-input ' . $name . '_search" placeholder="' . $args['words']['search_text'] . '">'
                                . '</div>';

            }

        }

        // Verify if select btn exists
        if (isset($args['words']['select_btn'])) {

            echo '<div class="dropdown" data-option="' . $name . '">'
                    . '<button class="btn btn-secondary settings-dropdown-btn dropdown-toggle ' . $name . '" type="button" data-toggle="dropdown">'
                        . $args['words']['select_btn']
                    . '</button>'
                    . '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                        . '<div class="card">'
                            . $search_input
                        . '<div class="card-body">'
                            . '<ul class="list-group ' . $name . '_list settings-dropdown-list-ul">'
                            . '</ul>'
                        . '</div>'
                    . '</div>'
                . '</div>'
            . '</div>';
            
        }
        
    }
    
}