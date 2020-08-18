<?php
/**
 * Activity Model
 *
 * PHP Version 5.6
 *
 * Activity file contains the Activity Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Activity class - operates the activity table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Activity extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'activity', $allowed = 0;

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
        // Verify if comments are enabled
        $this->if_allowed('allow_facebook_commenting');
    }

    /**
     * The public method activities gets posts from the database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start column
     * 
     * @return object with activities or false
     */
    public function activities( $user_id, $start=NULL ) {
        
        $this->db->select('networks.net_id as neti_id', false);
        $this->db->select('activity.activity_id,posts.post_id,activity.net_id,posts.body,posts.title,posts.img,posts.video,posts.url,posts.sent_time,networks.user_name');
        $this->db->from($this->table);
        $this->db->join('posts', 'activity.body=posts.post_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $this->db->join('bots', 'activity.activity_id=bots.rule1', 'left');
        
        if ( $this->allowed > 0 ) {
            
            $this->db->where(['activity.user_id' => $user_id]);
            $key = $this->db->escape_like_str('facebook');
            $this->db->like('activity.network_name', $key);
            
        } else {
            
            $this->db->where(['activity.user_id' => $user_id, 'activity.network_name' => 'facebook_pages']);
            
        }
        
        $this->db->group_by('activity.activity_id');
        
        if ( is_numeric($start) ) {
            
            $this->db->limit(10,$start);
            
        }
        
        $this->db->order_by('activity.activity_id','DESC');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $activities = $query->result();
            
            // Load botis model
            $this->load->model('Botis', 'botis');
            $ed = [];
            
            foreach ($activities as $activity) {
                
                $favourite = 0;
                
                if ( $this->botis->check_bot('promotis-favourites', $user_id, $activity->activity_id) ) {
                    
                    $favourite = 1;
                    
                }
                
                $ed[] = ['favourite' => $favourite, 'neti_id' => $activity->neti_id, 'activity_id' => $activity->activity_id, 'post_id' => $activity->post_id, 'net_id' => $activity->net_id, 'body' => $activity->body, 'title' => $activity->title, 'img' => $activity->img, 'url' => $activity->url, 'sent_time' => $activity->sent_time, 'user_name' => $activity->user_name];
            }
            
            return $ed;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method bookmarks gets bookmarked posts from the database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start column
     * 
     * @return object with activities or false
     */
    public function bookmarks( $user_id, $start=NULL ) {
        
        $this->db->select('networks.net_id as neti_id', false);
        $this->db->select("(CASE WHEN(bots.type = 'promotis-favourites') THEN '1' ELSE '0' END) as favourite", false);
        $this->db->select('activity.activity_id,posts.post_id,activity.net_id,posts.body,posts.title,posts.img,posts.video,posts.url,posts.sent_time,networks.user_name');
        $this->db->from($this->table);
        $this->db->join('posts', 'activity.body=posts.post_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $this->db->join('bots', 'activity.activity_id=bots.rule1', 'left');
        
        if ( $this->allowed > 0 ) {
            
            $this->db->where(['bots.type' => 'promotis-favourites', 'activity.user_id' => $user_id]);
            $key = $this->db->escape_like_str('facebook');
            $this->db->like('activity.network_name', $key);
            
        } else {
            
            $this->db->where(['bots.type' => 'promotis-favourites', 'activity.user_id' => $user_id, 'activity.network_name' => 'facebook_pages']);
            
        }
        
        $this->db->group_by('activity.activity_id');
        
        if ( is_numeric($start) ) {
            
            $this->db->limit(10,$start);
            
        }
        
        $this->db->order_by('activity.activity_id','DESC');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method active gets actived posts from the database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start column
     * 
     * @return object with activities or false
     */
    public function active( $user_id, $start=NULL ) {
        
        $this->db->select('networks.net_id as neti_id', false);
        $this->db->select("(CASE WHEN(MAX(b.type) = 'promotis-favourites') THEN '1' ELSE '0' END) as favourite", false);
        $this->db->select('activity.activity_id,posts.post_id,activity.net_id,posts.body,posts.title,posts.img,posts.video,posts.url,posts.sent_time,networks.user_name');
        $this->db->from($this->table);
        $this->db->join('posts', 'activity.body=posts.post_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $this->db->join('bots', 'activity.activity_id=bots.rule1', 'left');
        $this->db->join('bots b', 'activity.activity_id=b.rule1', 'left');
        
        if ( $this->allowed > 0 ) {
            
            $this->db->where(['bots.type' => 'promotis-com-opts', 'bots.rule3 >' => '0', 'activity.user_id' => $user_id]);
            $key = $this->db->escape_like_str('facebook');
            $this->db->like('activity.network_name', $key);
            
        } else {
            
            $this->db->where(['bots.type' => 'promotis-com-opts', 'bots.rule3 >' => '0', 'activity.user_id' => $user_id, 'activity.network_name' => 'facebook_pages']);
            
        }
        
        $this->db->group_by('activity.activity_id');
        
        if ( is_numeric($start) ) {
            
            $this->db->limit(10,$start);
            
        }
        
        $this->db->order_by('activity.activity_id','DESC');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $activities = $query->result();
            
            // Load botis model
            $this->load->model('Botis', 'botis');
            $ed = [];
            
            foreach ($activities as $activity) {
            
                $favourite = 0;
                
                if ( $this->botis->check_bot('promotis-favourites', $user_id, $activity->activity_id) ) {
                    
                    $favourite = 1;
                    
                }
                
                $ed[] = ['favourite' => $favourite, 'neti_id' => $activity->neti_id, 'activity_id' => $activity->activity_id, 'post_id' => $activity->post_id, 'net_id' => $activity->net_id, 'body' => $activity->body, 'title' => $activity->title, 'img' => $activity->img, 'url' => $activity->url, 'sent_time' => $activity->sent_time, 'user_name' => $activity->user_name];
                
            }
            
            return $ed;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_activities_by_account_id gets activities by account id
     *
     * @param $network_id contains the network_id
     * 
     * @return object with activities or false
     */
    public function get_activities_by_account_id($network_id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $where = ['network_id' => $network_id];
        $this->db->where($where);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_act_id gets activity by net_id
     *
     * @param integer $net_id contains the post's ID
     * @param integer $user_id contains the user_id
     * 
     * @return integer with activity_id or false
     */
    public function get_act_id( $net_id, $user_id ) {
        $this->db->select('activity_id');
        $this->db->from($this->table);
        $this->db->where(['net_id' => $net_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result_array();
            return $result[0]['activity_id'];
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_user_activity deletes user's activity
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true if were deleted or false
     */
    public function delete_user_activity( $user_id ) {
        
        $this->db->select('activity_id');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
        
            $result = $query->result();
            
            foreach ( $result as $activity ) {
                
                $this->db->delete($this->table, ['activity_id' => $activity->activity_id]);
                $this->db->delete('activity_meta', ['activity_id' => $activity->activity_id]);
                
            }
            
        }
        
    }
    
    /**
     * The public method if_allowed verifies if user is allowed to publish on all Facebook profiles, groups and pages
     *
     * @param string $meta contains the meta name
     * 
     * @return boolean true if enabled or false
     */
    public function if_allowed( $meta ) {
        
        // Load Options Model
        $this->load->model('Options', 'options');
        
        if ( $this->options->get_an_option($meta) ) {
            
            $this->allowed = 1;
            
        } else {
            
            $this->allowed = 0;
            
        }
        
    }   
    
}

/* End of file Activity.php */
