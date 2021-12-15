<?php
/**
 * Admin Frontend Hooks Inc
 *
 * This file contains some hooks
 * functions used in the Frontend component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Load the component's language files
get_instance()->lang->load( 'frontend_menu', get_instance()->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND );

// Register menu's item
md_set_admin_menu_item(array(
    'item_slug' => 'frontend',
    'item_icon' => md_the_admin_icon(array('icon' => 'frontend')),
    'item_name' => get_instance()->lang->line('frontend'),
    'item_url' => site_url('admin/frontend'),
    'item_position' => 4
));

/* End of file hooks.php */