<?php
/**
 * Ok
 *
 * PHP Version 7.4
 *
 * Connect Ok
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
 * Ok class - allows users to connect to their Ok groups and pages
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Ok implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $application_key, $redirect_uri, $ok_api_url = '';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Ok Client ID
        $this->client_id = md_the_option('network_ok_client_id');
        
        // Set the Ok Client Secret
        $this->client_secret = md_the_option('network_ok_client_secret');

        // Set the Ok Application Key
        $this->application_key = md_the_option('network_ok_application_key');

        // Set the redirect's url
        $this->redirect_uri = site_url('user/callback/ok');

        // Set ok api's url
        $this->ok_api_url = 'https://api.ok.ru/';
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
        
        // Verify if client_id and client_secret exists
        if ( ($this->client_id != '') AND ( $this->client_secret != '') AND ( $this->application_key != '') ) {
            
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
            'VALUABLE_ACCESS',
            'PHOTO_CONTENT',
            'GROUP_CONTENT',
            'LONG_ACCESS_TOKEN'
        );

        // Verify if additional scopes exists
        if ( md_the_option('network_ok_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_ok_scopes');

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
            'scope' => implode(';', $scopes)
        );
        
        // Set url
        $the_url = 'http://www.odnoklassniki.ru/oauth/authorize' . '?' . http_build_query($params);
        
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

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('access_token', 'Access Token', 'trim|required');
            $this->CI->form_validation->set_rules('refresh_token', 'Refresh Token', 'trim|required');
            $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim');

            // Get post data
            $access_token = $this->CI->input->post('access_token', TRUE);
            $refresh_token = $this->CI->input->post('refresh_token', TRUE);
            $net_ids = $this->CI->input->post('net_ids', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() === false) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_access_token_is_missing')
                    ),
                    TRUE
                );               

            } else {

                // Prepare the groups parameters
                $groups_params = array(
                    'method'          => 'group.getUserGroupsV2',
                    'access_token'    => $access_token,
                    'application_key' => $this->application_key,
                    'format'          => 'json',
                    'sig'             => md5("application_key={$this->application_key}format=jsonmethod=group.getUserGroupsV2" . md5("{$access_token}{$this->client_secret}"))
                );

                // Request the groups
                $the_ok_groups = json_decode(md_the_get(array(
                    'url' => $this->ok_api_url . 'fb.do' . '?' . urldecode(http_build_query($groups_params))
                )), TRUE); 
                
                // Verify if error msg exists
                if ( !empty($the_ok_groups['error_msg']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $the_ok_groups['error_msg']
                        ),
                        TRUE
                    );

                    exit();

                }
                
                // Verify if groups were not found
                if ( empty($the_ok_groups['groups']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_communities_found')
                        ),
                        TRUE
                    );

                    exit();                

                }

                // Ok Groups
                $ok_groups = array();

                // List the groups
                foreach ( $the_ok_groups['groups'] AS $group ) {

                    // Prepare the group parameters
                    $group_params = array(
                        'access_token'    => $access_token,
                        'application_key' => $this->application_key,
                        'fields'          => 'name',
                        'format'          => 'json',
                        'method'          => 'group.getInfo',
                        'uids'            => $group['groupId'],
                        'sig'             => md5("application_key={$this->application_key}fields=nameformat=jsonmethod=group.getInfouids=" . $group['groupId'] . md5("{$access_token}{$this->client_secret}"))
                    );

                    // Request the group's information
                    $the_ok_group = json_decode(md_the_get(array(
                        'url' => $this->ok_api_url . 'fb.do' . '?' . urldecode(http_build_query($group_params))
                    )), TRUE); 

                    // Verify if group's name exists
                    if ( !empty($the_ok_group[0]['name']) ) {

                        // Set group
                        $ok_groups[] = array(
                            'group_id' => $group['groupId'],
                            'group_name' => $the_ok_group[0]['name']
                        );

                    }

                }

                // Verify if groups exists
                if ( empty($ok_groups) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_communities_found')
                        ),
                        TRUE
                    );

                    exit(); 
                    
                }

                // Get connected groups and pages
                $the_connected_groups = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'ok',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected ok groups and pages
                if ( $the_connected_groups ) {

                    // List all connected ok groups and pages
                    foreach ( $the_connected_groups as $group ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // List the ok groups and pages
                            for ( $g = 0; $g < count($ok_groups); $g++ ) {

                                // Verify if this ok group or page is connected
                                if ( $ok_groups[$g]['group_id'] === $group['net_id'] ) {

                                    // Delete the ok group or page 
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $group['network_id'] ) ) ) {

                                        // Delete all records
                                        md_run_hook(
                                            'delete_network_account',
                                            array(
                                                'account_id' => $group['network_id']
                                            )
                                            
                                        );

                                    }

                                }

                            }

                            continue;
                            
                        }

                        // Verify if this ok group or page is still connected
                        if ( !in_array($group['net_id'], $net_ids) ) {

                            // List the ok groups or pages
                            for ( $g = 0; $g < count($ok_groups); $g++ ) {

                                // Verify if user has selected this ok group or page
                                if ( in_array($ok_groups[$g]['group_id'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this ok group or page is connected
                                if ( $ok_groups[$g]['group_id'] === $group['net_id'] ) {

                                    // Delete the ok group or page
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $group['network_id'] ) ) ) {

                                        // Delete all records
                                        md_run_hook(
                                            'delete_network_account',
                                            array(
                                                'account_id' => $group['network_id']
                                            )
                                            
                                        );

                                    }

                                }

                            }

                        }

                    }

                }

                // Verify if net_ids is empty
                if ( empty($net_ids) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_success',
                        array(
                            'message' => $this->CI->lang->line('user_network_communities_were_selected')
                        ),
                        TRUE
                    );

                    exit();

                }

                // Get connected ok communities
                $the_connected_ok_communities = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'ok',
                        'user_id' => md_the_user_id()
                    )

                );

                // Connected communities
                $connected = array(
                    'new' => 0,
                    'updated' => 0
                );

                // Prepare the connected ok communities
                $the_connected_ok_communities = !empty($the_connected_ok_communities)?array_column($the_connected_ok_communities, 'net_id'):array();
                    
                // Calculate expire token period
                $expires = '';

                // Get the user's plan
                $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                // Set network's accounts limit
                $network_accounts_limit = md_the_plan_feature('network_accounts', $user_plan)?(int)md_the_plan_feature('network_accounts', $user_plan):0;

                // List the ok groups and pages
                for ( $g = 0; $g < count($ok_groups); $g++ ) {

                    // Verify if the community is selected
                    if ( !in_array($ok_groups[$g]['group_id'], $net_ids) ) {
                        continue;
                    }

                    // Verify if user has selected this ok group or page
                    if ( in_array($ok_groups[$g]['group_id'], $the_connected_ok_communities) ) {

                        // Update the community
                        $update_community = $this->CI->base_model->update(
                            'networks',
                            array(
                                'network_name' => 'ok',
                                'net_id' => $ok_groups[$g]['group_id'],
                                'user_id' => md_the_user_id()
                            ),
                            array(
                                'user_name' => $ok_groups[$g]['group_name'],
                                'token' => $refresh_token
                            )
        
                        );

                        // Verify if the community was updated
                        if ( !empty($update_community) ) {

                            // Increase the updated counter
                            $connected['updated']++;

                        }

                    } else {

                        // Verify if communities limit was reached
                        if ( (count($the_connected_ok_communities) + $connected['new']) >= $network_accounts_limit ) {
                            continue;
                        }

                        // Save the community
                        $save_community = $this->CI->base_model->insert(
                            'networks',
                            array(
                                'network_name' => 'ok',
                                'net_id' => $ok_groups[$g]['group_id'],
                                'user_id' => md_the_user_id(),
                                'user_name' => $ok_groups[$g]['group_name'],
                                'token' => $refresh_token
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

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_success',
                        array(
                            'message' => $connected['new'] . ' ' . $this->CI->lang->line('user_network_communities_were_connected')
                        ),
                        TRUE
                    );

                } else if ( !empty($connected['updated']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_success',
                        array(
                            'message' => $connected['updated'] . ' ' . $this->CI->lang->line('user_network_communities_were_updated')
                        ),
                        TRUE
                    );

                } else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_communities_were_connected_updated')
                        ),
                        TRUE
                    );
                    
                }

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

            // Ask for access token
            $the_token = json_decode(md_the_post(array(
                'url' => $this->ok_api_url . 'oauth/token.do',
                'fields' => array(
                    'grant_type' => 'authorization_code',
                    'code' => $this->CI->input->get('code', TRUE),
                    'redirect_uri' => $this->redirect_uri,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret
                )

            )), TRUE);

            // Verify if access token exists
            if ( empty($the_token['access_token']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_access_token_not_generated')
                    ),
                    TRUE
                );

                exit();

            }

            // Prepare the groups parameters
            $groups_params = array(
                'method'          => 'group.getUserGroupsV2',
                'access_token'    => $the_token['access_token'],
                'application_key' => $this->application_key,
                'format'          => 'json',
                'sig'             => md5("application_key={$this->application_key}format=jsonmethod=group.getUserGroupsV2" . md5("{$the_token['access_token']}{$this->client_secret}"))
            );

            // Request the groups
            $the_ok_groups = json_decode(md_the_get(array(
                'url' => $this->ok_api_url . 'fb.do' . '?' . urldecode(http_build_query($groups_params))
            )), TRUE); 
            
            // Verify if error msg exists
            if ( !empty($the_ok_groups['error_msg']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $the_ok_groups['error_msg']
                    ),
                    TRUE
                );

                exit();

            }
            
            // Verify if groups were not found
            if ( empty($the_ok_groups['groups']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_no_communities_found')
                    ),
                    TRUE
                );

                exit();                

            }
            
            // Items array
            $items = array();

            // Get Ok
            $the_connected_groups = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'ok',
                    'user_id' => md_the_user_id()
                )

            );

            // Net Ids array
            $net_ids = array();

            // Verify if user has Ok
            if ( $the_connected_groups ) {

                // List all ok
                foreach ( $the_connected_groups as $group ) {

                    // Set net's id
                    $net_ids[] = $group['net_id'];

                }

            }

            // List the ok groups and pages
            for ( $o = 0; $o < count($the_ok_groups['groups']); $o++ ) {

                // Prepare the group parameters
                $group_params = array(
                    'access_token'    => $the_token['access_token'],
                    'application_key' => $this->application_key,
                    'fields'          => 'name',
                    'format'          => 'json',
                    'method'          => 'group.getInfo',
                    'uids'            => $the_ok_groups['groups'][$o]['groupId'],
                    'sig'             => md5("application_key={$this->application_key}fields=nameformat=jsonmethod=group.getInfouids=" . $the_ok_groups['groups'][$o]['groupId'] . md5("{$the_token['access_token']}{$this->client_secret}"))
                );

                // Request the group's information
                $the_ok_group = json_decode(md_the_get(array(
                    'url' => $this->ok_api_url . 'fb.do' . '?' . urldecode(http_build_query($group_params))
                )), TRUE); 

                // Verify if group's name exists
                if ( !empty($the_ok_group[0]['name']) ) {

                    // Set item
                    $items[$the_ok_groups['groups'][$o]['groupId']] = array(
                        'net_id' => $the_ok_groups['groups'][$o]['groupId'],
                        'name' => $the_ok_group[0]['name'],
                        'label' => '',
                        'connected' => FALSE
                    );

                    // Verify if this group or page is connected
                    if ( in_array($the_ok_groups['groups'][$o]['groupId'], $net_ids) ) {

                        // Set as connected
                        $items[$the_ok_groups['groups'][$o]['groupId']]['connected'] = TRUE;

                    }

                }
                
            }

            // Verify if groups exists
            if ( empty($items) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_no_communities_found')
                    ),
                    TRUE
                );

                exit();  
                
            }

            // Create the array which will provide the data
            $params = array(
                'title' => 'OK',
                'network_name' => 'ok',
                'items' => $items,
                'connect' => $this->CI->lang->line('user_network_connect_ok'),
                'callback' => site_url('user/callback/ok'),
                'inputs' => array(
                    array(
                        'access_token' => $the_token['access_token']
                    ),
                    array(
                        'refresh_token' => $the_token['refresh_token']
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
    public function actions($action, $params) {}

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info() {
        
        return array(
            'network_name' => 'OK',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_ok_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_ok_enabled')?md_the_option('network_ok_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_ok_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'OK App ID',
                            'field_description' => "These informations were provided in email after the game registration on ok.ru."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('network_ok_client_id')?md_the_option('network_ok_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_ok_application_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'OK Public Key',
                            'field_description' => "These informations were provided in email after the game registration on ok.ru."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the public key ...",
                            'value' => md_the_option('network_ok_application_key')?md_the_option('network_ok_application_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_ok_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'OK Secret Key',
                            'field_description' => "These informations were provided in email after the game registration on ok.ru."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the secret key ...",
                            'value' => md_the_option('network_ok_client_secret')?md_the_option('network_ok_client_secret'):'',
                            'disabled' => false
                        )

                    ),                    
                    array(
                        'field_slug' => 'network_ok_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "You could add here additional scopes approved on OK. GROUP_CONTENT is already added by default."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_ok_scopes')?md_the_option('network_ok_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_ok_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Ok client."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/ok'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file ok.php */