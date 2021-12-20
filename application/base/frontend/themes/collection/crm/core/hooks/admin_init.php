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
 * The public method md_set_contents_category sets the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'theme_pages',
    array(
        'category_name' => $CI->lang->line('theme_category_name'),
        'category_icon' => md_the_admin_icon(array('icon' => 'pages')),
        'editor' => false,
        'slug_in_url' => false,
        'templates_path' => md_the_theme_path() . 'contents/templates/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_page'),
            'search_content' => $CI->lang->line('theme_search_pages'),
            'enter_content_title' => $CI->lang->line('theme_enter_page_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'theme_pages',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_option sets option for the Themes contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_option(
    'theme_pages',
    array(
        'name' => $CI->lang->line('frontend_set_theme_template'),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_integrations_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method md_set_contents_category sets the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'features',
    array(
        'category_name' => $CI->lang->line('theme_features'),
        'category_icon' => md_the_admin_icon(array('icon' => 'features')),
        'editor' => true,
        'slug_in_url' => true,
        'templates_path' => md_the_theme_path() . 'contents/features/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_feature'),
            'search_content' => $CI->lang->line('theme_search_features'),
            'enter_content_title' => $CI->lang->line('theme_enter_feature_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the features contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'features',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_meta sets short description box
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'features',
    array(
        'name' => md_get_the_string('theme_features_contents', true),
        'slug' => 'theme_features_contents_box',
        'fields' => array(
            array(
                'slug' => 'short_description',
                'type' => 'text_input',
                'label' => $this->CI->lang->line('theme_features_short_description'),
                'label_description' => $this->CI->lang->line('theme_features_short_description_instructions'),
                'value' => ''
            ),
            array(
                'slug' => 'icon_class',
                'type' => 'text_input',
                'label' => $this->CI->lang->line('theme_features_icon'),
                'label_description' => $this->CI->lang->line('theme_features_icon_description'),
                'value' => ''
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method md_set_contents_category_meta sets general options
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'features',
    array(
        'name' => md_get_the_string('theme_integration_options', true),
        'slug' => 'theme_feature_options',
        'fields' => array(          
            array(
                'slug' => 'featured',
                'type' => 'checkbox_input',
                'label' => md_get_the_string('theme_feature_options_featured', true),
                'label_description' => md_get_the_string('theme_feature_options_featured_description', true)
            )

        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method set_contents_category_option sets option for the features contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option (
    'features',
    array(
        'name' => md_get_the_string('theme_integrations_theme_templates', true),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_integrations_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method set_contents_category_option sets option for the features contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option(
    'features',
    array(
        'name' => md_get_the_string('theme_features_categories', true),
        'slug' => 'features_categories',
        'fields' => array(
            array(
                'slug' => 'features_categories',
                'type' => 'contents_classification',
                'label' => md_get_the_string('theme_features_selected_categories', true),
                'parent' => false,
                'fields' => array(),
                'words_list' => array(
                    'single_item' => md_get_the_string('theme_features_category', true),
                    'search_input_placeholder' => md_get_the_string('theme_features_search_for_categories', true),
                    'new_classification_option' => md_get_the_string('theme_features_new_category', true),
                    'classification_name_input_placeholder' => md_get_the_string('theme_features_enter_category_name', true),
                    'classification_slug_input_placeholder' => md_get_the_string('theme_features_enter_category_slug', true)
                )
            )                    
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category sets the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'integrations',
    array(
        'category_name' => $CI->lang->line('theme_integrations'),
        'category_icon' => md_the_admin_icon(array('icon' => 'integrations')),
        'editor' => true,
        'slug_in_url' => true,
        'templates_path' => md_the_theme_path() . 'contents/integrations/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_integration'),
            'search_content' => $CI->lang->line('theme_search_integrations'),
            'enter_content_title' => $CI->lang->line('theme_enter_integration_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the integrations contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'integrations',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_meta sets short description box
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'integrations',
    array(
        'name' => md_get_the_string('theme_integrations_contents', true),
        'slug' => 'theme_integration_short_description_box',
        'fields' => array(
            array(
                'slug' => 'short_description',
                'type' => 'text_input',
                'label' => $this->CI->lang->line('theme_integration_short_description'),
                'label_description' => $this->CI->lang->line('theme_integration_short_description_instructions'),
                'value' => ''
            )
        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method md_set_contents_category_meta sets general options
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'integrations',
    array(
        'name' => md_get_the_string('theme_integration_options', true),
        'slug' => 'theme_integration_options',
        'fields' => array(
            array(
                'slug' => 'image',
                'type' => 'media_input',
                'label' => $this->CI->lang->line('theme_integration_options_image'),
                'label_description' => $this->CI->lang->line('theme_integration_options_image_description')
            ),          
            array(
                'slug' => 'featured',
                'type' => 'checkbox_input',
                'label' => md_get_the_string('theme_integration_options_featured', true),
                'label_description' => md_get_the_string('theme_integration_options_featured_description', true)
            ),                                                   
            array(
                'slug' => 'featured_image',
                'type' => 'media_input',
                'label' => $this->CI->lang->line('theme_top_section_image_url'),
                'label_description' => $this->CI->lang->line('theme_integration_options_featured_image_description')
            )

        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method set_contents_category_option sets option for the Themes contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option (
    'integrations',
    array(
        'name' => md_get_the_string('theme_integrations_theme_templates', true),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_integrations_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method set_contents_category_option sets option for the themes contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option(
    'integrations',
    array(
        'name' => md_get_the_string('theme_integrations_categories', true),
        'slug' => 'integrations_categories',
        'fields' => array(
            array(
                'slug' => 'integrations_categories',
                'type' => 'contents_classification',
                'label' => md_get_the_string('theme_integrations_selected_categories', true),
                'parent' => false,
                'fields' => array(),
                'words_list' => array(
                    'single_item' => md_get_the_string('theme_integrations_classification_single_item', true),
                    'search_input_placeholder' => md_get_the_string('theme_integrations_search_for_categories', true),
                    'new_classification_option' => md_get_the_string('theme_integrations_new_category', true),
                    'classification_name_input_placeholder' => md_get_the_string('theme_integrations_enter_category_name', true),
                    'classification_slug_input_placeholder' => md_get_the_string('theme_integrations_enter_category_slug', true)
                )
            )                    
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category sets the contents posts category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'posts',
    array(
        'category_name' => $CI->lang->line('theme_posts'),
        'category_icon' => md_the_admin_icon(array('icon' => 'posts')),
        'editor' => true,
        'slug_in_url' => true,
        'templates_path' => md_the_theme_path() . 'contents/posts/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_post'),
            'search_content' => $CI->lang->line('theme_search_posts'),
            'enter_content_title' => $CI->lang->line('theme_enter_post_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the posts contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'posts',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_meta sets short description box
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'posts',
    array(
        'name' => md_get_the_string('theme_post_contents', true),
        'slug' => 'theme_post_contents_box',
        'fields' => array(
            array(
                'slug' => 'short_description',
                'type' => 'text_input',
                'label' => $this->CI->lang->line('theme_post_short_description'),
                'label_description' => $this->CI->lang->line('theme_post_short_description_instructions'),
                'value' => ''
            )          
        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method md_set_contents_category_meta sets general options
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'posts',
    array(
        'name' => md_get_the_string('theme_post_options', true),
        'slug' => 'post_options',
        'fields' => array(
            array(
                'slug' => 'cover',
                'type' => 'media_input',
                'label' => $this->CI->lang->line('theme_post_options_cover'),
                'label_description' => $this->CI->lang->line('theme_post_options_cover_description')
            ),          
            array(
                'slug' => 'featured',
                'type' => 'checkbox_input',
                'label' => md_get_the_string('theme_post_options_featured', true),
                'label_description' => md_get_the_string('theme_post_options_featured_description', true)
            )

        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method set_contents_category_option sets option for the posts contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option (
    'posts',
    array(
        'name' => md_get_the_string('theme_integrations_theme_templates', true),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_integrations_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method set_contents_category_option sets option for the posts contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option(
    'posts',
    array(
        'name' => md_get_the_string('theme_posts_categories', true),
        'slug' => 'posts_categories',
        'fields' => array(
            array(
                'slug' => 'posts_categories',
                'type' => 'contents_classification',
                'label' => md_get_the_string('theme_posts_selected_categories', true),
                'parent' => false,
                'fields' => array(),
                'words_list' => array(
                    'single_item' => md_get_the_string('theme_post', true),
                    'search_input_placeholder' => md_get_the_string('theme_posts_search_for_categories', true),
                    'new_classification_option' => md_get_the_string('theme_posts_new_category', true),
                    'classification_name_input_placeholder' => md_get_the_string('theme_posts_enter_category_name', true),
                    'classification_slug_input_placeholder' => md_get_the_string('theme_posts_enter_category_slug', true)
                )
            )                    
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category sets the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'support_articles',
    array(
        'category_name' => $CI->lang->line('theme_articles'),
        'category_icon' => md_the_admin_icon(array('icon' => 'support_articles')),
        'editor' => TRUE,
        'slug_in_url' => TRUE,
        'templates_path' => md_the_theme_path() . 'contents/support_articles/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_article'),
            'search_content' => $CI->lang->line('theme_search_articles'),
            'enter_content_title' => $CI->lang->line('theme_enter_article_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the support articles contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'support_articles',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_option sets option for the Themes contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_option(
    'support_articles',
    array(
        'name' => $CI->lang->line('frontend_set_theme_template'),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_integrations_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method set_contents_category_option sets option for the themes contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option(
    'support_articles',
    array(
        'name' => md_get_the_string('theme_support_articles_categories', true),
        'slug' => 'support_categories',
        'fields' => array(
            array(
                'slug' => 'support_categories',
                'type' => 'contents_classification',
                'label' => md_get_the_string('theme_integrations_selected_categories', true),
                'parent' => false,
                'fields' => array(
                    array(
                        'slug' => 'icon',
                        'type' => 'text',
                        'placeholder' => md_get_the_string('theme_enter_icon_code', true)
                    ),
                    array(
                        'slug' => 'description',
                        'type' => 'text',
                        'placeholder' => md_get_the_string('theme_enter_category_description', true)
                    )                    
                ),
                'words_list' => array(
                    'single_item' => md_get_the_string('theme_support_articles_classification_single_item', true),
                    'search_input_placeholder' => md_get_the_string('theme_support_articles_search_for_categories', true),
                    'new_classification_option' => md_get_the_string('theme_support_articles_new_category', true),
                    'classification_name_input_placeholder' => md_get_the_string('theme_support_articles_enter_category_name', true),
                    'classification_slug_input_placeholder' => md_get_the_string('theme_support_articles_enter_category_slug', true)
                )
            )                    
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category sets the Default contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category(
    'careers',
    array(
        'category_name' => $CI->lang->line('theme_careers'),
        'category_icon' => md_the_admin_icon(array('icon' => 'jobs')),
        'editor' => TRUE,
        'slug_in_url' => TRUE,
        'templates_path' => md_the_theme_path() . 'contents/careers/',
        'words_list' => array(
            'new_content' => $CI->lang->line('theme_new_career'),
            'search_content' => $CI->lang->line('theme_search_careers'),
            'enter_content_title' => $CI->lang->line('theme_enter_career_title')
        )
    )
);

/**
 * The public method md_set_contents_category_meta sets meta for the support articles contents category
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'careers',
    array(
        'name' => $CI->lang->line('theme_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_page_title'),
                'label_description' => $CI->lang->line('theme_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_description'),
                'label_description' => $CI->lang->line('theme_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_meta_keywords'),
                'label_description' => $CI->lang->line('theme_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_contents_category_meta sets faq for plans page
 * 
 * @since 0.0.8.5
 */
md_set_contents_category_meta(
    'careers',
    array(
        'name' => $CI->lang->line('theme_career_options'),
        'slug' => 'careers_options',
        'fields' => array(

            array(
                'slug' => 'career_location',
                'type' => 'text_input',
                'label' => $CI->lang->line('theme_career_location'),
                'label_description' => $CI->lang->line('theme_career_location_description')
            )

        ),
        'css_urls' => array(),
        'js_urls' => array()
    )

);

/**
 * The public method set_contents_category_option sets option for the careers contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option (
    'careers',
    array(
        'name' => md_get_the_string('theme_careers_theme_templates', true),
        'slug' => 'theme_templates',
        'fields' => array(
            array(
                'slug' => 'theme_templates',
                'type' => 'theme_templates',
                'label' => md_get_the_string('theme_careers_selected_theme_template', true),
                'label_description' => ''
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

/**
 * The public method set_contents_category_option sets option for the careers contents category
 * 
 * @since 0.0.8.5
 */
set_contents_category_option(
    'careers',
    array(
        'name' => md_get_the_string('theme_careers_categories', true),
        'slug' => 'careers_categories',
        'fields' => array(
            array(
                'slug' => 'careers_categories',
                'type' => 'contents_classification',
                'label' => md_get_the_string('theme_careers_selected_categories', true),
                'parent' => false,
                'fields' => array(),
                'words_list' => array(
                    'single_item' => md_get_the_string('theme_careers_category', true),
                    'search_input_placeholder' => md_get_the_string('theme_careers_search_for_categories', true),
                    'new_classification_option' => md_get_the_string('theme_careers_new_category', true),
                    'classification_name_input_placeholder' => md_get_the_string('theme_careers_enter_category_name', true),
                    'classification_slug_input_placeholder' => md_get_the_string('theme_careers_enter_category_slug', true)
                )
            )                    
        ),
        'css_urls' => array(),
        'js_urls' => array()        
    )    
);

/**
 * The public method md_set_frontend_menu registers a new menu
 * 
 * @since 0.0.8.5
 */
md_set_frontend_menu(
    'main_menu',
    array(
        'name' => $CI->lang->line('theme_top_menu')      
    )    
);

/**
 * The public method md_set_frontend_menu registers a new menu
 * 
 * @since 0.0.8.5
 */
md_set_frontend_menu(
    'access_menu',
    array(
        'name' => $CI->lang->line('theme_access_menu')      
    )    
);

/**
 * The public method md_set_frontend_menu registers a new menu
 * 
 * @since 0.0.8.5
 */
md_set_frontend_menu(
    'footer_menu',
    array(
        'name' => $CI->lang->line('theme_footer_menu')      
    )    
);

/**
 * The public method md_set_frontend_menu registers a new menu
 * 
 * @since 0.0.8.5
 */
md_set_frontend_menu(
    'social_menu',
    array(
        'name' => $CI->lang->line('theme_social_menu')      
    )    
);

// Load classes based on templates
if ( ($CI->input->get('p', TRUE) === 'editor') && ($CI->input->get('category', TRUE) === 'theme_pages') && $CI->input->get('template', TRUE) ) {

    $template = str_replace('-', '_', $CI->input->get('template', TRUE));

    // Verify if class exists
    if ( file_exists(md_the_theme_path() . 'core/classes/' . $template . '.php' ) ) {

        // Create an array
        $array = array(
            'CmsBase',
            'Frontend',
            'Themes',
            'Collection',
            'Crm',
            'Core',
            'Classes',
            ucfirst($template)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Register hooks
        (new $cl())->load_hooks($category);

    }

}

/**
 * The public method md_set_frontend_settings_page registers a subpage in the Frontend Settings page
 * 
 * @since 0.0.8.2
 */
md_set_frontend_settings_page(
    'frontend_settings_crm_theme',
    array(
        'page_name' => $CI->lang->line('theme_frontend_crm_theme'),
        'page_icon' => md_the_admin_icon(array('icon' => 'pages')),
        'content' => 'the_frontend_settings_crm_theme_settings',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('the_frontend_settings_crm_theme_settings') ) {

    /**
     * The function the_frontend_settings_crm_theme_settings gets the CRM theme settings
     * 
     * @return void
     */
    function the_frontend_settings_crm_theme_settings() {

        // Set the CRM Theme Admin Js
        md_set_js_urls(array(md_the_theme_uri() . 'js/admin.js'));

        // Include crm frontend settings
        md_include_component_file(md_the_theme_path() . 'contents/settings/main.php');
        
    }

}

/* End of file admin_init.php */