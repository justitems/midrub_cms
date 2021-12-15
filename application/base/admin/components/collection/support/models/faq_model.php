<?php
/**
 * Faq Model
 *
 * PHP Version 7.2
 *
 * Faq_model file contains the Faq Model
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
 * Faq_model class - operates the faq table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Faq_model extends CI_MODEL {
    
    /**
     * Class variables
     */
    private $table = 'faq_articles';

    /**
     * Initialise the model
     */
    public function __construct() {
        
        // Call the Model constructor
        parent::__construct();
        
        $faq_articles = $this->db->table_exists('faq_articles');
        
        if ( !$faq_articles ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `faq_articles` (
                              `article_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `user_id` bigint(20) NOT NULL,
                              `status` 	tinyint(1) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $faq_articles_meta = $this->db->table_exists('faq_articles_meta');
        
        if ( !$faq_articles_meta ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `faq_articles_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `article_id` bigint(20) NOT NULL,
                              `title` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $faq_articles_categories = $this->db->table_exists('faq_articles_categories');
        
        if ( !$faq_articles_categories ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `faq_articles_categories` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                              `article_id` bigint(20) NOT NULL,
                              `category_id` int(6) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }        
        
        $faq_categories = $this->db->table_exists('faq_categories');
        
        if ( !$faq_categories ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `faq_categories` (
                              `category_id` int(6) AUTO_INCREMENT PRIMARY KEY,
                              `parent` int(6) NOT NULL,
                              `created` varchar(30) NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }
        
        $faq_categories_meta = $this->db->table_exists('faq_categories_meta');
        
        if ( !$faq_categories_meta ) {
            
            $this->db->query('CREATE TABLE IF NOT EXISTS `faq_categories_meta` (
                              `meta_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,                
                              `category_id` int(6) NOT NULL,
                              `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                              `language` varchar(30) COLLATE utf8_unicode_ci NOT NULL
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
            
        }        
        
        // Set the tables value
        $this->tables = $this->config->item('tables', $this->table);
        
    }

    /**
     * The public method save_article saves a new faq's article
     * 
     * @param integer $user_id contains the user's id
     * @param integer $status contains the article's status
     * 
     * @return integer with inserted id or false
     */
    public function save_article( $user_id, $status ) {
        
        // Set data
        $data = array(
            'user_id' => $user_id,
            'status' => $status,
            'created' => time()
        );
        
        // Insert post
        $this->db->insert('faq_articles', $data);
        
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
     * The public method save_article_meta saves the article's meta
     * 
     * @param integer $article_id contains the article's id
     * @param string $title contains the article's title
     * @param string $body contains the article's body
     * @param string $language contains the article's language
     * 
     * @return integer with inserted id or false
     */
    public function save_article_meta( $article_id, $title, $body, $language ) {
        
        // Set data
        $data = array(
            'article_id' => $article_id,
            'title' => $title,
            'body' => $body,
            'language' => $language
        );
        
        // Insert post
        $this->db->insert('faq_articles_meta', $data);
        
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
     * The public method save_article_category saves the article's category
     * 
     * @param integer $article_id contains the article's id
     * @param integer $category_id contains the category's id
     * 
     * @return integer with inserted id or false
     */
    public function save_article_category( $article_id, $category_id ) {
        
        // Set data
        $data = array(
            'article_id' => $article_id,
            'category_id' => $category_id
        );
        
        // Insert post
        $this->db->insert('faq_articles_categories', $data);
        
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
     * The public method save_category saves categories
     * 
     * @param integer $parent contains the category's parent
     * 
     * @return integer with inserted id or false
     */
    public function save_category( $parent = 0  ) {
        
        // Set data
        $data = array(
            'parent' => $parent,
            'created' => time()
        );
        
        // Insert post
        $this->db->insert('faq_categories', $data);
        
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
     * The public method save_category_meta saves category meta
     * 
     * @param integer $category_id contains the category's id
     * @param string $name contains the category's name
     * @param string $language contains the language
     * 
     * @return integer with inserted id or false
     */
    public function save_category_meta( $category_id, $name, $language ) {
        
        // Set data
        $data = array(
            'category_id' => $category_id,
            'name' => $name,
            'language' => $language
        );
        
        // Insert post
        $this->db->insert('faq_categories_meta', $data);
        
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
     * The public method get_faq_articles gets faq articles
     * 
     * @param string $key contains the search's key
     * @param integer $start contains the start of displays posts
     * @param integer $limit displays the limit of displayed posts
     * 
     * @return object with articles or false
     */
    public function get_faq_articles($key = NULL, $start = NULL , $limit = NULL) {
        
        $language = $this->config->item('language');
        
        $where = array(
            'faq_articles_meta.language' => $language
        );
        
        $this->db->select('faq_articles.article_id, faq_articles.user_id, users.username, faq_articles.status, faq_articles_meta.title');
        $this->db->from($this->table);
        $this->db->join('users', 'users.user_id=faq_articles.user_id', 'left');
        $this->db->join('faq_articles_meta', 'faq_articles.article_id=faq_articles_meta.article_id', 'left');
        $this->db->where($where);

        if ( $key ) {

            $key = $this->db->escape_like_str($key);
            $this->db->like('faq_articles_meta.title', $key);

        }

        $this->db->group_by('faq_articles.article_id');
        $this->db->order_by('faq_articles.article_id', 'desc');
        
        if ( $limit ) {
            
            $this->db->limit($limit, $start);
            
        }
        
        $query = $this->db->get();
        
        // If $limit is null will return number of rows
        if ( !$limit ) {
            
            return $query->num_rows();
            
        }
        
        if ( $query->num_rows() > 0 ) {
            
            return $query->result();
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_faq_article gets faq article
     * 
     * @param string $article_id contains the article's id
     * 
     * @return object with articles or false
     */
    public function get_faq_article($article_id) {
        
        $where = array(
            'article_id' => $article_id
        );
        
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($where);
        $query = $this->db->get();
        
        if ( $query->num_rows() > 0 ) {
            
            $content = array(
                'article' => $query->result(),
                'data' => array(),
                'categories' => array()
            );

            $this->db->select('*');
            $this->db->from('faq_articles_meta');
            $this->db->where($where);
            $query = $this->db->get();

            if ( $query->num_rows() > 0 ) {
                
                $datas = $query->result();
                
                foreach ( $datas as $dat ) {
                    
                    $content['data'][$dat->language] = array(
                        'meta_id' => $dat->meta_id,
                        'title' => $dat->title,
                        'body' => $dat->body
                    );
                    
                }

            }
            
            $this->db->select('faq_categories_meta.language, faq_categories_meta.name, faq_categories_meta.category_id');
            $this->db->from('faq_articles_categories');
            $this->db->join('faq_categories_meta', 'faq_articles_categories.category_id=faq_categories_meta.category_id', 'left');
            $this->db->where($where);
            $query = $this->db->get();

            if ( $query->num_rows() > 0 ) {
                
                $datas = $query->result();
                
                foreach ( $datas as $dat ) {
                    
                    $content['categories'][] = $dat->category_id;
                    
                }

            }            
            
            return $content;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method get_categories gets all Faq's categories
     * 
     * @return object with categories or false
     */
    public function get_categories() {
        
        $language = $this->config->item('language');
        
        $this->db->select('faq_categories.category_id,faq_categories.parent,faq_categories_meta.name');
        $this->db->from('faq_categories');
        $this->db->join('faq_categories_meta', 'faq_categories.category_id=faq_categories_meta.category_id', 'left');
        $this->db->where(array('language' => $language));
        $query = $this->db->get();
        if ( $query->num_rows() > 0 ) {
            
            $result = $query->result();
            return $result;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_category deletes Faq's categories
     * 
     * @param integer $category_id contains the category's id
     * 
     * @return boolean true or false
     */
    public function delete_category($category_id) {
        
        // Delete the category
        $this->db->delete('faq_categories', array(
                'category_id' => $category_id
            )
        );
        
        if ( $this->db->affected_rows() ) {
            
            // Delete the category
            $this->db->delete('faq_categories', array(
                    'parent' => $category_id
                )
            );
            
            // Delete the category's meta
            $this->db->delete('faq_categories_meta', array(
                    'category_id' => $category_id
                )
            );
            
            // Delete the article's category
            $this->db->delete('faq_articles_categories', array(
                    'category_id' => $category_id
                )
            );
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_article deletes Faq's articles
     * 
     * @param integer $article_id contains the article's id
     * 
     * @return boolean true or false
     */
    public function delete_article($article_id) {
        
        // Delete the article
        $this->db->delete('faq_articles', array(
                'article_id' => $article_id
            )
        );
        
        if ( $this->db->affected_rows() ) {
            
            // Delete the article's categories
            $this->db->delete('faq_articles_categories', array(
                    'article_id' => $article_id
                )
            );
            
            // Delete the article's meta
            $this->db->delete('faq_articles_meta', array(
                    'article_id' => $article_id
                )
            );
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method delete_article_meta deletes Faq's article metas before updating it
     * 
     * @param integer $article_id contains the article's id
     * 
     * @return boolean true or false
     */
    public function delete_article_meta($article_id) {
        
        // Delete the article's meta
        $this->db->delete('faq_articles_meta', array(
                'article_id' => $article_id
            )
        );
        
        if ( $this->db->affected_rows() ) {
            
            // Delete the article's categories
            $this->db->delete('faq_articles_categories', array(
                    'article_id' => $article_id
                )
            );
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    } 
    
}

/* End of file faq_model.php */