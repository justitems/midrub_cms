<?php
/**
 * General Theme Ajax
 *
 * This file contains the main theme's ajax functions
 * used in the theme
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load Notifications Alerts Model
get_instance()->load->ext_model( APPPATH . 'base/user/themes/collection/crm/core/models/', 'Notifications_alerts_model', 'notifications_alerts_model' );

if ( !function_exists('theme_get_alerts') ) {

    /**
     * The function theme_get_alerts gets the alerts
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function theme_get_alerts() {

        // Get the string
        $CI =& get_instance();

        // Verify if is not a team member
        if ( !$CI->session->userdata( 'member' ) ) {

            // Set where parameters
            $where = array(
                'user_id' => md_the_user_id(),
                'plan' => md_the_user_option(md_the_user_id(), 'plan'),
                'language' => $CI->config->item('language')
            );

            // Get alerts alerts
            $alerts = $CI->notifications_alerts_model->the_alerts($where);

            // Verify if alerts alerts exists
            if ( $alerts ) {

                // User's alerts
                $user_alerts = array();

                // List found alerts
                foreach ( $alerts['alerts'] as $alert ) {

                    // Set alert
                    $user_alerts[] = array(
                        'alert_id' => $alert['alert_id'],
                        'alert_type' => $alert['alert_type'],
                        'content' => html_entity_decode($alert['content'])
                    );

                }
                
                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'alerts' => $user_alerts
                );

                // Display the succes response
                echo json_encode($data);
                exit();
                
            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE
        );

        // Display the error response
        echo json_encode($data);

    }

}

if ( !function_exists('theme_hide_alert') ) {

    /**
     * The function theme_hide_alert hides an alert
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function theme_hide_alert() {

        // Get the string
        $CI =& get_instance();
        
        // Get alert's input
        $alert = $CI->input->get('alert', TRUE);  

        // Verify if the alert is numeric
        if ( is_numeric($alert) ) {

            // Get the alert
            $alert_data = $CI->base_model->the_data_where(
                'notifications_alerts',
                'alert_type',
                array(
                    'alert_id' => $alert
                )
            );

            // Verify if the alert exists
            if ( !$alert_data ) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE
                );

                // Display the error response
                echo json_encode($data);
                exit();
                
            }

            // If alert type is 2 it can't be deleted
            if ( $alert_data[0]['alert_type'] === '2' ) {

                // Prepare the error response
                $data = array(
                    'success' => FALSE
                );

                // Display the error response
                echo json_encode($data);
                exit();

            }
            
            // Get the alert
            $alert_user = $CI->base_model->the_data_where(
                'notifications_alerts_users',
                'alert_id',
                array(
                    'alert_id' => $alert,
                    'user_id' => md_the_user_id()
                )
            );

            // Verify if the alert exists
            if ( $alert_user ) {

                // Try to change the alert's status
                if ( $CI->base_model->update('notifications_alerts_users', array('alert_id' => $alert), array('banner_seen' => 1)) ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE
                    );
        
                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            } else {

                // Create user's activity for alert
                $user_activity = array(
                    'alert_id' => $alert,
                    'user_id' => md_the_user_id(),
                    'banner_seen' => 1,
                    'page_seen' => 0,
                    'deleted' => 0,
                    'updated' => time(),
                    'created' => time()
                );

                // Save the user's activity by using the Base's Model
                if ( $CI->base_model->insert('notifications_alerts_users', $user_activity) ) {

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE
                    );
        
                    // Display the success response
                    echo json_encode($data);
                    exit();
                    
                }

            }

        }

        // Prepare the error response
        $data = array(
            'success' => FALSE
        );

        // Display the error response
        echo json_encode($data);
        
    }

}

if ( !function_exists('theme_get_error_alerts') ) {

    /**
     * The functions theme_get_error_alerts gets the error alerts
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function theme_get_error_alerts() {

        // Get the string
        $CI =& get_instance();

        // Set where parameters
        $where = array(
            'user_id' => md_the_user_id(),
            'plan' => md_the_user_option(md_the_user_id(), 'plan'),
            'language' => $CI->config->item('language')
        );

        // Get alerts alerts
        $alerts = $CI->notifications_alerts_model->the_error_alerts($where);

        // Verify if alerts alerts exists
        if ( $alerts ) {

            // User's alerts
            $user_alerts = array();

            // List found alerts
            foreach ( $alerts['alerts'] as $alert ) {

                // Set alert
                $user_alerts[] = array(
                    'alert_id' => $alert['alert_id'],
                    'alert_type' => $alert['alert_type'],
                    'content' => html_entity_decode($alert['content'])
                );

            }
            
            // Prepare the success response
            $data = array(
                'success' => TRUE,
                'alerts' => $user_alerts
            );

            // Display the succes response
            echo json_encode($data);
            exit();
            
        }

        // Prepare the error response
        $data = array(
            'success' => FALSE
        );

        // Display the error response
        echo json_encode($data);

    }


}

/* End of file main.php */