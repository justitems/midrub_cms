<?php
/**
 * Dashboard Users Model
 *
 * PHP Version 7.4
 *
 * Dashboard_users_model contains the Dashboard Users Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}

/**
 * Dashboard_users_model class - operates the users table
 *
 * @since 0.0.8.5
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class Dashboard_users_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'users';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
    }
    
    /**
     * The public method get_last_users gets last users registered after the $time
     *
     * @param integer $time contains the time duration
     * 
     * @return array with last users or false     
     */
    public function get_last_users( $time ) {

        // Select datetime
        $this->db->select('UNIX_TIMESTAMP(date_joined) AS time, LEFT(date_joined,10) as datetime', false);

        // Select number of members
        $this->db->select('COUNT(user_id) as number', false);

        // Set table
        $this->db->from($this->table);

        // Set where parameters
        $this->db->where(array(
                'UNIX_TIMESTAMP(date_joined) >' => strtotime('-31day', time())
            )
        );

        // Group by time
        $this->db->group_by('datetime');

        // Get data
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

/* End of file dashboard_users_model.php */