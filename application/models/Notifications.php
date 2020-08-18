<?php
/**
 * Notifications Model
 *
 * PHP Version 5.6
 *
 * Notifications file contains the Notifications Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    
    exit('No direct script access allowed');
    
}

/**
 * Notifications class - operates the notifications table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Notifications extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'notifications';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method get_templates gets all templates from database
     *
     * @param string $template contains the template name
     * 
     * @return object with templates or false
     */
    public function get_templates( $template ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('template', $template);
        $this->db->order_by('notification_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template gets notification template by $template
     *
     * @param string $template contains the template name
     * @param array $args contains an array
     * 
     * @return object with template data or false
     */
    public function get_template( $template, $args ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('template_name', $template);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            $title = str_replace(array_keys($args), array_values($args), $result[0]->notification_title);
            $body = str_replace(array_keys($args), array_values($args), $result[0]->notification_body);
            
            if ( $title != '' AND $body != '' ) {
                
                return array(
                    'title' => strip_tags($title),
                    'body' => $body
                );
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method update_msg saves new notification or updates a template
     *
     * @param string $title contains the notification title
     * @param string $body contains the notification body
     * @param string $template contains the template name
     * 
     * @return boolean true if the notification was update or false
     */
    public function update_msg($title, $body, $template = null) {
        
        // Set title
        $title = rawurldecode($title);
        
        // Set description
        $body = rawurldecode($body);
        
        // Verify if template is not null
        if ( $template ) {
            
            // Check if the template already exists.
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('template_name', $template);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                // If the template exists will be update
                $data = ['notification_title' => $title, 'notification_body' => $body, 'template' => '1'];
                $this->db->where('template_name', $template);
                $this->db->update($this->table, $data);
                
                if ( $this->db->affected_rows() ) {
                    
                    return true;
                    
                } else {
                    
                    return false;
                    
                }
                
            } else {
                
                // If the template now exists will be insert
                $data = array('notification_title' => $title, 'notification_name' => $title, 'notification_body' => $body, 'template' => '1', 'template_name' => $template);
                
                $this->db->insert($this->table, $data);
                
                if ( $this->db->affected_rows() ) {
                    
                    return true;
                    
                } else {
                    
                    return false;
                    
                }
                
            }
            
        } else {
            
            // If is a notification will be sent to all users
            $sent_date = time();
            
            // Set data
            $data = array('notification_title' => $title, 'notification_body' => $body, 'sent_time' => $sent_date);
            
            // Save
            $this->db->insert($this->table, $data);
            
            // Verify if data was saved
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method get_notification gets the notification by $notification_id
     *
     * @param integer $notification_id contains the notification's id
     * @param integer $user_id contains the user's ID
     * 
     * @return object with notification or false
     */
    public function get_notification( $notification_id, $user_id = null ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('notification_id', $notification_id);
        $this->db->limit(1);
        $querys = $this->db->get();
        
        if ( $querys->num_rows() > 0 ) {
            
            if ( $user_id ) {
                
                $this->db->select('*');
                $this->db->from('notifications_stats');
                $this->db->where(['notification_id' => $notification_id, 'user_id' => $user_id]);
                $query = $this->db->get();
                
                if ( $query->num_rows() < 1 ) {
                    
                    // If a user has seen a notification the status will be 1
                    $data = ['notification_id' => $notification_id, 'user_id' => $user_id, 'status' => 1];
                    $this->db->insert('notifications_stats', $data);
                    
                }
                
            }
            
            $result = $querys->result_array();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method del_notification deletes a notification
     *
     * @param integer $notification_id contains the notification's id
     * @param integer $user_id contains the user's ID
     * 
     * @return boolean true or false
     */
    public function del_notification( $notification_id, $user_id ) {
        
        $this->db->select('*');
        $this->db->from('notifications_stats');
        $this->db->where(['notification_id' => $notification_id, 'user_id' => $user_id, 'status' => 2]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return true;
            
        } else {
            
            // To delete a notification for an user we add status=2 in notifications_stats
            $data = ['notification_id' => $notification_id, 'user_id' => $user_id, 'status' => 2];
            
            // Where conditions
            $this->db->where(['notification_id' => $notification_id, 'user_id' => $user_id]);
            
            // Update
            $this->db->update('notifications_stats', $data);
            
            // Verify if update was done successfully
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method get_notifications gets all notifications from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start
     * @param integer $limit displays the limit
     * @param string $key contains the search key
     * 
     * @return object with results or false
     */
    public function get_notifications( $user_id, $start=0, $limit=0, $key = NULL ) {
        
        // Get user date_joined by id
        $CI = & get_instance();
        $CI->load->model('user');
        $username = $CI->user->get_user_info($user_id);
        
        if ( @$username['date'] ) {
            
            $joined = $username['date'];
            
        } else {
            
            $joined = time() - 2592000;
            
        }
        
        $this->db->select('notifications_stats.status,notifications_stats.user_id,notifications.sent_time,notifications.notification_title,notifications.notification_id as id');
        $this->db->from($this->table);
        $this->db->join('notifications_stats', 'notifications.notification_id=notifications_stats.notification_id', 'left');
        $this->db->where("notifications.template='0' AND notifications.sent_time>'$joined' AND notifications.notification_id NOT IN (SELECT notification_id FROM notifications_stats WHERE user_id ='$user_id' AND notifications_stats.status='2')");
        
        if ( $key ) {
            
            $key = $this->db->escape_like_str($key);
            $this->db->like('notification_body', $key);
            
        }
        
        $this->db->group_by('id');
        $this->db->order_by('id', 'desc');

        if ( $limit ) {

            $this->db->limit($limit, $start);

        }

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method del_notification_completely deletes a notification
     *
     * @param integer $notification_id contains the notification's id
     * 
     * @return boolean true if notification was deleted or false
     */
    public function del_notification_completely($notification_id) {
        
        $this->db->where('notification_id', $notification_id);
        $this->db->delete($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            // Delete notification's information from notifications_stats
            $this->db->where('notification_id', $notification_id);
            $this->db->delete('notifications_stats');
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method send_notification sends a notification
     *
     * @param integer $user_id contains the user's id
     * @param string $template contains the template's name
     * @param string $template contains the notification title
     * 
     * @return boolean true if the notification was sent or false
     */
    public function send_notification( $user_id, $template, $title=NULL ) {
        
        // sends notifications to user about error publishing posts.
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('template_name', $template);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
            $CI = & get_instance();
            $CI->load->model('user');
            $username = $CI->user->get_username_by_id($user_id);
            $placeholders = ['[login_address]', '[username]', '[site_name]', '[site_url]'];
            $replace = ['<a href="' . $CI->config->item('login_url') . '">' . $CI->config->item('login_url') . '</a>', $username, '<a href="' . $CI->config->base_url() . '">' . $CI->config->item('site_name') . '</a>', '<a href="' . $CI->config->base_url() . '">' . $CI->config->base_url() . '</a>'];
            if ( $title ) {
                $placeholders[] = '[post]';
                $replace[] = substr(strip_tags($title),0,100);
                $placeholders[] = '[template]';
                $replace[] = substr(strip_tags($title),0,100);                
            }
            $title = strip_tags(str_replace($placeholders, $replace, $result[0]->notification_title));
            $body = str_replace($placeholders, $replace, $result[0]->notification_body);
            $email = $CI->user->get_email_by('user_id', $user_id);
            $this->email->from($CI->config->item('contact_mail'), $CI->config->item('site_name'));
            $this->email->to($email);
            $this->email->subject($title);
            $this->email->message($body);
            if ( $this->email->send() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Notifications.php */
