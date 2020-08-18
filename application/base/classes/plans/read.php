<?php
/**
 * Plans Read Class
 *
 * This file loads the Read Class with properties used to extract plans from the database
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes\Plans;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Read class has properties used to extract plans from the database
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Read {

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
     * The public method get_plans gets plans based on arguments
     * 
     * @param array $args contains the arguments to filter the plans
     * 
     * @since 0.0.7.8
     * 
     * @return array with plans or false
     */
    public function get_plans($args=array()) {

        // Get all plans
        $plans = $this->CI->base_model->get_data_where('plans', '*');

        // All plans
        $all_plans = array();

        // Verify if plans exists
        if ( $plans ) {

            // List all plans
            foreach ( $plans as $plan ) {

                // Verify if visible filter exists
                if ( isset($args['visible']) ) {

                    if ((int)$plan['visible'] !== $args['visible']) {
                        continue;
                    }

                }

                // Add plan to list
                $all_plans[] = $plan;

            }

        }

        // Verify if plans exists
        if ( $all_plans ) {

            return $all_plans;

        } else {

            return false;

        }

    } 

}
