<?php
/**
 * Invoices Model
 *
 * PHP Version 5.6
 *
 * Invoices file contains the Invoices Model
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
 * Invoices class - operates the Invoices table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Invoice extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'invoices';

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
     * The public method create_invoice creates an invoice
     *
     * @param string $transaction_id contains the transaction_id
     * @param integer $plan_id contains the plan_id
     * @param string $invoice_date contains the invoice's creation date
     * @param integer $user_id contains the user_id
     * @param string $invoice_title contains the invoice's title
     * @param string $invoice_text contains the invoice_text
     * @param string $amount contains the amount
     * @param string $currency contains the currency
     * @param string $taxes contains the taxes
     * @param string $total contains the total
     * @param string $from_period contains the start period
     * @param string $to_period contains the end period
     * @param string $gateway contains the gateway's name
     * 
     * @return integer with invoice_id or false
     */
    public function create_invoice( $transaction_id, $plan_id, $invoice_date, $user_id, $invoice_title, $invoice_text, $amount, $currency, $taxes, $total, $from_period, $to_period, $gateway ) {
        
        // Set data
        $data = ['transaction_id' => $transaction_id,
                'plan_id' => $plan_id,
                'invoice_date' => $invoice_date,
                'user_id' => $user_id,
                'invoice_title' => $invoice_title, 
                'invoice_text' => $invoice_text,
                'amount' => $amount,
                'currency' => $currency,
                'taxes' => $taxes,
                'total' => $total,
                'from_period' => $from_period,
                'to_period' => $to_period,
                'gateway' => $gateway];
        
        // Insert invoice
        $this->db->insert($this->table, $data);
        
        // Verify if post was saved
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_invoices gets all invoices by paramaters
     *
     * @param integer $start contains the number where start displaing users
     * @param integer $limit contains the display limit
     * @param integer $user_id contains the user_id
     * @param string $date_from contains the date from
     * @param string $date_to contains the date to
     * @param boolean $total contains the limit options
     * 
     * @return integer with user_id or false
     */
    public function get_invoices( $start, $limit, $user_id, $date_from, $date_to, $total ) {
        
        $this->db->select('invoices.invoice_id, invoices.user_id, users.username, invoices.gateway, invoices.status, LEFT(invoices.invoice_date, 10) AS invoice_date');
        $this->db->from($this->table);
        $this->db->join('users', 'invoices.user_id=users.user_id', 'left');
        
        if ( ($user_id != 0) || ($date_from != 0) || ($date_to != 0) ) {
            
            $data = [];
            
            if ( $user_id ) {
                
                $data['invoices.user_id'] = $user_id;
            
            }
            
            if ( $date_from ) {
                
                $data['UNIX_TIMESTAMP(invoices.invoice_date) >='] = strtotime($date_from);
            
            }
            
            if ( $date_to ) {
                
                $data['UNIX_TIMESTAMP(invoices.invoice_date) <='] = strtotime($date_to);
            
            }

            $this->db->where($data);
        
        }
        
        if ( $total ) {
            
            $this->db->limit($limit, $start);
        
        }
        
        $this->db->order_by('invoice_id', 'desc');
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            if ( $total ) { 
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return $query->num_rows();
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_invoice gets invoice details
     *
     * @param integer $invoice_id contains the invoice_id
     * 
     * @return object with invoice details or false
     */
    public function get_invoice( $invoice_id ) {
        
        $this->db->select('invoices.invoice_id, invoices.transaction_id, invoices.invoice_title, invoices.invoice_text, invoices.from_period, invoices.to_period, invoices.user_id, users.username, users.email, invoices.gateway, invoices.status, invoices.amount, invoices.taxes, invoices.total, invoices.currency, plans.plan_name, LEFT(invoices.invoice_date, 10) AS invoice_date');
        $this->db->from($this->table);
        $this->db->join('users', 'invoices.user_id=users.user_id', 'left');
        $this->db->join('plans', 'invoices.plan_id=plans.plan_id', 'left');
        $data = ['invoices.invoice_id' => $invoice_id];
        $this->db->where($data);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_invoice deletes invoice
     *
     * @param integer $invoice_id contains the invoice_id
     * 
     * @return boolean true or false
     */
    public function delete_invoice( $invoice_id ) {
        
        $this->db->where(['invoice_id' => $invoice_id]);
        
        $this->db->delete($this->table);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_invoices_statistics gets number of invoices per period of time
     *
     * @param integer $period contains the period limit
     * 
     * @return integer with number of invoices or false
     */
    public function get_invoices_statistics( $period ) {
        
        $this->db->select('invoice_id');
        $this->db->from($this->table);
    
        if ( $period ) {
                
                $data['UNIX_TIMESTAMP(invoice_date) >='] = strtotime('-' . $period . ' days');

            $this->db->where($data);
        
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->num_rows();
            
        } else {
            
            return '0';
            
        }
        
    }
    
    /**
     * The public method set_status sets the invoice status
     *
     * @param integer $invoice_id contains the invoice_id
     * @param integer $status contains the invoice's status
     * 
     * @return boolean true or false
     */
    public function set_status( $invoice_id, $status ) {
        
        $this->db->where( 'invoice_id', $invoice_id );
        $this->db->update($this->table, ['status' => $status]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_by_username_or_email gets user_id by username or email
     *
     * @param string $key contains the search key
     * 
     * @return integer with user_id or false
     */
    public function get_user_by_username_or_email( $key ) {
        
        $this->db->select('user_id');
        $this->db->from('users');
        $this->db->where('username', $key);
        $this->db->or_where('email', $key);
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Invoices.php */