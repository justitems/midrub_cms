<?php
/**
 * Gateways Class
 *
 * This file loads the Gateways Class with properties used to displays gateways in the admin panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the namespaces to use
namespace MidrubBase\Classes\Payments;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Gateways class loads the general properties used to displays gateways in the admin panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Gateways {
    
    /**
     * Contains and array with saved gateways
     *
     * @since 0.0.8.0
     */
    public static $the_gateways = array(); 

    /**
     * The public method set_gateway adds gateway
     * 
     * @param string $gateway_slug contains the gateway's slug
     * @param array $args contains the gateway's arguments
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function set_gateway($gateway_slug, $args) {

        // Verify if the gateway has valid fields
        if ( $gateway_slug && isset($args['gateway_name']) && isset($args['gateway_icon']) ) {

            self::$the_gateways[][$gateway_slug] = $args;
            
        }

    } 

    /**
     * The public method load_gateways loads all gateways
     * 
     * @since 0.0.8.0
     * 
     * @return array with gateways or boolean false
     */
    public function load_gateways() {

        // Verify if gateways exists
        if ( self::$the_gateways ) {

            return self::$the_gateways;

        } else {

            return false;

        }

    }

}
