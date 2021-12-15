<?php
/**
 * Midrub Base Admin Settings
 *
 * This file contains the class Settings
 * which processes the Admin's settings fields
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings class processes the Admin's settings
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Settings {
    
    /**
     * The public method process processes options
     * 
     * @param array $options contains the options
     *
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function process( $options ) {
        
        // Define all_options variable
        $all_options = '';
        
        // List all available options
        foreach ( $options as $option ) {
            
            // Call a method by option's type
            switch ( $option['type'] ) {               
                
                case 'checkbox':
                    
                    $all_options .= $this->checkbox( $option );
                    
                    break;
                
                case 'text':
                    
                    $all_options .= $this->text( $option );
                    
                    break;

                case 'storage_dropdown':
                
                    $all_options .= $this->storage_dropdown( $option );
                    
                    break;
                
            }
            
        }
        
        return '<ul class="settings-list-options">' . $all_options . '</ul>';
        
    }
    
    /**
     * The protected method checkbox processes the option's type checkbox
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.8
     * 
     * @return string with processed data
     */ 
    protected function checkbox( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }

        $checked = '';

        // Verify if the option is enabled
        if ( md_the_option($option['name']) ) {
            $checked = 'checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10 col-md-10 col-xs-10">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-2 col-md-2 col-xs-2">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" class="settings-option-checkbox" type="checkbox" ' . $checked . '>'
                                . '<label for="' . $option['name'] . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }
    
    /**
     * The protected method text processes the option's type text
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.7.8
     * 
     * @return string with processed data
     */ 
    protected function text( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }
        
        $value = '';
        
        // Verify if the option is enabled
        if ( md_the_option( $option['name'] ) ) {

            // Set option's value
            $value = md_the_option( $option['name'] );

        } else if ( isset($option['default_value']) ) {

            // Set default value
            $value = $option['default_value'];

        }
        
        $maxlength = '';
        
        // Verify if max length is used in the input field
        if ( isset($option['maxlength']) ) {

            $maxlength = ' maxlength="' . $option['maxlength'] . '"';

        }  
        
        $type = 'text';
        
        // Verify if the input field has an input's type
        if ( isset($option['input_type']) ) {

            // Set wanted type
            $type = $option['input_type'];

        }         
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-8">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-4">'
                            . '<div class="input-option">'
                                . '<input id="' . $option['name'] . '" name="' . $option['name'] . '" value="' . $value . '" class="settings-option-input" type="' . $type . '"' . $maxlength . '>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }  

    /**
     * The protected method storage_dropdown shows the storage's locations
     * 
     * @param array $option contains the option's information
     * 
     * @since 0.0.8.4
     * 
     * @return string with processed data
     */ 
    protected function storage_dropdown( $option ) {
        
        // Verify if option has correct format
        if ( ( @$option['name'] == '') || ( @$option['title'] == '') || ( @$option['description'] == '') ) {
            return '';
        }        
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-8 col-md-8 col-xs-8">'
                            . '<h4>' . $option['title'] . '</h4>'
                            . '<p>' . $option['description'] . '</p>'
                        . '</div>'
                        . '<div class="col-lg-4 col-md-4 col-xs-4 text-right">'
                            . '<div class="dropdown" data-option="' . $option['name'] . '">'
                                . '<button class="btn btn-secondary settings-dropdown-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">'
                                . '</button>'
                                . '<div class="dropdown-menu" aria-labelledby="dropdown-items">'
                                    . '<div class="card">'
                                        . '<div class="card-head">'
                                            . '<input type="text" class="search-dropdown-items settings-dropdown-search-input settings-storage-locations-search" placeholder="' . get_instance()->lang->line('settings_search_for_locations') . '" />'
                                        . '</div>'
                                        . '<div class="card-body">'
                                            . '<ul class="list-group upload_locations_list settings-dropdown-list-ul">'
                                            . '</ul>'
                                        . '</div>'
                                    . '</div>'
                                . '</div>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }  
    
}

