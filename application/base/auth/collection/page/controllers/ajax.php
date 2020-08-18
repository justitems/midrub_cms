<?php
/**
 * Ajax Controller
 *
 * This file processes the Page's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Page\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Collection\Page\Helpers as MidrubBaseAuthCollectionPageHelpers;

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
     * The public method save_new_user creates a new user
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function save_new_user() {

        // Create a new user
        (new MidrubBaseAuthCollectionPageHelpers\User)->save_new_user();
        
    }
 
}

/* End of file ajax.php */