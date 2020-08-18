<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Midrub's Installation
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_url') ) {
    
    /**
     * The function md_the_url returns the url
     * 
     * @since 0.0.8.1
     * 
     * @return string with url
     */
    function md_the_url() {

        // Get the protocol
        $protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';

        // If action in url exists, remove
        $url = explode('?action', $protocol . '://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        
        // Returns the url
        return $url[0];
        
    }
    
}