<?php
/**
 * User Plans Groups Model
 *
 * PHP Version 7.3
 *
 * User_plans_groups_model file contains the User Plans Groups Model
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
 * User_plans_groups_model class - operates the plans_groups tables.
 *
 * @since 0.0.8.2
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
class User_plans_groups_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'plans_groups';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        // Get plans_groups table
        $plans_groups = $this->db->table_exists('plans_groups');

        // Verify if the plans_groups table exists
        if (!$plans_groups) {

            $this->db->query('CREATE TABLE IF NOT EXISTS `plans_groups` (
                `group_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `group_name` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `created` varchar(30) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

        }      
        
        // Get plans_texts table
        $plans_texts = $this->db->table_exists('plans_texts');

        // Verify if the plans_texts table exists
        if (!$plans_texts) {

            $this->db->query('CREATE TABLE IF NOT EXISTS `plans_texts` (
                `text_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                `plan_id` bigint(20) NOT NULL,
                `language` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `text_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `text_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `text_extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                `created` varchar(30) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');

        }  
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
 
}

/* End of file user_plans_groups_model.php */