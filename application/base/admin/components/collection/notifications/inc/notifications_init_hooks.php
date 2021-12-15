<?php
/**
 * Notifications Init Hooks Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions which
 * are runned when the Notifications component loads
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

if ( !function_exists('the_admin_notifications_pages') ) {
    
    /**
     * The function the_admin_notifications_pages gets the notifications pages
     * 
     * @since 0.0.8.3
     * 
     * @return array with notifications pages or boolean false
     */
    function the_admin_notifications_pages() {
        
        // Call the admin_notifications_pages class
        $notifications_pages = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Notifications_pages);

        // Return notifications pages
        return $notifications_pages->load_pages();
        
    }
    
}

if ( !function_exists('get_the_admin_notifications_page_content') ) {
    
    /**
     * The function get_the_admin_notifications_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function get_the_admin_notifications_page_content($page) {

        // Call the admin_notifications_pages class
        $notifications_pages = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Notifications_pages);

        // List all pages
        foreach ( $notifications_pages::$the_pages as $the_admin_notifications_page ) {

            if ( isset($the_admin_notifications_page[$page]['content']) ) {

                if ( $the_admin_notifications_page[$page]['content'] ) {

                    if ( function_exists($the_admin_notifications_page[$page]['content']) ) {
                        $the_admin_notifications_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}

if ( !function_exists('the_admin_notifications_email_templates') ) {
    
    /**
     * The function the_admin_notifications_email_templates gets the email's templates
     * 
     * @since 0.0.8.3
     * 
     * @return array with email templates or boolean false
     */
    function the_admin_notifications_email_templates() {
        
        // Call the email_templates class
        $email_templates = (new CmsBaseAdminComponentsCollectionNotificationsClasses\Email_templates);

        // Gets and return the email templates
        return $email_templates->load_templates();
        
    }
    
}

/* End of file notifications_init_hooks.php */