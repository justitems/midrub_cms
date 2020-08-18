<?php
/**
 * Codes Model
 *
 * PHP Version 5.6
 *
 * Codes file contains the Codes Model
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
 * Codes class - operates the codes table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Codes extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'coupons';

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
     * The public method save_coupon saves a new coupon code in the database
     *
     * @param integer $value contains the discount value
     * @param integer $type contains the coupon type
     * 
     * @return boolean true or false
     */
    public function save_coupon( $value, $type ) {
        
        // Generate the code
        $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
        
        // Verify if the coupon already exists
        if ( !$this->get_code( $code ) ) {
        
            // Set data
            $data = ['code' => $code, 'value' => $value, 'type' => $type];

            // Save data
            $this->db->insert($this->table, $data);

            // Verify if data was saved
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
     * The public method get_codes gets all available coupon codes
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays posts
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object with posts or false
     */
    public function get_codes( $start, $limit = NULL ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        
        $this->db->order_by('coupon_id', 'desc');
        
        if ( $limit !== NULL ) {
            
            $this->db->limit($limit, $start);
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            if ( $limit !== NULL ) {
  
                // Get results
                $results = $query->result();

                return $results;
                
            } else {
                
                return $query->num_rows();
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_code verifies if a coupon code exists
     *
     * @param string $code contains the coupon code
     * 
     * @return boolean true or false
     */
    public function get_code( $code ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('code', $code);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_code deletes a coupon code
     *
     * @param integer $coupon_id contains the coupon_id
     * 
     * @return boolean true or false
     */
    public function delete_coupon( $coupon_id ) {
        
        $this->db->delete($this->table, ['coupon_id' => $coupon_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Coupons.php */