<?php
/**
 * Midrub Components Plans
 *
 * This file loads the Plans Components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Plans;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_USER_COMPONENTS_PLANS') OR define('MIDRUB_BASE_USER_COMPONENTS_PLANS', APPPATH . 'base/user/components/collection/plans/');
defined('MIDRUB_BASE_USER_COMPONENTS_PLANS_VERSION') OR define('MIDRUB_BASE_USER_COMPONENTS_PLANS_VERSION', '0.1');

// Define the namespaces to use
use MidrubBase\User\Interfaces as MidrubBaseUserInterfaces;
use MidrubBase\User\Components\Collection\Plans\Controllers as MidrubBaseUserComponentsCollectionPlansControllers;

/*
 * Main class loads the Plans component loader
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

        if ( !get_option('component_plans_enable') || !team_role_permission('plans') ) {
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
        if ( !get_option('component_plans_enable') ) {
            show_404();
        }

        // Instantiate the class
        (new MidrubBaseUserComponentsCollectionPlansControllers\User)->view();
        
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
            (new MidrubBaseUserComponentsCollectionPlansControllers\Ajax)->$action();
            
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
                $this->CI->lang->load('plans_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_PLANS);

                // Require the Admin Inc
                md_include_component_file(MIDRUB_BASE_USER_COMPONENTS_PLANS . 'inc/admin.php');

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
        $this->CI->lang->load( 'plans_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_PLANS );
        
        // Return component's information
        return array(
            'component_name' => $this->CI->lang->line('plans'),
            'component_slug' => 'plans',
            'component_icon' => '<i class="fas fa-hand-holding-usd"></i>',
            'version' => MIDRUB_BASE_USER_COMPONENTS_PLANS_VERSION,
            'update_url' => 'https://update.midrub.com/plans/',
            'update_code' => TRUE,
            'update_code_url' => 'https://access-codes.midrub.com/',
            'min_version' => '0.0.7.9',
            'max_version' => '0.0.7.9',
        );
        
    }

}

/* End of file main.php */
