<?php
/**
 * Reddit
 *
 * PHP Version 7.4
 *
 * Connect Reddit profiles
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
 * Reddit class - allows users to connect to their Reddit profiles
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Reddit implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_url;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Reddit Client ID
        $this->client_id = md_the_option('network_reddit_client_id');
        
        // Set the Reddit Client Secret
        $this->client_secret = md_the_option('network_reddit_client_secret');

        // Get the redirect url
        $this->redirect_url = site_url('user/callback/reddit');
        
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
            'save',
            'modposts',
            'identity',
            'edit',
            'read',
            'report',
            'submit',
            'mysubreddits'
        );

        // Verify if additional scopes exists
        if ( md_the_option('network_reddit_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_reddit_scopes');

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
            'redirect_uri' => $this->redirect_url,
            'scope' => implode(',', $scopes),
            'state' => rand(),
            'duration' => 'permanent',
        );
        
        // Set url
        $the_url = 'https://www.reddit.com/api/v1/authorize' . '?' . urldecode(http_build_query($params));
        
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

                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL,'https://oauth.reddit.com/api/v1/me');

                // Set header
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Bearer ' . $access_token,
                        'User-Agent: flairbot/1.0 by '
                    )
                );

                // Set return transfer
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Execute request
                $the_profile = json_decode(curl_exec($curl), TRUE);

                // Close curl
                curl_close($curl);

                // Verify if name exists
                if ( empty($the_profile['name']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_user_information_returned')
                        ),
                        TRUE
                    );

                    exit();
                    
                }
                
                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL,'https://oauth.reddit.com/subreddits/mine/moderator');

                // Set header
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Bearer ' . $access_token,
                        'User-Agent: flairbot/1.0 by '
                    )
                );

                // Set return transfer
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Execute request
                $the_subreddits = json_decode(curl_exec($curl), TRUE);

                // Close curl
                curl_close($curl);

                // Verify if subreddits exists
                if ( empty($the_subreddits['data']) ) {

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

                // Verify if data exists
                if ( empty($the_subreddits['data']) ) {

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

                // Verify if subreddits exists
                if ( empty($the_subreddits['data']['children']) ) {

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

                // Reddit Communities
                $reddit_communities = array();

                // List the communities
                foreach ( $the_subreddits['data']['children'] AS $community ) {

                    // Verify if is the user
                    if ( substr($community['data']['display_name_prefixed'], 0, 2) === 'u/' ) {
                        continue;
                    }

                    // Set community
                    $reddit_communities[] = array(
                        'community_id' => $community['data']['display_name_prefixed'],
                        'community_name' => $community['data']['display_name_prefixed'],
                        'icon_img' => !empty($community['data']['icon_img'])?$community['data']['icon_img']:'https://www.redditstatic.com/avatars/defaults/v2/avatar_default_0.png'
                    );

                }

                // Verify if communities exists
                if ( empty($reddit_communities) ) {

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

                // Get connected communities
                $the_connected_communities = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'reddit',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected reddit communities
                if ( $the_connected_communities ) {

                    // List all connected reddit communities
                    foreach ( $the_connected_communities as $community ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // List the reddit communities
                            for ( $c = 0; $c < count($reddit_communities); $c++ ) {

                                // Verify if this reddit community is connected
                                if ( $reddit_communities[$c]['community_id'] === $community['net_id'] ) {

                                    // Delete the reddit community 
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $community['network_id'] ) ) ) {

                                        // Delete all records
                                        md_run_hook(
                                            'delete_network_account',
                                            array(
                                                'account_id' => $community['network_id']
                                            )
                                            
                                        );

                                    }

                                }

                            }

                            continue;
                            
                        }

                        // Verify if this reddit community is still connected
                        if ( !in_array($community['net_id'], $net_ids) ) {

                            // List the reddit communities 
                            for ( $c = 0; $c < count($reddit_communities); $c++ ) {

                                // Verify if user has selected this reddit community
                                if ( in_array($reddit_communities[$c]['community_id'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this reddit community is connected
                                if ( $reddit_communities[$c]['community_id'] === $community['net_id'] ) {

                                    // Delete the reddit community
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $community['network_id'] ) ) ) {

                                        // Delete all records
                                        md_run_hook(
                                            'delete_network_account',
                                            array(
                                                'account_id' => $community['network_id']
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

                // Get connected reddit communities
                $the_connected_reddit_communities = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'reddit',
                        'user_id' => md_the_user_id()
                    )

                );

                // Connected communities
                $connected = array(
                    'new' => 0,
                    'updated' => 0
                );

                // Prepare the connected reddit communities
                $the_connected_reddit_communities = !empty($the_connected_reddit_communities)?array_column($the_connected_reddit_communities, 'net_id'):array();
                    
                // Calculate expire token period
                $expires = '';

                // Get the user's plan
                $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                // Set network's accounts limit
                $network_accounts_limit = md_the_plan_feature('network_accounts', $user_plan)?(int)md_the_plan_feature('network_accounts', $user_plan):0;

                // List the reddit communities
                for ( $c = 0; $c < count($reddit_communities); $c++ ) {

                    // Verify if the community is selected
                    if ( !in_array($reddit_communities[$c]['community_id'], $net_ids) ) {
                        continue;
                    }

                    // Verify if user has selected this reddit community
                    if ( in_array($reddit_communities[$c]['community_id'], $the_connected_reddit_communities) ) {

                        // Update the community
                        $update_community = $this->CI->base_model->update(
                            'networks',
                            array(
                                'network_name' => 'reddit',
                                'net_id' => $reddit_communities[$c]['community_id'],
                                'user_id' => md_the_user_id()
                            ),
                            array(
                                'user_name' => $reddit_communities[$c]['community_name'],
                                'user_avatar' => $reddit_communities[$c]['icon_img'],
                                'token' => $refresh_token,
                                'secret' => $the_profile['name']
                            )
        
                        );

                        // Verify if the community was updated
                        if ( !empty($update_community) ) {

                            // Increase the updated counter
                            $connected['updated']++;

                        }

                    } else {

                        // Verify if communities limit was reached
                        if ( (count($the_connected_reddit_communities) + $connected['new']) >= $network_accounts_limit ) {
                            continue;
                        }

                        // Save the community
                        $save_community = $this->CI->base_model->insert(
                            'networks',
                            array(
                                'network_name' => 'reddit',
                                'net_id' => $reddit_communities[$c]['community_id'],
                                'user_id' => md_the_user_id(),
                                'user_name' => $reddit_communities[$c]['community_name'],
                                'user_avatar' => $reddit_communities[$c]['icon_img'],
                                'token' => $refresh_token,
                                'secret' => $the_profile['name']
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

            // Init a CURL session
            $curl = curl_init();

            // Set url
            curl_setopt($curl, CURLOPT_URL, 'https://www.reddit.com/api/v1/access_token');

            // Enable POST
            curl_setopt($curl, CURLOPT_POST, true);

            // Set client id and secret as access
            curl_setopt($curl, CURLOPT_USERPWD, $this->client_id . ':' . $this->client_secret);

            // Set post fields
            curl_setopt(
                $curl,
                CURLOPT_POSTFIELDS,
                array(
                    'grant_type' => 'authorization_code',
                    'code' => $this->CI->input->get('code', TRUE),
                    'redirect_uri' => $this->redirect_url,
                )
            );

            // Enable return
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            
            // Send request for an access token
            $the_token = json_decode(curl_exec($curl), true);

            // Close the CURL session
            curl_close($curl);

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

            // Init curl
            $curl = curl_init();

            // Set url
            curl_setopt($curl, CURLOPT_URL,'https://oauth.reddit.com/subreddits/mine/moderator');

            // Set header
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $the_token['access_token'],
                    'User-Agent: flairbot/1.0 by '
                )
            );

            // Set return transfer
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Execute request
            $the_subreddits = json_decode(curl_exec($curl), TRUE);

            // Close curl
            curl_close($curl);

            // Verify if subreddits exists
            if ( empty($the_subreddits['data']) ) {

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

            // Verify if data exists
            if ( empty($the_subreddits['data']) ) {

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

            // Verify if subreddits exists
            if ( empty($the_subreddits['data']['children']) ) {

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

            // Get reddit subreddits
            $the_connected_subreddits = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'reddit',
                    'user_id' => md_the_user_id()
                )

            );

            // Net Ids array
            $net_ids = array();

            // Verify if user has subreddits
            if ( $the_connected_subreddits ) {

                // List all reddit
                foreach ( $the_connected_subreddits as $subreddit ) {

                    // Set net's id
                    $net_ids[] = $subreddit['net_id'];

                }

            }

            // List the reddit subreddits
            for ( $s = 0; $s < count($the_subreddits['data']['children']); $s++ ) {

                // Verify if is the user
                if ( substr($the_subreddits['data']['children'][$s]['data']['display_name_prefixed'], 0, 2) === 'u/' ) {
                    continue;
                }

                // Set item
                $items[$the_subreddits['data']['children'][$s]['data']['display_name_prefixed']] = array(
                    'net_id' => $the_subreddits['data']['children'][$s]['data']['display_name_prefixed'],
                    'name' => $the_subreddits['data']['children'][$s]['data']['display_name_prefixed'],
                    'label' => '',
                    'connected' => FALSE
                );

                // Verify if this subreddit is connected
                if ( in_array($the_subreddits['data']['children'][$s]['data']['display_name_prefixed'], $net_ids) ) {

                    // Set as connected
                    $items[$the_subreddits['data']['children'][$s]['data']['display_name_prefixed']]['connected'] = TRUE;

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
                'title' => 'Reddit',
                'network_name' => 'reddit',
                'items' => $items,
                'connect' => $this->CI->lang->line('user_network_connect_reddit'),
                'callback' => site_url('user/callback/reddit'),
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
    public function actions($action, $params) {

    }

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info() {
        
        return array(
            'network_name' => 'Reddit',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_reddit_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_reddit_enabled')?md_the_option('network_reddit_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_reddit_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Reddit App ID',
                            'field_description' => "The Reddit's App ID could be found in the Reddit -> My Apps -> your app -> Manage -> Settings."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('network_reddit_client_id')?md_the_option('network_reddit_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_reddit_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Reddit Secure key',
                            'field_description' => "The Reddit's client secret could be found in the Reddit -> My Apps -> your app -> Manage -> Settings"
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the secure key ...",
                            'value' => md_the_option('network_reddit_client_secret')?md_the_option('network_reddit_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_reddit_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "The additional scopes could be requested by some apps. The scopes should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_reddit_scopes')?md_the_option('network_reddit_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_reddit_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Reddit app from your Developer account."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/Reddit'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file Reddit.php */
