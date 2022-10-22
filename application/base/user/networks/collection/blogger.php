<?php
/**
 * Blogger
 *
 * PHP Version 7.4
 *
 * Connect Blogger
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
 * Blogger class - allows users to connect to their Blogger's blogs
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Blogger implements CmsBaseUserInterfaces\Networks {

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
        $this->client_id = md_the_option('network_blogger_client_id');
        
        // Get the Google's client_secret
        $this->client_secret = md_the_option('network_blogger_client_secret');
        
        // Get the Google's api key
        $this->api_key = md_the_option('network_blogger_api_key');
        
        // Get the Google's application name
        $this->app_name = md_the_option('network_blogger_google_application_name');
        
        // Blogger CallBack
        $this->redirect_url = site_url('user/callback/blogger');
        
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
            'scope' => 'https://www.googleapis.com/auth/blogger https://www.googleapis.com/auth/userinfo.profile',
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

        // Check if data was submitted
        if ($this->CI->input->post()) {
        
            // Define the callback status
            $check = 0;

            // Add form validation
            $this->CI->form_validation->set_rules('access_token', 'Access Token', 'trim|required');
            $this->CI->form_validation->set_rules('refresh_token', 'Refresh Token', 'trim|required');
            $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim|required');

            // Get post data
            $access_token = $this->CI->input->post('access_token', TRUE);
            $refresh_token = $this->CI->input->post('refresh_token', TRUE);
            $net_ids = $this->CI->input->post('net_ids', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Init a new CURL session
                $curl = curl_init();
                
                // Set options
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://www.googleapis.com/blogger/v3/users/self/blogs?fetchUserInfo=true&role=ADMIN&view=ADMIN&fields=blogUserInfos%2Citems&access_token=' . $access_token,
                    CURLOPT_HEADER => false
                ));
                
                // Send the request & save response to $resp
                $the_blogs = json_decode(curl_exec($curl), true);
                
                // Close request to clear up some resources
                curl_close($curl);

                // Verify if user has blogs
                if ( empty($the_blogs) ) {

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
                        'network_name' => 'blogger',
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
                            if ( !empty($the_blogs['blogUserInfos']) ) {

                                // List the blogs
                                for ( $b = 0; $b < count($the_blogs['blogUserInfos']); $b++ ) {

                                    // Verify if this blog is connected
                                    if ( $the_blogs['blogUserInfos'][$b]['blog']['id'] === $the_connected_blog['net_id'] ) {

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
                            if ( !empty($the_blogs['blogUserInfos']) ) {

                                // List the blogs
                                for ( $b = 0; $b < count($the_blogs['blogUserInfos']); $b++ ) {

                                    // Verify if user has selected this blog
                                    if ( in_array($the_blogs['blogUserInfos'][$b]['blog']['id'], $net_ids) ) {
                                        continue;
                                    }

                                    // Verify if this blog is connected
                                    if ( $the_blogs['blogUserInfos'][$b]['blog']['id'] === $the_connected_blog['net_id'] ) {

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
                    if ( !empty($the_blogs['blogUserInfos']) ) {
                        
                        // Calculate expire token period
                        $expires = '';

                        // Get the user's plan
                        $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                        // Set network's accounts
                        $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                        // Connected networks
                        $connected_networks = $the_connected_blogs?array_column($the_connected_blogs, 'network_id', 'net_id'):array();

                        // List the blogs
                        for ( $b = 0; $b < count($the_blogs['blogUserInfos']); $b++ ) {

                            // Verify if user has selected this blog
                            if ( !in_array($the_blogs['blogUserInfos'][$b]['blog']['id'], $net_ids) ) {
                                continue;
                            }

                            // Verify if the blog is already connected
                            if ( isset($connected_networks[$the_blogs['blogUserInfos'][$b]['blog']['id']]) ) {

                                // Set as connected
                                $check++;

                                // Update the blog
                                $this->CI->base_model->update(
                                    'networks',
                                    array(
                                        'network_name' => 'blogger',
                                        'net_id' => $the_blogs['blogUserInfos'][$b]['blog']['id'],
                                        'user_id' => md_the_user_id()
                                    ),
                                    array(
                                        'user_name' => $the_blogs['blogUserInfos'][$b]['blog']['name'],
                                        'token' => $refresh_token
                                    )
                
                                );

                            } else {

                                // Save the blog
                                $the_response = $this->CI->base_model->insert(
                                    'networks',
                                    array(
                                        'network_name' => 'blogger',
                                        'net_id' => $the_blogs['blogUserInfos'][$b]['blog']['id'],
                                        'user_id' => md_the_user_id(),
                                        'user_name' => $the_blogs['blogUserInfos'][$b]['blog']['name'],
                                        'token' => $refresh_token
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
                
            // Verify if access token exists
            if ( empty($access_response['access_token']) ) {

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

            // Verify if refresh token exists
            if ( empty($access_response['refresh_token']) ) {

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

            // Init a new CURL session
            $curl = curl_init();
            
            // Set options
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://www.googleapis.com/blogger/v3/users/self/blogs?fetchUserInfo=true&role=ADMIN&view=ADMIN&fields=blogUserInfos%2Citems&access_token=' . $access_response['access_token'],
                CURLOPT_HEADER => false
            ));
            
            // Send the request & save response to $resp
            $the_blogs = json_decode(curl_exec($curl), true);
            
            // Close request to clear up some resources
            curl_close($curl);

            // Verify if user has blogs
            if ( empty($the_blogs) ) {

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
                    'network_name' => 'blogger',
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
            
            // If user has blogs will save them
            if ( !empty($the_blogs['blogUserInfos']) ) {
                
                // List blogs
                for ( $b = 0; $b < count($the_blogs['blogUserInfos']); $b++ ) {

                    // Set item
                    $items[$the_blogs['blogUserInfos'][$b]['blog']['id']] = array(
                        'net_id' => $the_blogs['blogUserInfos'][$b]['blog']['id'],
                        'name' => $the_blogs['blogUserInfos'][$b]['blog']['name'],
                        'label' => '',
                        'connected' => FALSE
                    );

                    // Verify if this blog is connected
                    if ( in_array($the_blogs['blogUserInfos'][$b]['blog']['id'], $net_ids) ) {

                        // Set as connected
                        $items[$the_blogs['blogUserInfos'][$b]['blog']['id']]['connected'] = TRUE;

                    }
                    
                }

                // Create the array which will provide the data
                $params = array(
                    'title' => 'Blogger',
                    'network_name' => 'blogger',
                    'items' => $items,
                    'connect' => $this->CI->lang->line('user_networks_blogs'),
                    'callback' => site_url('user/callback/blogger'),
                    'inputs' => array(
                        array(
                            'access_token' => $access_response['access_token']
                        ), 
                        array(
                            'refresh_token' => $access_response['refresh_token']
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

            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_seams_you_have_no_blogs')
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
            'network_name' => 'Blogger',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_blogger_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_blogger_enabled')?md_the_option('network_blogger_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_blogger_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client ID',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_blogger_client_id')?md_the_option('network_blogger_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_blogger_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client Secret',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret ...",
                            'value' => md_the_option('network_blogger_client_secret')?md_the_option('network_blogger_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_blogger_api_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Api Key',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the api's key ...",
                            'value' => md_the_option('network_blogger_api_key')?md_the_option('network_blogger_api_key'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_blogger_google_application_name',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Application Name',
                            'field_description' => 'The application\'s name from the OAuth client ID.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the application's name ...",
                            'value' => md_the_option('network_blogger_google_application_name')?md_the_option('network_blogger_google_application_name'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_blogger_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Blogger application."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/blogger'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file blogger.php */