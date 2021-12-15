<?php
/**
 * Notifications Alert Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions used
 * in the alert's page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_users_alert_name') ) {

    /**
     * The function the_users_alert_name gets the users alert name
     * 
     * @return string with alert's name or boolean false
     */
    function the_users_alert_name() {

        // Get the alert's name
        $alert_name = md_the_data('notifications_users_alert_name');

        // Verify if alert's name exists
        if ( $alert_name ) {
            
            return $alert_name;

        } else {

            return false;

        }
        
    }

}

if ( !function_exists('the_users_alert_type') ) {

    /**
     * The function the_users_alert_type gets the users alert type
     * 
     * @since 0.0.8.3
     * 
     * @return string with alert's type or boolean false
     */
    function the_users_alert_type() {

        // Get the alert's type
        $alert_type = md_the_data('notifications_users_alert_type');

        // Verify if alert's type exists
        if ( is_numeric($alert_type) ) {
            
            return $alert_type;

        } else {

            return false;

        }
        
    }

}

if ( !function_exists('the_users_alerts_field') ) {

    /**
     * The function the_users_alerts_field gets the users alert field
     * 
     * @param string $field_name contains the field's name
     * @param string $field_extra contains the field's extra
     * @param string $language contains the field's language
     * 
     * @since 0.0.8.3
     * 
     * @return any with field's content or boolean false
     */
    function the_users_alerts_field($field_name, $field_extra=NULL, $language=NULL) {

        // Get the alert's fields
        $alert_fields = md_the_data('notifications_users_alert_fields');

        // Verify if field's name exists
        if ( isset($alert_fields[$field_name]) ) {

            // Verify if the language is required
            if ( $language ) {

                // Verify if the language exists
                if ( isset($alert_fields[$field_name][$language]) ) {

                    // Set key
                    $key = empty($field_extra)?'field_value':'field_extra';

                    // Return content
                    return $alert_fields[$field_name][$language][$key];

                }

            } else {

                // Set key
                $key = empty($field_extra)?'field_value':'field_extra';

                // Return content
                return $alert_fields[$field_name][$key];

            }

        }

        return false;
        
    }

}

if ( !function_exists('the_users_alerts_filters') ) {

    /**
     * The function the_users_alerts_filters gets the users alert filters
     * 
     * @param string $filter_name contains the filter's name
     * @param string $filter_extra contains the filter's extra
     * 
     * @since 0.0.8.3
     * 
     * @return any with filter's content or boolean false
     */
    function the_users_alerts_filters($filter_name, $filter_extra=NULL) {
    
        // Get the alert's filters
        $alert_filters = md_the_data('notifications_users_alert_filters')?array_column(md_the_data('notifications_users_alert_filters'), 'filter_value', 'filter_name'):array();

        // Verify if extra exists
        if ( $filter_extra ) {

            // Get the alert's filters
            $alert_filters = array_column(md_the_data('notifications_users_alert_filters'), 'filter_extra', 'filter_name');

        }

        // Verify if filter's name exists
        if ( isset($alert_filters[$filter_name]) ) {

            // Return content
            return $alert_filters[$filter_name];
    
        }
    
        return false;
        
    }
    
}

if ( !function_exists('the_system_errors_user') ) {

    /**
     * The function the_system_errors_user gets the user's data'
     * 
     * @param string $user_field contains the user's field
     * 
     * @return string with user's data or boolean false
     */
    function the_system_errors_user($user_field) {

        // Get the user
        $the_user = md_the_data('notifications_system_errors_user')?md_the_data('notifications_system_errors_user'):array();

        // Verify if user's field exists
        if ( isset($the_user[$user_field]) ) {

            // Return content
            return $the_user[$user_field];
    
        }
    
        return false;
        
    }

}

/* End of file notifications_alert.php */