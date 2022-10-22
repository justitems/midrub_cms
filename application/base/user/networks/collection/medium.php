<?php
/**
 * Medium
 *
 * PHP Version 7.4
 *
 * Connect Medium
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
 * Medium class - allows users to connect to their Medium
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Medium implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
    }

    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability() {
            
        return true;
        
    }

    /**
     * The public method connect requests the access token
     *
     * @return void
     */
    public function connect() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('integration_token', 'Integration Token', 'trim|required');

            // Get post data
            $integration_token = $this->CI->input->post('integration_token', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() === false) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_integration_token_missing')
                    ),
                    TRUE
                );
                exit();

            } else {

                // Init a CURL session
                $curl = curl_init();
                
                // Set options
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://api.medium.com/v1/me?accessToken=' . $integration_token,
                    CURLOPT_HEADER => false)
                );
                
                // Get the profile
                $the_profile = json_decode(curl_exec($curl), TRUE);
                
                // Close the CURL session
                curl_close($curl);

                // Verify if errors exists
                if ( !empty($the_profile['errors']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $the_profile['errors'][0]['message']
                        ),
                        TRUE
                    );
                    exit();
                    
                }

                // Get the medium's blog
                $the_medium_blog = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id',
                    array(
                        'network_name' => 'medium',
                        'net_id' => $the_profile['data']['id'],
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if the blog is already connected
                if ( $the_medium_blog ) {

                    // Update the blog
                    $update = $this->CI->base_model->update(
                        'networks',
                        array(
                            'network_name' => 'medium',
                            'net_id' => $the_profile['data']['id'],
                            'user_id' => md_the_user_id()
                        ),
                        array(
                            'user_name' => $the_profile['data']['name'],
                            'user_avatar' => !empty($the_profile['data']['imageUrl'])?$the_profile['data']['imageUrl']:'',
                            'token' => $integration_token
                        )
    
                    );

                    // Verify if the blog was updated
                    if ( $update ) {
                        
                        // Set view
                        echo $this->CI->load->ext_view(
                            CMS_BASE_PATH . 'user/default/php',
                            'network_success',
                            array(
                                'message' => $this->CI->lang->line('user_networks_blog_was_updated')
                            ),
                            TRUE
                        );

                    } else {

                        // Set view
                        echo $this->CI->load->ext_view(
                            CMS_BASE_PATH . 'user/default/php',
                            'network_error',
                            array(
                                'message' => $this->CI->lang->line('user_networks_blog_was_not_updated')
                            ),
                            TRUE
                        );
                        
                    }

                } else {

                    // Save the blog
                    $the_response = $this->CI->base_model->insert(
                        'networks',
                        array(
                            'network_name' => 'medium',
                            'net_id' => $the_profile['data']['id'],
                            'user_id' => md_the_user_id(),
                            'user_name' => $the_profile['data']['name'],
                            'user_avatar' => !empty($the_profile['data']['imageUrl'])?$the_profile['data']['imageUrl']:'',
                            'token' => $integration_token
                        )
    
                    );
                    
                    // Verify if the account was saved
                    if ( $the_response ) {

                        // Set view
                        echo $this->CI->load->ext_view(
                            CMS_BASE_PATH . 'user/default/php',
                            'network_success',
                            array(
                                'message' => $this->CI->lang->line('user_networks_blog_was_connected')
                            ),
                            TRUE
                        );

                    } else {

                        // Set view
                        echo $this->CI->load->ext_view(
                            CMS_BASE_PATH . 'user/default/php',
                            'network_error',
                            array(
                                'message' => $this->CI->lang->line('user_networks_blog_was_not_connected')
                            ),
                            TRUE
                        );
                        
                    }

                }

            }

        } else {
            
            // Display the login form
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_connect',
                array(
                    'page_title' => $this->CI->lang->line('user_network_connect_medium'),
                    'callback_url' => site_url('user/connect/medium'),
                    'fields' => array(
                        array(
                            'slug' => 'integration_token',
                            'name' => $this->CI->lang->line('user_networks_integration_token'),
                            'type' => 'text',
                            'placeholder' => $this->CI->lang->line('user_network_enter_the_integration_token')
                        )
                    )
                ),
                TRUE
            );            
            
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
                
        // Define the callback status
        $check = 0;

        // Add form validation
        $this->CI->form_validation->set_rules('bot_key', 'Bot Key', 'trim|required');
        $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim|required');

        // Get post data
        $bot_key = $this->CI->input->post('bot_key', TRUE);
        $net_ids = $this->CI->input->post('net_ids', TRUE);

        // Verify if form data is valid
        if ($this->CI->form_validation->run() == false) {

            // Subscriber counter
            $subscriber_counter = 0;

            // Get the updates for testing
            $the_updates_test = @file_get_contents('https://api.telegram.org/bot' . $bot_key . '/getUpdates?limit=1000');

            // Verify if updates exists
            if ( $the_updates_test ) {

                // Decode
                $decode_test = json_decode($the_updates_test, TRUE);

                // Verify if the resonse contains error
                if ( isset($decode_test['error_code']) ) {

                    // Delete the webhook
                    @file_get_contents('https://api.telegram.org/bot' . $bot_key . '/deleteWebhook');

                    // Increase the subscriber
                    $subscriber_counter++;

                }

            } else {

                // Delete the webhook
                @file_get_contents('https://api.telegram.org/bot' . $bot_key . '/deleteWebhook');

                // Increase the subscriber
                $subscriber_counter++;
                
            }

            // The data array
            $the_data = array();

            // Get user data
            $data = @file_get_contents('https://api.telegram.org/bot' . $bot_key . '/getUpdates?limit=1000');

            // Verify if any data is returned
            if ( !empty($data) ) {

                // Decode the data
                $the_data = json_decode($data, TRUE);

            }

            // Get connected accounts
            $get_connected = $this->CI->base_model->the_data_where(
                'networks',
                'network_id, net_id',
                array(
                    'network_name' => 'medium',
                    'user_id' => md_the_user_id()
                )

            );

            // Verify if user has connected accounts
            if ( $get_connected ) {

                // List all connected accounts
                foreach ( $get_connected as $connected ) {

                    // Verify if $net_ids is empty
                    if ( empty($net_ids) ) {

                        // Verify if user has groups
                        if ( !empty($the_data['result']) ) {

                            // List all found chats
                            foreach ( $the_data['result'] as $result ) {

                                if ( !isset($result['message']) ) {
                                    continue;
                                }

                                // Verify if this group is connected
                                if ( $result['message']['chat']['id'] === (int)$connected['net_id'] ) {

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

                        // Verify if user has groups
                        if ( !empty($the_data['result']) ) {

                            // List all found chats
                            foreach ( $the_data['result'] as $result ) {

                                if ( !isset($result['message']) ) {
                                    continue;
                                }

                                // Verify if user has selected this group
                                if ( in_array($result['message']['chat']['id'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this group is connected
                                if ( $result['message']['chat']['id'] === (int)$connected['net_id'] ) {

                                    // Delete the account
                                    if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $connected['network_id'] ) ) ) {

                                        $count++;

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
                
                // Verify if user has groups
                if ( isset($the_data['result']) ) {
                    
                    // Calculate expire token period
                    $expires = '';

                    // Get the user's plan
                    $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                    // Set network's accounts
                    $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                    // Connected networks
                    $connected_networks = $get_connected?array_column($get_connected, 'network_id', 'net_id'):array();

                    // List the groups
                    for ( $y = 0; $y < count($the_data['result']); $y++ ) {

                        // Verify if message exists
                        if ( !isset($the_data['result'][$y]['message']) ) {
                            continue;
                        }

                        // Get connected group
                        $the_connected_group = $this->CI->base_model->the_data_where(
                            'networks',
                            'network_id',
                            array(
                                'network_name' => 'medium',
                                'net_id' => $the_data['result'][$y]['message']['chat']['id'],
                                'user_id' => md_the_user_id(),
                                'user_name' => $the_data['result'][$y]['message']['chat']['title'],
                            )

                        );

                        // Verify if the Telegram's group is already connected
                        if ( $the_connected_group ) {

                            // Set as connected
                            $check++;

                            // Update the page
                            $this->CI->base_model->update(
                                'networks',
                                array(
                                    'network_id' => $the_connected_group[0]['network_id']
                                ),
                                array(
                                    'user_name' => $the_data['result'][$y]['message']['chat']['title'],
                                    'token' => $bot_key
                                )
            
                            );

                        } else {

                            // Save the page
                            $the_response = $this->CI->base_model->insert(
                                'networks',
                                array(
                                    'network_name' => 'medium',
                                    'net_id' => $the_data['result'][$y]['message']['chat']['id'],
                                    'user_id' => md_the_user_id(),
                                    'user_name' => $the_data['result'][$y]['message']['chat']['title'],
                                    'token' => $bot_key
                                )
            
                            );
                            
                            // Verify if the Medium was saved
                            if ( $the_response ) {
                                $check++;
                            }

                        }

                        // Verify if number of the pages was reached
                        if ( $check >= $network_accounts ) {
                            break;
                        }
                        
                    }

                    // If at least a group is subscribed
                    if ( $subscriber_counter ) {

                        // Webhook's URL
                        $webhook_url = site_url('guest/crm_dashboard');

                        // Set webhook
                        @file_get_contents('https://api.telegram.org/bot' . $api_key . '/setWebhook?url=' . $webhook_url);

                    }
                    
                }

            }  else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_no_groups_were_selected')
                    ),
                    TRUE
                );
                exit();
                
            }

        }

        // Verify if at least a Medium was connected
        if ( $check > 0 ) {
            
            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_success',
                array(
                    'message' => $this->CI->lang->line('user_networks_all_groups_were_connected_successfully')
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
            'network_name' => 'Medium',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_medium_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_medium_enabled')?md_the_option('network_medium_enabled'):0
                        )
    
                    )

                )

            )

        );
        
    }



}

/* End of file medium.php */
