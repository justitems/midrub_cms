<?php
/**
 * Base Auth Social Model
 *
 * PHP Version 7.3
 *
 * Base_auth_social file contains the Base Auth Social Model
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
 * Base_auth_social class - operates the base_auth_social table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_auth_social extends CI_MODEL {

    /**
     * Class variables
     */
    private $table = 'users_social';

    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the users_social table
        $users_social = $this->db->table_exists('users_social');
        
        // Verify if the users_social exists
        if ( !$users_social ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `users_social` (
                              `social_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `network_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `net_id` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set table
        $this->tables = $this->config->item('tables', $this->table);

    }

}

/* End of file base_auth_social.php */