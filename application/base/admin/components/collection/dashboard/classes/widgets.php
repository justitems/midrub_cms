<?php
/**
 * Widgets Class
 *
 * This file loads the Widgets class with methods to process the widgets
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the namespace
namespace CmsBase\Admin\Components\Collection\Dashboard\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Widgets class loads the properties used to process the widgets
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Widgets {
    
    /**
     * Contains and array with saved widgets
     *
     * @since 0.0.8.5
     */
    public static $the_widgets = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }

    /**
     * The public method set_widget adds the widgets widgets in the queue
     * 
     * @param string $widget_slug contains the widget's slug
     * @param array $widget_params contains the widget's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function set_widget($widget_slug, $widget_params) {

        // Verify if the widget has valid fields
        if ( !empty($widget_params['widget_name']) && !empty($widget_params['widget_description']) && !empty($widget_params['widget_icon']) && !empty($widget_params['widget_data']) ) {

            // Verify if position exists
            if ( empty($widget_params['widget_position']) ) {
                $widget_params['widget_position'] = 0;
            }

            // Set slug
            $widget_params['widget_slug'] = $widget_slug;

            self::$the_widgets[] = $widget_params;
            
        }

    } 

    /**
     * The public method the_widgets provides the widgets from the queue
     * 
     * @since 0.0.8.5
     * 
     * @return array with widgets or boolean false
     */
    public function the_widgets() {

        // Verify if widgets exists
        if ( self::$the_widgets ) {

            // Sort the widgets
            usort(self::$the_widgets, $this->widgets_sorter('widget_position'));

            return self::$the_widgets;

        } else {

            return false;

        }

    }

    /**
     * The protected method widgets_sorter sorts the widgets
     * 
     * @param string $position contains the position's value
     * 
     * @since 0.0.8.5
     * 
     * @return array with widgets
     */
    protected function widgets_sorter($position) {

        return function ($a, $b) use ($position) {

            return strnatcmp($a[$position], $b[$position]);

        };

    }

}

/* End of file widgets.php */