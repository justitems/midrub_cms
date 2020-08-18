<?php
/**
 * Permissions_templates Class
 *
 * This file loads the Permissions_templates Class with methods to generates permissions templates
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Classes\Team;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Permissions_templates class loads the methods to generates permissions templates
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Permissions_templates {

    /**
     * The public method checkbox_input processes the plans option's type checkbox
     * 
     * @param array $option contains the option's information
     * @param integer $role_id contains the role's id
     * 
     * @since 0.0.7.9
     * 
     * @return string with processed data
     */ 
    public function checkbox_input( $option, $role_id) {
        
        // Verify if option has correct format
        if ( !isset($option['slug']) || !isset($option['label']) || !isset($option['label_description']) ) {
            return '';
        }

        $checked = '';

        if ( check_team_role_permission($role_id, $option['slug']) ) {
            $checked = ' checked';
        }
        
        // Return html
        return '<li>'
                    . '<div class="row">'
                        . '<div class="col-10">'
                            . '<label>' . $option['label'] . '</label>'
                            . '<p>' . $option['label_description'] . '</p>'
                        . '</div>'
                        . '<div class="col-2">'
                            . '<div class="checkbox-option pull-right">'
                                . '<input id="' . $option['slug'] . '-' . $role_id . '" name="' . $option['slug'] . '-' . $role_id . '" class="permission-checkbox" type="checkbox" data-permission="' . $option['slug'] . '" data-role="' . $role_id . '"' . $checked . '>'
                                . '<label for="' . $option['slug'] . '-' . $role_id . '"></label>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</li>';
        
    }

}

/* End of file permissions_templates.php */
