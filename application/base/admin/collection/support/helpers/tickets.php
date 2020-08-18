<?php
/**
 * Tickets Helper
 *
 * This file contains the class Tickets
 * with methods to manage the user's tickets
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Support\Helpers;

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Tickets class provides the methods to manage the user's tickets
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Tickets
{

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
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();

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
                
                // Get the ticket by id
                $get_ticket = $this->CI->tickets_model->get_ticket($ticket_id);
                
                // Verify if ticket exissts
                if ( $get_ticket ) {

                    // Verify if the ticket is closed
                    if ( !$get_ticket[0]['status'] ) {

                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('ticket_is_closed')
                        );

                        echo json_encode($data);
                        exit();

                    }

                    // Save new ticket's reply
                    $create = $this->CI->tickets_model->save_reply($this->CI->user_id, $ticket_id, $body);

                    // Verify if the ticket's reply was saved 
                    if ( $create ) {
                        
                        // Verify if the user is admin
                        $this->CI->tickets_model->ticket_update($ticket_id, 'status', 2);                  

                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('reply_was_saved')
                        );

                        echo json_encode($data);

                    }
                
                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ticket_not_found')
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
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

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('ticket_id', 'Ticket ID', 'trim|integer|required');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            
            // Get data
            $ticket_id = $this->CI->input->post('ticket_id');
            $status = $this->CI->input->post('status');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                // Get the ticket by id
                $get_ticket = $this->CI->tickets_model->get_ticket($ticket_id);
                
                // Verify if ticket exissts
                if ( $get_ticket ) {

                    // Change the ticket's status
                    $response = $this->CI->tickets_model->ticket_update($ticket_id, 'status', $status);

                    if ($response) {

                        if ($status === 1) {

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
                
                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ticket_not_found')
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }

    }

    /**
     * The public method load_tickets loads tickets
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_tickets() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|integer|required');
            
            // Get post data
            $key = $this->CI->input->post('key');
            $page = $this->CI->input->post('page');

            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_tickets_found')
                );

                echo json_encode($data);

            } else {

                // Set the limit
                $limit = 10;
                $page--;
                
                // Get tickets by page
                $tickets = $this->CI->tickets_model->get_all_tickets( $key, $page * $limit, $limit );
                
                // Get total tickets
                $total_tickets = $this->CI->tickets_model->get_all_tickets($key);
                
                if ( $tickets ) {
                
                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'tickets' => $tickets,
                        'total' => $total_tickets,
                        'page' => ($page + 1),
                        'words' => array(
                            'answered' => strtolower($this->CI->lang->line('answered')),
                            'unanswered' => strtolower($this->CI->lang->line('unanswered')),
                            'closed' => strtolower($this->CI->lang->line('closed')),
                            'close' => strtolower($this->CI->lang->line('close'))
                        )
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_tickets_found')
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }

    }

    /**
     * The public method load_ticket_replies loads ticket's replies
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_ticket_replies() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('ticket_id', 'Ticket ID', 'trim|integer|required');
            
            $ticket_id = $this->CI->input->post('ticket_id');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Gets ticket's replies
                $replies = $this->CI->tickets_model->get_ticket_replies($ticket_id);

                if ($replies) {

                    $data = array(
                        'success' => TRUE,
                        'content' => $replies,
                        'cdate' => time()
                    );

                    echo json_encode($data);

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ticket_no_replies_found')
                    );

                    echo json_encode($data);

                }

            }

        }

    }

    /**
     * The public method delete_tickets deletes Tickets
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function delete_tickets() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('tickets', 'Tickets', 'trim');
            
            $tickets = $this->CI->input->post('tickets');

            if ( !$tickets ) {
                    
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('please_select_one_ticket')
                );

                echo json_encode($data); 
                exit();
                
            }

            

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                $count = 0;

                foreach ( $tickets as $ticket ) {

                    if ( is_numeric($ticket) ) {

                        if ( $this->CI->tickets_model->delete_ticket($ticket) ) {
                            $count++;
                        }

                    }

                }
                
                if ( $count > 0 ) {

                    $message = $this->CI->lang->line('ticket_was_deleted');
                    
                    if ( $count > 1 ) {
                        $message = $this->CI->lang->line('ticket_were_deleted');
                    }

                    $data = array(
                        'success' => TRUE,
                        'message' => $message
                    );

                    echo json_encode($data);                     
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ticket_was_not_deleted')
                    );

                    echo json_encode($data); 
                    
                }
                
            }
            
        }

    }

    /**
     * The public method close_ticket closes Ticket
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function close_ticket() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('ticket_id', 'Ticket ID', 'trim|integer|required');
            
            $ticket_id = $this->CI->input->post('ticket_id');

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                // Close tickets
                $close_ticket = $this->CI->tickets_model->ticket_update($ticket_id, 'status', '0');
                
                // Verify if the ticket was closed
                if ( $close_ticket ) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('ticket_was_closed')
                    );

                    echo json_encode($data);                     
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('ticket_was_not_closed')
                    );

                    echo json_encode($data); 
                    
                }
                
            }
            
        }

    }

}

/* End of file tickets.php */
