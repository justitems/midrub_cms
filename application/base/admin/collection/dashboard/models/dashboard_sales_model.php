<?php
/**
 * Dashboard Sales Model
 *
 * PHP Version 7.3
 *
 * Dashboard_sales_model contains the Dashboard Sales Model
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
 * Dashboard_sales_model class - operates the sales table
 *
 * @since 0.0.8.1
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Dashboard_sales_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'transactions';

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
     * The public method get_last_sales gets last sales registered after the $time
     * 
     * @return array with last sales or false     
     */
    public function get_last_sales() {

        $this->db->select('LEFT(FROM_UNIXTIME(created),7) as datetime, LEFT(FROM_UNIXTIME(created),10) as fulltime', false);
        $this->db->select('COUNT(transaction_id) as number', false);
        $this->db->from($this->table);
        $this->db->where(array(
                'status' => 1,
                'created >' => strtotime('-30day', time())
            )
        );
        $this->db->group_by('datetime');
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {
            
            // Return data
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file dashboard_sales_model.php */