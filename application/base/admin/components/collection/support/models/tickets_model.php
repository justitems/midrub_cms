<?php
/**
 * Tickets Model
 *
 * PHP Version 7.2
 *
 * Tickets_model file contains the Tickets Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Email as CmsBaseClassesEmail;

/**
 * Tickets_model class - operates the tickets table
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Tickets_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'tickets';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        $tickets = $this->db->list_fields('tickets');
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

    /**
     * The public method save_reply saves a ticket's reply in the database
     *
     * @param integer $user_id contains the user_id
     * @param integer $ticket_id contains the ticket's subject
     * @param string $body contains the ticket's body
     * 
     * @return boolean true or false
     */
    public function save_reply( $user_id, $ticket_id, $body ) {
        
        // Prepare the reply
        $data = array(
            'ticket_id' => $ticket_id,
            'body' => $body,
            'created' => time()
        );
            
        // Set user's ID
        $data['user_id'] = $user_id;
        
        // Save reply
        $this->db->insert('tickets_meta', $data);
        
        // Verify if the reply was saved
        if ( $this->db->affected_rows() ) {
            
            // Get information about the ticket
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where(array('ticket_id' => $ticket_id));

            // Ticket
            $ticket = $this->db->get();
            
            // Verify if the ticket exists
            if ( $ticket->num_rows() > 0 ) {
                
                // Get ticket's data
                $ticket_data = $ticket->result_array();
                
                // Verify if user wants notifications about tickets
                if ( md_the_user_option($ticket_data[0]['user_id'], 'notification_tickets') ) {

                    // Get information about the ticket's author
                    $this->db->select('*');
                    $this->db->from('users');
                    $this->db->where(array('user_id' => $ticket_data[0]['user_id']));

                    // User
                    $user = $this->db->get();
                    
                    // Verify if the user exists
                    if ( $user->num_rows() > 0 ) {
                        
                        // Get user's data
                        $user_data = $user->result_array();

                        // Placeholders
                        $placeholders = array('[username]', '[first_name]', '[last_name]', '[website_name]', '[login_url]', '[website_url]');

                        // Set first name
                        $first_name = isset($user_data[0]['first_name'])?$user_data[0]['first_name']:'';
            
                        // Set last name
                        $last_name = isset($user_data[0]['last_name'])?$user_data[0]['last_name']:'';

                        // Replacers
                        $replacers = array(
                            $user_data[0]['username'],
                            $first_name,
                            $last_name,
                            $this->config->item('site_name'),
                            md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin'),
                            site_url()
                        );

                        // Default subject
                        $subject = $this->lang->line('ticket_notification_ticket_reply_title');

                        // Default body
                        $body = $this->lang->line('ticket_notification_ticket_reply_description');

                        // Get ticket's reply template
                        $ticket_reply = the_admin_notifications_email_template('support_ticket_reply_notification', $this->config->item('language'));

                        // Verify if $ticket_reply exists
                        if ( $ticket_reply ) {

                            // New subject
                            $subject = $ticket_reply[0]['template_title'];

                            // New body
                            $body = $ticket_reply[0]['template_body'];

                        }

                        // Create email
                        $email_args = array(
                            'from_name' => $this->config->item('site_name'),
                            'from_email' => $this->config->item('contact_mail'),
                            'to_email' => $user_data[0]['email'],
                            'subject' => str_replace($placeholders, $replacers, $subject),
                            'body' => str_replace($placeholders, $replacers, $body)
                        );

                        // Send notification template
                        (new CmsBaseClassesEmail\Send())->send_mail($email_args);

                    }
                    
                }
                
            }
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method ticket_update updates a ticket's columns
     *
     * @param integer $ticket_id contains the ticket_id
     * @param string $key contains the table's column
     * @param string $value contains the column's value
     * 
     * @return boolean true or false
     */
    public function ticket_update( $ticket_id, $key, $value ) {
        
        // Set data
        $data = array(
            $key => $value
        );
        
        $this->db->where('ticket_id', $ticket_id);
        $this->db->update($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    } 

    /**
     * The public method get_all_tickets gets all tickets
     *
     * @param string $key contains the search's key
     * @param integer $start contains the current page
     * @param integer $limit contains the number of tickets
     * 
     * @return object with all tickets or false
     */
    public function get_all_tickets( $key = NULL, $start=0, $limit=0 ) {
        
        $this->db->select('tickets.ticket_id,tickets.user_id,tickets.subject,tickets.status,users.username');
        $this->db->from($this->table);
        $this->db->join('users', 'tickets.user_id=users.user_id', 'left');

        if ( $key ) {

            $key = $this->db->escape_like_str($key);
            $this->db->like('tickets.subject', $key);

        }
        
        if ( $limit ) {
            
            $this->db->limit($limit, $start);
        
        }
        
        $this->db->order_by('tickets.ticket_id', 'desc');
        $query = $this->db->get();
        
        // If $limit is null will return number of rows
        if ( !$limit ) {
            
            return $query->num_rows();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_ticket gets ticket's data
     *
     * @param integer $ticket_id contains the ticket_id
     * 
     * @return object with the ticket or false
     */
    public function get_ticket( $ticket_id ) {
        
        // First we check if the ticket exists
        $this->db->select('tickets.ticket_id, tickets.subject, tickets.body, tickets.status, tickets.created, users.user_id, users.username');
        $this->db->from($this->table);
        $this->db->join('users', 'tickets.user_id=users.user_id', 'left');
        $this->db->where(
            array(
                'ticket_id' => $ticket_id
            )
        );
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_ticket_replies gets ticket's replies
     *
     * @param integer $ticket_id contains the ticket's ID
     * 
     * @return object with all replies or boolean false
     */
    public function get_ticket_replies( $ticket_id ) {
        
        // Select tickets
        $this->db->select('tickets_meta.created,tickets_meta.body,users.user_id,users.first_name,users.last_name,users.username,users.email');

        // From table
        $this->db->from('tickets_meta');

        // Join users
        $this->db->join('users', 'tickets_meta.user_id=users.user_id', 'left');

        // Set where
        $this->db->where('tickets_meta.ticket_id', $ticket_id);

        // Set order
        $this->db->order_by('tickets_meta.meta_id', 'desc');

        // Get data
        $query = $this->db->get();
        
        // Verify if replies exists
        if ( $query->num_rows() > 0 ) {
            
            // Set results
            $results = $query->result();
            
            // All replies container
            $all_replies = array();

            // User date
            $user_date = md_the_date_format($this->user_id);

            // Set wanted date format
            $date_format = str_replace(array('dd', 'mm', 'yyyy'), array('d', 'm', 'Y'), $user_date);
            
            // List all replies
            foreach ( $results as $result ) {

                // Format the time
                $time_format = (($result->created + 86400) < time())?date($date_format, $result->created):md_the_calculate_time($this->user_id, $result->created);
                
                // Add reply to the container
                $all_replies[] = array(
                    'created' => $time_format,
                    'body' => nl2br($result->body),
                    'first_name' => ($result->first_name)?$result->first_name:'',
                    'last_name' => ($result->last_name)?$result->last_name:'',
                    'username' => $result->username,
                    'avatar' => 'https://www.gravatar.com/avatar/' . md5($result->email)
                );
                
            }
            
            return $all_replies;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_ticket deletes a ticket
     *
     * @param integer $user_id contains the user's id
     * @param integer $ticket_id contains the ticket_id
     * 
     * @return boolean true or false
     */
    public function delete_ticket( $ticket_id ) {
        
        // First we check if the ticket exists
        $this->db->select('*');
        $this->db->from($this->table);
        
        // Verify if user is admin
        $this->db->where(
            array(
                'ticket_id' => $ticket_id
            )
        );
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Then will be deleted the ticket
            $this->db->delete($this->table,
                array(
                    'ticket_id' => $ticket_id
                )
            );

            if ( $this->db->affected_rows() ) {
                
                $this->db->delete('tickets_meta', array('ticket_id' => $ticket_id));
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file tickets_model.php */