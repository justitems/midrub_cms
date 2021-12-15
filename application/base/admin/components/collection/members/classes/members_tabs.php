<?php
/**
 * Members Tabs Class
 *
 * This file loads the Members_tabs class with methods to register the member's tabs
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
 * Members_tabs class loads the properties used to collect the member's tabs for the Members component
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Members_tabs {
    
    /**
     * Contains and array with saved tabs
     *
     * @since 0.0.8.3
     */
    public static $the_tabs = array(); 

    /**
     * The public method set_tab registers a member's tab
     * 
     * @param string $tab_slug contains the tab's slug
     * @param array $args contains the contents tab's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function set_tab($tab_slug, $args) {

        // Verify if the tab has valid parameters
        if ( isset($args['tab_name']) && isset($args['tab_icon']) ) {

            self::$the_tabs[$tab_slug] = $args;
            
        }

    }

    /**
     * The public method load_fields loads all members fields
     * 
     * @since 0.0.8.3
     * 
     * @return array with tabs or boolean false
     */
    public function load_tabs() {

        // Verify if tabs exists
        if ( self::$the_tabs ) {

            return self::$the_tabs;

        } else {

            return false;

        }

    }

}

/* End of file members_tabs.php */