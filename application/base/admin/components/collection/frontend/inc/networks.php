<?php
/**
 * Networks Inc
 *
 * PHP Version 7.4
 *
 * This files contains the Networks Inc file
 * with methods to manage the networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_frontend_networks') ) {

    /**
     * The function md_the_frontend_networks provides the list with frontend's networks
     * 
     * @return array with networks list
     */
    function md_the_frontend_networks() {

        // Networks array
        $networks = array();

        // List all frontend's networks
        foreach (glob(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'networks/collection/*.php') as $network) {

            // Get the dir name
            $class_name = str_replace(array(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'networks/collection/', '.php'), '', $network);

            // Create an array
            $array = array(
                'CmsBase',
                'Admin',
                'Components',
                'Collection',
                'Frontend',
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

if ( !function_exists('md_the_frontend_network') ) {

    /**
     * The function md_the_frontend_network provides the frontend's network data
     * 
     * @param string $network contains the network's name
     * 
     * @return array with network data or boolean false
     */
    function md_the_frontend_network($network_name) {

        // List all frontend's networks
        foreach (glob(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'networks/collection/*.php') as $network) {

            // Get the dir name
            $class_name = str_replace(array(CMS_BASE_ADMIN_COMPONENTS_FRONTEND . 'networks/collection/', '.php'), '', $network);

            // Verify if is required network
            if ( $network_name !== $class_name ) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'Admin',
                'Components',
                'Collection',
                'Frontend',
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