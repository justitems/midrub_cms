<?php
/**
 * Members Fields Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions which
 * are runned only for the Members Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Members\Classes as CmsBaseAdminComponentsCollectionMembersClasses;

if ( !function_exists('the_admin_members_field') ) {
    
    /**
     * The function the_admin_members_field returns the member field
     * 
     * @param string $field_slug contains the field's slug
     * 
     * @since 0.0.8.3
     * 
     * @return array with member field or boolean false
     */
    function the_admin_members_field($field_slug) {

        // Call the Members class
        $members = (new CmsBaseAdminComponentsCollectionMembersClasses\Members);

        // Returns the field
        return $members->load_field($field_slug);
        
    }
    
}