<?php
/**
 * Ajax Controller
 *
 * This file processes the Support's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Support\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Components\Collection\Support\Helpers as CmsBaseAdminComponentsCollectionSupportHelpers;

/*
 * Ajax class processes the admin component's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the component's language files
        $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SUPPORT);

        // Load the Faq Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'models/', 'Faq_model', 'faq_model' );

        // Load the Tickets Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_SUPPORT . 'models/', 'Tickets_model', 'tickets_model' );

    }
    
    /**
     * The public method load_all_faq_articles loads all Faq's Articles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_all_faq_articles() {
        
        // Load Faq Articles
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Faq)->load_all_faq_articles();
        
    }

    /**
     * The public method delete_faq_articles deletes Faq's Articles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_faq_articles() {
        
        // Delete Faq Articles
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Faq)->delete_faq_articles();
        
    }

    /**
     * The public method create_new_faq_article create Faq's Article
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_new_faq_article() {
        
        // Create Faq Article
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Faq)->create_new_faq_article();
        
    }

    /**
     * The public method load_all_faq_categories loads all Faq's Categories
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_all_faq_categories() {
        
        // Load Faq's Categories
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Categories)->load_all_faq_categories();
        
    }

    /**
     * The public method support_get_categories_parents gets all Parents Faq's Categories
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function support_get_categories_parents() {
        
        // Get Parents Faq's Categories
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Categories)->support_get_categories_parents();
        
    }

    /**
     * The public method refresh_categories_list loads categories for the Faq's article
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function refresh_categories_list() {
        
        // Load Faq's Categories
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Categories)->refresh_categories_list();
        
    }

    /**
     * The public method create_category creates a category
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_category() {
        
        // Create category
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Categories)->create_category();
        
    }

    /**
     * The public method delete_category deletes a category
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_category() {
        
        // Delete category
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Categories)->delete_category();
        
    }

    /**
     * The public method load_tickets loads tickets
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_tickets() {
        
        // Load tickets by page
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->load_tickets();
        
    }

    /**
     * The public method delete_tickets deletes tickets
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_tickets() {
        
        // Delete tickets
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->delete_tickets();
        
    }

    /**
     * The public method close_ticket closes tickets
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function close_ticket() {
        
        // Close tickets
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->close_ticket();
        
    }

    /**
     * The public method load_ticket_replies gets ticket's replies
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_ticket_replies() {
        
        // Load ticket's replies
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->load_ticket_replies();
        
    }

    /**
     * The public method create_ticket_reply creates a ticket's reply
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_ticket_reply() {
        
        // Create ticket's reply
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->create_ticket_reply();
        
    }

    /**
     * The public method set_ticket_status changes the ticket's status
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_ticket_status() {
        
        // Changes the ticket's status
        (new CmsBaseAdminComponentsCollectionSupportHelpers\Tickets)->set_ticket_status();
        
    }

}

/* End of file ajax.php */