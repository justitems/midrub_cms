<?php
/**
 * Ajax Controller
 *
 * This file processes the Plugins's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Plugins\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Plugins\Helpers as CmsBaseAdminComponentsCollectionPluginsHelpers;

/*
 * Ajax class processes the Plugins component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'plugins', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PLUGINS);

    }

    /**
     * The public method plugins_enable_plugin enables a plugin
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function plugins_enable_plugin() {

        // Enables Plugin
        (new CmsBaseAdminComponentsCollectionPluginsHelpers\Plugins)->plugins_enable_plugin();
        
    }

    /**
     * The public method plugins_disable_plugin disables a plugin
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function plugins_disable_plugin() {

        // Disables Plugin
        (new CmsBaseAdminComponentsCollectionPluginsHelpers\Plugins)->plugins_disable_plugin();
        
    }
    
    /**
     * The public method plugins_upload_plugin uploads an plugin to be installed
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function plugins_upload_plugin() {

        // Uploads Plugin
        (new CmsBaseAdminComponentsCollectionPluginsHelpers\Plugins)->plugins_upload_plugin();
        
    }

    /**
     * The public method plugins_unzipping_zip extract the plugin from the zip
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function plugins_unzipping_zip() {
        
        // Extract the Plugin
        (new CmsBaseAdminComponentsCollectionPluginsHelpers\Plugins)->plugins_unzipping_zip();
        
    }

}

/* End of file ajax.php */