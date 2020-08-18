<?php
/**
 * Accounts Helpers
 *
 * This file contains the class Accounts
 * with methods to process the accounts data
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the page namespace
namespace MidrubApps\Collection\Posts\Helpers;

/*
 * Accounts class provides the methods to process the accounts data
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class Accounts {
    
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method list_accounts_for_composer prepares the list with accounts for posts composer
     * 
     * @since 0.0.7.0
     * 
     * @return array with accounts
     */ 
    public function list_accounts_for_composer($accounts) {
        
        if ( $accounts ) {
            
            // Require Autopost's interface
            require_once APPPATH . 'interfaces/Autopost.php';
            
            // Create array for all accounts networks
            $networks = array();
            
            // Create the accounts_list array
            $accounts_list = array();
            
            // List all accounts
            foreach ( $accounts as $account ) {
                
                // Get network's name
                $network = ucfirst($account->network_name);

                // Check if the $network exists in autopost
                if ( file_exists(APPPATH . 'autopost/' . $network . '.php') ) {
                    
                    // Verify if same networks was called before
                    if ( isset( $networks[$account->network_name] ) ) {
                        
                        $accounts_list[] = array(
                            'network_info' => $networks[$account->network_name],
                            'network_id' => $account->network_id,
                            'user_name' => $account->user_name,
                            'user_avatar' => $account->user_avatar,
                            'network_name' => $account->network_name,
                            'network' => $network
                        );
                        
                        continue;
                        
                    }

                    // Now we need to get the key
                    require_once APPPATH . 'autopost/' . $network . '.php';

                    // Call the network class
                    $get = new $network;
                    
                    // Add network info in the array
                    $networks[$account->network_name] = $get->get_info();

                    // Return array with network info and accounts
                    $accounts_list[] = array(
                        'network_info' => $get->get_info(),
                        'network_id' => $account->network_id,
                        'user_name' => $account->user_name,
                        'user_avatar' => $account->user_avatar,
                        'network_name' => $account->network_name,
                        'network' => $network
                    );

                }
            
            }
            
            return $accounts_list;
            
        } else {
            
            return array();
            
        }
        
    }
    
    /**
     * The public method get_network_icon by network's name
     * 
     * @since 0.0.7.0
     * 
     * @param string $network_name contains network's name
     * 
     * @return array with accounts
     */ 
    public function get_network_icon( $network_name ) {
        
        // Require Autopost's interface
        require_once APPPATH . 'interfaces/Autopost.php';

        // Check if the $network exists in autopost
        if ( file_exists(APPPATH . 'autopost/' . $network_name . '.php') ) {

            // Now we need to get the key
            require_once APPPATH . 'autopost/' . $network_name . '.php';

            // Call the network class
            $get = new $network_name;

            // Add network info
            $info = $get->get_info();

            return str_replace(' class', ' style="color: ' . $info->color . ';" class', $info->icon);

        } else {
            
            return false;
            
        }
        
    }

}

