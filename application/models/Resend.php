<?php
/**
 * Resend Model
 *
 * PHP Version 5.6
 *
 * Resend file contains the Resend Model
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
 * Resend class - operates the resend table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Resend extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'resend';

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
     * The public method save_resend saves a resend
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function save_resend( $user_id, $date ) {
        
        // Set data
        $data = ['user_id' => $user_id, 'time' => $date, 'created' => time(), 'updated' => the_time(), 'active' => 1];
        
        // Save data
        $this->db->insert($this->table, $data);
        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method save_meta saves a resend meta
     *
     * @param integer $resend_id contains the resend_id
     * @param integer $rule1 contains the first planner rule
     * @param integer $rule2 contains the second planner rule
     * @return boolean true or false
     */
    public function save_meta( $resend_id, $rule1, $rule2, $rule3, $rule4 ) {
        
        // Set data
        $data = ['resend_id' => $resend_id, 'rule1' => $rule1, 'rule2' => $rule2, 'rule3' => $rule3, 'rule4' => $rule4];
        
        // Save data
        $this->db->insert('resend_meta', $data);
        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            
            $id = $this->db->insert_id();
            $this->db->where(['resend_id' => $resend_id]);
            $this->db->update('resend', ['active' => 1]);
            return $id;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method save_rules saves a resend rule
     *
     * @param integer $resend_id contains the resend_id
     * @param integer $meta_id contains the meta_id
     * @param integer $totime contains the scheduled time
     * @param integer $status contains the scheduled status
     * 
     * @return integer with inserted id or false
     */
    public function save_rules( $resend_id, $meta_id, $totime, $status ) {
        
        // Verify if $totime is not numeric
        if ( !is_numeric($totime) ){
            
            return false;
            
        }
        
        // Set data
        $data = ['resend_id' => $resend_id, 'meta_id' => $meta_id, 'status' => $status, 'totime' => $totime];
        
        // Save data
        $this->db->insert('resend_rules', $data);
        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
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
    public function get_posts( $user_id, $start=NULL, $limit=NULL, $key=NULL ) {
        
        $this->db->select('*');
        $this->db->from('posts');
        $data = ['user_id' => $user_id];
        
        if ( ($start == 2) || ($key == 2) ) {
            $data['resend >'] = 0;
        }
        $this->db->where($data);
        $this->db->order_by('post_id', 'desc');
        
        if ( $limit ) {
            
            $this->db->limit($limit, $start);
            
        }
        
        if ( ($start == 1) || ($key == 1) ) {
            
            $this->db->order_by('sent_time', 'desc');
            
        } else if ( ($start == 2) || ($key == 2) ) {
            
            $this->db->order_by('resend', 'desc');
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Get results
            $results = $query->result();

            // Create a new arrayz
            $array = [];

            foreach ( $results as $result ) {

                // Each result will be a new object
                $array[] = (object) array(
                    'post_id' => $result->post_id,
                    'body' => htmlentities($result->body),
                    'title' => $result->title,
                    'url' => $result->url,
                    'video' => $result->video,
                    'img' => $result->img,
                    'sent_time' => $result->sent_time,
                    'status' => $result->status
                );

            }
            
            return $array;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_templates gets all templates from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays templates
     * @param integer $limit displays the limit of displayed templates
     * @param string $key contains the search key
     * @return object with templates or false
     */
    public function get_templates( $user_id, $start=NULL, $limit=NULL, $key=NULL ) {
        
        $this->db->select('templates.template_id,campaigns.campaign_id,campaigns.name,templates.body,templates.title,templates.created,templates.resend,templates.list_id');
        $this->db->from('templates');
        $this->db->join('campaigns', 'campaigns.campaign_id=templates.campaign_id', 'left');
        $data = ['templates.user_id' => $user_id];
        
        if ( ($start == 2) || ($key == 2) ) {
            
            $data['templates.resend >'] = 0;
            
        }
        
        $this->db->where($data);
        $this->db->order_by('templates.template_id', 'desc');
        
        if ( $limit ) {
            
            $this->db->limit($limit, $start);
            
        }
        
        if ( ($start == 1) || ($key == 1) ) {
            
            $this->db->order_by('templates.created', 'desc');
            
        } else if ( ($start == 2) || ($key == 2) ) {
            
            $this->db->order_by('templates.resend', 'desc');
            
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
     * The public method get_aleator_rules gets aleator schedules
     * 
     * @return object with rules or false
     */
    public function get_aleator_rules() {
        
        $this->db->select('resend_rules.rule_id,resend_rules.resend_id,resend_rules.status,resend_rules.totime');
        $this->db->from('resend_rules');
        $this->db->join('resend', 'resend_rules.resend_id=resend.resend_id', 'left');
        $this->db->where(['resend_rules.status' => 1, 'resend_rules.active' => 1, 'resend_rules.totime >' => time()]);
        $this->db->order_by('resend_rules.totime', 'desc');
        $this->db->limit(10);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_post_resend_id checks if a post has a resend id
     *
     * @param integer $user_id contains the user_id
     * @param integer $posts contains the post's ID
     * 
     * @return integer with post's id or false
     */
    public function get_post_resend_id( $user_id, $post_id ) {
        
        $this->db->select('resend');
        $this->db->from('posts');
        $this->db->where(['post_id' => $post_id, 'user_id' => $user_id, 'resend >' => 0]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->resend;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template_resend_id checks if a template has a resend id
     *
     * @param integer $user_id contains the user_id
     * @param integer $template contains the template's ID
     * 
     * @return integer with resend or false
     */
    public function get_template_resend_id( $user_id, $template_id ) {
        
        $this->db->select('resend');
        $this->db->from('templates');
        $this->db->where(['template_id' => $template_id, 'user_id' => $user_id, 'resend >' => 0]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->resend;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_rule_by_id gets rule by meta_id
     *
     * @param integer $meta_id contains the rule meta's ID
     * @return object with rules or false
     */
    public function get_rule_by_id( $meta_id ) {
        
        $this->db->select('*');
        $this->db->from('resend_rules');
        $this->db->where(['meta_id' => $meta_id]);
        $this->db->order_by('rule_id', 'desc');
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
     * The public method get_rules_by_id gets rules by meta_id
     *
     * @param integer $meta_id contains the rule meta's ID
     * @return object with rules or false
     */
    public function get_rules_by_id( $meta_id ) {
        
        $this->db->select('*');
        $this->db->from('resend_rules');
        $this->db->where(['meta_id' => $meta_id]);
        $this->db->order_by('rule_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_active_rules get rules
     * 
     * @return object with active rules or false
     */
    public function get_active_rules() {
        
        $this->db->select('*');
        $this->db->from('resend_rules');
        $this->db->where(['totime <' => time(), 'status' => 1]);
        $this->db->limit(10);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_post_by_resend_id gets post by resend id 
     *
     * @param integer $resend_id contains the resend's id
     * 
     * @return object with post's data or false
     */
    public function get_post_by_resend_id( $resend_id ) {
        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where(['resend' => $resend_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template_by_resend_id gets template by resend id 
     *
     * @param integer $resend_id contains the resend's id
     * 
     * @return object with templates or false
     */
    public function get_template_by_resend_id( $resend_id ) {
        
        $this->db->select('*');
        $this->db->from('templates');
        $this->db->where(['resend' => $resend_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }    
    
    /**
     * The public method get_resend_post gets resend's post
     *
     * @param integer $user_id contains the user_id
     * @param integer $resend_id contains the resend's ID
     * 
     * @return integer with post id or false
     */
    public function get_resend_post( $resend_id, $b = NULL ) {
        
        if ( $b ) {
            
            $this->db->select('*');
            
        } else {
            
            $this->db->select('post_id');
            
        }
        
        $this->db->from('posts');
        $this->db->where(['resend' => $resend_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            if ( $b ) {
                
                return $result;
                
            } else {
                
                return $result[0]->post_id;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_rules gets resend's rules
     *
     * @param integer $user_id contains the user_id
     * @param integer $post_id contains the post_id
     * 
     * @return object with rules or false
     */
    public function get_rules( $user_id, $post_id ) {
        
        $resend_id = $this->get_post_resend_id($user_id,$post_id);
        
        if ( !$resend_id ) {
            
            return false;
            
        }
        
        $this->db->select('resend_rules.rule_id,resend_rules.resend_id,resend_rules.status,resend_rules.totime,UNIX_TIMESTAMP(CURRENT_TIMESTAMP) as tim',FALSE);
        $this->db->from('resend_rules');
        $this->db->join('resend', 'resend_rules.resend_id=resend.resend_id', 'left');
        $this->db->where(['resend.user_id' => $user_id, 'resend_rules.resend_id' => $resend_id]);
        $this->db->order_by('resend_rules.totime', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_rules_for_temp gets resend's rules
     *
     * @param integer $user_id contains the user_id
     * @param integer $template_id contains the template_id
     * @return object with rules or false
     */
    public function get_rules_for_temp( $user_id, $template_id ) {
        
        $resend_id = $this->get_template_resend_id($user_id,$template_id);
        if ( !$resend_id ) {
            
            return false;
            
        }
        
        $this->db->select('resend_rules.rule_id,resend_rules.resend_id,resend_rules.status,resend_rules.totime,UNIX_TIMESTAMP(CURRENT_TIMESTAMP) as tim',FALSE);
        $this->db->from('resend_rules');
        $this->db->join('resend', 'resend_rules.resend_id=resend.resend_id', 'left');
        $this->db->where(['resend.user_id' => $user_id, 'resend_rules.resend_id' => $resend_id]);
        $this->db->order_by('resend_rules.totime', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_posts gets all posts from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $id contains the resend's ID
     * 
     * @return object with metas or false
     */
    public function get_metas( $user_id, $id ) {
        
        $this->db->select('resend.resend_id,resend_meta.meta_id,resend_meta.rule1,resend_meta.rule2,resend_meta.rule3,resend_meta.rule4');
        $this->db->from('resend_meta');
        $this->db->join('resend', 'resend_meta.resend_id=resend.resend_id', 'left');
        $this->db->where(['resend.user_id' => $user_id, 'resend_meta.resend_id' => $id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete deletes a resend
     *
     * @param integer $resend_id contains the resend_id
     * @return boolean true or false
     */
    public function delete( $resend_id, $temp=NULL ) {
        
        $this->db->delete($this->table, ['resend_id' => $resend_id]);
        
        if ( $this->db->affected_rows() ) {
            
            $this->db->where('resend', $resend_id);
            
            if( $temp ) {
                
                $this->db->update('templates', ['resend' => 0]);
                
            } else {
                
                $this->db->update('posts', ['resend' => 0]);
                
            }
            
            $this->db->delete('resend_meta', ['resend_id' => $resend_id]);
            $this->db->delete('resend_rules', ['resend_id' => $resend_id]);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_meta_by deletes resend meta
     *
     * @param integer $resend contains the resend_id
     * @param integer $meta contains the meta_id
     * 
     * @return boolean true or false
     */
    public function delete_meta_by( $resend, $meta ) {
        
        $this->db->delete('resend_meta', ['meta_id' => $meta, 'resend_id' => $resend]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method finished_planner mark as finished a planner
     *
     * @param integer $resend contains the resend_id
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function finished_planner( $resend, $user_id ) {
        
        // Load Notifications model
        $this->load->model('Notifications', 'notifications');
        $this->db->where(['resend_id' => $resend]);
        $this->db->update('resend', ['active' => 0]);
        
        if ( $this->db->affected_rows() ) {
            
            // Verify if the user wants to receive the notification
            if ( get_user_option('send_notification_planner',$user_id) ) {
                
                $post = $this->get_resend_post($resend, 1);
                
                if ( $post ) {
                    
                    $this->notifications->send_notification($user_id, 'planned-completed-confirmation', $post[0]->body);
                    
                }
                
            }
            
            if ( get_user_option('send_notification_planne',$user_id) ) {
                
                $template = $this->get_template_by_resend_id($resend);
                
                if ( $template ) {
                    
                    $this->notifications->send_notification($user_id, 'planned-email-completed-confirmation', $template[0]->title);
                    
                }
                
            }
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method cancel_planner_sched cancel scheduling
     *
     * @param integer $resend_id contains the resend_id
     * @param integer $rule_id contains the rule_id
     * 
     * @return boolean true or false
     */
    public function cancel_planner_sched( $resend_id, $rule_id ) {
        
        $this->db->where(['rule_id' => $rule_id, 'resend_id' => $resend_id]);
        $this->db->update('resend_rules', ['status' => 3]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method done_planner_sched mark a schedule like published
     *
     * @param integer $resend_id contains the resend_id
     * @param integer $rule_id contains the rule_id
     * 
     * @return boolean true or false
     */
    public function done_planner_sched( $resend_id, $rule_id ) {
        
        $this->db->where(['rule_id' => $rule_id, 'resend_id' => $resend_id]);
        $this->db->update('resend_rules', ['status' => 2]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method edit_resend_meta edits resend meta
     *
     * @param integer $resend contains the resend_id
     * @param integer $meta contains the meta_id
     * @param string $rule contains rule value
     * @param string $type contains the rule's type
     * 
     * @return boolean true or false
     */
    public function edit_resend_meta( $resend, $meta, $rule, $type ) {
        
        $this->db->where(['resend_id' => $resend, 'meta_id' => $meta]);
        $this->db->update('resend_meta', [$type => $rule]);
        
        if ( $this->db->affected_rows() ) {
            
            $this->db->where(['resend_id' => $resend]);
            $this->db->update('resend', ['active' => 1]);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_meta_publishes gets resend's data
     *
     * @param integer $meta contains the meta_id
     * 
     * @return object meta's data or false
     */
    public function get_meta_publishes( $meta ) {
        
        $this->db->select('meta_id');
        $this->db->from('resend_rules');
        $this->db->where(['meta_id' => $meta]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method setup adds a resend to a post
     *
     * @param integer $post_id contains the post_id
     * @param integer $resend_id contains the resend_id
     * 
     * @return boolean true or false
     */
    public function setup( $post_id, $resend_id ) {
        
        $this->db->where('post_id', $post_id);
        $this->db->update('posts', ['resend' => $resend_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method setup_temp adds a resend to a template
     *
     * @param integer $template_id contains the template_id
     * @param integer $resend_id contains the resend_id
     * @param integer $list_id contains the list_id
     * 
     * @return boolean true or false
     */
    public function setup_temp( $template_id, $resend_id, $list_id = NULL ) {
        
        $data = ['resend' => $resend_id];
        if( is_numeric($list_id) ) {
            
            $data['list_id'] = $list_id;
            
        }
        
        $this->db->where('template_id', $template_id);
        $this->db->update('templates', $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method updatup updates updated column
     *
     * @param integer $resend_id contains the resend_id
     * 
     * @return boolean true or false
     */
    public function updatup( $resend_id ) {
        
        $this->db->where('resend_id', $resend_id);
        $this->db->update('resend', ['updated' => the_time()]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_active_resend gets active resends
     * 
     * @return object with resends or false
     */
    public function get_active_resend() {
        
        $this->db->select('*');
        $this->db->from('resend');
        $this->db->where(['active' => 1, 'updated <' => time() - 604800]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_resend_type gets the resend type
     * 
     * @param integer $resend_id contains the resend_id
     * 
     * @return integer with resend type
     */
    public function get_resend_type( $resend_id ) {
        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where(['resend' => $resend_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return 1;
            
        } else {
            
            $this->db->select('*');
            $this->db->from('templates');
            $this->db->where(['resend' => $resend_id]);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                return 2;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
}

/* End of file Resend.php */