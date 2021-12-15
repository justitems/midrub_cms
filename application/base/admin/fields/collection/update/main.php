<?php
/**
 * Base Admin Update
 *
 * This file loads the Base Admin field
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Fields\Collection\Update;

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Admin\Interfaces as CmsBaseAdminInterfaces;

/*
 * Main class loads the Base Admin field loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Main implements CmsBaseAdminInterfaces\Fields {
    
    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method the_field gets the admin's field
     * 
     * @param array $field contains the field's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with the field
     */
    public function the_field($field) {
        
        // Footer container
        $footer = '';

        // Verify if update form exists
        if ( !empty($field['field_params']['update_form']) ) {

            // Update code container
            $update_code = '';

            // Update button code container
            $update_button_code = '';            

            // Verify if update code is required
            if ( !empty($field['field_params']['update_code']) ) {
                
                // Set update input
                $update_code = '<input type="text" class="form-control rounded-end theme-text-input-1 updates-code-input" placeholder="' . $this->CI->lang->line('admin_enter_update_code') . '" required />';
                
                // Verify if update button code is required
                if ( !empty($field['field_params']['update_button_code']) ) {

                    // Set update button code
                    $update_button_code = '<button type="button" class="btn btn-primary rounded-start rounded-end theme-button-1 ms-3 mt-0 updates-generate-new-update-code" data-url="' . $field['field_params']['update_button_code'] . '">'
                        . $this->CI->lang->line('admin_new_code')
                    . '</button>';

                }

            }

            $update_button_left = $update_code?' ms-3':'';

            // Set form
            $footer = '<div class="card-footer">'
                . '<div class="row">'
                    . '<div class="col-lg-12">'
                        . form_open('admin/update', array('class' => 'update-midrub' ) )
                            . '<div class="form-group">'
                                . '<div class="input-group">'
                                    . $update_code
                                    . $update_button_code
                                    . '<button type="submit" class="btn btn-primary rounded-start theme-button-1' . $update_button_left . ' mt-0">'
                                        . $this->CI->lang->line('admin_update')
                                    . '</button>'
                                . '</div>'
                            . '</div>'
                        . form_close()
                    . '</div>'
                . '</div>'
            . '</div>';

        }

        // Return the field
        return '<li class="list-group-item" data-field="' . $field['field_slug'] . '">'
            . '<div class="card w-100 theme-card-box admin-update-field">'
                . '<div class="card-header">'
                    . '<button class="btn btn-link pt-0 pb-0 h-auto">'
                        . $field['field_words']['field_title']
                    . '</button>'
                . '</div>'
                . '<div class="card-body">'
                    . $field['field_words']['field_description']
                . '</div>'
                . $footer
            . '</div>'
        . '</li>';
        
    }

}

/* End of file main.php */