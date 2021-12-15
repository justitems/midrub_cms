<?php
/**
 * General Inc
 *
 * PHP Version 7.4
 *
 * This files contains the General Inc file
 * with default functions used in the Dashboard's component 
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('dashboard_get_old_events_time') ) {

    /**
     * The function dashboard_get_old_events_time gets the old events time
     * 
     * @return string with the date
     */
    function dashboard_get_old_events_time() {

        // Set the time
        $time = new \DateTime('-6 day');

        return $time->format('Y-m-d');
        
    }

}

if ( !function_exists('dashboard_get_new_events_time') ) {

    /**
     * The function dashboard_get_new_events_time gets the new events time
     * 
     * @return string with the date
     */
    function dashboard_get_new_events_time() {

        // Set the time
        $time = new \DateTime('+7 day');

        return $time->format('Y-m-d');
        
    }

}

/* End of file general.php */