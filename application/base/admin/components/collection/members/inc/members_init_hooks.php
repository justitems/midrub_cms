<?php
/**
 * Members Init Hooks Inc
 *
 * PHP Version 7.3
 *
 * This files contains the hooks which are registered
 * immediately when the Member component is loaded
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Members General Inc file
require_once CMS_BASE_ADMIN_COMPONENTS_MEMBERS . 'inc/members_general.php';

// Get codeigniter object instance
$CI = &get_instance();

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'first_name',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_first_name'),
            'field_description' => $CI->lang->line('members_first_name_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_first_name'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'first_name'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'last_name',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_last_name'),
            'field_description' => $CI->lang->line('members_last_name_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_last_name'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'last_name'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'username',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_username'),
            'field_description' => $CI->lang->line('members_username_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_username'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'username'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'email',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_email'),
            'field_description' => $CI->lang->line('members_email_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_email'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'email'):'',
            'disabled' => false
        )

    )

);

// Get the countries
$countries = the_members_countries_list();

// Set the country's name
$country_name = md_the_user_option($CI->input->get('member'), 'country')?$countries[md_the_user_option($CI->input->get('member'), 'country')]:$CI->lang->line('members_select_country');

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(

    array(
        'field_slug' => 'country',
        'field_type' => 'dynamic_list',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_country'),
            'field_description' => $CI->lang->line('members_select_country_description')
        ),
        'field_params' => array(
            'button_text' => $country_name,
            'button_value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'country'):0,
            'placeholder' => $CI->lang->line('members_search_countries')
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'state',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_state'),
            'field_description' => $CI->lang->line('members_state_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_state'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'state'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'city',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_city'),
            'field_description' => $CI->lang->line('members_city_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_city'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'city'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'postal_code',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_postal_code'),
            'field_description' => $CI->lang->line('members_postal_code_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_postal_code'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'postal_code'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'street_number',
        'field_type' => 'text',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_street_number'),
            'field_description' => $CI->lang->line('members_street_number_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_street_number'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'street_number'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'password',
        'field_type' => 'password',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_password'),
            'field_description' => $CI->lang->line('members_password_description')
        ),
        'field_params' => array(
            'placeholder' => $CI->lang->line('members_enter_password'),
            'value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'password_input'):'',
            'disabled' => false
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    array(
        'field_slug' => 'role',
        'field_type' => 'dropdown',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_role'),
            'field_description' => $CI->lang->line('members_role_description')
        ),
        'field_params' => array(
            'button_text' => (md_the_user_option($CI->input->get('member'), 'role') === '1')?$CI->lang->line('members_administrator'):$CI->lang->line('members_user'),
            'button_value' => md_the_user_option($CI->input->get('member'), 'role')?md_the_user_option($CI->input->get('member'), 'role'):0,
            'field_items' => array (
                array(
                    'id' => '0',
                    'name' => $CI->lang->line('members_user')    
                ),
                array(
                    'id' => '1',
                    'name' => $CI->lang->line('members_administrator') 
                )  
                
            )

        )

    )

);

// Default status
$status = $CI->lang->line('members_active');

// Verify if the member's exists
if ( $CI->input->get('member') ) {

    // Switch status
    switch ( md_the_user_option($CI->input->get('member'), 'status') ) {

        case '0':
            $status = $CI->lang->line('members_inactive');
            break;

        case '2':
            $status = $CI->lang->line('members_blocked');
            break;        

    }

}

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(
    
    array(
        'field_slug' => 'status',
        'field_type' => 'dropdown',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_status'),
            'field_description' => $CI->lang->line('members_select_status_description')
        ),
        'field_params' => array(
            'button_text' => $status,
            'button_value' => $CI->input->get('member')?md_the_user_option($CI->input->get('member'), 'status'):1,
            'field_items' => array (
                array(
                    'id' => '0',
                    'name' => $CI->lang->line('members_inactive')
                ),
                array(
                    'id' => '1',
                    'name' => $CI->lang->line('members_active')
                ),
                array(
                    'id' => '2',
                    'name' => $CI->lang->line('members_blocked')
                )  
                
            )

        )

    )

);

// Default member's plan
$member_plan = 0;

// Default member's plan name
$member_plan_name = '';

// Verify if member's id exists
if ( $CI->input->get('member') ) {

    // Get member's plan
    $the_member_plan = $this->CI->base_model->the_data_where(
        'users_meta',
        'users_meta.meta_value, plans.plan_name',
        array(
            'users_meta.user_id' => $CI->input->get('member'),
            'users_meta.meta_name' => 'plan'
        ),
        array(),
        array(),
        array(array(
            'table' => 'plans',
            'condition' => 'users_meta.meta_value=plans.plan_id',
            'join_from' => 'LEFT'
        )),
    );

    // Verify if member's plan exists
    if ( $the_member_plan ) {

        // Set plan's ID
        $member_plan = $the_member_plan[0]['meta_value'];

        // Set plan's name
        $member_plan_name = $the_member_plan[0]['plan_name'];

    }

}

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(

    array(
        'field_slug' => 'plan',
        'field_type' => 'dynamic_list',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_plan'),
            'field_description' => $CI->lang->line('members_select_plan_description')
        ),
        'field_params' => array(
            'button_text' => $member_plan?$member_plan_name:$CI->lang->line('members_select_plan'),
            'button_value' => $member_plan?$member_plan:0,
            'placeholder' => $CI->lang->line('members_search_plans')
        )

    )

);

/**
 * The public method set_admin_members_field registers a members field
 * 
 * @since 0.0.8.5
 */
set_admin_members_field(

    array(
        'field_slug' => 'send_email',
        'field_type' => 'checkbox',
        'field_words' => array(
            'field_title' => $CI->lang->line('members_send_email'),
            'field_description' => $CI->lang->line('members_send_email_description')
        ),
        'field_params' => array(
            'checked' => 0
        )

    )

);

/**
 * The public method set_admin_members_member_data_for_general_tab registers data for the General members tab
 * 
 * @since 0.0.8.5
 */
set_admin_members_member_data_for_general_tab('the_admin_members_member_last_access_data_for_general_tab');

if ( !function_exists('the_admin_members_member_last_access_data_for_general_tab') ) {
    
    /**
     * The function the_admin_members_member_last_access_data_for_general_tab returns the last_access's data
     * 
     * @since 0.0.8.5
     * 
     * @return array with response or boolean false
     */
    function the_admin_members_member_last_access_data_for_general_tab() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Set value
        $value = $CI->lang->line('members_never');

        // Verify for last access
        if ( md_the_user_option($CI->input->get('member'), 'last_access') ) {

            // Set new value
            $value = substr(md_the_user_option($CI->input->get('member'), 'last_access'), 0, 10);

        }

        // Set response
        return array(
            'label' => $CI->lang->line('members_last_access'),
            'value' => $value
        );
        
    }
    
}

/**
 * The public method set_admin_members_member_data_for_general_tab registers data for the General members tab
 * 
 * @since 0.0.8.5
 */
set_admin_members_member_data_for_general_tab('the_admin_members_member_signup_data_for_general_tab');

if ( !function_exists('the_admin_members_member_signup_data_for_general_tab') ) {
    
    /**
     * The function the_admin_members_member_signup_data_for_general_tab returns the signup's data
     * 
     * @since 0.0.8.5
     * 
     * @return array with response or boolean false
     */
    function the_admin_members_member_signup_data_for_general_tab() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Set response
        return array(
            'label' => $CI->lang->line('members_joined'),
            'value' => substr(md_the_user_option($CI->input->get('member'), 'date_joined'), 0, 10)
        );
        
    }
    
}

/**
 * The public method set_admin_members_member_tab registers a members tab
 * 
 * @since 0.0.8.5
 */
set_admin_members_member_tab(
    'general_activity',
    array(
        'tab_name' => $CI->lang->line('members_general'),
        'tab_icon' => md_the_admin_icon(array('icon' => 'general')),
        'tab_content' => '<ul class="list-group theme-settings-options mt-3">' . the_admin_members_member_data_for_general_tab() . '</li>',
        'css_urls' => array(),
        'js_urls' => array() 
    )
);

/**
 * The public method set_admin_members_member_tab registers a members tab
 * 
 * @since 0.0.8.5
 */
set_admin_members_member_tab(
    'transactions',
    array(
        'tab_name' => $CI->lang->line('members_transactions'),
        'tab_icon' => md_the_admin_icon(array('icon' => 'member_money')),
        'tab_content' => '<div class="row">'
            . '<div class="col-12">'
                . '<div class="card theme-list mt-0">'
                    . '<div class="card-body"></div>'
                    . '<div class="card-footer theme-box-1">'
                        . '<div class="row">'
                            . '<div class="col-md-5 col-12">'
                                . '<h6 class="theme-color-black"></h6>'
                            . '</div>'
                            . '<div class="col-md-7 col-12 text-end">'
                                . '<nav aria-label="member-transactions">'
                                    . '<ul class="theme-pagination" data-type="member-transactions">'
                                    . '</ul>'
                                . '</nav>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>'
            . '</div>'
        . '</div>',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/members/styles/css/tab-transactions.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_MEMBERS_VERSION), 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/members/js/tab-transactions.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_MEMBERS_VERSION))
        )  
    )
);