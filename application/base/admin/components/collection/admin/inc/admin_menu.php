<?php
/**
 * Admin Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Admin component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'admin_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_ADMIN );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'admin',
    'item_icon' => md_the_admin_icon(array('icon' => 'admin')),
    'item_name' => get_instance()->lang->line('admin'),
    'item_url' => site_url('admin/admin'),
    'item_position' => 6
));

/* End of file hooks.php */