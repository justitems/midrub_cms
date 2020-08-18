<?php
/**
 * Dashboard Widgets Model
 *
 * PHP Version 7.3
 *
 * dashboard_widgets_model contains the Dashboard Widgets Model
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
 * dashboard_widgets_model class - operates the administrator_dashboard_widgets table
 *
 * @since 0.0.8.1
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Dashboard_widgets_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'administrator_dashboard_widgets';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get the table
        $administrator_dashboard_widgets = $this->db->table_exists('administrator_dashboard_widgets');

        // Verify if the table exists
        if ( !$administrator_dashboard_widgets ) {

            // Create the table
            $this->db->query('CREATE TABLE IF NOT EXISTS `administrator_dashboard_widgets` (
                              `widget_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `widget_slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `enabled` tinyint(1) NOT NULL,
                              `order` smallint(3) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
                            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    
}

/* End of file dashboard_widgets_model.php */