<?php
/**
 * Base Invoices Model
 *
 * PHP Version 7.3
 *
 * Base_invoices file contains the Base Invoices Model
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
 * Base Invoices class - operates the base_invoices table.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base_invoices extends CI_MODEL {

  /**
   * Class variables
   */
  private $table = 'invoices_options';

  public function __construct() {
      
      // Call the Model constructor
      parent::__construct();
      
      // Get the table invoices_options
      $invoices_options = $this->db->table_exists('invoices_options');
      
      // Verify if the table invoices_options exists
      if ( !$invoices_options ) {
          
          $this->db->query('CREATE TABLE IF NOT EXISTS `invoices_options` (
                            `option_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                            `option_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                            `option_value` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                            `template_slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
          
      }

      // Get the table invoices_templates
      $invoices_templates = $this->db->table_exists('invoices_templates');
      
      // Verify if the table invoices_templates exists
      if ( !$invoices_templates ) {
          
          $this->db->query('CREATE TABLE IF NOT EXISTS `invoices_templates` (
                            `template_id` bigint(20) AUTO_INCREMENT PRIMARY KEY,
                            `template_title` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                            `template_body` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                            `template_slug` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
                          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;');
          
      }
      
      // Set table
      $this->tables = $this->config->item('tables', $this->table);

  }

  /**
   * The function save_invoices_option saves invoices option
   *
   * @param string $option_name has the option's identifier
   * @param string $option_value has the option's value
   * @param string $template_slug has the template's slug
   * 
   * @return boolean true or false
   */
  public function save_invoices_option($option_name, $option_value, $template_slug) {
        
    // Prepare data to insert
    $data = array(
      'option_name' => $option_name,
      'option_value' => $option_value,
      'template_slug' => $template_slug
    );
    
    // Insert data
    $this->db->insert('invoices_options', $data);
    
    // Verify if data was updated, inserted or deleted
    if ( $this->db->affected_rows() ) {
        
      return true;
        
    } else {
        
      return false;
        
    }
    
  }

  /**
   * The function get_invoices_option gets invoices option
   *
   * @param string $option_name has the option's identifier
   * @param string $template_slug has the template's slug
   * 
   * @return string with option's value or boolean false
   */
  public function get_invoices_option($option_name, $template_slug) {
    
    $this->db->select('option_value');
    $this->db->from('invoices_options');
    $this->db->where(
      array(
        'option_name' => $option_name,
        'template_slug' => $template_slug
      )
    );

    $query = $this->db->get();
    
    // Verify if data exists
    if ( $query->num_rows() > 0 ) {

      // Get data
      $option = $query->result_array();
        
      // Return value
      return $option[0]['option_value'];
        
    } else {
        
      return false;
        
    }

  }

  /**
   * The function update_invoices_template saves/updates template's title and body
   *
   * @param string $template_title has the template's title
   * @param string $template_body has the template's body
   * @param string $template_slug has the template's slug
   * 
   * @return boolean true or false
   */
  public function update_invoices_template($template_title, $template_body, $template_slug) {
    
    // Get option by name
    $this->db->select('template_id');
    $this->db->from('invoices_templates');
    $this->db->where('template_slug', $template_slug);       
    $query = $this->db->get();
    
    // Verify if data exists
    if ( $query->num_rows() == 1 ) {

      // Verify if $template_title is not empty
      if ( $template_title ) {
          
        // Set new data
        $data = array(
          'template_title' => $template_title,
          'template_body' => $template_body
        );

        // Set where condition
        $this->db->where(array(
          'template_slug', $template_slug
        ));

        // Update
        $this->db->update('invoices_templates', $data);
          
      } else {
        
        // Set where condition
        $this->db->where(
          'template_slug', $template_slug
        );

        // Delete
        $this->db->delete('invoices_templates');
          
      }
      
    } else {
        
      // Prepare data to insert
      $data = array(
        'template_title' => $template_title,
        'template_body' => $template_body,
        'template_slug' => $template_slug
      );
      
      // Insert data
      $this->db->insert('invoices_templates', $data);
        
    }
    
    // Verify if data was updated, inserted or deleted
    if ( $this->db->affected_rows() ) {
        
      return true;
        
    } else {
        
      return false;
        
    }
    
  }

  /**
   * The function get_template_field gets template's field by template's slug
   *
   * @param string $template_field has the template's field
   * @param string $template_slug has the template's slug
   * 
   * @return string with field's value or boolean false
   */
  public function get_template_field($template_field, $template_slug) {
    
    $this->db->select($template_field);
    $this->db->from('invoices_templates');
    $this->db->where(
      array(
        'template_slug' => $template_slug
      )
    );
           
    $query = $this->db->get();
    
    // Verify if data exists
    if ( $query->num_rows() > 0 ) {

      // Get data
      $template = $query->result_array();
        
      // Return value
      return $template[0][$template_field];
        
    } else {
        
      return false;
        
    }

  }

}

/* End of file base_invoices.php */