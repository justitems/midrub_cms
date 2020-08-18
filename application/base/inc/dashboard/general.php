<?php
/**
 * General Dashboard Inc
 *
 * This file contains contains the general functions
 * for both admin and user dashboard
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_get_dashboard_logo') ) {
    
    /**
     * The function md_get_dashboard_logo displays the dashboard's logo
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_dashboard_logo() {

        // Get logo
        $main_logo = get_option('main_logo');

        // Verify if logo exists
        if ($main_logo) {

            echo $main_logo;

        } else {

            echo base_url('/assets/img/logo.png');

        }
        
    }
    
}
