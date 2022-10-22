<?php
/**
 * Base Plans Model
 *
 * PHP Version 7.3
 *
 * Base_plans file contains the Base Plans Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Plans class - operates the plans table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
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
        
        // Load Base Plans Update Model
        $this->load->ext_model( CMS_BASE_PATH . 'models/parts/plans/', 'Base_plans_update', 'base_plans_update' );  

        // Try to update data
        return $this->base_plans_update->update_plan_meta($plan_id, $plan_metas);

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
     * The public method the_public_plans gets the plans which are public
     * 
     * @return array with data or boolean false
     */
    public function the_public_plans() {

        // Get selected groups plans
        $get_groups = $this->base_model->the_data_where(
            'plans_meta',
            'plan_id',
            array(
                'meta_name' => 'plans_group'
            )
        );

        // Ids array
        $ids = array();
        
        // Verify if selected groups plans exists
        if ( $get_groups ) {

            // List all groups
            foreach ( $get_groups as $get_group ) {

                // Set id
                $ids[] = $get_group['plan_id'];

            }

        }

        // If ids is not empty
        if ( $ids ) {

            // Select columns
            $this->db->select('plans.*, plans_meta.meta_value AS plans_group, plans_groups.group_name');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where(array(
                'plans.hidden' => 0,
                'plans_meta.meta_name' => 'plans_group'
            ));            

            // Set where in
            $this->db->where_in('plans.plan_id', $ids);

            // Set join
            $this->db->join('plans_meta', 'plans.plan_id=plans_meta.plan_id', 'LEFT');
            $this->db->join('plans_groups', 'plans_meta.meta_value=plans_groups.group_id', 'LEFT');

            // Set order
            $this->db->order_by('plans_groups.group_id', 'ASC');

        } else {

            // Select columns
            $this->db->select('plans.*');

            // From plans table
            $this->db->from('plans');

            // Set where
            $this->db->where('plans.hidden', 0);

            // Set order
            $this->db->order_by('plans.plan_id', 'ASC');

        }
        
        // Get data
        $query = $this->db->get();
        
        // Verify if data exists
        if ( $query->num_rows() > 0 ) {

            // If ids is not empty
            if ( $ids ) {

                // Get response
                $response = $query->result_array();

                // Groups array
                $groups = array();

                // List all plans
                foreach ( $response as $plan ) {

                    // Verify if group already exists
                    if ( !isset($groups[$plan['plans_group']]) ) {
                        $groups[$plan['plans_group']] = array(
                            'group_id' => $plan['plans_group'],
                            'group_name' => $plan['group_name'],
                            'plans' => array()
                        );
                    }

                    // Set plan
                    $groups[$plan['plans_group']]['plans'][] = $plan;

                }

                // Return groups
                return array_values($groups);

            } else {

                // Return data
                return $query->result_array();

            }

            
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

    /**
     * The function change_plan changes the user's plan
     *
     * @param array $params contains the data
     * 
     * @return boolean true of the plan was changed or false
     */
    public function change_plan($params) {
        
        // Load Base Plans Update Model
        $this->load->ext_model( CMS_BASE_PATH . 'models/parts/plans/', 'Base_plans_update', 'base_plans_update' );  

        // Try to change the plan
        return $this->base_plans_update->change_plan($params);
    
    }
    
}

/* End of file base_plans.php */