<?php
/**
 * Admin Members Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Members component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'members',
    'item_icon' => md_the_admin_icon(array('icon' => 'members')),
    'item_name' => get_instance()->lang->line('members'),
    'item_url' => site_url('admin/members'),
    'item_position' => 3
));

/* End of file members_hooks.php */