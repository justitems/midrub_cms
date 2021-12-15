<?php
/**
 * Admin Profile Quick Guide Inc
 *
 * This file contains the function whic provides
 * the quick guide articles
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_profile_quick_guide') ) {
    
    /**
     * The function the_profile_quick_guide provides the quick guide content
     * 
     * @since 0.0.8.5
     * 
     * @return array with data
     */
    function the_profile_quick_guide() {

        // Assign the CodeIgniter super-object
        $CI =& get_instance();

        // Load the component's language files
        $CI->lang->load( 'profile_quick_guide', $CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_PROFILE);

        // Return data
        return array(
            array(
                'content_type' => 'category',
                'content_slug' => 'my_profile',
                'content_title' => $CI->lang->line('profile'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_profile_basic',
                        'content_title' => $CI->lang->line('profile_basic'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_basic_article',
                                'content_title' => $CI->lang->line('profile_basic_information'),
                                'content_body' => $CI->lang->line('profile_basic_instructions')
                            ) 
                        )
                    ),
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_profile_advanced',
                        'content_title' => $CI->lang->line('profile_advanced'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_advanced_article',
                                'content_title' => $CI->lang->line('profile_advanced_information'),
                                'content_body' => $CI->lang->line('profile_advanced_instructions')
                            ) 
                        )
                    ),                    
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_profile_photo',
                        'content_title' => $CI->lang->line('profile_photo'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_photo_article',
                                'content_title' => $CI->lang->line('profile_photo_information'),
                                'content_body' => $CI->lang->line('profile_photo_instructions')
                            ) 
                        )
                    )
                )
            ), 
            array(
                'content_type' => 'category',
                'content_slug' => 'preferences',
                'content_title' => $CI->lang->line('profile_my_preferences'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'preferences_language',
                        'content_title' => $CI->lang->line('profile_language'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_language_article',
                                'content_title' => $CI->lang->line('profile_language_information'),
                                'content_body' => $CI->lang->line('profile_language_instructions')
                            ) 
                        )
                    ),
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'preferences_time_formats',
                        'content_title' => $CI->lang->line('profile_time_formats'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_time_formats_article',
                                'content_title' => $CI->lang->line('profile_time_formats_information'),
                                'content_body' => $CI->lang->line('profile_time_formats_instructions')
                            ) 
                        )
                    )                    
                )
            ),    
            array(
                'content_type' => 'category',
                'content_slug' => 'security',
                'content_title' => $CI->lang->line('profile_security'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'security_access',
                        'content_title' => $CI->lang->line('profile_access'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_profile_access_article',
                                'content_title' => $CI->lang->line('profile_access_information'),
                                'content_body' => $CI->lang->line('profile_access_instructions')
                            ) 
                        )
                    )
                )
            )    
        );
        
    }
    
}

/* End of file quick_guide.php */