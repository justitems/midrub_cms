<?php
/**
 * Base Classifications Model
 *
 * PHP Version 7.2
 *
 * Base_classifications file contains the Base Classifications Model
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
 * Base_classifications class - is the main Base Classifications model 
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_classifications extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'classifications';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();

        $classifications = $this->db->table_exists('classifications');
        
        if ( !$classifications ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `classifications` (
                              `classification_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `type` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `parent` bigint(20) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }

        $classifications_meta = $this->db->table_exists('classifications_meta');
        
        if ( !$classifications_meta ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `classifications_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `classification_id` bigint(20) NOT NULL,
                              `meta_slug` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

    /**
     * The public method get_menu_items gets menu's items
     * 
     * @param array $args contains the query arguments
     * 
     * @return object with items or boolean false
     */
    public function get_menu_items($args) {
        
        // Set language
        $language = $this->config->item('language');

        // Set where variables
        $where = array(
            'classifications_meta.meta_name' => 'name'
        );

        // Verify if menu slug's exists
        if ( isset($args['slug']) ) {
            $where['classifications.slug'] = $args['slug'];
        }

        if ( isset($args['fields']) ) {

            // List all fields
            for ($f = 0; $f < count($args['fields']); $f++) {

                // Letters
                $letters = range('a', 'z');

                // Add where parameter
                $where[$letters[$f] . '.meta_name'] = $args['fields'][$f];

                // Verify if items should be displayed by language
                if ( !empty($args['language']) ) {
                    $where[$letters[$f] . '.language'] = $language;
                }

                // Select meta fields
                $this->db->select($letters[$f] . '.meta_value AS ' . $args['fields'][$f]);
                
            }

        }

        if (!empty($args['language'])) {
            $where['classifications_meta.language'] = $language;
        }        
        
        $this->db->select('classifications_meta.*, classifications.parent');
        $this->db->from($this->table);
        $this->db->join('classifications_meta', 'classifications.classification_id=classifications_meta.classification_id', 'left');

        if ( isset($args['fields']) ) {

            // List all fields
            for ($e = 0; $e < count($args['fields']); $e++) {

                // Letters
                $letters = range('a', 'z');

                // Join table
                $this->db->join('classifications_meta ' . $letters[$e], 'classifications.classification_id=' . $letters[$e] . '.classification_id', 'left');
            }

        }
        
        $this->db->where($where);
        $this->db->group_by('classifications.classification_id');
        $this->db->order_by('classifications.classification_id', 'asc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {

            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_classifications_by_slug gets classifications by slug
     * 
     * @param array $args contains the query arguments
     * 
     * @return object with items or boolean false
     */
    public function get_classifications_by_slug($args) {
        
        // Set language
        $language = $this->config->item('language');
        
        // Set where variables
        $where = array(
            'classifications_meta.meta_name' => 'name'
        );

        if ( isset($args['slug']) ) {
            $where['classifications.slug'] = $args['slug'];
        }

        if ( isset($args['type']) ) {
            $where['classifications.type'] = $args['type'];
        }

        if ( empty($args['subclassifications']) && !isset($args['item_id']) && !isset($args['content_id']) ) {
            $where['classifications.parent'] = '0';
        }
        
        if ( isset($args['item_id']) ) {
            $where['classifications.parent'] = $args['item_id'];
        }

        if ( isset($args['content_id']) ) {
            $where['contents_classifications.content_id'] = $args['content_id'];
        }

        if ( isset($args['fields']) ) {

            // List all fields
            for ($f = 0; $f < count($args['fields']); $f++) {

                // Letters
                $letters = range('a', 'z');

                // Add where parameter
                $where[$letters[$f] . '.meta_name'] = $args['fields'][$f];

                // Verify if items should be displayed by language
                if ( !empty($args['language']) ) {
                    $where[$letters[$f] . '.language'] = $language;
                }

                // Select meta fields
                $this->db->select($letters[$f] . '.meta_value AS ' . $args['fields'][$f]);

            }

        }

        if (!empty($args['language'])) {
            $where['classifications_meta.language'] = $language;
        }
        
        $this->db->select('classifications.classification_id, classifications_meta.meta_slug AS item_slug, classifications_meta.meta_value AS name, classifications.parent');

        if ( isset($args['content_id']) ) {
            $this->db->from('contents_classifications');
            $this->db->join('classifications', 'contents_classifications.classification_value=classifications.classification_id', 'left');
            $this->db->join('classifications_meta', 'classifications.classification_id=classifications_meta.classification_id', 'left');
        } else {
            $this->db->from($this->table);
            $this->db->join('classifications_meta', 'classifications.classification_id=classifications_meta.classification_id', 'left');
        }

        if ( isset($args['fields']) ) {

            // List all fields
            for ($e = 0; $e < count($args['fields']); $e++) {

                // Letters
                $letters = range('a', 'z');

                // Join table
                $this->db->join('classifications_meta ' . $letters[$e], 'classifications.classification_id=' . $letters[$e] . '.classification_id', 'left');
            }

        }
        
        $this->db->where($where);
        $this->db->group_by('classifications.classification_id');
        $this->db->order_by('classifications.classification_id', 'asc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_classifications_item_by_slug gets classifications item by slug
     * 
     * @param array $args contains the arguments
     * 
     * @return array with item's data or boolean false
     */
    public function get_classifications_item_by_slug($args) {
        
        // Set where array
        $where = array();

        if ( isset($args['slug']) ) {
            $where['classifications_meta.meta_slug'] = $args['slug'];
        }        

        if ( isset($args['type']) ) {
            $where['classifications.type'] = $args['type'];
        }
        
        $this->db->select('classifications.classification_id');
        $this->db->from($this->table);
        $this->db->join('classifications_meta', 'classifications.classification_id=classifications_meta.classification_id', 'left');
        $this->db->where($where);
        $this->db->limit(1);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file base_classifications.php */