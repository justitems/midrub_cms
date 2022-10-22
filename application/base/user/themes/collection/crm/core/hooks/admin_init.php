<?php
/**
 * Admin Init Hooks
 *
 * PHP Version 5.6
 *
 * This files contains the hooks loaded
 * in the Midrub's admin panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Get codeigniter object instance
$CI = &get_instance();

/**
 * The public method md_set_user_menu registers a new menu
 * 
 * @since 0.0.8.1
 */
md_set_user_menu(
    'sidebar_top_menu',
    array(
        'name' => $CI->lang->line('theme_sidebar_top_menu')   
    )    
);

/**
 * The public method md_set_user_menu registers a new menu
 * 
 * @since 0.0.8.1
 */
md_set_user_menu(
    'sidebar_bottom_menu',
    array(
        'name' => $CI->lang->line('theme_sidebar_bottom_menu')   
    )    
);