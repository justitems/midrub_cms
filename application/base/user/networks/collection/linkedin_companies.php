<?php
/**
 * Linkedin Companies
 *
 * PHP Version 7.4
 *
 * Connect Linkedin Companies
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the namespace
namespace CmsBase\User\Networks\Collection;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\User\Interfaces as CmsBaseUserInterfaces;

// Require the POST Inc file
require_once CMS_BASE_PATH . 'inc/curl/post.php'; 

// Require the GET Inc file
require_once CMS_BASE_PATH . 'inc/curl/get.php'; 

/**
 * Linkedin_companies class - allows users to connect to their Linkedin Companies
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Linkedin_companies implements CmsBaseUserInterfaces\Networks {

    /**
     * Class variables
     */
    public $CI, $client_id, $client_secret, $redirect_uri, $api_endpoint = 'https://api.linkedin.com/';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Set the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Linkedin Client ID
        $this->client_id = md_the_option('network_linkedin_companies_client_id');
        
        // Set the Linkedin Client Secret
        $this->client_secret = md_the_option('network_linkedin_companies_client_secret');

        // Set the redirect's url
        $this->redirect_uri = site_url('user/callback/linkedin_companies'); 
        
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
        $scopes = array();

        // Verify if additional scopes exists
        if ( md_the_option('network_linkedin_companies_scopes') ) {

            // Get the scopes
            $the_scopes = md_the_option('network_linkedin_companies_scopes');

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
            'redirect_uri' => $this->redirect_uri,
            'scope' => implode(',', $scopes),
            'state' => uniqid()
        );
        
        // Set url
        $the_url = 'https://www.linkedin.com/oauth/v2/authorization' . '?' . http_build_query($params);
        
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
            $the_token = $this->CI->input->post('token', TRUE);
            $net_ids = $this->CI->input->post('net_ids', TRUE);

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Request the organizations
                $the_organizations = json_decode(md_the_get(array(
                    'url' => 'https://api.linkedin.com/rest/organizationAcls?q=roleAssignee',
                    'header' => array(
                        'Authorization: Bearer ' . $the_token,
                        'Content-Type: application/json',
                        'X-Restli-Protocol-Version: 2.0.0',
                        'LinkedIn-Version: 202402'
                    )

                )), TRUE);

                // Verify if companies were found
                if ( empty($the_organizations['elements']) ) {

                    // Set view
                    echo $this->CI->load->ext_view(
                        CMS_BASE_PATH . 'user/default/php',
                        'network_error',
                        array(
                            'message' => $this->CI->lang->line('user_networks_no_linkedin_companies_were_found')
                        ),
                        TRUE
                    );

                    exit();

                }

                // Extract Ids
                $organizations = array_column($the_organizations['elements'], 'organization');

                // Replace urn:li:organization:
                $organizations = array_map(function($value) {
                    return str_replace('urn:li:organization:', '', $value);
                }, $organizations);

                // Convert the array to a comma-separated string
                $ids_string = implode(',', $organizations);

                // Get the organizations with data
                $the_organization_list = json_decode(md_the_get(array(
                    'url' => 'https://api.linkedin.com/rest/organizations?ids=List(' . $ids_string . ')',
                    'header' => array(
                        'Authorization: Bearer ' . $the_token,
                        'Content-Type: application/json',
                        'X-Restli-Protocol-Version: 2.0.0',
                        'LinkedIn-Version: 202402'
                    )

                )), TRUE);

                // Get connected linkedin companies
                $the_connected_linkedin_companies = $this->CI->base_model->the_data_where(
                    'networks',
                    'network_id, net_id',
                    array(
                        'network_name' => 'linkedin_companies',
                        'user_id' => md_the_user_id()
                    )

                );

                // Verify if user has connected linkedin companies
                if ( $the_connected_linkedin_companies ) {

                    // List all connected linkedin companies
                    foreach ( $the_connected_linkedin_companies as $connected ) {

                        // Verify if $net_ids is empty
                        if ( empty($net_ids) ) {

                            // Verify if companies were found
                            if ( !empty($the_organization_list['results']) ) {

                                // List the companies
                                foreach ( $the_organization_list['results'] as $key => $value ) {

                                    // Verify if this company is connected
                                    if ( $value['id'] === (int)$connected['net_id'] ) {

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

                            // Verify if companies were found
                            if ( !empty($the_organization_list['results']) ) {

                                // List the companies
                                foreach ( $the_organization_list['results'] as $key => $value ) {

                                    // Verify if user has selected this Linkedin Company
                                    if ( in_array($value['id'], $net_ids) ) {
                                        continue;
                                    }

                                    // Verify if this company is connected
                                    if ( $value['id'] === (int)$connected['net_id'] ) {

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
                    
                    // Verify if companies were found
                    if ( !empty($the_organization_list['results']) ) {

                        // Connected companies
                        $connected_linkedin_companies = !empty($the_connected_linkedin_companies)?array_column($the_connected_linkedin_companies, 'net_id'):array();
                        
                        // Calculate expire token period
                        $expires = '';

                        // Get the user's plan
                        $user_plan = md_the_user_option( md_the_user_id(), 'plan');

                        // Set network's accounts
                        $network_accounts = md_the_plan_feature('network_accounts', $user_plan)?md_the_plan_feature('network_accounts', $user_plan):0;

                        // Connected networks
                        $connected_networks = $the_connected_linkedin_companies?array_column($the_connected_linkedin_companies, 'network_id', 'net_id'):array();

                        // List the companies
                        foreach ( $the_organization_list['results'] as $key => $value ) {


                            // Verify if user has selected this Linkedin Company
                            if ( !in_array((string)$value['id'], $net_ids) ) {
                                continue;
                            }

                            // Verify if the company is already connected
                            if ( in_array((string)$value['id'], $connected_linkedin_companies) ) {

                                // Set as connected
                                $check++;

                                // Update the company
                                $this->CI->base_model->update(
                                    'networks',
                                    array(
                                        'network_name' => 'linkedin_companies',
                                        'net_id' => (string)$value['id'],
                                        'user_id' => md_the_user_id()
                                    ),
                                    array(
                                        'user_name' => $value['localizedName'],
                                        'token' => $the_token
                                    )
                
                                );

                            } else {

                                // Save the company
                                $the_response = $this->CI->base_model->insert(
                                    'networks',
                                    array(
                                        'network_name' => 'linkedin_companies',
                                        'net_id' => $value['id'],
                                        'user_id' => md_the_user_id(),
                                        'user_name' => $value['localizedName'],
                                        'token' => $the_token
                                    )
                
                                );
                                
                                // Verify if the Linkedin Company was saved
                                if ( $the_response ) {
                                    $check++;
                                }

                            }

                            // Verify if number of the companies was reached
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
                            'message' => $this->CI->lang->line('user_networks_no_companies_were_selected')
                        ),
                        TRUE
                    );
                    exit();
                    
                }

            }

            // Verify if at least a Linkedin Company was connected
            if ( $check > 0 ) {
                
                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_success',
                    array(
                        'message' => $this->CI->lang->line('user_networks_all_linkedin_companies_were_connected_successfully')
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

            // Ask for access token
            $the_token = json_decode(md_the_post(array(
                'url' => 'https://www.linkedin.com/oauth/v2/accessToken',
                'fields' => array(
                    'grant_type' => 'authorization_code',
                    'code' => $this->CI->input->get('code', TRUE),
                    'redirect_uri' => $this->redirect_uri,
                    'client_id' => $this->client_id,
                    'client_secret' => $this->client_secret
                )

            )), TRUE);

            // Verify if access token exists
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

            // Request the organizations
            $the_organizations = json_decode(md_the_get(array(
                'url' => 'https://api.linkedin.com/rest/organizationAcls?q=roleAssignee',
                'header' => array(
                    'Authorization: Bearer ' . $the_token['access_token'],
                    'Content-Type: application/json',
                    'X-Restli-Protocol-Version: 2.0.0',
                    'LinkedIn-Version: 202402'
                )

            )), TRUE);

            // Verify if companies were found
            if ( !empty($the_organizations['message']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $the_organizations['message']
                    ),
                    TRUE
                );

                exit();

            }

            // Verify if companies were found
            if ( empty($the_organizations['elements']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $this->CI->lang->line('user_networks_no_linkedin_companies_were_found')
                    ),
                    TRUE
                );

                exit();

            }

            // Extract Ids
            $organizations = array_column($the_organizations['elements'], 'organization');

            // Replace urn:li:organization:
            $organizations = array_map(function($value) {
                return str_replace('urn:li:organization:', '', $value);
            }, $organizations);

            // Convert the array to a comma-separated string
            $ids_string = implode(',', $organizations);

            // Get the organizations with data
            $the_organization_list = json_decode(md_the_get(array(
                'url' => 'https://api.linkedin.com/rest/organizations?ids=List(' . $ids_string . ')',
                'header' => array(
                    'Authorization: Bearer ' . $the_token['access_token'],
                    'Content-Type: application/json',
                    'X-Restli-Protocol-Version: 2.0.0',
                    'LinkedIn-Version: 202402'
                )

            )), TRUE);

            // Verify if companies were found
            if ( !empty($the_organization_list['message']) ) {

                // Set view
                echo $this->CI->load->ext_view(
                    CMS_BASE_PATH . 'user/default/php',
                    'network_error',
                    array(
                        'message' => $the_organization_list['message']
                    ),
                    TRUE
                );

                exit();

            }
            
            // Items array
            $items = array();

            // Get Linkedin Companies
            $the_connected_linkedin_companies = $this->CI->base_model->the_data_where(
                'networks',
                'net_id',
                array(
                    'network_name' => 'linkedin_companies',
                    'user_id' => md_the_user_id()
                )

            );

            // Net Ids array
            $net_ids = array();

            // Verify if user has Linkedin Companies
            if ( $the_connected_linkedin_companies ) {

                // List all linkedin companies
                foreach ( $the_connected_linkedin_companies as $connected ) {

                    // Set net's id
                    $net_ids[] = $connected['net_id'];

                }

            }

            // List the companies
            foreach ( $the_organization_list['results'] as $key => $value ) {

                // Set item
                $items[$value['id']] = array(
                    'net_id' => $value['id'],
                    'name' => $value['localizedName'],
                    'label' => '',
                    'connected' => FALSE
                );

                // Verify if this Company is connected
                if ( in_array($value['id'], $net_ids) ) {

                    // Set as connected
                    $items[$value['id']]['connected'] = TRUE;

                }
                
            }

            // Create the array which will provide the data
            $params = array(
                'title' => 'Linkedin Companies',
                'network_name' => 'linkedin_companies',
                'items' => $items,
                'connect' => $this->CI->lang->line('user_network_linkedin_companies'),
                'callback' => site_url('user/callback/linkedin_companies'),
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
            'network_name' => 'Linkedin Companies',
            'network_version' => '0.1',
            'network_configuration' => array(
                'fields' => array(
                    array(
                        'field_slug' => 'network_linkedin_companies_enabled',
                        'field_type' => 'checkbox',
                        'field_words' => array(
                            'field_title' => 'Enable',
                            'field_description' => 'By enabling this network you will see it in the plans pages. You have to enable it there too for the wanted plans.'
                        ),
                        'field_params' => array(
                            'checked' => md_the_option('network_linkedin_companies_enabled')?md_the_option('network_linkedin_companies_enabled'):0
                        )
    
                    ),
                    array(
                        'field_slug' => 'network_linkedin_companies_client_id',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Linkedin Client ID',
                            'field_description' => "The Linkedin's client ID could be found in the Linkedin Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's id ...",
                            'value' => md_the_option('network_linkedin_companies_client_id')?md_the_option('network_linkedin_companies_client_id'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_companies_client_secret',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Linkedin Client Secret',
                            'field_description' => "The Linkedin's client secret code could be found in the Linkedin Developer -> Client -> Settings -> General."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the client's secret code ...",
                            'value' => md_the_option('network_linkedin_companies_client_secret')?md_the_option('network_linkedin_companies_client_secret'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_companies_scopes',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Additional Scopes',
                            'field_description' => "The additional scopes could be requested by some clients. The scopes should be separated by commas."
                        ),
                        'field_params' => array(
                            'placeholder' => "Enter the scopes ...",
                            'value' => md_the_option('network_linkedin_companies_scopes')?md_the_option('network_linkedin_companies_scopes'):'',
                            'disabled' => false
                        )

                    ),
                    array(
                        'field_slug' => 'network_linkedin_companies_redirect_url',
                        'field_type' => 'text',
                        'field_words' => array(
                            'field_title' => 'Redirect Url',
                            'field_description' => "The redirect url should be used in the Login product from your Linkedin client."
                        ),
                        'field_params' => array(
                            'placeholder' => "",
                            'value' => site_url('user/callback/linkedin_companies'),
                            'disabled' => true
                        )

                    )

                )

            )

        );
        
    }



}

/* End of file linkedin_companies.php */
