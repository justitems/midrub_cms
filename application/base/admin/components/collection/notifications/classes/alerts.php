<?php
/**
 * Alerts Class
 *
 * This file loads the Alerts Class with methods to manage the alerts
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
namespace CmsBase\Admin\Components\Collection\Notifications\Classes;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Alerts class loads the methods to manage the alerts
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Alerts {

    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Notifications Users Alerts Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_alerts_model', 'notifications_alerts_model' );
        
        // Load the alerts language file
        $this->CI->lang->load( 'notifications_alerts', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );
        
    }

    /**
     * The public method save_alert saves a new alert
     * 
     * @param array $args contains the alert's parameters
     * 
     * @since 0.0.8.3
     * 
     * @return array with response
     */
    public function save_alert($args) {

        // Verify if the alert has the expected parameters
        if ( empty($args['alert_name']) || !isset($args['alert_type']) || !isset($args['alert_audience']) || !isset($args['alert_fields']) ) {

            // Return the error
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_missing_some_alert_parameters')
            );

        }

        // Verify if the alert's parameters have correct value
        if ( ($args['alert_type'] < 0) || ($args['alert_type'] > 3) || !is_numeric($args['alert_type']) || ($args['alert_audience'] < 0) || ($args['alert_audience'] > 2) || !is_numeric($args['alert_audience']) || !is_array($args['alert_fields']) ) {

            // Return the error
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_wrong_value_some_alert_parameters')
            );

        }
        
        // Verify if the alert's fields have correct value
        if ( empty($args['alert_fields']) ) {

            // Return the error
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_wrong_value_some_alert_fields')
            );

        }

        // Verify if the alert's parameters have correct value
        if ( !isset($args['alert_fields'][0]['field_name']) || !isset($args['alert_fields'][0]['field_value']) ) {

            // Return the error
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_wrong_value_some_alert_fields')
            );

        }

        // Verify if the alert's parameters have correct value
        if ( !isset($args['alert_fields'][0]['language']) ) {

            // Return the error
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_alert_fields_without_language')
            );

        }

        // Check for errors by type
        if ( $args['alert_type'] === '0' ) {

            // Banner count
            $banner_count = 0;

            // Page count
            $page_count = 0;

            // List the alert's fields
            foreach ( $args['alert_fields'] as $field ) {

                // Verify if is the banner content field
                if ( $field['field_name'] === 'banner_content' ) {

                    // Verify if banner is empty
                    if ( !empty($field['field_value']) ) {
                        $banner_count++;
                    }

                }

                // Verify if is the banner enabled field
                if ( $field['field_name'] === 'banner_enabled' ) {

                    // Verify if banner is enabled
                    if ( !empty($field['field_value']) ) {
                        $banner_count++;
                    }

                }

                // Verify if is the page title field
                if ( $field['field_name'] === 'page_title' ) {

                    // Verify if page title is empty
                    if ( !empty($field['field_value']) ) {
                        $page_count++;
                    }

                }

                // Verify if is the page content field
                if ( $field['field_name'] === 'page_content' ) {

                    // Verify if page content is empty
                    if ( !empty($field['field_value']) ) {
                        $page_count++;
                    }

                }

                // Verify if is the page enabled field
                if ( $field['field_name'] === 'page_enabled' ) {

                    // Verify if page is enabled
                    if ( !empty($field['field_value']) ) {
                        $page_count++;
                    }

                }                

            }

            // Verify if at least the banner or page content exists
            if ( ($banner_count < 2) && ($page_count < 3) ) {

                // Return the error
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_alert_can_not_be_saved_wrong_parameters')
                );

            }

        } else if ( $args['alert_type'] === '1' ) {

            // Banner count
            $banner_count = 0;

            // List the alert's fields
            foreach ( $args['alert_fields'] as $field ) {

                // Verify if is the banner content field
                if ( $field['field_name'] === 'banner_content' ) {

                    // Verify if banner is empty
                    if ( !empty($field['field_value']) ) {
                        $banner_count++;
                    }

                }      

            }

            // Verify if at least the banner or page content exists
            if ( $banner_count < 1 ) {

                // Return the error
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_alert_type_requires_banner')
                );

            }

        } else {

            // Banner count
            $banner_count = 0;

            // Page count
            $page_count = 0;

            // List the alert's fields
            foreach ( $args['alert_fields'] as $field ) {

                // Verify if is the banner content field
                if ( $field['field_name'] === 'banner_content' ) {

                    // Verify if banner is empty
                    if ( !empty($field['field_value']) ) {
                        $banner_count++;
                    }

                }               

            }

            // Verify if at least the banner exists
            if ( $banner_count < 1 ) {

                // Return the error
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_alert_type_requires_banner')
                );

            }

        }

        // Create the alert's parameters
        $alert_args = array(
            'alert_name' => $args['alert_name'],
            'alert_type' => $args['alert_type'],
            'alert_audience' => $args['alert_audience'],
            'created' => time()
        );

        // Save the alert
        $alert_id = $this->CI->base_model->insert('notifications_alerts', $alert_args);

        // Verify if the alert was saved
        if ( $alert_id ) {

            // Fields counter
            $fields_count = 0; 
        
            // List all alert fields
            foreach ( $args['alert_fields'] as $field ) {

                // Set extra
                $field_extra = isset($field['field_extra'])?$field['field_extra']:'';

                // Set language
                $language = isset($field['language'])?$field['language']:'';
                
                // Try to save the field
                if ( $this->save_alerts_field($alert_id, $field['field_name'], $field['field_value'], $field_extra, $language ) ) {
                    $fields_count++;
                }    

            }

            // Verify if the alert has filters
            if ( !empty($args['alert_filters']) ) {

                // List all alert filters
                foreach ( $args['alert_filters'] as $filter ) {

                    // Set extra
                    $filter_extra = isset($filter['filter_extra'])?$filter['filter_extra']:'';
                    
                    // Try to save the filter
                    $this->save_alerts_filter($alert_id, $filter['filter_name'], $filter['filter_value'], $filter_extra);   

                }

            }

            // Verify if the alert has users
            if ( !empty($args['alert_users']) ) {

                // List all alert's users'
                foreach ( $args['alert_users'] as $user ) {

                    // Verify if user's id is numeric
                    if ( is_numeric($user['user_id']) ) {
                    
                        // Try to save the alert's user
                        $this->save_alerts_user($alert_id, $user['user_id']); 
                        
                    }

                }

            }

            // Verify if all fields were saved
            if ( $fields_count === count($args['alert_fields']) ) {

                // Return the success
                return array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('notifications_alert_was_saved')
                );

            } 

        }

        // Return the error
        return array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_alert_was_not_saved')
        );

    }

    /**
     * The protected method save_alerts_field saves an alert's field
     * 
     * @param integer $alert_id contains the alert's identifier
     * @param string $name contains the field's name
     * @param string $value contains the field's value
     * @param string $extra contains the field's extra
     * @param string $language contains the field's language
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    protected function save_alerts_field($alert_id, $name, $value, $extra=NULL, $language=NULL) {

        // Prepare the field
        $field_args = array(
            'alert_id' => $alert_id,
            'field_name' => $name,
            'field_value' => $value
        );

        // Verify if extra exists
        if ( $extra !== NULL ) {

            // Set the field's extra
            $field_args['field_extra'] = $extra;

        }

        // Verify if language exists
        if ( $language !== NULL ) {

            // Set the field's language
            $field_args['language'] = $language;

        }  

        // Save the message's field
        if ( $this->CI->base_model->insert('notifications_alerts_fields', $field_args) ) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * The protected method save_alerts_filter saves an alert's filter
     * 
     * @param integer $alert_id contains the alert's identifier
     * @param string $name contains the filter's name
     * @param string $value contains the filter's value
     * @param string $extra contains the filter's extra
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    protected function save_alerts_filter($alert_id, $name, $value, $extra=NULL) {

        // Prepare the filter
        $filter_args = array(
            'alert_id' => $alert_id,
            'filter_name' => $name,
            'filter_value' => $value
        );

        // Verify if extra exists
        if ( $extra !== NULL ) {

            // Set the filter's extra
            $filter_args['filter_extra'] = $extra;

        } 

        // Save the message's filter
        if ( $this->CI->base_model->insert('notifications_alerts_filters', $filter_args) ) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * The protected method save_alerts_user saves an alert's user
     * 
     * @param integer $alert_id contains the alert's identifier
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.8.4
     * 
     * @return boolean true or false
     */
    protected function save_alerts_user($alert_id, $user_id) {

        // Create user's activity for alert
        $user_activity = array(
            'alert_id' => $alert_id,
            'user_id' => $user_id,
            'page_seen' => 0,
            'deleted' => 0,
            'updated' => time(),
            'created' => time()
        );

        // Save the alert's user
        if ( $this->CI->base_model->insert('notifications_alerts_users', $user_activity) ) {
            return true;
        } else {
            return false;
        }
        
    }

}

/* End of file alerts.php */