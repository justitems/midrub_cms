<?php
/**
 * Admin Settings Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Settings component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'settings_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SETTINGS );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'settings',
    'item_icon' => md_the_admin_icon(array('icon' => 'settings')),
    'item_name' => get_instance()->lang->line('settings'),
    'item_url' => site_url('admin/settings'),
    'item_position' => 8
));

/* End of file hooks.php */