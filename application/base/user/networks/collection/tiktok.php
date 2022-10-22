<?php
/**
 * Tiktok
 *
 * PHP Version 7.4
 *
 * Connect Tiktok
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\User\Networks\Collection;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\User\Interfaces as CmsBaseUserInterfaces;

/**
 * Tiktok class - allows users to connect to their Tiktok's accounts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Tiktok implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $redirect_url, $client_key, $client_secret, $api_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();

        // Get the Tiktok client key
        $this->client_key = md_the_option('network_tiktok_client_key');
        
        // Get the Tiktok client secret
        $this->client_secret = md_the_option('network_tiktok_client_secret');
        
        // Tiktok CallBack
        $this->redirect_url = site_url('user/callback/tiktok');

        // Set the api url
        $this->api_url = 'https://open-api.tiktok.com/';
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
            
        // Verify if client_key and client_secret exists
        if ( ($this->client_key != '') and ( $this->client_secret != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method connect requests the access token
     *
     * @return void
     */
    public function connect() {

        // Prepare params to send
        $params = array(
            'client_key' => $this->client_key,
            'response_type' => 'code',
            'redirect_uri' => $this->redirect_url,
            'scope' => 'user.info.basic,video.upload',
            'state' => time()
        );

        // Generate redirect url
        $loginUrl = $this->api_url . 'platform/oauth/connect/' . '?' . urldecode(http_build_query($params));

        // Redirect
        header('Location:' . $loginUrl);

    }

    /**
     * The public method callback generates the access token
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function callback($token = null) {

        // Verify if the code exists
        if ( !$this->CI->input->get('code', TRUE) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $this->CI->lang->line('user_network_code_parameter_missing')
                ),
                TRUE
            );

            exit();

        }

        // Ask for access token
        $the_token = json_decode(md_the_post(array(
            'url' => $this->api_url . 'oauth/access_token/',
            'fields' => array(
                'client_key' => $this->client_key,
                'client_secret' => $this->client_secret,
                'code' => $this->CI->input->get('code', TRUE),
                'grant_type' => 'authorization_code'
            )

        )), TRUE);

        // Verify if the refresh token exists
        if ( empty($the_token['data']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $this->CI->lang->line('user_networks_refresh_token_is_missing')
                ),
                TRUE
            );

            exit();

        }

        // Verify if the refresh token exists
        if ( empty($the_token['data']['refresh_token']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $this->CI->lang->line('user_networks_refresh_token_is_missing')
                ),
                TRUE
            );

            exit();

        }

        // User parameters
        $user_params = array(
            'access_token' => $the_token['data']['access_token'],
            'open_id' => $the_token['data']['open_id'],
            'fields' => array('open_id', 'union_id', 'display_name', 'avatar_url')
        );

        // Initialize the CURL session
        $curl = curl_init();

        // Set url
        curl_setopt($curl, CURLOPT_URL, $this->api_url . 'user/info/');

        // Enable post
        curl_setopt($curl, CURLOPT_POST, true);

        // Set post's fields
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($user_params));

        // Enable return
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type' => 'application/json'
        ));

        // Send request
        $the_user = json_decode(curl_exec($curl), TRUE);

        // Close CURL session
        curl_close($curl);

        // Verify if the error exists
        if ( empty($the_user['data']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $the_user['error']['message']
                ),
                TRUE
            );

            exit();

        }

        // Get the tiktok's account
        $the_tiktok_account = $this->CI->base_model->the_data_where(
            'networks',
            'network_id',
            array(
                'network_name' => 'tiktok',
                'net_id' => $the_user['data']['user']['open_id'],
                'user_id' => md_the_user_id()
            )

        );

        // Verify if the account is already connected
        if ( $the_tiktok_account ) {

            // Update the account
            $update = $this->CI->base_model->update(
                'networks',
                array(
                    'network_name' => 'tiktok',
                    'net_id' => $the_user['data']['user']['open_id'],
                    'user_id' => md_the_user_id()
                ),
                array(
                    'user_name' => $the_user['data']['user']['display_name'],
                    'user_avatar' => $the_user['data']['user']['avatar_url'],
                    'token' => $the_token['data']['refresh_token']
                )

            );

            // Verify if the account was updated
            if ( $update ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_account_was_updated')
                    ),
                    TRUE
                );

            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_account_was_not_updated')
                    ),
                    TRUE
                );
                
            }

        } else {

            // Save the account
            $the_response = $this->CI->base_model->insert(
                'networks',
                array(
                    'network_name' => 'tiktok',
                    'net_id' => $the_user['data']['user']['open_id'],
                    'user_id' => md_the_user_id(),
                    'user_name' => $the_user['data']['user']['display_name'],
                    'user_avatar' => $the_user['data']['user']['avatar_url'],
                    'token' => $the_token['data']['refresh_token']
                )

            );

            // Verify if the account was saved
            if ( $the_response ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_account_was_connected')
                    ),
                    TRUE
                );

            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_account_was_not_connected')
                    ),
                    TRUE
                );
                
            }

        }
        
    }

    /**
     * The public method actions executes the actions
     *
     * @param string $action contains the action's name
     * @param array $params contains the request's params
     * 
     * @return array with response
     */
    public function actions($action, $params) {



    }

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info() {
        
        return array(
            'network_name' => 'Tiktok',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_tiktok_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_tiktok_enabled')?md_the_option('network_tiktok_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_tiktok_client_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Tiktok Client Key',
                            'field_description' => 'The client\'s key could be found in <a href="https://developers.tiktok.com/apps" target="_blank">https://developers.tiktok.com/apps</a> -> Applications -> your app.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's key ...",
                            'value' => md_the_option('network_tiktok_client_key')?md_the_option('network_tiktok_client_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_tiktok_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Tiktok Client Secret',
                            'field_description' => 'The client\'s secret could be found in <a href="https://developers.tiktok.com/apps" target="_blank">https://developers.tiktok.com/apps</a> -> Applications -> your app.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret ...",
                            'value' => md_the_option('network_tiktok_client_secret')?md_the_option('network_tiktok_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_tiktok_redirect_domain',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Domain',
                            'field_description' => "The redirect domain should be used in the Tiktok application."
                        ),
                        'field_params' => array(
                            'placeholder' => '',
                            'value' => $_SERVER['SERVER_NAME'],
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file tiktok.php */