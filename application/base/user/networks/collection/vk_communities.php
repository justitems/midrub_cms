<?php
/**
 * Vk Communities
 *
 * PHP Version 7.4
 *
 * Connect Vk Communities
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

// Require the GET Inc file
require_once CMS_BASE_PATH . 'inc/curl/get.php';

/**
 * Vk_communities class - allows users to connect to their Vk communities
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Vk_communities implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_uri, $api_endpoint = 'https://oauth.vk.com/', $version='5.92';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Vk Client ID
        $this->client_id = md_the_option('network_vk_client_id');
        
        // Set the Vk Client Secret
        $this->client_secret = md_the_option('network_vk_client_secret');

        // Get the redirect url
        $this->redirect_uri = $this->api_endpoint . 'authorize?client_id=' . $this->client_id . '&scope=groups,photos,video,wall&redirect_uri=' . $this->api_endpoint . 'blank.html&display=page&v=' . $this->version . '&response_type=token';
        
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
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code'
        );
        
        // Set url
        $the_url = $this->api_endpoint . 'authorize' . '?' . urldecode(http_build_query($params));
        
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
    public function callback($token = null) {}

    /**
     * The public method actions executes the actions
     *
     * @param string $action contains the action's name
     * @param array $params contains the request's params
     * 
     * @return array with response
     */
    public function actions($action, $params) {

        // Run code by action
        if ( $action === 'connect' ) {

            // Verify if code parameter exists
            if ( empty($params['code']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_network_code_parameter_missing')
                );

            }

            // Parameters for access token
            $token_params = array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $params['code'],
                'redirect_uri' => $this->redirect_uri
            );

            // Get the access token
            $the_token = json_decode(md_the_get(array(
                'url' => $this->api_endpoint . 'access_token' . '?' . urldecode(http_build_query($token_params))
            )), TRUE);

            // Verify if the error_description parameter exists
            if ( !empty($the_token['error_description']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $the_token['error_description']
                );
                
            }

            // Verify if access token exists
            if ( empty($the_token['access_token']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_networks_access_token_not_generated')
                );
                
            }
            
            // Communities params
            $communities_params = array(
                'extended' => 1,
                'access_token' => $the_token['access_token'],
                'v' => $this->version
            );
            
            // Get the communities
            $the_communities = json_decode(md_the_get(array(
                'url' => 'https://api.vk.com/method/groups.get' . '?' . urldecode(http_build_query($communities_params))
            )), TRUE);

            // Verify if the error parameter exists
            if ( !empty($the_communities['error']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $the_communities['error']['error_msg']
                );
                
            }            
            
            // Verify if the error_description parameter exists
            if ( !empty($the_communities['error_description']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $the_communities['error_description']
                );
                
            }

            // Verify if the user has communities
            if ( empty($the_communities['response']['items']) ) {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_network_no_communities_found')
                );
                
            }

            // Get connected vk communities
            $the_connected_vk_communities = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'vk_communities',
                    'user_id' => md_the_user_id()
                )

            );

            // Prepare the connected vk communities
            $the_connected_vk_communities = !empty($the_connected_vk_communities)?array_column($the_connected_vk_communities, 'net_id'):array();

            // Set the number of total communities
            $the_total_vk_communities = !empty($the_connected_vk_communities)?count($the_connected_vk_communities):0;

            // Get the user's plan
            $user_plan = md_the_user_option( md_the_user_id(), 'plan');

            // Set network's accounts limit
            $network_accounts_limit = md_the_plan_feature('network_accounts', $user_plan)?(int)md_the_plan_feature('network_accounts', $user_plan):0;

            // Connected communities
            $connected = array(
                'new' => 0,
                'updated' => 0
            );

            // List the communities
            foreach ( $the_communities['response']['items'] AS $community ) {

                // Verify if the community is connected
                if ( in_array($community['id'], $the_connected_vk_communities) ) {

                    // Update the community
                    $update_community = $this->CI->base_model->update(
                        'networks',
                        array(
                            'network_name' => 'vk_communities',
                            'net_id' => $community['id'],
                            'user_id' => md_the_user_id()
                        ),
                        array(
                            'user_name' => $community['name'],
                            'user_avatar' => !empty($community['photo_50'])?$community['photo_50']:'',
                            'token' => $the_token['access_token']
                        )
    
                    );

                    // Verify if the community was updated
                    if ( !empty($update_community) ) {

                        // Increase the updated counter
                        $connected['updated']++;

                    }

                } else {

                    // Verify if communities limit was reached
                    if ( ($the_total_vk_communities + $connected['new']) >= $network_accounts_limit ) {
                        continue;
                    }

                    // Save the community
                    $save_community = $this->CI->base_model->insert(
                        'networks',
                        array(
                            'network_name' => 'vk_communities',
                            'net_id' => $community['id'],
                            'user_id' => md_the_user_id(),
                            'user_name' => $community['name'],
                            'user_avatar' => !empty($community['photo_50'])?$community['photo_50']:'',
                            'token' => $the_token['access_token']
                        )
    
                    );
                    
                    // Verify if the community was saved
                    if ( !empty($save_community) ) {

                        // Increase the new counter
                        $connected['new']++;

                    }                    

                }

            }

            // Verify if were saved communities
            if ( !empty($connected['new']) ) {

                return array(
                    'success' => TRUE,
                    'message' => $connected['new'] . ' ' . $this->CI->lang->line('user_network_communities_were_connected')
                );

            } else if ( !empty($connected['updated']) ) {

                return array(
                    'success' => TRUE,
                    'message' => $connected['updated'] . ' ' . $this->CI->lang->line('user_network_communities_were_updated')
                );

            } else {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_network_no_communities_were_connected_updated')
                );
                
            }

        }

    }

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info() {
        
        return array(
            'network_name' => 'VK Communities',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_vk_communities_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_vk_communities_enabled')?md_the_option('network_vk_communities_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_vk_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'VK App ID',
                            'field_description' => "The Vk's App ID could be found in the VK -> My Apps -> your app -> Manage -> Settings."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('network_vk_client_id')?md_the_option('network_vk_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_vk_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'VK Secure key',
                            'field_description' => "The Vk's client secret could be found in the VK -> My Apps -> your app -> Manage -> Settings"
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the secure key ...",
                            'value' => md_the_option('network_vk_client_secret')?md_the_option('network_vk_client_secret'):'',
                            'disabled' => false
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file vk.php */
