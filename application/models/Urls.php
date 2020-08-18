<?php
/**
 * Urls Model
 *
 * PHP Version 5.6
 *
 * Posts file contains the Urls Model
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
 * Urls class - operates the urls table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Urls extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'urls';

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
     * The public method save_url
     *
     * @param string $url contains the original URL
     * 
     * @return string url's id
     */
    public function save_url( $url ) {
        
        $this->db->select('url_id');
        $this->db->from($this->table);
        $this->db->where(['original_url' => $url]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return str_replace(['=','/'],['','-'],base64_encode($result[0]->url_id));
            
        } else {
            
            $data = ['original_url' => $url, 'created' => date('Y-m-d H:i:s')];
            $this->db->insert($this->table, $data);
            
            if ( $this->db->affected_rows() ) {
                
                return str_replace(['=','/'],['','-'],base64_encode($this->db->insert_id()));
                
            } else {
                
                return false;
                
            }
            
        }
        
    }
    
    /**
     * The public method get_original_url
     *
     * @param integer $id contains the url's id
     * 
     * @return string with original url
     */
    public function get_original_url( $id ) {
        
        $this->db->select('original_url');
        $this->db->from($this->table);
        $this->db->where(['url_id' => $id]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result[0]->original_url;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method update_url_stats counts views
     *
     * @param integer $id contains the url's id
     * 
     * @return void
     */
    public function update_url_stats( $id, $network_name, $color ) {
        
        $ip = $this->input->ip_address();
        $this->db->select('*');
        $this->db->from('urls_stats');
        $this->db->where(['url_id' => $id, 'ip_address' => $ip, 'network_name' => $network_name]);
        $query = $this->db->get();
        
        if ( $query->num_rows() < 1 ) {
            
            // Set data
            $data = ['url_id' => $id, 'network_name' => $network_name, 'color' => $color, 'ip_address' => $ip, 'created' => date('Y-m-d H:i:s')];
            
            // Save data
            $this->db->insert('urls_stats', $data);
            
        }
        
    }
    
    /**
     * The public method get_url_stats gets click statistics by id
     * 
     * @param integer $id contains url's id
     * 
     * @return string with statistics or false
     */
    public function get_url_stats( $id ) {
        
        $this->db->select('network_name,color,COUNT(stats_id) as number', false);
        $this->db->from('urls_stats');
        $this->db->where(['url_id' => $id]);
        $this->db->group_by('network_name');
        $this->db->order_by('network_name');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Create new array
            $new_array = '';
            $colors = '';
            
            foreach ( $result as $data ) {
                
                $new_array .= '{"label": "' . $data->network_name . '", "value": ' . $data->number . '},';
                $colors .= '"' . $data->color . '",';
                
            }
            
            return base64_encode(substr($new_array,0,-1)).','.base64_encode(substr($colors,0,-1));
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file Urls.php */
