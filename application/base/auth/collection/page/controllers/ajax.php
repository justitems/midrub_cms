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
namespace CmsBase\Auth\Collection\Page\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Auth\Collection\Page\Helpers as CmsBaseAuthCollectionPageHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method generate_csrf generates csrf code
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function generate_csrf() {

        // Prepare success message 
        $data = array(
            'success' => TRUE,
            'csrf' => array(
                'name' => $this->CI->security->get_csrf_token_name(),
                'hash' => $this->CI->security->get_csrf_hash()
            )
        );

        // Display success message
        echo json_encode($data);
        
    }
 
}

/* End of file ajax.php */