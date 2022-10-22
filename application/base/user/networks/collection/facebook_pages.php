<?php
/**
 * Facebook Pages
 *
 * PHP Version 7.4
 *
 * Connect Facebook Pages
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
 * Facebook_pages class - allows users to connect to their Facebook Pages
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Facebook_pages implements CmsBaseUserInterfaces\Networks {

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
        $this->app_id = md_the_option('network_facebook_pages_app_id');
        
        // Set the Facebook App Secret
        $this->app_secret = md_the_option('network_facebook_pages_app_secret');

        // Set the Facebook Api Version
        $this->api_version = md_the_option('network_facebook_pages_api_version')?md_the_option('network_facebook_pages_api_version'):$this->api_version;
        
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
     * @return void
     */
    public function connect() {

        // Permissions to request
        $permissions = array(
            'pages_show_list'
        );

        // Verify if additional permissions exists
        if ( md_the_option('network_facebook_pages_permissions') ) {

            // Get the permissions
            $the_permissions = md_the_option('network_facebook_pages_permissions');

            if ( count(explode(',', $the_permissions)) > 0 ) {

                // List the permissions
                foreach ( explode(',', $the_permissions) as $permission ) {

                    // Verify if permission is valid
                    if ( !empty($permission) ) {

                        // Verify if permission exists in the list
                        if ( in_array(trim($permission), $permissions) ) {
                            continue;
                        }

                        // Set permission
                        $permissions[] = trim($permission);

                    }

                }

            }

        }

        // Prepare parameters for url
        $params = array(
            'client_id' => $this->app_id,
            'state' => time(),
            'response_type' => 'code',
            'redirect_uri' => site_url('user/callback/facebook_pages'),
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
            $this->CI->form_validation->set_rules('token', 'Token', 'trim|required');
            $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim|required');

            // Get post data
            $token = $this->CI->input->post('token', TRUE);
            $net_ids = $this->CI->input->post('net_ids', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Get user data
                $response = json_decode(file_get_contents('https://graph.facebook.com/' . $this->api_version . '/me/accounts?limit=500&fields=name,picture,access_token&access_token=' . $token), true);

                // Get connected facebook pages
                $the_connected_facebook_pages = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'facebook_pages',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected facebook pages
                if ( $the_connected_facebook_pages ) {

                    // List all connected facebook pages
                    foreach ( $the_connected_facebook_pages as $connected ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // Verify if user has pages
                            if ( isset($response['data'][0]['id']) ) {

                                // List pages
                                for ( $y = 0; $y < count($response['data']); $y++ ) {

                                    // Verify if this page is connected
                                    if ( $response['data'][$y]['id'] === $connected['net_id'] ) {

                                        // Delete the account
                                        if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                            // Delete all account's records
                                            md_run_hook(
                                                'delete_network_account',
                                                array(
                                                    'account_id' => $connected['network_id']
                                                )
                                                
                                            );

                                        }

                                    }

                                }

                            }

                            continue;
                            
                        }

                        // Verify if this account is still connected
                        if ( !in_array($connected['net_id'], $net_ids) ) {

                            // Verify if user has pages
                            if ( isset($response['data'][0]['id']) ) {

                                // List pages
                                for ( $y = 0; $y < count($response['data']); $y++ ) {

                                    // Verify if user has selected this Facebook Page
                                    if ( in_array($response['data'][$y]['id'], $net_ids) ) {
                                        continue;
                                    }

                                    // Verify if this page is connected
                                    if ( $response['data'][$y]['id'] === $connected['net_id'] ) {

                                        // Delete the account
                                        if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                            // Delete all account's records
                                            md_run_hook(
                                                'delete_network_account',
                                                array(
                                                    'account_id' => $connected['network_id']
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
                    
                    // Verify if user has pages
                    if ( isset($response['data'][0]['id']) ) {
                        
                        // Calculate expire token period
                        $expires = '';

                        // Get the user's plan
                        $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                        // Set network's accounts
                        $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                        // Connected networks
                        $connected_networks = $the_connected_facebook_pages?array_column($the_connected_facebook_pages, 'network_id', 'net_id'):array();

                        // Save page
                        for ( $y = 0; $y < count($response['data']); $y++ ) {

                            // Verify if user has selected this Facebook Page
                            if ( !in_array($response['data'][$y]['id'], $net_ids) ) {
                                continue;
                            }

                            // Verify if the Facebook Page is already connected
                            if ( isset($connected_networks[$response['data'][$y]['id']]) ) {

                                // Set as connected
                                $check++;

                                // Update the page
                                $this->CI->base_model->update(
                                    'networks',
                                    array(
                                        'network_name' => 'facebook_pages',
                                        'net_id' => $response['data'][$y]['id'],
                                        'user_id' => md_the_user_id()
                                    ),
                                    array(
                                        'user_name' => $response['data'][$y]['name'],
                                        'token' => $response['data'][$y]['access_token']
                                    )
                
                                );

                            } else {

                                // Save the page
                                $the_response = $this->CI->base_model->insert(
                                    'networks',
                                    array(
                                        'network_name' => 'facebook_pages',
                                        'net_id' => $response['data'][$y]['id'],
                                        'user_id' => md_the_user_id(),
                                        'user_name' => $response['data'][$y]['name'],
                                        'token' => $response['data'][$y]['access_token']
                                    )
                
                                );
                                
                                // Verify if the Facebook Page was saved
                                if ( $the_response ) {
                                    $check++;
                                }

                            }

                            // Verify if number of the pages was reached
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
                            'message' => $this->CI->lang->line('user_networks_no_pages_were_selected')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

            }

            // Verify if at least a Facebook Page was connected
            if ( $check > 0 ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_all_facebook_pages_were_connected_successfully')
                    ),
                    TRUE
                );
                exit();
                
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
                exit();
                
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

            // Prepare the fields
            $fields = array(
                'client_id' => $this->app_id,
                'client_secret' => $this->app_secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => site_url('user/callback/facebook_pages'),
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

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $the_token['error']['message']
                        ),
                        TRUE
                    );

                    exit();                    

                }

            }

            // Get the Facebook Pages
            $the_facebook_pages = json_decode(file_get_contents('https://graph.facebook.com/' . $this->api_version . '/me/accounts?limit=500&access_token=' . $the_token['access_token']), true);

            // Verify if user has pages
            if ( isset($the_facebook_pages['data'][0]['id']) ) {
            
                // Items array
                $items = array();

                // Get Facebook Pages
                $the_connected_facebook_pages = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'facebook_pages',
                        'user_id' => md_the_user_id()
                    )

                );

                // Net Ids array
                $net_ids = array();

                // Verify if user has Facebook Pages
                if ( $the_connected_facebook_pages ) {

                    // List all Facebook Pages
                    foreach ( $the_connected_facebook_pages as $connected ) {

                        // Set net's id
                        $net_ids[] = $connected['net_id'];

                    }

                }

                // Save page
                for ( $y = 0; $y < count($the_facebook_pages['data']); $y++ ) {

                    // Set item
                    $items[$the_facebook_pages['data'][$y]['id']] = array(
                        'net_id' => $the_facebook_pages['data'][$y]['id'],
                        'name' => $the_facebook_pages['data'][$y]['name'],
                        'label' => '',
                        'connected' => FALSE
                    );

                    // Verify if this Facebook Page is connected
                    if ( in_array($the_facebook_pages['data'][$y]['id'], $net_ids) ) {

                        // Set as connected
                        $items[$the_facebook_pages['data'][$y]['id']]['connected'] = TRUE;

                    }
                    
                }

                // Create the array which will provide the data
                $params = array(
                    'title' => 'Facebook Pages',
                    'network_name' => 'facebook_pages',
                    'items' => $items,
                    'connect' => $this->CI->lang->line('user_network_facebook_pages'),
                    'callback' => site_url('user/callback/facebook_pages'),
                    'inputs' => array(
                        array(
                            'token' => $the_token['access_token']
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
                
                exit();
                
            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_not_facebook_pages_found')
                    ),
                    TRUE
                );
                exit();
                
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
            'network_name' => 'Facebook Pages',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_facebook_pages_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_facebook_pages_enabled')?md_the_option('network_facebook_pages_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_facebook_pages_app_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook App ID',
                            'field_description' => "The Facebook's app ID could be found in the Facebook Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('network_facebook_pages_app_id')?md_the_option('network_facebook_pages_app_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_facebook_pages_app_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook App Secret',
                            'field_description' => "The Facebook's app secret code could be found in the Facebook Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('network_facebook_pages_app_secret')?md_the_option('network_facebook_pages_app_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_facebook_pages_api_version',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Facebook Api Version',
                            'field_description' => "The Facebook's api's version is optionally."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the api's version ...",
                            'value' => md_the_option('network_facebook_pages_api_version')?md_the_option('network_facebook_pages_api_version'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_facebook_pages_permissions',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Permissions',
                            'field_description' => "The additional permissions could be requested by some apps. The permissions should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the permissions ...",
                            'value' => md_the_option('network_facebook_pages_permissions')?md_the_option('network_facebook_pages_permissions'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_facebook_pages_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Facebook app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/facebook_pages'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file facebook_pages.php */
