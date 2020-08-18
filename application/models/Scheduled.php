<?php
/**
 * Scheduled Model
 *
 * PHP Version 5.6
 *
 * Scheduled file contains the Scheduled Model
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
 * Scheduled class - operates the scheduled table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Scheduled extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'scheduled';

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
     * The public method schedule_template schedules a template
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the type
     * @param integer $campaign_id contains the campaign's ID
     * @param integer $list_id contains the list's ID
     * @param integer $template_id contains the template's ID
     * @param integer $send_at contains the scheduled time
     * 
     * @return integer with Last Inserted ID or false
     */
    public function schedule_template( $user_id, $type, $campaign_id, $list_id, $template_id, $con, $stemplate, $send_at ) {
        
        $data = ['user_id' => $user_id, 'type' => $type, 'campaign_id' => $campaign_id, 'list_id' => $list_id, 'template_id' => $template_id, 'con' => $con, 'template' => $stemplate, 'send_at' => $send_at];
        $this->db->insert($this->table, $data);
        
        if ( $this->db->affected_rows() ) {
            
            return $this->db->insert_id();
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_scheduled gets scheduleds
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the type
     * @param integer $campaign_id contains the campaign's ID
     * 
     * @return boolean true or false
     */
    public function get_scheduleds( $user_id, $type, $campaign_id ) {
        
        $data = ['scheduled.user_id' => $user_id, 'scheduled.type' => $type, 'scheduled.campaign_id' => $campaign_id, 'scheduled.a' => 0];
        $this->db->select('scheduled.send_at,scheduled.scheduled_id,scheduled.list_id,templates.title,scheduled.template_id,lists.name,UNIX_TIMESTAMP(CURRENT_TIMESTAMP) as tim',FALSE);
        $this->db->from($this->table);
        $this->db->join('templates', 'scheduled.template_id=templates.template_id', 'left');
        $this->db->join('lists', 'scheduled.list_id=lists.list_id', 'left');
        $this->db->where($data);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_schedule gets schedule's information 
     *
     * @param integer $user_id contains the user's id
     * @param integer $schedule_id contains the scheduled's id
     * 
     * @return object with the schedule's data
     */
    public function get_schedule( $user_id, $schedule_id ) {
        
        $this->db->select('scheduled.send_at as datetime', false);
        $this->db->select('campaigns.name as cname', false);
        $this->db->select('lists.name, scheduled.scheduled_id, scheduled.list_id, scheduled.campaign_id, templates.title');
        $this->db->from($this->table);
        $this->db->join('templates', 'templates.template_id=scheduled.template_id', 'left');
        $this->db->join('lists', 'lists.list_id=scheduled.list_id', 'left');
        $this->db->join('campaigns', 'campaigns.campaign_id=scheduled.campaign_id', 'left');
        $this->db->where(['scheduled.user_id' => $user_id, 'scheduled.scheduled_id' => $schedule_id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Get results
            $result = $query->result();
            
            return ['cname' => $result[0]->cname, 'name' => $result[0]->name, 'scheduled_id' => $result[0]->scheduled_id, 'list_id' => $result[0]->list_id, 'campaign_id' => $result[0]->campaign_id, 'title' => $result[0]->title, 'datetime' => $result[0]->datetime, 'current' => time()];
            
        } else {
            
            return '';
            
        }
        
    }
    
    /**
     * The public method get_sents gets sents emails by user_id
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the type
     * 
     * @return object with sents emails or false
     */
    public function get_sents( $user_id, $type ) {
        
        $data = ['scheduled.user_id' => $user_id, 'scheduled.type' => $type, 'scheduled.send_at >' => strtotime(date('Y-m'))];
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('scheduled_stats', 'scheduled.scheduled_id=scheduled_stats.sched_id', 'left');
        $this->db->where($data);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_sent gets sent templates from database by campaign's ID
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the type
     * @param integer $campaign_id contains the campaign's ID
     * @param integer $page contains the page number
     * 
     * @return boolean true or false
     */
    public function get_sent( $user_id, $type, $campaign_id, $page=NULL ) {
        
        // Set data
        $data = ['scheduled.user_id' => $user_id, 'scheduled.type' => $type, 'scheduled.campaign_id' => $campaign_id];
        
        if ( $page ) {
            
            $this->db->select('scheduled.a,scheduled.send_at,scheduled.scheduled_id,scheduled.list_id,templates.title,scheduled.template_id,lists.name,UNIX_TIMESTAMP(CURRENT_TIMESTAMP) as tim,COUNT(scheduled_stats.stat_id) as sent,SUM(CASE WHEN scheduled_stats.unsubscribed > 0 THEN 1 ELSE 0 END) as unsub,SUM(CASE WHEN scheduled_stats.readed > 0 THEN 1 ELSE 0 END) as readi,SUM(CASE WHEN (scheduled_stats.readed = 0 AND scheduled_stats.unsubscribed = 0) THEN 1 ELSE 0 END) as unread',FALSE);
        
        } else {
            
            $this->db->select('scheduled.scheduled_id');
            
        }
        
        $this->db->from($this->table);
        $this->db->join('templates', 'scheduled.template_id=templates.template_id', 'left');
        $this->db->join('lists', 'scheduled.list_id=lists.list_id', 'left');
        $this->db->join('scheduled_stats', 'scheduled.scheduled_id=scheduled_stats.sched_id', 'left');
        $this->db->where($data);
        $this->db->group_by('scheduled.scheduled_id');
        $this->db->order_by('scheduled.send_at', 'desc');
        
        if ( $page ) {
            
            $page--;
            $this->db->limit(10, ($page*10));
            
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
     * The public method get_stats gets statistics from database by campaign's ID
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the type
     * @param integer $campaign_id contains the campaign's ID
     * 
     * @return object with statistics or false
     */
    public function get_stats( $user_id, $type, $campaign_id ) {
        
        // Set data
        $data = ['campaigns.user_id' => $user_id, 'campaigns.type' => $type, 'campaigns.campaign_id' => $campaign_id];
        $this->db->select('COUNT(scheduled_stats.stat_id) as sent,SUM(CASE WHEN scheduled_stats.unsubscribed > 0 THEN 1 ELSE 0 END) as unsub,SUM(CASE WHEN scheduled_stats.readed > 0 THEN 1 ELSE 0 END) as readi,SUM(CASE WHEN (scheduled_stats.readed = 0 AND scheduled_stats.unsubscribed = 0) THEN 1 ELSE 0 END) as unread',FALSE);
        $this->db->from('campaigns');
        $this->db->join('scheduled_stats', 'campaigns.campaign_id=scheduled_stats.campaign_id', 'left');
        $this->db->where($data);
        $this->db->group_by('campaigns.campaign_id');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_template deletes a template by $scheduled_id
     *
     * @param integer $user_id contains the user_id
     * @param integer $scheduled_id contains the scheduled's ID
     * 
     * @return boolean true or false
     */
    public function delete_schedules( $user_id, $scheduled_id ) {
        
        $this->db->delete($this->table, array('scheduled_id' => $scheduled_id,'user_id' => $user_id));
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_templates_to_send gets the scheduled templates
     * 
     * @return object with templates to send
     */
    public function get_templates_to_send() {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['a <' => 1, 'send_at <' => time()]);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        }
        
    }
    
    /**
     * The public method update_send set as sent a scheduled template
     *
     * @param integer $scheduled_id contains the scheduled_id
     * 
     * @return boolean true or false
     */
    public function update_send( $scheduled_id ) {
        
    	$this->db->set(['a' => '1']);
    	$this->db->where(['scheduled_id' => $scheduled_id]);
    	$this->db->update($this->table);
    	
        if ( $this->db->affected_rows() ) {
            
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }
    
    /**
     * The public method update_view mark as seen an email
     *
     * @param integer $scheduled_id contains the scheduled_id
     * @param string $body contains the list's body
     * 
     * @return boolean true or false
     */
    public function update_view( $scheduled_id, $body ) {
        
    	$this->db->set(['readed' => '1']);
    	$this->db->where(['sched_id' => $scheduled_id, 'body' => $body]);
    	$this->db->update('scheduled_stats');
    	
        if ( $this->db->affected_rows() ) {
            
            $vars = ['active' => '1'];
            $this->db->set($vars);
            $this->db->where(['body' => $body]);
            $this->db->update('lists_meta');
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }
    
    /**
     * The public method unsubscribe unsubscribes an email address from a campaign
     *
     * @param integer $campaign_id contains the Campaign's ID
     * @param integer $scheduled_id contain's the scheduled's ID
     * @param string $body contains the email address
     * 
     * @return boolean true or false
     */
    public function unsubscribe( $campaign_id, $scheduled_id, $body ) {
        
    	$this->db->set(['unsubscribed' => '1']);
    	$this->db->where(['campaign_id' => $campaign_id, 'sched_id' => $scheduled_id, 'body' => $body]);
    	$this->db->update('scheduled_stats');
        
    	if ( $this->db->affected_rows() ) {
            
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }
    
    /**
     * The public method save_stats saves scheduled's stats
     *
     * @param integer $scheduled_id contains the scheduled_id
     * @param integer $campaign_id contains the campaign_id
     * @param integer $list_id contains the list_id
     * @param integer $template_id contains the template_id
     * @param string $body contains the email address
     * 
     * @return boolean true or false
     */
    public function save_stats( $scheduled_id, $campaign_id, $list_id, $template_id, $body ) {
        
        $data = ['sched_id' => $scheduled_id, 'campaign_id' => $campaign_id, 'list_id' => $list_id, 'template_id' => $template_id, 'body' => $body];
        $this->db->insert('scheduled_stats', $data);
        
    	if ( $this->db->affected_rows() ) {
            
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }
    
    /**
     * The public method get_scheduled_stats gets scheduled stats by scheduled_id
     *
     * @param integer $user_id contains the user_id
     * @param string $type contains the meta type
     * @param integer $scheduled_id contains the scheduled's ID
     * @param integer $page contains the page number
     * 
     * @return object with stats or false
     */
    public function get_scheduled_stats( $user_id, $type, $scheduled_id, $page=NULL, $limit=NULL ) {
        
        if ( $type == 'opened' ) {
            
            $this->db->select('*');
            $this->db->from('scheduled_stats');
            $this->db->join('scheduled', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
            $this->db->where(['scheduled.user_id' => $user_id, 'scheduled_stats.sched_id' => $scheduled_id, 'scheduled_stats.readed' => 1, 'scheduled_stats.unsubscribed' => 0]);
            
            if ( $page ) {
                
                $this->db->limit($limit,$page);
                
            }
            
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            }
            
        } else if( $type == 'unread' ) {
            
            $this->db->select('*');
            $this->db->from('scheduled_stats');
            $this->db->join('scheduled', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
            $this->db->where(['scheduled.user_id' => $user_id, 'scheduled_stats.sched_id' => $scheduled_id, 'scheduled_stats.readed' => 0]);
            
            if ( $page ) {
                
                $this->db->limit($limit,$page);
                
            }
            
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            }
            
        } else if( $type == 'unsubscribed' ) {
            
            $this->db->select('*');
            $this->db->from('scheduled_stats');
            $this->db->join('scheduled', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
            $this->db->where(['scheduled.user_id' => $user_id, 'scheduled_stats.sched_id' => $scheduled_id, 'scheduled_stats.unsubscribed' => 1]);
            
            if ( $page ) {
                
                $this->db->limit($limit,$page);
                
            }
            
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            }
            
        } else {
            
            $this->db->select('*');
            $this->db->from('scheduled_stats');
            $this->db->join('scheduled', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
            $this->db->where(['scheduled.user_id' => $user_id, 'scheduled_stats.sched_id' => $scheduled_id]);
            
            if ( $page ) {
                
                $this->db->limit($limit,$page);
                
            }
            
            $query = $this->db->get();
            
            if ( $query->num_rows() > 0 ) {
                
                $result = $query->result();
                return $result;
                
            }   
            
        }
        
    }
    
    /**
     * The public method get_open_schedules gets all readed templates
     *
     * @param integer $campaign_id contains the campaign_id
     * @param integer $template_id contains the template id
     * @param integer $time contains the time period
     * 
     * @return array with schedules or false
     */
    public function get_open_schedules( $campaign_id, $template_id, $time, $con ) {
        
        $this->db->select('*, LEFT(FROM_UNIXTIME(scheduled.send_at),10) as datetime', false);
        
        if ( $con < 1 ) {
            
            $this->db->select('COUNT(scheduled_stats.readed) as number', false);
            
        } else {
            
            $this->db->select('COUNT(scheduled_stats.unsubscribed) as number', false);
            
        }
        
        $this->db->from('scheduled');
        
        $this->db->join('scheduled_stats', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
        
        if ( $con < 1 ) {
            
            if ( $template_id > 0 ) {
                
                $this->db->where(['LEFT(FROM_UNIXTIME(scheduled.send_at),10)' => $time, 'scheduled_stats.readed' => '1', 'scheduled.template_id' => $template_id]);
                
            } else {
                
                $this->db->where(['LEFT(FROM_UNIXTIME(scheduled.send_at),10)' => $time, 'scheduled_stats.readed' => '1', 'scheduled.campaign_id' => $campaign_id]);
                
            }
            
        } else {
            
            if ( $template_id > 0 ) {
                
                $this->db->where(['LEFT(FROM_UNIXTIME(scheduled.send_at),10)' => $time, 'scheduled_stats.unsubscribed' => '1', 'scheduled.template_id' => $template_id]);
                
            } else {
                
                $this->db->where(['LEFT(FROM_UNIXTIME(scheduled.send_at),10)' => $time, 'scheduled_stats.unsubscribed' => '1', 'scheduled.campaign_id' => $campaign_id]);
                
            }
            
        }
        
        $this->db->group_by(['datetime']);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->number;
            
        } else {
            
            return '0';
            
        }
        
    }
    
    /**
     * The public method get_sent_schedules gets all schedule sent
     *
     * @param integer $campaign_id contains the campaign_id
     * @param integer $template_id contains the template id
     * @param integer $time contains the time period
     * 
     * @return array with schedules or false
     */
    public function get_sent_schedules( $campaign_id, $template_id, $time ) {
        
        $this->db->select('*, LEFT(FROM_UNIXTIME(scheduled.send_at),10) as datetime', false);
        $this->db->select('COUNT(scheduled_stats.sched_id) as number', false);
        $this->db->from('scheduled');
        $this->db->join('scheduled_stats', 'scheduled_stats.sched_id=scheduled.scheduled_id', 'left');
        
        if ( $template_id > 0 ) {
            
            $this->db->where(['scheduled.send_at >' => strtotime('-' . $time . 'day', time()), 'scheduled.a' => '1', 'scheduled.template_id' => $template_id]);
            
        } else {
            
            $this->db->where(['scheduled.send_at >' => strtotime('-' . $time . 'day', time()), 'scheduled.a' => '1', 'scheduled.campaign_id' => $campaign_id]);
            
        }
        
        $this->db->group_by(['datetime']);
        
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $data = '';
            
            foreach ( $result as $dat ) {
                
                $data .= "{period: '" . date("Y-m-d", $dat->send_at). "', Sent: '" . $dat->number . "', Opened: '" . $this->get_open_schedules($campaign_id,$template_id,date("Y-m-d", $dat->send_at),0) . "', Unsubscribed: '" . $this->get_open_schedules($campaign_id,$template_id,date("Y-m-d", $dat->send_at),1) . "'},";
                
            }
            
            return "[" . substr($data,0,-1) . "]";
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_sent_emails gets emails for planner from database
     *
     * @param integer $user_id contains the user_id
     * @param integer $start contains the start of displays emails
     * @param integer $end displays the end time of displayed emails
     * 
     * @return object with posts or false
     */
    public function get_sent_emails( $user_id, $start, $end ) {
        
        $this->db->select('*, FROM_UNIXTIME(scheduled.send_at) as datetime', false);
        $this->db->select('scheduled.scheduled_id, templates.title');
        $this->db->from($this->table);
        $this->db->join('templates', 'templates.template_id=scheduled.template_id', 'left');
        $this->db->where(['scheduled.user_id' => $user_id, 'scheduled.send_at >=' => $start, 'scheduled.send_at <=' => $end]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Get results
            $results = $query->result();
            
            return $results;
            
        } else {
            
            return '';
            
        }
        
    }
    
}

/* End of file Scheduled.php */