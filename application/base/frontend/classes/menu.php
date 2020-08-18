<?php
/**
 * Menu Class
 *
 * This file loads the Menu Class with methods to display the Menu
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Menu class loads methods to display the menu
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Menu {

    /**
     * The public method get_menu generates a menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function get_menu($menu_slug, $args) {
     
        // Require the Read Menu Inc file
        require_once APPPATH . 'base/inc/menu/read_menu.php';

        // Prepare menu's args
        $menu_args = array(
            'slug' => $menu_slug,
            'fields' => array(
                'selected_page',
                'permalink',
                'class'
            ),
            'language' => TRUE
        );

        // Get menu's items
        $menu_items = md_the_theme_menu($menu_args);

        // Verify if menu items exists
        if ( $menu_items ) {

            if ( isset($args['before_menu']) ) {
                echo $args['before_menu'];
            }

            // List all menu items
            foreach ( $menu_items as $menu_item ) {

                // Default permalink
                $permalink = base_url($menu_item['selected_page']);

                if ( $menu_item['permalink'] ) {
                    $permalink = $menu_item['permalink'];
                }

                $class = '';

                if ( $menu_item['class'] ) {
                    $class = ' ' . $menu_item['class'];
                }

                if ( isset($args['before_single_item']) ) {
                    echo str_replace(array('[class]', '[url]'), array($class, $permalink), $args['before_single_item']);
                }

                echo $menu_item['meta_value'];

                if ( isset($args['after_single_item']) ) {
                    echo $args['after_single_item'];
                }

            }

            if ( isset($args['after_menu']) ) {
                echo $args['after_menu'];
            }

        }

    }

}
