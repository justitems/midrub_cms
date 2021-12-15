<?php
/**
 * Plugins Init Hooks Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions which
 * are runned when the Plugins component loads
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Plugins\Classes as CmsBaseAdminComponentsCollectionPluginsClasses;

if ( !function_exists('the_admin_plugins_pages') ) {
    
    /**
     * The function the_admin_plugins_pages gets the plugins pages
     * 
     * @since 0.0.8.4
     * 
     * @return array with plugins pages or boolean false
     */
    function the_admin_plugins_pages() {
        
        // Call the admin_plugins_pages class
        $plugins_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_pages);

        // Return plugins pages
        return $plugins_pages->the_pages();
        
    }
    
}

if ( !function_exists('get_the_admin_plugins_page_content') ) {
    
    /**
     * The function get_the_admin_plugins_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function get_the_admin_plugins_page_content($page) {

        // Call the admin_plugins_pages class
        $plugins_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_pages);

        // List all pages
        foreach ( $plugins_pages::$the_pages as $the_admin_plugins_page ) {

            if ( isset($the_admin_plugins_page[$page]['content']) ) {

                if ( $the_admin_plugins_page[$page]['content'] ) {

                    if ( function_exists($the_admin_plugins_page[$page]['content']) ) {
                        $the_admin_plugins_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}

if ( !function_exists('the_admin_plugins_plugin_pages') ) {
    
    /**
     * The function the_admin_plugins_plugin_pages gets the plugins pages
     * 
     * @since 0.0.8.4
     * 
     * @return array with plugins pages or boolean false
     */
    function the_admin_plugins_plugin_pages() {
        
        // Call the admin_plugins_plugin_pages class
        $plugins_plugin_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_plugin_pages);

        // Return plugins pages
        return $plugins_plugin_pages->the_pages();
        
    }
    
}

if ( !function_exists('get_the_admin_plugins_plugin_page_content') ) {
    
    /**
     * The function get_the_admin_plugins_plugin_page_content displays the page content
     * 
     * @param string $page contains the page to load
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function get_the_admin_plugins_plugin_page_content($page) {

        // Call the admin_plugins_plugin_pages class
        $plugins_plugin_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_plugin_pages);

        // List all pages
        foreach ( $plugins_plugin_pages::$the_pages as $the_admin_plugins_plugin_page ) {

            if ( isset($the_admin_plugins_plugin_page[$page]['content']) ) {

                if ( $the_admin_plugins_plugin_page[$page]['content'] ) {

                    if ( function_exists($the_admin_plugins_plugin_page[$page]['content']) ) {
                        $the_admin_plugins_plugin_page[$page]['content']();
                    }

                }
                
            }

        }
        
    }
    
}

/* End of file plugins_init_hooks.php */