<?php
/**
 * Ajax Controller
 *
 * This file processes the Members's ajax calls
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
namespace CmsBase\Admin\Components\Collection\Members\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Members General Inc file
require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/members_general.php';

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Members\Helpers as CmsBaseAdminComponentsCollectionMembersHelpers;

/*
 * Ajax class processes the Members component's ajax calls
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Ajax {
    
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

        // Load the component's language files
        $this->CI->lang->load( 'members', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_MEMBERS );

    }

    /**
     * The public method members_save_member saves members
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function members_save_member() {
        
        // Save member
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Members)->members_save_member();
        
    }

    /**
     * The public method members_get_members loads members
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function members_get_members() {
        
        // Get members
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Members)->members_get_members();
        
    }

    /**
     * The public method members_delete_member deletes a member
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function members_delete_member() {
        
        // Delete member
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Members)->members_delete_member();
        
    }

    /**
     * The public method members_delete_members deletes members
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function members_delete_members() {
        
        // Delete members
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Members)->members_delete_members();
        
    }

    /**
     * The public method members_get_countries gets the countries list
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function members_get_countries() {

        // Gets the countries
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Countries)->members_get_countries();
        
    } 

    /**
     * The public method members_get_plans gets the plans list
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function members_get_plans() {

        // Gets the plans
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Plans)->members_get_plans();
        
    } 

    /**
     * The public method load_payments_transactions loads payments transactions
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function load_payments_transactions() {
        
        // Get transactions
        (new CmsBaseAdminComponentsCollectionMembersHelpers\Transactions)->load_payments_transactions();
        
    }

}

/* End of file ajax.php */