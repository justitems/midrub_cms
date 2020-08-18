<?php
/**
 * Team Permissions Inc
 *
 * This file contains the team's member functions
 * for permissions
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Team as MidrubBaseClassesTeam;

if ( !function_exists('md_set_member_permissions') ) {
    
    /**
     * The function md_set_member_permissions registers permissions for team's member
     * 
     * @param array $args contains the permissions
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_member_permissions($args) {

        // Call the permissions class
        $team_permissions = (new MidrubBaseClassesTeam\Permissions);

        // Set permissions in the queue
        $team_permissions->set_permissions($args);
        
    }
    
}

if ( !function_exists('md_the_member_permissions') ) {
    
    /**
     * The function md_the_member_permissions returns the member's permissions
     * 
     * @param integer $role_id contains the role's id
     * 
     * @since 0.0.7.9
     * 
     * @return string with permissions or boolean false
     */
    function md_the_member_permissions($role_id) {

        // Call the permissions class
        $team_permissions = (new MidrubBaseClassesTeam\Permissions);

        // Get member's permissions
        $member_permissions = $team_permissions->load_permissions();

        // Verify if permissions exists
        if ( $member_permissions ) {

            // Permissions
            $permissions = '<div class="row">'
                        . '<div class="col-xl-3">'
                    . '<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';

            $first = 0;

            // Lista all permissions
            foreach ( $member_permissions as $permission ) {

                $active = '';
                $selected = 'false';

                if ( $first < 1 ) {
                    $active = ' active';
                    $selected = 'true';
                }

                $permissions .= '<a class="nav-link' . $active . '" id="v-pills-' . $permission['slug'] . '-tab" data-toggle="pill" href="#v-pills-' . $permission['slug'] . '-' . $role_id . '" role="tab" aria-controls="v-pills-' . $permission['slug'] . '-' . $role_id . '" aria-selected="' . $selected . '">'
                        . $permission['icon'] . ' ' . $permission['name']
                    . '</a>';

                $first++;

            }

            $permissions .= '</div>'
                        . '</div>'
                    .'<div class="col-xl-9">'
                . '<div class="tab-content" id="v-pills-tabContent">';
            
            $first = 0;

            // Lista all permissions
            foreach ( $member_permissions as $permission ) {

                $active = '';

                if ( $first < 1 ) {
                    $active = ' active';
                }

                $permissions .= '<div class="tab-pane fade show ' . $active . '" id="v-pills-' . $permission['slug'] . '-' . $role_id . '" role="tabpanel" aria-labelledby="v-pills-' . $permission['slug'] . '-tab">'
                            . '<ul class="list-permissions">';

                // Verify if fields exists
                if ( $permission['fields'] ) {

                    // List all fields
                    foreach ( $permission['fields'] as $field ) {

                        if ( !isset($field['type']) ) {
                            continue;
                        }

                        // Verify if class has the method
                        if (method_exists((new MidrubBaseClassesTeam\Permissions_templates), $field['type'])) {

                            // Set the method to call
                            $method = $field['type'];

                            // Display input
                            $permissions .= (new MidrubBaseClassesTeam\Permissions_templates)->$method($field, $role_id);
                        }

                    }

                }

                $permissions .= '</ul>'
                            . '</div>';

                $first++;

            }

            $permissions .= '</div>'
                        . '</div>'
                    . '</div>';

            return $permissions;

        }
        
    }
    
}

/* End of file permissions.php */