<?php
/**
 * Contents Categories Inc
 *
 * PHP Version 7.3
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
 * The public method set_contents_category_meta sets meta for the auth contents category
 * 
 * @since 0.0.7.8
 */
set_contents_category_meta(
    'auth',
    array(
        'name' => $CI->lang->line('auth_signin_details'),
        'slug' => 'auth_signin_details',
        'fields' => array(
            array(
                'slug' => 'auth_signin_details_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_signin_details_title'),
                'label_description' => $CI->lang->line('auth_signin_details_title_description'),
                'value' => $CI->lang->line('auth_signin')
            ), array(
                'slug' => 'auth_signin_details_under_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('auth_signin_details_under_title'),
                'label_description' => $CI->lang->line('auth_signin_details_under_title_description'),
                'value' => $CI->lang->line('auth_signin_forgot_your_password')
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
        'name' => $CI->lang->line('auth_signin_slider'),
        'slug' => 'auth_signin_slider',
        'fields' => array(
            array(
                'slug' => 'auth_signin_slider_enable',
                'type' => 'checkbox_input',
                'label' => $this->CI->lang->line('auth_signin_settings_enable'),
                'label_description' => $this->CI->lang->line('auth_signin_settings_enable_description')
            ),
            array(
                'slug' => 'auth_signin_slider_items',
                'type' => 'list_items',
                'label' => $CI->lang->line('auth_signin_slider'),
                'words' => array(
                    'new_item_text' => '<i class="icon-picture"></i> ' . $CI->lang->line('auth_signin_new_photo')
                ),
                'fields' => array(
                    array(
                        'slug' => 'auth_signin_settings_enter_image_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('auth_signin_settings_enter_image_title'),
                        'label_description' => $this->CI->lang->line('auth_signin_settings_enter_image_title_description')
                    ), 
                    array(
                        'slug' => 'auth_signin_slider_image',
                        'type' => 'media_input',
                        'label' => $this->CI->lang->line('auth_signin_slider_caption_image'),
                        'label_description' => $this->CI->lang->line('auth_signin_slider_caption_image_description')
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