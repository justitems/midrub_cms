<?php
/**
 * Crm Home Page Hooks
 *
 * This file loads the class Homepage with hooks for the homepage's template
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Frontend\Themes\Collection\Crm\Core\Classes;

/*
 * Homepage registers hooks for the homepage's template
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Homepage {

    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method load_hooks registers hooks for the homepage's template
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function load_hooks() {

        /**
         * The public method md_set_contents_category_meta sets top section text for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_top_section'),
                'slug' => 'theme_top_section',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'theme_top_section_slogan',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_slogan'),
                        'label_description' => $this->CI->lang->line('theme_top_section_slogan_description'),
                        'value' => 'Universal CRM for Business'
                    ),  
                    array(
                        'slug' => 'theme_top_section_text_below_slogan',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_text_below_slogan'),
                        'label_description' => $this->CI->lang->line('theme_top_section_text_below_slogan_description'),
                        'value' => 'Get new original tools to find new clients.'
                    ),
                    array(
                        'slug' => 'theme_top_section_short_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_short_description'),
                        'label_description' => $this->CI->lang->line('theme_top_section_enter_short_description'),
                        'value' => 'The CRM provides a large number of original tools for business which could be used to find new clients for your business.'
                    ),                    
                    array(
                        'slug' => 'theme_top_section_get_started_button_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_get_started_button_text'),
                        'label_description' => $this->CI->lang->line('theme_top_section_get_started_button_text_description'),
                        'value' => 'Get Started Now'
                    ),
                    array(
                        'slug' => 'theme_top_section_get_started_button_link',
                        'type' => 'select_page',
                        'label' => $this->CI->lang->line('theme_top_section_get_started_button_link'),
                        'label_description' => $this->CI->lang->line('theme_top_section_get_started_button_link_description')
                    ),                    
                    array(
                        'slug' => 'theme_top_section_learn_more_button_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_learn_more_button_text'),
                        'label_description' => $this->CI->lang->line('theme_top_section_learn_more_button_text_description'),
                        'value' => 'Learn More'
                    ),
                    array(
                        'slug' => 'theme_top_section_learn_more_button_link',
                        'type' => 'select_page',
                        'label' => $this->CI->lang->line('theme_top_section_learn_more_button_link'),
                        'label_description' => $this->CI->lang->line('theme_top_section_learn_more_button_link_description')
                    ),
                    array(
                        'slug' => 'theme_top_section_text_below_buttons',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_text_below_buttons'),
                        'label_description' => $this->CI->lang->line('theme_top_section_text_below_buttons_description'),
                        'value' => 'No credit card required'
                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets top section video for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_top_section_video'),
                'slug' => 'theme_top_section_video',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'theme_top_section_video_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_top_section_video_enabled'),
                        'label_description' => $this->CI->lang->line('theme_top_section_video_enabled_description')
                    ),                                                   
                    array(
                        'slug' => 'theme_top_section_video_cover',
                        'type' => 'media_input',
                        'label' => $this->CI->lang->line('theme_top_section_video_cover'),
                        'label_description' => $this->CI->lang->line('theme_top_section_video_cover_description')
                    ),                    
                    array(
                        'slug' => 'theme_top_section_video_url',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_top_section_video_url'),
                        'label_description' => $this->CI->lang->line('theme_top_section_video_url_description'),
                        'value' => ''
                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets top section image for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_top_section_image'),
                'slug' => 'theme_top_section_image',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'theme_top_section_image_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_top_section_image_enabled'),
                        'label_description' => $this->CI->lang->line('theme_top_section_image_enabled_description')
                    ),                                                   
                    array(
                        'slug' => 'theme_top_section_image_url',
                        'type' => 'media_input',
                        'label' => $this->CI->lang->line('theme_top_section_image_url'),
                        'label_description' => $this->CI->lang->line('theme_top_section_image_url_description')
                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets top section image for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_home_quick_statistics'),
                'slug' => 'theme_home_statistics',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'theme_home_statistics_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_top_section_statistics_enabled'),
                        'label_description' => $this->CI->lang->line('theme_top_section_statistics_enabled_description')
                    ),                     
                    array(
                        'slug' => 'theme_home_statistics',
                        'type' => 'list_items',
                        'label' => $this->CI->lang->line('theme_home_statistics'),
                        'words' => array(
                            'new_item_text' => md_the_admin_icon(array('icon' => 'stats')) . ' ' . $this->CI->lang->line('theme_new_stats')
                        ),
                        'fields' => array(
                            array(
                                'slug' => 'theme_home_statistics_stats_value',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_home_statistics_value')
                            ),
                            array(
                                'slug' => 'theme_home_statistics_stats_description',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_home_statistics_description')
                            )                         

                        )

                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets integrations for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_integrations'),
                'slug' => 'theme_top_section_integrations',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'integrations_home_page_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_integrations_enabled'),
                        'label_description' => $this->CI->lang->line('theme_integrations_enabled_description')
                    ),                    
                    array(
                        'slug' => 'integrations_home_page_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_integrations_home_page_text'),
                        'label_description' => $this->CI->lang->line('theme_integrations_home_page_text_description'),
                        'value' => 'Get more value from your tools with our CRM'
                    ),                    
                    array(
                        'slug' => 'integrations_home_page_directory_link_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_integrations_directory_link_text'),
                        'label_description' => $this->CI->lang->line('theme_integrations_directory_link_text_description'),
                        'value' => 'See all of our integrations'
                    ),                    
                    array(
                        'slug' => 'integrations_home_page_directory_link_url',
                        'type' => 'select_page',
                        'label' => $this->CI->lang->line('theme_integrations_directory_link_url'),
                        'label_description' => $this->CI->lang->line('theme_integrations_directory_link_url_description')
                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets quick preview for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_quick_preview'),
                'slug' => 'theme_quick_preview',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'theme_quick_preview_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_quick_preview_enabled'),
                        'label_description' => $this->CI->lang->line('theme_quick_preview_enabled_description')
                    ),                    
                    array(
                        'slug' => 'quick_preview_header_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_quick_preview_header_text'),
                        'label_description' => $this->CI->lang->line('theme_quick_preview_header_text_description'),
                        'value' => 'A quick guide how to use our service'
                    ),                    
                    array(
                        'slug' => 'quick_preview_header_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_quick_preview_header_description'),
                        'label_description' => $this->CI->lang->line('theme_quick_preview_header_description_text'),
                        'value' => 'Watch how you could start to use our service'
                    ),                     
                    array(
                        'slug' => 'quick_preview_videos',
                        'type' => 'list_items',
                        'label' => $this->CI->lang->line('theme_quick_preview_videos'),
                        'words' => array(
                            'new_item_text' => md_the_admin_icon(array('icon' => 'video')) . ' ' . $this->CI->lang->line('theme_new_video')
                        ),
                        'fields' => array(
                            array(
                                'slug' => 'theme_video_title',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_quick_preview_video_title')
                            ),
                            array(
                                'slug' => 'theme_video_description',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_quick_preview_video_description')
                            ),
                            array(
                                'slug' => 'theme_video_icon',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_quick_preview_video_icon')
                            ),                            
                            array(
                                'slug' => 'theme_video_url',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_quick_preview_video_url')
                            )                         

                        )

                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets features for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_features'),
                'slug' => 'theme_features',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'features_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_features_enabled'),
                        'label_description' => $this->CI->lang->line('theme_features_enabled_description')
                    ),
                    array(
                        'slug' => 'features_section_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_features_section_title'),
                        'label_description' => $this->CI->lang->line('theme_features_section_title_description'),
                        'value' => 'CRM Features'
                    ), 
                    array(
                        'slug' => 'features_section_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_features_section_description'),
                        'label_description' => $this->CI->lang->line('theme_features_section_description_info'),
                        'value' => 'We have the riht features which could help your business to grow.'
                    ), 
                    array(
                        'slug' => 'features_section_link_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_integrations_directory_link_text'),
                        'label_description' => $this->CI->lang->line('theme_integrations_directory_link_text_description'),
                        'value' => "See all CRM's features"
                    ),                    
                    array(
                        'slug' => 'features_section_link_url',
                        'type' => 'select_page',
                        'label' => $this->CI->lang->line('theme_features_section_link_url'),
                        'label_description' => $this->CI->lang->line('theme_features_section_link_url_description')
                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets reviews model 1 for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_reviews_model_1'),
                'slug' => 'reviews_model_1',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'reviews_model_1_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_reviews_model_1_enabled'),
                        'label_description' => $this->CI->lang->line('theme_reviews_model_1_enabled_description')
                    ),
                    array(
                        'slug' => 'reviews_model_1_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_reviews_model_1_title'),
                        'label_description' => $this->CI->lang->line('theme_reviews_model_1_title_description'),
                        'value' => 'Our CRM Testimonials'
                    ),
                    array(
                        'slug' => 'reviews_model_1_reviews',
                        'type' => 'list_items',
                        'label' => $this->CI->lang->line('theme_reviews'),
                        'words' => array(
                            'new_item_text' => md_the_admin_icon(array('icon' => 'review')) . ' ' . $this->CI->lang->line('theme_new_review')
                        ),
                        'fields' => array(
                            array(
                                'slug' => 'review_author_name',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_name')
                            ),
                            array(
                                'slug' => 'review_author_position',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_position')
                            ), 
                            array(
                                'slug' => 'review_author_photo',
                                'type' => 'media_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_photo')
                            ),                                                    
                            array(
                                'slug' => 'review_author_comment',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_comment')
                            )                        

                        )

                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets reviews model 2 for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_reviews_model_2'),
                'slug' => 'reviews_model_2',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'reviews_model_2_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_reviews_model_2_enabled'),
                        'label_description' => $this->CI->lang->line('theme_reviews_model_2_enabled_description')
                    ),
                    array(
                        'slug' => 'reviews_model_2_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_reviews_model_2_title'),
                        'label_description' => $this->CI->lang->line('theme_reviews_model_2_title_description'),
                        'value' => 'Our CRM Testimonials'
                    ),
                    array(
                        'slug' => 'reviews_model_2_reviews',
                        'type' => 'list_items',
                        'label' => $this->CI->lang->line('theme_reviews'),
                        'words' => array(
                            'new_item_text' => md_the_admin_icon(array('icon' => 'review')) . ' ' . $this->CI->lang->line('theme_new_review')
                        ),
                        'fields' => array(
                            array(
                                'slug' => 'review_author_name',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_name')
                            ),
                            array(
                                'slug' => 'review_author_position',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_position')
                            ), 
                            array(
                                'slug' => 'review_author_photo',
                                'type' => 'media_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_photo')
                            ), 
                            array(
                                'slug' => 'review_author_comment',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_author_comment')
                            ), 
                            array(
                                'slug' => 'review_stars',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_reviews_stars')
                            )

                        )

                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets faq for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_faq'),
                'slug' => 'faq',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'faq_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_faq_enabled'),
                        'label_description' => $this->CI->lang->line('theme_faq_enabled_description')
                    ),
                    array(
                        'slug' => 'faq_section_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_faq_section_title'),
                        'label_description' => $this->CI->lang->line('theme_faq_section_title_description'),
                        'value' => 'Faq'
                    ), 
                    array(
                        'slug' => 'faq_section_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_faq_section_description'),
                        'label_description' => $this->CI->lang->line('theme_faq_section_description_info'),
                        'value' => 'Popular Questions and Answers'
                    ), 
                    array(
                        'slug' => 'faq_section_link_text',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_faq_section_link_text'),
                        'label_description' => $this->CI->lang->line('theme_faq_section_link_text_description'),
                        'value' => "See the CRM's FAQ Center"
                    ),                    
                    array(
                        'slug' => 'faq_section_link_url',
                        'type' => 'select_page',
                        'label' => $this->CI->lang->line('theme_faq_section_link_url'),
                        'label_description' => $this->CI->lang->line('theme_faq_section_link_url_description')
                    ),
                    array(
                        'slug' => 'faq_questions',
                        'type' => 'list_items',
                        'label' => $this->CI->lang->line('theme_questions_answers'),
                        'words' => array(
                            'new_item_text' => md_the_admin_icon(array('icon' => 'question')) . ' ' . $this->CI->lang->line('theme_new_question')
                        ),
                        'fields' => array(
                            array(
                                'slug' => 'question',
                                'type' => 'text_input',
                                'label' => $this->CI->lang->line('theme_faq_question')
                            ),
                            array(
                                'slug' => 'answer',
                                'type' => 'editor',
                                'label' => $this->CI->lang->line('theme_faq_answer')
                            )

                        )

                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets blog posts for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_posts'),
                'slug' => 'blog_posts',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'blog_posts_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_blog_posts_enabled'),
                        'label_description' => $this->CI->lang->line('theme_blog_posts_enabled_description')
                    ),
                    array(
                        'slug' => 'blog_posts_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_blog_posts_title'),
                        'label_description' => $this->CI->lang->line('theme_blog_posts_title_description'),
                        'value' => 'Latest CRM News'
                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets plans for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_plans'),
                'slug' => 'plans',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'plans_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_plans_enabled'),
                        'label_description' => $this->CI->lang->line('theme_plans_enabled_description')
                    ),
                    array(
                        'slug' => 'plans_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_plans_title'),
                        'label_description' => $this->CI->lang->line('theme_plans_title_description'),
                        'value' => 'Choose the right plan for your business'
                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

        /**
         * The public method md_set_contents_category_meta sets Newsletter form for home page
         * 
         * @since 0.0.8.5
         */
        md_set_contents_category_meta(
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_newsletter'),
                'slug' => 'newsletter',
                'template' => 'homepage',
                'fields' => array(
                    array(
                        'slug' => 'newsletter_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_newsletter_enabled'),
                        'label_description' => $this->CI->lang->line('theme_newsletter_enabled_description')
                    ),
                    array(
                        'slug' => 'newsletter_mailchimp_api_key',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_mailchimp_api_key'),
                        'label_description' => $this->CI->lang->line('theme_mailchimp_api_key_description')
                    )
                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

    }

}

/* End of file homepage.php */