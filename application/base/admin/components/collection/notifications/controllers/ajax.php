<?php
/**
 * Ajax Controller
 *
 * This file processes the Notifications ajax calls
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
namespace CmsBase\Admin\Components\Collection\Notifications\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Notifications\Helpers as CmsBaseAdminComponentsCollectionNotificationsHelpers;

/*
 * Ajax class processes the Notifications ajax calls
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
        $this->CI->lang->load( 'notifications', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );

    }

    /**
     * The public method create_email_template saves an email's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function create_email_template() {
        
        // Create email's template
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Emails)->create_email_template();
        
    }    

    /**
     * The public method update_email_template updates an email's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function update_email_template() {
        
        // Update email's template
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Emails)->update_email_template();
        
    }   

    /**
     * The public method get_email_template_placeholder loads the email template's placeholders
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_email_template_placeholder() {
        
        // Get placeholders
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Emails)->get_email_template_placeholder();
        
    }

    /**
     * The public method email_templates_load_all loads the email templates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function email_templates_load_all() {
        
        // Get email templates
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Emails)->email_templates_load_all();
        
    }

    /**
     * The public method notifications_load_all_plans loads plans by page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_all_plans() {
        
        // Get plans
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Plans)->notifications_load_all_plans();
        
    }

    /**
     * The public method notifications_load_selected_plans loads all selected plans
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_selected_plans() {
        
        // Get selected plans
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Plans)->notifications_load_selected_plans();
        
    }

    /**
     * The public method notifications_load_users_alert_plans gets users alert's plans
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_users_alert_plans() {
        
        // Get alert's plans
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Plans)->notifications_load_users_alert_plans();
        
    }

    /**
     * The public method notifications_create_users_alert creates a users alert
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_create_users_alert() {
        
        // Save alert
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Users_alerts)->notifications_create_users_alert();
        
    }

    /**
     * The public method notifications_load_users_alerts loads users alerts
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_users_alerts() {
        
        // Loads alerts
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Users_alerts)->notifications_load_users_alerts();
        
    }

    /**
     * The public method notifications_delete_users_alert deletes a users alert
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_delete_users_alert() {
        
        // Delete alert
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Users_alerts)->notifications_delete_users_alert();
        
    }

    /**
     * The public method notifications_delete_users_alerts deletes multiple users alerts
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_delete_users_alerts() {
        
        // Delete alerts
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Users_alerts)->notifications_delete_users_alerts();
        
    }

    /**
     * The public method notifications_load_all_alert_users loads alert's users by page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function notifications_load_all_alert_users() {
        
        // Load users
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\Users)->notifications_load_all_alert_users();
        
    }

    /**
     * The public method notifications_load_system_errors loads system errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_load_system_errors() {
        
        // Loads system errors
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\System_errors)->notifications_load_system_errors();
        
    }

    /**
     * The public method notifications_load_system_errors_users loads users which have errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_load_system_errors_users() {
        
        // Loads users
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\System_errors)->notifications_load_system_errors_users();
        
    }    

    /**
     * The public method notifications_load_system_errors_types loads system errors types
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_load_system_errors_types() {
        
        // Loads system errors types
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\System_errors)->notifications_load_system_errors_types();
        
    }

    /**
     * The public method notifications_delete_system_error deletes a system error
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_delete_system_error() {
        
        // Delete system error
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\System_errors)->notifications_delete_system_error();
        
    }    

    /**
     * The public method notifications_delete_system_errors deletes bulk system errors
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_delete_system_errors() {
        
        // Delete system errors
        (new CmsBaseAdminComponentsCollectionNotificationsHelpers\System_errors)->notifications_delete_system_errors();
        
    }

}

/* End of file ajax.php */