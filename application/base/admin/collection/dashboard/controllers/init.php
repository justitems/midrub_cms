<?php
/**
 * Init Controller
 *
 * This file loads the Dashboard Component in the admin's panel
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
 * Init class loads the Dashboard Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Init {
    
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

        // Require the General Inc
        require_once MIDRUB_BASE_ADMIN_DASHBOARD . 'inc/general.php';

        // Require the Default Widgets Inc
        require_once MIDRUB_BASE_ADMIN_DASHBOARD . 'inc/default_widgets.php';
        
    }
    
    /**
     * The public method view loads the dashboard's template
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('dashboard'));

        // Set the component's slug
        md_set_component_variable('component_slug', 'dashboard');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/collection/dashboard/styles/css/styles.css?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION), 'text/css', 'all'));

        // Set Main Js file
        md_set_js_urls(array(base_url('assets/base/admin/collection/dashboard/js/main.js?ver=' . MIDRUB_BASE_ADMIN_DASHBOARD_VERSION)));

        // Set Chart JS
        set_js_urls(array('//www.chartjs.org/dist/2.7.2/Chart.js')); 

        // Set Utils JS
        set_js_urls(array('//www.chartjs.org/samples/latest/utils.js'));

        // Call the widgets class
        $widgets = (new MidrubBaseAdminCollectionDashboardHelpers\Widgets);

        // Gets widgets
        $all_widgets = $widgets->load_widgets();

        // Verify if widgets exists
        if ( $all_widgets ) {

            // List all widgets
            foreach ( $all_widgets as $widget ) {

                // Verify if css links exists
                if ( $widget['css_urls'] ) {

                    // List all urls
                    foreach ( $widget['css_urls'] as $url ) {

                        // Set CSS url
                        md_set_css_urls($url);

                    }

                }

                // Verify if js links exists
                if ( $widget['js_urls'] ) {

                    // List all urls
                    foreach ( $widget['js_urls'] as $url ) {

                        // Set JS url
                        set_js_urls(array($url[0]));

                    }

                }

            }

        }

        // Making temlate and send data to view.
        $template['header'] = $this->CI->load->view('admin/layout/header2', array('admin_header' => admin_header()), true);
        $template['left'] = $this->CI->load->view('admin/layout/left', array(), true);
        $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_DASHBOARD .  'views', 'main', array(
            'widgets' => $all_widgets
        ), true);
        $template['footer'] = $this->CI->load->view('admin/layout/footer', array(), true);
        $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_DASHBOARD . 'views/layout', 'index', $template);
        
    }

}
