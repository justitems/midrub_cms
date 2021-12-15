<?php
/**
 * Admin Contents Meta Templates Class
 *
 * This file loads the Admin_contents_meta_templates Class with methods to generates meta templates for contents meta fields
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Classes\Contents;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Contents as CmsBaseClassesContents;

/*
 * Admin_contents_meta_templates class loads the methods to generates meta templates for contents meta fields
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Admin_contents_meta_templates {

    /**
     * Methods
     *
     * @since 0.0.8.1
     */
    public static $methods = array();

    /**
     * The public method text_input generates contents for text input
     * 
     * @param array $field contains the meta field's params
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function text_input($field, $language) {

        $label_description = '';

        // Verify if the label's description isn't empty
        if ( isset($field['label_description']) ) {

            $label_description = '<small class="form-text text-muted theme-small">'
                                    . $field['label_description']
                                . '</small>';

        }

        $input_placeholder = '';

        // Verify if the placeholder isn't empty
        if ( isset($field['placeholder']) ) {

            $input_placeholder = ' placeholder="' . $field['placeholder'] . '"';

        }  
        
        $value = '';

        // Get input's value
        $get_value = md_the_single_content_meta($field['slug'], $language);

        // Verify if input's value exists
        if ( $get_value ) {

            $value = ' value="' . $get_value . '"';

        } else if ( isset($field['value']) ) {

            $value = ' value="' . $field['value'] . '"';

        }

        return '<div class="form-group mb-3">'
                    . '<label class="theme-label" for="contents-meta-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                    . '<input type="text" name="contents-meta-text-input-' . time() . '" class="form-control theme-text-input-1 contents-meta-text-input" id="contents-meta-field-' . $field['slug'] . '"' . $input_placeholder . $value . ' data-slug="' . $field['slug'] . '" data-meta="' . $field['meta_slug'] . '">'
                    . $label_description
                . '</div>';


    } 

    /**
     * The public method checkbox_input generates contents for checkbox input
     * 
     * @param array $field contains the meta field's params
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function checkbox_input($field, $language) {

        $checked = '';

        // Get input's value
        $get_value = md_the_single_content_meta($field['slug'], $language);

        // Verify if the checkbox is checked
        if ( $get_value ) {

            $checked = ' checked';

        }

        return '<div class="form-group">'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-12">'
                            . '<label class="theme-label" for="checkbox_' . $field['slug'] . '_' . $language . '">'
                                . $field['label']
                            . '</label>'
                            . '<small class="form-text text-muted theme-small">'
                                . $field['label_description']
                            . '</small>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-12 text-end">'
                            . '<div class="checkbox-option theme-checkbox-input-2">'
                                . '<input id="checkbox_' . $field['slug'] . '_' . $language . '" name="checkbox_' . $field['slug'] . '_' . $language . '" class="contents-meta-checkbox-input" type="checkbox" data-slug="' . $field['slug'] . '" data-meta="' . $field['meta_slug'] . '"' . $checked . '>'
                                . '<label for="checkbox_' . $field['slug'] . '_' . $language . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>';


    } 

    /**
     * The public method media_input generates contents for media input
     * 
     * @param array $field contains the meta field's params
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function media_input($field, $language) {

        $label_description = '';

        // Verify if the label's description isn't empty
        if ( isset($field['label_description']) ) {

            $label_description = '<small class="form-text text-muted theme-small">'
                                    . $field['label_description']
                                . '</small>';

        }

        $input_placeholder = '';

        // Verify if the placeholder isn't empty
        if ( isset($field['placeholder']) ) {

            $input_placeholder = ' placeholder="' . $field['placeholder'] . '"';

        }  
        
        $value = '';

        // Get input's value
        $get_value = md_the_single_content_meta($field['slug'], $language);

        // Verify if input's value exists
        if ( $get_value ) {

            $value = ' value="' . $get_value . '"';

        } else if ( isset($field['value']) ) {

            $value = ' value="' . $field['value'] . '"';

        }

        return '<div class="form-group mb-3">'
                    . '<label class="theme-label" for="contents-meta-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                    . '<div class="input-group theme-input-group-2">'
                        . '<input type="text" name="contents-meta-text-input-' . time() . '" class="form-control theme-text-input-1 contents-meta-text-input" id="contents-meta-field-' . $field['slug'] . '"' . $input_placeholder . $value . ' data-slug="' . $field['slug'] . '" data-meta="' . $field['meta_slug'] . '">'                       
                        . '<button type="button" class="input-group-append multimedia-manager-btn btn" data-bs-toggle="modal" data-bs-target="#theme-upload-media-modal">'
                            . md_the_admin_icon(array('icon' => 'medias'))
                        . '</button>'
                    . '</div>'
                    . $label_description
                . '</div>';
                

    }

    /**
     * The public method select_page generates contents for select page
     * 
     * @param array $field contains the meta field's params
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function select_page($field, $language) {

        // Get codeigniter object instance
        $CI = &get_instance();

        $selected = '';

        // Call the contents_read class
        $contents_read = (new CmsBaseClassesContents\Contents_read);

        // Verify if content exists
        if ($contents_read::$the_single_content) {

            foreach ($contents_read::$the_single_content as $meta) {

                if ( ($meta['meta_name'] === $field['slug'] ) && ( $meta['language'] === $language ) ) {
                    $selected = ' data-id="' . $meta['meta_extra'] . '"';
                    break;
                }
                
            }

        }


        $search_input = '<input type="text" class="search-dropdown-items editor-dropdown-search-input ' . $field['slug'] . '_search" placeholder="' . $CI->lang->line('frontend_search_pages') . '">';

        $label_description = '';

        // Verify if the label's description isn't empty
        if ( isset($field['label_description']) ) {

            $label_description = '<small class="form-text text-muted theme-small">'
                                    . $field['label_description']
                                . '</small>';

        }

        return '<div class="form-group">'
                    . '<div class="row">'
                        . '<div class="col-12">'
                            . '<label class="theme-label" for="contents-meta-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                        . '</div>'
                    . '</div>'
                    . '<div class="row">'             
                        . '<div class="col-12">'
                            . '<div class="dropdown theme-dropdown-1" data-option="' . $field['slug'] . '">'
                                . '<button type="button" class="btn btn-secondary meta-dropdown-btn dropdown-toggle ' . $field['slug'] . ' d-flex justify-content-between" aria-expanded="false" data-bs-toggle="dropdown" data-meta="selected_page"' . $selected . '>'
                                    . '<span>'
                                        . $CI->lang->line('frontend_settings_select_page')
                                    . '</span>'
                                    . md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon'))
                                . '</button>'
                                . '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                    . $search_input
                                    . '<div>'
                                        . '<ul class="list-group ' . $field['slug'] . '_list meta-dropdown-list-ul">'
                                        . '</ul>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                    . '<div class="row">'
                        . '<div class="col-12">'
                            . $label_description
                        . '</div>'
                    . '</div>'                    
                . '</div>';
                

    }

    /**
     * The public method select_page generates contents for select page
     * 
     * @param array $field contains the meta field's params
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return string with html
     */
    public function editor($field, $language) {
        $label_description = '';

        // Verify if the label's description isn't empty
        if ( isset($field['label_description']) ) {

            $label_description = '<small class="form-text text-muted theme-small">'
                                    . $field['label_description']
                                . '</small>';

        }

        $value = '';

        // Get input's value
        $get_value = md_the_single_content_meta($field['slug'], $language);

        // Verify if input's value exists
        if ( $get_value ) {

            $value = $get_value;

        } else if ( isset($field['value']) ) {

            $value = $field['value'];

        }

        return '<div class="form-group summer-area mb-3">'
                . '<label class="theme-label" for="contents-meta-field-' . $field['slug'] . '">' . $field['label'] . '</label>'
                . $label_description
                . '<div class="row">'
                    . '<div class="col-lg-12">'
                        . '<div class="summernote-editor body-' . $field['slug'] . '" data-dir="body-' . $field['slug'] . '"></div>'
                        . '<textarea class="editor-body editor-body-' . $field['slug'] . ' d-none" data-slug="' . $field['slug'] . '" data-meta="' . $field['meta_slug'] . '">' . $value . '</textarea>'
                    . '</div>'
                . '</div>'
            . '</div>';
                

    }

    /**
     * The magic method __set registers methods
     * 
     * @param string $name contains the method's name
     * @param function $function contains the function
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function __set($name, $function) {

        self::$methods[$name] = $function;
    }

    /**
     * The magic method __call runs when the method missing
     * 
     * @param string $name contains the method's name
     * @param array $params contains the parameters for method
     * 
     * @since 0.0.8.1
     * 
     * @return string with html or boolean false
     */
    public function __call($name, $params) {

        if ( isset(self::$methods[$name]) ) {

            return self::$methods[$name]($params[0], $params[1]);

        } else {

            return false;

        }

    }

}

/* End of file admin_contents_meta_templates.php */