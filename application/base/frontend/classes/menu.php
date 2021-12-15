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
namespace CmsBase\Frontend\Classes;

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
     * The public method md_get_menu generates a menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function md_get_menu($menu_slug, $args) {
     
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
            for ( $m = 0; $m < count($menu_items); $m++ ) {

                $classification_id = $menu_items[$m]['classification_id'];

                $permalink = base_url($menu_items[$m]['selected_page']);

                if ( !empty($menu_items[$m]['permalink']) ) {
                    $permalink = $menu_items[$m]['permalink'];
                }

                $class = '';

                if ( $menu_items[$m]['class'] ) {
                    $class = $menu_items[$m]['class'];
                }

                $active = '';

                if ( $permalink === current_url() ) {
                    $active = ' nav-active';
                }

                if ( isset($args['before_single_item']) ) {

                    $before_single_item = $args['before_single_item'];

                    if ( isset($menu_items[($m + 1)]) ) {

                        if ( $menu_items[($m + 1)]['classification_parent'] === $classification_id ) {

                            $before_single_item = isset($args['before_single_item_with_submenu'])?$args['before_single_item_with_submenu']:$args['before_single_item'];

                        }
                        
                    }

                    echo str_replace(array('[class]', '[url]', '[active]', '[text]', '[unique_id]'), array($class, $permalink, $active, $menu_items[$m]['meta_value'], uniqid()), $before_single_item);

                }

                if ( isset($menu_items[($m + 1)]) ) {

                    if ( $menu_items[($m + 1)]['classification_parent'] === $classification_id ) {

                        if ( isset($args['before_submenu']) ) {
                            echo str_replace(array('[unique_id]'), array(uniqid()), $args['before_submenu']);
                        }

                        $fs = ($m + 1);

                        for ( $m2 = $fs; $m2 < count($menu_items); $m2++ ) {

                            if ( $menu_items[$m2]['classification_parent'] !== $classification_id ) {
                                break;
                            }

                            $permalink = base_url($menu_items[$m2]['selected_page']);

                            if ( !empty($menu_items[$m2]['permalink']) ) {
                                $permalink = $menu_items[$m2]['permalink'];
                            }
            
                            $class = '';
            
                            if ( $menu_items[$m2]['class'] ) {
                                $class = $menu_items[$m2]['class'];
                            }
            
                            $active = '';
            
                            if ( $permalink === current_url() ) {
                                $active = ' nav-active';
                            }
            
                            if ( isset($args['before_single_item']) ) {

                                $before_submenu_single_item = isset($args['before_submenu_single_item'])?$args['before_submenu_single_item']:$args['before_single_item'];

                                echo str_replace(array('[class]', '[url]', '[active]', '[text]', '[unique_id]'), array($class, $permalink, $active, $menu_items[$m2]['meta_value'], uniqid()), $before_submenu_single_item);
                                
                            }

                            if ( isset($args['after_single_item']) ) {
                                echo isset($args['after_submenu_single_item'])?$args['after_submenu_single_item']:$args['after_single_item'];
                            }
                            
                            $m++;

                        }

                        if ( isset($args['after_submenu']) ) {
                            echo $args['after_submenu'];
                        }
                    
                    }

                }

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

/* End of file menu.php */