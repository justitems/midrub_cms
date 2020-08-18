<?php
/**
 * User_meta Model
 *
 * PHP Version 5.6
 *
 * User_meta file contains the User_meta Model
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
 * User_meta class - operates the User_meta table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class User_meta extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'users_meta';

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
     * The public method enable_disable_user_option enables and disables an user's option
     *
     * @param integer $user_id contains user_id
     * @param string $option contains meta_name
     * 
     * @return boolean true or false
     */
    public function enable_disable_user_option( $user_id, $option ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'meta_name' => $option]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            // If the user's option is enabled, will be deleted
            $this->db->where(['user_id' => $user_id, 'meta_name' => $option]);
            $this->db->delete($this->table);
            
        } else {
            
            // If the user's option not exists, will be added with value 1
            $data = ['user_id' => $user_id, 'meta_name' => $option, 'meta_value' => '1'];
            $this->db->insert($this->table, $data);
            
        }
        
        // Check if option was saved or deleted successfully
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_all_user_options gets all user options
     *
     * @param integer $user_id contains user_id
     * 
     * @return object with options
     */
    public function get_all_user_options( $user_id ) {

        $this->db->select('meta_name,meta_value');
        $this->db->from($this->table);
        $this->db->where(
            array(
                'user_id' => $user_id
            )
        );
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $new_array = array();
            
            foreach ( $result as $data ) {
                
                $new_array[$data->meta_name] = $data->meta_value;
                
            }
            
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where(
                array(
                    'user_id' => $user_id
                )
            );

            $query = $this->db->get();

            if ( $query->num_rows() > 0 ) {

                $results = $query->result();
                
                $new_array['username'] = $results[0]->username;
                $new_array['email'] = $results[0]->email;
                $new_array['last_name'] = $results[0]->last_name;
                $new_array['first_name'] = $results[0]->first_name;

            }
            
            return $new_array;
            
        }
        
    }
    
    /**
     * The public method get_favourites gets all favourites tool
     *
     * @param integer $user_id contains user_id
     * 
     * @return object with user's favourites
     */
    public function get_favourites( $user_id ) {
        
        $this->db->select('meta_value');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'meta_name' => 'favourites']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        }
        
    }
    
    /**
     * The public method delete_favourites deletes favourites tools
     *
     * @param integer $user_id contains user_id
     * 
     * @return boolean true if the favourites were deleted
     */
    public function delete_favourites( $user_id ) {
        
        $this->db->where(['user_id' => $user_id, 'meta_name' => 'favourites']);
        
        $this->db->delete($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        }
        
    }
    
    /**
     * The public method update_favourites updates favourites
     *
     * @param integer $user_id contains user_id
     * 
     * @return boolean true or false
     */
    public function update_favourites( $user_id, $meta_value ) {
        
        $this->db->select('meta_value');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'meta_name' => 'favourites']);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            if ( $meta_value ) {
                
                $data = ['meta_value' => $meta_value];
                $this->db->where(['user_id' => $user_id, 'meta_name' => 'favourites']);
                $this->db->update($this->table, $data);
                return true;
                
            } else {
                
                $this->db->where(['user_id' => $user_id, 'meta_name' => 'favourites']);
                $this->db->delete($this->table);
                return true;
                
            }
            
        } else {
            
            $data = ['user_id' => $user_id, 'meta_name' => 'favourites', 'meta_value' => $meta_value];
            $this->db->insert($this->table, $data);
            return true;
            
        }
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method update_user_meta updates user meta
     *
     * @param integer $user_id contains user_id
     * @param string $meta_meta contains the meta_name
     * @param string $meta_value contains meta value
     * 
     * @return bolean true or false
     */
    public function update_user_meta( $user_id, $meta_name, $meta_value ) {
        
        $this->db->select('meta_value');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'meta_name' => $meta_name]);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $data = ['meta_value' => $meta_value];
            $this->db->where(['user_id' => $user_id, 'meta_name' => $meta_name]);
            $this->db->update($this->table, $data);
            
        } else {
            
            $data = ['user_id' => $user_id, 'meta_name' => $meta_name, 'meta_value' => $meta_value];
            $this->db->insert($this->table, $data);
            
        }
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file User_meta.php */
