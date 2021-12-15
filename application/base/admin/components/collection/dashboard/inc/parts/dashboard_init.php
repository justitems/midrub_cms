<?php
/**
 * Dashboard Widgets Parts Inc
 *
 * This file contains global widgets functions
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_the_admin_widget_position_from_parts') ) {
    
    /**
     * The public method md_the_admin_widget_position_from_parts gets the widget's position
     * 
     * @param string $widget_slug
     * 
     * @since 0.0.8.5
     * 
     * @return integer or boolean false
     */
    function md_the_admin_widget_position_from_parts($widget_slug) {
        
        // Get CodeIgniter object instance
        $CI =& get_instance();

        // Verify if the widgets exists
        if ( !md_the_data('admin_dashboard_widgets_positions') ) {

            // Get the widgets
            $the_widgets = $CI->base_model->the_data_where(
                'dashboard_widgets',
                '*'
            );

            // Prepare the widgets
            $widgets = $the_widgets?array_column($the_widgets, 'widget_position', 'widget'):array(); 
            
            // Set the widgets
            md_set_data('admin_dashboard_widgets_positions', $widgets);            

            // Verify if the widgets exists
            if ( !$the_widgets ) {
                return false;
            }

        }

        // Get the widgets
        $widgets = md_the_data('admin_dashboard_widgets_positions');

        // Verify if the widget exists
        if ( isset($widgets[$widget_slug]) ) {
            return $widgets[$widget_slug];
        } else {
            return false;
        }
        
    }
    
}

/* End of file dashboard_widgets.php */