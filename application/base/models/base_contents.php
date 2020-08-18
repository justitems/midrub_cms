<?php
/**
 * Base Contents Model
 *
 * PHP Version 7.2
 *
 * Base_contents file contains the Base Contents Model
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
 * Base_contents class - operates the contents table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_contents extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'contents';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        $contents = $this->db->table_exists('contents');
        
        if ( !$contents ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `contents` (
                              `content_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `contents_category` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `contents_component` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `contents_theme` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `contents_template` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `contents_slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `status` 	tinyint(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $contents_meta = $this->db->table_exists('contents_meta');
        
        if ( !$contents_meta ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `contents_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `content_id` bigint(20) NOT NULL,
                              `meta_slug` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `meta_extra` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);

        $contents_classifications = $this->db->table_exists('contents_classifications');

        if ( !$contents_classifications ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `contents_classifications` (
                              `classification_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `content_id` bigint(20) NOT NULL,
                              `classification_slug` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `classification_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }
    
    /**
     * The public method save_content saves a new content
     * 
     * @param integer $user_id contains the user's id
     * @param string $contents_category contains the content's category
     * @param string $contents_theme contains the theme slug
     * @param string $contents_template contains the theme's template slug
     * @param string $contents_component contains the content's component
     * @param integer $status contains the content's status
     * 
     * @return integer with inserted id or false
     */
    public function save_content( $user_id, $contents_category, $contents_component, $contents_theme=NULL, $contents_template=NULL,  $status ) {
        
        // Set data
        $data = array(
            'user_id' => $user_id,
            'contents_category' => $contents_category,
            'status' => $status,
            'created' => time()
        );

        // Verify if component exists
        if ( $contents_component ) {
            $data['contents_component'] = $contents_component;
        }

        // Verify if contents theme exists
        if ( $contents_theme ) {
            $data['contents_theme'] = $contents_theme;
        }

        // Verify if contents template exists
        if ( $contents_template ) {
            $data['contents_template'] = $contents_template;
        }
        
        // Insert post
        $this->db->insert($this->table, $data);
        
        // Verify if post was saved
        if ( $this->db->affected_rows() ) {
            
            $last_id = $this->db->insert_id();
            
            // Return last inserted id
            return $last_id;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method save_content_meta saves the content's meta
     * 
     * @param integer $content_id contains the content's id
     * @param string $meta_slug contains the meta's slug
     * @param string $meta_name contains the meta's name
     * @param string $meta_value contains the meta's value
     * @param string $meta_extra contains the meta's extra
     * @param string $language contains the article's language
     * 
     * @return boolean true or false
     */
    public function save_content_meta( $content_id, $meta_slug=NULL, $meta_name=NULL, $meta_value=NULL, $meta_extra=NULL, $language=NULL ) {

        // Verify if required variables aren't null
        if ( ( $meta_name !== "" ) && ( $meta_value !== "" ) ) {

            // Verify if content_id exists
            $this->db->select('*');
            $this->db->from($this->table);
            $this->db->where('content_id', $content_id);
            $query = $this->db->get();
            
            // If content exists
            if ( $query->num_rows() > 0 ) {

                // Verify if meta_name already exists
                $this->db->select('meta_id');
                $this->db->from('contents_meta');
                $this->db->where(array(
                    'content_id' => $content_id,
                    'meta_name' => $meta_name,
                    'language' => $language
                ));

                $query = $this->db->get();

                // If content exists
                if ($query->num_rows() > 0) {

                    // Get results
                    $results = $query->result();

                    // Prepare data
                    $params = array(
                        'content_id' => $content_id,
                        'meta_value' => $meta_value
                    );

                    // Verify id meta's extra exists
                    if ( $meta_extra ) {
                        $params['meta_extra'] = $meta_extra;
                    }

                    // Update content's meta
                    $this->db->where(array(
                        'meta_id' => $results[0]->meta_id
                    ));

                    $this->db->update('contents_meta', $params);

                    // Verify if the content's meta was updated
                    if ( $this->db->affected_rows() ) {

                        return true;

                    }

                } else {

                    // Set data
                    $data = array(
                        'content_id' => $content_id,
                        'meta_name' => $meta_name,
                        'meta_value' => $meta_value,
                        'language' => $language
                    );

                    // Verify id meta's slug exists
                    if ( $meta_slug ) {
                        $data['meta_slug'] = $meta_slug;
                    }                    

                    // Verify id meta's extra exists
                    if ( $meta_extra ) {
                        $data['meta_extra'] = $meta_extra;
                    }

                    // Save content's meta
                    $this->db->insert('contents_meta', $data);

                    // Verify if the content's meta was saved
                    if ( $this->db->affected_rows() ) {

                        return true;

                    }

                }
                

            }


        }

        return false;
        
    }

    /**
     * The public method get_contents gets contents
     * 
     * @param array $args contains the arguments to request
     * 
     * @return object with contents or false
     */
    public function get_contents($args) {
        
        // Set language
        $language = $this->config->item('language');

        $where = array(
            'contents_meta.language' => $language,
            'contents_meta.meta_name' => 'content_title'      
        );

        // If $args has contents_category
        if ( isset($args['contents_category'] ) ) {
            $where['contents.contents_category'] = $args['contents_category'];
        }

        // If $args has classification_value
        if ( isset($args['classification_value'] ) ) {

            $where['contents_classifications.classification_value'] = $args['classification_value'];

            $this->db->select('contents_classifications.classification_slug as classification_slug, classifications_meta.meta_slug AS classification_meta_slug');

        }
        
        $this->db->select('contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status, users.user_id, users.first_name, users.last_name, users.username');
        $this->db->from($this->table);

        // If $args has classification_slug
        if ( isset($args['classification_value'] ) ) {
            $this->db->join('contents_classifications', 'contents.content_id=contents_classifications.content_id', 'left');
            $this->db->join('classifications_meta', 'contents_classifications.classification_value=classifications_meta.classification_id', 'left');
        }         

        $this->db->join('users', 'users.user_id=contents.user_id', 'left');
        $this->db->join('contents_meta', 'contents.content_id=contents_meta.content_id', 'left');
        $this->db->where($where);

        // If contents category is null
        if ( !empty($args['contents_category']) ) {
            
            $categories = array();
            $contents_categories = md_the_contents_categories();
            
            if ( $contents_categories ) {
                foreach ( $contents_categories as $contents_category ) {
                    $category_slug = array_keys($contents_category);
                    $categories[] = $category_slug[0];
                }
            }

            if ( $categories ) {
                $this->db->where_in('contents_category', $categories);
            }

        }

        // Verify if search key exists
        if ( !empty($args['key']) ) {

            $keys = explode('-', $this->db->escape_like_str($args['key']));

            if ( count($keys) > 0 ) {

                $string = '';

                foreach ( $keys as $key ) {

                    if ( !$string ) {
                        $this->db->like('contents_meta.meta_value', $key);
                    } else {
                        $this->db->or_like('contents_meta.meta_value', $key);
                    }

                }

            }

        }

        $this->db->group_by('contents.content_id');

        // Verify if search key exists
        if ( !empty($args['key']) ) {

            $keys = explode('-', $this->db->escape_like_str($args['key']));

            $string = '';

            foreach ( $keys as $key ) {

                if ( !$string ) {
                    $string .= "IF(contents_meta.meta_value REGEXP '$key', 0, 1) ASC";
                } else {
                    $string .= ", IF(contents_meta.meta_value REGEXP '$key', 0, 1) ASC";
                }

            }

            $this->db->order_by($string);

        } else {

            $this->db->order_by('contents.content_id', 'DESC');

        }
        
        // Verify if pagination exists
        if ( isset($args['limit']) && isset($args['start']) ) {
            
            $this->db->limit($args['limit'], $args['start']);
            
        }
        
        $query = $this->db->get();
        
        // If $args has limit
        if ( !isset($args['limit']) ) {
            
            return $query->num_rows();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_content gets content by content's id
     * 
     * @param integer $content_id contains the content's ID
     * @param string $contents_slug contains the content's slug
     * @param bool $lang contains language option
     * 
     * @return object with content or false
     */
    public function get_content($content_id=NULL, $contents_slug=NULL, $lang=TRUE) {
        
        // Set language
        $language = $this->config->item('language');
        
        // Set where variables
        $where = array();

        // Verify if content_id is positive
        if ( $content_id ) {
            $where['contents.content_id'] = $content_id;
        } elseif ($contents_slug) {
            $where['contents.contents_slug'] = $contents_slug;
        }

        // Verify if content should be displayed by language
        if ( !$lang ) {
            $where['contents_meta.language'] = $language;
        }
        
        $this->db->select('contents_meta.*, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents.contents_slug, contents.status, users.user_id, users.first_name, users.last_name, users.username');
        $this->db->from('contents_meta');
        $this->db->join('contents', 'contents.content_id=contents_meta.content_id', 'left');   
        $this->db->join('users', 'users.user_id=contents.user_id', 'left');
        $this->db->where($where);
        $this->db->group_by('contents_meta.meta_id');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_contents_by_meta_name gets contents by meta
     * 
     * @param string $meta_name contains the meta's name
     * @param string $meta_value contains the meta's value
     * 
     * @return object with contents or false
     */
    public function get_contents_by_meta_name($meta_name, $meta_value=NULL) {
        
        // Set where variables
        $where = array(
            'meta.meta_name' => $meta_name,
            'content.meta_name' => 'content_title',
            'content.language' => $this->config->item('language')
        );

        // Verify if $meta_value exists
        if ( $meta_value ) {
            $where['meta.meta_value'] = $meta_value;
        }      
        
        $this->db->select('meta.*, content.meta_value as title, contents.contents_category, contents.contents_component, contents.contents_theme, contents.contents_template, contents_slug, contents.status, users.user_id, users.first_name, users.last_name, users.username');
        $this->db->from($this->table);
        $this->db->join('users', 'users.user_id=contents.user_id', 'left');
        $this->db->join('contents_meta meta', 'contents.content_id=meta.content_id', 'left');
        $this->db->join('contents_meta content', 'contents.content_id=content.content_id', 'left');
        $this->db->where($where);
        $this->db->order_by('contents.content_id', 'desc');
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {

            return $query->result_array();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The function delete_content deletes a content
     *
     * @param integer $content_id contains the content's id
     * 
     * @return boolean true or false
     */
    public function delete_content( $content_id ) {

        $this->db->delete(
            $this->table,
            array(
                'content_id' => $content_id
            )
        );
        
        if ( $this->db->affected_rows() ) {

            $this->db->delete(
                'contents_meta',
                array(
                    'content_id' => $content_id
                )
            );
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The function delete_content_meta deletes content's meta
     *
     * @param integer $content_id contains the content's id
     * @param string $meta_name contains the meta's name
     * 
     * @return boolean true or false
     */
    public function delete_content_meta( $content_id=0, $meta_name ) {

        $args = array(
            'meta_name' => $meta_name
        );

        if ( $content_id ) {
            $args['content_id'] = $content_id;
        }

        $this->db->delete(
            'contents_meta',
            $args
        );
        
        if ( $this->db->affected_rows() ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }
    
}

/* End of file base_contents.php */