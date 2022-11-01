<?php
/**
 * Time Timezone Class
 *
 * This file loads the Timezone Class with methods calculate the times by timezone
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Time;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Timezone class loads the methods to calculate the times by timezone
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Timezone {

    /**
     * The public method the_date_time_to_timestamp converts a string to timestamp
     * 
     * @param integer $user_id contains the user's ID
     * @param string $date_time contains the date and time
     * 
     * @since 0.0.8.5
     * 
     * @return integer with time
     */
    public function the_date_time_to_timestamp($user_id, $date_time) {

        // Time zone offset
        $the_default_time_zone = 0;

        // Get time zone
        $the_user_time_zone = md_the_user_option($user_id, 'user_time_zone');

        // Check for timezone
        if ( $the_user_time_zone !== FALSE ) {
            
            // Set time zone
            $the_default_time_zone = $the_user_time_zone;

        }

        // Set time zone
        $start_date = date_create('now', timezone_open($this->the_time_zone($the_default_time_zone)));

        // Get end date
        $end_date =  date_create($date_time, timezone_open($this->the_time_zone($the_default_time_zone)));

        // Return the expected time
        return time() + $end_date->format('U') - $start_date->format('U');
        
    }

    /**
     * The public method the_time_zone gets the time zone
     * 
     * @param string $offset contains the time zone offset
     * 
     * @since 0.0.8.5
     * 
     * @return string
     */
    public function the_time_zone($offset) {

        // Time zones list
        $time_zones_list = array (
            '-11' => 'Pacific/Midway',
            '-10' => 'Pacific/Honolulu',
            '-9' => 'US/Alaska',
            '-8' => 'America/Los_Angeles',
            '-7' => 'America/Chihuahua',
            '-6' => 'Canada/Saskatchewan',
            '-5' => 'America/Bogota',
            '-4' => 'Canada/Atlantic',
            '-4.30' => 'America/Caracas',
            '-4' => 'America/La_Paz',
            '-3.30' => 'Canada/Newfoundland',
            '-3' => 'America/Sao_Paulo',
            '-2' => 'America/Noronha',
            '-1' => 'Atlantic/Cape_Verde',
            '0' => 'UTC',
            '1' => 'Europe/Zagreb',
            '2' => 'Europe/Vilnius',
            '3' => 'Europe/Bucharest',
            '3.30' => 'Asia/Tehran',
            '4' => 'Asia/Yerevan',
            '4.30' => 'Asia/Kabul',
            '5' => 'Asia/Tashkent',
            '5.30' => 'Asia/Calcutta',
            '5.45' => 'Asia/Katmandu',
            '6' => 'Asia/Yekaterinburg',
            '6.30' => 'Asia/Rangoon',
            '7' => 'Asia/Novosibirsk',
            '8' => 'Asia/Urumqi',
            '9' => 'Asia/Tokyo',
            '9.30' => 'Australia/Darwin',
            '10' => 'Asia/Yakutsk',
            '10.30' => 'Australia/Adelaide',
            '11' => 'Asia/Vladivostok',
            '12' => 'Pacific/Auckland',
            '13' => 'Pacific/Tongatapu'
        );

        return !empty($time_zones_list[$offset])?$time_zones_list[$offset]:$time_zones_list['0'];
        
    }    

}

/* End of file timezone.php */