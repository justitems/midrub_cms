<?php
/**
 * Dashboard Init Inc
 *
 * This file contains the general functions
 * which are used in the ADMIN Dashboard app
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Dashboard\Classes as CmsBaseAdminComponentsCollectionDashboardClasses;

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if (!function_exists('md_the_admin_dashboard_widget_position')) {
    
    /**
     * The function md_the_admin_dashboard_widget_position gets the widget's position
     * 
     * @param string $widget_slug
     * 
     * @since 0.0.8.5
     * 
     * @return integer or boolean false
     */
    function md_the_admin_dashboard_widget_position($widget_slug) {

        // Require the Dashboard Functions Inc Part
        require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/parts/dashboard_init.php';   
        
        // Get position
        return md_the_admin_widget_position_from_parts($widget_slug);  

    }

}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_set_admin_dashboard_widget') ) {
    
    /**
     * The function md_set_admin_dashboard_widget registers dashboard widgets
     * 
     * @param string $widget_slug contains the widget's slug
     * @param array $widget_params contains the widget's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_set_admin_dashboard_widget($widget_slug, $widget_params) {

        // Call the widgets class
        $widgets = (new CmsBaseAdminComponentsCollectionDashboardClasses\Widgets);

        // Set widget in the queue
        $widgets->set_widget($widget_slug, $widget_params);
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO EXECUTE ACTIONS
|--------------------------------------------------------------------------
*/

if (!function_exists('md_create_admin_dashboard_event')) {
    
    /**
     * The function md_create_admin_dashboard_event creates admin dashboard's event
     * 
     * @param array $args contains the event's parameters
     * 
     * @return array with response
     */
    function md_create_admin_dashboard_event($args) {

        // Require the Events Functions Inc Part
        require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/parts/dashboard_events.php';   
        
        // Create
        return md_create_admin_dashboard_event_from_parts($args);  

    }

}

/* End of file dashboard_init.php */