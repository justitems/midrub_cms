<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_the_site_logo') ) {
    
    /**
     * The function get_the_site_logo displays the site's logo
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function get_the_site_logo() {

        // Verify if logo exists
        if ( md_the_option('main_logo') ) {

            echo '<a href="' . site_url() . '" class="navbar-brand">'
                . '<img src="' . md_the_option('main_logo') . '" alt="Midrub Docs" width="32">'
            . '</a>';

        }
        
    }
    
}

if ( !function_exists('get_the_site_favicon') ) {
    
    /**
     * The function get_the_site_favicon displays the site's favicon
     * 
     * @since 0.0.8.4
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

if ( !function_exists('get_the_tickets_notification') ) {

    /**
     * The function get_the_tickets_notification provides the number with unreplied tickets
     *
     * @return integer with unreplied tickets
     */
    function get_the_tickets_notification() {

        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Tickets Model
        $CI->load->model('tickets');
        
        // Get all tickets
        $all_tickets = $CI->tickets->get_all_tickets_for();
        
        // Return array with admin information
        return $all_tickets;
        
    }

}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/