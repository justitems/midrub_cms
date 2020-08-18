<?php
/**
 * Init Controller
 *
 * This file loads the Support Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Support\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Require the support_pages functions file
require_once APPPATH . 'base/inc/pages/administrator/support_pages.php';

/*
 * Init class loads the Support Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SUPPORT);

        // Load the Faq Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SUPPORT . 'models/', 'Faq_model', 'faq_model' );

        // Load the Tickets Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SUPPORT . 'models/', 'Tickets_model', 'tickets_model' );
        
    }
    
    /**
     * The public method view loads the support's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('support'));

        // Set the component's slug
        md_set_component_variable('component_slug', 'support');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/collection/support/styles/css/styles.css?ver=' . MIDRUB_BASE_ADMIN_SUPPORT_VERSION), 'text/css', 'all'));

        // Template array
        $template = array();

        // Get support pages
        $support_pages = md_the_support_pages();

        // Verify if support pages exists
        if ($support_pages) {

            // Verify if page exists
            if ( $this->CI->input->get('p', true) ) {

                // List all support's pages
                foreach ($support_pages as $support_page) {

                    // Get page slug
                    $page_slug = array_keys($support_page);

                    // Verify if the support page meets the required page
                    if ( $page_slug[0] === $this->CI->input->get('p', true) ) {

                        // Verify if the page has the css_urls array
                        if (isset($support_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($support_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($support_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($support_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($support_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($support_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                    // Add js link in the queue
                                    md_set_js_urls($js_link_array);

                                }

                            }

                        }

                        // Set the component's display
                        md_set_component_variable('component_display', $page_slug[0]);

                        // Load the editor
                        $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_SUPPORT .  '/views', 'main', array(), true);
                        break;

                    }

                }

            } else {

                // List all support's pages
                foreach ($support_pages as $support_page) {

                    // Get page slug
                    $page_slug = array_keys($support_page);

                    // Verify if the page has the css_urls array
                    if (isset($support_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($support_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($support_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($support_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($support_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($support_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                // Add js link in the queue
                                md_set_js_urls($js_link_array);

                            }

                        }

                    }

                    // Set the component's display
                    md_set_component_variable('component_display', $page_slug[0]);

                    // Load the editor
                    $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_SUPPORT .  '/views', 'main', array(), true);
                    break;

                }

            }
            
        }

        // Verify if body was setup
        if ( !isset($template['body']) ) {
            show_404();
        }

        // Making temlate and send data to view.
        $template['header'] = $this->CI->load->view('admin/layout/header2', array('admin_header' => admin_header()), true);
        $template['left'] = $this->CI->load->view('admin/layout/left', array(), true);
        $template['footer'] = $this->CI->load->view('admin/layout/footer', array(), true);
        $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_SUPPORT . '/views/layout', 'index', $template);
        
    }

}
