<?php
/**
 * Init Controller
 *
 * This file loads the Admin Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Admin\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Admin Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'admin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_ADMIN );
        
    }
    
    /**
     * The public method view loads the admin's template
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('admin'));

        // Set the component's slug
        md_set_data('component_slug', 'admin');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/admin/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_ADMIN_VERSION), 'text/css', 'all'));

        // Template array
        $template = array();

        // Get admin's pages
        $admin_pages = md_the_admin_pages();

        // Verify if admin pages exists
        if ($admin_pages) {

            // Verify if page exists
            if ( $this->CI->input->get('p', true) ) {

                // List all admin's pages
                foreach ($admin_pages as $admin_page) {

                    // Get page slug
                    $page_slug = array_keys($admin_page);

                    // Verify if the admin page meets the required page
                    if ( $page_slug[0] === $this->CI->input->get('p', true) ) {

                        // Verify if the page has the css_urls array
                        if (isset($admin_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($admin_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($admin_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($admin_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($admin_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($admin_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                                CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views',
                                'main',
                                array(),
                                true
                            )

                        );
                        
                        break;

                    }

                }

            } else if ( $this->CI->input->get('invoice', true) ) {

                // Require the Invoices Inc
                require_once CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'inc/invoices.php';

                // Get invoice's data
                $invoice = md_the_invoice_by_id($this->CI->input->get('invoice', true));

                // Verify if invoice exists
                if ($invoice) {
                    echo $invoice[0]['invoice_text'];
                } else {
                    show_404();
                }

                exit();


            } else {

                // List all admin's pages
                foreach ($admin_pages as $admin_page) {

                    // Get page slug
                    $page_slug = array_keys($admin_page);

                    // Verify if the page has the css_urls array
                    if (isset($admin_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($admin_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($admin_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($admin_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($admin_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($admin_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                            CMS_BASE_ADMIN_COMPONENTS_ADMIN . 'views',
                            'main',
                            array(),
                            true
                        )

                    );

                    break;

                }

            }

        } else {

            // Show the 404 error
            show_404();

        }
        
    }

}

/* End of file init.php */