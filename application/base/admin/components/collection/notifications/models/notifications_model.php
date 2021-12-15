<?php
/**
 * Notifications Model
 *
 * PHP Version 7.3
 *
 * Notifications_model file contains the Notifications Model
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notifications_model class - operates the notifications tables
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Notifications_model extends CI_MODEL {

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get notifications_templates table
        $notifications_templates = $this->db->table_exists('notifications_templates');
        
        // Verify if the notifications_templates table exists
        if ( !$notifications_templates ) {
            
            // Create the notifications_templates table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_templates` (
                              `template_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `template_slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Get notifications_templates_meta table
        $notifications_templates_meta = $this->db->table_exists('notifications_templates_meta');
        
        // Verify if the notifications_templates_meta table exists
        if ( !$notifications_templates_meta ) {
            
            // Create the notifications_templates_meta table
            $this->db->query('CREATE TABLE IF NOT EXISTS `notifications_templates_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `template_id` bigint(20) NOT NULL,
                              `template_title` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `template_body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
    }
    
}

/* End of file notifications_model.php */