<?php
/**
 * Referrals Model
 *
 * PHP Version 5.6
 *
 * Referrals file contains the Referrals Model
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
 * Referrals class - operates the referrals table.
 *
 * @since 0.0.7.6
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Referrals extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'referrals';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get referrals table
        $referrers = $this->db->table_exists('referrals');
        
        if ( !$referrers ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `referrals` (
                              `referrer_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `referrer` int(11) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `plan_id` bigint(20) NOT NULL,
                              `earned` varchar(30) NOT NULL,
                              `paid` TINYINT(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_referrals saves a referrals
     *
     * @param integer $referrer contains the referrer's id
     * @param integer $user_id contains the user's id
     * @param integer $plan_id contains the plan's id
     * 
     * @return integer with last inserted id or false
     */
    public function save_referrals( $referrer, $user_id, $plan_id ) {
        
        // Get current time
        $created = time();
        
        // Set data
        $data = array(
            'referrer' => $referrer,
            'user_id' => $user_id,
            'plan_id' => $plan_id,
            'earned' => 0,
            'paid' => 0,
            'created' => $created
        );
        
        // Insert data
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted ID
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method pay_referrers_earns marks as paid the user's gains
     *
     * @param integer $user_id contains the user's id
     * 
     * @return boolean true or false
     */
    public function pay_referrers_earns( $user_id ) {
        
        $this->db->set(['paid' => '1']);
        $this->db->where(array('referrer' => $user_id));
        $this->db->update($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method add_earnings_to_referral adds earnings to referral
     *
     * @param integer $user_id contains the user's id
     * @param integer $plan_id contains the plan's id
     * @param string $earned contains the earned value
     * 
     * @return boolean true or false
     */
    public function add_earnings_to_referral( $user_id, $plan_id, $earned ) {
        
        $this->db->set(array('plan_id' => $plan_id, 'earned' => $earned));
        $this->db->where(array('user_id' => $user_id));
        $this->db->update($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_referrals gets all referrals
     *
     * @param integer $start contains the current page
     * @param integer $limit contains the number of tickets
     * @param integer $date_from contains the date's from
     * @param integer $date_to contains the date's to
     * 
     * @return object with all referrals or false
     */
    public function get_referrals( $start=0, $limit=0, $date_from=NULL, $date_to=NULL ) {
        
        $where = array();
        
        $sql_where = '';
        
        if ( is_numeric($date_from) ) {
            $where['referrals.created >'] = $date_from;
            $sql_where = " WHERE `created` > '" . $date_from . "'";
        }
        
        if ( is_numeric($date_to) ) {
            
            $where['referrals.created <'] = $date_to;
            
            if ( $sql_where ) {
                
                $sql_where = " AND `created` > '" . $date_to . "'";
                
            } else {
                
                $sql_where = " WHERE `created` < '" . $date_to . "'";
                
            }
            
        }
        
        $this->db->select("users.user_id,users.username,referrals.earned,referrals.paid,referrals.created,(SELECT COUNT(*) FROM referrals" . $sql_where . ") AS total", FALSE);
        $this->db->from($this->table);
        $this->db->join('users', 'referrals.referrer=users.user_id', 'left');
        
        if ( $where ) {
            $this->db->where($where);
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by('referrals.referrer_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_referrals gets all referrals
     *
     * @param integer $user_id contains the user's id
     * 
     * @return object with referral's data or false
     */
    public function get_referral( $user_id ) {
        
        $this->db->select('referrer,plan_id,earned');
        $this->db->from($this->table);
        $this->db->where(array(
            'user_id' => $user_id
        ));
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_referrers gets all referrers
     *
     * @param integer $start contains the current page
     * @param integer $limit contains the number of tickets
     * 
     * @return object with all referrers or false
     */
    public function get_referrers( $start=0, $limit=0 ) {
        
        $this->db->select("(SELECT COUNT(*) FROM referrals WHERE `earned` > '0' GROUP BY referrer) AS total, SUM(referrals.earned) AS earned, (SELECT COUNT(*) FROM referrals WHERE `paid` > '0' GROUP BY referrer) AS paid", FALSE);
        $this->db->select("users.user_id,users.username,referrals.created,plans.currency_code");
        $this->db->from($this->table);
        $this->db->join('users', 'referrals.referrer=users.user_id', 'left');
        $this->db->join('plans', 'referrals.plan_id=plans.plan_id', 'left');
        
        $this->db->where(array(
            'referrals.earned >' => 0
        ));
        
        $this->db->group_by(array('users.user_id'));
        $this->db->limit($limit, $start);
        $this->db->order_by('referrals.paid', 'asc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            $total_results = array();
            
            foreach ( $results as $result ) {
                
                $this->db->select('*');
                $this->db->from($this->table);
                $this->db->where(array('referrer' => $result->user_id, 'earned >' => 0, 'paid <' => 1));
                $query = $this->db->get();
                
                $earned = 0;

                if ( $query->num_rows() > 0 ) {
                    
                    $earnings = $query->result();
                    
                    foreach ( $earnings as $earning ) {

                        $earned = $earned + (int)$earning->earned;
                        
                    }
                    
                }
                
                $total_results[] = array(
                    'user_id' => $result->user_id,
                    'username' => $result->username,
                    'paid' => $result->paid,
                    'created' => $result->created,
                    'total' => $result->total,
                    'earned' => ($earned)?$earned:$result->earned,
                    'currency_code' => $result->currency_code
                );
                
            }
            
            return $total_results;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_stats gets user stats
     *
     * @param integer $user_id contains the user's id
     * 
     * @return object with all user's referral stats
     */
    public function get_stats( $user_id ) {
        
        $this->db->select("COUNT(referrals.user_id) AS signups, plans.currency_code, (SELECT SUM(earned) FROM referrals WHERE referrer='$user_id' AND earned > '0' AND paid > '0') AS total_paid, (SELECT SUM(earned) FROM referrals WHERE referrer='$user_id' AND earned > '0' AND paid < '1') AS total_unpaid", FALSE);
        $this->db->from($this->table);
        $this->db->join('plans', 'referrals.plan_id=plans.plan_id', 'left');
        $this->db->where(array(
            'referrals.referrer' => $user_id
        ));
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return false;
            
        }
        
    }   
    
    /**
     * The public method delete_referrals deletes user's refferals
     *
     * @param integer $user_id contains the user_id
     * 
     * @return void
     */
    public function delete_referrals( $user_id ) {
        
        $this->db->delete($this->table, array(
                'user_id' => $user_id
            )
        );

        $this->db->delete($this->table, array(
                'referrer' => $user_id
            )
        );
        
    }
    
}

/* End of file Referrals.php */