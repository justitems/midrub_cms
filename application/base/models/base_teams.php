<?php
/**
 * Teams Model
 *
 * PHP Version 7.2
 *
 * Teams file contains the Teams Model
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
 * Team class - manages the User's Team
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_teams extends CI_MODEL {
    
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
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
        // Load the Bcrypt library
        $this->load->library('bcrypt');
        
    }
    
    /**
     * The public method save_member saves a team's member
     *
     * @param integer $user_id contains the user_id 
     * @param string $username contains the member's name
     * @param string $email contains the member's email
     * @param integer $role_id contains the member's role_id
     * @param integer $status contains the member's status
     * @param string $about contains the member's information
     * @param string $password contains the member's password
     * 
     * @return boolean true or false
     */
    public function save_member( $user_id, $username, $email, $role_id, $status, $about=NULL, $password ) {
        
        // First verify if the username already exists in the database
        $username = $this->check_member_name($username);
        
        // If the $username is not available, return false
        if ( !$username ) {
            
            return false;
            
        }
        
        // Then save the new user
        $data = array(
            'user_id' => $user_id,
            'member_username' => $username,
            'member_password' => $this->bcrypt->hash_password($password),
            'member_email' => $email,
            'role_id' => $role_id,
            'status' => $status,
            'about_member' => $about,
            'date_joined' => date('Y-m-d H:i:s')
        );
        
        $this->db->insert($this->table, $data);
        
        if ($this->db->affected_rows()) {
            
            // Return last inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function check will check if username and password exists
     *
     * @param string $username contains the member's username
     * @param string $password contains the member's password
     * 
     * @return boolean true or false
     */
    public function check( $username, $password ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('member_username', strtolower($username));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            if ( $result[0]->member_password AND password_verify($password, $result[0]->member_password) ) {
                
                $this->last_access( $result[0]->member_id );
                
                if ( is_numeric( $result[0]->member_id ) ) {
                    
                    // Load User model
                    $this->load->model('User', 'user');
                    
                    // Get Username by ID
                    $username = $this->user->get_username_by_id( $result[0]->user_id );
                    
                    if ( $username ) {
                        
                        return array(
                            'username' => $username,
                            'status' => $result[0]->status
                        );
                        
                    } else {
                        
                        return false;
                        
                    }
                    
                } else {
                    
                    return false;
                    
                }
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function last_access updates last access date
     *
     * @param integer $member_id contains member's member_id
     * 
     * @return void
     */
    public function last_access( $member_id ) {
        
        $this->db->where('member_id', $member_id);
        $this->db->update($this->table, ['last_access' => date('Y-m-d H:i:s')]);
        
    }
    
    /**
     * The function update_member updates a member data
     *
     * @param integer $member_id contains the member_id 
     * @param integer $user_id contains the user_id 
     * @param string $email contains the member's email
     * @param integer $role_id contains the member's role_id
     * @param integer $status contains the member's status
     * @param string $about contains the member's information
     * @param string $password contains the member's password
     * 
     * @return boolean true or false
     */
    public function update_member( $member_id, $user_id, $email, $role_id, $status, $about, $password = NULL ) {
        
        $this->db->where( array(
            'member_id' => $member_id,
            'user_id' => $user_id
        ) );

        $data = array(
            'member_email' => $email,
            'role_id' => $role_id,
            'status'=> $status,
            'about_member'=> $about
        );

        if ( $password ) {
            $data['member_password'] = $this->bcrypt->hash_password($password);
        }
        
        $this->db->update( $this->table, $data );
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_members
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays posts
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object with members or false
     */
    public function get_members( $user_id, $start = NULL , $limit = NULL ) {
        
        // Get team's members
        $this->db->select('teams.member_id,teams.member_username,teams.member_email,teams.status,teams.date_joined,teams.last_access,teams_roles.role');
        $this->db->from($this->table);
        $this->db->join('teams_roles', 'teams.role_id=teams_roles.role_id', 'left');
        $this->db->where( array(
                'teams.user_id' => $user_id
             )
        );
        
        $this->db->order_by('teams.member_id', 'desc');
        
        if ( $limit ) {
            
            $this->db->limit(10);
            $this->db->limit($limit, $start);
            
        }
        
        $query = $this->db->get();
        
        // If $limit is null will return number of rows
        if ( !$limit ) {
            
            return $query->num_rows();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_members gets member details
     *
     * @param integer $user_id contains the user_id
     * @param integer $member_id contains the member's ID
     * @param string $member_username contains the member's username
     * 
     * @return object with member data or false
     */
    public function get_member( $user_id, $member_id, $member_username=NULL ) {

        $this->db->select('teams.member_id, teams.member_username, teams.member_email, teams_roles.role_id, teams_roles.role, teams.status, teams.about_member, UNIX_TIMESTAMP(teams.date_joined) AS date_joined,UNIX_TIMESTAMP(teams.last_access) AS last_access');
        $this->db->join('teams_roles', 'teams.role_id=teams_roles.role_id', 'left');
        $this->db->from($this->table);
        
        if ( $member_username ) {
            
            $this->db->where( array(
                'teams.user_id' => $user_id,
                'teams.member_username' => $member_username
            ) );              
            
        } else {
            
            $this->db->where( array(
                'teams.member_id' => $member_id,
                'teams.user_id' => $user_id
            ) );            
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function delete_member deletes a member
     *
     * @param integer $user_id contains the user_id
     * @param integer $member_id contains the member's ID
     * 
     * @return boolean true or false
     */
    public function delete_member( $user_id, $member_id ) {
        
        $this->db->delete( $this->table, array(
            'member_id' => $member_id,
            'user_id' => $user_id
        ) );
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The function delete_members deletes all team's member of a user
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function delete_members( $user_id ) {
        
        $this->db->delete( $this->table, array(
            'user_id' => $user_id
        ) );
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_member_email verifies if email address already exists
     *
     * @param string $email contains the email address
     * 
     * @return boolean true or false
     */
    public function check_member_email( $email ) {
        $this->db->select('member_id');
        $this->db->from($this->table);
        $this->db->where(array('member_email' => $email));
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The protected method check_member_name verifies the member's username
     *
     * @param string $username contains the member's name
     * 
     * @return boolean true or false
     */
    protected function check_member_name( $username ) {
        
        // If the username already exists will generate a new username
        for ( $e = 0; $e < 1000; $e++ ) {
            
            // If $e is bigger than 0, will be renamed the username
            if ( $e > 0 ) {
                
                $new_name = $username . '_' . $e;
                
            } else {
                
                $new_name = $username;
                
            }
            
            $this->db->select( 'member_id' );
            $this->db->from($this->table);
            $this->db->where( 'member_username', $new_name );
            $query = $this->db->get();
            
            if ( $query->num_rows() == 0 ) {
                
                return $new_name;
                
            }
            
        }
        
        // If the username is not available return false
        return false;
        
    }
    
}

/* End of file base_teams.php */