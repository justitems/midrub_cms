<?php
/**
 * Networks Controller
 *
 * PHP Version 7.4
 *
 * Networks connects and manages the CMS networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Networks class - loads the Midrub's content
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Networks extends CI_Controller {
    
    /**
     * Class variables
     */   
    public $user_id, $user_role;
    
    /**
     * Initialise the Networks controller
     */
    public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');

        // Require the base class
        $this->load->file(APPPATH . '/base/main.php');

        // Load Base Model
        $this->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_model', 'base_model' );

        // Require the General Inc file
        require_once CMS_BASE_PATH . 'user/inc/general.php';

        // Require the Post Inc file
        require_once CMS_BASE_PATH . 'inc/curl/post.php';   
        
        // Require the Get Inc file
        require_once CMS_BASE_PATH . 'inc/curl/get.php';

        // Load Base Model
        $this->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_users', 'base_users');

        // Load language
        $this->lang->load( 'user_networks', $this->config->item('language'), FALSE, TRUE, CMS_BASE_PATH . 'user/' );

        // Get user data
        $user_data = $this->base_users->get_user_data_by_username($this->session->userdata['username']);

        // Verify if user exists
        if ( $user_data ) {

            // Set user data
            md_set_data('user_data', (array)$user_data[0]);

            // Set user_id
            $this->user_id = $user_data[0]->user_id;

            // Set user_role
            $this->user_role = $user_data[0]->role;

            // Set user_status
            $this->user_status = $user_data[0]->status;

            // Get user language
            $user_lang = md_the_user_option($this->user_id, 'user_language');

            // Verify if user has selected a language
            if ($user_lang) {
                md_set_config_item('language', $user_lang);
            }       

        }
        
    }
    
    /**
     * The public method connect redirects user to the login page
     *
     * @param string $networks contains the name of network
     * 
     * @return void
     */
    public function connect($network) {

        // Check if session username exists
        if ( !isset($this->session->userdata['username']) ) {
            
            // Redirect to the home page
            redirect('/');
            
        }
        
        // Get the number of accounts
        $the_accounts = $this->base_model->the_data_where('networks', 'COUNT(*) AS total', array('network_name' => $network, 'user_id' => $this->user_id));

        // Prepare the number of accounts
        $the_number_of_accounts = $the_accounts?$the_accounts[0]['total']:0;

        // Verify if user has reached his plan
        if ( md_the_plan_feature('network_accounts') <= $the_number_of_accounts ) {
            
            // Display the error message
            $this->get_html('error', array('message' => $this->lang->line('user_networks_maximum_number_of_accounts')));
            
        }
        
        // Verify if the network exists
        if ( file_exists(APPPATH . 'base/user/networks/collection/' . $network . '.php') ) {

            // Verify if the network is available for the user's plan
            if ( !md_the_plan_feature('network_' . $network) ) {

                // Display the error message
                $this->get_html('error', array('message' => $this->lang->line('user_network_is_not_enabled_for_your_plan')));

            }
            
            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Networks',
                'Collection',
                ucfirst($network)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Verify if the network is configured
            if ( !(new $cl())->availability() ) {

                // Display the error message
                $this->get_html('error', array('message' => $this->lang->line('user_network_not_configured')));                

            }

            // Try to connect
            (new $cl())->connect();
            
        } else {
            
            // Display the error message
            $this->get_html('error', array('message' => $this->lang->line('user_network_was_not_found')));
            
        }
        
    }

    /**
     * The public method callback saves token from a social network
     *
     * @param string $network contains the network's name
     * 
     * @return void
     */
    public function callback($network) {
        
        // Check if session username exists
        if ( !isset($this->session->userdata['username']) ) {
            
            // Redirect to the home page
            redirect('/');
            
        }
        
        // Get the number of accounts
        $the_accounts = $this->base_model->the_data_where('networks', 'COUNT(*) AS total', array('network_name' => $network, 'user_id' => $this->user_id));

        // Prepare the number of accounts
        $the_number_of_accounts = $the_accounts?$the_accounts[0]['total']:0;

        // Verify if user has reached his plan
        if ( md_the_plan_feature('network_accounts') <= $the_number_of_accounts ) {
            
            // Display the error message
            $this->get_html('error', array('message' => $this->lang->line('user_networks_maximum_number_of_accounts')));
            
        }
        
        // Verify if the network exists
        if ( file_exists(APPPATH . 'base/user/networks/collection/' . $network . '.php') ) {

            // Verify if the network is available for the user's plan
            if ( !md_the_plan_feature('network_' . $network) ) {

                // Display the error message
                $this->get_html('error', array('message' => $this->lang->line('user_network_is_not_enabled_for_your_plan')));

            }
            
            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Networks',
                'Collection',
                ucfirst($network)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Verify if the network is configured
            if ( !(new $cl())->availability() ) {

                // Display the error message
                $this->get_html('error', array('message' => $this->lang->line('user_network_not_configured')));                

            }

            // Try to generate the token
            (new $cl())->callback();
            
        } else {
            
            // Display the error message
            $this->get_html('error', array('message' => $this->lang->line('user_network_was_not_found')));
            
        }
        
    }

    /**
     * The protected method get_html gets html for the networks
     * 
     * @param string $template contains the html's template name
     * @param array $params contains the parameters
     * 
     * @return void
     */
    protected function get_html($template, $params) {

        // Verify which template should be loaded
        if ( $template === 'error' ) {

            // Set view
            echo $this->load->ext_view(
                CMS_BASE_PATH . 'user/default/php',
                'network_error',
                array(
                    'message' => $params['message']
                ),
                TRUE
            );

        }

        exit();
        
    }
    
}

/* End of file networks.php */