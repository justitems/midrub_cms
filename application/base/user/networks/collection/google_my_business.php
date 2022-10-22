<?php
/**
 * Google My Business
 *
 * PHP Version 7.4
 *
 * Connect Google My Business
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the location namespace
namespace CmsBase\User\Networks\Collection;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\User\Interfaces as CmsBaseUserInterfaces;

/**
 * Google_my_business class - allows users to connect to their Google My Business
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Google_my_business implements CmsBaseUserInterfaces\Networks {

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
        $this->client_id = md_the_option('network_google_my_business_client_id');
        
        // Get the Google's client_secret
        $this->client_secret = md_the_option('network_google_my_business_client_secret');
        
        // Get the Google's api key
        $this->api_key = md_the_option('network_google_my_business_api_key');
        
        // Get the Google's application name
        $this->app_name = md_the_option('network_google_my_business_google_application_name');
        
        // Google My Business CallBack
        $this->redirect_url = site_url('user/callback/google_my_business');
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
        
        // Verify if client_id, client_secret and api_key exists
        if ( ($this->client_id != '') and ( $this->client_secret != '') and ( $this->api_key != '') and ( $this->app_name != '') ) {
            
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
            'scope' => 'https://www.googleapis.com/auth/plus.business.manage',
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
        
            // Save counter
            $save = array(
                'saved' => 0,
                'updated' => 0,
                'connected' => 0
            );

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

                // Locations container
                $locations = array();

                // Init the CURL session
                $curl = curl_init();
                        
                // Set parameters
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts?access_token=' . $access_token,
                    CURLOPT_HEADER => false
                ));
                
                // Execute request
                $list_with_accounts = json_decode(curl_exec($curl), true);
                
                // Close the CURL session
                curl_close($curl);

                // Verify if an error was returned
                if ( !empty($list_with_accounts['error']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $list_with_accounts['error']['message']
                        ),
                        TRUE
                    );
                    exit();

                } else if ( !empty($list_with_accounts['accounts']) ) {

                    // List the accounts
                    foreach ( $list_with_accounts['accounts'] as $account ) {

                        // Init the CURL session
                        $curl = curl_init();
                        
                        // Set parameters
                        curl_setopt_array($curl, array(
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => 'https://mybusinessbusinessinformation.googleapis.com/v1/' . $account['name'] . '/locations?readMask=name,title&access_token=' . $access_token,
                            CURLOPT_HEADER => false
                        ));
                        
                        // Execute request
                        $list_with_accounts = json_decode(curl_exec($curl), true);
                        
                        // Close the CURL session
                        curl_close($curl);
                        
                        // Verify if locations exists
                        if ( !empty($list_with_accounts['locations']) ) {

                            // List the locations
                            foreach ( $list_with_accounts['locations'] AS $location ) {

                                // Add location to the container
                                $locations[] = $location;

                            }

                        }

                    }

                }

                // Verify if locations exists
                if ( empty($locations) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_google_locations_were_found')
                        ),
                        TRUE
                    );

                    exit();
                    
                }

                // Get connected google my business locations
                $the_connected_google_locations = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'google_my_business',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected google my business locations
                if ( $the_connected_google_locations ) {

                    // List all connected google my business locations
                    foreach ( $the_connected_google_locations as $connected ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // List google my business locations
                            foreach ( $locations as $location ) {

                                // Verify if this location is connected
                                if ( $location['name'] === $connected['net_id'] ) {

                                    // Delete the account
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                        // Remove a connected location counter
                                        $save['connected']--;

                                        // Increase the update counter
                                        $save['updated']++;

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

                            continue;
                            
                        }

                        // Verify if this account is still connected
                        if ( !in_array($connected['net_id'], $net_ids) ) {

                            // List google my business locations
                            foreach ( $locations as $location ) {

                                // Verify if user has selected this location
                                if ( in_array($location['name'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this location is connected
                                if ( $location['name'] === $connected['net_id'] ) {

                                    // Delete the account
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                        // Remove a connected location counter
                                        $save['connected']--;

                                        // Increase the update counter
                                        $save['updated']++;

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

                // Verify if net ids is not empty
                if ( $net_ids ) {
                        
                    // Calculate expire token period
                    $expires = '';

                    // Get the user's plan
                    $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                    // Set network's accounts
                    $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                    // Connected networks
                    $connected_networks = $the_connected_google_locations?array_column($the_connected_google_locations, 'network_id', 'net_id'):array();

                    // List google my business locations
                    foreach ( $locations as $location ) {

                        // Verify if user has selected this Google My Business Location
                        if ( !in_array($location['name'], $net_ids) ) {
                            continue;
                        }

                        // Verify if the Google My Business Location is already connected
                        if ( isset($connected_networks[$location['name']]) ) {

                            // Update the location
                            $the_response = $this->CI->base_model->update(
                                'networks',
                                array(
                                    'network_name' => 'google_my_business',
                                    'net_id' => $location['name'],
                                    'user_id' => md_the_user_id()
                                ),
                                array(
                                    'user_name' => $location['title'],
                                    'token' => $access_token,
                                    'secret' => $refresh_token
                                )
            
                            );

                            // Verify if the Google My Business Location was updated
                            if ( $the_response ) {
                                $save['updated']++;
                            }                            

                        } else {

                            // Save the location
                            $the_response = $this->CI->base_model->insert(
                                'networks',
                                array(
                                    'network_name' => 'google_my_business',
                                    'net_id' => $location['name'],
                                    'user_id' => md_the_user_id(),
                                    'user_name' => $location['title'],
                                    'token' => $token,
                                    'secret' => $refresh_token
                                )
            
                            );
                            
                            // Verify if the Google My Business Location was saved
                            if ( $the_response ) {
                                $save['connected']++;
                                $save['saved']++;
                            }

                        }

                        // Verify if number of the locations was reached
                        if ( $save['connected'] >= $network_accounts ) {
                            break;
                        }
                        
                    }

                }  else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_locations_were_selected')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

            }

            // Verify if the locations were saved
            if ( $save['saved'] > 0 ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $save['saved'] . ' ' . $this->CI->lang->line('user_networks_locations_were_saved')
                    ),
                    TRUE
                );

            } else if ( $save['updated'] > 0  ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_locations_were_updated')
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

            // Verify if refresh_token exists
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

            // Init the CURL session
            $curl = curl_init();
                    
            // Set parameters
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://mybusinessaccountmanagement.googleapis.com/v1/accounts?access_token=' . $access_response['access_token'],
                CURLOPT_HEADER => false
            ));
            
            // Execute request
            $list_with_accounts = json_decode(curl_exec($curl), true);
            
            // Close the CURL session
            curl_close($curl);

            // Verify if an error was returned
            if ( !empty($list_with_accounts['error']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $list_with_accounts['error']['message']
                    ),
                    TRUE
                );
                exit();

            } else if ( !empty($list_with_accounts['accounts']) ) {

                // Items array
                $items = array();

                // Get the google my business locations
                $the_connected_google_locations = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'google_my_business',
                        'user_id' => md_the_user_id()
                    )

                );

                // Net Ids array
                $net_ids = array();

                // Verify if user has saved google my business locations
                if ( $the_connected_google_locations ) {

                    // List all google my business locations
                    foreach ( $the_connected_google_locations as $connected ) {

                        // Set net's id
                        $net_ids[] = $connected['net_id'];

                    }

                }

                // List the accounts
                foreach ( $list_with_accounts['accounts'] as $account ) {

                    // Init the CURL session
                    $curl = curl_init();
                    
                    // Set parameters
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => 'https://mybusinessbusinessinformation.googleapis.com/v1/' . $account['name'] . '/locations?readMask=name,title&access_token=' . $access_response['access_token'],
                        CURLOPT_HEADER => false
                    ));
                    
                    // Execute request
                    $list_with_accounts = json_decode(curl_exec($curl), true);
                    
                    // Close the CURL session
                    curl_close($curl);
                    
                    // Verify if locations exists
                    if ( !empty($list_with_accounts['locations']) ) {

                        // List the locations
                        foreach ( $list_with_accounts['locations'] AS $location ) {

                            // Set item
                            $items[$location['name']] = array(
                                'net_id' => $location['name'],
                                'name' => $location['title'],
                                'label' => '',
                                'connected' => FALSE
                            );

                            // Verify if this location is connected
                            if ( in_array($location['name'], $net_ids) ) {

                                // Set as connected
                                $items[$location['name']]['connected'] = TRUE;

                            }

                        }

                    }

                }





                $post_params = array(
                    'summary' => 'This is my new post',
                    'topic_type' => 'STANDARD'
                );

                // Init the CURL session
                $curl = curl_init();
                
                // Set parameters
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://mybusiness.googleapis.com/v4/' . $account['name'] . '/' . $items[key($items)]['net_id'] . '/localPosts?access_token=' . $access_response['access_token'],
                    CURLOPT_HTTPHEADER => array( 'Content-Type: application/json'),
                    CURLOPT_POSTFIELDS => json_encode($post_params),
                    CURLOPT_POST => true,
                ));
                
                // Execute request
                $response = json_decode(curl_exec($curl), TRUE);
                
                // Close the CURL session
                curl_close($curl);
var_dump($response);
exit();
                // Verify if items exists
                if ( empty($items) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_google_locations_were_found')
                        ),
                        TRUE
                    );

                    exit();
                    
                }

                // Create the array which will provide the data
                $params = array(
                    'title' => 'Google My Business',
                    'network_name' => 'google_my_business',
                    'items' => $items,
                    'connect' => $this->CI->lang->line('user_network_google_my_business'),
                    'callback' => site_url('user/callback/google_my_business'),
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
                
                exit();

            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_not_accounts_found')
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
            'network_name' => 'Google My Business',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_google_my_business_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans locations. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_google_my_business_enabled')?md_the_option('network_google_my_business_enabled'):0
                        )
        
                    ),
                    array(
                        'field_slug' => 'network_google_my_business_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client ID',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_google_my_business_client_id')?md_the_option('network_google_my_business_client_id'):'',
                            'disabled' => false
                        )
        
                    ),
                    array(
                        'field_slug' => 'network_google_my_business_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Client Secret',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret ...",
                            'value' => md_the_option('network_google_my_business_client_secret')?md_the_option('network_google_my_business_client_secret'):'',
                            'disabled' => false
                        )
        
                    ),
                    array(
                        'field_slug' => 'network_google_my_business_api_key',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Api Key',
                            'field_description' => 'The client\'s id could be found in <a href="https://console.developers.google.com/" target="_blank">https://console.developers.google.com/</a> -> your project -> Credentials -> Create Credentials.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the api's key ...",
                            'value' => md_the_option('network_google_my_business_api_key')?md_the_option('network_google_my_business_api_key'):'',
                            'disabled' => false
                        )
        
                    ),
                    array(
                        'field_slug' => 'network_google_my_business_google_application_name',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Google Application Name',
                            'field_description' => 'The application\'s name from the OAuth client ID.'
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the application's name ...",
                            'value' => md_the_option('network_google_my_business_google_application_name')?md_the_option('network_google_my_business_google_application_name'):'',
                            'disabled' => false
                        )
        
                    ),
                    array(
                        'field_slug' => 'network_google_my_business_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the google_my_business application."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/google_my_business'),
                            'disabled' => true
                        )
        
                    )
        
                )
        
            )
        
        );

    }

}

/* End of file google_my_business.php */