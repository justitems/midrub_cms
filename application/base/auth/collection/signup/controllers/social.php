<?php
/**
 * Social Controller
 *
 * This file connects user by using networks
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Signup\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Social class connects user by using networks
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Social {
    
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

        // Load Plans Model
        $this->CI->load->model('plans');

        // Load Base Contents Model
        $this->CI->load->ext_model(MIDRUB_BASE_PATH . 'models/', 'Base_auth_social', 'base_auth_social');
        
    }
    
    /**
     * The public method connect redirects user to the network
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function connect($network) {

        // Verify if network exists
        if ( !file_exists(MIDRUB_BASE_AUTH . 'social/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !get_option('enable_auth_' . strtolower($network)) ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_enabled'));
            exit();

        }

        // Require network
        require_once MIDRUB_BASE_AUTH . 'social/' . $network . '.php';

        // Create an array
        $array = array(
            'MidrubBase',
            'Auth',
            'Social',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->check_availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_configured'));
            exit();            

        }

        // Set the sign up page
        $sign_up = the_url_by_page_role('sign_up') ? the_url_by_page_role('sign_up') : site_url('auth/signup');

        // Redirect user
        (new $cl())->connect($sign_up . '/' . $network);
        
    }

    /**
     * The public method login tries to login the user
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.7.8
     * 
     * @return array with error message or void
     */
    public function login($network) {

        // Verify if network exists
        if ( !file_exists(MIDRUB_BASE_AUTH . 'social/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !get_option('enable_auth_' . strtolower($network)) ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_enabled'));
            exit();

        }

        // Require network
        require_once MIDRUB_BASE_AUTH . 'social/' . $network . '.php';

        // Create an array
        $array = array(
            'MidrubBase',
            'Auth',
            'Social',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->check_availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_configured'));
            exit();            

        }

        // Set the sign up page
        $sign_up = the_url_by_page_role('sign_up') ? the_url_by_page_role('sign_up') : site_url('auth/signup');

        // Try to get user's data
        $user_data = (new $cl())->save($sign_up . '/' . $network);

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

        // Params array
        $params = array();

        // Verify if user's data exists
        if ( isset($user_data['data']) ) {

            // Verify if account's ID exists
            if ( isset($user_data['data']['id']) ) {

                // Delete social account
                $this->CI->session->unset_userdata('social_account');

                // Delete social network
                $this->CI->session->unset_userdata('social_network');

                // Save the social account
                $this->CI->session->set_userdata('social_account', trim($user_data['data']['id']));

                // Save the social network
                $this->CI->session->set_userdata('social_network', trim($network));                

            }            

            // Verify if email exists
            if ( isset($user_data['data']['email']) ) {

                // Set email
                $params['email'] = trim($user_data['data']['email']);

            }

            // Verify if the first name exists
            if ( isset($user_data['data']['first_name']) ) {

                // Set first_name
                $params['first_name'] = trim($user_data['data']['first_name']);

            }
            
            // Verify if the last name exists
            if ( isset($user_data['data']['last_name']) ) {

                // Set last_name
                $params['last_name'] = trim($user_data['data']['last_name']);

            }

            // Set success message
            $params['success_message'] = $this->CI->lang->line('auth_signup_fill_in_all_required_fields');            

        } else {

            // Set error message
            $params['error_message'] = $user_data['message'];

        }

        // Making temlate and send data to view.
        $this->CI->template['header'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views/layout', 'header', array(), true);
        $this->CI->template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views', 'main', $params, true);
        $this->CI->template['footer'] = $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP .  '/views/layout', 'footer', array(), true);
        $this->CI->load->ext_view(MIDRUB_BASE_AUTH_SIGNUP . '/views/layout', 'index', $this->CI->template);
        
    }

}
