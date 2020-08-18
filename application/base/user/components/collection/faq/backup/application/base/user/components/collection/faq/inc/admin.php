<?php
/**
 * Admin Inc
 *
 * PHP Version 7.2
 *
 * This files contains the hooks for
 * the User component from the admin Panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Get codeigniter object instance
$CI = &get_instance();

/**
 * The public method set_admin_component_options registers options for Admin's
 * 
 * @since 0.0.7.9
 */
set_admin_component_options(

    array (
            
        array (
            'type' => 'checkbox_input',
            'slug' => 'component_faq_enable',
            'label' => $CI->lang->line('enable_component'),
            'label_description' => $CI->lang->line('if_is_enabled')
        )
        
    )

);