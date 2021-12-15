<?php
/**
 * Oauth Applications Model
 *
 * PHP Version 5.6
 *
 * Oauth_applications_model contains the Oauth Applications Model
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
 * Oauth_applications_model class - operates the oauth_applications table
 *
 * @since 0.0.7.7
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Oauth_applications_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'oauth_applications';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get oauth_permissions table
        $oauth_permissions = $this->db->table_exists('oauth_applications');
        
        if ( !$oauth_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_applications` (
                              `application_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `application_name` varchar(250) NOT NULL,
                              `redirect_url` text COLLATE utf8_unicode_ci NOT NULL,
                              `cancel_url` text COLLATE utf8_unicode_ci NOT NULL,
                              `type` tinyint(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');            
            
        }
        
        // Get oauth_applications_permissions table
        $oauth_applications_permissions = $this->db->table_exists('oauth_applications_permissions');
        
        if ( !$oauth_applications_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_applications_permissions` (
                              `permission_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,                
                              `application_id` bigint(20) NOT NULL,
                              `permission_slug` varchar(250) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');            
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_application saves a new application
     *
     * @param integer $user_id contains the user's id
     * @param string $application_name contains the application's name
     * @param string $redirect_url contains the redirect's url
     * @param string $cancel_url contains the cancel redirect's url
     * 
     * @return integer with last inserted id or false
     */
    public function save_application( $user_id, $application_name, $redirect_url=NULL, $cancel_url=NULL ) {
        
        // Set data
        $data = array(
            'user_id' => $user_id,
            'application_name' => $application_name,
            'created' => time()
        );
        
        if ( $redirect_url ) {
            $data['redirect_url'] = $redirect_url;
        }

        if ( $cancel_url ) {
            $data['cancel_url'] = $cancel_url;
        }

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
     * The public method oauth_applications_permissions saves application's permission
     *
     * @param integer $application_id contains the application's id
     * @param string $permission_slug contains the permission's slug
     * 
     * @return integer with last inserted id or false
     */
    public function save_application_permission( $application_id, $permission_slug ) {
        
        // Set data
        $data = array(
            'application_id' => $application_id,
            'permission_slug' => $permission_slug
        );

        // Insert data
        $this->db->insert('oauth_applications_permissions', $data);

        if ( $this->db->affected_rows() ) {

            // Return last inserted ID
            return $this->db->insert_id();

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method update_application updates an application
     *
     * @param integer $application_id contains the application's id
     * @param string $application_name contains the application's name
     * @param string $redirect_url contains the redirect's url
     * @param string $cancel_url contains the cancel redirect's url
     * 
     * @return integer with last inserted id or false
     */
    public function update_application( $application_id, $application_name, $redirect_url=NULL, $cancel_url=NULL ) {
        
        $data = array(
            'application_name' => $application_name
        ); 
        
        if ( $redirect_url ) {
            $data['redirect_url'] = $redirect_url;
        }

        if ( $cancel_url ) {
            $data['cancel_url'] = $cancel_url;
        }

        $this->db->set($data);
        $this->db->where(array(
                'application_id' => $application_id
            )
        );

        $this->db->update($this->table);

        if ( $this->db->affected_rows() ) {

            return true;

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method get_applications gets all applications
     *
     * @param integer $start contains the current page
     * @param integer $limit contains the number of tickets
     * 
     * @return object with all applications or false
     */
    public function get_applications( $start=0, $limit=0 ) {
        
        $this->db->select('oauth_applications.application_id, oauth_applications.user_id, oauth_applications.application_name, users.username');
        $this->db->from($this->table);
        $this->db->join('users', 'oauth_applications.user_id=users.user_id', 'left');
        
        if ( $limit ) {
            $this->db->limit($limit, $start);
        } else {
            $query = $this->db->get();
            return $query->num_rows();
        }
        
        $this->db->order_by('oauth_applications.application_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_application get application's data
     *
     * @param integer $application_id contains the application's ID
     * 
     * @return object with application's data or false
     */
    public function get_application( $application_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array(
                'application_id' => $application_id
            )
        );
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_application_permissions gets application's permissons
     *
     * @param integer $application_id contains the application's ID
     * 
     * @return object with application's permissions or false
     */
    public function get_application_permissions( $application_id ) {
        
        $this->db->select('*');
        $this->db->from('oauth_applications_permissions');
        $this->db->where(array(
                'application_id' => $application_id
            )
        );

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_application deletes api applications
     *
     * @param integer $application_id contains the application's ID
     * 
     * @return boolean true or false
     */
    public function delete_application( $application_id ) {
        
        $this->db->delete($this->table, array(
                'application_id' => $application_id
            )
        );
        
        if ( $this->db->affected_rows() ) {
            
            $this->db->delete('oauth_applications_permissions', array(
                    'application_id' => $application_id
                )
            ); 
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_application_permissions deletes application's permissions
     *
     * @param integer $application_id contains the application's ID
     * 
     * @return boolean true or false
     */
    public function delete_application_permissions( $application_id ) {
        
        $this->db->delete('oauth_applications_permissions', array(
                'application_id' => $application_id
            )
        );
        
        if ( $this->db->affected_rows() ) {           
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file oauth_applications_model.php */