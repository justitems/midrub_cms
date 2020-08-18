<?php
/**
 * Activities Model
 *
 * PHP Version 5.6
 *
 * Activities file contains the Activities Model
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
 * Activities class - operates the activities table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Activities extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'activities';

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
     * The public method save_activity saves activities
     *
     * @since 0.0.7.0
     * 
     * @param string $app contains the app's name 
     * @param string $template contains the template's name
     * @param integer $id contains the identificator
     * @param integer $user_id contains the user's id
     * @param integer $member_id contains the member's id
     * @param string $text contains the activity's text
     * 
     * @return integer with inserted id or false
     */
    public function save_activity( $app, $template, $id, $user_id, $member_id, $text=NULL ) {

        // Get the activities table
        $activities = $this->db->list_fields('activities');
        
        // Verify if the activities has text's column
        if ( !in_array('text', $activities) ) {
            $this->db->query('ALTER TABLE activities ADD text TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci AFTER member_id');
        }
        
        // Set the time
        $time = time();
        
        // Set data
        $data = array(
            'app' => $app,
            'template' => $template,
            'id' => $id,
            'user_id' => $user_id,
            'member_id' => $member_id,
            'created' => $time
        );

        // Verify if $text is not NULL
        if ( $text ) {

            // Set text
            $data['text'] = $text;

        }
        
        // Insert activity
        $this->db->insert($this->table, $data);
        
        // Verify if post was saved
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_activities gets activities from database base on user_id
     *
     * @param integer $user_id contains the user's ID
     * @param integer $page contains a page number
     * @param integer $limit is used to get number of rows
     * 
     * @return object with activities or false
     */
    public function get_activities( $user_id, $page=NULL, $limit=NULL ) {
        
        // Get activities if exists
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(
            array('user_id' => $user_id)
        );
        
        if ( $limit ) {
            $this->db->order_by('activity_id', 'DESC');
            $this->db->limit($limit, $page);
        }
        
        $query = $this->db->get();
        
        if ( !$limit ) {
            return $query->num_rows();
        }
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return FALSE;
            
        }
        
    }
    
    /**
     * The public method delete_activity deletes an activity by identifier or user_id
     *
     * @param integer $user_id contains the user's id
     * @param integer $id contains the activity's identifier
     * 
     * @return boolean true or false
     */
    public function delete_activity($user_id, $id) {
         
        if ( $user_id > 0 ) {
            
            // Delete activity by user_id
            $this->db->delete($this->table, array('user_id' => $user_id));
            
        } else {
            
            // Delete activity by id
            $this->db->delete($this->table, array('id' => $id));
            
        }

        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Activities.php */