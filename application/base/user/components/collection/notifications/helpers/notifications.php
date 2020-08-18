<?php
/**
 * Notifications Helper
 *
 * This file contains the class Notifications
 * with methods to manage the notifications
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Notifications\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Notifications class provides the methods to manage the notifications
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Notifications {
    
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

    }

    /**
     * The public method load_notifications_by_page loads notifications by page
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_notifications_by_page() {
        
        // Get page's input
        $page = $this->CI->input->get('page', TRUE);   
        
        // Verify if the page isn't numeric
        if ( !is_numeric($page) ) {
            $page = 1;
        }
        
        $limit = 10;
        
        $page--;

        // Get Notifications
        $notifications = $this->CI->notifications_model->get_notifications($this->CI->user_id, ($page * $limit), $limit);

        // Get total number of notifications
        $total = $this->CI->notifications_model->get_notifications($this->CI->user_id);
        
        // Verify if notifications exists
        if ( $notifications ) {
            
            $data = array(
                'success' => TRUE,
                'notifications' => $notifications,
                'total' => $total,
                'date' => time(),
                'page' => ($page + 1),
                'user_id' => $this->CI->user_id,
                'words' => array(
                    'delete' => $this->CI->lang->line('notifications_delete')
                )
            );

            echo json_encode($data);
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('notifications_no_found')
            );

            echo json_encode($data);            
            
        }
        
    }

    /**
     * The public method delete_notification deletes notification by notification's ID
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function delete_notification() {
        
        // Get notification_id's input
        $notification_id = $this->CI->input->get('notification_id', TRUE);  

        // Verify if the notification_id is numeric
        if ( is_numeric($notification_id) ) {

            // Delete the notification
            $delete = $this->CI->notifications_model->delete_notification($this->CI->user_id, $notification_id);

            // Verify if the notification was deleted
            if ( $delete ) {

                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('notification_was_deleted_successfully')
                );
    
                echo json_encode($data);
                exit();

            }

        }


        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notification_was_not_deleted_successfully')
        );

        echo json_encode($data);
        
    }

}

/* End of file notifications.php */