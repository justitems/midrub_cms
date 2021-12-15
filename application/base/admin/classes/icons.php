<?php
/**
 * Base Admin Icons
 *
 * This file contains the class Icons
 * which processes the Admin's Icons
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Icons class processes the Admin's Icons
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Icons {
    
    /**
     * The public method the_icon gets the admin icon
     * 
     * @param array $params contains the parameters
     *
     * @since 0.0.8.5
     * 
     * @return string with icon or boolean
     */ 
    public function the_icon( $params ) {
        
        // Verify if the required parameter exists
        if ( !empty($params['icon']) ) {

            // Verify if the icon file exists
            if ( file_exists(CMS_BASE_ADMIN . 'icons/collection/' . $params['icon'] . '.php') ) {

                try {
                    
                    // Require the icon file
                    require_once CMS_BASE_ADMIN . 'icons/collection/' . $params['icon'] . '.php';

                    // Verify if the function exists
                    if ( function_exists('md_admin_icon_' . $params['icon']) ) {

                        $func = 'md_admin_icon_' . $params['icon'];

                        // Return the icon
                        return $func($params);

                    }
                
                } catch ( Throwable $e ) {
                    return false;
                }

            }

        }

        return false;
        
    }
    
}

/* End of file icons.php */