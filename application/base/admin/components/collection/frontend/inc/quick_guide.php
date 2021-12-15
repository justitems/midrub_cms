<?php
/**
 * Admin Frontend Quick Guide Inc
 *
 * This file contains the function whic provides
 * the quick guide articles
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_frontend_quick_guide') ) {
    
    /**
     * The function the_frontend_quick_guide provides the quick guide content
     * 
     * @since 0.0.8.5
     * 
     * @return array with data
     */
    function the_frontend_quick_guide() {

        // Assign the CodeIgniter super-object
        $CI =& get_instance();

        // Load the component's language files
        $CI->lang->load( 'frontend_quick_guide', $CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_FRONTEND);

        // Return data
        return array(
            array(
                'content_type' => 'category',
                'content_slug' => 'my_frontend',
                'content_title' => $CI->lang->line('frontend'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_frontend_basic',
                        'content_title' => $CI->lang->line('frontend_basic'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_basic_article',
                                'content_title' => $CI->lang->line('frontend_basic_information'),
                                'content_body' => $CI->lang->line('frontend_basic_instructions')
                            ) 
                        )
                    ),
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_frontend_advanced',
                        'content_title' => $CI->lang->line('frontend_advanced'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_advanced_article',
                                'content_title' => $CI->lang->line('frontend_advanced_information'),
                                'content_body' => $CI->lang->line('frontend_advanced_instructions')
                            ) 
                        )
                    ),                    
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'my_frontend_photo',
                        'content_title' => $CI->lang->line('frontend_photo'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_photo_article',
                                'content_title' => $CI->lang->line('frontend_photo_information'),
                                'content_body' => $CI->lang->line('frontend_photo_instructions')
                            ) 
                        )
                    )
                )
            ), 
            array(
                'content_type' => 'category',
                'content_slug' => 'preferences',
                'content_title' => $CI->lang->line('frontend_my_preferences'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'preferences_language',
                        'content_title' => $CI->lang->line('frontend_language'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_language_article',
                                'content_title' => $CI->lang->line('frontend_language_information'),
                                'content_body' => $CI->lang->line('frontend_language_instructions')
                            ) 
                        )
                    ),
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'preferences_time_formats',
                        'content_title' => $CI->lang->line('frontend_time_formats'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_time_formats_article',
                                'content_title' => $CI->lang->line('frontend_time_formats_information'),
                                'content_body' => $CI->lang->line('frontend_time_formats_instructions')
                            ) 
                        )
                    )                    
                )
            ),    
            array(
                'content_type' => 'category',
                'content_slug' => 'security',
                'content_title' => $CI->lang->line('frontend_security'),
                'content_childrens' => array(
                    array(
                        'content_type' => 'category',
                        'content_slug' => 'security_access',
                        'content_title' => $CI->lang->line('frontend_access'),
                        'content_childrens' => array(
                            array(
                                'content_type' => 'article',
                                'content_slug' => 'my_frontend_access_article',
                                'content_title' => $CI->lang->line('frontend_access_information'),
                                'content_body' => $CI->lang->line('frontend_access_instructions')
                            ) 
                        )
                    )
                )
            )    
        );
        
    }
    
}

/* End of file quick_guide.php */