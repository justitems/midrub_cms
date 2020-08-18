<?php
/**
 * Tickets Inc
 *
 * PHP Version 7.2
 *
 * This files contains the tickets functions
 * used for tickets
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('set_ticket_data') ) {

    /**
     * The function set_ticket_data sets ticket's data
     * 
     * @return void
     */
    function set_ticket_data() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if ticket's ID is numeric
        if ( is_numeric( $CI->input->get('ticket', true) ) ) {

            // Get ticket
            $ticket = $CI->tickets_model->get_ticket($CI->input->get('ticket', true));

            // If ticket exists will be added ticket in the queue
            if ( $ticket ) {

                // Add the ticket in the queue
                md_set_component_variable('support_single_ticket', $ticket);

                // Get ticket's replies
                $replies = $CI->tickets_model->get_ticket_replies($CI->input->get('ticket', true));

                // Verify if the ticket has replies
                if ( $replies ) {

                    // Add the ticket's replies in the queue
                    md_set_component_variable('support_single_ticket_replies', $replies);
                
                }

            }

        }
        
    }

}

if ( !function_exists('the_ticket_author_id') ) {

    /**
     * The function the_ticket_author_id returns the ticket's author id
     * 
     * @return integer with author's ID or boolean false
     */
    function the_ticket_author_id() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['user_id'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_author_username') ) {

    /**
     * The function the_ticket_author_username returns the ticket's author username
     * 
     * @return integer with author's username or boolean false
     */
    function the_ticket_author_username() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['username'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_id') ) {

    /**
     * The function the_ticket_id returns the ticket's id
     * 
     * @return integer with ticket's ID or boolean false
     */
    function the_ticket_id() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['ticket_id'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_status') ) {

    /**
     * The function the_ticket_status returns the ticket's status
     * 
     * @return integer with ticket's status or boolean false
     */
    function the_ticket_status() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['status'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_subject') ) {

    /**
     * The function the_ticket_subject returns the ticket's subject
     * 
     * @return string with ticket's subject or boolean false
     */
    function the_ticket_subject() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['subject'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_body') ) {

    /**
     * The function the_ticket_body returns the ticket's body
     * 
     * @return string with ticket's body or boolean false
     */
    function the_ticket_body() {

        // Get ticket
        $ticket = md_the_component_variable('support_single_ticket');

        // Verify if ticket exists
        if ( $ticket ) {
            return $ticket[0]['body'];
        } else {
            return false;
        }
        
    }

}

if ( !function_exists('the_ticket_replies') ) {

    /**
     * The function the_ticket_replies returns the ticket's replies
     * 
     * @return array with ticket's replies or boolean false
     */
    function the_ticket_replies() {

        // Get ticket's replies
        $replies = md_the_component_variable('support_single_ticket_replies');

        // Verify if ticket has replies
        if ( $replies ) {
            return $replies;
        } else {
            return false;
        }
        
    }

}