<?php
/**
 * User Controller
 *
 * This file loads the Faq Component in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Faq\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the Faq Component loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI, $css_urls_widgets = array(), $js_urls_widgets = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load language
        $this->CI->lang->load( 'faq_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_FAQ );

        // Load the Faq Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_FAQ . 'models/', 'Faq_model', 'faq_model' );

        // Load the Tickets Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_FAQ . 'models/', 'Tickets_model', 'tickets_model' );
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set the Faq's styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/components/collection/faq/styles/css/styles.css?ver=' . MIDRUB_BASE_USER_COMPONENTS_FAQ_VERSION), 'text/css', 'all'));
        
        // Set the Main Faq Js
        set_js_urls(array(base_url('assets/base/user/components/collection/faq/js/main.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_FAQ_VERSION)));
        
        // Prepare view
        $this->set_user_view();
        
    }

    /**
     * The private method set_user_view sets user view
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    private function set_user_view() {

        // Verify if single page exists
        if ( $this->CI->input->get('p', TRUE) ) {

            switch ( $this->CI->input->get('p', TRUE) ) {

                case 'categories':

                    // Get the category's ID
                    $category_id = $this->CI->input->get('category', TRUE);

                    if ( !is_numeric($category_id) ) {
                        show_404();
                    }

                    // Get current user's language
                    $language = $this->CI->config->item('language');

                    // Get category's data
                    $category = $this->CI->faq_model->get_category_meta($category_id, $language);

                    // Verify if category exists
                    if (!$category) {
                        show_404();
                    }

                    // Gets all articles by category
                    $articles = $this->CI->faq_model->get_faq_articles_by_category($category_id);

                    // Get all categories
                    $categories = $this->CI->faq_model->get_categories();

                    // Prepare view params
                    $params = array(
                        'categories' => $categories,
                        'category_id' => $category_id,
                        'parent' => $category[0]->parent,
                        'articles' => $articles
                    );

                    // Set views params
                    set_user_view(
                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views',
                            'faq-categories',
                            $params,
                            true
                        )
                    );

                    break;

                case 'articles':

                    // Get the article's ID
                    $article_id = $this->CI->input->get('article', TRUE);

                    // Get the faq article
                    $article = $this->CI->faq_model->get_faq_article($article_id);

                    if (!$article) {

                        show_404();
                    }

                    // Get current user's language
                    $language = $this->CI->config->item('language');

                    $category_id = 0;

                    if (isset($article['categories'][0])) {

                        $category_id = $article['categories'][0];
                    }

                    // Get all categories
                    $categories = $this->CI->faq_model->get_categories();

                    // Get category's data
                    $category = $this->CI->faq_model->get_category_meta($category_id, $language);

                    $parent = 0;

                    if ($category) {

                        $parent = $category[0]->parent;
                    }

                    // Prepare view params
                    $params = array(
                        'categories' => $categories,
                        'article' => $article,
                        'category_id' => $category_id,
                        'parent' => $parent
                    );

                    // Set views params
                    set_user_view(
                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views',
                            'single-faq-article',
                            $params,
                            true
                        )
                    );

                    break;

                    case 'tickets':

                    // Get the ticket's ID
                    $ticket_id = $this->CI->input->get('ticket', TRUE);

                    // Verify if the ticket exists and if the user is the owner of the ticket
                    $ticket = $this->CI->tickets_model->get_ticket($this->CI->user_id, $ticket_id);

                    // Get last tickets
                    $tickets = $this->CI->tickets_model->get_all_tickets(0, $this->CI->user_id, 0, 10);

                    // Verify if the ticket exists
                    if (!$ticket) {
                        show_404();
                    }

                    // Gets ticket's meta
                    $metas = $this->CI->tickets_model->get_metas($ticket_id);

                    // Prepare view params
                    $params = array(
                        'ticket' => $ticket,
                        'id' => $ticket_id,
                        'metas' => $metas,
                        'tickets' => $tickets
                    );

                    // Set views params
                    set_user_view(
                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views',
                            'single-ticket',
                            $params,
                            true
                        )
                    );

                    break;

                default:

                    show_404();

                    break;

            }

        } else {

            // Get all categories
            $categories = $this->CI->faq_model->get_categories();

            // Prepare view params
            $params = array(
                'categories' => $categories
            );

            // Set views params
            set_user_view(
                $this->CI->load->ext_view(
                    MIDRUB_BASE_USER_COMPONENTS_FAQ . 'views',
                    'main',
                    $params,
                    true
                )
            );

        }

    }
    
}
