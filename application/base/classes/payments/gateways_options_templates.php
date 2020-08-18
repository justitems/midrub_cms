<?php
/**
 * Gateways Options Templates Class
 *
 * This file loads the Gateways_options_templates class with methods to generate options templates for gateways
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Classes\Payments;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Gateways_options_templates class loads the methods to generate options templates for gateways
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Gateways_options_templates {

    /**
     * The public method checkbox_input generates contents for checkbox input
     * 
     * @param array $option contains the option's params
     * 
     * @since 0.0.8.0
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

        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10 col-md-10 col-xs-10">'
                            . '<h4>'
                                . $option['label']
                            . '</h4>'
                            . '<p>'
                                . $option['label_description']
                            . '</p>'
                        . '</div>'
                        . '<div class="col-lg-2 col-md-2 col-xs-2">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['slug'] . '" name="checkbox_' . $option['slug'] . '" class="settings-option-checkbox" type="checkbox"' . $checked . '>'
                                . '<label for="' . $option['slug'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';


    }

    /**
     * The public method text_input generates contents for text input
     * 
     * @param array $option contains the option's params
     * 
     * @since 0.0.8.0
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

        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-8">'
                            . '<h4>'
                                . $option['label']
                            . '</h4>'
                            . '<p>'
                                . $option['label_description']
                            . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-4">'
                            . '<div class="input-option">'
                                . '<input id="' . $option['slug'] . '" name="' . $option['slug'] . '" value="' . $value . '" class="settings-option-input" type="text">'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';


    }

}

/* End of file gateways_options_templates.php */