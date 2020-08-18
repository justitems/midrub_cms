<?php
/**
 * Base Rest Model
 *
 * PHP Version 7.2
 *
 * base_rest file contains the Base Rest Model
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
 * Base_rest class - operates the oauth table.
 *
 * @since 0.0.7.9
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_rest extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'oauth_tokens';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Get oauth_tokens table
        $oauth_tokens = $this->db->table_exists('oauth_tokens');
        
        if ( !$oauth_tokens ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_tokens` (
                              `token_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `application_id` bigint(20) NOT NULL,
                              `user_id` int(11) NOT NULL,
                              `token` TEXT NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Get oauth_tokens table
        $oauth_tokens_permissions = $this->db->table_exists('oauth_tokens_permissions');
        
        if ( !$oauth_tokens_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_tokens_permissions` (
                              `permission_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `token_id` bigint(20) NOT NULL,
                              `permission_slug` varchar(250) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Get oauth_authorization_codes table
        $oauth_authorization_codes = $this->db->table_exists('oauth_authorization_codes');
        
        if ( !$oauth_authorization_codes ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_authorization_codes` (
                              `code_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` int(11) NOT NULL,
                              `application_id` bigint(20) NOT NULL,
                              `code` varchar(250) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Get oauth_authorization_codes_permissions table
        $oauth_authorization_codes_permissions = $this->db->table_exists('oauth_authorization_codes_permissions');
        
        if ( !$oauth_authorization_codes_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_authorization_codes_permissions` (
                              `permission_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `code_id` bigint(20) NOT NULL,
                              `permission_slug` varchar(250) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Get oauth_tokens table
        $oauth_tokens = $this->db->table_exists('oauth_tokens');
        
        if ( !$oauth_tokens ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_tokens` (
                              `token_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `token` text NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Get oauth_tokens_permissions table
        $oauth_tokens_permissions = $this->db->table_exists('oauth_tokens_permissions');
        
        if ( !$oauth_tokens_permissions ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `oauth_tokens_permissions` (
                              `permission_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `permission_slug` varchar(250) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');          
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_application_authorization_code saves authorization code
     *
     * @param integer $user_id contains the user's id
     * @param integer $application_id contains the application's id
     * @param string $code contains the authorization's 
     * 
     * @return integer with last inserted id or false
     */
    public function save_application_authorization_code( $user_id, $application_id, $code ) {
        
        // Set data
        $data = array(
            'user_id' => $user_id,
            'application_id' => $application_id,
            'code' => $code,
            'created' => time()
        );

        // Insert data
        $this->db->insert('oauth_authorization_codes', $data);

        if ( $this->db->affected_rows() ) {

            // Return last inserted ID
            return $this->db->insert_id();

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method save_application_authorization_code_permission saves authorization code permission
     *
     * @param integer $code_id contains the code's id
     * @param string $permission_slug contains the permission's slug
     * 
     * @return integer with last inserted id or false
     */
    public function save_application_authorization_code_permission( $code_id, $permission_slug ) {
        
        // Set data
        $data = array(
            'code_id' => $code_id,
            'permission_slug' => $permission_slug
        );

        // Insert data
        $this->db->insert('oauth_authorization_codes_permissions', $data);

        if ( $this->db->affected_rows() ) {

            // Return last inserted ID
            return $this->db->insert_id();

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method save_oauth_token saves oauth's token
     *
     * @param integer $application_id contains the application's id
     * @param integer $user_id contains the user's id
     * @param string $token contains the token
     * 
     * @return integer with last inserted id or false
     */
    public function save_oauth_token( $application_id, $user_id, $token ) {
        
        // Set data
        $data = array(
            'application_id' => $application_id,
            'user_id' => $user_id,
            'token' => $token,
            'created' => time()
        );

        // Insert data
        $this->db->insert('oauth_tokens', $data);

        if ( $this->db->affected_rows() ) {

            // Return last inserted ID
            return $this->db->insert_id();

        } else {

            return false;

        }
        
    }
    
    /**
     * The public method save_oauth_token_permission saves oauth token's permission
     *
     * @param integer $token_id contains's the token's id
     * @param string $permission_slug contains the permission's slug
     * 
     * @return integer with last inserted id or false
     */
    public function save_oauth_token_permission($token_id, $permission_slug) {
        
        // Set data
        $data = array(
            'token_id' => $token_id,
            'permission_slug' => $permission_slug
        );

        // Insert data
        $this->db->insert('oauth_tokens_permissions', $data);

        if ( $this->db->affected_rows() ) {

            // Return last inserted ID
            return $this->db->insert_id();

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
        $this->db->from('oauth_applications');
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
     * The public method check_authorization_code verifies the authorization's code
     *
     * @param integer $application_id contains the application's ID
     * @param string $code contains the authorization's code
     * 
     * @return object with permissions or false
     */
    public function check_authorization_code( $application_id, $code ) {
        
        $this->db->select('oauth_authorization_codes_permissions.permission_slug, oauth_authorization_codes.user_id');
        $this->db->from('oauth_authorization_codes_permissions');
        $this->db->join('oauth_authorization_codes', 'oauth_authorization_codes_permissions.code_id=oauth_authorization_codes.code_id', 'left');
        $this->db->where(array(
                'oauth_authorization_codes.application_id' => $application_id,
                'oauth_authorization_codes.code' => $code
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
     * The public method check_token verifies user's token
     *
     * @param string $token contains the user's token
     * 
     * @return object with token's data or false
     */
    public function check_token( $token ) {
        
        $this->db->select('*');
        $this->db->from('oauth_tokens');
        $this->db->where(array(
                'token' => $token
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
     * The public method get_token_permissions gets token's permissions
     *
     * @param string $token_id contains the token's id
     * 
     * @return integer with token's or false
     */
    public function get_token_permissions( $token_id ) {
        
        $this->db->select('permission_slug');
        $this->db->from('oauth_tokens_permissions');
        $this->db->where(array(
                'token_id' => $token_id
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
     * The public method delete_authorization_codes deletes authorization codes
     *
     * @param integer $user_id contains the user's ID
     * 
     * @return boolean true or false
     */
    public function delete_authorization_codes( $user_id ) {
        
        $this->db->select('*');
        $this->db->from('oauth_authorization_codes');
        $this->db->where(array(
                'user_id' => $user_id
            )
        );

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            foreach ( $results as $result ) {
        
                $this->db->delete('oauth_authorization_codes', array(
                        'code_id' => $result->code_id
                    )
                );

                if ( $this->db->affected_rows() ) {

                    $this->db->delete('oauth_authorization_codes_permissions', array(
                             'code_id' => $result->code_id
                        )
                    );

                }
                
            }
            
        }
        
    }

    /**
     * The public method delete_access_tokens deletes authorization codes
     *
     * @param integer $user_id contains the user's ID
     * @param integer $token_id contains the token's ID which shouldn't be deleted
     * 
     * @return boolean true or false
     */
    public function delete_access_tokens( $user_id, $token_id ) {
        
        $this->db->select('token_id');
        $this->db->from('oauth_tokens');
        $this->db->where(array(
                'token_id !=' => $token_id,
                'user_id' => $user_id,
                'created <' => (time() - 31536000)
            )
        );

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            foreach ( $results as $result ) {
        
                $this->db->delete('oauth_tokens', array(
                        'token_id' => $result->token_id
                    )
                );

                if ( $this->db->affected_rows() ) {

                    $this->db->delete('oauth_tokens_permissions', array(
                            'token_id' => $result->token_id
                        )
                    );

                }
                
            }
            
        }
        
    }
    
    /**
     * The public method delete_application_permissions deletes application's permissions by user_id
     *
     * @param integer $user_id contains the user's ID
     * @param integer $application_id contains the application's ID
     * 
     * @return boolean true or false
     */
    public function delete_application_permissions( $user_id, $application_id ) {
        
        $this->db->select('*');
        $this->db->from('oauth_tokens');
        $this->db->where(array(
                'application_id' => $application_id,            
                'user_id' => $user_id,
                'created <' => (time() - 31536000)
            )
        );

        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            
            foreach ( $results as $result ) {
        
                $this->db->delete('oauth_tokens', array(
                        'token_id' => $result->token_id
                    )
                );

                if ( $this->db->affected_rows() ) {

                    $this->db->delete('oauth_tokens_permissions', array(
                             'token_id' => $result->token_id
                        )
                    );

                }
                
            }
            
        }
        
    }
    
}

/* End of file base_rest.php */