<?php
/**
 * Apps Inc
 *
 * PHP Version 7.2
 *
 * This files contains the Apps Inc file
 * with methods to manage the apps
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_user_components') ) {

    /**
     * The function md_the_user_components provides the list with user's components
     * 
     * @return array with components list
     */
    function md_the_user_components() {

        // Components array
        $components = array();

        // List all user's components
        foreach ( glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $component = trim(basename($directory).PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Components',
                'Collection',
                ucfirst($component),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get component's info
            $info = (new $cl())->component_info();

            // Add info to component
            $components[] = $info;

        }

        return $components;
        
    }

}

if ( !function_exists('md_the_user_component') ) {

    /**
     * The function md_the_user_component provides the component's info if exists
     * 
     * @param string $component_slug contains the component's slug
     * 
     * @return array with component's info or boolean false
     */
    function md_the_user_component($component_slug) {

        // List all user's components
        foreach ( glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $component = trim(basename($directory).PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Components',
                'Collection',
                ucfirst($component),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get component's info
            $info = (new $cl())->component_info();

            // Verify if is required component
            if ( $component_slug === $info['component_slug'] ) {
                return $info;
            }

        }

        return false;
        
    }

}