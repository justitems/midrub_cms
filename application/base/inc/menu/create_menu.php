<?php
/**
 * Create Menu Inc
 *
 * This file contains the general functions to 
 * create menu for the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Menu as MidrubBaseClassesMenu;

if ( !function_exists('md_set_frontend_menu') ) {
    
    /**
     * The function md_set_frontend_menu adds a new menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_frontend_menu($menu_slug, $args) {
        
        // Call the create_menu class
        $create_menu = (new MidrubBaseClassesMenu\Create_menu);

        // Set frontend's menu in the queue
        $create_menu->set_menu('frontend', $menu_slug, $args);

    }
    
}

if ( !function_exists('md_the_frontend_menu_list') ) {
    
    /**
     * The function md_the_frontend_menu_list returns the menu list
     * 
     * @since 0.0.7.8
     * 
     * @return array with menu list or boolean false
     */
    function md_the_frontend_menu_list() {

        // Call the create_menu class
        $create_menu = (new MidrubBaseClassesMenu\Create_menu);        
        
        // Verify if menu exists
        if ( $create_menu::$the_frontend_menu ) {

            return $create_menu::$the_frontend_menu;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_set_user_menu') ) {
    
    /**
     * The function md_set_user_menu adds a new menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_user_menu($menu_slug, $args) {

        // Call the create_menu class
        $create_menu = (new MidrubBaseClassesMenu\Create_menu);

        // Set user's menu in the queue
        $create_menu->set_menu('user', $menu_slug, $args);

    }
    
}

if ( !function_exists('md_the_user_menu_list') ) {
    
    /**
     * The function md_the_user_menu_list returns the menu list
     * 
     * @since 0.0.7.9
     * 
     * @return array with menu list or boolean false
     */
    function md_the_user_menu_list() {

        // Call the create_menu class
        $create_menu = (new MidrubBaseClassesMenu\Create_menu);        
        
        // Verify if menu exists
        if ( $create_menu::$the_user_menu ) {

            return $create_menu::$the_user_menu;

        } else {

            return false;

        }
        
    }
    
}