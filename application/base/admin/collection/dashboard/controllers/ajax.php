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
namespace MidrubBase\Admin\Collection\Dashboard\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Dashboard\Helpers as MidrubBaseAdminCollectionDashboardHelpers;

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
        $this->CI->lang->load( 'dashboard', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_DASHBOARD );

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
        (new MidrubBaseAdminCollectionDashboardHelpers\Widgets)->load_members_for_graph();
        
    }

    /**
     * The public method load_sales_for_graph loads sales numbers for graph
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_sales_for_graph() {
        
        // Get sales
        (new MidrubBaseAdminCollectionDashboardHelpers\Widgets)->load_sales_for_graph();
        
    }

    /**
     * The public method change_widget_status changes the widget status
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function change_widget_status() {
        
        // Change the widget status
        (new MidrubBaseAdminCollectionDashboardHelpers\Widgets)->change_widget_status();
        
    }

}

/* End of file ajax.php */