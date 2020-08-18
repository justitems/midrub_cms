<?php
/**
 * Networks Model
 *
 * PHP Version 5.6
 *
 * Networks file contains the Networks Model
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
 * Network class - operates the Networks table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Networks extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'networks';

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
     * The public method add_network will add new network connection
     *
     * @param string $name contains the network's name
     * @param integer $net_id contains the user id from the social network
     * @param integer $user_id contains the user id
     * @param string $expires contains the date when the session will expire
     * @param string $user_name the username from the social network
     * @param string $user_avatar contains the avatar url
     * @param string $secret contains to token secret
     * 
     * @return boolean true or false
     */
    public function add_network( $name, $net_id, $token, $user_id, $expires, $user_name, $user_avatar, $secret = null, $app_id = null, $app_secret = null ) {
        
        // First verify if the account was already added
        $this->db->select( 'network_id' );
        
        $this->db->from( $this->table );
        
        $this->db->where( ['network_name' => strtolower($name), 'net_id' => $net_id, 'user_id' => $user_id] );
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            return $result[0]->network_id;
            
        }
        
        $secret = ($secret == null) ? ' ' : $secret;
        
        if ( ($app_id != NULL) && ($app_secret != NULL) ) {
            
            // Add new row
            $data = array(
                'network_name' => strtolower($name),
                'net_id' => $net_id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_avatar' => $user_avatar,
                'date' => date('Y-m-d h:i:s'),
                'expires' => $expires,
                'token' => $token,
                'secret' => $secret,
                'api_key' => $app_id,
                'api_secret' => $app_secret
            );
            
        } else {
            
            // Add new row
            $data = array(
                'network_name' => strtolower($name),
                'net_id' => $net_id,
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_avatar' => $user_avatar,
                'date' => date('Y-m-d h:i:s'),
                'expires' => $expires,
                'token' => $token,
                'secret' => $secret
            );
            
        }
        
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method update_network will reset the token and expiration date
     *
     * @param integer $network_id contains the network ID
     * @param integer $user_id contains the user id
     * @param string $expires contains the date when the session will expire
     * @param string $token contains the access token
     * @param string $secret contains to token secret
     * 
     * @return boolean true or false
     */
    public function update_network( $network_id, $user_id, $expires, $token, $secret = null ) {
        
        // Delete data if exists
        $data = ['expires' => $expires, 'token' => $token];
        
        if ( $secret ) {
            $data['secret'] = $secret;
        }
        
        $this->db->where(['network_id' => $network_id, 'user_id' => $user_id]);
        $this->db->update($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_networks gets all network connection(that are not expired).
     *
     * @param integer $user_id contains the user id
     * 
     * @return array with networks or false 
     */
    public function get_networks($user_id) {
        
        $this->db->select('network_name,net_id,UNIX_TIMESTAMP(expires) AS expires');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $this->db->group_by('network_name');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // This array was created only to check if a network was disabled
            $new_array = [];
            
            // Load options model
            $this->load->model('Options', 'options');
            
            foreach ( $result as $data ) {
                
                if ( $this->options->check_enabled(strtolower($data->network_name)) == false ) {
                    
                    continue;
                    
                }
                
                $new_array[] = ['network_name' => $data->network_name, 'net_id' => $data->net_id, 'expires' => $data->expires];
                
            }
            
            return $new_array;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_networks gets all user's accounts
     *
     * @param integer $user_id contains the user id
     * @param string $network contains the network name
     * 
     * @return object with user networks or false
     */
    public function get_user_networks( $user_id, $network = NULL ) {
        
        $this->db->select('network_id');
        $this->db->from($this->table);
        
        // Verify if $network is not null
        if ( $network ) {
            
            $this->db->where( ['user_id' => $user_id, 'network_name' => $network ] );
            
        } else {
            
            $this->db->where( 'user_id', $user_id );
            
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
     * The public method get_expired_tokens gets a list with all expired tokens
     *
     * @param integer $user_id contains the user id
     * 
     * @return object with expired accounts
     */
    public function get_expired_tokens( $user_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'UNIX_TIMESTAMP(expires) <' => time() + 432000, 'LENGTH(expires) >' => 5]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_accounts gets social networks accounts from database
     *
     * @param integer $user_id contains the user id
     * @param string $network contains the network's name
     * @param integer $start contains the page number
     * @param string $key contains the search key
     * 
     * @return object with accounts or false
     */    
    public function get_accounts( $user_id, $network, $start=0, $key = NULL ) {
        
        if( $key == NULL ) {
            
               $this->db->select('networks.network_id,networks.user_name,networks.net_id,networks.expires,networks.api_key,networks.api_secret,COUNT(posts_meta.meta_id) AS num');
               $this->db->from($this->table);
               $this->db->join('posts_meta', 'networks.network_id=posts_meta.network_id', 'left');
               
        } else {
            
               $this->db->select('networks.network_id,networks.user_name,networks.net_id,networks.expires');
               $this->db->from($this->table);
               
        }
        
        $this->db->where(['networks.user_id'=>$user_id,'networks.network_name'=>strtolower($network)]);
        
        if ( $key != NULL ) {
            
               $this->db->like('networks.user_name', $key);
               
        } else {
            
               $this->db->group_by('networks.network_id');
               $this->db->order_by('num', 'desc');
               
        }
        
        $this->db->limit(10, $start);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_account by network_id
     *
     * @param integer $network_id contains the network_id
     * 
     * @return object with account data or false
     */    
    public function get_account( $network_id ) {
        
	$this->db->select('*');
	$this->db->from($this->table);
	$this->db->where('network_id', $network_id);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method add_new_post_meta allows to add a new meta to a existing post
     *
     * @param integer $user_id contains the current user_id
     * @param integer $post contains the current post_id
     * @param integer $net contains the network_id
     * 
     * @return boolean false if post meta wasn't saved successfully 
     */    
    public function add_new_post_meta( $user_id, $post, $net ) {
        
        // Load posts model
        $this->load->model('Posts', 'posts');
	$this->db->select('*');
	$this->db->from($this->table);
	$this->db->where(['network_id' => $net, 'user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            $network_name = $result[0]->network_name;
            
            // Verify if the user is the post's author
            if ( $this->posts->get_post($user_id,$post) && $this->if_posts_has_the_meta($post,$net) != TRUE ) {
                
                $data = ['post_id' => $post, 'network_id' => $net, 'network_name' => $network_name, 'sent_time' => time()];
                $this->db->insert('posts_meta', $data);
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_user_post_meta deletes a post's meta
     *
     * @param integer $user_id contains the current user_id
     * @param integer $post contains the current post_id
     * @param integer $net contains the network_id
     * 
     * @return boolean false if post meta wasn't deleted
     */    
    public function delete_user_post_meta( $user_id, $post, $net ) {
        
	$this->db->select('*');
	$this->db->from('posts');
	$this->db->where(['post_id' => $post, 'user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $this->db->delete('posts_meta', ['post_id' => $post, 'meta_id' => $net]);
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method if_posts_has_the_meta checks if the post has the meta
     *
     * @param integer $post contains the current post_id
     * @param integer $network_id contains the network_id
     * 
     * @return boolean true or false
     */    
    public function if_posts_has_the_meta($post,$net) {
	
        $this->db->select('*');
	$this->db->from('posts_meta');
	$this->db->where(['post_id' => $post, 'network_id' => $net]);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            $result = $query->result();
            return TRUE;
            
        } else {
            
            return FALSE;
            
        }
        
    }    
    
    /**
     * The public method count_all_accounts counts all user's accounts from a social network
     *
     * @param string $network contains the network's name
     * @param integer $user_id contains the user id
     * @param string $key contains the search key
     * 
     * @return integer with number of accounts or false
     */
    public function count_all_accounts( $user_id, $network, $key = null ) {
        
        // Load options model
        $this->load->model('Options', 'options');
        
        // Check if the network is disabled
        if ( $this->options->check_enabled(strtolower($network)) == false ) {
            
               return false;
               
        }
        
        $this->db->select('network_id');
        $this->db->from($this->table);
        $this->db->where(['network_name'=>$network,'user_id'=>$user_id]);
        
        if ( $key ) {
            
            $this->db->like('user_name', $key);
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_all_accounts gets all user's accounts from a social network
     *
     * @param string $network contains the network's name
     * @param integer $user_id contains the user id
     * 
     * @return object with accounts or false
     */    
    public function get_all_accounts( $user_id, $network ) {
        
        // Load options model
        $this->load->model('Options', 'options');
        
        // Check if the network is disabled
        if ( $this->options->check_enabled(strtolower($network)) == false ) {
            
            return false;
               
        }
        
        $this->db->select('network_id,user_name,net_id,expires,token,secret');
        $this->db->from($this->table);
        $this->db->where(['network_name'=>$network,'user_id'=>$user_id]);
        $this->db->order_by('network_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_account_was_added checks if an user's social account exists in the database
     *
     * @param string $network contains the network's name
     * @param integer $net_id contains the user id from the social network
     * @param integer $user_id contains the user id
     * 
     * @return boolean true or false
     */
    public function check_account_was_added( $network, $net_id, $user_id ) {
        
        $this->db->select('net_id');
        $this->db->from($this->table);
        $this->db->where(['network_name'=>$network,'net_id'=>$net_id,'user_id'=>$user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }   
        
    }
    
    /**
     * The public method delete_network will delete a network account from the database
     *
     * @param integer $account_id contains the id account
     * @param integer $user_id contains the user id
     * 
     * @return boolean true or false
     */
    public function delete_network( $account_id, $user_id ) {
        
        if ( $account_id == 'all' ) {
            
            // Delete all social networks connections
            $this->db->delete($this->table, ['user_id' => $user_id]);
            
        } else {
            
            // Delete the $name social network's connection
            $this->db->delete($this->table, ['network_id'=>$account_id,'user_id'=>$user_id]);
            
        }
        
        if ( $this->db->affected_rows() ) {
            
            // Load Activity model
            $this->load->model('Activity', 'activity');
            
            // Delete the posts_meta
            $this->db->delete('posts_meta', ['network_id'=>$account_id]);
            
            // Delete all bots for this account
            $activities = $this->activity->get_activities_by_account_id($account_id);
            
            if ( $activities ) {
                
                foreach ( $activities as $activity ) {
                    
                    // Delete the bots for this activity
                    $this->db->delete('bots', ['rule1' => $activity->activity_id, 'type' => 'promotis-comment']);
                    $this->db->delete('bots', ['rule1' => $activity->activity_id, 'type' => 'promotis-com-opts']);
                    $this->db->delete('bots', ['rule1' => $activity->activity_id, 'type' => 'promotis-history']);
                    $this->db->delete('bots', ['rule6' => $account_id, 'type' => 'promotis-favourites']);
                    
                }
                
            }
            
            // Delete other bots
            $this->db->delete('bots', ['rule6' => $account_id, 'type' => 'twilos-opts']);
            $this->db->delete('bots', ['rule6' => $account_id, 'type' => 'inlike-opts']);
            $this->db->delete('bots', ['rule6' => $account_id, 'type' => 'instavy-opts']);
            $this->db->delete('bots', ['rule2' => $account_id, 'type' => 'retweet']);
            $this->db->delete('bots', ['rule6' => $account_id, 'type' => 'retweet']);
            $this->db->delete('bots', ['rule1' => $account_id, 'type' => 'dmitas-opts']);
            
            // Delete the activity
            $this->db->delete('activity', ['network_id'=>$account_id]);
            
            // Delete the activity_meta
            $this->db->delete('activity_meta', ['network_id'=>$account_id]);
            
            // Delete account from a group
            $this->db->delete('lists_meta', ['body'=>$account_id,'user_id'=>$user_id]);
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_account_field gets a column from a row
     *
     * @param integer $user_id contains the user ID
     * @param integer $net_id contains the user network id
     * @param string $field contains the column name
     * 
     * @return string with requested field or false
     */
    public function get_account_field( $user_id, $net_id, $field ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['net_id'=>$net_id,'user_id'=>$user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->$field;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_network_data checks if user are connected to $network
     *
     * @param string $networks contains the network's name
     * @param integer $network_id contains the network id from the DB
     * @param integer $user_id contains the user id
     * 
     * @return object with network data or false
     */
    public function get_network_data( $network, $user_id, $network_id=null ) {
        
        $this->db->select('network_id,net_id,network_name,user_name,expires,user_avatar,token,secret,api_key,api_secret,COUNT(network_name) AS num');
        $this->db->from($this->table);
        
        if ( $network_id != null ) {
            
            $this->db->where(['network_name'=>strtolower($network),'user_id'=>$user_id,'network_id'=>$network_id]);
            
        } else {
            
            $this->db->where(['network_name'=>strtolower($network),'user_id'=>$user_id]);
            
        }
        
        $this->db->group_by(['network_name']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_network_accounts checks if user are connected to $network
     *
     * @param $network contains the network's name
     * 
     * @return object with results or false
     */
    public function get_network_accounts( $network ) {
        
        $this->db->select('network_id,net_id,network_name,user_name,user_avatar,token,secret');
        $this->db->from($this->table);
        $this->db->where(array('network_name'=>strtolower($network)));
        $this->db->group_by('network_id');
        $query = $this->db->get();
        
        return $query->num_rows();
        
    }
    
}
/* End of file Networks.php */
