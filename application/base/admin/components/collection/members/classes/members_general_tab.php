<?php
/**
 * Members General Tab Class
 *
 * This file loads the Members_general_tab class with methods to register data for the General Tab
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Members\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Members_general_tab class loads the properties used to collect the data for the General Tab
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Members_general_tab {
    
    /**
     * Contains and array with saved data
     *
     * @since 0.0.8.3
     */
    public static $the_tab_data = array(); 

    /**
     * The public method set_tab_data registers new data for the General Members tab
     * 
     * @param string $func contains the function's name
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function set_tab_data($func) {

        self::$the_tab_data[] = $func;

    }

    /**
     * The public method load_tab_data loads all data for the General Members tab
     * 
     * @since 0.0.8.3
     * 
     * @return array with tab's data or boolean false
     */
    public function load_tab_data() {

        // Verify if data exists
        if ( self::$the_tab_data ) {

            return self::$the_tab_data;

        } else {

            return false;

        }

    }

}

/* End of file members_general_tab.php */