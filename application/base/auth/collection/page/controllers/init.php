<?php
/**
 * Init Controller
 *
 * This file loads the Page Auth Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Page\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Page Component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method view loads the settings's template
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function view() {

        // Get component's title
        $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):md_the_single_content_meta('content_title');

        // Set page's title
        md_set_the_title($title);

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/page/styles/css/styles.css?ver=' . CMS_BASE_AUTH_PAGE_VERSION), 'text/css', 'all'));

        // Set javascript links
        md_set_js_urls(array(base_url('assets/base/auth/collection/page/js/main.js?ver=' . CMS_BASE_AUTH_PAGE_VERSION)));

        // Verify if meta description exists
        if ( md_the_single_content_meta('quick_seo_meta_description') ) {

            // Set meta description
            md_set_the_meta_description(md_the_single_content_meta('quick_seo_meta_description'));

        }

        // Verify if meta keywords exists
        if ( md_the_single_content_meta('quick_seo_meta_keywords') ) {

            // Set meta keywors
            md_set_the_meta_keywords(md_the_single_content_meta('quick_seo_meta_keywords'));

        }

        /**
         * The public method md_set_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_set_hook(
            'the_frontend_header',
            function () {

                // Get header code
                $header = md_the_option('frontend_header_code');

                // Verify if header code exists
                if ( $header ) {

                    // Show code
                    echo $header;

                }

                echo "<!-- Bootstrap CSS -->\n";
                echo "    <link rel=\"stylesheet\" href=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css\">\n";

            }
        );

        /**
         * The public method md_set_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_set_hook(
            'the_frontend_footer',
            function () {

                // Get footer code
                $footer = md_the_option('frontend_footer_code');

                // Verify if footer code exists
                if ( $footer ) {

                    // Show code
                    echo $footer;

                }

                echo "<script src=\"" . base_url("assets/js/jquery.min.js") . "\"></script>\n";
                echo "<script src=\"//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js\"></script>\n";
                echo "<script src=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>\n";
                echo "<script src=\"" . base_url("assets/js/main.js?ver=" . MD_VER) . "\"></script>\n";

            }

        );

        // Making temlate and send data to view.
        $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_PAGE .  '/views/layout', 'header', array(), true);
        $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_PAGE .  '/views', 'main', array(), true);
        $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_PAGE .  '/views/layout', 'footer', array(), true);
        $this->CI->load->ext_view(CMS_BASE_AUTH_PAGE . '/views/layout', 'index', $this->CI->template);
        
    }

}
