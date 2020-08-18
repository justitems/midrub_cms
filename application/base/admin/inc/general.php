<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_update_count') ) {
    
    /**
     * The function get_update_count shows the number of available updates
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    function get_update_count() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get updates
        $get_transaction = $CI->base_model->get_data_where('updates', 'COUNT(update_id) AS  num');

        if ( $get_transaction ) {

            echo $get_transaction[0]['num'];

        } else {

            echo 0;

        }

    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| REGISTER DEFAULT HOOKS
|--------------------------------------------------------------------------
*/