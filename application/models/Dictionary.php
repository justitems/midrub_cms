<?php
/**
 * Dictionary Model
 *
 * PHP Version 5.6
 *
 * Dictionary file contains the Dictionary Model
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
 * Dictionary class - operates the dictionary table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Dictionary extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'dictionary';

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
     * The public method save_word saves a word in the database
     *
     * @param integer $user_id contains the user_id
     * @param string $word contains the new word
     * 
     * @return integer last inserted id or false
     */
    public function save_word( $user_id, $word ) {
        
        // Verify if word exists
        $this->db->select('dict_id');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'name' => $word]);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 0 ) {
            
            // Set data
            $data = ['user_id' => $user_id, 'name' => $word];
            
            // Insert data
            $this->db->insert($this->table, $data);
            
            // Verify if was inserted successfully
            if ( $this->db->affected_rows() ) {
                
                return $this->db->insert_id();
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_words gets all user words
     *
     * @param integer $user_id contains the user_id
     * @param integer $page contains the page ID
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object with results or false
     */
    public function get_words( $user_id, $page, $limit=NULL ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $this->db->order_by('dict_id', 'desc');
        
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
     * The public method get_user_words gets all user words
     *
     * @param integer $user_id contains the user_id
     * 
     * @return object with results or false
     */
    public function get_user_words( $user_id ) {
        
        $this->db->select('name,body');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result_array();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_word deletes a word by $dict_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $dict_id contains the dictionary's ID
     * 
     * @return boolean true or false
     */
    public function delete_word( $user_id, $dict_id ) {
        
        $this->db->delete($this->table, ['dict_id' => $dict_id, 'user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_synonyms gets the synonym of a word
     *
     * @param integer $user_id contains the user_id
     * @param integer $word contains the dict_id
     * 
     * @return array results or false
     */
    public function get_synonyms( $user_id, $word ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['dict_id' => $word, 'user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->body;
            
        } else {
            
            return 2;
            
        }
        
    }
    
    /**
     * The public method save_synonym saves a new synonym in the database
     *
     * @param integer $user_id contains the user_id
     * @param integer $dict_id contains the dictionary's ID
     * @param integer $synonym contains the synonym
     * 
     * @return array results or false
     */
    public function save_synonym( $user_id, $dict_id, $synonym ) {
        
        // Set data
        $data = ['body' => $synonym];
        
        $this->db->where(['dict_id' => $dict_id, 'user_id' => $user_id]);
        
        $this->db->update($this->table, $data);
        
        // Verify if update was done successfully
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Dictionary.php */
