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
namespace CmsBase\User\Networks\Collection;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\User\Interfaces as CmsBaseUserInterfaces;  

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
    public $CI, $client_id, $client_secret, $twitter_api_url, $app_key, $app_secret, $request_token_url, $authenticate_url, $access_token_url, $verify_credentials_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Twitter Client id
        $this->client_id = md_the_option('network_twitter_client_id');
        
        // Set the Twitter Client secret
        $this->client_secret = md_the_option('network_twitter_client_secret');

        // Set the Twitter App Key
        $this->app_key = md_the_option('network_twitter_app_key');
        
        // Set the Twitter App Secret
        $this->app_secret = md_the_option('network_twitter_app_secret');

        // Set the Twitter Api URL
        $this->twitter_api_url = 'https://api.twitter.com/2/';

        // Set the request token url
        $this->request_token_url = 'https://api.twitter.com/oauth/request_token';

        // Set authenticate url
        $this->authenticate_url = 'https://api.twitter.com/oauth/authenticate';

        // Set access token url
        $this->access_token_url = 'https://api.twitter.com/oauth/access_token';

        // Set credentials url
        $this->verify_credentials_url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
            
        // Verify if client_id and client_secret exists
        if ( ($this->client_id != '') AND ( $this->client_secret != '') && ($this->app_key != '') AND ( $this->app_secret != '') ) {
            
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
        $the_url = 'https://twitter.com/i/oauth2/authorize?' . http_build_query($params) . '&scope=' . implode('%20', $scopes) . '&redirect_uri=' . site_url('user/callback/twitter');
        
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

        // Verify if state exists
        if ( !$this->CI->input->get('state', TRUE) ) {

            // Verify if the code exists
            if ( !$this->CI->input->get('oauth_token', TRUE) || !$this->CI->input->get('oauth_verifier', TRUE) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_no_oauth_token_verifier_found')
                    ),
                    TRUE
                );
                exit();

            }

            // Send request
            parse_str(md_the_post(array(
                'url' => $this->access_token_url . '?oauth_verifier=' . $this->CI->input->get('oauth_verifier', TRUE) . '&oauth_token=' . $this->CI->input->get('oauth_token', TRUE)
            )), $response);

            // Verify if the code exists
            if ( empty($response['oauth_token']) || empty($response['oauth_token_secret']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_oauth_token_oauth_token_secret_not_generated')
                    ),
                    TRUE
                );
                exit();

            }
            
            // Prepare the oauth params
            $oauth_params = array(
                'oauth_consumer_key' => $this->app_key,
                'oauth_token' => $response['oauth_token'],
                'oauth_nonce' => md5(uniqid()),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_timestamp' => time(),
                'oauth_version' => '1.1'
            );

            // Base string
            $base_string = array();
            
            // Sort oauth params
            ksort($oauth_params);
        
            // List oauth params
            foreach($oauth_params as $key => $value){

                // Add key
                $base_string[] = "$key=" . rawurlencode($value);

            }
        
            // Set the prepared base string
            $the_prepared_string = 'GET&' . rawurlencode($this->verify_credentials_url) . '&' . rawurlencode(implode('&', $base_string));
            
            // Set the key
            $the_secret_key = rawurlencode($this->app_secret) . '&' . rawurlencode($response['oauth_token_secret']);
            
            // Set the oauth signature
            $oauth_params['oauth_signature'] = base64_encode(hash_hmac('sha1', $the_prepared_string, $the_secret_key, true));

            // Header for curl
            $curl_header = 'Authorization: OAuth ';

            // Values container
            $values = array();
        
            // List the oauth params
            foreach($oauth_params as $key => $value) {

                // Add key to values
                $values[] = "$key=\"" . rawurlencode( $value ) . "\"";

            }
        
            // Turn values to string
            $curl_header .= implode(', ', $values);
        
            // Init Curl
            $curl = curl_init();

            // Set options
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->verify_credentials_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array($curl_header, 'Expect:')
            ));

            // Get the response
            $the_response = json_decode(curl_exec($curl), TRUE);
        
            // Close Curl
            curl_close($curl);

            // Verify if errors exists
            if ( !empty($the_response['errors']) ) {

                // Verify if errors message exists
                if ( !empty($the_response['errors'][0]['message']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $the_response['errors'][0]['message']
                        ),
                        TRUE
                    );
                    exit();              

                }

            }

            // Verify if the id exists
            if ( !empty($the_response['id']) ) {

                // Get the twitter's account
                $the_twitter_account = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id',
                    array(
                        'network_name' => 'twitter',
                        'net_id' => $the_response['id'],
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if the account is already connected
                if ( $the_twitter_account ) {

                    // Update the account
                    $this->CI->base_model->update(
                        'networks',
                        array(
                            'network_name' => 'twitter',
                            'net_id' => (string)$the_response['id'],
                            'user_id' => md_the_user_id()
                        ),
                        array(
                            'user_name' => $the_response['name'],
                            'api_key' => $response['oauth_token'],
                            'api_secret' => $response['oauth_token_secret']
                        )

                    );
                        
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

                    // Save the account
                    $the_response = $this->CI->base_model->insert(
                        'networks',
                        array(
                            'network_name' => 'twitter',
                            'net_id' => $the_response['id'],
                            'user_id' => md_the_user_id(),
                            'user_name' => $the_response['name'],
                            'api_key' => $response['oauth_token'],
                            'api_secret' => $response['oauth_token_secret']
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

            } else {

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

        } else {

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

            // Params for request
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => site_url('user/callback/twitter'),
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

            // Verify if the refresh token exists
            if ( empty($the_token['refresh_token']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => !empty($the_token['error_description'])?$the_token['error_description']:$this->CI->lang->line('user_social_an_error_occurred')
                    ),
                    TRUE
                );
                exit();

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

                // Get the twitter's account
                $the_twitter_account = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id',
                    array(
                        'network_name' => 'twitter',
                        'net_id' => $the_profile['data']['id'],
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if the account is already connected
                if ( $the_twitter_account ) {

                    // Update the account
                    $update = $this->CI->base_model->update(
                        'networks',
                        array(
                            'network_name' => 'twitter',
                            'net_id' => $the_profile['data']['id'],
                            'user_id' => md_the_user_id()
                        ),
                        array(
                            'user_name' => $the_profile['data']['name'],
                            'token' => $the_token['refresh_token']
                        )

                    );

                    // Verify if the account was updated
                    if ( $update ) {
                        
                        // Set header
                        header('Content-Type: application/json');
                        header('Access-Control-Allow-Origin: *');
                        
                        // Prepare the oauth params
                        $oauth_params = array(
                            'oauth_callback' => site_url('user/callback/twitter'),
                            'oauth_consumer_key' => $this->app_key,
                            'oauth_nonce' => md5(uniqid()),
                            'oauth_signature_method' => 'HMAC-SHA1',
                            'oauth_timestamp' => time(),
                            'oauth_version' => '2.0',
                        );

                        // Base string
                        $base_string = array();
                        
                        // Sort oauth params
                        ksort($oauth_params);
                    
                        // List oauth params
                        foreach($oauth_params as $key => $value){

                            // Add key
                            $base_string[] = "$key=" . rawurlencode($value);

                        }
                    
                        // Set the prepared base string
                        $the_prepared_string = 'POST&' . rawurlencode($this->request_token_url) . '&' . rawurlencode(implode('&', $base_string));
                        
                        // Set the key
                        $the_secret_key = rawurlencode($this->app_secret) . '&' . rawurlencode(null);
                        
                        // Set the oauth signature
                        $oauth_params['oauth_signature'] = base64_encode(hash_hmac('sha1', $the_prepared_string, $the_secret_key, true));

                        // Header for curl
                        $curl_header = 'Authorization: OAuth ';

                        // Values container
                        $values = array();
                    
                        // List the oauth params
                        foreach($oauth_params as $key => $value) {

                            // Add key to values
                            $values[] = "$key=\"" . rawurlencode( $value ) . "\"";

                        }
                    
                        // Turn values to string
                        $curl_header .= implode(', ', $values);
                    
                        // Init Curl
                        $curl = curl_init();

                        // Set options
                        curl_setopt_array($curl, array(
                            CURLOPT_HTTPHEADER => array($curl_header, 'Expect:'),
                            CURLOPT_HEADER => false,
                            CURLOPT_URL => $this->request_token_url,
                            CURLOPT_POST => true,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_SSL_VERIFYPEER => false,
                        ));

                        // Get the response
                        parse_str(curl_exec($curl), $response);
                    
                        // Close Curl
                        curl_close($curl);

                        // Verify if oauth_token exists
                        if ( !empty($response['oauth_token']) ) {

                            // Set url
                            $the_url = $this->authenticate_url . '?oauth_token=' . $response['oauth_token'];
                            
                            // Redirect
                            header('Location:' . $the_url);

                        } else {

                            // Display error
                            echo $this->CI->lang->line('user_oauth_token_missing');

                        }

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

                } else {

                    // Save the account
                    $save = $this->CI->base_model->insert(
                        'networks',
                        array(
                            'network_name' => 'twitter',
                            'net_id' => $the_profile['data']['id'],
                            'user_id' => md_the_user_id(),
                            'user_name' => $the_profile['data']['name'],
                            'token' => $the_token['refresh_token']
                        )

                    );
                    
                    // Verify if the account was saved
                    if ( $save ) {

                        // Set header
                        header('Content-Type: application/json');
                        header('Access-Control-Allow-Origin: *');
                        
                        // Prepare the oauth params
                        $oauth_params = array(
                            'oauth_callback' => site_url('user/callback/twitter'),
                            'oauth_consumer_key' => $this->app_key,
                            'oauth_nonce' => md5(uniqid()),
                            'oauth_signature_method' => 'HMAC-SHA1',
                            'oauth_timestamp' => time(),
                            'oauth_version' => '2.0',
                        );

                        // Base string
                        $base_string = array();
                        
                        // Sort oauth params
                        ksort($oauth_params);
                    
                        // List oauth params
                        foreach($oauth_params as $key => $value){

                            // Add key
                            $base_string[] = "$key=" . rawurlencode($value);

                        }
                    
                        // Set the prepared base string
                        $the_prepared_string = 'POST&' . rawurlencode($this->request_token_url) . '&' . rawurlencode(implode('&', $base_string));
                        
                        // Set the key
                        $the_secret_key = rawurlencode($this->app_secret) . '&' . rawurlencode(null);
                        
                        // Set the oauth signature
                        $oauth_params['oauth_signature'] = base64_encode(hash_hmac('sha1', $the_prepared_string, $the_secret_key, true));

                        // Header for curl
                        $curl_header = 'Authorization: OAuth ';

                        // Values container
                        $values = array();
                    
                        // List the oauth params
                        foreach($oauth_params as $key => $value) {

                            // Add key to values
                            $values[] = "$key=\"" . rawurlencode( $value ) . "\"";

                        }
                    
                        // Turn values to string
                        $curl_header .= implode(', ', $values);
                    
                        // Init Curl
                        $curl = curl_init();

                        // Set options
                        curl_setopt_array($curl, array(
                            CURLOPT_HTTPHEADER => array($curl_header, 'Expect:'),
                            CURLOPT_HEADER => false,
                            CURLOPT_URL => $this->request_token_url,
                            CURLOPT_POST => true,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_SSL_VERIFYPEER => false,
                        ));

                        // Get the response
                        parse_str(curl_exec($curl), $response);
                    
                        // Close Curl
                        curl_close($curl);

                        // Verify if oauth_token exists
                        if ( !empty($response['oauth_token']) ) {

                            // Set url
                            $the_url = $this->authenticate_url . '?oauth_token=' . $response['oauth_token'];
                            
                            // Redirect
                            header('Location:' . $the_url);

                        } else {

                            // Display error
                            echo $this->CI->lang->line('user_oauth_token_missing');

                        }

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

            } else if ( !empty($the_token['error_description']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $the_token['error_description']
                    ),
                    TRUE
                );

            } else {

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
            'network_name' => 'Twitter',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_twitter_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_twitter_enabled')?md_the_option('network_twitter_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_twitter_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter Client id',
                            'field_description' => "The Twitter's client id could be found in the Twitter Developer -> App -> OAuth 2.0 Client ID and Client Secret."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_twitter_client_id')?md_the_option('network_twitter_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_twitter_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter Client secret',
                            'field_description' => "The Twitter's client secret code could be found in the Twitter Developer -> App -> OAuth 2.0 Client ID and Client Secret."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('network_twitter_client_secret')?md_the_option('network_twitter_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_twitter_app_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter App Key',
                            'field_description' => "The Twitter's app Key could be found in the Twitter Developer -> App -> Consumer Keys."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's key ...",
                            'value' => md_the_option('network_twitter_app_key')?md_the_option('network_twitter_app_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_twitter_app_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Twitter App Secret',
                            'field_description' => "The Twitter's app secret code could be found in the Twitter Developer -> App -> Consumer Keys."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('network_twitter_app_secret')?md_the_option('network_twitter_app_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_twitter_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "The additional scopes could be requested by some apps. The scopes should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_twitter_scopes')?md_the_option('network_twitter_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_twitter_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Twitter application."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/twitter'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }

}

/* End of file twitter.php */