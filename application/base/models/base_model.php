<?php
/**
 * Base Model
 *
 * PHP Version 7.2
 *
 * Base_model file contains the Base Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base_model class - is the main model with generic methods
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_model extends CI_MODEL {

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
    }

    /**
     * The public method insert adds new data in the database
     *
     * @param string $table contains the database's table
     * @param array $args contains the array with arguments to insert
     * 
     * @return integer with last inserted id or boolean false
     */
    public function insert($table, $args) {     
        
        // Save data
        $this->db->insert($table, $args);
        
        // Verify if the data was saved
        if ( $this->db->affected_rows() ) {

            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method update_ceil updates a ceil(deprecated)
     *
     * @param string $table contains the database's table
     * @param array $where contains where option
     * @param array $update contains array with params to update
     * 
     * @return boolean true or false
     */
    public function update_ceil( $table, $where, $update ) {
        
        if ( $this->update( $table, $where, $update ) ) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * The public method update updates one or more rows
     *
     * @param string $table contains the database's table
     * @param array $where contains where option
     * @param array $update contains array with params to update
     * 
     * @return boolean true or false
     */
    public function update( $table, $where, $update ) {
        
        // Verify if user exists
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {

            // Update ceil
            $this->db->where($where);
            $this->db->update($table, $update);

            // Verify if data was updated
            if ($this->db->affected_rows()) {

                return true;

            } else {

                return false;

            } 
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_data_where gets data where parameters meets the request
     *
     * @param string $table contains the database's table
     * @param string $select contains ceils to select
     * @param array $where contains where option
     * @param array $where_in contains where in parameters
     * @param array $like contains the like parameters
     * @param array $joins contains the tables to join
     * @param array $order_limit contains the order and limits parameters
     * 
     * @return array with data or boolean false
     */
    public function get_data_where( $table, $select, $where=array(), $where_in=array(), $like=array(), $joins = array(), $order_limit = array() ) {
        
        $this->db->select($select);
        $this->db->from($table);

        // List all joined tables
        for ( $j = 0; $j < count($joins); $j++ ) {

            // Join table
            $this->db->join($joins[$j]['table'], $joins[$j]['condition'], $joins[$j]['join_from']);

        }

        if ( $where ) {

            $this->db->where($where);

        } 
        
        if ( $where_in ) {

            $this->db->where_in($where_in[0], $where_in[1]);

        }

        if ( $like ) {
            
            $this->db->like($like);

        }

        if ( !empty($order_limit['group_by']) ) {

            $this->db->group_by($order_limit['group_by']);

        }        

        if ( !empty($order_limit['order']) ) {

            $this->db->order_by($order_limit['order'][0], $order_limit['order'][1]);

        }

        if ( !empty($order_limit['limit']) ) {

            $start = !empty($order_limit['start'])?$order_limit['start']:'0';

            $this->db->limit($order_limit['limit'], $start);

        }        

        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            // Return data
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The function delete deletes data from data base
     *
     * @param string $table contains the database's table
     * @param array $where contains where option
     * 
     * @return boolean true or false
     */
    public function delete( $table, $where ) {

        $this->db->delete(
            $table,
            $where
        );
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

}

/* End of file base_model.php */