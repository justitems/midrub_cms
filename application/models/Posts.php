<?php
/**
 * Posts Model
 *
 * PHP Version 5.6
 *
 * Posts file contains the Posts Model
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
 * Posts class - operates the posts table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Posts extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'posts';

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
     * The public method save_post saves post before send on social networks
     *
     * @param integer $user_id contains the user_id
     * @param string $post contains the post content
     * @param string $url contains the post's url
     * @param string $img contains the post's image url
     * @param integer $time contains the time when will be published the post
     * @param integer $publish contains a number. If 0 the post will be saved as draft.
     * @param string $categories contains the category where will be published the post
     * 
     * @return integer with inserted id or false
     */
    public function save_post( $user_id, $post, $url, $img, $video = NULL, $time, $publish, $categories = NULL, $post_title = NULL ) {
        
        // Get current ip
        $ip = $this->input->ip_address();
        
        // Decode URL-encoded strings
        $post = rawurldecode($post);
        
        // Set data
        $data = ['user_id' => $user_id, 'body' => $post, 'title' => $post_title, 'url' => $url, 'img' => $img, 'category' => $categories, 'sent_time' => $time, 'ip_address' => $ip, 'status' => $publish, 'view' => '1'];
        
        // Verify if video exists
        if ( $video ) {
            
            $data['video'] = $video;
            
        }
        
        // Insert post
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
     * The public method save_post_meta saves post meta
     *
     * @param integer $post_id contains the post_id
     * @param integer $account contains the account where will be published the post
     * @param string $name contains the network's name
     * @param integer $status may be a number 0, 1 or 2
     * @param integer $user_id contains the user_id
     * 
     * @return void
     */
    public function save_post_meta( $post_id, $account, $name, $status=0, $user_id=0 ) {
        
        // Get current time
        $time = time();
        
        // Set data
        $data = ['post_id' => $post_id, 'network_id' => $account, 'network_name' => $name, 'sent_time' => $time, 'status' => $status];
        
        // Verify if post failed
        if ( $status > 1 ) {
            
            // Get the last error
            // Load User model
            $this->load->model( 'User', 'user' );
            $error_code = $this->user->get_user_option( $user_id, 'last-social-error' );
            
            if ( $error_code ) {
                
                $data['network_status'] = $error_code;
                $this->user->delete_user_option( $user_id, 'last-social-error' );
                
            }
        }
        
        $this->db->insert('posts_meta', $data);
    }

    /**
     * The public method update_post_meta updates post meta after publishing
     *
     * @param $meta_id contains the meta_id
     * @param $status contains the published status
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function update_post_meta( $meta_id, $status, $user_id ) {
        
        // Get current time
        $time = time();
        
        // Set data
        $data = ['sent_time' => $time, 'status' => $status];
        
        // Verify if post failed
        if ( $status > 1 ) {
            
            // Get the last error
            // Load User model
            $this->load->model( 'User', 'user' );
            $error_code = $this->user->get_user_option( $user_id, 'last-social-error' );
            
            if ( $error_code ) {
                
                $data['network_status'] = $error_code;
                $this->user->delete_user_option( $user_id, 'last-social-error' );
                
            }
        }
        
        $this->db->where('meta_id', $meta_id);
        $this->db->update('posts_meta', $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method change_scheduled_to_publish changes a scheduled post to publish
     *
     * @param integer $post_id contains the post_id
     * 
     * @return boolean true or false
     */
    public function change_scheduled_to_publish( $post_id ) {
        
        // Get current time
        $time = time();
        
        // Set data
        $data = ['sent_time' => $time, 'status' => 1];
        
        $this->db->where('post_id', $post_id);
        $this->db->update($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_post gets post content
     *
     * @param integer $user_id contains the user's id
     * @param integer $msgId contains the post_id
     * 
     * @return array with post's data or false if post doesn't exists
     */
    public function get_post( $user_id, $msgId ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'post_id' => $msgId]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            $sent = "";
            
            // Update view with 0
            $this->db->where('post_id', $msgId);
            $this->db->update($this->table, ['view' => 0]);
            
            // Get history of published post on social networks
            if ( $this->sentnetworkmess($msgId) ) {
                
                $sent = $this->sentnetworkmess($msgId);
                
            }
            
            return ['post_id' => $result[0]->post_id, 'user_id' => $result[0]->user_id, 'body' => htmlentities($result[0]->body), 'title' => $result[0]->title, 'category' => $result[0]->category, 'url' => $result[0]->url, 'img' => $result[0]->img, 'video' => $result[0]->video, 'status' => $result[0]->status, 'sent' => $sent, 'time' => $result[0]->sent_time, 'current' => time(), 'parent' => $result[0]->parent];
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_post deletes a post
     *
     * @param integer $user_id contains the user's id
     * @param integer $msgId contains the post_id
     * 
     * @return boolean if the post was deleted successfully or false
     */
    public function delete_post($user_id, $msgId) {
        
        // First we check if the post exists
        $this->db->select('post_id');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'post_id' => $msgId]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Load resend model
            $this->load->model('Resend', 'resend');
            $resend_id = $this->resend->get_post_resend_id($user_id,$msgId);
            
            // Then will be deleted the post's meta
            $this->db->delete('posts_meta', ['post_id' => $msgId]);
            
            // Then will be deleted the post
            $this->db->delete($this->table, ['post_id' => $msgId]);
            
            if ( $this->db->affected_rows() ) {
                
                if ( is_numeric($resend_id) ) {
                    
                    // Then will be deleted the resend's row
                    $this->db->delete('resend', ['resend_id' => $resend_id]);
                    $this->db->delete('resend_meta', ['resend_id' => $resend_id]);
                    $this->db->delete('resend_rules', ['resend_id' => $resend_id]);
                    
                }
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method find_error_publishing_posts detects all non published posts
     *
     * @param integer $msgId contains the post_id
     * 
     * @return integer number of errors
     */
    public function find_error_publishing_posts( $msgId ) {
        
        $this->db->select('*');
        $this->db->from('posts_meta');
        $this->db->where(['post_id' => $msgId, 'status' => 2]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        }
        
    }
    
    /**
     * The public method gets_post_group gets the post group
     *
     * @param integer $msgId contains the post_id
     * 
     * @return object with post groups
     */
    public function gets_post_group( $msgId ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['post_id' => $msgId]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        }
        
    }

    /**
     * The public method get_posts gets all posts from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays posts
     * @param integer $limit displays the limit of displayed posts
     * @param string $key contains the search key
     * 
     * @return object with posts or false
     */
    public function get_posts( $user_id, $start, $limit, $key = NULL ) {
        
        $this->db->select('post_id,body,title,url,img,video,sent_time,status');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        
        // If $key exists means will displayed posts by search
        if ( $key ) {
            
            // This method allows to escape special characters for LIKE conditions
            $key = $this->db->escape_like_str($key);
            
            // Gets posts which contains the $key
            $this->db->like('body', $key);
            
        }
        
        $this->db->order_by('sent_time', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Get results
            $results = $query->result();
            
            // Create a new array
            $array = [];
            
            foreach ( $results as $result ) {
                
                // Each result will be a new object
                $array[] = (object)[ 'post_id' => $result->post_id, 'body' => htmlentities($result->body), 'title' => $result->title, 'url' => $result->url, 'video' => $result->video, 'img' => $result->img, 'sent_time' => $result->sent_time, 'status' => $result->status, 'history' => $this->sentnetworkmess($result->post_id) ];
                
            }
            
            return $array;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method cildrens gets cildrens by parent
     *
     * @param integer $parent contains the parent's post
     * 
     * @return object with post's childrens or false
     */
    public function cildrens($parent) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['parent'=>$parent]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }    

    /**
     * The public method count_all_posts counts all published posts
     *
     * @param integer $user_id contains the user_id
     * @param string $key contains the search key
     * 
     * @return integer with post number or 0
     */
    public function count_all_posts( $user_id, $key = NULL ) {
        
        $this->db->select('post_id');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $key = $this->db->escape_like_str($key);
        
        if ( $key ) {
            
            $this->db->like('body', $key);
            
        }
        
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        } else {
            
            return '0';
            
        }
        
    }

    /**
     * The public method get_last_posts gets last published posts limit by $time
     *
     * @param integer $user_id contains the user_id
     * @param integer $time contains the time period
     * 
     * @return array with posts or false
     */
    public function get_last_posts($time, $user_id) {
        
        $this->db->select('*, LEFT(FROM_UNIXTIME(posts.sent_time),10) as datetime', false);
        $this->db->select('COUNT(posts_meta.meta_id) as number', false);
        $this->db->from('posts');
        $this->db->join('posts_meta', 'posts_meta.post_id=posts.post_id', 'left');
        $this->db->where(['posts.user_id' => $user_id, 'posts_meta.sent_time >' => strtotime('-' . $time . 'day', time()), 'posts_meta.status' => '1']);
        $this->db->group_by(['datetime', 'posts_meta.network_name']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $new_array = [];
            
            foreach ( $result as $data ) {
                
                $new_array[date("Y-m-d", $data->sent_time)][$data->network_name] = $data->number;
                
            }
            
            return $new_array;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_all_count_posts gets all count posts for admin dashboard
     * 
     * @return array with posts or false 
     */
    public function get_all_count_posts() {
        
        $this->db->select('network_name,COUNT(meta_id) as number', false);
        $this->db->from('posts_meta');
        $this->db->where(['status' => '1']);
        $this->db->group_by('network_name');
        $this->db->order_by('network_name');
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $new_array = [];
            
            foreach ( $result as $data ) {
                
                $new_array[$data->network_name] = $data->number;
                
            }
            
            return $new_array;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_last_ten_posts gets last users registered after the $time
     *
     * @param integer $user_id contains the user_id
     * 
     * @return object with posts or false
     */
    public function get_last_ten_posts( $user_id ) {
        
        $this->db->select('post_id,body,sent_time,view');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $this->db->order_by('post_id', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method count_all_sent_posts counts published $user_id's posts from database
     *
     * @param integer $user_id contains the user_id
     * 
     * @return integer with number of posts or false
     */
    public function count_all_sent_posts( $user_id ) {
        
        $this->db->select('post_id');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'status' => 1]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        } else {
            
            return '0';
            
        }
        
    }

    /**
     * The public method get_first_unpublished_post gets first unpublished post and return time
     * 
     * @return integer with sent time
     */
    public function get_first_unpublished_post() {
        
        $this->db->select('sent_time');
        $this->db->from($this->table);
        $this->db->where(['sent_time <' => time(), 'status' => 2]);
        $this->db->order_by('sent_time', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $publish = $query->result_array();
            return $publish[0]['sent_time'];
            
        }
        
    }

    /**
     * The public method get_the_time_scheduled_post gets the last time of a scheduled post
     * 
     * @return integer with sent time
     */
    public function get_the_time_scheduled_post() {
        
        $this->db->select('sent_time');
        $this->db->from($this->table);
        $this->db->where(['sent_time >' => time(), 'status' => 2]);
        $this->db->order_by('sent_time', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $publish = $query->result_array();
            return $publish[0]['sent_time'];
            
        }
        
    }

    /**
     * The public method count_all_scheduled_posts counts all scheduled posts
     *
     * @param integer $status contains the post's status
     * 
     * @return integer with number of rows or 0
     */
    public function count_all_scheduled_posts( $status = NULL ) {
        
        $this->db->select('post_id');
        $this->db->from($this->table);
        $this->db->where(['status' => 2]);
        
        if ( $status ) {
            
            $this->db->where(['sent_time <' => time()]);
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        } else {
            
            return '0';
            
        }
        
    }

    /**
     * The public method get_all_scheduled_posts gets all scheduled posts that must be published before the time()
     *
     * @param integer $limit contains the period time
     * 
     * @return object with scheduled posts or false
     */
    public function get_all_scheduled_posts($limit) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['status' => 2, 'sent_time <' => time()]);
        $this->db->limit($limit);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method all_social_networks_by_post_id gets all social network where the post($post_id) must be published
     *
     * @param integer $post_id contains the post_id
     * 
     * @return array with networks 
     */
    public function all_social_networks_by_post_id( $user_id, $post_id ) {
        
        $this->db->select('posts_meta.meta_id,posts_meta.network_id,posts_meta.post_id,networks.network_name,networks.user_name');
        $this->db->from('posts_meta');
        $this->db->join('networks', 'posts_meta.network_id=networks.network_id', 'left');
        $this->db->where(['networks.user_id' => $user_id, 'posts_meta.post_id' => $post_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $networks = $query->result_array();
            return $networks;
            
        }
        
    }

    /**
     * The public method byact gets post by activity
     *
     * @param integer $user_id contains user_id
     * @param integer $act contains the activity ID
     * 
     * @return object with activities or false
     */
    public function byact($user_id, $act) {
        
        $get = $this->get_an_activity($act);
        
        if ( $get ) {
            
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where(['user_id' => $user_id, 'post_id' => $get[0]->body]);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
            
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_posts gets all user's posts
     *
     * @param integer $user_id contains user_id
     * 
     * @return object with posts or false
     */
    public function get_user_posts( $user_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_posts deletes all user's posts 
     *
     * @param integer $user_id contains user_id
     * 
     * @return boolean true or false
     */
    public function delete_posts( $user_id ) {
        
        $this->load->model('Resend', 'resend');
        $posts = $this->get_user_posts($user_id);
        
        if ( $posts ) {
            
            foreach ( $posts as $post ) {
                
                $resend_id = $this->resend->get_post_resend_id($user_id,$post->post_id);
                
                $this->db->delete('posts_meta', array('post_id' => $post->post_id));
                
                if( $resend_id ) {
                    
                    $this->db->delete('resend', ['resend_id' => $resend_id]);
                    $this->db->delete('resend_meta', ['resend_id' => $resend_id]);
                    $this->db->delete('resend_rules', ['resend_id' => $resend_id]);
                    
                }
                
            }
            
        }
        
        $this->db->delete('posts', array('user_id' => $user_id));
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method sentnetworkmess gets information about the published post on the social network
     *
     * @param integer $fromId contains the post_id
     * 
     * @return array with published posts
     */
    private function sentnetworkmess( $fromId ) {
        
        $this->db->select('posts_meta.meta_id,posts_meta.network_name,posts_meta.status,networks.user_name,posts_meta.network_status');
        $this->db->from('posts_meta');
        $this->db->join('networks', 'posts_meta.network_id=networks.network_id', 'left');
        $this->db->where(['posts_meta.post_id' => $fromId]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result_array();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method upo adds the post ID
     *
     * @param integer $id contains the post ID
     * @param integer $pid contains the post ID
     * @param integer $acc contains the account ID
     * @param string $net contains network name
     * @param integer $user_id contains user_id
     * 
     * @return void
     */
    public function upo( $id, $pid, $acc, $net, $user_id ) {
        
        // Get current time
        $time = time();
        
        // Set data
        $data = ['user_id' => $user_id, 'net_id' => $pid, 'body' => $id, 'network_name' => $net, 'network_id' => $acc, 'created' => $time];
        
        // Save
        $this->db->insert('activity', $data);
        
    }

    /**
     * The public method get_activity gets all activities by parameters
     *
     * @param integer $user_id contains the user_id
     * @param integer $page contains a page number
     * @param string $net contains the network name or id
     * @param integer $l is used to get number of rows
     * 
     * @return integer number of rows, object with all posts or false
     */
    public function get_activity( $user_id, $page, $net = NULL, $l = NULL ) {
        
        // Verify if $page is null
        if ( !$page ) {
            
            $page = 0;
            
        } else {
            
            $page--;
            $page = $page * 10;
            
        }
        
        $this->db->select('activity.activity_id,posts.post_id,activity.dlt,posts.body,posts.title,posts.url,posts.img,posts.video,activity.net_id,activity.network_name,activity.network_id,networks.user_name as user_name', FALSE);
        $this->db->from('activity');
        $this->db->join('posts', 'activity.body=posts.post_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $where = ['activity.user_id' => $user_id, 'activity.view' => 0];
        
        if ( $net ) {
            
            if ( is_numeric($net) ) {
                
                $where = ['activity.user_id' => $user_id, 'activity.network_id' => $net];
                
            } else {
                
                $where = ['activity.user_id' => $user_id, 'activity.network_name' => str_replace('-', '_', $net)];
                
            }
            
        }
        
        $this->db->where($where);
        $this->db->order_by('activity_id', 'desc');
        if ( !$l ) {
            
            $this->db->limit(10, $page);
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            if ( is_numeric($l) ) {
                
                return $query->num_rows();
                
            } else {
                
                $result = $query->result();
                return $result;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_single_activity gets a single activity
     *
     * @param integer $user_id contains the user_id
     * @param string $act_id contains the activity's id
     * 
     * @return object with a post or false 
     */
    public function get_single_activity( $user_id, $act_id ) {
        
        $this->db->select('activity.activity_id,posts.post_id,activity.dlt,posts.body,posts.title,posts.url,posts.img,posts.video,activity.net_id,activity.network_name,activity.network_id,networks.user_name as user_name', FALSE);
        $this->db->from('activity');
        $this->db->join('posts', 'activity.body=posts.post_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $where = ['activity.activity_id' => $act_id];
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
     * The public method get_an_activity gets an activity by id
     *
     * @param integer $post_id contains the activity id
     * 
     * @return object with activity data or false
     */
    public function get_an_activity( $post ) {
        
        $this->db->select('*');
        $this->db->from('activity');
        $this->db->where(['activity_id' => $post]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method load_an_activity loads an random activity
     * 
     * @return object with activity or false
     */
    public function load_an_activity() {
        
        $t = time() - $this->lacu();
        $this->db->select('activity.activity_id,activity.network_name,activity.net_id,activity.network_id');
        $this->db->from('activity');
        $this->db->join('activity_meta', 'activity.activity_id=activity_meta.activity_id', 'left');
        $this->db->where(['activity.created>' => $t]);
        $this->db->or_where(['activity_meta.created>' => $t]);
        $this->db->order_by('rand()');
        $this->db->limit(5);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method insert_meta add new value
     *
     * @param string $key may contains option_key
     * 
     * @return boolean true or false
     */
    public function insert_meta( $activity_id, $type, $net_id, $author_id, $author_name, $msg, $network_id, $parent = '' ) {
        
        $this->db->select('*');
        $this->db->from('activity_meta');
        $this->db->where(['net_id' => $net_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() < 1 ) {
            
            // Add new row
            $time = time();
            
            $data = ['activity_id' => $activity_id, 'type' => $type, 'net_id' => $net_id, 'author_id' => $author_id, 'author_name' => $author_name, 'body' => $msg, 'network_id' => $network_id, 'created' => $time, 'parent' => $parent];
            
            $this->db->insert('activity_meta', $data);
            
            if ( $this->db->affected_rows() ) {
                
                $this->nonseen($activity_id);
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method repu save a post
     *
     * @param integer $user contains the current user_id
     * @param array $array contains an array
     * @param string $c contains the date
     * @param integer $parent contains the post parent
     * 
     * @return boolean true or false
     */
    public function repu( $user, $args, $c, $parent ) {
        
        $ip = $this->input->ip_address();
        
        if ( ($c < 1) || !is_numeric($c) ) {
            
            $c = time();
            
        } elseif( $c < 10000000 ) {
            
            $c = time() + $c;
            
        }
        
        $data = ['user_id' => $args[0], 'body' => $args[1], 'title' => $args[2], 'url' => $args[3], 'img' => $args[4], 'video' => $args[5], 'category' => $args[6], 'sent_time' => $c, 'ip_address' => $ip, 'status' => 2, 'parent' => $parent];
        
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_comments gets comments from the database
     *
     * @param integer $post_id contains the post id
     * 
     * @return object with comments or false
     */
    public function get_comments( $post_id, $all = NULL ) {
        
        $this->db->select('*');
        $this->db->from('activity_meta');
        
        if ( !$all ) {
            
            $this->db->join('comments', 'activity_meta.net_id=comments.comment', 'left');
            $this->db->where(['activity_id' => $post_id, 'type' => 'comment']);
            
        } else {
            
            $this->db->where(['activity_id' => $post_id]);
            
        }
        
        $this->db->order_by('meta_id', 'ASC');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_likes gets likes from the database
     *
     * @param integer $post_id contains the post id
     * 
     * @return object with replies or false
     */
    public function get_likes( $post_id ) {
        
        $this->db->select('*');
        $this->db->from('activity_meta');
        $this->db->where(['activity_id' => $post_id, 'type' => 'like']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method save_comment saves a comment
     *
     * @param integer $comment contents the comment's ID
     * 
     * @return boolean true or false
     */
    public function save_comment( $comment ) {
        
        // Set data
        $data = ['comment' => $comment, 'created' => date('Y-m-d h:i:s')];
        
        // Insert
        $this->db->insert('comments', $data);
        
        // Verify if comment was saved
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_comment deletes a comment
     *
     * @param integer $comment contents the comment's ID
     * 
     * @return boolean true or false
     */
    public function delete_comment( $comment ) {
        
        $this->db->delete('comments', ['comment' => $comment]);
        $this->db->delete('activity_meta', ['net_id' => $comment]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_activity_by_id gets activity data by id
     * 
     * @param integer $act contains activity ID
     * 
     * @return object with results or false
     */
    public function get_activity_by_id( $act ) {
        
        $this->db->select('activity.net_id,activity.network_id,activity.activity_id,networks.token,networks.secret,networks.user_name,networks.network_name,networks.user_id,networks.expires');
        $this->db->from('activity');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        $this->db->where(['activity_id' => $act]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_replies gets replies from the database
     *
     * @param integer $comment_id contains the comment id
     * 
     * @return object with replies or false
     */
    public function get_replies( $comment_id ) {
        
        $this->db->select('*');
        $this->db->from('activity_meta');
        $this->db->join('comments', 'activity_meta.net_id=comments.comment', 'left');
        $this->db->where(['parent' => $comment_id, 'type' => 'parent']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method seen updates an activity
     *
     * @param integer $user_id contains the user id
     * @param integer $activity_id contains the activity id
     * 
     * @return boolean true or false
     */
    public function seen( $user_id, $activity_id ) {
        
        $this->db->set(['view' => '1']);
        $this->db->where(['activity_id' => $activity_id, 'user_id' => $user_id]);
        $this->db->update('activity');
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method insert_del deletes an activity
     *
     * @param integer $act contains activity's ID
     * @param integer $val contains a number
     * 
     * @return integer with time or false
     */
    public function insert_del( $act, $val ) {
        
        $this->db->set(['dlt' => $val]);
        $this->db->where(['activity_id' => $act]);
        $this->db->update('activity');
        
        if ( $this->db->affected_rows() ) {
            
            return $val;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method sched_again allows to schedule deletion of the post
     *
     * @param integer $id contains post's ID
     * @param integer $time contains the scheduling time
     * 
     * @return boolean true or false
     */
    public function sched_again( $user_id,$id,$time ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['post_id' => $id, 'user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            $time = $result[0]->sent_time+$time;
            
            $this->db->set(['dlt' => $time]);
            
            $this->db->where(['post_id' => $id]);
            
            $this->db->update($this->table);
            
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }    

    /**
     * The public method activity_del deletes activities
     * 
     * @return object with acivities wich must be deleted or false
     */
    public function activity_del() {
        
        $this->db->select('activity_id, net_id, network_id, network_name');
        $this->db->from('activity');
        $this->db->where(['dlt <' => time(), 'dlt !=' => '']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_all deletes an activity
     *
     * @param integer $act contains activity's ID
     * 
     * @return boolean true or false
     */
    public function delete_all( $act ) {
        
        $this->db->delete('activity', ['activity_id' => $act]);
        if ( $this->db->affected_rows() ) {
            
            $this->del_meta($act);
            
            // Delete the bots for this activity
            $this->db->delete('bots', ['rule1' => $act, 'type' => 'promotis-comment']);
            $this->db->delete('bots', ['rule1' => $act, 'type' => 'promotis-com-opts']);
            $this->db->delete('bots', ['rule1' => $act, 'type' => 'promotis-history']);
            $this->db->delete('bots', ['rule1' => $act, 'type' => 'promotis-favourites']);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method del_meta deletes the activity's comments
     *
     * @param integer $act contains activity's ID
     * 
     * @return boolean true or false
     */
    private function del_meta( $act ) {
        
        $this->db->select('*');
        $this->db->from('activity_meta');
        $this->db->where(['activity_id' => $act]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            $result = $query->result();
            
            foreach ( $result as $res ) {
                $this->db->select('*');
                $this->db->from('comments');
                $this->db->where(['comment' => $res->net_id]);
                $query = $this->db->get();
                
                if ( $query->num_rows() > 0 ) {
                    
                    $this->db->delete('comments', ['comment' => $res->net_id]);
                    
                }
            }
            $this->db->delete('activity_meta', ['activity_id' => $act]);
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method nonseen removes seen from an activity
     *
     * @param integer $act contains activity's ID
     * 
     * @return boolean true or false
     */
    public function nonseen( $act ) {
        
        $this->db->set(['view' => '0']);
        $this->db->where(['activity_id' => $act]);
        $this->db->update('activity');
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method bydell gets posts which must be deleted
     * 
     * @return object with posts or false
     */
    public function bydell() {
        
        // Get current time
        $time = time();
        
        $this->db->select('posts.post_id,posts.user_id');
        $this->db->from('posts_meta');
        $this->db->join($this->table, 'posts_meta.post_id=posts.post_id', 'left');
        $this->db->where(['posts.dlt <' => $time,'posts.dlt!=' => '']);
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method pmet gets post's meta
     *
     * @param integer $post_id contains the post_id
     * 
     * @return object with all post's meta
     */
    public function pmet( $post_id ) {
        
        $this->db->select('*');
        $this->db->from('posts_meta');
        $this->db->where(['post_id' => $post_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        }
        
    }
    
    /**
     * The public method count_post_meta counts post's meta by post's id
     *
     * @param integer $post_id contains the post_id
     * @param string $network contains the network's name
     * 
     * @return integer with number of post's meta
     */
    public function count_post_meta( $post_id, $network ) {
        
        $this->db->select('COUNT(*) as num');
        $this->db->from('posts_meta');
        $this->db->where(['post_id' => $post_id, 'network_name' => $network]);
        $this->db->group_by('network_name');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->num;
            
        }
        
    }
    
    /**
     * The public method get_activity_by_post gets activity_by post
     *
     * @param integer $id contains the post_id
     * 
     * @return object with post's activity or false
     */
    public function get_activity_by_post( $id ) {
        
        $this->db->select('*');
        $this->db->from('activity');
        $where = ['body' => $id];
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
     * The public method update_group updates a post's group
     *
     * @param integer $user_id contains the user id
     * @param integer $post_id contains the post id
     * @param strung $value contains the group value
     * 
     * @return boolean true or false
     */
    public function update_group( $user_id, $post_id, $value ) {
        
        $this->db->set(['category' => $value]);
        $this->db->where(['post_id' => $post_id, 'user_id' => $user_id]);
        $this->db->update($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_published_posts gets published and scheduled posts
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays posts
     * @param integer $end displays the end time of displayed posts
     * 
     * @return object with posts or false
     */
    public function get_published_posts( $user_id, $start, $end ) {
        
        $this->db->select('FROM_UNIXTIME(posts.sent_time) as datetime', false);
        $this->db->select('post_id,body,title,url,img,video,sent_time,status');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'sent_time >=' => $start, 'sent_time <=' => $end]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Get results
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return '';
            
        }
        
    }

    protected function lacu() {
        
        $rd = 1;
        return $rd * 6400;
        
    }
    
}

/* End of file Posts.php */