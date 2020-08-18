<?php
/**
 * General Inc
 *
 * PHP Version 7.3
 *
 * This files contains the General Inc file
 * with default functions used in the Dashboard's component 
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Dashboard\Helpers as MidrubBaseAdminCollectionDashboardHelpers;

if ( !function_exists('administrator_dashboard_set_widgets') ) {

    /**
     * The function administrator_dashboard_set_widgets registers the widgets for the Dashboard's Component
     * 
     * @param array $args contains the widget's arguments
     * 
     * @return void
     */
    function administrator_dashboard_set_widgets($args) {

        // Call the widgets class
        $widgets = (new MidrubBaseAdminCollectionDashboardHelpers\Widgets);

        // Set widget in the queue
        $widgets->set_widget($args);
        
    }

}

if ( !function_exists('administrator_dashboard_the_widgets') ) {

    /**
     * The function administrator_dashboard_the_widgets gets the widgets for the Dashboard's Component
     * 
     * @return array with widgets
     */
    function administrator_dashboard_the_widgets() {

        // Call the widgets class
        $widgets = (new MidrubBaseAdminCollectionDashboardHelpers\Widgets);

        // Get codeigniter object instance
        $CI =& get_instance();

        // Use the base model to get the widgets
        $dashboard_widgets = $CI->base_model->get_data_where(
            'administrator_dashboard_widgets',
            '*'
        );

        // Widgets List
        $widgets_list = array();

        // Verify if widgets exists
        if ( $dashboard_widgets ) {

            // List all widgets
            foreach ( $dashboard_widgets as $dashboard_widget ) {

                // Set widget status
                $widgets_list[$dashboard_widget['widget_slug']] = ($dashboard_widget['enabled'])?false:true;

            }

        }

        // Returns widgets
        return array(
            'widgets' => $widgets->load_widgets($widgets_list),
            'enabled' => $widgets_list
        );
        
    }

}