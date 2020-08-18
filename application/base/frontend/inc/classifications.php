<?php
/**
 * Classification Themes Inc
 *
 * This file contains the classifications themes functions
 * used in the themes
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('the_classification_meta') ) {
    
    /**
     * The function the_classification_meta gets the classification's meta
     * 
     * @param $meta contains the classification's meta
     * 
     * @since 0.0.7.9
     * 
     * @return string with classification's meta or boolean false
     */
    function the_classification_meta($meta) {
        
        if ( md_the_component_variable('single_classification') ) {

            if ( isset(md_the_component_variable('single_classification')[$meta]) ) {
                return md_the_component_variable('single_classification')[$meta];
            }

        }

        return false;
        
    }
    
}

if ( !function_exists('the_classification_url') ) {
    
    /**
     * The function the_classification_url gets the classification's url
     * 
     * @since 0.0.7.9
     * 
     * @return string with url or boolean false
     */
    function the_classification_url() {
        
        if ( md_the_component_variable('single_classification') ) {

            if ( isset(md_the_component_variable('single_classification')['item_slug']) ) {
                return site_url(md_the_component_variable('classification_slug') . '/' . md_the_component_variable('single_classification')['item_slug']);
            }

        }

        return false;
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_single_classification') ) {
    
    /**
     * The function set_single_classification sets the single classification
     * 
     * @param array $classification contains the classification's data
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_single_classification($content) {

        // Set the classification's ID
        md_set_component_variable('single_classification', $content);
        
    }
    
}