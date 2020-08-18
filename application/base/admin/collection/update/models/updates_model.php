<?php
/**
 * Updates Model
 *
 * PHP Version 7.3
 *
 * Updates_model contains the Updates Model
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
 * Updates_model class - operates the updates table
 *
 * @since 0.0.8.1
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Updates_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'updates';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $updates = $this->db->table_exists('updates');

        // Verify if the table exists
        if ( !$updates ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `updates` (
                              `update_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `version` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
                            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
}

/* End of file updates_model.php */