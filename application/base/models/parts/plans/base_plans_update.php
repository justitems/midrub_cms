<?php
/**
 * Base Plans Update Model
 *
 * PHP Version 7.3
 *
 * Base_plans_update file contains the Base Plans Update Model
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
 * Base Plans class - operates the plans table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_plans_update extends CI_MODEL {

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
     * The function change_plan changes the user's plan
     *
     * @param array $params contains the data
     * 
     * @return boolean true of the plan was changed or false
     */
    public function change_plan($params) {

        // Verify if the expected data exists
        if ( empty($params['plan_id']) || empty($params['user_id']) || empty($params['period']) ) {
            return false;
        }

        // Will be changed the plan
        $this->db->select('*');

        // Select from
        $this->db->from('users_meta');

        // Where
        $this->db->where(array(
            'user_id' => $params['user_id'],
            'meta_name' => 'plan'
        ));

        // Set limit
        $this->db->limit(1);

        // Get data
        $query = $this->db->get();
        
        // Verify if user has a plan
        if ( $query->num_rows() > 0 ) {

            // Get plan
            $plans = $query->result_array();

            // Verify if user has same plan
            if ( $plans[0]['meta_value'] != $params['plan_id'] ) {

                // Renew period
                $data = array(
                    'meta_value' => $params['plan_id']
                );

                // Set where
                $this->db->where(
                    array(
                        'user_id' => $params['user_id'],
                        'meta_name' => 'plan'
                    )
                );

                // Update
                $this->db->update('users_meta', $data);

                // Select
                $this->db->select('*');

                // From
                $this->db->from('users_meta');

                // Where
                $this->db->where(
                    array(
                        'user_id' => $params['user_id'],
                        'meta_name' => 'plan_end'
                    )
                );

                // Set limit
                $this->db->limit(1);
                
                // Get
                $query = $this->db->get();
                
                // Verify if data exists
                if ( $query->num_rows() > 0 ) {

                    // Set time
                    $date = strtotime('+' . $params['period'] . ' day', time());

                    // Set plan's end
                    $plan_end = date('Y-m-d H:i:s', $date);

                    // Set data
                    $data = array(
                        'user_id' => $params['user_id'],
                        'meta_name' => 'plan_end',
                        'meta_value' => $plan_end
                    );
                    
                    // Set where
                    $this->db->where(
                        array(
                            'user_id' => $params['user_id'],
                            'meta_name' => 'plan_end'
                        )
                    );
                    
                    // Update
                    $this->db->update('users_meta', $data);

                } else {

                    // Set time
                    $date = strtotime('+' . $params['period'] . ' day', time());

                    // Set plan's end
                    $plan_end = date('Y-m-d H:i:s', $date);

                    // Set data
                    $data = array(
                        'user_id' => $params['user_id'],
                        'meta_name' => 'plan_end',
                        'meta_value' => $plan_end
                    );
                    

                    // Insert
                    $this->db->insert('users_meta', $data);
                
                }
                
                return true;

            } else {

                // Get time based on period
                $date = strtotime('+' . $params['period'] . ' day', time());

                // Sets when plan will end
                $plan_end = date('Y-m-d H:i:s', $date);

                // Verify if plan_end exists
                if ( !empty($params['plan_end']) ) {

                    // Verify if the current plan is not ended
                    if ( strtotime($params['plan_end']) > time() ) {

                        // Set left time
                        $renew = $date + (strtotime($params['plan_end']) - time());

                        // Set new plan end
                        $plan_end = date('Y-m-d H:i:s', $renew);

                    }

                }

                // Prepare the data
                $data = array(
                    'user_id' => $params['user_id'],
                    'meta_name' => 'plan_end',
                    'meta_value' => $plan_end
                );

                // Set where
                $this->db->where(
                    array(
                        'user_id' => $params['user_id'],
                        'meta_name' => 'plan_end'
                    )
                );

                // Update
                $this->db->update('users_meta', $data);

                // Verify if the data was updated
                if ( $this->db->affected_rows() ) {
            
                    return true;
                    
                }

            }

        } else {

            // Prepare data
            $data = array(
                'user_id' => $params['user_id'],
                'meta_name' => 'plan',
                'meta_value' => $params['plan_id']
            );

            // Save data
            $this->db->insert('users_meta', $data);

            // Calculate time
            $date = strtotime('+' . $params['period'] . ' day', time());
            
            // Sets when the plan ends
            $plan_end = date('Y-m-d H:i:s', $date);

            // Set new plan's data
            $data = array(
                'user_id' => $params['user_id'],
                'meta_name' => 'plan_end',
                'meta_value' => $plan_end
            );
            
            // Insert data
            $this->db->insert('users_meta', $data);

            // Verify if the data was saved
            if ( $this->db->affected_rows() ) {
            
                return true;
                
            }
        
        }
        
        return false;
    
    }
    
}

/* End of file base_plans_update.php */