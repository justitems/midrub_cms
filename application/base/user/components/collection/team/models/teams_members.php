<?php
/**
 * Teams Members Model
 *
 * PHP Version 7.3
 *
 * Teams_members contains the Teams Members Model
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
 * Teams_members class - operates the teams and teams_meta table
 *
 * @since 0.0.8.2
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Teams_members extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'teams';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get teams_meta table
        $teams_meta = $this->db->table_exists('teams_meta');
        
        // Verify if the teams_meta table exists
        if ( !$teams_meta ) {
            
            // Create the teams_meta table
            $this->db->query('CREATE TABLE IF NOT EXISTS `teams_meta` (
                `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `member_id` bigint(20) NOT NULL,
                `meta_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `meta_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `meta_extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
}

/* End of file teams_members.php */