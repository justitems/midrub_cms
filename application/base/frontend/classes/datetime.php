<?php
/**
 * Datetime Class
 *
 * This file loads the Datetime Class with methods to display the time
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Datetime class loads methods to display the time
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Datetime {

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
     * The public method the_date formates the timestamp to date
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with date or boolean false
     */
    public function the_date($params) {
     
        // Verify if the required parameters exists
        if ( isset($params['time']) && isset($params['format']) ) {

            // Verify if the parameters are integer
            if ( is_numeric($params['time']) && is_numeric($params['format']) ) {

                // Display date by format
                if ( $params['format'] === '1' ) {

                    return $this->CI->lang->line('frontend_month_' . date('n', $params['time'])) . ' ' . date('j', $params['time']) . ', ' . date('Y', $params['time']);

                }

            }

        }

        return false;

    }

}

/* End of file datetime.php */