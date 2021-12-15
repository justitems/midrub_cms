<?php
/**
 * Admin Contents Option Templates Class
 *
 * This file loads the Admin_contents_option_templates Class with methods to generate option templates for contents option fields
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Classes\Contents;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Admin_contents_option_templates class loads the methods to generate option templates for contents option fields
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Admin_contents_option_templates {

    /**
     * The public method auth_components generates dropdown with auth's components
     * 
     * @param array $field contains the option field's params
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function auth_components($field) {

        // Get selected auth component variable
        $auth_component = md_the_data('auth_component');

        $options = '';

        if ( $auth_component ) {

            $options = '<option value="' . $auth_component['slug'] . '">' . str_replace(array('_', '-'), ' ', $auth_component['name']) . '</option>';

        }
        
        return '<div class="form-group">'
                    . '<label class="theme-label" for="contents-option-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                    . '<select class="form-control w-100 auth-components-selected-component theme-select" id="contents-option-field-' . $field['slug'] . '" disabled>'
                        . $options
                    . '</select>'
                . '</div>';

    } 

    /**
     * The public method theme_templates generates dropdown with theme's templates
     * 
     * @param array $field contains the option field's params
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function theme_templates($field) {

        // Get selected theme's template variable
        $theme_template = md_the_data('theme_template');

        $options = '';

        if ( $theme_template ) {

            $options = '<option value="' . $theme_template['slug'] . '">' . str_replace(array('_', '-'), ' ', $theme_template['name']) . '</option>';

        }
        
        return '<div class="form-group">'
                    . '<label class="theme-label" for="contents-option-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                    . '<select class="form-control w-100 theme-templates-selected-template theme-select" id="contents-option-field-' . $field['slug'] . '" disabled>'
                        . $options
                    . '</select>'
                . '</div>';

    }

    /**
     * The public method contents_classification generates a list with dynamic options to group contents
     * 
     * @param array $field contains the option field's params
     * 
     * @since 0.0.7.9
     * 
     * @return string with html
     */
    public function contents_classification($field) {

        // Button data ids
        $data_ids = '';
        
        if ( $field['parent'] ) {
            $data_ids .= ' data-parent="1"';
        } else {
            $data_ids .= ' data-parent="0"';
        }

        // Get codeigniter object instance
        $CI =& get_instance();

        return '<div class="form-group">'
                    . '<div class="theme-box-1">'
                        . '<div class="card theme-card-box">'
                            . '<div class="card-header">'
                                . '<div class="row">'
                                    . '<div class="col-8">'
                                        . '<button class="btn btn-link">'
                                            . $field['label']
                                        . '</button>'
                                    . '</div>'
                                    . '<div class="col-4 text-end">'
                                        . '<button type="button" class="btn mt-2 me-3 ps-2 pe-2 btn-classification-popup-manager theme-button-1" data-classification-slug="' . $field['slug'] . '">'
                                            . md_the_admin_icon(array('icon' => 'plus', 'class' => 'me-0'))
                                        . '</button>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                            . '<div class="card-body">'
                                . '<ul class="classification-selected-list classification-selected-list-' . $field['slug'] . '">'
                                    . '<li class="list-group-item no-results-found">'
                                        . $CI->lang->line('frontend_no_data_found_to_show')
                                    . '</li>'
                                . '</ul>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';

    }

}

/* End of file admin_contents_option_templates.php */