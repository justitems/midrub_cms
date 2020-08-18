<?php
/**
 * User Model
 *
 * PHP Version 5.6
 *
 * User file contains the User Model
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
 * User class - operates the user table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class User extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'users';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Load the bcrypt library
        $this->load->library('bcrypt');
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method check will check if username and password exists
     *
     * @param string $username contains the user's username
     * @param string $password contains the user's password
     * 
     * @return boolean true or false
     */
    public function check( $username, $password ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', strtolower($username));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();

            if ( $result[0]->password AND password_verify($password, $result[0]->password) ) {
                
                $this->last_access( $result[0]->user_id );
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_email checks if email address exists
     *
     * @param string $email contains the user's email
     * @param integer $user_id contains the user's user_id
     * 
     * @return boolean true or false
     */
    public function check_email( $email, $user_id = null ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', strtolower($email));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            if ( $user_id ) {
                
                $result = $query->result();
                
                if ( $user_id == $result[0]->user_id ) {
                    
                    return false;
                    
                } else {
                    
                    return true;
                    
                }
                
            } else {
                
                return true;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_username checks if username address exists
     *
     * @param string $username contains the user's username
     * 
     * @return boolean true or false
     */
    public function check_username( $username ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', strtolower($username));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_username_by_id gets username by user_id
     *
     * @param integer $id contains the user's user_id
     * 
     * @return string with username or false
     */
    public function get_username_by_id( $id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            return $result[0]->username;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_id_by_username gets user id by username
     *
     * @param string $username contains the user's username
     * 
     * @return integer with user's id or false
     */
    public function get_user_id_by_username( $username ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', strtolower($username));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            return $result[0]->user_id;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_username_by_email will get username by using email address
     *
     * @param string $email contains the user's email
     * 
     * @return string with username or false
     */
    public function get_username_by_email( $email ) {
        
        $this->db->select('username');
        $this->db->from($this->table);
        $this->db->where('email', strtolower($email));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            if ( $result[0]->username ) {
                
                return $result[0]->username;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_email_by will get username by using email address or user_id
     *
     * @param string $field contains the db field name
     * @param integer $user contains email or username
     * 
     * @return string with email or false
     */
    public function get_email_by( $field, $user ) {
        
        $this->db->select('email');
        $this->db->from($this->table);
        $this->db->where($field, strtolower($user));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            if ( $result[0]->email ) {
                
                return $result[0]->email;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_user deletes user by id
     *
     * @param integer $user_id contains user's user_id
     * 
     * @return boolean true or false
     */
    public function delete_user( $user_id ) {
        
        // Delete user's account
        $this->db->delete($this->table, array('user_id' => $user_id));
        
        if ( $this->db->affected_rows() ) {
            
            // Delete user meta
            $this->db->delete('users_meta', array('user_id' => $user_id));
            
            // Delete user's data from notifications_stats
            $this->db->delete('notifications_stats', array('user_id' => $user_id));

            // Delete the user's auth networks
            $this->db->delete('users_social', array('user_id' => $user_id));
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method add_code will save reset/activation code in the database. The reset confirmation email can be sent once in 24 hours.
     *
     * @param string $email contains user's email
     * @param integer $code contains a string
     * @param string $key contains a string
     * 
     * @return boolean true or false 
     */
    public function add_code( $email, $code, $key ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('email', strtolower($email));
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            if ( $result[0]->reset_code < time() - 86400 ) {
                
                $this->db->where('user_id', $result[0]->user_id);
                $this->db->update($this->table, [$key => $code]);
                
                if ( $this->db->affected_rows() ) {
                    
                    return $result[0]->user_id;
                    
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
     * The public method check_reset_code checks if reset code is valid
     *
     * @param integer $code contains the reset code
     * @param integer $user contains the user_id
     * 
     * @return boolean true or false
     */
    public function check_reset_code( $code, $user ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user, 'reset_code' => $code]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_activation_code checks if activation code is valid
     *
     * @param integer $code contains the reset code
     * @param integer $user contains the user_id
     * 
     * @return boolean true or false
     */
    public function check_activation_code( $code, $user ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user, 'activate' => $code]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method activate_account will activate user account
     *
     * @param integer $user contains the user_id
     * 
     * @return boolean true or false
     */
    public function activate_account( $user ) {
        
        $this->db->where(['user_id' => $user]);
        $this->db->update($this->table, ['status' => 1, 'activate' => '']);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method password_changed will save new password
     *
     * @param string $password contains the user's password
     * @param integer $code contains the reset code
     * @param integer $user contains the user_id
     * 
     * @return boolean true if password was changed or false
     */
    public function password_changed( $password, $code, $user ) {
        
        $this->db->where(['user_id' => $user, 'reset_code' => $code]);
        $this->db->update($this->table, ['password' => $this->bcrypt->hash_password($password), 'reset_code' => '']);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method signup will create new users
     *
     * @param string $first_name contains the first name
     * @param string $last_name contains the last name
     * @param string $username contains the username
     * @param string $email contains the user's email
     * @param string $password contains the user's password
     * @param integer $pstatus contains the user's status
     * @param integer $prole contains the user's role
     * 
     * @return boolean true or false
     */
    public function signup( $first_name = null, $last_name = null, $username, $email, $password, $pstatus = null, $prole = null ) {
        
        $status = 1;
        if ( $this->options_check('signup_confirm') AND ( $pstatus != 1) ) {
            
            $status = 0;
            
        }
        
        $role = 0;
        
        if ( $prole == 1 ) {
            
            $role = 1;
            
        }
        
        $ip = $this->input->ip_address();
        
        $data = array(
            'username' => strtolower($username),
            'email' => strtolower($email),
            'password' => $this->bcrypt->hash_password($password),
            'role' => $role,
            'status' => $status,
            'date_joined' => date('Y-m-d H:i:s'),
            'ip_address' => $ip
            );
        
        if ( $first_name ) {
            $data['first_name'] = $first_name;
        }
        
        if ( $last_name ) {
            $data['last_name'] = $last_name;
        }        
        
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method updateuser will update user data
     *
     * @param integer $user_id contains the user's user_id
     * @param string $first_name contains the first name
     * @param string $last_name contains the last name
     * @param string $email contains the user's email
     * @param string $password contains the user's password
     * @param integer $role contains the user's role
     * @param integer $status contains the user's status
     * @param integer $plan contains the user's plan  
     * @param string $proxy contains the user's proxy
     * 
     * @return boolean true or false
     */
    public function updateuser( $user_id, $first_name=NULL, $last_name=NULL, $email, $password, $role=NULL, $status=NULL, $plan=NULL, $proxy=NULL ) {
        
        if ( $user_id ) {
            
            $data = ['email' => $email];
            
            if ( $first_name ) {
                $data['first_name'] = $first_name;
            }

            if ( $last_name ) {
                $data['last_name'] = $last_name;
            } 
            
            $i = 0;
            
            if( ($role != NULL) AND ($role != 1) ) {
                
                $CI = & get_instance();
                $CI->load->model('plans');
                
                if( $CI->plans->change_plan($plan, $user_id) ) {
                    
                    $i++;
                    
                }
                
            }
            
            $this->db->where('user_id', $user_id);
            
            if ( $role == null ) {
                
                if ( $password ) {
                    
                    $data['password'] = $this->bcrypt->hash_password($password);
                    
                    $this->db->update($this->table, $data);
                    
                } else {
                    
                    $this->db->update($this->table, $data);
                    
                }
                
            } else {
                
                if ( $password ) {
                    
                    $data['password'] = $this->bcrypt->hash_password($password);
                    
                    $data['role'] = $role;
                    
                    $data['status'] = $status;
                    
                    $this->db->update($this->table, $data);
                    
                } else {
                    
                    $data['role'] = $role;
                    
                    $data['status'] = $status;
                    
                    $this->db->update($this->table, $data);
                    
                }
                
            }
            
            if ( $this->db->affected_rows() ) {
                
                      $i++;
                      
            }
            
            if ( $i > 0 ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method update_proxy updates user proxy
     *
     * @param integer $user_id contains user_id
     * 
     * @return boolean true or false
     */
    public function update_proxy( $user_id,$meta_value ) {
        
        $this->db->select('meta_value');
        $this->db->from('users_meta');
        $this->db->where(['user_id' => $user_id, 'meta_name' => 'proxy']);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $data = ['meta_value' => $meta_value];
            $this->db->where(['user_id' => $user_id, 'meta_name' => 'proxy']);
            $this->db->update('users_meta', $data);
            
        } else {
            
            $data = ['user_id' => $user_id, 'meta_name' => 'proxy', 'meta_value' => $meta_value];
            $this->db->insert('users_meta', $data);
            
        }
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_option gets user's option
     *
     * @param integer $user_id contains user_id
     * @param string $meta_name contains the user's meta
     * 
     * @return string with user's option or false
     */
    public function get_user_option( $user_id, $meta_name ) {
        
        $this->db->select('meta_value');
        $this->db->from('users_meta');
        $this->db->where(['user_id' => $user_id, 'meta_name' => $meta_name]);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            return $result[0]->meta_value;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_user_option deletes user's option
     *
     * @param integer $user_id contains user_id
     * @param string $meta_name contains the user's meta
     * 
     * @return boolean true or false
     */
    public function delete_user_option( $user_id, $meta_name ) {
        
        $this->db->where(['user_id' => $user_id, 'meta_name' => $meta_name]);
        $this->db->delete('users_meta');
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_ip_and_date checks if ip exists and if the ip was added today
     * 
     * @return integer with status
     */
    public function check_ip_and_date() {
        
        $ip = $this->input->ip_address();
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('ip_address', $ip);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            if ( date('Y-m-d', strtotime($result[0]->date_joined)) == date('Y-m-d') ) {
                
                return 1;
                
            } else {
                
                return 2;
                
            }
            
        } else {
            
            return 0;
            
        }
        
    }
    
    /**
     * The public method get_all_user_email_for_notifications gets all user's email that want to receive notifications by email
     * 
     * @return object with user's emails or false 
     */
    public function get_all_user_email_for_notifications() {
        
        $this->db->select('email');
        $this->db->from($this->table);
        $this->db->where("users.user_id IN", "(SELECT user_id FROM users_meta WHERE users_meta.meta_name='email_notifications')", false);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $results = $query->result();
            return $results;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_role_by_username gets user role
     *
     * @param string $username contains the user's username
     * 
     * @return integer with user's role 
     */
    public function check_role_by_username( $username ) {
        
        // Get ip
        $ip = $this->input->ip_address();
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            return $result[0]->role;
            
        }
        
    }
    
    /**
     * The public method check_status_by_username gets user status 
     *
     * @param string $username contains the user's username
     * 
     * @return integer with user's status 
     */
    public function check_status_by_username( $username ) {
        
        // Get current user ip
        $ip = $this->input->ip_address();
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            return $result[0]->status;
            
        }
        
    }
    
    /**
     * The public method last_access updates last access date
     *
     * @param integer $user_id contains user's user_id
     * 
     * @return void
     */
    public function last_access( $user_id ) {
        
        $this->db->where('user_id', $user_id);
        
        // Also will be deleted the reset code
        $this->db->update($this->table, ['last_access' => date('Y-m-d H:i:s'), 'reset_code' => ' ']);
        
    }
    
    /**
     * The public method get_users gets users from database
     *
     * @param integer $start contains the number where start displaing users
     * @param integer $limit contains the display limit
     * @param integer $order contains the order param
     * @param string $key contains search key
     * 
     * @return object with users or false
     */
    public function get_users( $start, $limit, $order, $key = null ) {
        
        $this->db->select('user_id,username,email,role,MD5(email) as md5');
        $this->db->from($this->table);
        $key = $this->db->escape_like_str($key);
        
        if ( $key ) {
            
            $this->db->like('username', $key);
            $this->db->or_like('email', $key);
            
        }
        
        // If $order is 1 will be redirected by last_access
        if ( $order ) {
            
            $this->db->order_by('last_access', 'desc');
            
        } else {
            
            $this->db->order_by('user_id', 'desc');
            
        }
        
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_active_users gets active users from database
     *
     * @param integer $start contains the number where start displaing users
     * @param integer $limit contains the display limit
     * @param integer $time contains the time period
     * @param integer $mod allows to get data without pagination
     * 
     * @return object with users or false
     */
    public function get_active_users( $start, $limit, $time, $mod = NULL ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['UNIX_TIMESTAMP(last_access)>' => time() - ($time * 86400), 'role<' => 1]); // we count only users
        $this->db->order_by('user_id', 'desc');
        
        if ( !$mod ) {
            $this->db->limit($limit, $start);
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            if ( !$mod ) {
            
                $result = $query->result();
                return $result;
                
            } else {
                
                return $query->num_rows();
                
            }
            
        } else {
            
            if ( $mod ) {
                
                return '0';
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method get_user_info gets user data from database
     *
     * @param integer $user_id contains user's user_id
     * 
     * @return array with user info or false 
     */
    public function get_user_info( $user_id ) {
        
        $this->db->select('user_id,first_name,last_name,username,email,role,status,date_joined');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            $result = $query->result();
            
            // Now get user plan
            $this->db->select('*');
            $this->db->from('users_meta');
            $this->db->where(['user_id'=>$user_id,'meta_name'=>'plan']);
            $this->db->limit(1);
            $check = $this->db->get();
            $get_plan = $check->result();
            $plan = @$get_plan[0]->meta_value;
            $proxy = $this->get_user_option($user_id,'proxy');
            
            if ( !$proxy ) {
                
                $proxy = '';
                
            }
            
            return [
                'user_id' => $result[0]->user_id,
                'first_name' => $result[0]->first_name,
                'last_name' => $result[0]->last_name,
                'email' => $result[0]->email,
                'username' => $result[0]->username,
                'role' => $result[0]->role,
                'status' => $result[0]->status,
                'proxy' => $proxy,
                'date' => strtotime($result[0]->date_joined),
                'current' => time(),
                'plan' => $plan
                ];
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method count_all_users gets posts from database
     *
     * @param string $key contains the search key
     * @param integer $time contains the time duration
     * 
     * @return integer with number of users
     */
    public function count_all_users( $key = null, $time = null ) {
        
        $this->db->select('username');
        $this->db->from($this->table);
        $key = $this->db->escape_like_str($key);
        
        if ( $key ) {
            
            $this->db->like('username', $key);
            $this->db->or_like('email', $key);
            
        }
        
        if ( is_numeric($time) ) {
            
            $this->db->where('UNIX_TIMESTAMP(date_joined) >', strtotime('-' . $time . 'day', time()));
            
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            return $query->num_rows();
            
        } else {
            
            return '0';
            
        }
        
    }
    
    /**
     * The public method get_last_users gets last users registered after the $time
     *
     * @param integer $time contains the time duration
     * 
     * @return array with last users or false     
     */
    public function get_last_users( $time ) {
        
        $this->db->select('LEFT(date_joined,10) as date', false);
        $this->db->select('COUNT(user_id) as number', false);
        $this->db->from($this->table);
        $this->db->where('UNIX_TIMESTAMP(date_joined) >', strtotime('-' . $time . 'day', time()));
        $this->db->group_by('date');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $new_array = [];
            
            foreach ( $result as $data ) {
                
                $new_array[$data->date] = $data->number;
                
            }
            
            return $new_array;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method options_check is used to get some data from options table
     *
     * @param string $data contains option key
     * 
     * @return boolean true or false   
     */
    public function options_check( $data ) {
        
        $this->db->select('*');
        $this->db->from('options');
        $this->db->where(['option_key' => $data, 'option_value' => '1']);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_all_sessions deletes all user's sessions from database
     * 
     * @return void
     */
    public function delete_all_sessions() {
        
        // Get current user IP
        $ip = $this->input->ip_address();
        
        // Delete all user sessions
        $this->db->delete('ci_sessions', array('ip_address' => $ip));
        
    }
    
}
/* End of file User.php */
