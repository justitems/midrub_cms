<?php
/**
 * Auth General Inc
 *
 * This file contains the methods used in 
 * both auth and public area
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_the_frontend_header') ) {
    
    /**
     * The function md_get_the_frontend_header loads the frontend's header
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_frontend_header() {

        // Call the properties class
        $hooks = (new MidrubBase\Classes\Hooks);

        // Runs a hook based on hook's name
        $hooks->run_hook('the_frontend_header', array());
        
    }
    
}

if ( !function_exists('md_get_the_frontend_footer') ) {
    
    /**
     * The function md_get_the_frontend_footer loads the frontend's footer
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_frontend_footer() {

        // Call the properties class
        $hooks = (new MidrubBase\Classes\Hooks);

        // Runs a hook based on hook's name
        $hooks->run_hook('the_frontend_footer', array());
        
    }
    
}