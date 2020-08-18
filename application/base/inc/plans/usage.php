<?php
/**
 * Plans Usage Inc
 *
 * This file contains the plans functions 
 * to show plans usage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Plans as MidrubBaseClassesPlans;

if ( !function_exists('md_set_plans_usage') ) {
    
    /**
     * The function md_set_plans_usage adds plan's usage for user
     * 
     * @param array $args contains the plan's usage for user
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function md_set_plans_usage($args) {

        // Call the usage class
        $plans_usage = (new MidrubBaseClassesPlans\Usage);

        // Set plans usage in the queue
        $plans_usage->set_usage($args);
        
    }
    
}

if ( !function_exists('md_the_plans_usage') ) {
    
    /**
     * The function md_the_plans_usage gets the plans usage
     * 
     * @since 0.0.8.0
     * 
     * @return array with plans usage or boolean false
     */
    function md_the_plans_usage() {

        // Call the usage class
        $plans_usage = (new MidrubBaseClassesPlans\Usage);

        // Return plans usage
        return $plans_usage->load_usage();
        
    }
    
}

/* End of file usage.php */