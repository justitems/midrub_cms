<?php
/**
 * Tickets Helper
 *
 * This file contains the class Tickets
 * with methods to manage the tickets
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Faq\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Tickets class provides the methods to manage the tickets
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Tickets {
    
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

        // Load the Tickets Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_FAQ . 'models/', 'Tickets_model', 'tickets_model' );

    }

    /**
     * The public method load_ticket_replies returns all ticket's replies
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_ticket_replies() {
        
        // Get ticket_id's input
        $ticket_id = $this->CI->input->get('ticket_id');
        
        // Verify if the user is admin
        if ( $this->CI->user_role != 1 ) {
        
            // Verify if user is the creator of this ticket
            if ( !$this->CI->tickets_model->get_ticket($this->CI->user_id, $ticket_id) ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_replies_found')
                );

                echo json_encode($data);  
                exit();

            }
            
        }
        
        // Gets ticket's replies
        $replies = $this->CI->tickets_model->get_metas($ticket_id);   
        
        if ( $replies ) {
            
            $data = array(
                'success' => TRUE,
                'content' => $replies,
                'cdate' => time()
            );

            echo json_encode($data);            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('no_replies_found')
            );

            echo json_encode($data);             
            
        }
        
    }

    /**
     * The public method set_ticket_status changes the ticket's status
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function set_ticket_status() {
        
        // Get ticket_id's input
        $ticket_id = $this->CI->input->get('ticket_id');  
        
        // Get status's input
        $status = (int)$this->CI->input->get('status');          
        
        // Load language
        $this->CI->lang->load( 'default_tickets', $this->CI->config->item('language') );
        
        // Verify if status is valid
        if ( ($status !== 1) && ($status !== 0) ) {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('mm3')
            );

            echo json_encode($data);  
            exit();

        }        
        
        // Change the ticket's status
        $response = $this->CI->tickets_model->ticket_update($ticket_id, 'status', $status);        
        
        if ( $response ) {
            
            if ( $status === 1 ) {
                
                $new_status = $this->CI->lang->line('active');
                
            } else {
                
                $new_status = $this->CI->lang->line('closed');
                
            }
            
            $data = array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('ticket_status_was_changed'),
                'status' => $new_status
            );

            echo json_encode($data);            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('ticket_status_was_not_changed')
            );

            echo json_encode($data);             
            
        }
        
    }

    /**
     * The public method create_new_ticket creates a new ticket
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function create_new_ticket() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $this->CI->form_validation->set_rules('body', 'Body', 'trim');
            
            // Get data
            $subject = $this->CI->input->post('subject');
            $body = $this->CI->input->post('body');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                // Verify when was saved the last ticket
                $last_ticket = $this->CI->tickets_model->last_ticket($this->CI->user_id);
                
                if ( $last_ticket ) {
                    
                    $limit = 24;
                    // Verify if admin had changed the default limit
                    $verify = get_option('tickets_limit');
                    
                    if($verify) {
                        
                        $limit = $verify;
                        
                    }
                    
                    if ( ($last_ticket + $limit * 3600) > time() ) {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('you_can_open_one_ticket') . ' ' . $limit . ' ' . $this->CI->lang->line('mm107')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }
                    
                }
                
                // Verify if tickets are enabled
                if ( get_option('disable-tickets') ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('creation_new_tickets_restricted')
                    );

                    echo json_encode($data);
                    exit();
                    
                }
                
                $create = $this->CI->tickets_model->save_ticket($this->CI->user_id, $subject, $body);
                
                if ( $create ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('ticket_was_created'),
                        'ticket_id' => $create
                    );

                    echo json_encode($data);
                    exit();
                    
                }
                
            }
            
        }    
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('ticket_was_not_created')
        );

        echo json_encode($data);
        
    }

    /**
     * The public method create_ticket_reply creates a ticket's reply
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function create_ticket_reply() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('body', 'Body', 'trim|required');
            $this->CI->form_validation->set_rules('ticket_id', 'Ticket ID', 'trim|integer|required');
            
            // Get data
            $body = $this->CI->input->post('body');
            $ticket_id = $this->CI->input->post('ticket_id');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                // Verify if the user is admin
                $get_ticket = $this->CI->tickets_model->get_ticket($this->CI->user_id, $ticket_id);
                
                // Verify if user is the creator of this ticket
                if ( $get_ticket ) {
                    
                    // Verify if the user is admin
                    if ( $this->CI->user_role != 1 ) {
                    
                        if ( (int)$get_ticket[0]->status < 1 ) {

                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('ticket_is_closed')
                            );

                            echo json_encode($data);
                            exit();

                        }
                        
                    }

                    // Save new ticket's reply
                    $create = $this->CI->tickets_model->save_reply($this->CI->user_id, $ticket_id, $body);

                    // Verify if the ticket's reply was saved 
                    if ( $create ) {
                        
                        // Verify if the user is admin
                        if ( $this->CI->user_role != 1 ) {

                            $this->CI->tickets_model->ticket_update($ticket_id, 'status', 1);  

                        } else {

                            $this->CI->tickets_model->ticket_update($ticket_id, 'status', 2);  

                        }                        

                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('reply_was_saved')
                        );

                        echo json_encode($data);
                        exit();

                    }
                
                }
                
            }
            
        }    
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('reply_was_not_saved')
        );

        echo json_encode($data);
        
    }

}

/* End of file tickets.php */