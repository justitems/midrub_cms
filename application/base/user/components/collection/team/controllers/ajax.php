<?php
/**
 * Ajax Controller
 *
 * This file processes the component's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Team\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Team\Helpers as MidrubBaseUserComponentsCollectionTeamHelpers;

// Require the Team Inc
md_include_component_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'inc/team.php');

/*
 * Ajax class processes the app's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'team_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_TEAM );
        
    }

    /**
     * The public method team_new_member creates a new member
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_new_member() {
        
        // Create a new Team's member
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->team_new_member();
        
    } 

    /**
     * The public method team_update_member updates member's info
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_update_member() {
        
        // Update a Team's member
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->team_update_member();
        
    }

    /**
     * The public method team_all_members returns all team's members
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_all_members() {
        
        // Loads the team's members
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->team_all_members();
        
    }

    /**
     * The public method team_member_info returns the member's info
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_member_info() {
        
        // Get member's info
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->team_member_info();
        
    }

    /**
     * The public method team_member_delete deletes a team's member
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_member_delete() {
        
        // Delete a team member
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->team_member_delete();
        
    }

    /**
     * The public method members_action_execute executes actions for members
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function members_action_execute() {
        
        // Send data
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Team)->members_action_execute();
        
    }
    
    /**
     * The public method team_create_role create a team's role
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_create_role() {
        
        // Create a team's role
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->team_create_role();
        
    }   
    
    /**
     * The public method team_create_role loads all roles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_all_roles() {
        
        // Loads roles
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->team_all_roles();
        
    }   

    /**
     * The public method team_total_roles loads total roles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_total_roles() {
        
        // Loads roles
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->team_total_roles();
        
    }
    
    /**
     * The public method team_get_permissions get role's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function team_get_permissions() {
        
        // Loads role's permissions
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->team_get_permissions();
        
    }

    /**
     * The public method save_role_permission saves role's permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function save_role_permission() {
        
        // Saves role's permissions
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->save_role_permission();
        
    }

    /**
     * The public method roles_action_execute executes actions for roles
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function roles_action_execute() {
        
        // Send data
        (new MidrubBaseUserComponentsCollectionTeamHelpers\Roles)->roles_action_execute();
        
    }
    
}
