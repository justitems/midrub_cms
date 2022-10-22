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
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Get codeigniter object instance
$CI = &get_instance();

/**
 * The public md_set_plans_options registers the general plans options
 * 
 * @since 0.0.7.9
 */
md_set_plans_options(
    
    array(
        'name' => $CI->lang->line('user_general'),
        'icon' => md_the_admin_icon(array('icon' => 'home')),
        'slug' => 'general',
        'fields' => array(
            array (
                'field_type' => 'text',
                'field_slug' => 'plan_name',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_plan_name'),
                    'field_description' => $CI->lang->line('user_plan_name_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('plan_name', $CI->input->get('plan_id')),
                    'disabled' => false
                )
                
            ), array (
                'field_type' => 'text',
                'field_slug' => 'plan_price',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_plan_price'),
                    'field_description' => $CI->lang->line('user_plan_price_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('plan_price', $CI->input->get('plan_id')),
                    'disabled' => false
                )

            ), array (
                'field_type' => 'text',
                'field_slug' => 'currency_sign',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_currency_symbol'),
                    'field_description' => $CI->lang->line('user_currency_sign_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('currency_sign', $CI->input->get('plan_id')),
                    'disabled' => false
                )                

            ), array (
                'field_type' => 'text',
                'field_slug' => 'currency_code',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_currency_code'),
                    'field_description' => $CI->lang->line('user_currency_code_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('currency_code', $CI->input->get('plan_id')),
                    'disabled' => false
                )

            ), array (
                'field_type' => 'text',
                'field_slug' => 'period',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_period_plan'),
                    'field_description' => $CI->lang->line('user_plan_period_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('period', $CI->input->get('plan_id')),
                    'disabled' => false
                )
                
            ), array (
                'field_type' => 'checkbox',
                'field_slug' => 'hidden',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_hiden_plan'),
                    'field_description' => $CI->lang->line('user_plan_status_description')
                ),
                'field_params' => array(
                    'checked' => md_the_plan_feature('hidden', $CI->input->get('plan_id'))?1:0
                )
                
            ), array (
                'field_type' => 'checkbox',
                'field_slug' => 'popular',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_most_popular'),
                    'field_description' => $CI->lang->line('user_plan_popular_description')
                ),
                'field_params' => array(
                    'checked' => md_the_plan_feature('popular', $CI->input->get('plan_id'))?1:0
                )

            ), array (
                'field_type' => 'checkbox',
                'field_slug' => 'featured',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_featured'),
                    'field_description' => $CI->lang->line('user_plan_featured_description')
                ),
                'field_params' => array(
                    'checked' => md_the_plan_feature('featured', $CI->input->get('plan_id'))?1:0
                )
                
            ), array (
                'field_type' => 'checkbox',
                'field_slug' => 'trial',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_trial_enabled'),
                    'field_description' => $CI->lang->line('user_plan_trial_description')
                ),
                'field_params' => array(
                    'checked' => md_the_plan_feature('trial', $CI->input->get('plan_id'))?1:0
                )
                
            )

        )

    )

);

// Default refferals option
$refferals = array();

// Set refferals option
if ( md_the_option('enable_referral') && md_the_option('referrals_exact_gains') ) {
            
    $refferals = array (
        'field_type' => 'text',
        'field_slug' => 'referrals_exact_revenue',
        'field_words' => array(
            'field_title' => $CI->lang->line('user_referrals_exact_revenue'),
            'field_description' => $CI->lang->line('user_referrals_exact_revenue_description')
        ),
        'field_params' => array(
            'value' => md_the_plan_feature('referrals_exact_revenue', $CI->input->get('plan_id')),
            'disabled' => false
        )
        
    );
    
} else if ( md_the_option('enable_referral') ) {
    
    $refferals = array (
        'field_type' => 'text',
        'field_slug' => 'referrals_percentage_revenue',
        'field_words' => array(
            'field_title' => $CI->lang->line('user_referrals_percentage_revenue'),
            'field_description' => $CI->lang->line('user_referrals_percentage_revenue_description')
        ),
        'field_params' => array(
            'value' => md_the_plan_feature('referrals_percentage_revenue', $CI->input->get('plan_id')),
            'disabled' => false
        )
        
    );
    
}

// Default plan_group
$plan_group = $CI->lang->line('user_select_plan_group');

// Get the plan's group
$the_plan_group = md_the_plan_feature('plans_group', $CI->input->get('plan_id'));

// Verify if the plan's group exists
if ( $the_plan_group ) {

    // Get group by id
    $the_group = $CI->base_model->the_data_where(
        'plans_groups',
        '*',
        array(
            'group_id' => $the_plan_group
        )
    );

    // Verify if group exists
    if ( $the_group ) {

        // Set group
        $plan_group = array(
            'id' => $the_group[0]['group_id'],
            'name' => $the_group[0]['group_name']
        );

    }

}

// Default user redirect
$user_redirect = $CI->lang->line('user_select_app_or_component');

// Verify if the plan has a selected user_redirect
if ( md_the_plan_feature( 'user_redirect', $CI->input->get('plan_id') ) ) {
    
    // List all user's apps
    foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

        // Get the directory's name
        $app = trim(basename($directory) . PHP_EOL);

        // Verify if the app is enabled
        if ( !md_the_option('app_' .  $app. '_enabled') ) {
            continue;
        }

        // Create an array
        $array = array(
            'CmsBase',
            'User',
            'Apps',
            'Collection',
            ucfirst($app),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Get app's info
        $info = (new $cl())->app_info();

        // Verify if redirect is the current app
        if ( md_the_plan_feature( 'user_redirect', $CI->input->get('plan_id') ) === $info['app_slug'] ) {

            // Set app
            $user_redirect = array(
                'id' => $info['app_slug'],
                'name' => $info['app_name']
            );

            break;

        }

    }

    // Verify if an app was selected
    if ( !is_array($user_redirect) ) {

        // List all user's components
        foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $component = trim(basename($directory) . PHP_EOL);

            // Verify if the component is enabled
            if ( !md_the_option('component_' . $component . '_enabled') ) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Components',
                'Collection',
                ucfirst($component),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get component's info
            $info = (new $cl())->component_info();

            // Verify if redirect is the current component
            if ( md_the_plan_feature( 'user_redirect', $CI->input->get('plan_id') ) === $info['component_slug'] ) {

                // Set component
                $user_redirect = array(
                    'id' => $info['component_name'],
                    'name' => $info['component_slug']
                );

                break;

            }

        }

    }
    
}

/**
 * The public md_set_plans_options registers the general plans options
 * 
 * @since 0.0.7.9
 */
md_set_plans_options(
    
    array(
        'name' => $CI->lang->line('user_advanced'),
        'icon' => md_the_admin_icon(array('icon' => 'advanced')),
        'slug' => 'advanced',
        'fields' => array(
            
            array (
                'field_type' => 'text',
                'field_slug' => 'network_accounts',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_number_accounts'),
                    'field_description' => $CI->lang->line('user_allowed_accounts_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('network_accounts', $CI->input->get('plan_id')),
                    'disabled' => false
                ) 
                
            ), array (
                'field_type' => 'text',
                'field_slug' => 'teams',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_teams_members'),
                    'field_description' => $CI->lang->line('user_teams_members_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('teams', $CI->input->get('plan_id')),
                    'disabled' => false
                ) 
                                
            ), array (
                'field_type' => 'text',
                'field_slug' => 'storage',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_storage'),
                    'field_description' => $CI->lang->line('user_storage_description')
                ),
                'field_params' => array(
                    'value' => md_the_plan_feature('storage', $CI->input->get('plan_id')),
                    'disabled' => false
                )

            ), array(
                'field_slug' => 'plans_group',
                'field_type' => 'dynamic_list',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_plan_group'),
                    'field_description' => $CI->lang->line('user_plan_group_description')
                ),
                'field_params' => array(
                    'button_text' => is_array($plan_group)?$plan_group['name']:$plan_group,
                    'button_value' => is_array($plan_group)?$plan_group['id']:0,
                    'placeholder' => $CI->lang->line('user_search_for_groups')
                )

            ), array(
                'field_slug' => 'user_redirect',
                'field_type' => 'dynamic_list',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_plan_redirect'),
                    'field_description' => $CI->lang->line('user_plan_redirect_description')
                ),
                'field_params' => array(
                    'button_text' => is_array($user_redirect)?$user_redirect['name']:$user_redirect,
                    'button_value' => is_array($user_redirect)?$user_redirect['id']:0,
                    'placeholder' => $CI->lang->line('user_search_component_or_app')
                )

            ),
            $refferals,
            array(
                'field_slug' => 'plan_text',
                'field_type' => 'plan_text',
                'field_words' => array(
                    'field_title' => $CI->lang->line('user_plan_text'),
                    'field_description' => $CI->lang->line('user_plan_text_description')
                ),
                'field_params' => array(
                    'plan_id' => $CI->input->get('plan_id')
                )

            )

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
        foreach ( glob(CMS_BASE_PATH . 'user/networks/collection/*.php') as $filename ) {

            // Get the class's name
            $className = str_replace(array(CMS_BASE_PATH . 'user/networks/collection/', '.php'), '', $filename);

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Networks',
                'Collection',
                ucfirst($className)
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get method
            $get = (new $cl());

            // Verify if the social networks is available
            if ( !$get->availability() || !md_the_option('network_' . $className . '_enabled') ) {
                continue;
            }

            // Get network's info
            $info = (new $cl())->info();

            // Set network
            $networks[] = array (
                'field_type' => 'checkbox',
                'field_slug' => 'network_' . $className,
                'field_words' => array(
                    'field_title' => $info['network_name'],
                    'field_description' => $CI->lang->line('user_enable_or_disable')
                ),
                'field_params' => array(
                    'checked' => md_the_plan_feature('network_' . $className, $CI->input->get('plan_id'))?1:0
                )
                
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
        'icon' => md_the_admin_icon(array('icon' => 'networks')),
        'slug' => 'networks',
        'fields' => the_networks_list()
    )

);
