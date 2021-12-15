<?php
/**
 * Midrub Base Plugins
 *
 * This file loads the Midrub's Plugins Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Plugins;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_PLUGINS') OR define('CMS_BASE_PLUGINS', APPPATH . 'base/plugins/');
defined('CMS_BASE_PLUGINS_VERSION') OR define('CMS_BASE_PLUGINS_VERSION', '0.1');

/*
 * Main is the plugins's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */
class Main {

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

    }
    
    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @since 0.0.8.4
     * 
     * @param string $plugin contains the plugin's name
     * 
     * @return void
     */
    public function ajax_init($plugin) {

        // Verify if plugin exists
        if ( file_exists(CMS_BASE_PLUGINS . 'collection/' . $plugin . '/main.php') ) {

            // Create an array
            $array = array(
                'CmsBase',
                'Plugins',
                'Collection',
                ucfirst($plugin),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            if ( is_dir(CMS_BASE_PLUGINS . 'collection/' . $plugin . '/') ) {

                // Instantiate the plugin's view
                (new $cl())->ajax();

            } else {

                // Display 404 page
                show_404();
                
            }

        } else {

            // Display 404 page
            show_404();            

        }
        
    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.8.4
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // List all plugins's components
        foreach (glob(APPPATH . 'base/plugins/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $plugin = trim(basename($directory) . PHP_EOL);

            // Create an array
            $array = array(
                'CmsBase',
                'Plugins',
                'Collection',
                ucfirst($plugin),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Register hooks
            (new $cl())->load_hooks($category);

        }

    }
    
}

/* End of file main.php */