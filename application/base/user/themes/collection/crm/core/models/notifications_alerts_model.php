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
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notifications_alerts_model class - operates the notifications alerts tables
 *
 * @since 0.0.8.3
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Notifications_alerts_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'notifications';

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
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

    /**
     * The public method the_alerts gets all alerts from database
     *
     * @param array $args contains the query's parameters
     * 
     * @return array with results or false
     */
    public function the_alerts($args) {

        // Select data
        $this->db->select("notifications_alerts.alert_id, notifications_alerts.alert_type, notifications_alerts.created, notifications_alerts_fields.field_value as name, enabled.field_value as enabled, plans.filter_value as plans,
        languages.filter_value as languages, notifications_alerts_users.deleted, notifications_alerts_users.banner_seen");

        // From notifications_alerts
        $this->db->from('notifications_alerts');

        // Join notifications_alerts_fields
        $this->db->join('notifications_alerts_fields', "notifications_alerts.alert_id=notifications_alerts_fields.alert_id AND notifications_alerts_fields.field_name='banner_content'", 'left');
        $this->db->join('notifications_alerts_fields enabled', "notifications_alerts.alert_id=enabled.alert_id AND enabled.field_name='banner_enabled'", 'left');
        $this->db->join('notifications_alerts_filters plans', "notifications_alerts.alert_id=plans.alert_id AND plans.filter_name='plans'", 'left');
        $this->db->join('notifications_alerts_filters languages', "notifications_alerts.alert_id=languages.alert_id AND languages.filter_name='languages'", 'left');
        $this->db->join('notifications_alerts_users', 'notifications_alerts.alert_id=notifications_alerts_users.alert_id', 'left');

        // Set where
        $this->db->where(array(
            'enabled.field_value' => '1',
            'notifications_alerts.alert_audience' => '0',
            'notifications_alerts_fields.language' => $args['language']
        ));

        // Group by
        $this->db->group_by(array('notifications_alerts.alert_id', 'notifications_alerts.alert_type'));

        // Order by
        $this->db->order_by('notifications_alerts.alert_id', 'desc');

        // Get data
        $query = $this->db->get();
 
        // Verify if alerts exists
        if ( $query->num_rows() > 0 ) {

            // Get alerts
            $alerts_response = $query->result_array();

            // Alerts allowed
            $alerts = array();

            // Alert types
            $alert_types = array();

            // List alerts
            for ( $p = 0; $p < $query->num_rows(); $p++ ) {

                // Verify if the alert is deleted
                if ( !empty($alerts_response[$p]['deleted']) ) {
                    continue;
                } 
                
                // Verify if the alert's banner is seen
                if ( !empty($alerts_response[$p]['banner_seen']) && (($alerts_response[$p]['alert_type'] !== '2') || ($alerts_response[$p]['alert_type'] !== '5')) ) {
                    continue;
                }

                // Verify if the news alert has less than 60 days
                if ( ( (int)$alerts_response[$p]['created'] < (time() - 7776000) ) && ( $alerts_response[$p]['alert_type'] === '0' ) ) {
                    continue;
                }                 

                // Available counter
                $available = 0;

                // Verify if plans exists
                if ( !empty($alerts_response[$p]['plans']) ) {

                    // List available plans
                    foreach ( unserialize($alerts_response[$p]['plans']) as $plan ) {

                        // Verify if the user plan is allowed
                        if ( $plan === $args['plan'] ) {

                            // Increase the counter
                            $available++;                            

                        }

                    }

                } else {

                    // Increase the counter
                    $available++;

                }

                // Verify if languages exists
                if ( !empty($alerts_response[$p]['languages']) ) {

                    // List available languages
                    foreach ( unserialize($alerts_response[$p]['languages']) as $language ) {

                        // Verify if the user language is allowed
                        if ( $language === $args['language'] ) {

                            // Increase the counter
                            $available++;                            

                        }

                    }

                } else {

                    // Increase the counter
                    $available++;

                }
                
                // Verify if $available is higher than 1
                if ( ( $available > 1 ) && !isset($alert_types[$alerts_response[$p]['alert_type']]) ) {

                    // Set alerts
                    $alerts[] = $alerts_response[$p]['alert_id'];

                    // Set alert's type
                    $alert_types[$alerts_response[$p]['alert_type']] = $alerts_response[$p]['alert_type'];

                }

            }

            // Verify if alerts exists
            if ( $alerts ) {

                // Select data
                $this->db->select('notifications_alerts_fields.alert_id, notifications_alerts_fields.field_value as content, notifications_alerts.alert_type');

                // From notifications_alerts
                $this->db->from('notifications_alerts_fields');

                // Join tables
                $this->db->join('notifications_alerts', 'notifications_alerts_fields.alert_id=notifications_alerts.alert_id', 'left');
                $this->db->join('notifications_alerts_users', 'notifications_alerts_fields.alert_id=notifications_alerts_users.alert_id', 'left');

                // Set where
                $this->db->where(array(
                    'notifications_alerts_fields.field_name' => 'banner_content',
                    'notifications_alerts_fields.language' => $args['language']
                ));

                // Set where_in
                $this->db->where_in('notifications_alerts_fields.alert_id', $alerts);

                // Group by
                $this->db->group_by('notifications_alerts.alert_type');

                // Order by
                $this->db->order_by('notifications_alerts.alert_id', 'desc');

                // Set limit
                $this->db->limit(3, 0);

                // Get alerts
                $get_alerts = $this->db->get();
                
                // Verify if alerts exists
                if ( $get_alerts->num_rows() > 0 ) {

                    // Return response
                    return array(
                        'alerts' => $get_alerts->result_array()
                    );

                } else {

                    return false;

                }

            } else {

                return false;

            }
            
        } else {
            
            // Return false
            return false;
            
        }
        
    }

    /**
     * The public method the_error_alerts gets all error alerts from database
     *
     * @param array $args contains the query's parameters
     * 
     * @return array with results or false
     */
    public function the_error_alerts($args) {

        // Select data
        $this->db->select("notifications_alerts.alert_id, notifications_alerts.alert_type, notifications_alerts.created, notifications_alerts_fields.field_value as name, enabled.field_value as enabled, plans.filter_value as plans,
        languages.filter_value as languages, notifications_alerts_users.deleted, notifications_alerts_users.banner_seen");

        // From notifications_alerts
        $this->db->from('notifications_alerts');

        // Join notifications_alerts_fields
        $this->db->join('notifications_alerts_fields', "notifications_alerts.alert_id=notifications_alerts_fields.alert_id AND notifications_alerts_fields.field_name='banner_content'", 'left');
        $this->db->join('notifications_alerts_fields enabled', "notifications_alerts.alert_id=enabled.alert_id AND enabled.field_name='banner_enabled'", 'left');
        $this->db->join('notifications_alerts_filters plans', "notifications_alerts.alert_id=plans.alert_id AND plans.filter_name='plans'", 'left');
        $this->db->join('notifications_alerts_filters languages', "notifications_alerts.alert_id=languages.alert_id AND languages.filter_name='languages'", 'left');
        $this->db->join('notifications_alerts_users', 'notifications_alerts.alert_id=notifications_alerts_users.alert_id', 'left');

        // Set where
        $this->db->where(array(
            'enabled.field_value' => '1',
            'notifications_alerts.alert_type' => '3',
            'notifications_alerts_fields.language' => $args['language'],
            'notifications_alerts_users.user_id' => $args['user_id']
        ));

        // Group by
        $this->db->group_by(array('notifications_alerts.alert_id', 'notifications_alerts.alert_type'));

        // Order by
        $this->db->order_by('notifications_alerts.alert_id', 'desc');

        // Get data
        $query = $this->db->get();
     
        // Verify if alerts exists
        if ( $query->num_rows() > 0 ) {

            // Get alerts
            $alerts_response = $query->result_array();

            // Alerts allowed
            $alerts = array();

            // Alert types
            $alert_types = array();

            // List alerts
            for ( $p = 0; $p < $query->num_rows(); $p++ ) {

                // Verify if the alert is deleted
                if ( !empty($alerts_response[$p]['deleted']) ) {
                    continue;
                }
                
                // Verify if the alert's banner is seen
                if ( !empty($alerts_response[$p]['banner_seen']) && ($alerts_response[$p]['alert_type'] !== '2') ) {
                    continue;
                }

                // Available counter
                $available = 0;

                // Verify if plans exists
                if ( !empty(unserialize($alerts_response[$p]['plans'])) ) {

                    // List available plans
                    foreach ( unserialize($alerts_response[$p]['plans']) as $plan ) {

                        // Verify if the user plan is allowed
                        if ( $plan === $args['plan'] ) {

                            // Increase the counter
                            $available++;                            

                        }

                    }

                } else {

                    // Increase the counter
                    $available++;

                }

                // Verify if languages exists
                if ( !empty(unserialize($alerts_response[$p]['languages'])) ) {

                    // List available languages
                    foreach ( unserialize($alerts_response[$p]['languages']) as $language ) {

                        // Verify if the user language is allowed
                        if ( $language === $args['language'] ) {

                            // Increase the counter
                            $available++;                            

                        }

                    }

                } else {

                    // Increase the counter
                    $available++;

                }
                
                // Verify if $available is higher than 1
                if ( ( $available > 1 ) && !isset($alert_types[$alerts_response[$p]['alert_type']]) ) {

                    // Set alerts
                    $alerts[] = $alerts_response[$p]['alert_id'];

                    // Set alert's type
                    $alert_types[$alerts_response[$p]['alert_type']] = $alerts_response[$p]['alert_type'];

                }

            }

            // Verify if alerts exists
            if ( $alerts ) {

                // Select data
                $this->db->select('notifications_alerts_fields.alert_id, notifications_alerts_fields.field_value as content, notifications_alerts.alert_type');

                // From notifications_alerts
                $this->db->from('notifications_alerts_fields');

                // Join tables
                $this->db->join('notifications_alerts', 'notifications_alerts_fields.alert_id=notifications_alerts.alert_id', 'left');
                $this->db->join('notifications_alerts_users', 'notifications_alerts_fields.alert_id=notifications_alerts_users.alert_id', 'left');

                // Set where
                $this->db->where(array(
                    'notifications_alerts_fields.field_name' => 'banner_content',
                    'notifications_alerts_fields.language' => $args['language']
                ));

                // Set where_in
                $this->db->where_in('notifications_alerts_fields.alert_id', $alerts);

                // Group by
                $this->db->group_by('notifications_alerts.alert_type');

                // Order by
                $this->db->order_by('notifications_alerts.alert_id', 'desc');

                // Set limit
                $this->db->limit(3, 0);

                // Get alerts
                $get_alerts = $this->db->get();
                
                // Verify if alerts exists
                if ( $get_alerts->num_rows() > 0 ) {

                    // Return response
                    return array(
                        'alerts' => $get_alerts->result_array()
                    );

                } else {

                    return false;

                }

            } else {

                return false;

            }
            
        } else {
            
            // Return false
            return false;
            
        }
        
    }
    
}

/* End of file notifications_alerts_model.php */