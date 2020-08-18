<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Name: Admin Helper
 * Author: Scrisoft
 * Created: 25/11/2017
 * Here you will find the following functions:
 * admin_header - displays information about updates and scheduled posts in admin area
 * */

if ( !function_exists('admin_header') ) {

    /**
     * The function displays information about updates and scheduled posts in admin area
     *
     * @return array with information for admin 
     */
    function admin_header() {

        // Get codeigniter object instance
        $CI = get_instance();

        if ( !function_exists('get_update_count') ) {
        
            // Require the base class
            $CI->load->file(APPPATH . '/base/main.php');

            // Load Base Model
            $CI->load->ext_model( APPPATH . 'base/models/', 'Base_model', 'base_model' );

            // Require the general functions file
            require_once APPPATH . 'base/admin/inc/general.php';

        }
        
        // Load Tickets Model
        $CI->load->model('tickets');
        
        // Get all tickets
        $all_tickets = $CI->tickets->get_all_tickets_for();
        
        // Return array with admin information
        return array(
            'all_tickets' => $all_tickets
        );
        
    }

}

if (!function_exists('custom_header')) {
    
    /**
     * The function helps to custom the header
     * 
     * @return string with custom code
     */
    function custom_header() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Add main stylesheet file
        $data = '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/admin/styles/css/style.css?ver=' . MD_VER . '" media="all"/>';
        
        $data .= "\n";
        
        if ( $CI->router->fetch_method() === 'admin_apps' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/admin/styles/css/apps.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        }
        
        if ( $CI->router->fetch_method() === 'admin_plans' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/admin/styles/css/plans.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        }

        if ( $CI->router->fetch_method() === 'all_tickets' || $CI->router->fetch_method() === 'new_faq_article' || $CI->router->fetch_method() === 'faq_articles' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/admin/styles/css/tickets.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        }    
        
        return $data;
        
    }

}

if ( !function_exists('heads') ) {

    /**
     * The function displays the custom colors
     * 
     * @param string $data contains the header
     * 
     * @return string with styles
     */
    function heads( $data ) {
        
        // Get menu color
        $menu = get_option('main-menu-color');
        
        // Get the menu text color
        $menu_text = get_option('main-menu-text-color');
        
        // Get the panel heading colors
        $panel_heading = get_option('panel-heading-color');
        
        // Get the panel heading text colors
        $panel_heading_text = get_option('panel-heading-text-color');
        
        // Verify if one of the color above exists
        if ( ($menu != '') || ($menu_text != '') || ($panel_heading != '') || ($panel_heading_text != '') ) {
            
            // Create the custom styles
            $style = '<style>';
            
            if ( $menu ) {
                
                $style .= 'nav{background-color: ' . $menu . ' !important;}';
                
            }
            
            if ( $menu_text ) {
                
                $style .= 'nav a{color: ' . $menu_text . ' !important;}';
                
            }
            
            if ( $panel_heading ) {
                
                $style .= '.panel-heading {background: ' . $panel_heading . ';}';
                
            }
            
            if ( $panel_heading_text ) {
                
                $style .= '.panel-heading, .panel-heading>h2>a, .panel-heading>h2>span {color: ' . $panel_heading_text . ' !important;}';
                
            }
            
            $style .= '</style></head>';
            
            return str_replace('</head>', $style, $data);
            
        } else {
            
            return $data;
            
        }
        
    }

}