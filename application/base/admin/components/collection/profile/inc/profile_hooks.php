<?php
/**
 * Admin Profile Hooks Inc
 *
 * This file contains some hooks
 * functions used in the profile component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'profile_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PROFILE );

// Register menu's item
md_set_admin_menu_item(array(
    'item_parent' => 'account',
    'item_slug' => 'profile',
    'item_icon' => md_the_admin_icon(array('icon' => 'my_profile')),
    'item_name' => get_instance()->lang->line('profile'),
    'item_url' => site_url('admin/profile'),
    'item_position' => 1
));

/* End of file hooks.php */