<?php
/**
 * General Plans Options Inc
 *
 * PHP Version 7.2
 *
 * This files contains the general options
 * for all plans
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Get codeigniter object instance
$CI = &get_instance();

// Default refferals option
$refferals = array();

// Set refferals option
if ( get_option('enable_referral') && get_option('referrals_exact_gains') ) {
            
    $refferals = array (
        'type' => 'text_input',
        'slug' => 'referrals_exact_revenue',
        'label' => $CI->lang->line('user_referrals_exact_revenue'),
        'label_description' => $CI->lang->line('user_referrals_exact_revenue_description'),
        'input_type' => 'number'
    );
    
} else if ( get_option('enable_referral') ) {
    
    $refferals = array (
        'type' => 'text_input',
        'slug' => 'referrals_percentage_revenue',
        'label' => $CI->lang->line('user_referrals_percentage_revenue'),
        'label_description' => $CI->lang->line('user_referrals_percentage_revenue_description'),
        'input_type' => 'number'
    );
    
}

/**
 * The public md_set_plans_options registers the general plans options
 * 
 * @since 0.0.7.9
 */
md_set_plans_options(
    
    array(
        'name' => $CI->lang->line('user_general'),
        'icon' => '<i class="fas fa-home"></i>',
        'slug' => 'general',
        'fields' => array(
            array (
                'type' => 'text_input',
                'slug' => 'plan_name',
                'label' => $CI->lang->line('user_plan_name'),
                'label_description' => $CI->lang->line('user_plan_name_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'header',
                'label' => $CI->lang->line('user_plan_header'),
                'label_description' => $CI->lang->line('user_plan_header_description')
            ), array (
                'type' => 'textarea',
                'slug' => 'features',
                'label' => $CI->lang->line('user_plan_features'),
                'label_description' => $CI->lang->line('user_features_plan_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'plan_price',
                'label' => $CI->lang->line('user_plan_price'),
                'label_description' => $CI->lang->line('user_plan_price_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'currency_sign',
                'label' => $CI->lang->line('user_currency_symbol'),
                'label_description' => $CI->lang->line('user_currency_sign_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'currency_code',
                'label' => $CI->lang->line('user_currency_code'),
                'label_description' => $CI->lang->line('user_currency_code_description')
            ), array (
                'type' => 'text_input',
                'slug' => 'network_accounts',
                'label' => $CI->lang->line('user_number_accounts'),
                'label_description' => $CI->lang->line('user_allowed_accounts_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text_input',
                'slug' => 'teams',
                'label' => $CI->lang->line('teams_members'),
                'label_description' => $CI->lang->line('user_teams_members_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text_input',
                'slug' => 'period',
                'label' => $CI->lang->line('user_period_plan'),
                'label_description' => $CI->lang->line('user_plan_period_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text_input',
                'slug' => 'storage',
                'label' => $CI->lang->line('user_storage'),
                'label_description' => $CI->lang->line('user_storage_description'),
                'maxlength' => 12,
                'input_type' => 'number'
            ), array (
                'type' => 'checkbox_input',
                'slug' => 'visible',
                'label' => $CI->lang->line('user_hiden_plan'),
                'label_description' => $CI->lang->line('user_plan_status_description')
            ), array (
                'type' => 'checkbox_input',
                'slug' => 'popular',
                'label' => $CI->lang->line('user_most_popular'),
                'label_description' => $CI->lang->line('user_plan_popular_description')
            ), array (
                'type' => 'checkbox_input',
                'slug' => 'featured',
                'label' => $CI->lang->line('user_featured'),
                'label_description' => $CI->lang->line('user_plan_featured_description')
            ), array (
                'type' => 'checkbox_input',
                'slug' => 'trial',
                'label' => $CI->lang->line('user_trial_enabled'),
                'label_description' => $CI->lang->line('user_plan_trial_description')
            ), array (
                'type' => 'select_dropdown',
                'slug' => 'plans_group',
                'url' => site_url('admin/ajax/user'),
                'label' => $CI->lang->line('user_plan_group'),
                'label_description' => $CI->lang->line('user_plan_group_description'),
                'placeholder' => $CI->lang->line('user_search_for_groups')
            ), array (
                'type' => 'select_dropdown',
                'slug' => 'user_redirect',
                'url' => site_url('admin/ajax/user'),
                'label' => $CI->lang->line('user_plan_redirect'),
                'label_description' => $CI->lang->line('user_plan_redirect_description'),
                'placeholder' => $CI->lang->line('user_search_component_or_app')
            ),
            $refferals

        )

    )

);

if ( !function_exists('the_networks_list') ) {
    
    /**
     * The function the_networks_list returns array with network list
     * 
     * @since 0.0.7.9
     * 
     * @return array
     */
    function the_networks_list() {

        // Default array
        $networks = array();

        // Get codeigniter object instance
        $CI = &get_instance();

        // List all available networks
        foreach ( glob(MIDRUB_BASE_PATH . 'user/networks/*.php') as $filename ) {

            // Get the class's name
            $className = str_replace(array(MIDRUB_BASE_PATH . 'user/networks/', '.php'), '', $filename);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Networks',
                ucfirst($className)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get method
            $get = (new $cl());

            // Verify if the social networks is available
            if ( !$get->check_availability() || !get_option($className) ) {
                continue;
            }

            // Set network
            $networks[] = array (
                'type' => 'checkbox_input',
                'slug' => $className,
                'label' => ucwords(str_replace('_', ' ', $className)),
                'label_description' => $CI->lang->line('user_enable_or_disable')
            );

        }

        return $networks;
        
    }
    
}

/**
 * The public md_set_plans_options registers the networks plans options
 * 
 * @since 0.0.7.9
 */
md_set_plans_options(
    
    array(
        'name' => $CI->lang->line('user_networks'),
        'icon' => '<i class="far fa-share-square"></i>',
        'slug' => 'networks',
        'fields' => the_networks_list()
    )

);
