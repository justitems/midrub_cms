<?php
/**
 * Init Controller
 *
 * This file loads the Members Component in the admin's panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed'); 

/*
 * Init class loads the Members Component in the admin's panel
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'members', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_MEMBERS );
        
    }
    
    /**
     * The public method view loads the members's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('members'));

        // Set the component's slug
        md_set_data('component_slug', 'members');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/members/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_MEMBERS_VERSION), 'text/css', 'all'));

        // Template array
        $template = array();

        // Get admin's pages
        $members_pages = the_members_pages();

        // Verify if admin pages exists
        if ($members_pages) {

            // Verify if page exists
            if ( $this->CI->input->get('p', true) ) {

                // List all admin's pages
                foreach ($members_pages as $members_page) {

                    // Get page slug
                    $page_slug = array_keys($members_page);

                    // Verify if the admin page meets the required page
                    if ( $page_slug[0] === $this->CI->input->get('p', true) ) {

                        // Verify if the page has the css_urls array
                        if (isset($members_page[$page_slug[0]]['css_urls'])) {

                            // Verify if the css_urls array is not empty
                            if ($members_page[$page_slug[0]]['css_urls']) {

                                // List all css links
                                foreach ($members_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                    // Add css link in the queue
                                    md_set_css_urls($css_link_array);
                                    
                                }

                            }

                        }

                        // Verify if the page has the js_urls array
                        if (isset($members_page[$page_slug[0]]['js_urls'])) {

                            // Verify if the js_urls array is not empty
                            if ($members_page[$page_slug[0]]['js_urls']) {

                                // List all js links
                                foreach ($members_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                                CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'views',
                                'main',
                                array(),
                                true
                            )

                        );

                        break;

                    }

                }

            } else {

                // List all admin's pages
                foreach ($members_pages as $members_page) {

                    // Get page slug
                    $page_slug = array_keys($members_page);

                    // Verify if the page has the css_urls array
                    if (isset($members_page[$page_slug[0]]['css_urls'])) {

                        // Verify if the css_urls array is not empty
                        if ($members_page[$page_slug[0]]['css_urls']) {

                            // List all css links
                            foreach ($members_page[$page_slug[0]]['css_urls'] as $css_link_array) {

                                // Add css link in the queue
                                md_set_css_urls($css_link_array);

                            }

                        }

                    }

                    // Verify if the page has the js_urls array
                    if (isset($members_page[$page_slug[0]]['js_urls'])) {

                        // Verify if the js_urls array is not empty
                        if ($members_page[$page_slug[0]]['js_urls']) {

                            // List all js links
                            foreach ($members_page[$page_slug[0]]['js_urls'] as $js_link_array) {

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
                            CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'views',
                            'main',
                            array(),
                            true
                        )

                    );

                    break;

                }

            }

        } else {

            // Show 404 page
            show_404();

        }

        // Get member's tabs
        $member_tabs = the_admin_members_member_tabs();

        // Verify if at least a tab exists
        if ( $member_tabs ) {

            // List all member's tabs
            foreach ($member_tabs as $member_tab) {

                // Get tab's slug
                $tab_slug = array_keys($member_tab);

                // Verify if the tab has the css_urls array
                if (isset($member_tab['css_urls'])) {

                    // Verify if the css_urls array is not empty
                    if ($member_tab['css_urls']) {

                        // List all css links
                        foreach ($member_tab['css_urls'] as $css_link_array) {

                            // Add css link in the queue
                            md_set_css_urls($css_link_array);

                        }

                    }

                }

                // Verify if the tab has the js_urls array
                if (isset($member_tab['js_urls'])) {

                    // Verify if the js_urls array is not empty
                    if ($member_tab['js_urls']) {

                        // List all js links
                        foreach ($member_tab['js_urls'] as $js_link_array) {

                            // Add js link in the queue
                            md_set_js_urls($js_link_array);

                        }

                    }

                }

            }

        }
        
    }

}

/* End of file init.php */