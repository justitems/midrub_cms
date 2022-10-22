<?php
/**
 * Facebook
 *
 * PHP Version 7.4
 *
 * Connect Facebook
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
 * Facebook class - allows users to connect to their Facebook
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Facebook implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $app_id, $app_secret, $api_version = 'v12.0';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Facebook App ID
        $this->app_id = md_the_option('auth_network_facebook_app_id');
        
        // Set the Facebook App Secret
        $this->app_secret = md_the_option('auth_network_facebook_app_secret');

        // Set the Facebook Api Version
        $this->api_version = md_the_option('auth_network_facebook_api_version')?md_the_option('auth_network_facebook_api_version'):$this->api_version;

        // Load the Main Component Language
        $this->CI->lang->load( 'frontend_social', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND);
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
        
        // Verify if app_id and app_secret exists
        if ( ($this->app_id != '') AND ( $this->app_secret != '') ) {
            
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

        // Permissions to request
        $permissions = array(
            'email'
        );

        // Prepare parameters for url
        $params = array(
            'client_id' => $this->app_id,
            'state' => time(),
            'response_type' => 'code',
            'redirect_uri' => $redirect_url,
            'scope' => implode(',', $permissions)
        );
        
        // Set url
        $the_url = 'https://www.facebook.com/' . $this->api_version . '/dialog/oauth?' . http_build_query($params);
        
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

        // Set the sign in page
        $sign_in = md_the_url_by_page_role('sign_in')?md_the_url_by_page_role('sign_in'):site_url('auth/signin');

        // Prepare the fields
        $fields = array(
            'client_id' => $this->app_id,
            'client_secret' => $this->app_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_url,
            'code' => $this->CI->input->get('code', TRUE)
        );

        // Send request
        $the_token = json_decode(md_the_post(array(
            'url' => 'https://graph.facebook.com/' . $this->api_version . '/oauth/access_token',
            'fields' => $fields
        )), TRUE);

        // Verify if error exists
        if ( !empty($the_token['error']) ) {

            // Verify if error's message exists
            if ( !empty($the_token['error']['message']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $the_token['error']['message']
                );                 

            }

        }

        // Send request
        $the_profile = json_decode(md_the_post(array(
            'url' => 'https://graph.facebook.com/me?fields=id,name,email&access_token=' . $the_token['access_token']
        )), TRUE);

        // Verify if the id exists
        if ( !empty($the_profile['id']) ) {

            // Data to return
            $data = array(
                'network_name' => 'facebook',
                'net_id' => $the_profile['id'],
                'user_name' => $the_profile['name']
            );

            // Verify if email exists
            if ( !empty($the_profile['email']) ) {

                // Set email
                $data['email'] = $the_profile['email'];

            }

            // Return data
            return array(
                'success' => TRUE,
                'data' => $data
            );

        } else {

            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('frontend_social_an_error_occurred')
            );

        }
        
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
            'network_name' => 'Facebook',
            'network_version' => '0.1',
            'network_color' => '#3b5998',
            'network_icon' => '<i class="fab fa-facebook-f"></i>',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'auth_network_facebook_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('auth_network_facebook_enabled')?md_the_option('auth_network_facebook_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'auth_network_facebook_app_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook App ID',
                            'field_description' => "The Facebook's app ID could be found in the Facebook Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('auth_network_facebook_app_id')?md_the_option('auth_network_facebook_app_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_facebook_app_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook App Secret',
                            'field_description' => "The Facebook's app secret code could be found in the Facebook Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('auth_network_facebook_app_secret')?md_the_option('auth_network_facebook_app_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_facebook_api_version',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook Api Version',
                            'field_description' => "The Facebook api's version is optionally."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the api's version ...",
                            'value' => md_the_option('auth_network_facebook_api_version')?md_the_option('auth_network_facebook_api_version'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_facebook_sign_up_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Sign Up Redirect Url',
                            'field_description' => "The sign up redirect url should be used in the Login product from your Facebook app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => $sign_up . '/facebook',
                            'disabled' => true
                        )

                    ),
                    array(
                        'field_slug' => 'auth_network_facebook_sign_in_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Sign In Redirect Url',
                            'field_description' => "The sign in redirect url should be used in the Login product from your Facebook app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => $sign_in . '/facebook',
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file facebook.php */