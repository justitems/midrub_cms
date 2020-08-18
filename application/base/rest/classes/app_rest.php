<?php
/**
 * Midrub Base App Rest
 *
 * This file contains the class App_rest
 * with methods to load app's endpoints
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Rest\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * App_rest class with methods to load app's endpoints
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class App_rest {

    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method init tries to process the requested endpoint
     * 
     * @param string $app contains the app
     * @param string $endpoint has the app's requested method
     *
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function init($app, $endpoint) {
        
        // Prepare the app
        $app = str_replace('-', '_', $app);

        // Verify if the app exists
        if ( is_dir( MIDRUB_BASE_PATH . 'user/apps/collection/' . $app . '/' ) ) {
            
            // Verify if the app is enabled
            if ( !get_option('app_' . $app . '_enable') ) {
                
                echo json_encode(array(
                    'status' => FALSE,
                    'message' => $this->CI->lang->line('api_failed_connect')
                ));

                exit();
                
            }

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);
            
            // Call method if exists
            (new $cl())->rest($endpoint);
            
        } else {
            
            echo json_encode(array(
                'status' => FALSE,
                'message' => $this->CI->lang->line('api_failed_connect')
            ));
            
        }
        
    }
    
}

