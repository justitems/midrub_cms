<?php
/**
 * Time Inc
 *
 * This file contains the functions
 * for time
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_calculated_time') ) {
    
    /**
     * The function md_the_calculated_time calculates time between two dates
     * 
     * @param integer $from contains the time from
     * @param integer $to contains the time to
     * 
     * @return boolean true or false
     */
    function md_the_calculated_time($from, $to) {

        // Get codeigniter object instance
        $CI = get_instance();

        // Calculate time difference
        $calculate = $to - $from;
        
        // Get after icon
        $after = ' ' . $CI->lang->line('mm104');
        
        // Define $before variable
        $before = '';
        
        // Verify if the difference time is less than 0
        if ( $calculate < 0 ) {
            
            // Get absolute value
            $calculate = abs($calculate);
            
            // Get icon
            $after = '<i class="far fa-calendar-check pull-left"></i> ';
            
            $before = '';
            
        }
        
        // Verify if the difference time is less than 1 minute
        if ( $calculate < 60 ) {
            
            return $CI->lang->line('mm105');
            
        } else if ( $calculate < 3600 ) {
            
            // Display one minute text
            $calc = $calculate / 60;
            return $before . round($calc) . ' ' . $CI->lang->line('mm106') . $after;
            
        } else if ($calculate > 3600 AND $calculate < 86400) {
            
            // Display one hour text
            $calc = $calculate / 3600;
            return $before . round($calc) . ' ' . $CI->lang->line('mm107') . $after;
            
        } else if ($calculate >= 86400) {
            
            // Display one day text
            $calc = $calculate / 86400;
            return $before . round($calc) . ' ' . $CI->lang->line('mm103') . $after;
            
        }
        
    }
    
}

/* End of file time.php */