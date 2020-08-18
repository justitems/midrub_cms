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
$CI =& get_instance();

/**
 * The public method md_set_contents_category sets the Auth contents category
 * 
 * @since 0.0.7.8
 */
md_set_contents_category(
    'auth',
    array(
        'category_name' => $CI->lang->line('frontend_members_access'),
        'category_icon' => '<i class="icon-login"></i>',
        'editor' => true,
        'slug_in_url' => true,
        'words_list' => array(
            'new_content' => $CI->lang->line('frontend_new_page'),
            'search_content' => $CI->lang->line('frontend_search_pages'),
            'enter_content_title' => $CI->lang->line('frontend_enter_page_title')
        )
    )
);

/**
 * The public method md_set_contents_category_option sets option for the Auth contents category
 * 
 * @since 0.0.7.8
 */
md_set_contents_category_option(
    'auth',
    array(
        'name' => $CI->lang->line('frontend_set_auth_components'),
        'slug' => 'auth_components',
        'fields' => array(
            array(
                'slug' => 'auth_components',
                'type' => 'auth_components',
                'label' => $CI->lang->line('frontend_selected_auth_component'),
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
 * The public method md_set_contents_category_meta sets meta for the Auth contents category
 * 
 * @since 0.0.7.8
 */
md_set_contents_category_meta(
    'auth',
    array(
        'name' => $CI->lang->line('frontend_contents_quick_seo'),
        'slug' => 'quick_seo',
        'fields' => array(
            array(
                'slug' => 'quick_seo_page_title',
                'type' => 'text_input',
                'label' => $CI->lang->line('frontend_contents_page_title'),
                'label_description' => $CI->lang->line('frontend_contents_page_description')
            ), array(
                'slug' => 'quick_seo_meta_description',
                'type' => 'text_input',
                'label' => $CI->lang->line('frontend_contents_meta_description'),
                'label_description' => $CI->lang->line('frontend_contents_meta_description_info')
            ), array(
                'slug' => 'quick_seo_meta_keywords',
                'type' => 'text_input',
                'label' => $CI->lang->line('frontend_contents_meta_keywords'),
                'label_description' => $CI->lang->line('frontend_contents_meta_keywords_info')                
            )            
        ),
        'css_urls' => array(
        ),
        'js_urls' => array(
        )        
    )    
);

if ( !function_exists('md_the_contents_category_word') ) {

    /**
     * The function md_the_contents_category_word returns the contents category word if exists
     * 
     * @param string $word_key contains the word's key 
     * 
     * @return string with requested word or boolean false
     */
    function md_the_contents_category_word( $word_key ) {
        
        // Verify if word key exists
        if ( isset(md_the_component_variable('contents_category')['words_list'][$word_key]) ) {

            return md_the_component_variable('contents_category')['words_list'][$word_key];

        } else {

            return false;

        }
        
    }

}

if ( !function_exists('md_get_contents_category_word') ) {

    /**
     * The function md_get_contents_category_word gets the contents category word if exists
     * 
     * @param string $word_key contains the word's key 
     * 
     * @return void
     */
    function md_get_contents_category_word( $word_key ) {
        
        // Verify if word key exists
        if ( md_the_contents_category_word($word_key) ) {

            echo md_the_contents_category_word($word_key);

        }
        
    }

}

if ( !function_exists('md_get_contents_category_field') ) {

    /**
     * The function md_get_contents_category_field gets contents category field slug if exists
     * 
     * @param string $field contains the category's field
     * 
     * @return string with category's field value or boolean false
     */
    function md_get_contents_category_field( $field ) {

        // Get contents category array
        $contents_category = md_the_contents_categories();

        if ( $contents_category ) {

            // Get the category value
            $category = array_values($contents_category[0]);

            // Get category slug
            $category_slug = array_keys($contents_category[0]);

        }
        
    }

}

if ( !function_exists('md_update_contents_meta') ) {

    /**
     * The function md_update_contents_meta updates content meta
     * 
     * @param integer $content_id contains the content's id
     * @param string $meta_name contains the meta's name
     * @param string $meta_value contains the meta's value
     * 
     * @return boolean true or false
     */
    function md_update_contents_meta( $content_id, $meta_name, $meta_value ) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load Frontend Contents Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

        // Save the content meta
        if ($CI->base_contents->save_content_meta($content_id, '', $meta_name, $meta_value, '', '')) {
            return true;
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('md_delete_content_meta') ) {

    /**
     * The function md_delete_content_meta deletes contents meta
     * 
     * @param integer $content_id contains the content's id
     * @param string $meta_name contains the meta's name
     * 
     * @return boolean true or false
     */
    function md_delete_content_meta( $content_id=0, $meta_name ) {

        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load Base Contents Model
        $CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_contents', 'base_contents' );

        // Save the content meta
        if ( $CI->base_contents->delete_content_meta($content_id, $meta_name) ) {
            return true;
        } else {
            return false;
        }
        
    }

}