<?php
/**
 * Storage Init Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions to register
 * the storage's locations
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
use CmsBase\Admin\Components\Collection\Settings\Classes as CmsBaseAdminComponentsCollectionSettingsClasses;

if ( !function_exists('set_storage_location') ) {
    
    /**
     * The function set_storage_location registers settings locations
     * 
     * @param string $location_slug contains the location's slug
     * @param array $args contains the location's arguments
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    function set_storage_location($location_slug, $args) {

        // Call the storage_locations class
        $storage_locations = (new CmsBaseAdminComponentsCollectionSettingsClasses\Storage_locations);

        // Set settings location in the queue
        $storage_locations->set_location($location_slug, $args);
        
    }
    
}

/* End of file storage_init.php */