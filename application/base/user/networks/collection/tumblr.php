<?php
/**
 * Tumblr
 *
 * PHP Version 7.4
 *
 * Connect Tumblr
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

// If session valiable doesn't exists will be called
if ( !isset($_SESSION) ) {
    session_start();
}

/**
 * Tumblr class - allows users to connect to their Tumblr's blogs
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Tumblr implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $consumer_key, $consumer_secret, $redirect_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();

        // Get the Tumblr consumer key
        $this->consumer_key = md_the_option('network_tumblr_consumer_key');
        
        // Get the Tumblr consumer secret
        $this->consumer_secret = md_the_option('network_tumblr_consumer_secret');
        
        // Tumblr CallBack
        $this->redirect_url = site_url('user/callback/tumblr');
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
            
        // Verify if consumer_key and consumer_secret exists
        if ( ($this->consumer_key != '') and ( $this->consumer_secret != '') ) {
            
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

        // Set header
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        
        // Prepare the oauth params
        $oauth_params = array(
            'oauth_callback' => $this->redirect_url,
            'oauth_consumer_key' => $this->consumer_key,
            'oauth_nonce' => md5(uniqid()),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0',
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
        $the_prepared_string = 'POST&' . rawurlencode('https://www.tumblr.com/oauth/request_token') . '&' . rawurlencode(implode('&', $base_string));
        
        // Set the key
        $the_secret_key = rawurlencode($this->consumer_secret) . '&' . rawurlencode(null);
        
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
            CURLOPT_URL => 'https://www.tumblr.com/oauth/request_token',
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

            $_SESSION['oauth_token'] = $response['oauth_token'];
            $_SESSION['oauth_token_secret'] = $response['oauth_token_secret'];

            // Set url
            $the_url = 'https://www.tumblr.com/oauth/authorize?oauth_token=' . $response['oauth_token'];
            
            // Redirect
            header('Location:' . $the_url);

        } else {

            // Display error
            echo $this->CI->lang->line('user_oauth_token_missing');

        }

    }

    /**
     * The public method callback generates the access token
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function callback($token = null) {

        // Check if data was submitted
        if ($this->CI->input->post()) {
        
            // Define the callback status
            $check = 0;

            // Add form validation
            $this->CI->form_validation->set_rules('oauth_token', 'Oauth Token', 'trim|required');
            $this->CI->form_validation->set_rules('oauth_token_secret', 'Oauth Token Secret', 'trim|required');
            $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim|required');

            // Get post data
            $oauth_token = $this->CI->input->post('oauth_token', TRUE);
            $oauth_token_secret = $this->CI->input->post('oauth_token_secret', TRUE);
            $net_ids = $this->CI->input->post('net_ids', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Prepare the oauth params
                $oauth_params = array(
                    'oauth_consumer_key' => $this->consumer_key,
                    'oauth_token' => $oauth_token,
                    'oauth_token_secret' => $oauth_token_secret,
                    'oauth_nonce' => md5(uniqid()),
                    'oauth_signature_method' => 'HMAC-SHA1',
                    'oauth_timestamp' => time(),
                    'oauth_version' => '1.0'
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
                $the_prepared_string = 'GET&' . rawurlencode('https://api.tumblr.com/v2/user/info') . '&' . rawurlencode(implode('&', $base_string));
                
                // Set the key
                $the_secret_key = rawurlencode($this->consumer_secret) . '&' . rawurlencode($oauth_token_secret);
                
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
                    CURLOPT_URL => 'https://api.tumblr.com/v2/user/info',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array($curl_header, 'Expect:')
                ));

                // Get the user info
                $the_user_info = json_decode(curl_exec($curl), TRUE);
            
                // Close Curl
                curl_close($curl);

                // Verify if the error message exists
                if ( !empty($the_user_info['errors']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $the_user_info['errors'][0]['detail']
                        ),
                        TRUE
                    );
                    exit();

                }

                // Verify if response exists
                if ( empty($the_user_info['response']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_received_response_is_not_valid')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

                // Verify if the user has blogs
                if ( empty($the_user_info['response']['user']['blogs']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_seams_you_have_no_blogs')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

                // Get connected blogs
                $the_connected_blogs = $this->CI->base_model->the_data_where(
                    'networks',
                    '*',
                    array(
                        'network_name' => 'tumblr',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected blogs
                if ( $the_connected_blogs ) {

                    // List all connected blogs
                    foreach ( $the_connected_blogs as $the_connected_blog ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // Verify if user has blogs
                            if ( !empty($the_user_info['response']['user']['blogs']) ) {

                                // List the blogs
                                for ( $b = 0; $b < count($the_user_info['response']['user']['blogs']); $b++ ) {

                                    // Verify if this blog is connected
                                    if ( $the_user_info['response']['user']['blogs'][$b]['name'] === $the_connected_blog['net_id'] ) {

                                        // Delete the account
                                        if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $the_connected_blog['network_id'] ) ) ) {

                                            // Delete all account's records
                                            md_run_hook(
                                                'delete_network_account',
                                                array(
                                                    'account_id' => $the_connected_blog['network_id']
                                                )
                                                
                                            );

                                        }

                                    }

                                }

                            }

                            continue;
                            
                        }

                        // Verify if this account is still connected
                        if ( !in_array($the_connected_blog['net_id'], $net_ids) ) {

                            // Verify if user has blogs
                            if ( !empty($the_user_info['response']['user']['blogs']) ) {

                                // List the blogs
                                for ( $b = 0; $b < count($the_user_info['response']['user']['blogs']); $b++ ) {

                                    // Verify if user has selected this blog
                                    if ( in_array($the_user_info['response']['user']['blogs'][$b]['name'], $net_ids) ) {
                                        continue;
                                    }

                                    // Verify if this blog is connected
                                    if ( $the_user_info['response']['user']['blogs'][$b]['name'] === $the_connected_blog['net_id'] ) {

                                        // Delete the account
                                        if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $the_connected_blog['network_id'] ) ) ) {

                                            // Delete all account's records
                                            md_run_hook(
                                                'delete_network_account',
                                                array(
                                                    'account_id' => $the_connected_blog['network_id']
                                                )
                                                
                                            );

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

                // Verify if net ids is not empty
                if ( $net_ids ) {
                    
                    // Verify if user has blogs
                    if ( !empty($the_user_info['response']['user']['blogs']) ) {
                        
                        // Calculate expire token period
                        $expires = '';

                        // Get the user's plan
                        $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                        // Set network's accounts
                        $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                        // Connected networks
                        $connected_networks = $the_connected_blogs?array_column($the_connected_blogs, 'network_id', 'net_id'):array();

                        // List the blogs
                        for ( $b = 0; $b < count($the_user_info['response']['user']['blogs']); $b++ ) {

                            // Verify if user has selected this blog
                            if ( !in_array($the_user_info['response']['user']['blogs'][$b]['name'], $net_ids) ) {
                                continue;
                            }

                            // Verify if the blog is already connected
                            if ( isset($connected_networks[$the_user_info['response']['user']['blogs'][$b]['name']]) ) {

                                // Set as connected
                                $check++;

                                // Update the blog
                                $this->CI->base_model->update(
                                    'networks',
                                    array(
                                        'network_name' => 'tumblr',
                                        'net_id' => $the_user_info['response']['user']['blogs'][$b]['name'],
                                        'user_id' => md_the_user_id()
                                    ),
                                    array(
                                        'user_name' => $the_user_info['response']['user']['blogs'][$b]['name'],
                                        'token' => $oauth_token,
                                        'secret' => $oauth_token_secret
                                    )
                
                                );

                            } else {

                                // Save the blog
                                $the_response = $this->CI->base_model->insert(
                                    'networks',
                                    array(
                                        'network_name' => 'tumblr',
                                        'net_id' => $the_user_info['response']['user']['blogs'][$b]['name'],
                                        'user_id' => md_the_user_id(),
                                        'user_name' => $the_user_info['response']['user']['blogs'][$b]['name'],
                                        'token' => $oauth_token,
                                        'secret' => $oauth_token_secret
                                    )
                
                                );
                                
                                // Verify if the blog was saved
                                if ( $the_response ) {
                                    $check++;
                                }

                            }

                            // Verify if number of the blogs was reached
                            if ( $check >= $network_accounts ) {
                                break;
                            }
                            
                        }
                        
                    }

                }  else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_blogs_were_selected')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

            }

            // Verify if at least a blogs was connected
            if ( $check > 0 ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_blogs_were_connected')
                    ),
                    TRUE
                );
                
            } else {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_an_error_occurred')
                    ),
                    TRUE
                );
                
            }

            exit();

        } else {

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

            // Get timestamp
            $timestamp = time();

            // Generate nonce
            $nonce = md5(microtime() . mt_rand());

            // Set parameters
            $signature_params = array(
            'oauth_consumer_key' => $this->consumer_key,
            'oauth_nonce' => $nonce,
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => $timestamp,
            'oauth_token' => $this->CI->input->get('oauth_token', TRUE),
            'oauth_verifier' => $this->CI->input->get('oauth_verifier', TRUE),
            'oauth_version' => '1.0'
            );
        
            // Order parameters
            uksort($signature_params, 'strcmp');

            // List the parameters
            foreach($signature_params AS $key => $value) {

                // Set parameter
                $signature_params[$key] = rawurlencode($key) . '=' . rawurlencode($value);

            }
        
            // Set signature base
            $signature_base = array(
            rawurlencode('POST'),
            rawurlencode('https://www.tumblr.com/oauth/access_token'),
            rawurlencode(implode('&', $signature_params))
            );

            // Turn signature to string
            $signature_base_string = implode('&', $signature_base);
        
            // Set signature access
            $signature_key = array(
            rawurlencode($this->consumer_secret),
            rawurlencode($_SESSION['oauth_token_secret'])
            );

            // Turn signature access to string
            $signature_key_string = implode('&', $signature_key);
        
            // Prepare the signature
            $signature = rawurlencode(base64_encode(hash_hmac('sha1', $signature_base_string, $signature_key_string, true)));
        
            // Set header
            $headers = array(
                'Authorization: OAuth oauth_consumer_key="' . $this->consumer_key . '",oauth_token="' . $_SESSION['oauth_token'] . '",oauth_signature_method="HMAC-SHA1",oauth_timestamp="' . $timestamp . '",oauth_nonce="' . $nonce . '",oauth_version="1.0",oauth_verifier="' . $this->CI->input->get('oauth_verifier', TRUE) . '",oauth_signature="' . $signature . '"'
            );

            // Init Curl
            $curl = curl_init();

            // Set options
            curl_setopt_array($curl, array(
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_HEADER => false,
                CURLOPT_URL => 'https://www.tumblr.com/oauth/access_token',
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
            ));

            // Get the oauth
            parse_str(curl_exec($curl), $the_oauth);
        
            // Close Curl
            curl_close($curl);

            // Verify if the code exists
            if ( empty($the_oauth['oauth_token']) || empty($the_oauth['oauth_token_secret']) ) {

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
                'oauth_consumer_key' => $this->consumer_key,
                'oauth_token' => $the_oauth['oauth_token'],
                'oauth_token_secret' => $the_oauth['oauth_token_secret'],
                'oauth_nonce' => md5(uniqid()),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0'
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
            $the_prepared_string = 'GET&' . rawurlencode('https://api.tumblr.com/v2/user/info') . '&' . rawurlencode(implode('&', $base_string));
            
            // Set the key
            $the_secret_key = rawurlencode($this->consumer_secret) . '&' . rawurlencode($the_oauth['oauth_token_secret']);
            
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
                CURLOPT_URL => 'https://api.tumblr.com/v2/user/info',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array($curl_header, 'Expect:')
            ));

            // Get the user info
            $the_user_info = json_decode(curl_exec($curl), TRUE);
        
            // Close Curl
            curl_close($curl);

            // Verify if the error message exists
            if ( !empty($the_user_info['errors']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $the_user_info['errors'][0]['detail']
                    ),
                    TRUE
                );
                exit();

            }

            // Verify if response exists
            if ( empty($the_user_info['response']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_received_response_is_not_valid')
                    ),
                    TRUE
                );
                exit();
                
            }

            // Verify if the user has blogs
            if ( empty($the_user_info['response']['user']['blogs']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_seams_you_have_no_blogs')
                    ),
                    TRUE
                );
                exit();
                
            }

            // Items array
            $items = array();

            // Get connected blogs
            $the_connected_blogs = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'tumblr',
                    'user_id' => md_the_user_id()
                )

            );

            // Net Ids array
            $net_ids = array();

            // Verify if user has connected blogs
            if ( $the_connected_blogs ) {

                // List all connected blogs
                foreach ( $the_connected_blogs as $connected ) {

                    // Set net's id
                    $net_ids[] = $connected['net_id'];

                }

            }

            // List blogs
            for ( $b = 0; $b < count($the_user_info['response']['user']['blogs']); $b++ ) {

                // Set item
                $items[$the_user_info['response']['user']['blogs'][$b]['name']] = array(
                    'net_id' => $the_user_info['response']['user']['blogs'][$b]['name'],
                    'name' => $the_user_info['response']['user']['blogs'][$b]['name'],
                    'label' => '',
                    'connected' => FALSE
                );

                // Verify if this blog is connected
                if ( in_array($the_user_info['response']['user']['blogs'][$b]['name'], $net_ids) ) {

                    // Set as connected
                    $items[$the_user_info['response']['user']['blogs'][$b]['name']]['connected'] = TRUE;

                }
                
            }

            // Create the array which will provide the data
            $params = array(
                'title' => 'Tumblr',
                'network_name' => 'tumblr',
                'items' => $items,
                'connect' => $this->CI->lang->line('user_networks_blogs'),
                'callback' => site_url('user/callback/tumblr'),
                'inputs' => array(
                    array(
                        'oauth_token' => $the_oauth['oauth_token']
                    ), 
                    array(
                        'oauth_token_secret' => $the_oauth['oauth_token_secret']
                    )
                ) 
            );

            // Get the user's plan
            $user_plan = md_the_user_option( md_the_user_id(), 'plan');

            // Set network's accounts
            $params['network_accounts'] = md_the_plan_feature('network_accounts', $user_plan);

            // Set the number of the connected accounts
            $params['connected_accounts'] = count($net_ids);

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'list_accounts',
                $params,
                TRUE
            );

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
            'network_name' => 'Tumblr',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_tumblr_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_tumblr_enabled')?md_the_option('network_tumblr_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_tumblr_consumer_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Tumblr Consumer Key',
                            'field_description' => 'The consumer\'s key could be found in <a href="https://www.tumblr.com/oauth/apps" target="_blank">https://www.tumblr.com/oauth/apps</a> -> Applications -> your app.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the consumer's key ...",
                            'value' => md_the_option('network_tumblr_consumer_key')?md_the_option('network_tumblr_consumer_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_tumblr_consumer_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Tumblr Consumer Secret',
                            'field_description' => 'The consumer\'s secret could be found in <a href="https://www.tumblr.com/oauth/apps" target="_blank">https://www.tumblr.com/oauth/apps</a> -> Applications -> your app.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the consumer's secret ...",
                            'value' => md_the_option('network_tumblr_consumer_secret')?md_the_option('network_tumblr_consumer_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_tumblr_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Tumblr application."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/tumblr'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file tumblr.php */