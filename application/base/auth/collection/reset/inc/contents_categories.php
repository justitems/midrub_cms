<?php
/**
 * Contents Categories Functions
 *
 * PHP Version 5.6
 *
 * This files contains the component's contents
 * categories meta used in admin -> frontend
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
 * The public method md_set_contents_category_meta sets meta for the auth contents category
 * 
 * @since 0.0.7.8
 */
md_set_contents_category_meta(
    'auth',
    array(
        'name' => $CI->lang->line('auth_reset_details'),
        'slug' => 'auth_reset_details',
        'fields' => array(
            array(
                'slug' => 'auth_reset_details_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_reset_details_title'),
                'label_description' => $CI->lang->line('auth_reset_details_title_description'),
                'value' => $CI->lang->line('auth_reset_page_title')
            ), array(
                'slug' => 'auth_reset_details_under_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_reset_details_under_title'),
                'label_description' => $CI->lang->line('auth_reset_details_under_title_description'),
                'value' => $CI->lang->line('auth_reset_page_under_title')
            )           
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

