<?php
/**
 * Notifications Model
 *
 * PHP Version 7.2
 *
 * Notifications_model file contains the Notifications Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notifications_model class - operates the notifications table.
 *
 * @since 0.0.7.9
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Notifications_model extends CI_MODEL {
    
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
     * The public method get_notifications gets all notifications from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start
     * @param integer $limit displays the limit
     * @param string $key contains the search key
     * 
     * @return array with results or false
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
        
        $this->db->select('notifications.notification_id,notifications_stats.status,notifications_stats.user_id,notifications.sent_time,notifications.notification_title,notifications.notification_id as id');
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

        if ( !$limit ) {
            return $query->num_rows();
        }
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result_array();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_notification gets the notification by $notification_id
     *
     * @param integer $user_id contains the user's ID
     * @param integer $notification_id contains the notification's id
     * 
     * @return array with notification or false
     */
    public function get_notification( $user_id, $notification_id ) {
        
        $this->db->select('notifications_stats.status,notifications_stats.user_id,notifications.sent_time,notifications.notification_title,notifications.notification_body,notifications.notification_id as notification_id');
        $this->db->from($this->table);
        $this->db->join('notifications_stats', 'notifications.notification_id=notifications_stats.notification_id', 'left');
        $this->db->where('notifications.notification_id', $notification_id);
        $this->db->limit(1);

        $querys = $this->db->get();
        
        if ( $querys->num_rows() > 0 ) {

            $this->db->select('*');
            $this->db->from('notifications_stats');
            $this->db->where(array(
                'notification_id' => $notification_id,
                'user_id' => $user_id
            ));

            $query = $this->db->get();

            if ($query->num_rows() < 1) {

                // If a user has seen a notification the status will be 1
                $data = array(
                    'notification_id' => $notification_id,
                    'user_id' => $user_id,
                    'status' => 1
                );

                $this->db->insert('notifications_stats', $data);

            }
            
            $result = $querys->result_array();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_notification deletes a notification
     *
     * @param integer $user_id contains the user's ID
     * @param integer $notification_id contains the notification's id
     * 
     * @return boolean true or false
     */
    public function delete_notification( $user_id, $notification_id ) {
        
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
    
}

/* End of file notifications_model.php */