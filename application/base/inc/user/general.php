<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used for user
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.3
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_delete_user') ) {
    
    /**
     * The function md_delete_user deletes a user
     * 
     * @param array $args contains the user's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    function md_delete_user( $args ) {

        // Get codeigniter object instance
        $CI = get_instance();

        // List all apps
        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $dir) {

            // Set App's dir
            $app_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Delete user's data
            (new $cl())->delete_account($args['user_id']);

        }

        // List all components
        foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $dir) {

            // Set Component's dir
            $component_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Components',
                'Collection',
                ucfirst($component_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Delete user's data
            (new $cl())->delete_account($args['user_id']);

        }

        // Call all hooks
        md_run_hook(
            'delete_user',
            array(
                'user_id' => $args['user_id']
            )
            
        );

        // Load Networks Model
        $CI->load->model('networks');
        
        // Delete connected social accounts
        $CI->networks->delete_network('all', $args['user_id']);
        
        // Load Fourth Helper
        $CI->load->helper('fourth_helper');
        
        // Load Tickets Model
        $CI->load->model('tickets');
        
        // Delete tickets
        $CI->tickets->delete_tickets($args['user_id']);

        // Load Referrals model
        $CI->load->model('referrals');

        // Delete referrals
        $CI->referrals->delete_referrals($args['user_id']);
        
        // Load Media Model
        $CI->load->model('media');
        
        // Get all user medias
        $getmedias = $CI->media->get_user_medias($args['user_id'], 0, 1000000);
      
        // Verify if user has media and delete them
        if ( $getmedias ) {
            
            // Load Media Helper
            $CI->load->helper('media_helper');
            
            foreach( $getmedias as $media ) {
                delete_media($media->media_id, false);
            }
            
        }
        
        // Load Team Model
        $CI->load->model('team');
        
        // Delete the user's team
        $CI->team->delete_members( $args['user_id'] );
        
        // Load Activities Model
        $CI->load->model('activities');
        
        // Delete the user's activities
        $CI->activities->delete_activity( $args['user_id'], 0 ); 
        
        // Delete user account
        if ( $CI->base_users->delete_user($args['user_id']) ) {

            return true; 
            
        } else {
            
            return false; 
            
        }
        
    }
    
}