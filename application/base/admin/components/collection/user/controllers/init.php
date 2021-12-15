<?php
/**
 * Init Controller
 *
 * This file loads the User Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the User Component in the admin's panel
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
        $this->CI->lang->load( 'user', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_USER);

        // Load Base Contents Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );
        
    }
    
    /**
     * The public method view loads the user's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('user'));

        // Set the component's slug
        md_set_data('component_slug', 'user');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/user/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_USER_VERSION), 'text/css', 'all'));

        // Template array
        $template = array();

        // Get user's pages
        $user_pages = md_the_user_pages();

        // Verify if user pages exists
        if ($user_pages) {

            // Verify if page exists
            if ( $this->CI->input->get('p', true) ) {

                // List all user's pages
                foreach ($user_pages as $user_page) {

                    // Get page slug
                    $page_slug = array_keys($user_page);

                    // Verify if the user page meets the required page
                    if ( $page_slug[0] === $this->CI->input->get('p', true) ) {

                        // Verify if the page has the css_urls array
                        if (isset($user_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($user_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($user_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($user_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($user_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($user_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                                CMS_BASE_ADMIN_COMPONENTS_USER .  '/views',
                                'main',
                                array(),
                                true
                            )

                        );

                        break;

                    }

                }

            } else {

                // List all user's pages
                foreach ($user_pages as $user_page) {

                    // Get page slug
                    $page_slug = array_keys($user_page);

                    // Verify if the page has the css_urls array
                    if (isset($user_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($user_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($user_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($user_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($user_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($user_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                            CMS_BASE_ADMIN_COMPONENTS_USER .  '/views',
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