<?php
/**
 * Admin Plugins Inc
 *
 * This file contains the functions
 * used in the plugins component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.4
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_plugins_list') ) {
    
    /**
     * The function the_plugins_list returns the plugins list
     * 
     * @since 0.0.8.4
     * 
     * @return array with plugins list
     */
    function the_plugins_list() {

        // All plugins container
        $all_plugins = array();

        // Verify if the plugins dir exists
        if ( !is_dir(APPPATH . 'base/plugins/') ) {
            mkdir(APPPATH . 'base/plugins/', 0777);
        }

        // Verify if the plugins collection dir exists
        if ( !is_dir(APPPATH . 'base/plugins/collection/') ) {
            mkdir(APPPATH . 'base/plugins/collection/', 0777);
        }

        // Verify if the assets plugins dir exists
        if ( !is_dir(FCPATH . 'assets/base/plugins/') ) {
            mkdir(FCPATH . 'assets/base/plugins/', 0777);
        }

        // Verify if the assets plugins collection dir exists
        if ( !is_dir(FCPATH . 'assets/base/plugins/collection/') ) {
            mkdir(FCPATH . 'assets/base/plugins/collection/', 0777);
        }        

        // List all plugins
        foreach (glob(APPPATH . 'base/plugins/collection/*', GLOB_ONLYDIR) as $dir) {

            // Verify if the Main file exists
            if ( !file_exists(APPPATH . 'base/plugins/collection/' . basename($dir) . '/main.php') ) {
                continue;
            }

            // Get directory name
            $plugin = trim(basename($dir) . PHP_EOL);

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
            $all_plugins[] = (new $cl())->plugin_info();

        }

        return $all_plugins;
        
    }
    
}

/* End of file plugins.php */