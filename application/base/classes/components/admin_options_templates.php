<?php
/**
 * Admin Options Templates Class
 *
 * This file loads the Admin_options_templates Class with methods to generates options templates for components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Classes\Components;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Admin_components_templates class loads the methods to generates options templates for components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Admin_options_templates {

    /**
     * The public method checkbox_input generates contents for checkbox input
     * 
     * @param array $component_option contains the option's params
     * 
     * @since 0.0.7.9
     * 
     * @return string with html
     */
    public function checkbox_input($component_option) {

        $checked = '';

        // Get input's value
        $get_value = get_option($component_option['slug']);

        // Verify if the checkbox is checked
        if ( $get_value ) {

            $checked = ' checked';

        }

        return '<div class="form-group">'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-12">'
                            . '<label for="menu-item-text-input">'
                                . $component_option['label']
                            . '</label>'
                            . '<small>'
                                . $component_option['label_description']
                            . '</small>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-12 text-right">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $component_option['slug'] . '" name="checkbox_' . $component_option['slug'] . '" class="component-checkbox-input" type="checkbox"' . $checked . '>'
                                . '<label for="' . $component_option['slug'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';


    }

}

/* End of file admin_options_templates.php */