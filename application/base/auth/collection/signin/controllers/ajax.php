<?php
/**
 * Ajax Controller
 *
 * This file processes the Signin's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Signin\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Collection\Signin\Helpers as CmsBaseAuthCollectionSigninHelpers;

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
        
    }
    
    /**
     * The public method sign_in sign in 
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function sign_in() {

        // Sign In
        (new CmsBaseAuthCollectionSigninHelpers\User)->sign_in();
        
    }
 
}

/* End of file ajax.php */