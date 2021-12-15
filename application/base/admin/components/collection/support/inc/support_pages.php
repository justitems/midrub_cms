<?php
/**
 * Support Pages Inc
 *
 * PHP Version 7.2
 *
 * This files contains the support's pages
 * methods used in admin -> support
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
 * The public method md_set_support_page adds a support's page in the admin panel
 * 
 * @since 0.0.7.9
 */
md_set_support_page(
    'faq',
    array(
        'page_name' => $CI->lang->line('faq_articles'),
        'page_icon' => md_the_admin_icon(array('icon' => 'faq')),
        'content' => 'md_get_support_page_faq',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/support/styles/css/faq.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION), 'text/css', 'all'),
            array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css', 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/support/js/main.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION)),
            array('//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js')
        )  
    )
);

if ( !function_exists('md_get_support_page_faq') ) {

    /**
     * The function md_get_support_page_faq gets support's page faq content
     * 
     * @return void
     */
    function md_get_support_page_faq() {

        // Get codeigniter object instance
        $CI = &get_instance();

        if ( $CI->input->get('article', true) ) {

            // Require the Categories Inc
            require_once CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'inc/categories.php';

            // Require the Articles Inc
            require_once CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'inc/articles.php';
            
            // Try to add the article in the queue if exists
            set_faq_article_data();

            // Include article view for user
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/article.php');

        } else {

            // Include articles view for user
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/articles.php');

        }
        
    }

}

/**
 * The public method md_set_support_page adds a support's page in the admin panel
 * 
 * @since 0.0.7.9
 */
md_set_support_page(
    'tickets',
    array(
        'page_name' => $CI->lang->line('tickets'),
        'page_icon' => md_the_admin_icon(array('icon' => 'tickets')),
        'content' => 'md_get_support_page_tickets',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/support/styles/css/tickets.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/support/js/tickets.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SUPPORT_VERSION))
        )  
    )
);

if ( !function_exists('md_get_support_page_tickets') ) {

    /**
     * The function md_get_support_page_tickets gets support's page tickets content
     * 
     * @return void
     */
    function md_get_support_page_tickets() {

        // Get codeigniter object instance
        $CI = &get_instance();

        if ( $CI->input->get('ticket', true) ) {

            // Require the Tickets Inc
            require_once CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'inc/tickets.php';

            // Try to add the ticket in the queue if exists
            set_ticket_data();

            // Verify if ticket exists
            if ( md_the_data('support_single_ticket') ) {

                // Include ticket view for user
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/ticket.php');   

            } else {

                echo $CI->lang->line('ticket_not_found');

            }         

        } else {

            // Include tickets view for user
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'views/tickets.php');

        }
        
    }

}