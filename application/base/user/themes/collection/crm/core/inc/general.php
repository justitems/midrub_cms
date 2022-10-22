<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_the_site_logo') ) {
    
    /**
     * The function get_the_site_logo displays the site's logo
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_site_logo() {

        // Get codeigniter object instance
        $CI = get_instance();

        // Verify if logo exists
        if ( md_the_option('user_logo') ) {

            $the_logo = $CI->base_model->the_data_where('medias', '*', array('media_id' => md_the_option('user_logo')));

            if ( $the_logo ) {

                echo '<a class="home-page-link" href="' . site_url() . '">'
                        . '<img src="' . $the_logo[0]['body'] . '" alt="' . $CI->config->item("site_name") . '" width="32">'
                    . '</a>';

            }

        }
        
    }
    
}

if ( !function_exists('get_the_site_favicon') ) {
    
    /**
     * The function get_the_site_favicon displays the site's favicon
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_site_favicon() {

        // Verify if favicon exists
        if ( md_the_option('favicon') ) {

            echo '<link rel="shortcut icon" href="' . md_the_option('favicon') . '" />';

        }
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/