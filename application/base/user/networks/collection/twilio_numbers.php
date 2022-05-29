<?php
/**
 * Twilio Services
 *
 * PHP Version 7.4
 *
 * Connect Twilio Services
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
 * Twilio_numbers class - allows users to connect to their Twilio Services
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Twilio_numbers implements CmsBaseUserInterfaces\Networks {

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
            $this->CI->form_validation->set_rules('account_sid', 'Account SID', 'trim|required');
            $this->CI->form_validation->set_rules('auth_token', 'Auth Token', 'trim|required');
            
            // Get post data
            $account_sid = $this->CI->input->post('account_sid');
            $auth_token = $this->CI->input->post('auth_token');

            // Verify if form data is valid
            if ($this->CI->form_validation->run() === false) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_network_please_enter_account_sid_auth_token')
                    ),
                    TRUE
                );
                exit();

            } else {

                // Prepare the url
                $url = 'https://messaging.twilio.com/v1/Services';

                // Curl Init
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL, $url);

                // Set timeout
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);

                // Enable return
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                // Set Basic HTTP authentication method
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

                // Set authentification
                curl_setopt($curl, CURLOPT_USERPWD, $account_sid . ':' . $auth_token);

                // Decode the response
                $the_services_response = json_decode(curl_exec($curl), true);

                // Close curl
                curl_close($curl);
                
                // Verify if services exists
                if ( empty($the_services_response['services']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_twilio_numbers_found')
                        ),
                        TRUE
                    );
                    exit();

                }

                // Phone numbers container
                $phone_numbers = array();

                // List the services
                foreach ( $the_services_response['services'] AS $service ) {

                    // Get the service sid
                    $service_sid = $service['sid'];

                    // Prepare the url
                    $url = 'https://messaging.twilio.com/v1/Services/' . $service_sid . '/PhoneNumbers';

                    // Curl Init
                    $curl = curl_init();

                    // Set url
                    curl_setopt($curl, CURLOPT_URL, $url);

                    // Set timeout
                    curl_setopt($curl, CURLOPT_TIMEOUT, 30);

                    // Enable return
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                    // Set Basic HTTP authentication method
                    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

                    // Set authentification
                    curl_setopt($curl, CURLOPT_USERPWD, $account_sid . ':' . $auth_token);

                    // Decode the response
                    $the_numbers_response = json_decode(curl_exec($curl), true);

                    // Close curl
                    curl_close($curl);

                    // Verify if numbers exists
                    if ( !empty($the_numbers_response['phone_numbers']) ) {

                        // List the phone numbers
                        foreach ( $the_numbers_response['phone_numbers'] AS $phone_number ) {

                            // Add phone number to the container
                            $phone_numbers[] = $phone_number;

                        }

                    }

                }

                // Verify if phone numbers exists
                if ( empty($phone_numbers) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_twilio_numbers_found')
                        ),
                        TRUE
                    );
                    exit();

                }

                // Get connected numbers
                $the_numbers = $this->CI->base_model->the_data_where(
                    'networks',
                    'net_id',
                    array(
                        'network_name' => 'twilio_numbers',
                        'user_id' => md_the_user_id()
                    )

                );

                // Items array
                $items = array();

                // Net Ids array
                $net_ids = array();

                // Verify if user has numbers
                if ( $the_numbers ) {

                    // List all numbers
                    foreach ( $the_numbers as $the_number ) {

                        // Set net's id
                        $net_ids[] = $the_number['net_id'];

                    }

                }

                // Phone numbers
                $the_phone_numbers = array();

                // List all phone numbers
                foreach ( $phone_numbers as $number ) {

                    // Get the phone_number
                    $phone_number = $number['phone_number'];

                    // Verify if the phone number already was saved
                    if ( in_array($phone_number, $the_phone_numbers) ) {
                        continue;
                    } else {
                        $the_phone_numbers[] = $phone_number;
                    }

                    // Set item
                    $items[$phone_number] = array(
                        'net_id' => $phone_number,
                        'name' => $phone_number,
                        'label' => '',
                        'connected' => FALSE
                    );

                    // Verify if this phone number is connected
                    if ( in_array($phone_number, $net_ids) ) {

                        // Set as connected
                        $items[$phone_number]['connected'] = TRUE;

                    }

                }

                // Create the array which will provide the data
                $params = array(
                    'title' => 'Twilio Numbers',
                    'network_name' => 'twilio_numbers',
                    'items' => $items,
                    'connect' => $this->CI->lang->line('user_network_phone_numbers'),
                    'callback' => site_url('user/callback/twilio_numbers'),
                    'inputs' => array(
                        array(
                            'account_sid' => $account_sid
                        ),
                        array(
                            'auth_token' => $auth_token
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

        } else {
            
            // Display the login form
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_connect',
                array(
                    'page_title' => $this->CI->lang->line('user_network_connect_twilio_numbers'),
                    'callback_url' => site_url('user/connect/twilio_numbers'),
                    'fields' => array(
                        array(
                            'slug' => 'account_sid',
                            'name' => $this->CI->lang->line('user_network_account_sid'),
                            'type' => 'text',
                            'placeholder' => $this->CI->lang->line('user_network_enter_the_account_sid')
                        ),
                        array(
                            'slug' => 'auth_token',
                            'name' => $this->CI->lang->line('user_network_auth_token'),
                            'type' => 'text',
                            'placeholder' => $this->CI->lang->line('user_network_enter_the_auth_token')
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
        $this->CI->form_validation->set_rules('account_sid', 'Account SID', 'trim|required');
        $this->CI->form_validation->set_rules('auth_token', 'Auth Token', 'trim|required');
        $this->CI->form_validation->set_rules('net_ids', 'Net Ids', 'trim|required');
        
        // Get post data
        $account_sid = $this->CI->input->post('account_sid');
        $auth_token = $this->CI->input->post('auth_token');
        $net_ids = $this->CI->input->post('net_ids', TRUE);

        // Verify if form data is valid
        if ($this->CI->form_validation->run() == false) {

            // Prepare the url
            $url = 'https://messaging.twilio.com/v1/Services';

            // Curl Init
            $curl = curl_init();

            // Set url
            curl_setopt($curl, CURLOPT_URL, $url);

            // Set timeout
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);

            // Enable return
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // Set Basic HTTP authentication method
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

            // Set authentification
            curl_setopt($curl, CURLOPT_USERPWD, $account_sid . ':' . $auth_token);

            // Decode the response
            $the_services_response = json_decode(curl_exec($curl), true);

            // Close curl
            curl_close($curl);
            
            // Verify if services exists
            if ( empty($the_services_response['services']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_no_twilio_numbers_found')
                    ),
                    TRUE
                );
                exit();

            }

            // Phone numbers container
            $phone_numbers = array();

            // List the services
            foreach ( $the_services_response['services'] AS $service ) {

                // Get the service sid
                $service_sid = $service['sid'];

                // Prepare the url
                $url = 'https://messaging.twilio.com/v1/Services/' . $service_sid . '/PhoneNumbers';

                // Curl Init
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL, $url);

                // Set timeout
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);

                // Enable return
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                // Set Basic HTTP authentication method
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

                // Set authentification
                curl_setopt($curl, CURLOPT_USERPWD, $account_sid . ':' . $auth_token);

                // Decode the response
                $the_numbers_response = json_decode(curl_exec($curl), true);

                // Close curl
                curl_close($curl);

                // Verify if numbers exists
                if ( !empty($the_numbers_response['phone_numbers']) ) {

                    // List the phone numbers
                    foreach ( $the_numbers_response['phone_numbers'] AS $phone_number ) {

                        // Add phone number to the container
                        $phone_numbers[] = $phone_number;

                    }

                }

            }

            // Verify if phone numbers exists
            if ( empty($phone_numbers) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_no_twilio_numbers_found')
                    ),
                    TRUE
                );
                exit();

            }

            // The data array
            $the_data = array();

            // Items array
            $items = array();

            // Get connected numbers
            $the_numbers = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'twilio_numbers',
                    'user_id' => md_the_user_id()
                )

            );

            // Verify if user has numbers
            if ( $the_numbers ) {

                // List all numbers
                foreach ( $the_numbers as $the_number ) {

                    // Verify if $net_ids is empty
                    if ( empty($net_ids) ) {

                        // List all phone numbers
                        foreach ( $phone_numbers as $number ) {

                            // Get the phone_number
                            $phone_number = $number['phone_number'];

                            // Verify if this number is connected
                            if ( $phone_number === $the_number['net_id'] ) {

                                // Delete the number
                                if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $the_number['network_id'] ) ) ) {

                                    // Delete all number's records
                                    md_run_hook(
                                        'delete_network_account',
                                        array(
                                            'account_id' => $the_number['network_id']
                                        )
                                        
                                    );

                                }

                            }

                        }

                        continue;
                        
                    }

                    // Verify if this number is still connected
                    if ( !in_array($the_number['net_id'], $net_ids) ) {

                        // List all phone numbers
                        foreach ( $phone_numbers as $number ) {

                            // Get the phone_number
                            $phone_number = $number['phone_number'];

                            // Verify if this number is connected
                            if ( $phone_number === $the_number['net_id'] ) {

                                // Delete the number
                                if ( $this->CI->base_model->delete( 'networks', array( 'network_id' => $the_number['network_id'] ) ) ) {

                                    // Delete all number's records
                                    md_run_hook(
                                        'delete_network_account',
                                        array(
                                            'account_id' => $the_number['network_id']
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
                $connected_networks = $the_numbers?array_column($the_numbers, 'network_id', 'net_id'):array();

                // Phone numbers
                $the_phone_numbers = array();

                // List all phone numbers
                foreach ( $phone_numbers as $number ) {

                    // Get the phone_number
                    $phone_number = $number['phone_number'];

                    // Get the service sid
                    $service_sid = $number['service_sid'];

                    // Verify if numbers limit was reached
                    if ( $check >= $network_accounts ) {
                        break;
                    }

                    // Get connected number
                    $the_connected_number = $this->CI->base_model->the_data_where(
                        'networks',
                        'network_id',
                        array(
                            'network_name' => 'twilio_numbers',
                            'net_id' => $phone_number,
                            'user_id' => md_the_user_id()
                        )

                    );

                    // Verify if the number is already connected
                    if ( $the_connected_number ) {

                        // Set as connected
                        $check++;

                        // Update the page
                        $update = $this->CI->base_model->update(
                            'networks',
                            array(
                                'network_name' => 'twilio_numbers',
                                'net_id' => $phone_number,
                                'user_id' => md_the_user_id()
                            ),
                            array(
                                'user_name' => $phone_number,
                                'token' => $account_sid,
                                'secret' => $auth_token
                            )
        
                        );

                        // Verify if the phone number was updated
                        if ( $update ) {
                            $check++;
                        }

                    } else {

                        // Save the page
                        $the_response = $this->CI->base_model->insert(
                            'networks',
                            array(
                                'network_name' => 'twilio_numbers',
                                'net_id' => $phone_number,
                                'user_id' => md_the_user_id(),
                                'user_name' => $phone_number,
                                'token' => $account_sid,
                                'secret' => $auth_token,
                                'api_key' => $service_sid
                            )
        
                        );
                        
                        // Verify if the Twilio_numbers was saved
                        if ( $the_response ) {
                            $check++;
                        }

                    }

                }

            } else {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_no_twilio_numbers_selected')
                    ),
                    TRUE
                );
                exit();
                
            }

        }

        // Verify if at least a Twilio_numbers was connected
        if ( $check > 0 ) {
            
            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_success',
                array(
                    'message' => $this->CI->lang->line('user_networks_twilio_numbers_were_connected')
                ),
                TRUE
            );
            exit();
            
        } else {
            
            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_success',
                array(
                    'message' => $this->CI->lang->line('user_networks_twilio_numbers_were_not_connected')
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
            'network_name' => 'Twilio Services',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_twilio_numbers_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_twilio_numbers_enabled')?md_the_option('network_twilio_numbers_enabled'):0
                        )
    
                    )

                )

            )

        );
        
    }

}

/* End of file twilio_numbers.php */