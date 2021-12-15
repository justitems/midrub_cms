<?php
/**
 * Admin Dashboard Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Dashboard component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'dashboard_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_DASHBOARD );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'dashboard',
    'item_icon' => md_the_admin_icon(array('icon' => 'home')),
    'item_name' => get_instance()->lang->line('dashboard'),
    'item_url' => site_url('admin/dashboard'),
    'item_position' => 1
));

/* End of file hooks.php */