<?php
/**
 * Textarea Inc
 *
 * This file contains the methods for textarea's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_option_textarea') ) {
    
    /**
     * The function md_get_option_textarea displays the textarea's option
     * 
     * @param string $name contains the option's name
     * @param array $args contains the textarea's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_get_option_textarea($name, $args) {

        // Placeholder
        $placeholder = '';

        // Verify if placeholder exists
        if (isset($args['words']['placeholder'])) {

            // Set placeholder
            $placeholder = $args['words']['placeholder'];

        }

        // Value
        $value = '';

        // Verify if value exists
        if ( get_option($name) ) {

            // Set new value
            $value = get_option($name);

        }  

        // Display textarea
        echo '<div class="input-option">'
                . '<textarea placeholder="' . $placeholder . '" class="form-control settings-textarea-value" data-option="' . $name . '">' . $value . '</textarea>'
            . '</div>';
        
    }
    
}