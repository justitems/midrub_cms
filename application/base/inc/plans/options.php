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
use MidrubBase\Classes\Plans as MidrubBaseClassesPlans;

if ( !function_exists('md_set_plans_options') ) {
    
    /**
     * The function md_set_plans_options adds app's options for admin
     * 
     * @param array $args contains the app's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_plans_options($args) {
        
        // Call the options class
        $plans_options = (new MidrubBaseClassesPlans\Options);

        // Set plans options in the queue
        $plans_options->set_options($args);
        
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
        $plans_options = (new MidrubBaseClassesPlans\Options);

        // Return plans options
        return $plans_options->load_options();
        
    }
    
}

if ( !function_exists('md_get_plans_options') ) {
    
    /**
     * The function md_get_plans_options generates plans options
     * 
     * @param integer $plan_id contains the plan's id
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_plans_options($plan_id) {
        
        // Get plans options
        $plans_options = md_the_plans_options();

        // Verify if plans options exists
        if ( $plans_options ) {

            // Set tabs
            $tabs = '';

            // Lista all options
            foreach ( $plans_options as $options ) {

                $active = '';

                if ( $options['slug'] === 'general' ) {
                    $active = ' active in';
                }

                $tabs .= '<div class="tab-pane fade' . $active . '" id="nav-' . $options['slug'] . '" role="tabpanel" aria-labelledby="nav-general">';

                // Verify if fields exists
                if ( $options['fields'] ) {

                    $tabs .= '<ul>';

                    // List all fields
                    foreach ( $options['fields'] as $field ) {

                        if ( !isset($field['type']) ) {
                            continue;
                        }

                        // Verify if class has the method
                        if (method_exists((new MidrubBaseClassesPlans\Options_templates), $field['type'])) {

                            // Set the method to call
                            $method = $field['type'];

                            // Display input
                            $tabs .= (new MidrubBaseClassesPlans\Options_templates)->$method($field, $plan_id);
                        }

                    }

                    $tabs .= '</ul>';

                }

                $tabs .= '</div>';

            }

            echo $tabs;

        }
        
    }
    
}

/* End of file options.php */