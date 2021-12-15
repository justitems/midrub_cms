<?php
/**
 * Admin Plugins Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Plugins component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'plugins_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PLUGINS );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'plugins',
    'item_icon' => md_the_admin_icon(array('icon' => 'plugins')),
    'item_name' => get_instance()->lang->line('plugins'),
    'item_url' => site_url('admin/plugins'),
    'item_position' => 7
));

/* End of file hooks.php */