<?php
/**
 * Init Controller
 *
 * This file loads the Profile Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Profile\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Include General Inc
require_once CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'inc/general.php'; 

// Include Quick Guide Inc
require_once CMS_BASE_ADMIN_COMPONENTS_PROFILE . 'inc/quick_guide.php'; 

/*
 * Init class loads the Profile Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'profile', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PROFILE);
        
    }
    
    /**
     * The public method view loads the profile's template
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('profile'));

        // Set the component's slug
        md_set_data('component_slug', 'profile');

        // Set the Default Quick Guide Js
        md_set_js_urls(array(base_url('assets/base/admin/default/js/quick-guide.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION)));     

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/profile/styles/css/main.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION), 'text/css', 'all'));

        // Verify if page exists
        if ( $this->CI->input->get('p', true) ) {

            // Show page
            switch ( $this->CI->input->get('p', true) ) {

                case 'preferences':

                    // Set the Profile Preferences Js
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/profile/js/preferences.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION)));   

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_PROFILE .  '/views/templates',
                            'preferences',
                            array(),
                            true
                        )

                    );
                    
                    break;

                case 'security':

                    // Set the Profile Security Js
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/profile/js/security.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION))); 

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_PROFILE .  '/views/templates',
                            'security',
                            array(),
                            true
                        )

                    );
                    
                    break;
                    
                default:

                    // Show the 404 page
                    show_404();

                    break;

            }

        } else {

            // Set the Default Upload Box Js
            md_set_js_urls(array(base_url('assets/base/admin/default/js/upload-box.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION)));     

            // Set the Profile Main Js
            md_set_js_urls(array(base_url('assets/base/admin/components/collection/profile/js/main.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PROFILE_VERSION)));   

            // Set views params
            set_admin_view(

                $this->CI->load->ext_view(
                    CMS_BASE_ADMIN_COMPONENTS_PROFILE .  '/views/templates',
                    'main',
                    array(),
                    true
                )

            );

        }
        
    }

}

/* End of file init.php */