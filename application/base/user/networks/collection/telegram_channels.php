<?php
/**
 * Telegram Channels
 *
 * PHP Version 7.4
 *
 * Connect Telegram Channels
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
 * Telegram_channels class - allows users to connect to their Telegram channels
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Telegram_channels implements CmsBaseUserInterfaces\Networks {

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
            $this->CI->form_validation->set_rules('bot_token', 'Bot Token', 'trim|required');

            // Get post data
            $bot_token = $this->CI->input->post('bot_token', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() === false) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_bot_key_missing')
                    ),
                    TRUE
                );
                exit();

            } else {

                // Subscriber counter
                $subscriber_counter = 0;

                // Get the updates for testing
                $the_updates_test = @file_get_contents('https://api.telegram.org/bot' . $bot_token . '/getUpdates?limit=1000');

                // Verify if updates exists
                if ( $the_updates_test ) {

                    // Decode
                    $decode_test = json_decode($the_updates_test, TRUE);

                    // Verify if the resonse contains error
                    if ( isset($decode_test['error_code']) ) {

                        // Delete the webhook
                        @file_get_contents('https://api.telegram.org/bot' . $bot_token . '/deleteWebhook');

                        // Increase the subscriber
                        $subscriber_counter++;

                    }

                } else {

                    // Delete the webhook
                    @file_get_contents('https://api.telegram.org/bot' . $bot_token . '/deleteWebhook');

                    // Increase the subscriber
                    $subscriber_counter++;
                    
                }
                
                // Get updates
                $data = @file_get_contents('https://api.telegram.org/bot' . $bot_token . '/getUpdates?limit=1000');

                // Verify if any data is returned
                if ( !empty($data) ) {

                    // Decode the data
                    $the_data = json_decode($data, TRUE);

                    // Verify if updates exists
                    if ( !empty($the_data['result']) ) {
                        
                        // Items array
                        $items = array();

                        // Get connected accounts
                        $get_connected = $this->CI->base_model->the_data_where(
                            'networks',
                            'net_id',
                            array(
                                'network_name' => 'telegram_channels',
                                'user_id' => md_the_user_id()
                            )

                        );

                        // Net Ids array
                        $net_ids = array();

                        // Verify if user has connected accounts
                        if ( $get_connected ) {

                            // List all connected accounts
                            foreach ( $get_connected as $connected ) {

                                // Set net's id
                                $net_ids[] = $connected['net_id'];

                            }

                        }

                        // List all results
                        foreach ( $the_data['result'] as $result ) {

                            if ( !isset($result['channel_post']) || !isset($result['channel_post']['chat']['title']) ) {
                                continue;
                            }

                            // Verify if chat_id already exists
                            if ( isset($items[$result['channel_post']['chat']['id']]) ) {
                                continue;
                            }

                            // Set item
                            $items[$result['channel_post']['chat']['id']] = array(
                                'net_id' => $result['channel_post']['chat']['id'],
                                'name' => $result['channel_post']['chat']['title'],
                                'label' => '',
                                'connected' => FALSE
                            );

                            // Verify if this account is connected
                            if ( in_array($result['channel_post']['chat']['id'], $net_ids) ) {

                                // Set as connected
                                $items[$result['channel_post']['chat']['id']]['connected'] = TRUE;

                            }

                        }

                        // Create the array which will provide the data
                        $params = array(
                            'title' => 'Telegram Channels',
                            'network_name' => 'telegram_channels',
                            'items' => $items,
                            'connect' => $this->CI->lang->line('user_network_channels'),
                            'callback' => site_url('user/callback/telegram_channels'),
                            'inputs' => array(
                                array(
                                    'bot_key' => $bot_token
                                )
                            ) 
                        );

                        // Get the user's plan
                        $user_plan = md_the_user_option(md_the_user_id(), 'plan');

                        // Set network's accounts
                        $params['network_accounts'] = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

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

                    }

                }

            }

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $this->CI->lang->line('user_network_no_telegram_channels_found')
                ),
                TRUE
            );

        } else {
            
            // Display the login form
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_connect',
                array(
                    'page_title' => $this->CI->lang->line('user_network_connect_telegram_channels'),
                    'callback_url' => site_url('user/connect/telegram_channels'),
                    'fields' => array(
                        array(
                            'slug' => 'bot_token',
                            'name' => $this->CI->lang->line('user_network_bot_key'),
                            'type' => 'text',
                            'placeholder' => $this->CI->lang->line('user_network_enter_the_bot_key')
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
                    'network_name' => 'telegram_channels',
                    'user_id' => md_the_user_id()
                )

            );

            // Verify if user has connected accounts
            if ( $get_connected ) {

                // List all connected accounts
                foreach ( $get_connected as $connected ) {

                    // Verify if $net_ids is empty
                    if ( empty($net_ids) ) {

                        // Verify if user has channels
                        if ( !empty($the_data['result']) ) {

                            // List all found chats
                            foreach ( $the_data['result'] as $result ) {

                                if ( !isset($result['channel_post']) ) {
                                    continue;
                                }

                                // Verify if this channel is connected
                                if ( $result['channel_post']['chat']['id'] === (int)$connected['net_id'] ) {

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

                        // Verify if user has channels
                        if ( !empty($the_data['result']) ) {

                            // List all found chats
                            foreach ( $the_data['result'] as $result ) {

                                if ( !isset($result['channel_post']) ) {
                                    continue;
                                }

                                // Verify if user has selected this channel
                                if ( in_array($result['channel_post']['chat']['id'], $net_ids) ) {
                                    continue;
                                }

                                // Verify if this channel is connected
                                if ( $result['channel_post']['chat']['id'] === (int)$connected['net_id'] ) {

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
                
                // Verify if user has channels
                if ( isset($the_data['result']) ) {
                    
                    // Calculate expire token period
                    $expires = '';

                    // Get the user's plan
                    $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                    // Set network's accounts
                    $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                    // Connected networks
                    $connected_networks = $get_connected?array_column($get_connected, 'network_id', 'net_id'):array();

                    // List the channels
                    for ( $y = 0; $y < count($the_data['result']); $y++ ) {

                        // Verify if message exists
                        if ( !isset($the_data['result'][$y]['channel_post']) ) {
                            continue;
                        }

                        // Get connected channel
                        $the_connected_channel = $this->CI->base_model->the_data_where(
                            'networks',
                            'network_id',
                            array(
                                'network_name' => 'telegram_channels',
                                'net_id' => $the_data['result'][$y]['channel_post']['chat']['id'],
                                'user_id' => md_the_user_id(),
                                'user_name' => $the_data['result'][$y]['channel_post']['chat']['title'],
                            )

                        );

                        // Verify if the Telegram's channel is already connected
                        if ( $the_connected_channel ) {

                            // Set as connected
                            $check++;

                            // Update the page
                            $this->CI->base_model->update(
                                'networks',
                                array(
                                    'network_id' => $the_connected_channel[0]['network_id']
                                ),
                                array(
                                    'user_name' => $the_data['result'][$y]['channel_post']['chat']['title'],
                                    'token' => $bot_key
                                )
            
                            );

                        } else {

                            // Save the page
                            $the_response = $this->CI->base_model->insert(
                                'networks',
                                array(
                                    'network_name' => 'telegram_channels',
                                    'net_id' => $the_data['result'][$y]['channel_post']['chat']['id'],
                                    'user_id' => md_the_user_id(),
                                    'user_name' => $the_data['result'][$y]['channel_post']['chat']['title'],
                                    'token' => $bot_key
                                )
            
                            );
                            
                            // Verify if the Telegram_channels was saved
                            if ( $the_response ) {
                                $check++;
                            }

                        }

                        // Verify if number of the pages was reached
                        if ( $check >= $network_accounts ) {
                            break;
                        }
                        
                    }

                    // If at least a channel is subscribed
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
                        'message' => $this->CI->lang->line('user_networks_no_channels_were_selected')
                    ),
                    TRUE
                );
                exit();
                
            }

        }

        // Verify if at least a Telegram_channels was connected
        if ( $check > 0 ) {
            
            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_success',
                array(
                    'message' => $this->CI->lang->line('user_networks_all_channels_were_connected_successfully')
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
            'network_name' => 'Telegram Channels',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_telegram_channels_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_telegram_channels_enabled')?md_the_option('network_telegram_channels_enabled'):0
                        )
    
                    )

                )

            )

        );
        
    }



}

/* End of file telegram_channels.php */
