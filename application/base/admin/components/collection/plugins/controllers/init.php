<?php
/**
 * Init Controller
 *
 * This file loads the Plugins Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Plugins\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Plugins Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'plugins', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PLUGINS);
        
    }
    
    /**
     * The public method view loads the plugins's template
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('plugins'));

        // Set the component's slug
        md_set_data('component_slug', 'plugins');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/plugins/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_PLUGINS_VERSION), 'text/css', 'all'));

        // Template array
        $template = array();

        // Get plugins pages
        $plugins_pages = the_admin_plugins_pages();

        // Verify if plugins pages exists
        if ($plugins_pages) {

            // Verify if page exists
            if ( $this->CI->input->get('p', true) ) {

                // Set where plugins page
                $where_plugins_page = array('p' => $this->CI->input->get('p', true));
                
                // Get the plugins page
                $the_plugins_page = array_filter(array_map(function($plugins_page) use($where_plugins_page) {

                    // Get page slug
                    $page_slug = array_keys($plugins_page);
                    
                    // Verify if is required event
                    if ( $where_plugins_page['p'] === $page_slug[0] ) {

                        // Verify if the page has the css_urls array
                        if (isset($plugins_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($plugins_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($plugins_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($plugins_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($plugins_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($plugins_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                    // Add js link in the queue
                                    md_set_js_urls($js_link_array);

                                }

                            }

                        }

                        // Set the component's display
                        md_set_data('component_display', $page_slug[0]);

                        // Set views params
                        set_admin_view(

                            $this->CI->load->ext_view(
                                CMS_BASE_ADMIN_COMPONENTS_PLUGINS .  '/views',
                                'main',
                                array(),
                                true
                            )

                        );

                        return true;

                    }

                }, $plugins_pages));

                // Verify if $the_plugins_page is empty
                if ( empty($the_plugins_page) ) {

                    // Get plugins plugin pages
                    $plugins_plugin_pages = the_admin_plugins_plugin_pages();

                    // Set where plugin page
                    $where_plugins_plugin_page = array('p' => $this->CI->input->get('p', true));
                                    
                    // Get the plugin page
                    $the_plugins_plugin_page = array_filter(array_map(function($plugins_plugin_page) use($where_plugins_plugin_page) {

                        // Get page slug
                        $page_slug = array_keys($plugins_plugin_page);
                        
                        // Verify if is required event
                        if ( $where_plugins_plugin_page['p'] === $page_slug[0] ) {

                            // Verify if the page has the css_urls array
                            if (isset($plugins_plugin_page[$page_slug[0]]['css_urls'])) {

                                // Verify if the css_urls array is not empty
                                if ($plugins_plugin_page[$page_slug[0]]['css_urls']) {

                                    // List all css links
                                    foreach ($plugins_plugin_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                        // Add css link in the queue
                                        md_set_css_urls($css_link_array);
                                        
                                    }

                                }

                            }

                            // Verify if the page has the js_urls array
                            if (isset($plugins_plugin_page[$page_slug[0]]['js_urls'])) {

                                // Verify if the js_urls array is not empty
                                if ($plugins_plugin_page[$page_slug[0]]['js_urls']) {

                                    // List all js links
                                    foreach ($plugins_plugin_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                        // Add js link in the queue
                                        md_set_js_urls($js_link_array);

                                    }

                                }

                            }

                            // Set the component's display
                            md_set_data('component_display', $page_slug[0]);

                            // Set views params
                            set_admin_view(

                                $this->CI->load->ext_view(
                                    CMS_BASE_ADMIN_COMPONENTS_PLUGINS .  '/views',
                                    'plugin',
                                    array(),
                                    true
                                )

                            );

                            return true;

                        }

                    }, $plugins_plugin_pages));

                    // If plugin's page missing
                    if ( empty($the_plugins_plugin_page) ) {

                        // Show the 404 page
                        show_404();

                    }

                }

            } else {

                // List all plugins's pages
                foreach ($plugins_pages as $plugins_page) {

                    // Get page slug
                    $page_slug = array_keys($plugins_page);

                    // Verify if the page has the css_urls array
                    if (isset($plugins_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($plugins_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($plugins_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($plugins_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($plugins_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($plugins_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                // Add js link in the queue
                                md_set_js_urls($js_link_array);

                            }

                        }

                    }

                    // Set the component's display
                    md_set_data('component_display', $page_slug[0]);

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_PLUGINS .  '/views',
                            'main',
                            array(),
                            true
                        )

                    );

                    break;

                }

            }
            
        } else {

            // Show the 404 page
            show_404();

        }
        
    }

}

/* End of file init.php */