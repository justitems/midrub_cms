<?php
/**
 * Ajax Controller
 *
 * This file processes the Upgrade's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Upgrade\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Collection\Upgrade\Helpers as MidrubBaseAuthCollectionUpgradeHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.6
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.6
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'auth_upgrade', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_AUTH_UPGRADE );
        
    }

    /**
     * The public method verify_coupon verify if a coupon code is valid
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function verify_coupon() {

        // Verify if Coupon Code is correct
        (new MidrubBaseAuthCollectionUpgradeHelpers\Code)->verify_coupon();
        
    } 
 
}

/* End of file ajax.php */