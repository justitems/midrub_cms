<?php
/**
 * Wordpress
 *
 * PHP Version 7.4
 *
 * Connect Wordpress blogs
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
 * Wordpress class - allows users to connect to their Wordpress blogs
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Wordpress implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_uri, $api_endpoint = 'https://public-api.wordpress.com/';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();

        // Set the Wordpress Client ID
        $this->client_id = md_the_option('network_wordpress_client_id');
        
        // Set the Wordpress Client Secret
        $this->client_secret = md_the_option('network_wordpress_client_secret');

        // Set the redirect's url
        $this->redirect_uri = site_url('user/callback/wordpress'); 
        
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

        // Prepare params to send
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'response_type' => 'code'
        );

        // Generate redirect url
        $login_url = $this->api_endpoint . 'oauth2/authorize?' . urldecode(http_build_query($params));

        // Redirect
        header('Location:' . $login_url);

    }

    /**
     * The public method callback generates the access token
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function callback($token = null) {   
        
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

        // Set URL
        curl_setopt($curl, CURLOPT_URL, $this->api_endpoint . 'oauth2/token');

        // Enable POST
        curl_setopt($curl, CURLOPT_POST, true);

        // Set POST fields
        curl_setopt(
            $curl, CURLOPT_POSTFIELDS, array(
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => $this->redirect_uri,
                'grant_type' => 'authorization_code'
            )
        );

        // Enable return
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Send request
        $the_token = json_decode(curl_exec($curl), true);

        // Close the CURL session
        curl_close($curl);

        // Verify if the access token exists
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

        // Verify if the response contains the required parameters
        if ( empty($the_token['blog_id']) || empty($the_token['blog_url']) ) {

            // Set view
            echo $this->CI->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $this->CI->lang->line('user_networks_received_blog_information_not_valid')
                ),
                TRUE
            );

            exit();            

        }

        // Get information about the domain
        $the_domain = parse_url($the_token['blog_url']);

        // Set blog name
        $the_blog_name = $the_domain['host'];

        // Init a CURL session
        $curl = curl_init();

        // Set URL
        curl_setopt($curl, CURLOPT_URL, $this->api_endpoint . 'rest/v1.1/sites/' . $the_token['blog_id']);

        // Set header
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $the_token['access_token']));

        // Enable return
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Send request
        $the_blog_information = json_decode(curl_exec($curl), true);

        // Close the CURL session
        curl_close($curl);
        
        // Verify if blog name exists
        if ( !empty($the_blog_information['name']) ) {

            // Change the blog name holder value
            $the_blog_name = $the_blog_information['name'];

        }

        // Get the blog
        $the_blog = $this->CI->base_model->the_data_where(
            'networks',
            'network_id',
            array(
                'network_name' => 'wordpress',
                'net_id' => $the_token['blog_id'],
                'user_id' => md_the_user_id()
            )

        );

        // Verify if the blog is already connected
        if ( $the_blog ) {

            // Update the blog
            $update_response = $this->CI->base_model->update(
                'networks',
                array(
                    'network_name' => 'wordpress',
                    'net_id' => $the_token['blog_id'],
                    'user_id' => md_the_user_id()
                ),
                array(
                    'user_name' => $the_blog_name,
                    'token' => $the_token['access_token']
                )

            );

            // Verify if the blog was updated
            if ( !empty($update_response) ) {

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
                    'network_name' => 'wordpress',
                    'net_id' => $the_token['blog_id'],
                    'user_id' => md_the_user_id(),
                    'user_name' => $the_blog_name,
                    'token' => $the_token['access_token']
                )

            );
            
            // Verify if the blog was saved
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
            'network_name' => 'Wordpress',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_wordpress_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_wordpress_enabled')?md_the_option('network_wordpress_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_wordpress_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Client ID',
                            'field_description' => "The Wordpress's client id could be found in the Wordpress Developer -> My Apps -> App -> Client ID."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_wordpress_client_id')?md_the_option('network_wordpress_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_wordpress_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Client Secret',
                            'field_description' => "The Wordpress's client secret code could be found in the Wordpress Developer -> My Apps -> App -> Client Secret."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the app's secret code ...",
                            'value' => md_the_option('network_wordpress_client_secret')?md_the_option('network_wordpress_client_secret'):'',
                            'disabled' => false
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file wordpress.php */