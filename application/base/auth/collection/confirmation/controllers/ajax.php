<?php
/**
 * Ajax Controller
 *
 * This file processes the confirmation's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Collection\Confirmation\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Auth\Collection\Confirmation\Helpers as MidrubBaseAuthCollectionConfirmationHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method resend_confirmation_code resends confirmation code
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function resend_confirmation_code() {

        // Resend confirmation code password
        (new MidrubBaseAuthCollectionConfirmationHelpers\User)->resend_confirmation_code();
        
    }

    /**
     * The public method change_email changes the email and resends activation code
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function change_email() {

        // Change email address
        (new MidrubBaseAuthCollectionConfirmationHelpers\User)->change_email();
        
    }
 
}

/* End of file ajax.php */