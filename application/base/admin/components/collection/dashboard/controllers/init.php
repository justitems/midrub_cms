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
namespace CmsBase\Admin\Components\Collection\Dashboard\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Dashboard\Helpers as CmsBaseAdminComponentsCollectionDashboardHelpers;

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

        // Require the General Inc
        require_once CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'inc/general.php';

        // Load the Dashboard Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'models/', 'Dashboard_model', 'dashboard_model' );
        
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
        md_set_data('component_slug', 'dashboard');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/dashboard/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION), 'text/css', 'all'));

        // Set Main Js file
        md_set_js_urls(array(base_url('assets/base/admin/components/collection/dashboard/js/main.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_DASHBOARD_VERSION)));

        // Set ApexCharts JS
        set_js_urls(array('//cdn.jsdelivr.net/npm/apexcharts'));

        // Get the widgets
        $the_widgets = md_the_admin_dashboard_widgets();

        // Verify if the widgets exists
        if ( $the_widgets ) {

            // List all widgets
            foreach ( $the_widgets as $the_widget ) {

                // Verify if the page has the css_urls array
                if (isset($the_widget['css_urls'])) {

                    // Verify if the css_urls array is not empty
                    if ($the_widget['css_urls']) {

                        // List all css links
                        foreach ($the_widget['css_urls'] as $css_link_array) {

                            // Add css link in the queue
                            md_set_css_urls($css_link_array);

                        }

                    }

                }

                // Verify if the page has the js_urls array
                if (isset($the_widget['js_urls'])) {

                    // Verify if the js_urls array is not empty
                    if ($the_widget['js_urls']) {

                        // List all js links
                        foreach ($the_widget['js_urls'] as $js_link_array) {

                            // Add js link in the queue
                            md_set_js_urls($js_link_array);

                        }

                    }

                }

            }

        }

        // Set views params
        set_admin_view(

            $this->CI->load->ext_view(
                CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'views',
                'main',
                array(),
                true
            )

        );
        
    }

}

/* End of file init.php */
