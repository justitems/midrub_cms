<?php
/**
 * Ajax Controller
 *
 * This file processes the app's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Faq\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\User\Components\Collection\Faq\Helpers as MidrubBaseUserComponentsCollectionFaqHelpers;

/*
 * Ajaz class processes the app's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'faq_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_FAQ );

        // Load the Faq Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_FAQ . 'models/', 'Faq_model', 'faq_model' );
        
    }

    /**
     * The public method load_ticket_replies loads the tickets replies
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_ticket_replies() {
        
        // Loads the tickets replies
        (new MidrubBaseUserComponentsCollectionFaqHelpers\Tickets)->load_ticket_replies();
        
    } 

    /**
     * The public method set_ticket_status changes the ticket's status
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_ticket_status() {
        
        // Change the ticket status
        (new MidrubBaseUserComponentsCollectionFaqHelpers\Tickets)->set_ticket_status();
        
    } 

    /**
     * The public method create_new_ticket creates a new ticket
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_new_ticket() {
        
        // Create a new Ticket
        (new MidrubBaseUserComponentsCollectionFaqHelpers\Tickets)->create_new_ticket();
        
    }

    /**
     * The public method create_ticket_reply creates a ticket's reply
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_ticket_reply() {
        
        // Create a new Ticket's reply
        (new MidrubBaseUserComponentsCollectionFaqHelpers\Tickets)->create_ticket_reply();
        
    }

    /**
     * The public method load_faq_articles_by_search gets articles by search
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_faq_articles_by_search() {
        
        // Gets articles
        (new MidrubBaseUserComponentsCollectionFaqHelpers\Faq)->load_faq_articles_by_search();
        
    } 
    
}
