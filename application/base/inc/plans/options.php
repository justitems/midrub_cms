<?php
/**
 * Plans Options Inc
 *
 * This file contains the plans functions with 
 * options for plans
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Plans as CmsBaseClassesPlans;

if ( !function_exists('md_set_plans_options') ) {
    
    /**
     * The function md_set_plans_options adds app's options for admin
     * 
     * @param array $params contains the app's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_plans_options($params) {

        // Call the options class
        $plans_options = (new CmsBaseClassesPlans\Options);

        // Set plans options in the queue
        $plans_options->set_options($params);
        
    }
    
}

if ( !function_exists('md_the_plans_options') ) {
    
    /**
     * The function md_the_plans_options gets the plans options
     * 
     * @since 0.0.7.9
     * 
     * @return array with plans options or boolean false
     */
    function md_the_plans_options() {

        // Call the options class
        $plans_options = (new CmsBaseClassesPlans\Options);

        // Return plans options
        return $plans_options->load_options();
        
    }
    
}

/* End of file options.php */