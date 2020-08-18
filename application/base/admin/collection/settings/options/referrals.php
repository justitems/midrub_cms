<?php
/**
 * Referrals Options
 *
 * This file contains the class Referrals
 * with all advanced admin's referrals options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Referrals class provides the referrals admin's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
*/
class Referrals {
    
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
     * The public method get_options provides all Admin's general settings
     * 
     * @since 0.0.7.6
     * 
     * @return array with settings
     */ 
    public function get_options() {
        
        // Array with all Admin's general settings
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'enable_referral',
                'title' => $this->CI->lang->line('enable_referrals'),
                'description' => $this->CI->lang->line('enable_referrals_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'referrals_exact_gains',
                'title' => $this->CI->lang->line('exact_gains'),
                'description' => $this->CI->lang->line('exact_gains_description')
            )
            
        );
        
    }

}

