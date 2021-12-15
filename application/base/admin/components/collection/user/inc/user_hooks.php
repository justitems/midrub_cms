<?php
/**
 * Admin User Hooks Inc
 *
 * This file contains some hooks
 * functions used in the User component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'user_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_USER );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'user',
    'item_icon' => md_the_admin_icon(array('icon' => 'user')),
    'item_name' => get_instance()->lang->line('user'),
    'item_url' => site_url('admin/user'),
    'item_position' => 5
));

/* End of file hooks.php */