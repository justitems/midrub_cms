<?php
/**
 * Contents Categories Functions
 *
 * PHP Version 5.6
 *
 * This files contains the component's contents
 * categories used in admin -> frontend
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
 * The public method md_set_contents_category_meta sets meta for the auth contents category
 * 
 * @since 0.0.7.8
 */
set_contents_category_meta(
    'auth',
    array(
        'name' => $CI->lang->line('auth_signup_details'),
        'slug' => 'auth_signup_details',
        'fields' => array(
            array(
                'slug' => 'auth_signup_details_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_signup_details_title'),
                'label_description' => $CI->lang->line('auth_signup_details_title_description'),
                'value' => $CI->lang->line('auth_signup_page_title')
            ), array(
                'slug' => 'auth_signup_details_under_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_signup_details_under_title'),
                'label_description' => $CI->lang->line('auth_signup_details_under_title_description'),
                'value' => $CI->lang->line('auth_signup_page_under_title')
            ), array(
                'slug' => 'auth_signup_details_accept_terms',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_signup_details_approve_terms'),
                'label_description' => $CI->lang->line('auth_signup_details_approve_terms_description'),
                'value' => $CI->lang->line('auth_signup_page_approve_terms')
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);


/**
 * The public method set_contents_category_meta sets meta for the auth contents category
 * 
 * @since 0.0.8.2
 */
set_contents_category_meta(
    'auth',
    array(
        'name' => $CI->lang->line('auth_signup_slider'),
        'slug' => 'auth_signup_slider',
        'fields' => array(
            array(
                'slug' => 'auth_signup_slider_enable',
                'type' => 'checkbox_input',
                'label' => $this->CI->lang->line('auth_signup_settings_enable'),
                'label_description' => $this->CI->lang->line('auth_signup_settings_enable_description')
            ),
            array(
                'slug' => 'auth_signup_slider_items',
                'type' => 'list_items',
                'label' => $CI->lang->line('auth_signup_slider'),
                'words' => array(
                    'new_item_text' => '<i class="icon-picture"></i> ' . $CI->lang->line('auth_signup_new_photo')
                ),
                'fields' => array(
                    array(
                        'slug' => 'auth_signup_settings_enter_image_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('auth_signup_settings_enter_image_title'),
                        'label_description' => $this->CI->lang->line('auth_signup_settings_enter_image_title_description')
                    ), 
                    array(
                        'slug' => 'auth_signup_slider_image',
                        'type' => 'media_input',
                        'label' => $this->CI->lang->line('auth_signup_slider_caption_image'),
                        'label_description' => $this->CI->lang->line('auth_signup_slider_caption_image_description')
                    )                  
                )
            )        
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);