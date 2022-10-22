<?php
/**
 * Twitter
 *
 * PHP Version 7.4
 *
 * Connect Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Networks\Collection;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Frontend\Interfaces as CmsBaseUserInterfaces;

/**
 * Twitter class - allows users to connect to their Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Twitter implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $twitter_api_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();

        // Set the Twitter Client id
        $this->client_id = md_the_option('auth_network_twitter_client_id');
        
        // Set the Twitter Client secret
        $this->client_secret = md_the_option('auth_network_twitter_client_secret');

        // Set the Twitter Api URL
        $this->twitter_api_url = 'https://api.twitter.com/2/';

        // Load the Main Component Language
        $this->CI->lang->load( 'frontend_social', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND);
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
        
        // Verify if client_id and client_secret exists
        if ( ($this->client_id != '') AND ( $this->client_secret != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method connect requests the access token
     *
     * @param string $redirect_url contains the redirect's url
     * 
     * @return void
     */
    public function connect($redirect_url) {

        // Scopes to request
        $scopes = array(
            'offline.access',
            'users.read'
        );

        // Verify if additional scopes exists
        if ( md_the_option('network_twitter_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_twitter_scopes');

            if ( count(explode(',', $the_scopes)) > 0 ) {

                // List the scopes
                foreach ( explode(',', $the_scopes) as $scope ) {

                    // Verify if scope is valid
                    if ( !empty($scope) ) {

                        // Verify if scope exists in the list
                        if ( in_array(trim($scope), $scopes) ) {
                            continue;
                        }

                        // Set scope
                        $scopes[] = trim($scope);

                    }

                }

            }

        }

        // Prepare parameters for url
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'state' => uniqid(),
            'code_challenge' => 'challenge',
            'code_challenge_method' => 'plain',            
        );

        // Set url
        $the_url = 'https://twitter.com/i/oauth2/authorize?' . http_build_query($params) . '&scope=' . implode('%20', $scopes) . '&redirect_uri=' . $redirect_url;
        
        // Redirect
        header('Location:' . $the_url);

    }

    /**
     * The public method callback generates the access token
     * 
     * @param string $redirect_url contains the redirect's url
     * 
     * @return array with response
     */
    public function callback($redirect_url) {

        // Verify if the code exists
        if ( !$this->CI->input->get('code', TRUE) ) {

            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('frontend_social_no_code_was_found')
            );

        }

        // Params for request
        $params = array(
            'grant_type' => 'authorization_code',
            'code' => $this->CI->input->get('code', TRUE),
            'redirect_uri' => $redirect_url,
            'client_id' => $this->client_id,
            'code_verifier' => 'challenge'
        );

        // Init curl
        $curl = curl_init();

        // Set url
        curl_setopt($curl, CURLOPT_URL, $this->twitter_api_url . 'oauth2/token');

        // Post method
        curl_setopt($curl, CURLOPT_POST, 1);

        // Set fields
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

        // Set header
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/x-www-form-urlencoded'
            )
        );

        // Enable return
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute response
        $the_token = json_decode(curl_exec($curl), true);

        // Close curl
        curl_close ($curl);

        // Verify if the access token exists
        if ( empty($the_token['access_token']) ) {

            return array(
                'success' => FALSE,
                'message' => !empty($the_token['error_description'])?$the_token['error_description']:$this->CI->lang->line('frontend_social_an_error_occurred')
            );

        }
        
        // Init curl
        $curl = curl_init();

        // Set url
        curl_setopt($curl, CURLOPT_URL, $this->twitter_api_url . 'users/me');

        // Set header
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Bearer ' . $the_token['access_token']
            )
        );

        // Enable transfer
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute curl request
        $the_profile = json_decode(curl_exec ($curl), true);

        // Close curl
        curl_close ($curl);

        // Verify if the data exists
        if ( !empty($the_profile['data']) ) {

            // Data to return
            $data = array(
                'network_name' => 'twitter',
                'net_id' => $the_profile['data']['id'],
                'user_name' => $the_profile['data']['name'],
                'email' => $the_profile['data']['username'] . '@twitter.com'
            );


            // Return data
            return array(
                'success' => TRUE,
                'data' => $data
            );

        }

        return array(
            'success' => FALSE,
            'message' => !empty($the_profile['detail'])?$the_profile['detail']:$this->CI->lang->line('frontend_social_an_error_occurred')
        );

    }
    
    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info() {

        // Set the sign in page
        $sign_in = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

        // Set the sign up page
        $sign_up = md_the_url_by_page_role('sign_up')?md_the_url_by_page_role('sign_up'):site_url('auth/signup');
        
        return array(
            'network_name' => 'Twitter',
            'network_version' => '0.1',
            'network_color' => '#1d9bf0',
            'network_icon' => '<i class="fab fa-twitter"></i>',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'auth_network_twitter_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('auth_network_twitter_enabled')?md_the_option('auth_network_twitter_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'auth_network_twitter_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter Client id',
                            'field_description' => "The Twitter's client id could be found in the Twitter Developer -> App -> OAuth 2.0 Client ID and Client Secret."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('auth_network_twitter_client_id')?md_the_option('auth_network_twitter_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_twitter_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter Client secret',
                            'field_description' => "The Twitter's client secret code could be found in the Twitter Developer -> App -> OAuth 2.0 Client ID and Client Secret."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('auth_network_twitter_client_secret')?md_the_option('auth_network_twitter_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_twitter_sign_up_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Sign Up Redirect Url',
                            'field_description' => "The sign up redirect url should be used in the Login product from your Twitter app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => $sign_up . '/twitter',
                            'disabled' => true
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_twitter_sign_in_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Sign In Redirect Url',
                            'field_description' => "The sign in redirect url should be used in the Login product from your Twitter app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => $sign_in . '/twitter',
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }

}

/* End of file twitter.php */