<?php
/**
 * Articles Inc
 *
 * PHP Version 7.2
 *
 * This files contains the articles functions
 * used in faq's articles
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('set_faq_article_data') ) {

    /**
     * The function set_faq_article_data sets article's data
     * 
     * @return void
     */
    function set_faq_article_data() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if article's ID is numeric
        if ( is_numeric( $CI->input->get('article', true) ) ) {

            // Get article
            $article = $CI->faq_model->get_faq_article($CI->input->get('article', true));

            // If article exists will be added article in the queue if no, user will see empty create article composer
            if ( $article ) {

                // Add the article in the queue
                md_set_component_variable('support_faq_article', $article);

            }

        }
        
    }

}

if ( !function_exists('the_faq_article_id') ) {

    /**
     * The function the_faq_article_id returns the faq article's id
     * 
     * @return integer with article id or 0
     */
    function the_faq_article_id() {

        // Get article
        $article = md_the_component_variable('support_faq_article');

        // Verify if article exists
        if ( $article ) {
            return $article['article'][0]->article_id;
        } else {
            return '0';
        }
        
    }

}

if ( !function_exists('the_faq_article_title') ) {

    /**
     * The function the_faq_article_title returns the faq article's title
     * 
     * @param string $lang contains the requested language
     * 
     * @return string with faq article's title
     */
    function the_faq_article_title($lang) {

        // Get article
        $article = md_the_component_variable('support_faq_article');

        // Verify if article exists
        if ( $article ) {
            return isset($article['data'][$lang]['title'])?$article['data'][$lang]['title']:'';
        } else {
            return '';
        }
        
    }

}

if ( !function_exists('the_faq_article_body') ) {

    /**
     * The function the_faq_article_body returns the faq article's body
     * 
     * @param string $lang contains the requested language
     * 
     * @return string with faq article's body
     */
    function the_faq_article_body($lang) {

        // Get article
        $article = md_the_component_variable('support_faq_article');

        // Verify if article exists
        if ( $article ) {
            return isset($article['data'][$lang]['body'])?$article['data'][$lang]['body']:'';
        } else {
            return '';
        }
        
    }

}

if ( !function_exists('the_faq_article_category') ) {

    /**
     * The function the_faq_article_category verifies if an article has category
     * 
     * @param integer $category_id contains the category's ID
     * 
     * @return boolean true or false
     */
    function the_faq_article_category($category_id) {

        // Get article
        $article = md_the_component_variable('support_faq_article');

        // Verify if the article exists
        if ( !$article ) {
            return false;
        }

        // Verify if the article has the category
        if ( in_array($category_id, $article['categories']) ) {
            return true;
        } else {
            return false;
        }
        
    }

}