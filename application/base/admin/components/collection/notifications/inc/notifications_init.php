<?php
/**
 * Notifications Init Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions which
 * are runned when the pages loads
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Notifications\Classes as CmsBaseAdminComponentsCollectionNotificationsClasses;

if ( !function_exists('set_admin_notifications_page') ) {
    
    /**
     * The function set_admin_notifications_page adds notifications pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_admin_notifications_page($page_slug, $args) {
        
        // Call the admin_notifications_pages class
        $notifications_pages = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Notifications_pages);

        // Set notifications page in the queue
        $notifications_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('set_admin_notifications_email_template') ) {
    
    /**
     * The function set_admin_notifications_email_template registers a new email template
     * 
     * @param string $template_slug contains the template's slug
     * @param array $args contains the template's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_admin_notifications_email_template($template_slug, $args) {
        
        // Call the email_templates class
        $email_templates = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Email_templates);

        // Set email templates in the queue
        $email_templates->set_template($template_slug, $args);
        
    }
    
}

if ( !function_exists('the_admin_notifications_email_template') ) {
    
    /**
     * The function the_admin_notifications_email_template gets the email's template
     * 
     * @param string $template_slug contains the template slug
     * @param string $language contains the language
     * 
     * @since 0.0.8.3
     * 
     * @return array with email template or boolean false
     */
    function the_admin_notifications_email_template($template_slug, $language=NULL) {
        
        // Call the email_templates class
        $email_templates = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Email_templates);

        // Gets and return the email templates
        return $email_templates->the_email_template($template_slug, $language);
        
    }
    
}

if ( !function_exists('md_save_admin_notifications_alert') ) {
    
    /**
     * The function md_save_admin_notifications_alert saves a notification's alert
     * 
     * @param array $args contains the alert's parameters
     * 
     * @since 0.0.8.3
     * 
     * @return integer with alert's id or boolean false
     */
    function md_save_admin_notifications_alert($args) {
        
        // Call the alerts class
        $alerts = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Alerts);

        // Save alert
        return $alerts->save_alert($args);
        
    }
    
}

/* End of file notifications_init.php */