<?php
/**
 * Init Controller
 *
 * This file loads the Reset Auth Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Reset\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Email as CmsBaseClassesEmail;

/*
 * Init class loads the Reset Component
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
        
        // Load the component's language files
        $this->CI->lang->load( 'auth_reset', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_RESET );
        
    }
    
    /**
     * The public method view loads the settings's template
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function view() {

        // If session exists, redirect user
        if ( md_the_user_session() ) {
            redirect(md_the_user_session()['redirect']);
        }

        // Get component's title
        $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):$this->CI->lang->line('auth_reset_page_title');

        // Set page's title
        md_set_the_title($title);

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/reset/styles/css/styles.css?ver=' . CMS_BASE_AUTH_RESET_VERSION), 'text/css', 'all'));

        // Set javascript links
        md_set_js_urls(array(base_url('assets/base/auth/collection/reset/js/main.js?ver=' . CMS_BASE_AUTH_RESET_VERSION)));

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

        // Params container
        $params = array();

        // Verify if auth's logo exists
        if ( md_the_option('auth_logo') ) {

            // Get the auth's logo
            $auth_logo = $this->CI->base_model->the_data_where('medias', '*', array('media_id' => md_the_option('auth_logo')));

            // Verify if the auth's logo exists
            if ( $auth_logo ) {

                // Set the auth_logo key
                $params['auth_logo'] = $auth_logo[0]['body'];

            }

        }

        // Making temlate and send data to view.
        $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_RESET .  'views/layout', 'header', array(), true);
        $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_RESET .  'views', 'main', $params, true);
        $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_RESET .  'views/layout', 'footer', array(), true);
        $this->CI->load->ext_view(CMS_BASE_AUTH_RESET . 'views/layout', 'index', $this->CI->template);
        
    }

}
