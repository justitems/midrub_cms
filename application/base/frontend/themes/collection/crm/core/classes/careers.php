<?php
/**
 * Crm Careers Page Hooks
 *
 * This file loads the class Careers with hooks for the careers's template
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Frontend\Themes\Collection\Crm\Core\Classes;

/*
 * Careers registers hooks for the careers's template
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Careers {

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
     * The public method load_hooks registers hooks for the careers's template
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
                'slug' => 'careers_text',
                'template' => 'careers',
                'fields' => array(                 
                    array(
                        'slug' => 'careers_text_page_title',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_careers_text_page_title'),
                        'label_description' => $this->CI->lang->line('theme_careers_text_page_title_description'),
                        'value' => 'We\'re hiring!'
                    ),
                    array(
                        'slug' => 'careers_text_page_description',
                        'type' => 'text_input',
                        'label' => $this->CI->lang->line('theme_careers_text_page_description'),
                        'label_description' => $this->CI->lang->line('theme_careers_text_page_description_details'),
                        'value' => 'We are looking for talented, passionate people to build the world’s best search technology'
                    )

                ),
                'css_urls' => array(),
                'js_urls' => array()
            )

        );

    }

}

/* End of file careers.php */