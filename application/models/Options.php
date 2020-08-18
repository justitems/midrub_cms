<?php
/**
 * Options Model
 *
 * PHP Version 5.6
 *
 * Options file contains the Options Model
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
 * Options class - operates the options table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Options extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'options';

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
     * The public method check_enabled checks if an option is enabled
     *
     * @param string $key may contains option_key
     * 
     * @return boolean true or false
     */
    public function check_enabled($key) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['option_key' => $key, 'option_value' => '1']);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() == 1 ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method enable_or_disable_network enables and disables a social network for users. First call, enables social network, second call disable. Also this function allows to enable or disable an option.
     *
     * @param string $network contains the network's name
     * @param integer $update contains a number when the update_code must be deleted
     * 
     * @return boolean true if option was enabled/disabled or false 
     */
    public function enable_or_disable_network( $network, $update = NULL ) {
        
        // Verify if option exists
    	$this->db->select('*');
    	$this->db->from($this->table);
    	$this->db->where(['option_key' => $network, 'option_value' => '1']);
    	$this->db->limit(1);
    	$query = $this->db->get();
        
    	if ( $query->num_rows() == 1 ) {
            
            // If the network is enabled, will be deleted
            $this->db->where(['option_key' => $network, 'option_value' => '1']);
            $this->db->delete($this->table);
                
    	} else {
            
            // If the network not exists, will be added with value 1
            $data = ['option_key' => $network, 'option_value' => '1'];
            $this->db->insert($this->table, $data);
                
    	}
        
    	// Check if option was saved or deleted successfully
    	if ( $this->db->affected_rows() ) {
            
            if ( $update ) {
                
                $this->db->where(['option_key' => 'update_code']);
                $this->db->delete($this->table);
                    
            }
            
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }
    
    /**
     * The public method add_option_value adds value to an option.
     *
     * @param string $key contains the option's key
     * @param string $value contains the new option's value
     * 
     * @return boolean true if value was added successfully or false
     */
    public function add_option_value( $key, $value ) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(array('option_key' => $key));
        
        $query = $this->db->get();
        
        $value = rawurldecode(str_replace('empty-option', '', $value));
        
        if ( $query->num_rows() > 0 ) {
            
            $this->db->set(array(
                    'option_key'=>$key,
                    'option_value'=>trim($value)
                )
                    
            );
            
            $this->db->where(array(
                    'option_key' => $key
                )
            );
            
            $this->db->update($this->table);
            
            // Verify if the option was updated
            if ( $this->db->affected_rows() ) {

                return true;

            } else {

                return false;

            }
            
        } else {
            
            // If the option not exists, will be added
            $data = array(
                'option_key' => $key,
                'option_value' => trim($value)
            );
            
            $this->db->insert($this->table, $data);
            
            // Verify if the option was created
            if ( $this->db->affected_rows() ) {

                return true;

            } else {

                return false;

            }
            
        }
        
        return false;
        
    }
    
    /**
     * The public method get_all_options gets all options
     * 
     * @return array with all options or false
     */
    public function get_all_options() {
        
        $this->db->select('option_key,option_value');
        $this->db->from($this->table);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // Create new array
            $new_array = [];
            $result = $query->result();
            foreach ($result as $data) {
                $new_array[$data->option_key] = $data->option_value;
            }
            return $new_array;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method get_all_options gets all options
     *
     * @param string $name contains the option's name
     * 
     * @return string with option value or false
     */
    public function get_an_option( $name ) {
        
        $this->db->select('option_value');
        $this->db->from($this->table);
        $this->db->where(['option_key' => $name]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            
            // Returns option_value
            return $result[0]->option_value;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method set_media_option changes logo for login page and the main logo. Also this function changes favicon and login background.
     *
     * @param string $name contains the option's name
     * @param string $url contains the media url
     * 
     * @return boolean true or false
     */
    public function set_media_option($name, $url) {
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where(['option_key' => $name]);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            // If the media url are saved already, will be updated.
            $data = ['option_value' => $url];
            $this->db->where(['option_key' => $name]);
            $this->db->update($this->table, $data);
            
        } else {
            
            // If the network not exists, will be added with value 1
            $data = ['option_key' => $name, 'option_value' => trim($url)];
            $this->db->insert($this->table, $data);
            
        }
        
        // Check if option was saved or deleted successfully
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
    /**
     * The public method delete_option deletes an option
     *
     * @param string $name contains the option's name
     * 
     * @return string with option value or false
     */
    public function delete_option( $name ) {
        
        $this->db->where(['option_key' => $name]);
        $this->db->delete($this->table);
        
    	// Check if option was saved or deleted successfully
    	if ( $this->db->affected_rows() ) {
            
            return true;
            
    	} else {
            
            return false;
            
    	}
        
    }    
    
}

/* End of file Options.php */
