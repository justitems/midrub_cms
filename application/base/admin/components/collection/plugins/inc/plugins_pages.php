<?php
/**
 * Plugins Pages Inc
 *
 * PHP Version 7.3
 *
 * This files contains the plugins's pages
 * methods used in admin -> plugins
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Register a plugins's page in the admin panel
set_admin_plugins_page(
    'plugins',
    array(
        'page_name' => get_instance()->lang->line('plugins'),
        'page_icon' => md_the_admin_icon(array('icon' => 'plugins_small')),
        'content' => 'get_admin_page_plugins',
        'css_urls' => array(),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/plugins/js/plugins.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_PLUGINS_VERSION))
        )  
    )
);

if ( !function_exists('get_admin_page_plugins') ) {

    /**
     * The function get_admin_page_plugins gets plugins's page
     * 
     * @return void
     */
    function get_admin_page_plugins() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if the plugins directory exists
        if ( $CI->input->get('directory', true) ) {

            // Include plugins directory view for user
            md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'views/plugins/plugins_directory.php');

        } else {

            // Require the Plugins Inc
            require_once CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'inc/plugins.php';

            // Include list view for administrator
            md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_PLUGINS . 'views/plugins/list.php');

        }
        
    }

}

/* End of file plugins_pages.php */