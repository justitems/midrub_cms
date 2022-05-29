<?php
/**
 * Youtube
 *
 * PHP Version 7.4
 *
 * Connect Youtube
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
 * Youtube class - allows users to connect to their Youtube's channels
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Youtube implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $api_key, $app_name, $redirect_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();

        // Get the Google's client_id
        $this->client_id = md_the_option('network_youtube_client_id');
        
        // Get the Google's client_secret
        $this->client_secret = md_the_option('network_youtube_client_secret');
        
        // Get the Google's api key
        $this->api_key = md_the_option('network_youtube_api_key');
        
        // Get the Google's application name
        $this->app_name = md_the_option('network_youtube_google_application_name');
        
        // Youtube CallBack
        $this->redirect_url = site_url('user/callback/youtube');
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
            
        // Verify if client_id, client_secret and api_key exists
        if ( ($this->client_id != '') and ( $this->client_secret != '') and ( $this->api_key != '') ) {
            
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

        // Auth params
        $auth_params = array(
            'client_id' => $this->client_id,
            'scope' => 'https://www.googleapis.com/auth/youtube.upload https://www.googleapis.com/auth/youtube https://www.googleapis.com/auth/userinfo.profile',
            'redirect_uri' => $this->redirect_url,
            'response_type' => 'code',
            'access_type' => 'offline',
            'prompt' => 'consent'
        );

        // Set auth's url
        $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . urldecode(http_build_query($auth_params));
        
        // Redirect
        header('Location:' . $auth_url);

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

        // Init the CURL session
        $curl = curl_init();
        
        // Set URL
        curl_setopt($curl, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v4/token');

        // Enable return transfer
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        // Set POST method
        curl_setopt($curl, CURLOPT_POST, 1);
        
        // Disable SSL verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

        // Set POST's fields
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $this->CI->input->get('code', TRUE),
            'redirect_uri' => $this->redirect_url,
            'grant_type' => 'authorization_code',
            'access_type' => 'offline',
            'prompt' => 'consent'
        ));	

        // Decode the access response
        $access_response = json_decode(curl_exec($curl), true);

        // Close the CURL session
        curl_close($curl);
        
        // Verify if error_description exists
        if ( !empty($access_response['error_description']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $access_response['error_description']
                ),
                TRUE
            );
            exit();

        }
            
        // Init the CURL session
        $curl = curl_init();
        
        // Set parameters
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . $access_response['access_token'],
            CURLOPT_HEADER => false
        ));
        
        // Execute request
        $user_information = json_decode(curl_exec($curl), true);
        
        // Close the CURL session
        curl_close($curl);

        // Verify if error_description exists
        if ( !empty($user_information['error_description']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $user_information['error_description']
                ),
                TRUE
            );

            exit();

        }
        
        // Veify if response is valid
        if ($user_information['sub']) {
                
            // Get user's name
            $name = $user_information['name'];
            
            // Get user's picture
            $picture = !empty($user_information['picture'])?$user_information['picture']:'';

            // Get the channel
            $the_channel = $this->CI->base_model->the_data_where(
                'networks',
                'network_id',
                array(
                    'network_name' => 'youtube',
                    'net_id' => $user_information['sub'],
                    'user_id' => md_the_user_id()
                )

            );

            // Verify if the channel is already connected
            if ( $the_channel ) {

                // Update the channel
                $update_channel = $this->CI->base_model->update(
                    'networks',
                    array(
                        'network_id' => $the_connected_channel[0]['network_id']
                    ),
                    array(
                        'user_name' => $user_information['name'],
                        'user_avatar' => $picture,
                        'token' => $access_response['refresh_token']
                    )

                );

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_channel_was_updated')
                    ),
                    TRUE
                );

                exit();

            } else {

                // Save the channel
                $save_response = $this->CI->base_model->insert(
                    'networks',
                    array(
                        'network_name' => 'youtube',
                        'net_id' => $user_information['sub'],
                        'user_id' => md_the_user_id(),
                        'user_name' => $user_information['name'],
                        'user_avatar' => $picture,
                        'token' => $access_response['refresh_token']
                    )

                );

                // Verify if the channel was saved
                if ( $save_response ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_success',
                        array(
                            'message' => $this->CI->lang->line('user_networks_channel_was_saved')
                        ),
                        TRUE
                    );

                    exit();

                }

            }
            
        }

        // Set view
        echo $this->CI->load->ext_view(
            CMS_BASE_PATH . 'user/default/php',
            'network_error',
            array(
                'message' => $this->CI->lang->line('user_social_an_error_occurred')
            ),
            TRUE
        );

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
            'network_name' => 'Youtube',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_youtube_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_youtube_enabled')?md_the_option('network_youtube_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_youtube_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client ID',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_youtube_client_id')?md_the_option('network_youtube_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_youtube_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client Secret',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret ...",
                            'value' => md_the_option('network_youtube_client_secret')?md_the_option('network_youtube_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_youtube_api_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Api Key',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the api's key ...",
                            'value' => md_the_option('network_youtube_api_key')?md_the_option('network_youtube_api_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_youtube_google_application_name',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Application Name',
                            'field_description' => 'The application\'s name from the OAuth client ID.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the application's name ...",
                            'value' => md_the_option('network_youtube_google_application_name')?md_the_option('network_youtube_google_application_name'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_youtube_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Youtube application."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/youtube'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file youtube.php */