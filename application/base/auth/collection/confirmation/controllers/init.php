<?php
/**
 * Init Controller
 *
 * This file loads the Confirmation Auth Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Confirmation\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Confirmation Component
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
        $this->CI->lang->load( 'auth_confirmation', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_CONFIRMATION );

        // Load the Base Users Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_users', 'base_users' );
        
    }
    
    /**
     * The public method view loads the settings's template
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function view() {

        // Verify if activation code and user id exists
        if ( $this->CI->input->get('code', true) && $this->CI->input->get('f', true) ) {

            if ( is_numeric($this->CI->input->get('code', true)) AND is_numeric($this->CI->input->get('f', true)) ) {
            
                // Check if activation code is valid
                if ( !$this->CI->base_model->the_data_where(
                    'users',
                    'user_id',
                    array(
                        'user_id' => $this->CI->input->get('f', true),
                        'activate' => $this->CI->input->get('code', true)
                    )

                ) ) {
                    
                    echo $this->CI->lang->line('auth_confirmation_invalid_code');
                    
                } else {
                    
                    // Activate the user account
                    $this->CI->base_model->update_ceil('users', array('user_id' => $this->CI->input->get('f', true)), array('status' => 1));

                    // Verify if the account was activated
                    if ( $this->CI->base_model->the_data_where( 'users', 'user_id', array( 'user_id' => $this->CI->input->get('f', true), 'status' => 1 ) ) ) {
                        
                        // Check if user session exists
                        if ( isset($this->CI->session->userdata['username']) ) {

                            echo $this->CI->lang->line('auth_confirmation_congratulations_account_activated');

                            $login_page = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

                            // Redirect to the login page
                            echo '<meta http-equiv="refresh" content="3;url=' . $login_page . '" />';
                            exit();

                        }

                        // Get user name by user_id
                        $user = $this->CI->base_users->get_user_ceil('username', $this->CI->input->get('f', true));
                        
                        if ( $user ) {

                            $this->CI->user->last_access($this->CI->input->get('f', true));
                            $this->CI->session->set_userdata('username', $user[0]->username);
                            $this->CI->session->set_userdata('autodelete', time() + 7200);

                            echo $this->CI->lang->line('auth_confirmation_congratulations_account_activated');

                            $login_page = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

                            // Redirect to the login page
                            echo '<meta http-equiv="refresh" content="3;url=' . $login_page . '" />';
                            
                        } else {
                            
                            echo $this->CI->lang->line('auth_confirmation_congratulations_account_please_sign_in');

                            $login_page = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

                            // Redirect to the login page
                            echo '<meta http-equiv="refresh" content="3;url=' . $login_page . '" />';                        
                            
                        }
                        
                    } else {
                        
                        echo $this->CI->lang->line('auth_confirmation_account_not_activated');
                        
                    }
                    
                }

                exit();
                
            }

        }
           

        // If session exists, redirect user
        if ( !md_the_user_session() ) {
            redirect('/');
        } else {
            if ( md_the_user_session()['status'] === '1' ) {
                redirect('/');
            }
        }

        // Get component's title
        $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):$this->CI->lang->line('auth_confirmation_page_title');

        // Set page's title
        md_set_the_title($title);

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/confirmation/styles/css/styles.css?ver=' . CMS_BASE_AUTH_CONFIRMATION_VERSION), 'text/css', 'all'));

        // Set javascript links
        md_set_js_urls(array(base_url('assets/base/auth/collection/confirmation/js/main.js?ver=' . CMS_BASE_AUTH_CONFIRMATION_VERSION)));

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
        $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_CONFIRMATION .  '/views/layout', 'header', array(), true);
        $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_CONFIRMATION .  '/views', 'main', array(), true);
        $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_CONFIRMATION .  '/views/layout', 'footer', array(), true);
        $this->CI->load->ext_view(CMS_BASE_AUTH_CONFIRMATION . '/views/layout', 'index', $this->CI->template);
        
    }

}
