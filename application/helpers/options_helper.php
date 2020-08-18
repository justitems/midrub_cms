<?php
/**
 * Options helper
 *
 * This file contains the methods
 * for Admin's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('app_option_checkbox')) {
    
    /**
     * The function app_option_checkbox enables or disables admin's options
     * 
     * @return void
     */
    function app_option_checkbox() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Get the id's get input
        $option_name = $CI->input->get('id');
        
        // Enable or disable the $option_name option
        if ( $CI->options->enable_or_disable_network($option_name) ) {

            $data = array(
                'success' => TRUE,
                'message' => $CI->lang->line('mm2')
            );

            echo json_encode($data);

        } else {

            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line('mm3')
            );

            echo json_encode($data);

        }
        
    }
    
}

if (!function_exists('app_option_text')) {
    
    /**
     * The function app_option_text saves input's value
     * 
     * @return void
     */
    function app_option_text() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('id', 'ID', 'trim|required');
            $CI->form_validation->set_rules('value', 'Value', 'trim');

            // Get data
            $option_name = $CI->input->post('id');
            $option_value = $CI->input->post('value');

            // Check form validation
            if ($CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);

            } else {
                
                // Enable or disable the $option_name option
                if ( $CI->options->add_option_value( $option_name, $option_value ) ) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line('mm2')
                    );

                    echo json_encode($data);

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('mm3')
                    );

                    echo json_encode($data);

                }
                
            }
            
        }
        
    }
    
}