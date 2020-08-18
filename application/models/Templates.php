<?php
/**
 * Templates Model
 *
 * PHP Version 5.6
 *
 * Templates file contains the Templates Model
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
 * Templates class - operates the templates table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Templates extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'templates';

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
     * The public method save_template creates a template
     *
     * @param integer $user_id contains the user_id
     * @param integer $campaign_id contains the campaign's ID
     * @param string $type contains the template's type
     * @param string $title contains the template's title
     * @param string $body contains the template's body
     * 
     * @return boolean true or false
     */
    public function save_template( $user_id, $campaign_id, $type, $title, $body ) {
        
        // Get current time
        $created = time();
        
        // Set data
        $data = ['user_id' => $user_id, 'campaign_id' => $campaign_id, 'type' => $type, 'title' => $title, 'body' => $body, 'created' => $created];
        
        // Save template
        $this->db->insert($this->table, $data);
        
        // Verify if the template was saved
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_all_templates gets all user's templates
     *
     * @param integer $user_id contains the current user_id
     * @param integer $start contains a number where start to displays posts
     * @param integer $limit contains a number which means the limit of displayed posts
     * @param integer $total contains the option if total or limited
     * 
     * @return object with all user's feeds or false
     */
    public function get_all_templates( $user_id, $start, $limit, $total = NULL ) {
        
        // Verify if user has templates
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id]);
        $this->db->order_by('template_id', 'desc');
        
        // Verify if $total is null
        if ( !$total ) {
            
            $this->db->limit($limit, $start);
            
        } else {
            
            // Will return total number of templates
            $query = $this->db->get();
            return $query->num_rows();
            
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
     * The public method get_templates gets templates by campaign_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $campaign_id contains the campaign's ID
     * 
     * @return boolean true or false
     */
    public function get_templates( $user_id, $campaign_id ) {
        
        // Verify if user has templates in the campaign 
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'campaign_id' => $campaign_id]);
        $this->db->order_by('template_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template_title gets the template's title
     *
     * @param integer $user_id contains the user_id
     * @param integer $template_id contains the template's ID
     * 
     * @return string title or false
     */
    public function get_template_title( $user_id, $template_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id,'template_id' => $template_id]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Return the title
            $result = $query->result();
            
            return $result[0]->title;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template_body gets the template's title
     *
     * @param integer $user_id contains the user_id
     * @param integer $template_id contains the template's ID
     * 
     * @return string title or false
     */
    public function get_template_body( $user_id, $template_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id,'template_id' => $template_id]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->body;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_template gets a template's content
     *
     * @param integer $template_id contains the template's ID
     * 
     * @return object with template's data or false
     */
    public function get_template( $template_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['template_id' => $template_id]);
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
     * The public method delete_template deletes a template by $template_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $template_id contains the template's ID
     * 
     * @return boolean true or false
     */
    public function delete_template( $user_id, $template_id ) {
        
        $this->db->delete($this->table, ['user_id' => $user_id,'template_id' => $template_id]);
        if ( $this->db->affected_rows() ) {
            
            $this->db->delete('scheduled', ['template_id' => $template_id]);
            $this->db->delete('scheduled_stats', ['template_id' => $template_id]);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method set_list sets the template's list
     *
     * @param integer $template_id contains the template's ID
     * @param integer $list_id contains the list's ID
     * 
     * @return boolean true or false
     */
    public function set_list( $template_id, $list_id, $user_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['template_id' => $template_id,'user_id' => $user_id,'list_id' => $list_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $this->db->set(['list_id' => '0']);
            $this->db->where(['template_id' => $template_id,'user_id' => $user_id]);
            $this->db->update($this->table);
            
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            $this->db->set(['list_id' => $list_id]);
            $this->db->where(['template_id' => $template_id,'user_id' => $user_id]);
            $this->db->update($this->table);
            
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
}

/* End of file Templates.php */