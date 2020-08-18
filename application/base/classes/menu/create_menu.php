<?php
/**
 * Create Menu Class
 *
 * This file loads the Create_menu Class with properties used to displays menu in the admin panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes\Menu;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Create_menu class loads the general properties used to displays all theme's menu in the admin panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Create_menu {
    
    /**
     * Contains an array with frontend's menu
     *
     * @since 0.0.7.8
     */
    public static $the_frontend_menu = array();   

    /**
     * Contains an array with user's menu
     *
     * @since 0.0.7.8
     */
    public static $the_user_menu = array();   

    /**
     * The public set_theme_menu adds menu to the list
     * 
     * @param string $section contains the section
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_menu($section, $menu_slug, $args) {

        // Verify if the menu has valid fields
        if ( $menu_slug && isset($args['name']) ) {

            switch ( $section ) {

                case 'frontend':
                    self::$the_frontend_menu[][$menu_slug] = $args;
                break;

                case 'user':
                    self::$the_user_menu[][$menu_slug] = $args;
                break;

            }
            
        }

    } 

}
