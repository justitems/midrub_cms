<?php
/**
 * Ajax Controller
 *
 * This file processes the Dashboard's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Dashboard\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Dashboard\Helpers as CmsBaseAdminComponentsCollectionDashboardHelpers;

/*
 * Ajax class processes the Dashboard's component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'dashboard', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_DASHBOARD );

    }

    /**
     * The public method dashboard_get_events gets the events for the dashboard
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function dashboard_get_events() {
        
        // Get events
        (new CmsBaseAdminComponentsCollectionDashboardHelpers\Events)->dashboard_get_events();
        
    }
    
    /**
     * The public method load_members_for_graph loads members numbers for graph
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_members_for_graph() {
        
        // Get members
        (new CmsBaseAdminComponentsCollectionDashboardHelpers\Widgets)->load_members_for_graph();
        
    }
    
    /**
     * The public method dashboard_reorder_widgets reorders the widgets
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function dashboard_reorder_widgets() {
        
        // Reorder the widgets
        (new CmsBaseAdminComponentsCollectionDashboardHelpers\Widgets)->dashboard_reorder_widgets();
        
    }

}

/* End of file ajax.php */