<?php
/**
 * Plans Model
 *
 * PHP Version 5.6
 *
 * Plans file contains the Plans Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Plans class - operates the plans table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Plans extends CI_MODEL {
    private $table = 'plans';

    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        $tables = $this->db->list_fields('plans');
        
        if ( !in_array('popular', $tables) ) {
            $this->db->query('ALTER TABLE plans ADD header VARCHAR(250) AFTER features');
            $this->db->query('ALTER TABLE plans ADD popular TINYINT(1)');
            $this->db->query('ALTER TABLE plans ADD featured TINYINT(1)');
            $this->db->query('ALTER TABLE plans ADD trial TINYINT(1)');
        }        
        
        if ( !in_array('visible', $tables) ) {
            $this->db->query('ALTER TABLE plans ADD visible tinyint(1) AFTER period');
        }
        
        if ( !$this->db->table_exists('plans_meta') ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `plans_meta` (
                              `meta_id` int(6) AUTO_INCREMENT PRIMARY KEY,
                              `plan_id` int(6) NOT NULL,
                              `meta_name` varchar(30) NOT NULL,
                              `meta_value` text NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $this->tables = $this->config->item('tables', $this->table);
    }
    
    /**
     * The function save_plan creates a new plan
     *
     * @param string $plan_name contains the plan's name
     * 
     * @return integer with plan's id or false
     */
    public function save_plan($plan_name) {
            
        $data = array(
            'plan_name' => $plan_name
        );

        $this->db->insert($this->table, $data);
        
        if ($this->db->affected_rows()) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            return false;
        }

    }
    
    /**
     * The function update_plan updates an existing plan
     *
     * @param integer $plan_id contains the plan's ID
     * @param array $data contains the default plan's fields to update
     * 
     * @return boolean true or false
     */
    public function update_plan($plan_id, $data) {

        $this->db->set($data);
        $this->db->where('plan_id', $plan_id);
        $this->db->update($this->table);
        
        if ($this->db->affected_rows()) {
            
            return true;
            
        } else {
            return false;
        }

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
     * The function get_all_plans gets all plans
     * 
     * @param integer $visible contains the status option
     * 
     * @return object with all plans or false
     */
    public function get_all_plans( $visible = NULL ) {
        
        $this->db->select('*');
        
        $this->db->from($this->table);
        
        if ( !$visible ) {
            
            $this->db->where( 'visible IS NULL' );
            $this->db->or_where( 'visible', '0' );
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
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
     * The function get_user_plan get user plan by user's id
     *
     * @param $user_id contains the user's id
     * 
     * @return object with plan's data or false
     */
    public function get_user_plan($user_id) {
        $this->db->select('*');
        $this->db->from('users_meta');
        $this->db->where('user_id', $user_id);
        $this->db->like('meta_name', 'plan');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    /**
     * The function change_plan changes the user's plan
     *
     * @param $plan contains the plan's id
     * @param $user_id contains user's id
     * 
     * @return boolean true of the plan was changed or false
     */
    public function change_plan($plan, $user_id) {
        // Cancel the user subscribtions
        $this->cancel_subscriptions($user_id, $plan);
        $period = $this->get_plan_period($plan);
        // Will be changed the plan
        $this->db->select('*');
        $this->db->from('users_meta');
        $this->db->where(['user_id' => $user_id, 'meta_name' => 'plan']);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $plans = $query->result();
            if ($plans[0]->meta_value != $plan) {
                $data = ['meta_value' => $plan];
                $this->db->where(['user_id' => $user_id, 'meta_name' => 'plan']);
                $this->db->update('users_meta', $data);
                $this->db->select('*');
                $this->db->from('users_meta');
                $this->db->where(['user_id' => $user_id, 'meta_name' => 'plan_end']);
                $this->db->limit(1);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    $date = strtotime('+' . $period . ' day', time());
                    $plan_end = date('Y-m-d H:i:s', $date);
                    $data = ['user_id' => $user_id, 'meta_name' => 'plan_end', 'meta_value' => $plan_end];
                    $this->db->where(['user_id' => $user_id, 'meta_name' => 'plan_end']);
                    $this->db->update('users_meta', $data);
                } else {
                    $date = strtotime('+' . $period . ' day', time());
                    $plan_end = date('Y-m-d H:i:s', $date);
                    $data = ['user_id' => $user_id, 'meta_name' => 'plan_end', 'meta_value' => $plan_end];
                    $this->db->insert('users_meta', $data);
                }
                return true;
            } else {
                $date = strtotime('+' . $period . ' day', time());
                $plan_end = date('Y-m-d H:i:s', $date);
                // Check if the user plan is not ended yet
                $renew = $this->check_if_plan_ended($user_id);
                if ($renew) {
                    if ($renew < time() + 432000) {
                        $renew = $date + ($renew - time());
                        $plan_end = date('Y-m-d H:i:s', $renew);
                    }
                }
                $data = ['user_id' => $user_id, 'meta_name' => 'plan_end', 'meta_value' => $plan_end];
                $this->db->where(['user_id' => $user_id, 'meta_name' => 'plan_end']);
                $this->db->update('users_meta', $data);
            }
        } else {
            $data = ['user_id' => $user_id, 'meta_name' => 'plan', 'meta_value' => $plan];
            $this->db->insert('users_meta', $data);
            $date = strtotime('+' . $period . ' day', time());
            $plan_end = date('Y-m-d H:i:s', $date);
            $data = ['user_id' => $user_id, 'meta_name' => 'plan_end', 'meta_value' => $plan_end];
            $this->db->insert('users_meta', $data);
            return true;
        }
        return false;
    }
    
    /**
     * The function get_plan_period return plan's period by plan_id
     *
     * @param $plan_id contains the plan's id
     * 
     * @return object with plan's period
     */
    public function get_plan_period($plan_id) {
        $this->db->select('*');
        $this->db->from('plans');
        $this->db->where('plan_id', $plan_id);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0]->period;
        }
    }
    
    /**
     * The function get_plan_price return plan's price by plan_id
     *
     * @param $plan_id contains the plan's id
     * 
     * @return object with plan's price
     */
    public function get_plan_price($plan_id = NULL) {
        $this->db->select('*');
        $this->db->from('plans');
        if ( $plan_id ) {
            $this->db->where('plan_id', $plan_id);
        }
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        }
    }
    
    /**
     * The function check_payment checks if the transaction not exists in the database and saves it
     *
     * @param $value contains the payed price
     * @param $code contains the currency code
     * @param $plan_id contains the plan's id
     * @param $tx contains the transaction's id
     * @param $user_id contains user's id
     * @param string $source contains the gateway
     * 
     * @return boolean true if the payment was done successfully and plan was changed
     */
    public function check_payment($value, $code, $plan_id, $tx, $user_id, $source) {
        
        // Load User model
        $this->load->model('User', 'user');
        
        // Get discount if exists
        $discount = get_user_option( 'user_coupon_value' );
        
        // Get coupon if exists
        $coupon = get_user_option( 'user_coupon_code' );

        if ( $discount ) {
            
            // Get plan details
            $plan = $this->get_plan($plan_id);

            // Calculate total discount
            $total = ( $discount / 100) * $plan[0]['plan_price'];   

            // Set new price
            $total_to_pay = number_format(($plan[0]['plan_price'] - $total), 2);
            
            if ( ( trim($value) === trim($total_to_pay) ) && ( $code == $plan[0]['currency_code'] ) ) {
                
                $this->delete_code( $coupon );

                $this->db->select('*');

                $this->db->from('plans');

                $this->db->where(['plan_id' => $plan_id]);

                $query = $this->db->get();
                
            } else {

                $this->db->select('*');

                $this->db->from('plans');

                $this->db->where(['plan_id' => $plan_id, 'plan_price' => $value, 'currency_code' => $code]);

                $query = $this->db->get();

            }

        } else {
            
            $this->db->select('*');

            $this->db->from('plans');

            $this->db->where(['plan_id' => $plan_id, 'plan_price' => $value, 'currency_code' => $code]);

            $query = $this->db->get();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            $this->db->select('*');
            
            $this->db->from('payments');
            
            $this->db->where('txn_id', $tx);
            
            $query = $this->db->get();
            
            if ( $query->num_rows() < 1 ) {
                
                $data = ['user_id' => $user_id, 'txn_id' => $tx, 'payment_amount' => $value, 'payment_status' => 'complete', 'plan_id' => $plan_id, 'created' => date('Y-m-d H:i:s'), 'source' => $source];
                
                if ( ( get_option( 'Paypal-recurring-payments' ) != '' ) && ( get_option( 'Paypal-api-username' ) != '' ) && ( get_option( 'Paypal-api-password' ) != '' ) && ( get_option( 'Paypal-signature' ) != '' ) ) {
                    
                    $data['recurring'] = 1;
                    
                }
                
                $this->db->insert('payments', $data);
        
                // Load Referrals model
                $this->load->model('Referrals', 'referrals');
                
                if ( get_option('enable_referral') ) {
                
                    // Get referral data
                    $referral = $this->referrals->get_referral($user_id);

                    if ( $referral ) {

                        if ( $referral[0]->earned < 1 ) {
                            
                            if ( get_option('referrals_exact_gains') ) {

                                if ( is_numeric(plan_feature('referrals_exact_revenue', $plan_id)) ) {
                                    
                                    // Add referral earning
                                    $this->referrals->add_earnings_to_referral($user_id, $plan_id, plan_feature('referrals_exact_revenue', $plan_id));
                                    
                                }
                                
                            } else {
                                
                                if ( is_numeric(plan_feature('referrals_percentage_revenue', $plan_id)) ) {
                                    
                                    // Calculate percentage
                                    $total = number_format( ( (plan_feature('referrals_percentage_revenue', $plan_id) / 100) * $total_to_pay), 2);   
                                    
                                    // Add referral earning
                                    $this->referrals->add_earnings_to_referral($user_id, $plan_id, $total);                                    
                                    
                                }
                                
                            }

                        }

                    }
                
                }
                
                if ( $this->change_plan($plan_id, $user_id) ) {
                    
                    return true;
                    
                } else {
                    
                    if ( get_user_option('nonpaid') ) {
                        
                        $this->user->delete_user_option( $user_id, 'nonpaid' );
                        
                    }
                    
                    return true;
                    
                }
                
            }
            
        }
        
    }
    
    /**
     * The function check_transaction checks if the transaction already exists in the database
     *
     * @param string $tx contains the transaction's id
     * 
     * @return boolean true if the transaction exists
     */
    public function check_transaction($tx) {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where('txn_id', $tx);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }    
    
    /**
     * The function book_payment books a payment
     *
     * @param $user_id contains user's id
     * 
     * @param string $source contains the gateway
     */
    public function book_payment($user_id, $source, $plan_id) {
        $data = ['user_id' => $user_id, 'plan_id' => $plan_id, 'created' => date('Y-m-d H:i:s'), 'source' => $source];
        $this->db->insert('payments', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * The function trans add transaction id
     *
     * @param $user_id contains user's id
     * 
     * @return boolean true or false
     */
    public function trans($user_id, $txn_id, $price) {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where(['user_id' => $user_id, 'source' => 'voguepay']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $plan_id = $result[0]->plan_id;
            $id = $result[0]->id;
            $plan = $this->get_plan_price($plan_id);
            if($plan[0]->plan_price != $price) {
                return false;
            }
            if ($this->change_plan($plan_id, $user_id)) {
                $data = ['txn_id' => $txn_id, 'payment_amount' => $price, 'payment_status' => 'complete'];
                $this->db->where(['id' => $id]);
                $this->db->update('payments', $data);
                if ($this->db->affected_rows()) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    
    /**
     * The function payment_done verifies is the payment was done
     *
     * @param integer $user_id contains user's id
     * @param string $source contains the gateway
     * 
     * @return boolean true or false
     */
    public function payment_done($user_id, $source) {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where(['user_id' => $user_id, 'source' => 'voguepay']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $payment_status = $result[0]->payment_status;
            if($payment_status == 'complete') {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * The function get_all_payments calculates the earnings
     *
     * @param integer $time contains the time
     * 
     * @return boolean true or false
     */
    public function get_all_payments($time = NULL) {
        $this->db->select('SUM(payment_amount) as tot', false);
        $this->db->from('payments');
        if ( $time ) {
            $time = time() - $time;
            $this->db->where(['UNIX_TIMESTAMP(created)>' => $time]);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            if ( $result[0]->tot ) {
                return $result[0]->tot;
            } else {
                return '0.00';
            }
        } else {
            return '0.00';
        }
    }
    
    /**
     * The function get_plan_features gets features of a plan
     *
     * @param $user_id contains user's id
     * @param $key contains the plan's field
     * 
     * @return string with requested field or false
     */
    public function get_plan_features($user_id, $key) {
        $plan_id = 1;
        if ($this->get_user_plan($user_id)) {
            $user_plan = $this->get_user_plan($user_id);
            foreach ($user_plan as $up) {
                $plan_end = time();
                if (@$up->meta_name == 'plan') {
                    $cplan = $up->meta_value;
                }
                if (@$up->meta_name == 'plan_end') {
                    $plan_end = strtotime($up->meta_value);
                }
                if ($plan_end > time()) {
                    $plan_id = @$cplan;
                }
            }
        }
        $this->db->select('*');
        $this->db->from('plans');
        $this->db->where(['plan_id' => $plan_id]);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0]->$key;
        } else {
            return false;
        }
    }
    
    /**
     * The function check_if_plan_ended checks if user's plan has been ended
     *
     * @param $user_id contains user's id
     * 
     * @return string with date when plan ented or false
     */
    public function check_if_plan_ended($user_id) {
        $plan_id = 1;
        if ($this->get_user_plan($user_id)) {
            $user_plan = $this->get_user_plan($user_id);
            foreach ($user_plan as $up) {
                $plan_end = time();
                if (@$up->meta_name == 'plan') {
                    $cplan = $up->meta_value;
                }
                if (@$up->meta_name == 'plan_end') {
                    $plan_end = strtotime($up->meta_value);
                    return $plan_end;
                }
                if ($plan_end > time()) {
                    $plan_id = $cplan;
                }
            }
        }
        return false;
    }
    
    /**
     * The function delete_user_plan deletes user's plan
     *
     * @param $user_id contains user's id
     * 
     * @return boolean true if user was deleted or false
     */
    public function delete_user_plan($user_id) {
        $data = ['user_id' => $user_id, 'meta_name' => 'plan'];
        $this->db->delete('users_meta', $data);
        $data = ['user_id' => $user_id, 'meta_name' => 'plan_end'];
        $this->db->delete('users_meta', $data);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * The function plan_started gets the time when the user's plan starts
     *
     * @param $user_id contains user's id
     * 
     * @return array with data when plan started
     */
    public function plan_started($user_id) {
        
        $plan = $this->get_user_plan($user_id);
        
        if ( $plan ){
            
            $period = $this->get_plan_features($user_id,'period');
            
            if ( @$plan[1]->meta_value ) {
                
                $end = strtotime($plan[1]->meta_value);
                
                $tot = $end - ($period*86400);
                
                return array(
                    'plan' => $plan,
                    'time' => $tot
                );
                
            } else {
                
                $this->change_plan(1, $user_id);
                return array(
                    'plan' => 1,
                    'time' => time()
                );  
                
            }
            
        } else {
            
            $this->change_plan(1, $user_id);
            
            return array(
                'plan' => 1,
                'time' => time()
            );
            
        }
        
    }
    
    /**
     * The function delete_plan deletes plans
     *
     * @param integer $plan_id contains the plan's id
     * 
     * @return boolean true if plan was deleted or false
     */
    public function delete_plan($plan_id) {
        
        $this->db->delete($this->table, array('plan_id' => $plan_id));
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function get_subscription gets subscription if exists 
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true if the transaction exists
     */
    public function get_subscription($user_id) {
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where(['recurring >' => 0, 'user_id' => $user_id]);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0];
        } else {
            return false;
        }
    }
    
    /**
     * The function cancel_subscriptions cancels all user subscriptions
     *
     * @param integer $user_id contains the user_id
     * @param integer $plan_id contains the plan_id
     * 
     * @return void
     */
    public function cancel_subscriptions( $user_id, $plan_id ) {
        
        $this->db->select('*');
        $this->db->from('payments');
        $this->db->where(['recurring >' => 0, 'user_id' => $user_id]);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result();

            foreach ( $results as $result ) {
                
                if ( $result->plan_id === $plan_id ) {
                    continue;
                }
                
                $className = ucfirst(strtolower($result->source));
                
                if ( file_exists(APPPATH . 'payments/' . $className . '.php') ) {
                    
                    // Require the Payments interface
                    require_once APPPATH . 'interfaces/Payments.php';
            
                    // Require the payment class
                    require_once APPPATH . 'payments/' . $className . '.php';
                    
                    // Delete subscription
                    $this->db->delete('payments', array('id' => $result->id));
                    
                    // Call the class
                    $pay_class = str_replace('-', '_', $className);

                    $get = new $pay_class;
                    
                    $get->cancel( $result->txn_id );
                    
                    break;

                }

            }

        }  
        
    }
    
    /**
     * The protected method delete_code deletes a coupon code if is unique
     *
     * @param string $coupon contains the coupon code 
     * 
     * @return void
     */
    protected function delete_code($coupon) {

        // Load Codes model
        $this->load->model('Codes', 'codes');
        
        // Get the code information
        $details = $this->codes->get_code( $coupon );
        
        // Verify if the coupon code can be reused
        if ( @$details[0]->type > 0 ) {
            
            // Delete the coupon code by id
            $this->codes->delete_coupon( $details[0]->coupon_id );
            
        }
        
    }
    
}

/* End of file Plans.php */