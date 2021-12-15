<?php
/**
 * Plugins Init Inc
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
 * @since 0.0.8.4
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Plugins\Classes as CmsBaseAdminComponentsCollectionPluginsClasses;

if ( !function_exists('set_admin_plugins_page') ) {
    
    /**
     * The function set_admin_plugins_page registers plugins pages
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function set_admin_plugins_page($page_slug, $args) {
        
        // Call the admin_plugins_pages class
        $plugins_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_pages);

        // Set plugins page in the queue
        $plugins_pages->set_page($page_slug, $args);
        
    }
    
}

if ( !function_exists('set_admin_plugins_plugin_page') ) {
    
    /**
     * The function set_admin_plugins_plugin_page registers a page for a plugin
     * 
     * @param string $page_slug contains the page's slug
     * @param array $args contains the page's arguments
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function set_admin_plugins_plugin_page($page_slug, $args) {
        
        // Call the admin_plugins_plugin_pages class
        $plugins_plugin_pages = (new CmsBaseAdminComponentsCollectionPluginsClasses\Plugins_plugin_pages);

        // Set plugin's page in the queue
        $plugins_plugin_pages->set_page($page_slug, $args);
        
    }
    
}

/* End of file plugins_init.php */