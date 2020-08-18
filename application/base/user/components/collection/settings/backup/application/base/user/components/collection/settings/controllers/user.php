<?php
/**
 * User Controller
 *
 * This file loads the Settings component in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Settings\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

use MidrubBase\Classes as MidrubBaseClasses;

// Require the Functions Inc
require_once MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'inc/functions.php';

/*
 * User class loads the Dashboard app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class User {
    
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
        
        // Load language
        $this->CI->lang->load( 'settings_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_SETTINGS );
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set the page's title
        set_the_title($this->CI->lang->line('settings'));

        // Set the Dashboard's styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/components/collection/settings/styles/css/settings.css?ver=' . MIDRUB_BASE_USER_COMPONENTS_SETTINGS_VERSION), 'text/css', 'all'));
        
        // Set the Main Settings Js
        set_js_urls(array(base_url('assets/base/user/components/collection/settings/js/main.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_SETTINGS_VERSION)));
        
        // Prepare view
        $this->set_user_view();
        
    }

    /**
     * The private method set_user_view sets user view
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    private function set_user_view() {

        // Verify if page exists
        if ( $this->CI->input->get('p', true) ) {

            // Template
            $template = '';

            // Get user settings's pages
            $user_settings_pages = the_user_settings_pages();

            // Verify if settings's pages exists
            if ($user_settings_pages) {

                // List all user's pages
                foreach ($user_settings_pages as $user_settings_page) {

                    // Get page slug
                    $page_slug = array_keys($user_settings_page);

                    // Verify if the user page meets the required page
                    if ( $page_slug[0] === $this->CI->input->get('p', true) ) {

                        // Verify if the page has the css_urls array
                        if (isset($user_settings_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($user_settings_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($user_settings_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($user_settings_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($user_settings_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($user_settings_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                    // Add js link in the queue
                                    md_set_js_urls($js_link_array);

                                }

                            }

                        }

                        // Set the template's value
                        $template = $page_slug[0];

                        break;

                    }

                }

            }

            // Verify if template exists
            if ( $template ) {

                // Set views params
                set_user_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views',
                        'main',
                        array(
                            'template' => $template
                        ),
                        true
                    )
                );
                
            } else {

                // Display 404 page
                show_404();

            }

        } else {

            // Template
            $template = '';

            // Get user settings's pages
            $user_settings_pages = the_user_settings_pages();

            // Verify if settings's pages exists
            if ($user_settings_pages) {

                // List all user's pages
                foreach ($user_settings_pages as $user_settings_page) {

                    // Get page slug
                    $page_slug = array_keys($user_settings_page);

                    // Verify if the page has the css_urls array
                    if (isset($user_settings_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($user_settings_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($user_settings_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($user_settings_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($user_settings_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($user_settings_page[$page_slug[0]]['js_urls'] as $js_link_array) {

                                // Add js link in the queue
                                md_set_js_urls($js_link_array);

                            }

                        }

                    }

                    // Set the template's value
                    $template = $page_slug[0];

                    break;

                }

            }

            // Verify if template exists
            if ( $template ) {

                // Set views params
                set_user_view(
                    $this->CI->load->ext_view(
                        MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views',
                        'main',
                        array(
                            'template' => $template
                        ),
                        true
                    )
                );
                
            } else {

                // Display 404 page
                show_404();

            }

        }

    }
    
}
