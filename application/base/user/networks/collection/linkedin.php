<?php
/**
 * Linkedin
 *
 * PHP Version 7.4
 *
 * Connect Linkedin profiles
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

// Require the GET Inc file
require_once CMS_BASE_PATH . 'inc/curl/get.php'; 

/**
 * Linkedin class - allows users to connect to their Linkedin profiles
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Linkedin implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_uri, $api_endpoint = 'https://www.linkedin.com/oauth/v2';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Linkedin Client ID
        $this->client_id = md_the_option('network_linkedin_client_id');
        
        // Set the Linkedin Client Secret
        $this->client_secret = md_the_option('network_linkedin_client_secret');

        // Set the redirect's url
        $this->redirect_uri = site_url('user/callback/linkedin'); 
        
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

        // Scopes to request
        $scopes = array(
            'r_liteprofile'
        );

        // Verify if additional scopes exists
        if ( md_the_option('network_linkedin_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_linkedin_scopes');

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
            'redirect_uri' => $this->redirect_uri,
            'scope' => implode(',', $scopes),
            'state' => uniqid()
        );
        
        // Set url
        $the_url = $this->api_endpoint . '/authorization' . '?' . http_build_query($params);
        
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
            'url' => $this->api_endpoint . '/accessToken',
            'fields' => array(
                'grant_type' => 'authorization_code',
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => $this->redirect_uri,
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            )

        )), TRUE);

        // Verify if access token exists
        if ( !empty($the_token['access_token']) ) {

            // Request the profile
            $the_profile = json_decode(md_the_get(array(
                'url' => 'https://api.linkedin.com/v2/me?oauth2_access_token=' . $the_token['access_token']
            )), TRUE);
            
            // Verify if first name exists
            if ( !empty($the_profile['firstName']) ) {

                // Verify if preferredLocale exists
                if ( !empty($the_profile['firstName']['preferredLocale']) ) {

                    // Verify if country exists
                    if ( !empty($the_profile['firstName']['preferredLocale']['country']) ) {

                        // Get first and last name
                        $full_name = $the_profile['firstName']['localized'][$the_profile['firstName']['preferredLocale']['language'] . '_' . $the_profile['firstName']['preferredLocale']['country']] . ' ' . $the_profile['lastName']['localized'][$the_profile['lastName']['preferredLocale']['language'] . '_' . $the_profile['lastName']['preferredLocale']['country']];

                        // Get profile id
                        $id = $the_profile['id'];

                        // Get exiration time
                        $expires = date('Y-m-d H:i:s', time() + $the_token['expires_in']);

                        // Get the linkedin's account
                        $the_linkedin_account = $this->CI->base_model->the_data_where(
                            'networks',
                            'network_id',
                            array(
                                'network_name' => 'linkedin',
                                'net_id' => $id,
                                'user_id' => md_the_user_id()
                            )

                        );

                        // Verify if the account is already connected
                        if ( $the_linkedin_account ) {

                            // Update the account
                            $this->CI->base_model->update(
                                'networks',
                                array(
                                    'network_name' => 'linkedin',
                                    'net_id' => $id,
                                    'user_id' => md_the_user_id()
                                ),
                                array(
                                    'user_name' => $full_name,
                                    'expires' => $expires,
                                    'token' => $the_token['access_token']
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
                                    'network_name' => 'linkedin',
                                    'net_id' => $id,
                                    'user_id' => md_the_user_id(),
                                    'user_name' => $full_name,
                                    'expires' => $expires,
                                    'token' => $the_token['access_token']
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
                        exit();

                    }

                }

            }

        }

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
            'network_name' => 'Linkedin',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_linkedin_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_linkedin_enabled')?md_the_option('network_linkedin_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_linkedin_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Linkedin Client ID',
                            'field_description' => "The Linkedin's client ID could be found in the Linkedin Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_linkedin_client_id')?md_the_option('network_linkedin_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Linkedin Client Secret',
                            'field_description' => "The Linkedin's client secret code could be found in the Linkedin Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret code ...",
                            'value' => md_the_option('network_linkedin_client_secret')?md_the_option('network_linkedin_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "The additional scopes could be requested by some clients. The scopes should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_linkedin_scopes')?md_the_option('network_linkedin_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Linkedin client."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/linkedin'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file linkedin.php */
