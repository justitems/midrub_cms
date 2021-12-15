<?php
/**
 * Facebook
 *
 * PHP Version 7.3
 *
 * Connect and and sign up with Facebook
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */

 // Define the file namespace
namespace CmsBase\Auth\Social;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Interfaces as CmsBaseAuthInterfaces;

/**
 * Facebook class - connect and sign up with Facebook
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */
class Facebook implements CmsBaseAuthInterfaces\Social {

    /**
     * Class variables
     */
    public $CI, $fb, $app_id, $app_secret;

    /**
     * Initialize the class
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Facebook app id
        $this->app_id = md_the_option('facebook_auth_app_id');
        
        // Get the Facebook app secret
        $this->app_secret = md_the_option('facebook_auth_app_secret');
        
        // Load the Vendor dependencies
        require_once FCPATH . 'vendor/autoload.php';
            
        if (($this->app_id != '') AND ( $this->app_secret != '')) {
            
            $this->fb = new \Facebook\Facebook([
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => 'v5.0',
                'default_access_token' => '{access-token}',
            ]);
            
        }
        
    }

    /**
     * The public method check_availability verifies if social class is configured
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        if ( ($this->app_id != '') AND ( $this->app_secret != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method connect redirects user to social network where should approve permissions
     * 
     * @param string $redirect_url contains the redirect's url
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function connect($redirect_url=NULL) {

        $helper = $this->fb->getRedirectLoginHelper();
        
        // We need only email permission
        $permissions = array('email');

        // Create the redirect url
        $loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
        
        // Redirect user
        header('Location:' . $loginUrl);
        
    }

    /**
     * The public method save gets the access token and saves it
     * 
     * @param string $redirect_url contains the redirect's url
     * 
     * @return array with response
     */ 
    public function save($redirect_url=NULL) {

        // This function will get access token
        try {
            
            $helper = $this->fb->getRedirectLoginHelper();
            $access_token = $helper->getAccessToken($redirect_url);
            $access_token = (array) $access_token;
            $access_token = array_values($access_token);
            
            if (isset($access_token[0])) {

                // Get cURL resource
                $curl = curl_init();
                
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://graph.facebook.com/me?fields=id,name,email,first_name,last_name&access_token=' . $access_token[0], CURLOPT_HEADER => false));
                
                // Send the request
                $response = curl_exec($curl);
                
                // Close request to clear up some resources
                curl_close($curl);

                // Gets user's data
                $getUserdata = json_decode($response, true);

                if ( isset($getUserdata['id']) ) {

                    // Data to return
                    $data = array(
                        'id' => $getUserdata['id']
                    );

                    // Verify if email exists
                    if ( isset($getUserdata['email']) ) {

                        // Set email
                        $data['email'] = $getUserdata['email'];

                    }

                    // Verify if the first name exists
                    if ( isset($getUserdata['first_name']) ) {

                        // Set first_name
                        $data['first_name'] = $getUserdata['first_name'];

                    }
                    
                    // Verify if the last name exists
                    if ( isset($getUserdata['last_name']) ) {

                        // Set last_name
                        $data['last_name'] = $getUserdata['last_name'];

                    }

                    // Return data
                    return array(
                        'success' => TRUE,
                        'data' => $data
                    );
                    
                } else {

                    return array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_an_error_occurred')
                    );    
                    
                }
                
            } else {
                
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_an_error_occurred')
                );  
                
            }
            
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {

            // When Graph returns an error
            return array(
                'success' => FALSE,
                'message' => $e->getMessage()
            ); 
            
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            
            // When validation fails or other local issues
            return array(
                'success' => FALSE,
                'message' => $e->getMessage()
            );             
            
        }
        
    }

    /**
     * The public method login uses the access token to verify if user is register already
     * 
     * @param string $redirect_url contains the redirect url
     * 
     * @since 0.0.7.8
     * 
     * @return array with response
     */
    public function login($redirect_url=NULL) {

        // This function will get access token
        try {
            
            $helper = $this->fb->getRedirectLoginHelper();
            $access_token = $helper->getAccessToken($redirect_url);
            $access_token = (array) $access_token;
            $access_token = array_values($access_token);
            
            if (isset($access_token[0])) {

                // Get cURL resource
                $curl = curl_init();
                
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://graph.facebook.com/me?fields=id,name,email&access_token=' . $access_token[0], CURLOPT_HEADER => false));
                
                // Send the request
                $response = curl_exec($curl);
                
                // Close request to clear up some resources
                curl_close($curl);

                // Gets user's data
                $getUserdata = json_decode($response, true);

                if ( isset($getUserdata['id']) ) {

                    // Data to return
                    $data = array(
                        'id' => $getUserdata['id']
                    );

                    // Return data
                    return array(
                        'success' => TRUE,
                        'data' => $data
                    );
                    
                } else {

                    return array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('auth_an_error_occurred')
                    );    
                    
                }
                
            }

            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_an_error_occurred')
            );  
            
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            
            // When Graph returns an error
            return array(
                'success' => FALSE,
                'message' => $e->getMessage()
            );  
            
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            
            // When validation fails or other local issues
            return array(
                'success' => FALSE,
                'message' => $e->getMessage()
            );  
            
        }

    }

    /**
     * The public method get_info displays information about this class
     * 
     * @return object with network data
     */
    public function get_info() {

        return (object)array(
            'color' => '#3b5998',
            'icon' => '<i class="fab fa-facebook-f"></i>',
            'api' => array('app_id', 'app_secret')
        );
        
    }

}
