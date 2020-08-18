<?php
/**
 * Settings Inc
 *
 * PHP Version 7.2
 *
 * This files contains the hooks for
 * the Settings component from the user Panel
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
 * The public method set_user_settings_page registers a page for user's settings component
 * 
 * @since 0.0.8.2
 */
set_user_settings_page (
    'general',
    array(
        'page_name' => $this->lang->line('general'),
        'page_icon' => '',
        'content' => 'get_user_settings_general_page',
        'css_urls' => array(),
        'js_urls' => array(),
        'options' => array(
            array(
                'type' => 'checkbox_input',
                'slug' => 'email_notifications'
            ),
            array(
                'type' => 'checkbox_input',
                'slug' => 'notification_tickets'
            ),
            array(
                'type' => 'checkbox_input',
                'slug' => 'invoices_by_email'
            ),
            array(
                'type' => 'checkbox_input',
                'slug' => '24_hour_format'
            ),
            array(
                'type' => 'checkbox_input',
                'slug' => 'week_starts_sunday'
            ),
            array(
                'type' => 'checkbox_input',
                'slug' => 'new_original_slug'
            ),
            array(
                'type' => 'text_input',
                'slug' => 'original_slug'
            )                      
        )
    )
);

if ( !function_exists('get_user_settings_general_page') ) {

    /**
     * The function get_user_settings_general_page shows the settings general page
     * 
     * @return void
     */
    function get_user_settings_general_page() {

        // Load the General view
        get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/templates/general.php');

    }

}

/**
 * The public method set_user_settings_page registers a page for user's settings component
 * 
 * @since 0.0.8.2
 */
set_user_settings_page (
    'advanced',
    array(
        'page_name' => $this->lang->line('advanced'),
        'page_icon' => '',
        'content' => 'get_user_settings_advanced_page',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('get_user_settings_advanced_page') ) {

    /**
     * The function get_user_settings_advanced_page shows the settings advanced page
     * 
     * @return void
     */
    function get_user_settings_advanced_page() {

        // Load the Advanced view
        get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/templates/advanced.php');

    }

}

/**
 * The public method set_user_settings_page registers a page for user's settings component
 * 
 * @since 0.0.8.2
 */
set_user_settings_page (
    'plan_usage',
    array(
        'page_name' => $this->lang->line('plan_usage'),
        'page_icon' => '',
        'content' => 'get_user_settings_plan_usage_page',
        'css_urls' => array(),
        'js_urls' => array()  
    )
);

if ( !function_exists('get_user_settings_plan_usage_page') ) {

    /**
     * The function get_user_settings_plan_usage_page shows the settings plans usage page
     * 
     * @return void
     */
    function get_user_settings_plan_usage_page() {

        // Get codeigniter object instance
        $CI = get_instance();

        // Default plan's usage
        $default = array();

        // Get the user's plan
        $user_plan = get_user_option('plan', $CI->user_id);

        // Get plan end
        $plan_end = get_user_option('plan_end', $CI->user_id);

        // Get plan data
        $plan_data = $CI->plans->get_plan($user_plan);

        // Calculate remaining time
        $time = strip_tags(calculate_time(strtotime($plan_end), time()));

        // Set period
        $period = (strtotime($plan_end) - (strtotime($plan_end) - ($plan_data[0]['period'] * 86400)));

        // Set taken time
        $time_taken = ($period - (strtotime($plan_end) - time()));

        // Set usage
        $default[] = array(
            'name' => $plan_data[0]['plan_name'],
            'value' => $time_taken,
            'limit' => $period,
            'left' => $time
        );

        // Get user storage
        $user_storage = get_user_option('user_storage', $CI->user_id);

        if (!$user_storage) {
            $user_storage = 0;
        }

        $plan_storage = 0;

        // Gets plan's storage
        $plan_st = plan_feature('storage');

        if ($plan_st) {

            $plan_storage = $plan_st;
        }

        // Set usage
        $default[] = array(
            'name' => $CI->lang->line('storage'),
            'value' => $user_storage,
            'limit' => $plan_storage,
            'left' => calculate_size($user_storage) . '/' . calculate_size($plan_storage)
        );

        $team_limits = plan_feature('teams');

        // Verify if teams is available
        if ($team_limits > 0) {

            // Load Team Model
            $CI->load->model('team');

            // Get team members
            $members = $CI->team->get_members($CI->user_id);

            if (!$members) {
                $members = 0;
            }

            // Set usage
            $default[] = array(
                'name' => $CI->lang->line('teams'),
                'value' => $members,
                'limit' => $team_limits,
                'left' => ($team_limits - $members)
            );

        }

        // Adds plan usage to the list
        set_plans_usage($default);

        // Load the Plans Usage view
        get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/templates/plan_usage.php');

    }

}

// Verify if referrals are enabled
if ( get_option('enable_referral') ) {

    /**
     * The public method set_user_settings_page registers a page for user's settings component
     * 
     * @since 0.0.8.2
     */
    set_user_settings_page (
        'referrals',
        array(
            'page_name' => $this->lang->line('referrals'),
            'page_icon' => '',
            'content' => 'get_user_settings_referrals_page',
            'css_urls' => array(),
            'js_urls' => array()  
        )
    );

}

if ( !function_exists('get_user_settings_referrals_page') ) {

    /**
     * The function get_user_settings_referrals_page shows the settings referrals page
     * 
     * @return void
     */
    function get_user_settings_referrals_page() {

        // Get codeigniter object instance
        $CI = get_instance();

        // Load Referrals Model
        $CI->load->model('referrals');

        // Get Referral stats
        $stats = $CI->referrals->get_stats($CI->user_id);

        // Verify if stats exists
        if ( $stats ) {

            // Set global variable stats
            set_global_variable('user_referral_stats', $stats[0]);

        } else {

            // Set global variable stats
            set_global_variable('user_referral_stats', array());
            
        }

        // Load the Referrals view
        get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/templates/referrals.php');

    }

}

// Verify if Invoices are enabled
if ( !get_option('hide_invoices') ) {

    /**
     * The public method set_user_settings_page registers a page for user's settings component
     * 
     * @since 0.0.8.2
     */
    set_user_settings_page (
        'invoices',
        array(
            'page_name' => $this->lang->line('invoices'),
            'page_icon' => '',
            'content' => 'get_user_settings_invoices_page',
            'css_urls' => array(),
            'js_urls' => array()  
        )
    );

}

if ( !function_exists('get_user_settings_invoices_page') ) {

    /**
     * The function get_user_settings_invoices_page shows the settings invoices page
     * 
     * @return void
     */
    function get_user_settings_invoices_page() {

        // Load the invoices view
        get_the_file(MIDRUB_BASE_USER_COMPONENTS_SETTINGS . 'views/templates/invoices.php');

    }

}