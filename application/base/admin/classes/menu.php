<?php
/**
 * Menu Class
 *
 * This file loads the Menu class with methods to manage the menu's items
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Menu class loads the properties used to collect the menu's items
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Menu {
    
    /**
     * Contains and array with saved items
     *
     * @since 0.0.8.5
     */
    public static $the_items = array(), $the_item_childrens = array(); 

    /**
     * The public method set_item adds the menu's items in the queue
     * 
     * @param array $params contains the item's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function set_item($params) {

        // Verify if the item contains expected parameters
        if ( isset($params['item_slug']) && isset($params['item_icon']) && isset($params['item_name']) && isset($params['item_url']) && isset($params['item_position']) ) {

            // Add item to the list
            self::$the_items[] = $params;

        }

    }

    /**
     * The public method the_items returns the menu's items
     * 
     * @param array $params contains the item's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return array with items or boolean false
     */
    public function the_items($params) {

        // Verify if preferences exists
        if ( self::$the_items ) {

            // Verify if item exists
            if ( !empty($params['item_parent']) ) {

                self::$the_item_childrens = array();

                foreach ( self::$the_items as $the_item ) {

                    if ( empty($the_item['item_parent']) ) continue;

                    if ( $params['item_parent'] === $the_item['item_parent'] ) {

                        self::$the_item_childrens[] = $the_item;

                    }

                }

                if ( self::$the_item_childrens ) {

                    // Sort the items
                    usort(self::$the_item_childrens, $this->items_sorter('item_position'));

                    return self::$the_item_childrens;
                    
                }

            } else {

                // Sort the items
                usort(self::$the_items, $this->items_sorter('item_position'));

                return self::$the_items;

            }

        }

        return false;

    }

    /**
     * The protected method items_sorter sorts the items
     * 
     * @param string $position contains the position's value
     * 
     * @since 0.0.8.3
     * 
     * @return array with items
     */
    protected function items_sorter($position) {

        return function ($a, $b) use ($position) {

            return strnatcmp($a[$position], $b[$position]);

        };

    }

}

/* End of file menu.php */