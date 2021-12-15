<?php
/**
 * Dashboard Events Functions Inc Parts
 *
 * This file contains the some functions which
 * should be called only when them are used
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_delete_admin_dashboard_event_from_parts') ) {
    
    /**
     * The function md_delete_admin_dashboard_event_from_parts deletes an event
     * 
     * @param integer $event_id contains the event's ID
     * 
     * @return boolean true or false
     */
    function md_delete_admin_dashboard_event_from_parts($event_id) {

        // Delete the event
        if ( $CI->base_model->delete('crm_events', array('event_id' => $event_id) ) ) {

            // Delete the event's meta
            $CI->base_model->delete('crm_events_meta', array('event_id' => $event_id) );

            return true;

        } else {

            return false;

        }

    }

}

if (!function_exists('md_create_admin_dashboard_event_from_parts')) {
    
    /**
     * The function md_create_admin_dashboard_event_from_parts creates admin dashboard's event
     * 
     * @param array $args contains the event's parameters
     * 
     * @return array with response
     */
    function md_create_admin_dashboard_event_from_parts($args) {

        // Get CodeIgniter object instance
        $CI =& get_instance();

        // Verify if $args contains the required keys
        if ( isset($args['event_type']) && !empty($args['metas']) ) {

            // Prepare the event
            $event_args = array(
                'event_type' => $args['event_type'],
                'created' => time()
            );

            // Save the event by using the Base's Model
            $event_id = $CI->base_model->insert('dashboard_events', $event_args);

            // Verify if $event_id was saved
            if ( !$event_id ) {

                // Return error message
                return array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('dashboard_the_event_was_not_saved')
                );

            }

            // List metas
            foreach ( $args['metas'] as $meta ) {

                // Verify if meta has required parameters
                if ( isset($meta['meta_name']) && isset($meta['meta_value']) ) {

                    // Prepare the event
                    $meta_args = array(
                        'event_id' => $event_id,
                        'meta_name' => $meta['meta_name'],
                        'meta_value' => $meta['meta_value']
                    );

                    // Verify if meta's extra exists
                    if ( !empty($meta['meta_extra']) ) {

                        // Set meta_extra
                        $meta_args['meta_extra'] = $meta['meta_extra'];

                    }

                    // Save the event's meta by using the Base's Model
                    $meta_id = $CI->base_model->insert('dashboard_events_meta', $meta_args);

                    // Verify if meta_id exists
                    if ( !$meta_id ) {
                        
                        // Delete the event
                        md_delete_admin_dashboard_event_from_parts($event_id);

                        // Return error message
                        return array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('dashboard_a_event_meta_not_saved')
                        );
                        
                    }

                } else {

                    // Delete the event
                    md_delete_admin_dashboard_event_from_parts($event_id);

                    // Return error message
                    return array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('dashboard_no_valid_event_meta')
                    );
                    
                }

            }

            // Return success message
            return array(
                'success' => TRUE,
                'event_id' => $event_id
            );

        } else {

            // Return error message
            return array(
                'success' => FALSE,
                'message' => $CI->lang->line('dashboard_the_event_wrong_parameters')
            );

        }

    }

}

/* End of file dashboard_events.php */