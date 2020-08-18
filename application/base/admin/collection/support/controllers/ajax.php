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
namespace MidrubBase\Admin\Collection\Support\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Admin\Collection\Support\Helpers as MidrubBaseAdminCollectionSupportHelpers;

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
        $this->CI->lang->load( 'support', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SUPPORT);

        // Load the Faq Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SUPPORT . 'models/', 'Faq_model', 'faq_model' );

        // Load the Tickets Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SUPPORT . 'models/', 'Tickets_model', 'tickets_model' );

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
        (new MidrubBaseAdminCollectionSupportHelpers\Faq)->load_all_faq_articles();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Faq)->delete_faq_articles();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Faq)->create_new_faq_article();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Categories)->load_all_faq_categories();
        
    }

    /**
     * The public method load_all_parent_faq_categories loads all Parents Faq's Categories
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_all_parent_faq_categories() {
        
        // Load Parents Faq's Categories
        (new MidrubBaseAdminCollectionSupportHelpers\Categories)->load_all_parent_faq_categories();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Categories)->refresh_categories_list();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Categories)->create_category();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Categories)->delete_category();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->load_tickets();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->delete_tickets();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->close_ticket();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->load_ticket_replies();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->create_ticket_reply();
        
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
        (new MidrubBaseAdminCollectionSupportHelpers\Tickets)->set_ticket_status();
        
    }

}

/* End of file ajax.php */