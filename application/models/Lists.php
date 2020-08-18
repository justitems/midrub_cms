<?php
/**
 * Lists Model
 *
 * PHP Version 5.6
 *
 * Lists file contains the Lists Model
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
 * Lists class - operates the lists table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Lists extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'lists';

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
     * The public method save_list creates a list
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the list's type
     * @param string $name contains the list's name
     * @param string $description contains the list's description
     * 
     * @return boolean true or false
     */
    public function save_list( $user_id, $type, $name, $description ) {
        
        // Get current time
        $created = time();
        
        // Set data
        $data = ['user_id' => $user_id, 'type' => $type, 'name' => $name, 'description' => $description, 'created' => $created];
        
        // Insert data
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted ID
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_lists gets all lists
     *
     * @param integer $user_id contains the user_id
     * @param integer $page contains the page ID
     * @param string $type contains the list's Type
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object with results or false
     */
    public function get_lists( $user_id, $page, $type, $limit=NULL ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'type' => $type]);
        $this->db->order_by('list_id', 'desc');
        
        // Verify if limit is not null
        if ( $limit ) {
            
            $this->db->limit($limit, $page);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            $query = $this->db->get();
            return $query->num_rows();
            
        }
        
    }
    
    /**
     * The public method get_lists gets all lists
     *
     * @param integer $list_id contains the list_id
     * @param string $scheduled contains the scheduled data
     * 
     * @return object with results or false
     */
    public function get_list_childs( $list_id, $scheduled ) {
        
        if ( ($scheduled[0]->con < 1) || ($scheduled[0]->template < 1) ) {
            
            $bodies = $this->get_subscribers($list_id);
            $this->db->select('*');
            $this->db->from('lists_meta');
            $this->db->where(['list_id' => $list_id]);
            $this->db->where_not_in('body', $bodies); 
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        } else if( $scheduled[0]->con == 1 ) {
            
            $template = $scheduled[0]->template;
            $bodies = $this->get_receivers($template);
            $this->db->select('*');
            $this->db->from('lists_meta');
            $this->db->where(['list_id' => $list_id]);
            $this->db->where_in('body', $bodies); 
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        } else if ( $scheduled[0]->con == 2 ) {
            
            $template = $scheduled[0]->template;
            $bodies = $this->get_receivers($template,1);
            $this->db->select('*');
            $this->db->from('lists_meta');
            $this->db->where(['list_id' => $list_id]);
            $this->db->where_in('body', $bodies); 
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method get_receivers gets emails which have received a template
     *
     * @param integer $template_id contains the template_id
     * @param integer $readed filter results per peoples which readed the template
     * 
     * @return boolean with results or false
     */
    public function get_receivers($template_id,$readed=NULL) {
        
        // Verify if $readed is not null
        if ( $readed ) {
            
            $array = ['template_id' => $template_id, 'unsubscribed<' => '1', 'readed' => '1'];
            
        } else {
            
            $array = ['template_id' => $template_id, 'unsubscribed<' => '1'];
            
        }
        
        $this->db->select('body');
        $this->db->from('scheduled_stats');
        $this->db->where($array);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = parse_array($query->result_array());
            return $result;
            
        } else {
            
            return [''];
            
        }
        
    }
    
    /**
     * The public method get_subscribers gets subscribers by list
     *
     * @param integer $list_id contains the list_id
     * 
     * @return object with results or false
     */
    public function get_subscribers( $list_id ) {
        
        $this->db->select('body');
        $this->db->from('scheduled_stats');
        $this->db->where(['unsubscribed' => '1']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = parse_array($query->result_array());
            return $result;
            
        } else {
            
            return [''];
            
        }
        
    }
    
    /**
     * The public method get_lists_meta gets all list's meta
     *
     * @param integer $user_id contains the user_id
     * @param integer $page contains the page ID
     * @param integer $list contains the list's ID
     * @param integer $limit displays the limit of displayed posts
     * @param integer $un displays active or unactive emails
     * 
     * @return object with results or false
     */
    public function get_lists_meta( $user_id, $page, $list, $un, $limit=NULL ) {
        
        if ( $un == 1 ) {
            
            $args = ['user_id' => $user_id, 'list_id' => $list, 'active' => 0];
            
        } else {
            
            $args = ['user_id' => $user_id, 'list_id' => $list];
            
        }
        
        if ( $un == 3 ) {
            
            $this->db->select('lists_meta.meta_id,networks.network_id,networks.expires,networks.network_name,networks.user_id,networks.user_name');
            $this->db->from('lists_meta');
            $this->db->join('networks', 'lists_meta.body=networks.network_id', 'left');
            $this->db->where(['lists_meta.user_id' => $user_id, 'lists_meta.list_id' => $list, 'networks.user_id' => $user_id]);
            $this->db->order_by('lists_meta.meta_id', 'desc');
            
        } else if ( $un == 4 ) {
            
            $this->db->select('lists_meta.meta_id,networks.network_id,networks.expires,networks.network_name,networks.user_id,networks.user_name');
            $this->db->from('lists_meta');
            $this->db->join('networks', 'lists_meta.body=networks.network_id', 'left');
            $this->db->like(['lists_meta.user_id' => $user_id, 'lists_meta.list_id' => $list, 'user_name' => $limit]);
            $this->db->order_by('lists_meta.meta_id', 'desc');
            
        } else {
            
            $this->db->select('*');
            $this->db->from('lists_meta');
            $this->db->where($args);
            $this->db->order_by('meta_id', 'desc');
            
        }
        
        if ( $limit || ( $un == 3 ) || ( $un == 4 ) ) {
            
            $this->db->limit($limit, $page);
            
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            $query = $this->db->get();
            return $query->num_rows();
            
        }
        
    }
    
    /**
     * The public method gets_groups_selected_accounts gets groups selected accounts
     *
     * @param integer $list_id contains the list_id
     * @param string $network_name contains the network's name
     * 
     * @return object with results or false
     */
    public function gets_groups_selected_accounts( $list_id, $network_name ) {
        
        $this->db->select('COUNT(*) as num',FALSE);
        $this->db->from('lists_meta');
        $this->db->join('networks', 'lists_meta.body=networks.network_id', 'left');
        $this->db->where(['lists_meta.list_id' => $list_id, 'networks.network_name' => $network_name]);
        $this->db->group_by('network_name');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->num;
            
        } else {
            
            return false;
            
        }
        
    }    
   
    /**
     * The public method get_lists_body gets list's body by meta_id
     *
     * @param integer $meta_id contains the meta_id
     * 
     * @return object with results or false
     */
    public function get_lists_body( $meta_id ) {
        
        $this->db->select('body');
        $this->db->from('lists_meta');
        $this->db->where(['meta_id' => $meta_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->body;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_list deletes a list by $list_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $list_id contains the list's ID
     * 
     * @return boolean true or false
     */
    public function delete_list( $user_id, $list_id ) {
        
        $this->db->delete($this->table, ['list_id' => $list_id, 'user_id' => $user_id]);
        if ( $this->db->affected_rows() ) {
            
            $this->db->delete('lists_meta', ['list_id' => $list_id, 'user_id' => $user_id]);
            $this->db->delete('scheduled', ['list_id' => $list_id]);
            $this->db->delete('scheduled_stats', ['list_id' => $list_id]);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_meta deletes a list's meta by $list_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $list_id contains the list's ID
     * @param integer $meta_id contains the meta_id
     * 
     * @return boolean true or false
     */
    public function delete_meta( $user_id, $meta_id, $list_id ) {
        
        $this->db->delete('lists_meta', ['meta_id' => $meta_id, 'list_id' => $list_id, 'user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method upload_to_list uploads items to list
     *
     * @param integer $user_id contains the user_id
     * @param integer $list contains the list's ID
     * @param string $email contains a string
     * 
     * @return boolean true or false
     */
    public function upload_to_list( $user_id, $list, $item ) {
        
        $created = time();
        if ( $this->if_item_is_in_list($user_id, $list, $item) ) {
            
            return false;
            
        }
        
        // Set data
        $data = ['user_id' => $user_id, 'list_id' => $list, 'body' => $item];
        
        // Save data
        $this->db->insert('lists_meta', $data);
        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted ID
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method if_item_is_in_list check if the item already exists
     *
     * @param integer $user_id contains the user_id
     * @param integer $list contains the list's ID
     * @param string $email contains a string
     * 
     * @return boolean true or false
     */
    public function if_item_is_in_list( $user_id, $list, $item ) {
        
        // Verify if list's meta exists
        $this->db->select('*');
        $this->db->from('lists_meta');
        $this->db->where(['user_id' => $user_id, 'list_id' => $list, 'body' => $item]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return true;
            
        } else {
            
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where(['user_id' => $user_id, 'list_id' => $list]);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                return false;
                
            } else {
                
                return true;
                
            }
            
        }
        
    }
    
    /**
     * The public method if_item_is_in_list check if the item already exists
     *
     * @param integer $user_id contains the user_id
     * @param integer $list contains the list's ID
     * @param string $type contains the list's type
     * 
     * @return boolean true or false
     */
    public function if_user_has_list($user_id, $list, $type) {
        
        $this->db->select('*');
        $this->db->from('lists');
        $this->db->where(['user_id' => $user_id, 'list_id' => $list, 'type' => $type]);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method user_lists gets user's lists
     *
     * @param integer $user_id contains the user_id
     * 
     * @return object with lists or false
     */
    public function user_lists( $user_id, $type ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'type' => $type]);
        $this->db->order_by('list_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Lists.php */