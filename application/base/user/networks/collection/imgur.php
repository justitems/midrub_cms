<?php
/**
 * Imgur
 *
 * PHP Version 7.4
 *
 * Connect Imgur profiles
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

// Require the POST Inc file
require_once CMS_BASE_PATH . 'inc/curl/post.php';

/**
 * Imgur class - allows users to connect to their Imgur profiles
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Imgur implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_uri, $api_endpoint = 'https://www.imgur.com/oauth/v2';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Imgur Client ID
        $this->client_id = md_the_option('network_imgur_client_id');
        
        // Set the Imgur Client Secret
        $this->client_secret = md_the_option('network_imgur_client_secret');

        // Set the redirect's url
        $this->redirect_uri = site_url('user/callback/imgur'); 
        
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
     * @return void
     */
    public function connect() {

        // Prepare parameters for url
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'state' => 'code'
        );
        
        // Set url
        $the_url = 'https://api.imgur.com/oauth2/authorize' . '?' . http_build_query($params);
        
        // Redirect
        header('Location:' . $the_url);

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
            'url' => 'https://api.imgur.com/oauth2/token',
            'fields' => array(
                'grant_type' => 'authorization_code',
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => $this->redirect_uri,
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            )

        )), TRUE);

        // Verify if the refresh token exists
        if ( empty($the_token['refresh_token']) ) {

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

        // Get the imgur's account
        $the_imgur_account = $this->CI->base_model->the_data_where(
            'networks',
            'network_id',
            array(
                'network_name' => 'imgur',
                'net_id' => $the_token['account_id'],
                'user_id' => md_the_user_id()
            )

        );

        // Verify if the account is already connected
        if ( $the_imgur_account ) {

            // Update the account
            $update = $this->CI->base_model->update(
                'networks',
                array(
                    'network_name' => 'imgur',
                    'net_id' => $the_token['account_id'],
                    'user_id' => md_the_user_id()
                ),
                array(
                    'user_name' => $the_token['account_username'],
                    'token' => $the_token['refresh_token']
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
                    'network_name' => 'imgur',
                    'net_id' => $the_token['account_id'],
                    'user_id' => md_the_user_id(),
                    'user_name' => $the_token['account_username'],
                    'token' => $the_token['refresh_token']
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
            'network_name' => 'Imgur',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_imgur_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_imgur_enabled')?md_the_option('network_imgur_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_imgur_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Imgur Client ID',
                            'field_description' => "The Imgur's client ID could be found in the Imgur Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_imgur_client_id')?md_the_option('network_imgur_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_imgur_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Imgur Client Secret',
                            'field_description' => "The Imgur's client secret code could be found in the Imgur Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret code ...",
                            'value' => md_the_option('network_imgur_client_secret')?md_the_option('network_imgur_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_imgur_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Imgur client."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/imgur'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file imgur.php */
