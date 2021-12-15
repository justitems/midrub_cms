<?php
/**
 * Twitter
 *
 * PHP Version 5.6
 *
 * Connect and and sign up with Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */

// Define the file namespace
namespace CmsBase\Auth\Social;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Interfaces as CmsBaseAuthInterfaces;
use Abraham\TwitterOAuth\TwitterOAuth;

// If session valiable doesn't exists will be created
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Twitter class - connect and sign up with Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://elements.envato.com/license-terms
 * @link     https://www.midrub.com/
 */
class Twitter implements CmsBaseAuthInterfaces\Social {

    /**
     * Class variables
     */
    public $CI, $connection, $twitter_key, $twitter_secret, $redirect_url;

    /**
     * Initialize the class
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Twitter app key
        $this->twitter_key = md_the_option('twitter_auth_api_key');
        
        // Set the Twitter app secret
        $this->twitter_secret = md_the_option('twitter_auth_api_secret');
        
        // Load the Twtter dependencies
        require_once FCPATH . 'vendor/autoload.php';
        
        // Connect to Twitter api
        $this->connection = new TwitterOAuth($this->twitter_key, $this->twitter_secret);
        
        // Set timeout
        $this->connection->setTimeouts(10, 15);
        
    }

    /**
     * The public method check_availability verifies if social class is configured
     *
     * @return boolean true or false
     */
    public function check_availability() {

        if ( ($this->twitter_key != '') AND ( $this->twitter_secret != '') ) {
            
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

        // Set redirect
        $this->redirect_url = $redirect_url;

        // Set the callback 
        $request_token = $this->connection->oauth('oauth/request_token', array('oauth_callback' => $this->redirect_url));
        
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        
        // Create the redirect url
        $url = $this->connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']) );
        
        // Redirect user
        header('Location: ' . $url);
    }

    /**
     * The public method save gets the access token and saves it
     * 
     * @param string $redirect_url contains the redirect's url
     * 
     * @return array with response
     */ 
    public function save($redirect_url=NULL) {
        
        // Verify if return code exists
        if ( $this->CI->input->get('oauth_verifier', TRUE) ) {

            // this function will get access token
            if ($this->CI->input->get('denied', TRUE)) {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_an_error_occurred')
                ); 

            }

            // Login to Twitter
            $twitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
            
            // Set timeout
            $twitterOauth->setTimeouts(10, 15);
            
            // Get access token
            $twToken = $twitterOauth->oauth('oauth/access_token', array('oauth_verifier' => $this->CI->input->get('oauth_verifier', TRUE)));
            
            // Login to Twitter with access token
            $newTwitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $twToken['oauth_token'], $twToken['oauth_token_secret']);
            
            // Set timeout
            $newTwitterOauth->setTimeouts(10, 15);
            
            // Get user's information
            $response = (array) $newTwitterOauth->get('account/verify_credentials', array('include_email' => 'true') );
            
            // Verify if Twitter's response
            if ( !empty($response['id']) ) {

                // Set Twitter's ID
                $data = array(
                    'id' => $response['id']
                );

                // Verify if email exists
                if ( isset($response['email']) ) {

                    // Set email
                    $data['email'] = $response['email'];

                }

                // Verify if the name exists
                if ( isset($response['name']) ) {

                    // Set first_name
                    $data['first_name'] = $response['name'];

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

        // Verify if return code exists
        if ( $this->CI->input->get('oauth_verifier', TRUE) ) {

            // this function will get access token
            if ($this->CI->input->get('denied', TRUE)) {

                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_an_error_occurred')
                ); 

            }

            // Login to Twitter
            $twitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
            
            // Set timeout
            $twitterOauth->setTimeouts(10, 15);
            
            // Get access token
            $twToken = $twitterOauth->oauth('oauth/access_token', array('oauth_verifier' => $this->CI->input->get('oauth_verifier', TRUE)));
            
            // Login to Twitter with access token
            $newTwitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $twToken['oauth_token'], $twToken['oauth_token_secret']);
            
            // Set timeout
            $newTwitterOauth->setTimeouts(10, 15);
            
            // Get user's information
            $response = (array) $newTwitterOauth->get('account/verify_credentials', array('include_email' => 'true') );
            
            // Verify if Twitter's response
            if ( !empty($response['id']) ) {

                // Set Twitter's ID
                $data = array(
                    'id' => $response['id']
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

    }

    /**
     * The public method get_info displays information about this class
     * 
     * @return object with network data
     */
    public function get_info() {
        
        return (object) array(
            'color' => '#1da1f2',
            'icon' => '<i class="fab fa-twitter"></i>',
            'api' => array('api_key', 'api_secret')
        );
        
    }

}
