<?php
/**
 * Crm Plans Page Hooks
 *
 * This file loads the class Plans with hooks for the plans's template
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Frontend\Themes\Collection\Crm\Core\Classes;

/*
 * Plans registers hooks for the plans's template
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Plans {

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
     * The public method load_hooks registers hooks for the plans's template
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
                'name' => $this->CI->lang->line('theme_text'),
                'slug' => 'plans_text',
                'template' => 'plans',
                'fields' => array(                 
                    array(
                        'slug' => 'plans_text_page_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_plans_text_page_title'),
                        'label_description' => $this->CI->lang->line('theme_plans_text_page_title_description'),
                        'value' => 'Find the right plan for you'
                    ),
                    array(
                        'slug' => 'plans_text_page_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_plans_text_page_description'),
                        'label_description' => $this->CI->lang->line('theme_plans_text_page_description_details'),
                        'value' => 'You can anytime change the select plan with several clicks'
                    ),
                    array(
                        'slug' => 'plans_text_above_plans_list',
                        'type' => 'editor',
                        'label' => $this->CI->lang->line('theme_plans_text_above_plans_list'),
                        'label_description' => $this->CI->lang->line('theme_plans_text_above_plans_list_description')
                    ),
                    array(
                        'slug' => 'plans_text_below_plans_list',
                        'type' => 'editor',
                        'label' => $this->CI->lang->line('theme_plans_text_below_plans_list'),
                        'label_description' => $this->CI->lang->line('theme_plans_text_below_plans_list_description')
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
            'theme_pages',
            array(
                'name' => $this->CI->lang->line('theme_faq'),
                'slug' => 'faq',
                'template' => 'plans',
                'fields' => array(
                    array(
                        'slug' => 'faq_enabled',
                        'type' => 'checkbox_input',
                        'label' => $this->CI->lang->line('theme_plans_faq_enabled'),
                        'label_description' => $this->CI->lang->line('theme_plans_faq_enabled_description')
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

    }

}

/* End of file plans.php */