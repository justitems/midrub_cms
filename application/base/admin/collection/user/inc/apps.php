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

if ( !function_exists('md_the_user_apps') ) {

    /**
     * The function md_the_user_apps provides the list with user's apps
     * 
     * @return array with apps list
     */
    function md_the_user_apps() {

        // Apps array
        $apps = array();

        // List all user's apps
        foreach ( glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $app = trim(basename($directory).PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get app's info
            $info = (new $cl())->app_info();

            // Add info to app
            $apps[] = $info;

        }

        return $apps;
        
    }

}

if ( !function_exists('md_the_user_app') ) {

    /**
     * The function md_the_user_app provides the list with user's app
     * 
     * @param string $app_slug contains the app's slug
     * 
     * @return array with app's info or boolean false
     */
    function md_the_user_app($app_slug) {

        // List all user's apps
        foreach ( glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory ) {

            // Get the directory's name
            $app = trim(basename($directory).PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get app's info
            $info = (new $cl())->app_info();

            // Verify if is required app
            if ( $app_slug === $info['app_slug'] ) {
                return $info;
            }

        }

        return false;
        
    }

}