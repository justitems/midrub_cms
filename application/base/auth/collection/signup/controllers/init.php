<?php
/**
 * Init Controller
 *
 * This file loads the Signup Auth Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Signup\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Signup Component
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
        $this->CI->lang->load( 'auth_signup', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_SIGNUP );
        
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
        $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):$this->CI->lang->line('signup_page_title');

        // Set page's title
        md_set_the_title($title);

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/signup/styles/css/styles.css?ver=' . MIDRUB_BASE_AUTH_SIGNUP_VERSION), 'text/css', 'all'));

        // Set Font Awesome
        md_set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css', 'text/css', 'all'));

        // Set javascript links
        md_set_js_urls(array(base_url('assets/base/auth/collection/signup/js/main.js?ver=' . MIDRUB_BASE_AUTH_SIGNUP_VERSION)));

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
         * The public method md_add_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_add_hook(
            'the_frontend_header',
            function () {

                // Get header code
                $header = get_option('frontend_header_code');

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
         * The public method md_add_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_add_hook(
            'the_frontend_footer',
            function () {

                // Get footer code
                $footer = get_option('frontend_footer_code');

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

        // Verify if plan's parameter exists
        if ( $this->CI->input->get('plan') ) {

            // Verify if the plan exists and it is public
            if ( $this->CI->base_model->get_data_where('plans', 'plan_id', array('plan_id' => $this->CI->input->get('plan'), 'visible <' => 1)) ) {

                // Delete selected plan
                $this->CI->session->unset_userdata('selected_plan');

                // Save the plan
                $this->CI->session->set_userdata('selected_plan', $this->CI->input->get('plan'));

            }

        }

        // Making temlate and send data to view.
        $this->CI->template['header'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views/layout', 'header', array(), true);
        $this->CI->template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views', 'main', array(), true);
        $this->CI->template['footer'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views/layout', 'footer', array(), true);
        $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP . '/views/layout', 'index', $this->CI->template);
        
    }

}
