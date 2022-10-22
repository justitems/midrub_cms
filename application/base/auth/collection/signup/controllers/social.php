<?php
/**
 * Social Controller
 *
 * This file connects user by using networks
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Signup\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Get Inc file
require_once CMS_BASE_PATH . 'inc/curl/get.php';   

// Require the Post Inc file
require_once CMS_BASE_PATH . 'inc/curl/post.php';   

/*
 * Social class connects user by using networks
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Social {
    
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
        $this->CI->lang->load( 'auth_signup', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNUP );
        
    }
    
    /**
     * The public method connect redirects user to the network
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function connect($network) {

        // Verify if network exists
        if ( !file_exists(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !md_the_option('auth_network_' . strtolower($network) . '_enabled') ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_enabled'));
            exit();

        }

        // Require network
        require_once CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php';

        // Create an array
        $array = array(
            'CmsBase',
            'Admin',
            'Components',
            'Collection',
            'Frontend',
            'Networks',
            'Collection',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_configured'));
            exit();            

        }

        // Set the sign up page
        $sign_up = md_the_url_by_page_role('sign_up') ? md_the_url_by_page_role('sign_up') : site_url('auth/signup');

        // Redirect user
        (new $cl())->connect($sign_up . '/' . $network);
        
    }

    /**
     * The public method login tries to login the user
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.8.5
     * 
     * @return array with error message or void
     */
    public function login($network) {

        // Verify if network exists
        if ( !file_exists(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !md_the_option('auth_network_' . strtolower($network) . '_enabled') ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_enabled'));
            exit();

        }

        // Require network
        require_once CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php';

        // Create an array
        $array = array(
            'CmsBase',
            'Admin',
            'Components',
            'Collection',
            'Frontend',
            'Networks',
            'Collection',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signup_network_not_configured'));
            exit();            

        }

        // Set the sign up page
        $sign_up = md_the_url_by_page_role('sign_up') ? md_the_url_by_page_role('sign_up') : site_url('auth/signup');

        // Try to get user's data
        $user_data = (new $cl())->callback($sign_up . '/' . $network);

        // Verify if the response is positive
        if ( !empty($user_data['success']) ) {

            // Verify if the account is already connected
            if ( $this->CI->base_model->the_data_where(
                    'users_social',
                    'social_id',
                    array(
                        'network_name' => $network,
                        'net_id' => $user_data['data']['net_id'],
                    )
                ) 
            ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('auth_signup_account_already_connected')
                    ),
                    TRUE
                );

            } else {

                // Account parameters
                $account_params = array(
                    'user_id' => md_the_user_id(),
                    'network_name' => $network,
                    'net_id' => $user_data['data']['net_id'],
                    'user_name' => $user_data['data']['user_name'],
                    'created' => time()
                );

                // Save the account
                $save = $this->CI->base_model->insert(
                    'users_social',
                    $account_params
                );

                // Verify if the account was saved
                if ( $save ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_success',
                        array(
                            'message' => $this->CI->lang->line('auth_signup_account_connected')
                        ),
                        TRUE
                    );

                } else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('auth_signup_account_not_connected')
                        ),
                        TRUE
                    );

                }

            }

        } else {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $user_data['message']
                ),
                TRUE
            );
            
        }
        
    }

}

/* End of file social.php */