<?php
/**
 * Hooks Class
 *
 * This file loads the Hooks Class with hooks methods used in the base's components
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Hooks class loads the hooks methods used in the base's components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Hooks {

    /**
     * Contains the registered hooks to execute
     *
     * @since 0.0.7.8
     */
    public static $hooks = array();    

    /**
     * The public method add_hook adds a hook in the queue
     * 
     * @param string $hook_name contains the hook's name
     * @param function $function contains the function to call
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function add_hook($hook_name, $function) {

        self::$hooks[$hook_name][] = $function;

    }

    /**
     * The public method run_hook runs a hook based on name
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function run_hook($hook_name, $args) {

        // Verify if hook exists
        if ( isset(self::$hooks[$hook_name]) ) {

            if (self::$hooks[$hook_name]) {

                foreach (self::$hooks[$hook_name] as $hook) {

                    if ($args) {

                        $hook($args);

                    } else {

                        $hook($args);
                        
                    }

                }

            }

        }

    }    

}
