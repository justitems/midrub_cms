<?php
/**
 * Checkbox Inc
 *
 * This file contains the methods for checkbox's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_option_checkbox') ) {
    
    /**
     * The function md_get_option_checkbox displays the checkbox's option
     * 
     * @param string $name contains the option's name
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_get_option_checkbox($name) {

        // Checked
        $checked = '';

        // Verify if the checkbox is checked
        if ( get_option($name) ) {

            // Set checked status
            $checked = ' checked';

        }  

        // Display checkbox
        echo '<div class="checkbox-option pull-right">'
                . '<input id="' . $name . '" name="' . $name . '" class="settings-option-checkbox" type="checkbox" data-option="' . $name . '"' . $checked . ' />'
                . '<label for="' . $name . '"></label>'
            . '</div>';
        
    }
    
}