<?php

/**
 * Ajax Controller
 *
 * This file processes the gateway's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Payments\Collection\Braintree\Controllers;

defined('BASEPATH') or exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Payments\Collection\Braintree\Helpers as CmsBasePaymentsCollectionBraintreeHelpers;

/*
 * Ajax class processes the gateway's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

class Ajax
{

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
        $this->CI = &get_instance();

        // Load language
        $this->CI->lang->load( 'braintree_user', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PAYMENTS_BRAINTREE );

    }

    /**
     * The public method process_payment processes the payments
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function process_payment() {

        // Saves a suggestions group
        (new CmsBasePaymentsCollectionBraintreeHelpers\Process)->prepare();

    }

}

/* End of file ajax.php */