<?php
/**
 * Pinterest
 *
 * PHP Version 7.4
 *
 * Connect Pinterest boards
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
 * Pinterest class - allows users to connect to their Pinterest boards
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Pinterest implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $app_id, $app_secret;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Pinterest App ID
        $this->app_id = md_the_option('network_pinterest_app_id');
        
        // Set the Pinterest App Secret
        $this->app_secret = md_the_option('network_pinterest_app_secret');
        
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

        // Scopes to request
        $scopes = array(
            'user_accounts:read',
            'boards:read',
            'boards:read_secret',
            'pins:read',
            'pins:read_secret',
            'boards:write',
            'boards:write_secret',
            'pins:write',
            'pins:write_secret'
        );

        // Verify if additional scopes exists
        if ( md_the_option('network_pinterest_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_pinterest_scopes');

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
            'redirect_uri' => site_url('user/callback/pinterest'),
            'client_id' => $this->app_id,
            'scope' => implode(',', $scopes),
            'state' => uniqid()
        );
        
        // Set url
        $the_url = 'https://www.pinterest.com/oauth/' . '?' . http_build_query($params);
        
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

                // Prepare params
                $refresh_params = array(
                    'grant_type' => 'refresh_token',
                    'response_type' => 'string',
                    'refresh_token' => $token
                );

                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL,'https://api.pinterest.com/v5/oauth/token');

                // Enable post
                curl_setopt($curl, CURLOPT_POST, 1);

                // Set params
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($refresh_params));

                // Set header
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Basic ' . base64_encode($this->app_id . ':' . $this->app_secret)
                    )
                );

                // Set return transfer
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Execute request
                $the_token = json_decode(curl_exec($curl), true);

                // Close curl
                curl_close($curl);

                // Verify if access token exists
                if ( empty($the_token['access_token']) ) {

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

                // Default user's profile image
                $profile_image = '';

                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL,'https://api.pinterest.com/v5/user_account');

                // Set header
                curl_setopt(
                    $curl,
                    CURLOPT_HTTPHEADER,
                    array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Bearer ' . $the_token['access_token']
                    )
                );

                // Set return transfer
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                // Execute request
                $the_profile = json_decode(curl_exec($curl), true);

                // Close curl
                curl_close($curl);

                // Verify if profile image exists
                if ( !empty($the_profile['profile_image']) ) {

                    // Set the profile image
                    $profile_image = $the_profile['profile_image'];

                }

                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL, 'https://api.pinterest.com/v5/boards');

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
                $the_pinterest_boards = json_decode(curl_exec ($curl), true);

                // Close curl
                curl_close ($curl);

                // Verify if boards exists
                if ( empty($the_pinterest_boards['items']) ) {
                    
                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_boards_found')
                        ),
                        TRUE
                    );

                    exit();

                }

                // Get the connected Pinterest's boards
                $the_connected_boards = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'pinterest',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected Pinterests
                if ( $the_connected_boards ) {

                    // List all connected Pinterests
                    foreach ( $the_connected_boards as $connected ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // Verify if user has boards
                            if ( isset($response['data'][0]) ) {

                                // List all boards
                                foreach ($the_pinterest_boards['items'] as $board) {                                      

                                    // Verify if this account is connected
                                    if ( $board['id'] === $connected['net_id'] ) {

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

                        // Verify if this board is still connected
                        if ( !in_array($connected['net_id'], $net_ids) ) {

                            // List all boards
                            foreach ($the_pinterest_boards['items'] as $board) {                      

                                // Verify if user has selected this board
                                if ( in_array($board['id'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this board is connected
                                if ( $board['id'] === $connected['net_id'] ) {

                                    // Delete the board
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                        // Delete all board's records
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

                // Verify if net ids is not empty
                if ( $net_ids ) {

                    // Get the user's plan
                    $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                    // Set network's accounts
                    $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                    // Connected networks
                    $connected_networks = $the_connected_boards?array_column($the_connected_boards, 'network_id', 'net_id'):array();

                    // List all boards
                    foreach ($the_pinterest_boards['items'] as $board) {                             

                        // Verify if user has selected this Pinterest
                        if ( !in_array($board['id'], $net_ids) ) {
                            continue;
                        }

                        // Verify if the Pinterest is already connected
                        if ( isset($connected_networks[$board['id']]) ) {

                            // Set as connected
                            $check++;

                            // Update the page
                            $this->CI->base_model->update(
                                'networks',
                                array(
                                    'network_name' => 'pinterest',
                                    'net_id' => $board['id'],
                                    'user_id' => md_the_user_id()
                                ),
                                array(
                                    'user_name' => $board['name'],
                                    'user_avatar' => !empty($profile_image)?$profile_image:'',
                                    'token' => $token
                                )
            
                            );

                        } else {

                            // Save the page
                            $the_response = $this->CI->base_model->insert(
                                'networks',
                                array(
                                    'network_name' => 'pinterest',
                                    'net_id' => $board['id'],
                                    'user_id' => md_the_user_id(),
                                    'user_name' => $board['name'],
                                    'user_avatar' => !empty($profile_image)?$profile_image:'',
                                    'token' => $token
                                )
            
                            );
                            
                            // Verify if the Pinterest was saved
                            if ( $the_response ) {
                                $check++;
                            }

                        }

                        // Verify if number of the pages was reached
                        if ( $check >= $network_accounts ) {
                            break;
                        }
                        
                    }

                }  else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_boards_selected')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

            }

            // Verify if at least a Pinterest was connected
            if ( $check > 0 ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_all_boards_were_connected_successfully')
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

            // Params for request
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => site_url('user/callback/pinterest')
            );

            // Init curl
            $curl = curl_init();

            // Set url
            curl_setopt($curl, CURLOPT_URL, 'https://api.pinterest.com/v5/oauth/token');

            // Post method
            curl_setopt($curl, CURLOPT_POST, 1);

            // Set fields
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

            // Set header
            curl_setopt(
                $curl,
                CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic ' . base64_encode($this->app_id . ':' . $this->app_secret)
                )
            );

            // Enable return
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            // Execute response
            $the_token = json_decode(curl_exec($curl), true);

            // Close curl
            curl_close ($curl);

            // Verify if access token exists
            if ( !empty($the_token['access_token']) ) {

                // Init curl
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL, 'https://api.pinterest.com/v5/boards');

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
                $the_pinterest_boards = json_decode(curl_exec ($curl), true);

                // Close curl
                curl_close ($curl);

                // Verify if boards exists
                if ( empty($the_pinterest_boards['items']) ) {
                    
                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_no_boards_found')
                        ),
                        TRUE
                    );

                    exit();

                }
                
                // Items array
                $items = array();

                // Get Pinterest Boards
                $the_connected_boards_boards = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'pinterest',
                        'user_id' => md_the_user_id()
                    )

                );

                // Net Ids array
                $net_ids = array();

                // Verify if user has Pinterest Boards
                if ( $the_connected_boards_boards ) {

                    // List all Pinterest Boards
                    foreach ( $the_connected_boards_boards as $connected ) {

                        // Set net's id
                        $net_ids[] = $connected['net_id'];

                    }

                }

                // List all boards
                foreach ($the_pinterest_boards['items'] as $board) {

                    // Set item
                    $items[$board['id']] = array(
                        'net_id' => $board['id'],
                        'name' => $board['name'],
                        'label' => '',
                        'connected' => FALSE
                    );

                    // Verify if this Board is connected
                    if ( in_array($board['id'], $net_ids) ) {

                        // Set as connected
                        $items[$board['id']]['connected'] = TRUE;

                    }
                    
                }

                // Create the array which will provide the data
                $params = array(
                    'title' => 'Pinterest',
                    'network_name' => 'pinterest',
                    'items' => $items,
                    'connect' => $this->CI->lang->line('user_networks_boards'),
                    'callback' => site_url('user/callback/pinterest'),
                    'inputs' => array(
                        array(
                            'token' => $the_token['refresh_token']
                        )
                    ) 
                );

                // Get the user's plan
                $user_plan = md_the_user_option( md_the_user_id(), 'plan');
        
                // Set network's _accounts
                $params['network_accounts'] = md_the_plan_feature('network_accounts', $user_plan);

                // Set the number of the connected boards
                $params['connected_accounts'] = count($net_ids);

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'list_accounts',
                    $params,
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
            'network_name' => 'Pinterest',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_pinterest_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_pinterest_enabled')?md_the_option('network_pinterest_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_pinterest_app_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Pinterest App ID',
                            'field_description' => "The Pinterest's app ID could be found in the Pinterest Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's id ...",
                            'value' => md_the_option('network_pinterest_app_id')?md_the_option('network_pinterest_app_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_pinterest_app_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Pinterest App Secret',
                            'field_description' => "The Pinterest's app secret code could be found in the Pinterest Developer -> App -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('network_pinterest_app_secret')?md_the_option('network_pinterest_app_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_pinterest_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "The additional scopes could be requested by some apps. The scopes should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_pinterest_scopes')?md_the_option('network_pinterest_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_pinterest_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Pinterest app."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/pinterest'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file pinterest.php */
