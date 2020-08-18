<?php
/**
 * Ajax Controller
 *
 * This file processes the Reset's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Reset\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Collection\Reset\Helpers as MidrubBaseAuthCollectionResetHelpers;

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
     * The public method reset resets the user password
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function reset_password() {

        // Reset password
        (new MidrubBaseAuthCollectionResetHelpers\User)->reset_password();
        
    }
 
}

/* End of file ajax.php */