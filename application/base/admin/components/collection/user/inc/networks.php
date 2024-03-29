<?php
/**
 * Networks Inc
 *
 * PHP Version 7.2
 *
 * This files contains the Networks Inc file
 * with methods to manage the networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_user_networks') ) {

    /**
     * The function md_the_user_networks provides the list with user's networks
     * 
     * @return array with networks list
     */
    function md_the_user_networks() {

        // Networks array
        $networks = array();

        // List all user's networks
        foreach (glob(APPPATH . 'base/user/networks/collection/*.php') as $network) {

            // Get the dir name
            $class_name = str_replace(array(APPPATH . 'base/user/networks/collection/', '.php'), '', $network);

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Networks',
                'Collection',
                ucfirst($class_name)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get network's info
            $info = (new $cl())->info();

            // Verify if the required parameters exists
            if ( empty($info['network_name']) || empty($info['network_version']) ) {
                continue;
            }

            // Set network name
            $info['network_name'] = $info['network_name'];

            // Set network slug
            $info['network_slug'] = $class_name;

            // Add info to network
            $networks[] = $info;

        }

        return $networks;
        
    }

}

if ( !function_exists('md_the_user_network') ) {

    /**
     * The function md_the_user_network provides the user's network data
     * 
     * @param string $network contains the network's name
     * 
     * @return array with network data or boolean false
     */
    function md_the_user_network($network_name) {

        // List all user's networks
        foreach (glob(APPPATH . 'base/user/networks/collection/*.php') as $network) {

            // Get the dir name
            $class_name = str_replace(array(APPPATH . 'base/user/networks/collection/', '.php'), '', $network);

            // Verify if is required network
            if ( $network_name !== $class_name ) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Networks',
                'Collection',
                ucfirst($class_name)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get network's info
            $info = (new $cl())->info();

            // Return network's data
            return $info;

        }

        return false;
        
    }

}

/* End of file networks.php */