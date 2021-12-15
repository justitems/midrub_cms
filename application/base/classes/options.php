<?php
/**
 * Options Class
 *
 * This file loads the Options Class with options used in the base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Options class loads the general options used in the base components
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Options {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method update_option saves a new option
     * 
     * @param string $name contains the option's name
     * @param string $value contains the new option's value
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function update_option($name, $value) {

        if ( empty($name) ) {
            return false;
        }

        $md_the_option = $this->CI->base_model->the_data_where('options', '*', array('option_name' => trim($name)));

        if ( $md_the_option ) {

            if ( $this->CI->base_model->update('options', array('option_name' => trim($name)), array('option_value' => trim($value))) ) {
                return true;
            } else {
                return false;
            }

        } else {

            if ( $this->CI->base_model->insert('options', array('option_name' => trim($name), 'option_value' => trim($value))) ) {
                return true;
            } else {
                return false;
            }

        }

    }

    /**
     * The public method md_the_option returns option by option's name
     * 
     * @param string $name contains the option's name
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function md_the_option($name) {
        
        if ( !empty($this->CI->all_options) ) {
            
            if ( isset($this->CI->all_options[$name]) ) {
                return $this->CI->all_options[$name];
            } else {
                return false;
            }
            
        } else {

            $this->CI->all_options = array_column($this->CI->base_model->the_data_where('options', '*'), 'option_value', 'option_name');

            if ( isset($this->CI->all_options[$name]) ) {
                return $this->CI->all_options[$name];
            } else {
                return false;
            }
        
        }

    }

    /**
     * The public method delete_option deletes an option
     * 
     * @param string $name contains the option's name
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function delete_option($name) {

        if ( empty($name) ) {
            return false;
        }

        if ( $this->CI->base_model->delete('options', array('option_name' => trim($name))) ) {
            return true;
        } else {
            return false;
        }

    }

}

/* End of file options.php */