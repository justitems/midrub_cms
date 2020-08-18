<?php
/**
 * Media Inc
 *
 * This file contains the methods for media's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_option_media') ) {
    
    /**
     * The function md_get_option_media displays the media's option
     * 
     * @param string $name contains the option's name
     * @param array $args contains the media's arguments
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function md_get_option_media($name, $args) {

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

        // Display media input
        echo '<div class="input-group input-group-media">'
                . '<input type="text" placeholder="' . $placeholder . '" value="' . $value . '" class="form-control settings-media-value" data-option="' . $name . '" />'
                . '<div class="input-group-addon">'
                    . '<button type="button" class="input-group-append multimedia-manager-btn btn-default" data-toggle="modal" data-target="#multimedia-manager">'
                        . '<i class="fas fa-photo-video"></i>'
                    . '</button>'
                . '</div>'
            . '</div>';
        
    }
    
}