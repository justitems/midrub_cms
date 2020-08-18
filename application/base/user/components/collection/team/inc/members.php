<?php
/**
 * Members Inc
 *
 * PHP Version 7.3
 *
 * This files contains the hooks for
 * the Team's component from the user Panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The public set_member_permissions registers the team's permissions
 * 
 * @since 0.0.7.9
 */
set_member_permissions(

    array(
        'name' => get_instance()->lang->line('team'),
        'icon' => '<i class="icon-people"></i>',
        'slug' => 'team',
        'fields' => array(

            array (
                'type' => 'checkbox_input',
                'slug' => 'team',
                'label' => get_instance()->lang->line('team_allow'),
                'label_description' => get_instance()->lang->line('team_allow_if_enabled')
            )

        )

    )

);


/**
 * The public method set_user_team_page registers a page for user's team component
 * 
 * @since 0.0.8.2
 */
set_user_team_page (
    'members',
    array(
        'page_name' => $this->lang->line('team_members'),
        'page_icon' => '',
        'content' => 'get_user_team_members_page',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('get_user_team_members_page') ) {

    /**
     * The function get_user_team_members_page shows the team's members page
     * 
     * @return void
     */
    function get_user_team_members_page() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if should be displayed the New Member page
        if ( $CI->input->get('new-member', TRUE) ) {

            // Set the New Member Js
            set_js_urls(array(base_url('assets/base/user/components/collection/team/js/new-member.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

            // Load the new member's view
            get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/new-member.php');

        } else if ( $CI->input->get('member', TRUE) ) {

            // Verify if member is numeric
            if ( !is_numeric($CI->input->get('member', TRUE)) ) {

                // Load the no-member's view
                get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/no-member.php');

            } else {

                // Get member's data
                $member = $CI->base_model->get_data_where('teams', 'teams.*, teams_roles.role', array(
                    'teams.member_id' => $CI->input->get('member', TRUE),
                    'teams.user_id' => $CI->user_id
                ),
                array(),
                array(),
                array(array(
                    'table' => 'teams_roles',
                    'condition' => 'teams.role_id=teams_roles.role_id',
                    'join_from' => 'LEFT'
                )));

                // Verify if the member don't exists
                if ( !$member ) {

                    // Load the no-member's view
                    get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/no-member.php');

                } else {

                    // Set the Member Js
                    set_js_urls(array(base_url('assets/base/user/components/collection/team/js/member.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

                    // Set default first name key for member
                    $member[0]['first_name'] = '';

                    // Set default last name key for member
                    $member[0]['last_name'] = '';                    

                    // Get members meta
                    $get_metas = $CI->base_model->get_data_where('teams_meta', '*',
                    array(),
                    array('member_id', $CI->input->get('member', TRUE)));

                    // Verify if metas exists
                    if ( $get_metas ) {

                        // List all metas
                        foreach ( $get_metas as $meta ) {

                            // Verify if meta_name is first_name
                            if ( $meta['meta_name'] === 'first_name') {

                                // Set the first name
                                $member[0]['first_name'] = $meta['meta_value'];
                                
                            }

                            // Verify if meta_name is last_name
                            if ( $meta['meta_name'] === 'last_name') {

                                // Set the last name
                                $member[0]['last_name'] = $meta['meta_value'];
                                
                            }                            

                        }
                        
                    }

                    // Register member data
                    md_set_component_variable('member_data', $member[0]);

                    // Load the member's view
                    get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/member.php');

                }

            }

        } else {

            // Set the Members Js
            set_js_urls(array(base_url('assets/base/user/components/collection/team/js/members.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

            // Load the members's view
            get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/members.php');

        }

    }

}

/**
 * The public method set_user_team_page registers a page for user's team component
 * 
 * @since 0.0.8.2
 */
set_user_team_page (
    'roles',
    array(
        'page_name' => $this->lang->line('roles'),
        'page_icon' => '',
        'content' => 'get_user_team_roles',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('get_user_team_roles') ) {

    /**
     * The function get_user_team_roles shows the team's roles page
     * 
     * @return void
     */
    function get_user_team_roles() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if should be displayed the New Role page
        if ( $CI->input->get('new-role', TRUE) ) {

            // Set the New Role Js
            set_js_urls(array(base_url('assets/base/user/components/collection/team/js/new-role.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

            // Load the Role view
            get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/new-role.php'); 
            
        } else if ( $CI->input->get('role', TRUE) ) {

            // Verify if role is numeric
            if ( !is_numeric($CI->input->get('role', TRUE)) ) {

                // Load the no-role's view
                get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/no-role.php');

            } else {

                // Set the Role Js
                set_js_urls(array(base_url('assets/base/user/components/collection/team/js/role.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

                // Get role's data
                $role = $CI->base_model->get_data_where('teams_roles', '*', array(
                    'teams_roles.role_id' => $CI->input->get('role', TRUE),
                    'teams_roles.user_id' => $CI->user_id
                ));

                // Verify if the role exists
                if ( !$role ) {

                    // Load the no-role's view
                    get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/no-role.php');                    

                } else {

                    // Register role data
                    md_set_component_variable('role_data', $role[0]);

                    // Load the role's view
                    get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/role.php');    

                }

            }
        
        } else {

            // Set the Roles Js
            set_js_urls(array(base_url('assets/base/user/components/collection/team/js/roles.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_TEAM_VERSION)));

            // Load the Roles view
            get_the_file(MIDRUB_BASE_USER_COMPONENTS_TEAM . 'views/templates/roles.php');

        }

    }

}