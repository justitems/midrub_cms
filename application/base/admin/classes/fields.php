<?php
/**
 * Base Admin Fields
 *
 * This file contains the class Fields
 * which processes the Admin's fields
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Fields class processes the Admin's fields
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Fields {
    
    /**
     * The public method get_fields shows the admin's fields
     * 
     * @param array $params contains the parameters
     *
     * @since 0.0.8.5
     * 
     * @return void
     */ 
    public function get_fields( $params ) {

        // Fields container
        echo '<div class="theme-panel">';        
        
        // Verify if the header parameter exists
        if ( !empty($params['header']) ) {

            // Verify if the header has title
            if ( !empty($params['header']['title']) ) {

                echo '<div class="theme-panel-header">'
                    . '<h2>'
                        . $params['header']['title']
                    . '</h2>'
                . '</div>';

            }

        }

        // Verify if the fields parameter exists
        if ( !empty($params['fields']) ) {

            // Verify if fields is array
            if ( is_array($params['fields']) ) {

                echo '<div class="theme-panel-body">'
                    . '<ul class="list-group theme-settings-options">';

                // List all fields
                foreach ( $params['fields'] as $field ) {

                    // Set params
                    $field['field_params'] = isset($field['field_params'])?$field['field_params']:array();

                    // Verify if the field has the expected parameters
                    if ( !empty($field['field_slug']) && !empty($field['field_type']) && !empty($field['field_words']) ) {

                        // Verify if the expected words exists
                        if ( !empty($field['field_words']['field_title']) && !empty($field['field_words']['field_description']) ) {

                            // Verify if the field's directory exists
                            if (is_dir(CMS_BASE_ADMIN . 'fields/collection/' . $field['field_type'] . '/')) {

                                // Verify if the file main exists
                                if ( file_exists(CMS_BASE_ADMIN . 'fields/collection/' . $field['field_type'] . '/main.php') ) {

                                    // Create an array
                                    $array = array(
                                        'CmsBase',
                                        'Admin',
                                        'Fields',
                                        'Collection',
                                        ucfirst($field['field_type']),
                                        'Main'
                                    );

                                    // Implode the array above
                                    $cl = implode('\\', $array);

                                    // Get the field
                                    echo (new $cl())->the_field($field);

                                }

                            }

                        }

                    }

                }

                echo '</ul>'
            . '</div>';

            }
            
        }

        // Display the fields area
        echo '</div>';
        
    }
    
}

/* End of file fields.php */