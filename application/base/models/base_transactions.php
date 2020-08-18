<?php
/**
 * Base Transactions Model
 *
 * PHP Version 7.3
 *
 * Base_transactions file contains the Base Transactions Model
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
 * Base Transactions class - operates the base_transactions table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_transactions extends CI_MODEL {

    /**
     * Class variables
     */
    private $table = 'transactions';

    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        $transactions = $this->db->table_exists('transactions');
        
        if ( !$transactions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `transactions` (
                              `transaction_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `net_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `amount` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `currency` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `gateway` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `status` 	tinyint(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $transactions_options = $this->db->table_exists('transactions_options');
        
        if ( !$transactions_options ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `transactions_options` (
                              `option_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `transaction_id` bigint(20) NOT NULL,
                              `option_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `option_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        $transactions_fields = $this->db->table_exists('transactions_fields');

        if ( !$transactions_fields ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `transactions_fields` (
                              `field_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `transaction_id` bigint(20) NOT NULL,
                              `field_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `field_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        $subscriptions = $this->db->table_exists('subscriptions');

        if ( !$subscriptions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `subscriptions` (
                              `subscription_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `net_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `amount` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `currency` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `period` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `gateway` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `status` 	tinyint(1) NOT NULL,
                              `last_update` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set table
        $this->tables = $this->config->item('tables', $this->table);

    }

}

/* End of file base_transactions.php */