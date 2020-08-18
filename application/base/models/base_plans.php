<?php
/**
 * Base Plans Model
 *
 * PHP Version 7.2
 *
 * Base_plans file contains the Base Plans Model
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
 * Base Plans class - operates the base_plans table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_plans extends CI_MODEL {

    /**
     * Class variables
     */
    private $table = 'plans';

    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Set table
        $this->tables = $this->config->item('tables', $this->table);

    }

    /**
     * The function update_plan_meta updates or creates new plan meta
     *
     * @param integer $plan_id contains the plan's ID
     * @param array $plan_metas contains the plan's metas to update
     * 
     * @return integer with number of created/updated plan metas
     */
    public function update_plan_meta($plan_id, $plan_metas) {
        
        $count = 0;
        
        // Verify if plans metas exists
        if ( $plan_metas ) {
            
            foreach ( $plan_metas as $name => $value ) {
                
                if ( !$name ) {
                    continue;
                }
                
                $this->db->select('*');
                $this->db->from('plans_meta');
                $this->db->where(array(
                    'plan_id' => $plan_id,
                    'meta_name' => trim($name)
                    )
                );
                
                $this->db->limit(1);
                $query = $this->db->get();
                
                if ($query->num_rows() > 0) {
                    
                    $data = array(
                        'meta_value' => trim($value)
                    );                    

                    $this->db->set($data);
                    $this->db->where(array(
                            'plan_id' => $plan_id,
                            'meta_name' => trim($name)
                        )
                    );
                    
                    $this->db->update('plans_meta');

                    if ($this->db->affected_rows()) {

                        $count++;

                    }
                    
                } else {

                    $data = array(
                        'plan_id' => $plan_id,
                        'meta_name' => trim($name),
                        'meta_value' => trim($value)
                    );

                    $this->db->insert('plans_meta', $data);

                    if ($this->db->affected_rows()) {

                        $count++;

                    }
                    
                }
                
            }
            
        }
        
        return $count;

    }

    /**
     * The public method get_plans gets the plans list
     * 
     * @param array $args contains the arguments to request
     * 
     * @return object with plans or false
     */
    public function get_plans($args) {      
        
        $this->db->select('*');
        $this->db->from($this->table);

        if ( isset($args['key']) ) {

            $key = $this->db->escape_like_str($args['key']);
            $this->db->like('plan_name', $key);

        }

        $this->db->order_by('plan_id', 'desc');
        
        if ( isset($args['limit']) && isset($args['start']) ) {
            
            $this->db->limit($args['limit'], $args['start']);
            
        }
        
        $query = $this->db->get();
        
        // If $args has limit
        if ( !isset($args['limit']) ) {
            
            return $query->num_rows();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function get_plan gets a plan by $plan_id
     *
     * @param $plan_id contains the plan's id
     * 
     * @return array with plan's data or false
     */
    public function get_plan($plan_id) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('plan_id', $plan_id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            $limits = $query->result_array();
            
            $this->db->select('*');
            $this->db->from('plans_meta');
            $this->db->where(array(
                'plan_id' => $plan_id
                )
            );

            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $response = $query->result_array();
                
                foreach ( $response as $res ) {
                    
                    $limits[0][$res['meta_name']] = $res['meta_value'];
                    
                }

            }
            
            return $limits;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file base_plans.php */