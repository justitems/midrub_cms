<?php
/**
 * Ajax Controller
 *
 * This file processes the Change Password's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Change_password\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Collection\Change_password\Helpers as CmsBaseAuthCollectionChange_passwordHelpers;

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
     * The public method change_password changes the user password
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function change_password() {

        // Change password
        (new CmsBaseAuthCollectionChange_passwordHelpers\User)->change_password();
        
    }
 
}

/* End of file ajax.php */