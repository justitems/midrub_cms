<?php
/**
 * Campaigns Model
 *
 * PHP Version 5.6
 *
 * Campaigns file contains the Campaigns Model
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
 * Campaigns class - operates the campaigns table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Campaigns extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'campaigns';

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
     * The public method save_campaign creates a campaign
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the campaign's type
     * @param string $name contains the campaign's name
     * @param string $description contains the campaign's description
     * 
     * @return boolean true or false
     */
    public function save_campaign( $user_id, $type, $name, $description ) {
        
        // Get current time
        $created = time();
        
        // Set data to insert
        $data = ['user_id' => $user_id, 'type' => $type, 'name' => $name, 'description' => $description, 'created' => $created];
        
        // Save data
        $this->db->insert($this->table, $data);
        
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            
            // Return inserted id
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method save_campaign_meta saves campaign meta
     *
     * @param integer $campaign_id contains the campaign_id
     * @param string $smtp_option contains the meta name
     * @param string $field contains the meta field
     * @param string $value contains the meta value
     * 
     * @return boolean true or false
     */
    public function save_campaign_meta( $campaign_id, $smtp_option, $field, $value ) {
        
        // Verify if campaign exists
        $this->db->select('*');
        $this->db->from('campaigns_meta');
        $this->db->where(['campaign_id' => $campaign_id, 'meta_name' => $smtp_option]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // If exists, update data
            $data = [$field => $value];
            $this->db->where(['campaign_id' => $campaign_id, 'meta_name' => $smtp_option]);
            $this->db->update('campaigns_meta', $data);
            
            // Verfy if was updated successfully
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            // Set data value
            $data = ['campaign_id' => $campaign_id, 'meta_name' => $smtp_option, $field => $value];
            
            // Insert data
            $this->db->insert('campaigns_meta', $data);
            
            // Verify if data was saved
            if ( $this->db->affected_rows() ) {
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }    
    
    /**
     * The public method get_campaigns gets all campaigns
     *
     * @param integer $user_id contains the user_id
     * @param integer $page contains the page ID
     * @param string $type contains the campaign's type
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object results or false
     */
    public function get_campaigns( $user_id, $page, $type, $limit=NULL ) {
        
        // Verify if campaign exists
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'type' => $type]);
        $this->db->order_by('campaign_id', 'desc');
        
        // Verify if limit exists
        if ( $limit ) {
            
            $this->db->limit($limit, $page);
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            } else {
                
                return false;
                
            }
            
        } else {
            
            // Return total number of campaigns
            $query = $this->db->get();
            
            return $query->num_rows();
            
        }
        
    }
    
    /**
     * The public method campaign_owner verifies if the user is the campaign's author
     *
     * @param integer $user_id contains the user_id
     * @param integer $campaign_id contains the campaign's ID
     * 
     * @return object results or false
     */
    public function campaign_owner( $user_id, $campaign_id ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['campaign_id' => $campaign_id,'user_id' => $user_id]);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_campaign deletes a campaign by $campaign_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $campaign_id contains the campaign's ID
     * 
     * @return boolean true or false
     */
    public function delete_campaign( $user_id, $campaign_id ) {
        
        // Delete the campaign
        $this->db->delete($this->table, ['user_id' => $user_id,'campaign_id' => $campaign_id]);
        
        if ( $this->db->affected_rows() ) {
            
            // Delete templates and scheduled information
            $this->db->delete('templates', ['campaign_id' => $campaign_id, 'user_id' => $user_id]);
            $this->db->delete('scheduled', ['campaign_id' => $campaign_id, 'user_id' => $user_id]);
            $this->db->delete('scheduled_stats', ['campaign_id' => $campaign_id]);
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_campaign deletes campaigns by $user_id
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function delete_campaigns( $user_id ) {
        
        // Delete the capaign
        $this->db->delete($this->table, ['user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_templates deletes templates by $user_id
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function delete_templates( $user_id ) {
        
        $this->db->delete('templates', ['user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    } 
    
    /**
     * The public method delete_lists deletes lists by $user_id
     *
     * @param integer $user_id contains the user_id
     * 
     * @return boolean true or false
     */
    public function delete_lists( $user_id ) {
        
        $this->db->delete('lists', ['user_id' => $user_id]);
        
        if ( $this->db->affected_rows() ) {
            
            $this->db->delete('lists_meta', ['user_id' => $user_id]);
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_scheduled_stats deletes schedules stats by $user_id
     *
     * @param integer $user_id contains the user_id
     * 
     * @return bolean true or false
     */
    protected function delete_scheduled_stats( $user_id ) {
        
        $this->db->select('*');
        $this->db->from('scheduled');
        $this->db->where(['user_id' => $user_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            if( $result ){
                
                foreach($result as $res){
                    
                    $this->db->delete('scheduled_stats', array('sched_id' => $res->scheduled_id));
                    
                }
                
            }
            
        }
        
    }    
    
    /**
     * The public method delete_schedules deletes schedules by $user_id
     *
     * @param integer $user_id contains the user_id
     * 
     * @return bolean true or false
     */
    public function delete_schedules( $user_id ) {
        
        $this->delete_scheduled_stats($user_id);
        $this->db->delete('scheduled', array('user_id' => $user_id));
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_campaign_meta gets campaign's meta
     *
     * @param integer $campaign_id contains the campaign_id
     * @param string $smtp_option contains the meta name
     * 
     * @return object with campaign meta or false
     */
    public function get_campaign_meta( $campaign_id, $smtp_option ) {
        
        $this->db->select('*');
        $this->db->from('campaigns_meta');
        $this->db->where(['campaign_id' => $campaign_id, 'meta_name' => $smtp_option]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_user_campaigns gets all user's campaign
     *
     * @param integer $user_id contains the user_id
     * 
     * @return object results or false
     */
    public function get_user_campaigns( $user_id ) {
        
        // Verify if campaign exists
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['user_id' => $user_id, 'type' => 'email']);
        $this->db->order_by('campaign_id', 'desc');
        $query = $this->db->get();

        if ( $query->num_rows() > 0 ) {

            $result = $query->result();
            return $result;

        } else {

            return false;

        }
        
    }
    
}

/* End of file Campaigns.php */