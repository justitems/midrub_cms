<?php
/**
 * Midrub Components Team
 *
 * This file loads the Team Components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Team;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_USER_COMPONENTS_TEAM') OR define('MIDRUB_BASE_USER_COMPONENTS_TEAM', APPPATH . 'base/user/components/collection/team/');
defined('MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION') OR define('MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION', '0.2');

// Define the namespaces to use
use MidrubBase\User\Interfaces as MidrubBaseUserInterfaces;
use MidrubBase\User\Components\Collection\Team\Controllers as MidrubBaseUserComponentsCollectionTeamControllers;

/*
 * Main class loads the Team component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Main implements MidrubBaseUserInterfaces\Components {
   
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }

    /**
     * The public method check_availability checks if the component is available
     *
     * @return boolean true or false
     */
    public function check_availability() {

        if ( !get_option('component_team_enable') || !team_role_permission('team') ) {
            return false;
        } else {
            return true;
        }
        
    }
    
    /**
     * The public method user loads the component's main page in the user panel
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function user() {


        // Verify if the component is enabled
        if ( !get_option('component_team_enable') ) {
            show_404();
        }

        // Instantiate the class
        (new MidrubBaseUserComponentsCollectionTeamControllers\User)->view();
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function ajax() {
        
        // Get action's get input
        $action = $this->CI->input->get('action', TRUE);

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {
            
            // Call method if exists
            (new MidrubBaseUserComponentsCollectionTeamControllers\Ajax)->$action();
            
        } catch (Exception $ex) {
            
            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );
            
            echo json_encode($data);
            
        }

    }

    /**
     * The public method rest processes the rest's requests
     * 
     * @param string $endpoint contains the requested endpoint
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function rest($endpoint) {

    }
    
    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function cron_jobs() {
        
    }
    
    /**
     * The public method delete_account is called when user's account is deleted
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function delete_account($user_id) {

        // Deletes the user's team
        (new MidrubBaseUserComponentsCollectionTeamHelpers\User)->delete_user($user_id);
        
    }
    
    /**
     * The public method hooks contains the component's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_hooks( $category ) {

        // Load and run hooks based on category
        switch ($category) {

            case 'admin_init':

                // Load the component's language files
                $this->CI->lang->load('team_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_TEAM);

                // Verify which component is
                if ( ( $this->CI->input->get('component', true) === 'team') && (md_the_component_variable('component_display') === 'components' ) ) {

                    // Require the Admin Inc
                    md_include_component_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'inc/admin.php');
                }

                break;

            case 'user_init':

                // Verify which component is
                if ( md_the_component_variable('component') === 'team' ) {

                    if ( get_option('component_team_enable') ) {

                        // Load the component's language files
                        $this->CI->lang->load('team_member', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_TEAM);

                        // Require the Permissions Inc
                        md_include_component_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'inc/members.php');

                    }

                }

                break;

        }

    }
    
    /**
     * The public method component_info contains the component's info
     * 
     * @since 0.0.7.9
     * 
     * @return array with component's information
     */
    public function component_info() {

        // Load the component's language files
        $this->CI->lang->load( 'team_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_TEAM );
        
        // Return component's information
        return array(
            'component_name' => $this->CI->lang->line('team'),
            'component_slug' => 'team',
            'component_icon' => '<i class="icon-people"></i>',
            'version' => MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION,
            'update_url' => 'https://update.midrub.com/team/',
            'update_code' => TRUE,
            'update_code_url' => 'https://access-codes.midrub.com/',
            'min_version' => '0.0.7.9',
            'max_version' => '0.0.7.9',
        );
        
    }

}

/* End of file main.php */
