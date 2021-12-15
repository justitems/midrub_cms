<?php
/**
 * Members Init Inc
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
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Members\Classes as CmsBaseAdminComponentsCollectionMembersClasses;

if ( !function_exists('set_admin_members_field') ) {
    
    /**
     * The function set_admin_members_field registers a members field
     * 
     * @param string $field_slug contains the field's slug
     * @param array $params contains the contents field's parameters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_admin_members_field($params) {

        // Call the Members class
        $members = (new CmsBaseAdminComponentsCollectionMembersClasses\Members);

        // Set members fields in the queue
        $members->set_field($params);
        
    }
    
}

if ( !function_exists('the_admin_members_fields') ) {
    
    /**
     * The function the_admin_members_fields returns the members fields
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function the_admin_members_fields() {

        // Call the Members class
        $members = (new CmsBaseAdminComponentsCollectionMembersClasses\Members);

        // Returns the fields
        return $members->the_fields();
        
    }
    
}

if ( !function_exists('set_admin_members_member_tab') ) {
    
    /**
     * The function set_admin_members_member_tab registers a member's tab
     * 
     * @param string $tab_slug contains the tab's slug
     * @param array $params contains the contents tab's parameters
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_admin_members_member_tab($tab_slug, $params) {

        // Call the Members_tabs class
        $members_tabs = (new CmsBaseAdminComponentsCollectionMembersClasses\Members_tabs);

        // Set member's tabs in the queue
        $members_tabs->set_tab($tab_slug, $params);
        
    }
    
}

if ( !function_exists('the_admin_members_member_tabs') ) {
    
    /**
     * The function the_admin_members_member_tabs returns the member's tabs
     * 
     * @since 0.0.8.3
     * 
     * @return array with response or boolean false
     */
    function the_admin_members_member_tabs() {

        // Call the Members_tabs class
        $members_tabs = (new CmsBaseAdminComponentsCollectionMembersClasses\Members_tabs);

        // Returns the tabs
        return $members_tabs->load_tabs();
        
    }
    
}

if ( !function_exists('set_admin_members_member_data_for_general_tab') ) {
    
    /**
     * The function set_admin_members_member_data_for_general_tab registers new data for the General Members tab
     * 
     * @param string $func contains the function's name
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function set_admin_members_member_data_for_general_tab($func) {

        // Call the Members_general_tab class
        $members_general_tab = (new CmsBaseAdminComponentsCollectionMembersClasses\Members_general_tab);

        // Set new tab's data in the queue
        $members_general_tab->set_tab_data($func);
        
    }
    
}

if ( !function_exists('the_admin_members_member_data_for_general_tab') ) {
    
    /**
     * The function the_admin_members_member_data_for_general_tab returns the member's tabs
     * 
     * @since 0.0.8.3
     * 
     * @return string with response
     */
    function the_admin_members_member_data_for_general_tab() {

        // Call the Members_general_tab class
        $members_general_tab = (new CmsBaseAdminComponentsCollectionMembersClasses\Members_general_tab);

        // Get functions
        $functions = $members_general_tab->load_tab_data();

        // Data container
        $data = '';

        // Verify if $functions is not empty
        if ( $functions ) {

            // List the data
            foreach ( $functions as $function ) {

                // Get function's data
                $response = $function();

                // Verify if $response has required fields
                if ( isset($response['label']) && isset($response['value']) ) {

                    // Set data
                    $data .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                        . '<label class="theme-label ps-2">'
                            . $response['label']
                        . '</label>'
                        . '<span class="badge me-2 theme-badge-1 bg-primary">'
                            . $response['value']
                        . '</span>'
                    . '</li>';

                }

            }

        }

        // Returns the data
        return $data;
        
    }
    
}

/* End of file members_init.php */