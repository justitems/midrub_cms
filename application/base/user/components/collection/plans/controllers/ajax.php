<?php
/**
 * Ajax Controller
 *
 * This file processes the component's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Plans\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Plans\Helpers as MidrubBaseUserComponentsCollectionPlansHelpers;

/*
 * Ajax class processes the app's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'plans_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_PLANS );
        
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
        (new MidrubBaseUserComponentsCollectionPlansHelpers\Code)->verify_coupon();
        
    } 

}
