<?php
/**
 * Viber
 *
 * PHP Version 7.4
 *
 * Connect Viber accounts
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
 * Viber class - allows users to connect to their Viber accounts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Viber implements CmsBaseUserInterfaces\Networks {

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
                        'message' => $this->CI->lang->line('user_network_viber_token_missing')
                    ),
                    TRUE
                );

            } else {

                // Prepare the url
                $url = 'https://chatapi.viber.com/pa/get_account_info';

                // Curl Init
                $curl = curl_init();

                // Set url
                curl_setopt($curl, CURLOPT_URL, $url);

                // Set timeout
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);

                // Enable return
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                // Enable POST Request
                curl_setopt($curl, CURLOPT_POST, 1);

                // Set fields
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
                    array(
                        'auth_token' => $bot_token
                    )
                ));

                // Set header
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                // Decode the response
                $the_response = json_decode(curl_exec($curl), true);

                // Close curl
                curl_close($curl);
                
                // Verify if the id is valid
                if ( !empty($the_response['id']) ) {

                    // Get the viber's account
                    $the_viber_account = $this->CI->base_model->the_data_where(
                        'networks',
                        'network_id',
                        array(
                            'network_name' => 'viber',
                            'net_id' => $the_response['id'],
                            'user_id' => md_the_user_id()
                        )

                    );

                    // Verify if the account is already connected
                    if ( $the_viber_account ) {

                        // Update the account
                        $update = $this->CI->base_model->update(
                            'networks',
                            array(
                                'network_name' => 'viber',
                                'net_id' => $the_response['id'],
                                'user_id' => md_the_user_id()
                            ),
                            array(
                                'user_name' => $the_response['name'],
                                'token' => $bot_token
                            )
        
                        );

                        // Verify if the account was updated
                        if ( $update ) {
                            
                            // Set view
                            echo $this->CI->load->ext_view(
                                CMS_BASE_PATH . 'user/default/php',
                                'network_success',
                                array(
                                    'message' => $this->CI->lang->line('user_networks_account_was_connected')
                                ),
                                TRUE
                            );

                        } else {

                            // Set view
                            echo $this->CI->load->ext_view(
                                CMS_BASE_PATH . 'user/default/php',
                                'network_error',
                                array(
                                    'message' => $this->CI->lang->line('user_networks_account_was_not_connected')
                                ),
                                TRUE
                            );
                            
                        }

                    } else {

                        // Save the account
                        $the_response = $this->CI->base_model->insert(
                            'networks',
                            array(
                                'network_name' => 'viber',
                                'net_id' => $the_response['id'],
                                'user_id' => md_the_user_id(),
                                'user_name' => $the_response['name'],
                                'token' => $bot_token
                            )
        
                        );
                        
                        // Verify if the account was saved
                        if ( $the_response ) {

                            // Set view
                            echo $this->CI->load->ext_view(
                                CMS_BASE_PATH . 'user/default/php',
                                'network_success',
                                array(
                                    'message' => $this->CI->lang->line('user_networks_account_was_connected')
                                ),
                                TRUE
                            );

                        } else {

                            // Set view
                            echo $this->CI->load->ext_view(
                                CMS_BASE_PATH . 'user/default/php',
                                'network_error',
                                array(
                                    'message' => $this->CI->lang->line('user_networks_account_was_not_connected')
                                ),
                                TRUE
                            );
                            
                        }

                    }

                } else {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_network_viber_token_missing')
                        ),
                        TRUE
                    );

                }

            }

        } else {
            
            // Display the login form
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_connect',
                array(
                    'page_title' => $this->CI->lang->line('user_network_connect_viber'),
                    'callback_url' => site_url('user/connect/viber'),
                    'fields' => array(
                        array(
                            'slug' => 'bot_token',
                            'name' => $this->CI->lang->line('user_network_viber_token'),
                            'type' => 'text',
                            'placeholder' => $this->CI->lang->line('user_network_enter_viber_token')
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
            'network_name' => 'Viber',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_viber_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_viber_enabled')?md_the_option('network_viber_enabled'):0
                        )
    
                    )

                )

            )

        );
        
    }



}

/* End of file viber.php */