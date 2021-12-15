<?php
/**
 * Notifications Alerts Model
 *
 * PHP Version 7.3
 *
 * Notifications_alerts_model file contains the Notifications Alerts Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notifications_alerts_model class - operates the notifications_alerts table
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Notifications_alerts_model extends CI_MODEL {

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get notifications_alerts table
        $notifications_alerts = $this->db->table_exists('notifications_alerts');
        
        // Verify if the notifications_alerts table exists
        if ( !$notifications_alerts ) {
            
            // Create the notifications_alerts table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_alerts` (
                              `alert_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `alert_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `alert_type` smallint(1) NOT NULL,
                              `alert_audience` smallint(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Get notifications_alerts_fields table
        $notifications_alerts_fields = $this->db->table_exists('notifications_alerts_fields');
        
        // Verify if the notifications_alerts_fields table exists
        if ( !$notifications_alerts_fields ) {
            
            // Create the notifications_alerts_fields table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_alerts_fields` (
                              `field_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `alert_id` bigint(20) NOT NULL,
                              `field_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `field_value` VARBINARY(4000) NOT NULL,
                              `field_extra` VARBINARY(4000) NOT NULL,
                              `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        // Get notifications_alerts_filters table
        $notifications_alerts_filters = $this->db->table_exists('notifications_alerts_filters');

        // Verify if the notifications_alerts_filters table exists
        if ( !$notifications_alerts_filters ) {
            
            // Create the notifications_alerts_filters table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_alerts_filters` (
                                `filter_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                                `alert_id` bigint(20) NOT NULL,
                                `filter_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                `filter_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                `filter_extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        // Get notifications_alerts_users table
        $notifications_alerts_users = $this->db->table_exists('notifications_alerts_users');

        // Verify if the notifications_alerts_users table exists
        if ( !$notifications_alerts_users ) {
            
            // Create the notifications_alerts_users table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_alerts_users` (
                                `id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                                `alert_id` bigint(20) NOT NULL,
                                `user_id` bigint(20) NOT NULL,
                                `banner_seen` smallint(1) NOT NULL,
                                `page_seen` smallint(1) NOT NULL,
                                `deleted` smallint(1) NOT NULL,
                                `updated` varchar(30) NOT NULL,
                                `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
    }

    /**
     * The public method the_errors_users loads users which have errors
     *
     * @param array $args contains the query's parameters
     * 
     * @return array with results or false
     */
    public function the_errors_users($args) {

        // Select data
        $this->db->select("users.*");

        // From notifications_alerts
        $this->db->from('users');

        // Join notifications_alerts_users
        $this->db->join('notifications_alerts_users', "users.user_id=notifications_alerts_users.user_id", 'left');            

        // Join users
        $this->db->join('notifications_alerts', "notifications_alerts_users.alert_id=notifications_alerts.alert_id", 'left');        


        // Join notifications_alerts_fields
        $this->db->join('notifications_alerts_fields', "notifications_alerts.alert_id=notifications_alerts_fields.alert_id AND notifications_alerts_fields.field_name='error_type'", 'left');
        
        // Where container
        $where = array(
            'notifications_alerts.alert_type' => '3'
        );

        // Verify if error type exists
        if ( isset($args['error_type']) ) {

            // Set error type
            $where['notifications_alerts_fields.field_value'] = $error_type;

        }        

        // Set where
        $this->db->where($where);

        // Verify if key exists
        if ( isset($args['key']) ) {

            // Prepare key
            $key = $this->db->escape_like_str($args['key']);

            // Set where in
            $this->db->where_in(
                'users.user_id',
                array(
                    "(SELECT user_id FROM users WHERE username LIKE '%{$key}%' OR email LIKE '%{$key}%' OR last_name LIKE '%{$key}%' OR first_name LIKE '%{$key}%')"
                ),
                FALSE
            ); 
            
        }

        // Group by
        $this->db->group_by('users.user_id');

        // Verify if limit and page exists
        if ( isset($args['limit']) && isset($args['page']) ) {

            // Set limit
            $this->db->limit($args['limit'], $args['page']);

        }

        // Order by
        $this->db->order_by('notifications_alerts.alert_id', 'desc');

        // Get data
        $query = $this->db->get();
        
        // Verify if alerts exists
        if ( $query->num_rows() > 0 ) {

            // Get users
            $users = $query->result_array();

            // Return users
            return $users;
            
        } else {
            
            // Return false
            return false;
            
        }
        
    }
    
}

/* End of file notifications_alerts_model.php */