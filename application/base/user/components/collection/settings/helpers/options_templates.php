<?php
/**
 * Options Templates Class
 *
 * This file loads the Options_templates Class with methods to generates options templates for components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Settings\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User_components_templates class loads the methods to generates options templates for components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.2
 */
class Options_templates {

    /**
     * The public method checkbox_input processes the option's type checkbox
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.2
     * 
     * @return string with processed data
     */ 
    public function checkbox_input( $option ) {
        
        // Verify if option has correct format
        if ( empty($option['name']) || empty($option['slug']) || empty($option['description']) ) {
            return '';
        }

        // Verify if the option is enabled
        $checked = '';
        
        if ( get_user_option( $option['slug'] ) ) {
            $checked = 'checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-10 col-md-10 col-8">'
                            . '<h4>' . $option['name'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-2 col-md-2 col-4">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['slug'] . '" name="' . $option['slug'] . '" class="app-option-checkbox" type="checkbox" ' . $checked . '>'
                                . '<label for="' . $option['slug'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }

    /**
     * The public method select_input processes the option's type select
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.2
     * 
     * @return string with processed data
     */ 
    public function select_input( $option ) {
        
        // Verify if option has correct format
        if ( empty($option['slug']) || empty($option['options']) ) {
            return '';
        }

        $options = '';
        
        foreach ( $option['options'] as $item ) {

            if ( empty($item['value']) || empty($item['text']) ) {
                continue;
            }

            $selected = '';

            if ( $item['selected'] ) {
                $selected = ' selected';
            }

            $options .= '<option value="' . $item['value'] . '"' . $selected . '>' . $item['text'] . '</option>';

        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-10 col-md-10 col-8">'
                            . '<h4>' . $option['name'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-2 col-md-2 col-4">'
                            . '<div class="select-option pull-right">'
                                . '<select id="' . $option['slug'] . '">'
                                    . $options
                                . '</select>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
        
        
    /**
     * The public method text_input processes the option's type text input
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.2
     * 
     * @return string with processed data
     */ 
    public function text_input( $option ) {
        
        // Verify if option has correct format
        if ( empty($option['name']) || empty($option['slug']) || empty($option['description']) ) {
            return '';
        }
        
        // Verify if the option is enabled
        $value = '';
        
        if ( get_user_option( $option['slug'] ) ) {
            $value = get_user_option( $option['slug'] );
        }
        
        $edit = '';
        
        if ( $option['edit'] ) {
            
            $edit = '<button type="button" class="btn btn-settings-edit-text btn-light">'
                        . '<i class="icon-note"></i>'
                    . '</button>';
            
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-7 col-md-7 col-7">'
                            . '<h4>' . $option['name'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-5 col-md-5 col-5">'
                            . '<div class="textarea-option disabled pull-right">'
                                . '<input id="' . $option['slug'] . '" name="' . $option['slug'] . '" type="text" value="' . $value . '" class="app-option-input"></input>'
                                . $edit
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
        
    } 
    
    /**
     * The public method modal_link processes the option's type modal's link
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.2
     * 
     * @return string with processed data
     */ 
    public function modal_link( $option ) {
        
        // Verify if option has correct format
        if ( empty($option['name']) || empty($option['slug']) || empty($option['description']) ) {
            return '';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-xl-7 col-md-7 col-7">'
                            . '<h4>' . $option['name'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-xl-5 col-md-5 col-5 text-right">'
                            . '<a href="#" data-toggle="modal" data-target="#' . $option['slug'] . '">' . $option['modal_link'] . '</a>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
        
    }

    /**
     * The public method content processes the option's type content
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.2
     * 
     * @return string with processed data
     */ 
    public function content( $option ) {

        // Verify if content exists
        if ( isset($option['content']) ) {

            return $option['content'];

        }
        
    }

}

/* End of file options_templates.php */