<?php
/**
 * Dashboard Model
 *
 * PHP Version 7.4
 *
 * Dashboard_model contains the Dashboard Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}

/**
 * Dashboard_model class - main modal in the component which creates the missing tables
 *
 * @since 0.0.8.5
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Dashboard_model extends CI_MODEL {

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get dashboard_widgets table
        $dashboard_widgets = $this->db->table_exists('dashboard_widgets');
        
        // Verify if the dashboard_widgets table exists
        if ( !$dashboard_widgets ) {
            
            // Create the dashboard_widgets table
            $this->db->query('CREATE TABLE IF NOT EXISTS `dashboard_widgets` (
                `widget_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `user_id` int(11) NOT NULL,
                `widget` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `widget_position` int(4) NOT NULL,
                `status` tinyint(1) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        // Get dashboard_events table
        $dashboard_events = $this->db->table_exists('dashboard_events');
        
        // Verify if the dashboard_events table exists
        if ( !$dashboard_events ) {
            
            // Create the dashboard_events table
            $this->db->query('CREATE TABLE IF NOT EXISTS `dashboard_events` (
                `event_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `event_type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `created` varchar(30) COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        // Get dashboard_events_meta table
        $dashboard_events_meta = $this->db->table_exists('dashboard_events_meta');
        
        // Verify if the dashboard_events_meta table exists
        if ( !$dashboard_events_meta ) {
            
            // Create the dashboard_events_meta table
            $this->db->query('CREATE TABLE IF NOT EXISTS `dashboard_events_meta` (
                `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `event_id` bigint(20) NOT NULL,
                `meta_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
                `meta_value` text COLLATE utf8_unicode_ci NOT NULL,
                `meta_extra` text COLLATE utf8_unicode_ci NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
    }
    
}

/* End of file dashboard_model.php */