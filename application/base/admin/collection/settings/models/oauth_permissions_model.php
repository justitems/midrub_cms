<?php
/**
 * Oauth Permissions Model
 *
 * PHP Version 5.6
 *
 * Oauth_permissions_model contains the Oauth Permissions Model
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
 * Oauth_permissions_model class - operates the oauth_permissions table
 *
 * @since 0.0.7.7
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Oauth_permissions_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'oauth_permissions';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get oauth_permissions table
        $oauth_permissions = $this->db->table_exists('oauth_permissions');
        
        if ( !$oauth_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_permissions` (
                              `permission_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `permission_slug` varchar(250) NOT NULL,
                              `status` tinyint(1) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');            
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_permission saves the permission's status
     *
     * @param string $permission contains the permission's slug
     * @param string $status contains the permission's status
     * 
     * @return integer with last inserted id, boolean true or false
     */
    public function save_permission( $permission, $status ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array(
                'permission_slug' => $permission
            )
        );
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            
            $data = array(
                'status' => $status
            );                    

            $this->db->set($data);
            $this->db->where(array(
                    'permission_slug' => $permission
                )
            );

            $this->db->update($this->table);
            
            if ( $this->db->affected_rows() ) {

                return true;

            } else {

                return false;

            }
            
        } else {
        
            // Set data
            $data = array(
                'permission_slug' => $permission,
                'status' => $status
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
        
    }
    
    /**
     * The public method get_permission gets the permission's status
     *
     * @param string $permission contains the permission's slug
     * 
     * @return object with permission's data or false
     */
    public function get_permission( $permission ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array(
                'permission_slug' => $permission
            )
        );
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file oauth_permissions_model.php */