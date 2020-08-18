<?php
/**
 * Admin Options Templates Class
 *
 * This file loads the Admin_options_templates Class with methods to generates options templates for apps and components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Classes\Apps;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Admin_apps_templates class loads the methods to generates options templates for apps and components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Admin_options_templates {

    /**
     * The public method checkbox_input generates contents for checkbox input
     * 
     * @param array $option contains the option's params
     * 
     * @since 0.0.7.9
     * 
     * @return string with html
     */
    public function checkbox_input($option) {

        // Verify if option has correct format
        if ( empty($option['slug']) || empty($option['label']) ) {
            return '';
        }

        $checked = '';

        // Get input's value
        $get_value = get_option($option['slug']);

        // Verify if the checkbox is checked
        if ( $get_value ) {

            $checked = ' checked';

        }

        return '<div class="form-group">'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-12">'
                            . '<label for="menu-item-text-input">'
                                . $option['label']
                            . '</label>'
                            . '<small>'
                                . $option['label_description']
                            . '</small>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-12 text-right">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['slug'] . '" name="checkbox_' . $option['slug'] . '" class="option-input checkbox-input" type="checkbox"' . $checked . '>'
                                . '<label for="' . $option['slug'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';


    }

    /**
     * The public method text_input generates contents for text input
     * 
     * @param array $option contains the option's params
     * 
     * @since 0.0.7.9
     * 
     * @return string with html
     */
    public function text_input($option) {

        // Verify if option has correct format
        if ( empty($option['slug']) || empty($option['label']) ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( get_option( $option['slug'] ) ) {
            $value = get_option( $option['slug'] );
        }

        return '<div class="form-group">'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-12">'
                            . '<label for="menu-item-text-input">'
                                . $option['label']
                            . '</label>'
                            . '<small>'
                                . $option['label_description']
                            . '</small>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-12 text-right">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['slug'] . '" name="' . $option['slug'] . '" value="' . $value . '" class="option-input text-input" type="text">'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';


    }

}

/* End of file admin_options_templates.php */