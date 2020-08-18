<?php
/**
 * Botis Model
 *
 * PHP Version 5.6
 *
 * Botis file contains the Botis Model
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
 * Botis class - operates the botis table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Botis extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'bots';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_bot saves bots data
     *
     * @param string $type contains the bot's type
     * @param integer $user_id contains the user_id
     * @param string $rule1 contains the first rule
     * 
     * @return integer last inserted id or false
     */
    public function save_bot( $type, $user_id, $rule1, $rule2 = NULL, $rule3 = NULL, $rule4 = NULL, $rule5 = NULL, $rule6 = NULL ) {
        
        // Get current time
        $created = time();
        
        // Set data
        $data = ['user_id' => $user_id, 'type' => $type, 'rule1' => $rule1];
        
        if ( ($rule3 == 'rule3') || ($rule3 == 'rule4') || ($rule3 == 'rule5') || ($rule3 == 'rule6') ) {
            
            if ( $rule2 ) {
                
                $data['rule2'] = $rule2;
                $data['rule7'] = time();
                
            }
            
            $data[$rule3] = $rule4;
            
        } else {
            
            if ( $rule2 ) {
                
                $data['rule2'] = $rule2;
                
            }
            
            if ( $rule3 ) {
                
                $data['rule3'] = $rule3;
                
            }
            
            if ( $rule4 ) {
                
                $data['rule4'] = $rule4;
                
            }
            
        }
        
        if ( ($type == 'instavy-follow') || ($type == 'fillow-follow') || ($type == 'visam-follow') || ($type == 'dmitas-follow') || ($type == 'twilos-follow') ) {
            
            $data['rule7'] = $rule5;
            
        } else if ( $type == 'inlike-media' ) {
            
            $data['rule7'] = $rule5;
            
        }
        
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            // Return last inserted ID
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method update_bot updates bots data
     *
     * @param integer $bot_id contains the bot's id
     * @param integer $user_id contains the user_id
     * @param string $type contains the column name
     * @param string $type contains the column value
     * 
     * @return integer last inserted id or false
     */
    public function update_bot( $bot_id, $user_id, $type = NULL, $value = NULL ) {
        
        // Set data value
        $data = ['user_id' => $user_id, $type => $value];
        
        if ( $type == 'rule3' && $value > 0 ) {
            
            $data['rule7'] = time();
            
        }
        
        $this->db->where(['bot_id' => $bot_id, 'user_id' => $user_id]);
        $this->db->update($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_bot verifies if a bot data exists
     *
     * @param string $type contains the bot's type
     * @param integer $user_id contains the user_id
     * @param string $rule1 contains the first rule
     * @param string $rule2 contains the second rule
     * @param string $bot_id contains the bot_id
     * 
     * @return integer with bot_id or false
     */
    public function check_bot( $type, $user_id, $rule1, $rule2 = NULL, $bot_id = NULL ) {
        
        // Set data
        $data = ['user_id' => $user_id, 'type' => $type, 'rule1' => $rule1];
        
        if ( $rule2 ) {
            
            if ( $bot_id ) {
                
                $data['bot_id'] = $bot_id;
                
            } else {
                
                $data['rule2'] = $rule2;
                
            }
            
        }
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($data);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            if ( $rule2 ) {
                
                return $result;
                
            } else if ( $type == 'twilos-opts' ) {
                
                return $result;
                
            } else if ( $type == 'instavy-opts' ) {
                
                return $result;
                
            } else if ( $type == 'fillow-opts' ) {
                
                return $result;
                
            } else if ( $type == 'inlike-opts' ) {
                
                return $result;
                
            } else if ( $type == 'visam-opts' ) {
                
                return $result;
                
            } else if ( $type == 'dmitas-opts' ) {
                
                return $result;
                
            } else if ( $type == 'retweet' ) {
                
                return $result;
                
            } else {
                
                return $result[0]->bot_id;
                
            }
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_bota verifies if a bot data exists by using 4 columns
     *
     * @param integer $bot_id contains the bot's id
     * @param string $type contains the bot's type
     * @param integer $user_id contains the user_id
     * @param string $rule1 contains the first rule
     * 
     * @return boolean true or false
     */
    public function check_bota( $bot_id, $type, $user_id, $rule1 = NULL ) {
        
        // Set data
        $data = ['bot_id' => $bot_id, 'user_id' => $user_id, 'type' => $type];
        
        if ( $rule1 ) {
            
            $data['rule1'] = $rule1;
            
        }
        
        $this->db->select('bot_id');
        $this->db->from($this->table);
        $this->db->where($data);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_bot deletes bot data
     *
     * @param string $type contains the bot's type
     * @param integer $user_id contains the user_id
     * @param string $rule1 contains the first rule
     * @param integer $bot_id contains the bot_id
     * 
     * @return boolean true or false
     */
    public function delete_bot( $type, $user_id, $rule1, $bot_id = NULL ) {
        
        // Set data
        $data = ['user_id' => $user_id, 'type' => $type];
        
        if ( $type == 'twilos-search' ) {
            
            $data['bot_id'] = $rule1;
            
        } else if ( $type == 'instavy-search' ) {
            
            $data['bot_id'] = $rule1;
            
        } else if ( $type == 'fillow-search' || ($type == 'visam-search') ) {
            
            $data['bot_id'] = $rule1;
            
        } else if ( $type == 'inlike-search' ) {
            
            $data['bot_id'] = $rule1;
            
        } else {
            
            $data['rule1'] = $rule1;
            
        }
        if ( $bot_id ) {
            
            $data['bot_id'] = $bot_id;
            
        }
        
        $this->db->delete($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            if ( $type == 'promotis-comment' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'promotis-com-opts', 'rule2' => $bot_id]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'promotis-history', 'rule2' => $bot_id]);
                
            } else if ( $type == 'twilos-search' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'twilos-follow', 'rule1' => $rule1]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'twilos-opts', 'rule1' => $rule1]);
                
            } else if ( $type == 'instavy-search' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'instavy-follow', 'rule1' => $rule1]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'instavy-opts', 'rule1' => $rule1]);
                
            } else if ( $type == 'inlike-search' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'inlike-media', 'rule1' => $rule1]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'inlike-opts', 'rule1' => $rule1]);
                
            } else if ( $type == 'fillow-search' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'fillow-follow', 'rule1' => $rule1]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'fillow-opts', 'rule1' => $rule1]);
                
            } else if ( $type == 'visam-search' ) {
                
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'visam-follow', 'rule1' => $rule1]);
                $this->db->delete($this->table, ['user_id' => $user_id, 'type' => 'visam-opts', 'rule1' => $rule1]);
                
            }
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_all_bots gets all rows by type
     *
     * @param string $type contains the bot's type
     * @param integer $user_id contains the user_id
     * @param string $rule1 contains the first rule
     * @param string $rule2 contains the second rule
     * 
     * @return object with bots or false
     */
    public function get_all_bots( $type, $user_id, $rule1 = NULL, $rule2 = NULL ) {
        
        if ( $type == 'promotis-comment' ) {
            
            $this->db->select('b.rule3 as fop, b.rule4 as sop, b.rule5 as top, b.rule6 as ffop', false);
            
        } else if ( $type == 'promotis-com-opts' ) {
            
            $this->db->select('networks.token,networks.secret,networks.api_key,networks.api_secret,activity.net_id as neti_id', false);
            
        } else if ( $type == 'promotis-history' ) {
            
            $this->db->select('c.rule2 as text, c.rule3 as link, c.rule4 as photo', false);
            
        }
        
        $this->db->select('bots.bot_id,bots.user_id,bots.type,bots.rule1,bots.rule2,bots.rule3,bots.rule4,bots.rule5,bots.rule6,bots.rule7,networks.user_name,networks.net_id');
        $this->db->from($this->table);
        $this->db->join('activity', 'bots.rule1=activity.activity_id', 'left');
        $this->db->join('networks', 'activity.network_id=networks.network_id', 'left');
        
        if ( $type == 'promotis-comment' ) {
            
            $this->db->join('bots b', 'bots.bot_id=b.rule2', 'left');
            
        } else if ( $type == 'promotis-history' ) {
            
            $this->db->join('bots c', 'bots.rule2=c.bot_id', 'left');
            
        }
        
        $data = ['bots.user_id' => $user_id, 'bots.type' => $type];
        
        if ( $rule1 ) {
            
            $data['bots.rule1'] = $rule1;
            
        }
        
        if ( $rule2 ) {
            
            if ( ($type != 'promotis-history') && ($type != 'twilos-search') && ($type != 'instavy-search') && ($type != 'fillow-search') && ($type != 'visam-search') && ($type != 'dmitas-follow') ) {
                
                $data['bots.rule2'] = $rule2;
                
            }
            
        }
        
        $this->db->where($data);
        $this->db->order_by('bots.bot_id','DESC');
        $this->db->group_by(['bots.bot_id']);
        
        if ( $type == 'promotis-history' ) {
            
            if ( is_numeric($rule2) ) {
                
                $this->db->limit(10,$rule2);
                
            }
            
        } else if ( $type == 'twilos-search' ) {
            
            if ( is_numeric($rule2) ) {
                
                $this->db->limit(10,$rule2);
                
            }
            
        } else if ( ($type == 'instavy-search') || ($type == 'fillow-search')  || ($type == 'visam-search')  || ($type == 'dmitas-follow') ) {
            
            if ( is_numeric($rule2) ) {
                
                $this->db->limit(10,$rule2);
                
            }
            
        } else if( $type == 'inlike-search' ) {
            
            if ( is_numeric($rule2) ) {
                
                $this->db->limit(10,$rule2);
                
            }
            
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method check_random_user gets a random user_id
     * 
     * @return integer user_id or false
     */
    public function check_random_user() {
        
        $this->db->select('user_id');
        $this->db->from($this->table);
        $this->db->group_by('user_id');
        $this->db->order_by('rand()');
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->user_id;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_bot gets a bot 
     * 
     * @param array $args contains the query parameters
     * @param integer $rand contains a number
     * 
     * @return integer user_id or false
     */
    public function get_bot( $args, $rand = NULL ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($args);
        
        if ( $rand ) {
            $this->db->order_by('rand()');
        }
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_user_bots deletes all user bots
     *
     * @param $user_id contains the user_id
     * 
     * @return boolean true if were deleted or false
     */
    public function delete_user_bots( $user_id ) {
        
        $this->db->delete($this->table, ['user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Botis.php */
