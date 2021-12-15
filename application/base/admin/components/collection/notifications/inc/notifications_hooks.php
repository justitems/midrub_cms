<?php
/**
 * Admin Notifications Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Notifications component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'notifications',
    'item_icon' => md_the_admin_icon(array('icon' => 'notifications')),
    'item_name' => get_instance()->lang->line('notifications'),
    'item_url' => site_url('admin/notifications'),
    'item_position' => 2
));

/* End of file hooks.php */