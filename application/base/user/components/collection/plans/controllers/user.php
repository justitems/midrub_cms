<?php
/**
 * User Controller
 *
 * This file loads the Plans component in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Plans\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// General functions
require_once MIDRUB_BASE_USER_COMPONENTS_PLANS . 'inc/general.php';

/*
 * User class loads the Plans view
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI, $css_urls_widgets = array(), $js_urls_widgets = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the Plans Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_PLANS . 'models/', 'Plans_model', 'plans_model' );
        
        // Load language
        $this->CI->lang->load( 'plans_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_PLANS );

        // Load Alerts Helper
        $this->CI->load->helper('alerts_helper');
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set the Plans styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/components/collection/plans/styles/css/styles.css?ver=' . MIDRUB_BASE_USER_COMPONENTS_PLANS_VERSION), 'text/css', 'all'));
        
        // Set the Main Plans Js
        set_js_urls(array(base_url('assets/base/user/components/collection/plans/js/main.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_PLANS_VERSION)));

        // Load Plans Model
        $this->CI->load->model('plans');

        // Load Referrals model
        $this->CI->load->model('Referrals', 'referrals');

        // Verify if single page exists
        if ( $this->CI->input->get('p', TRUE) ) {

            switch ( $this->CI->input->get('p', TRUE) ) {

                case 'upgrade':

                    // Set plan's id
                    $plan_id = $this->CI->input->get('plan', TRUE);
                
                    // Verify if plan exists
                    if ( is_numeric( $plan_id ) ) {

                        // Define the required constant
                        defined('MIDRUB_BASE_PAYMENTS') OR define('MIDRUB_BASE_PAYMENTS', APPPATH . 'base/payments/');

                        // Require the payments gateway Inc functions file
                        require_once MIDRUB_BASE_PATH . 'inc/payments/gateways.php';

                        // Get plan
                        $plan = $this->CI->plans->get_plan($plan_id);

                        // Verify if plan exists
                        if ( $plan ) {

                            // Get plan's data
                            $plan_data = $this->CI->plans->get_plan_price($plan_id);

                            if ($plan_data[0]->plan_price > 0) {

                                // List all payments gateways
                                foreach (glob(APPPATH . 'base/payments/collection/*', GLOB_ONLYDIR) as $gateway) {

                                    // Get the gateway's name
                                    $gateway = trim(basename($gateway) . PHP_EOL);

                                    // Verify if the gateway is enabled
                                    if ( !get_option($gateway) ) {
                                        continue;
                                    }

                                    // Create an array
                                    $array = array(
                                        'MidrubBase',
                                        'Payments',
                                        'Collection',
                                        ucfirst($gateway),
                                        'Main'
                                    );

                                    // Implode the array above
                                    $cl = implode('\\', $array);

                                    // Get method
                                    (new $cl())->load_hooks('user_init');
                        
                                }

                                // Set the layout's content
                                $params = array(
                                    'plan_id' => $plan_id,
                                    'plan_data' => $plan_data
                                );

                                // Get discount if exists
                                $discount = $this->CI->session->flashdata('transaction_discount');

                                // Verify if discount exists
                                if ($discount) {

                                    // Calculate total discount
                                    $total = ($plan_data[0]->plan_price / 100) * $discount['discount_value'];

                                    // Set new price
                                    $params['plan_data'][0]->plan_price = number_format(($plan_data[0]->plan_price - $total), 2);

                                    // Set discount
                                    $params['discount'] = $discount['discount_value'];

                                    // Set discount code
                                    $params['discount_code'] = $discount['discount_code'];

                                }

                                // Set views params
                                set_user_view(
                                    $this->CI->load->ext_view(
                                        MIDRUB_BASE_USER_COMPONENTS_PLANS . 'views',
                                        'gateways',
                                        $params,
                                        true
                                    )
                                );

                            } else {

                                // Change user's plan
                                if ( $this->CI->plans_model->change_plan($plan_id, $this->CI->user_id) ) {

                                    // Set upgrade's success message
                                    $this->CI->session->set_flashdata('plans_change_message', $this->CI->lang->line('plans_was_upgraded'));

                                    // We need to delete the previous subscription
                                    $subscriptions = $this->CI->base_model->get_data_where('subscriptions', '*', array(
                                        'user_id' => $this->CI->user_id
                                    ));

                                    // Verify if old subscribtions exists
                                    if ( $subscriptions ) {

                                        // List all subscriptions
                                        foreach ( $subscriptions as $subscription ) {
                                            
                                            // Create an array
                                            $array = array(
                                                'MidrubBase',
                                                'Payments',
                                                'Collection',
                                                ucfirst($subscription['gateway']),
                                                'Main'
                                            );

                                            // Implode the array above
                                            $cl = implode('\\', $array);

                                            // Delete subscribtion
                                            (new $cl())->delete_subscription($subscription);

                                        }

                                        // Delete the subscription from the database
                                        $this->CI->base_model->delete('subscriptions', array(
                                            'user_id' => $this->CI->user_id,
                                        ) );

                                    }

                                } else {

                                    // Set upgrade's error message
                                    $this->CI->session->set_flashdata('plans_change_message', $this->CI->lang->line('plans_was_not_upgraded'));

                                }

                                // go to plans page
                                redirect('user/plans');

                            }

                        } else {
                            show_404();
                        }

                    } else {
                        show_404();
                    }

                    break;
                                    
                case 'coupon-code':

                    // Set plan's id
                    $plan_id = $this->CI->input->get('plan', TRUE);
                
                    // Verify if plan exists
                    if ( is_numeric( $plan_id ) ) {

                        // Get plan
                        $plan = $this->CI->plans->get_plan($plan_id);

                        // Verify if plan exists
                        if ( $plan ) {

                            // Get plan price
                            $plan_data = $this->CI->plans->get_plan_price($plan_id);

                            if ($plan_data[0]->plan_price > 0) {

                                // Set the layout's content
                                $params = array(
                                    'plan_id' => $plan_id,
                                    'plan_data' => $plan_data
                                );

                                // Set views params
                                set_user_view(
                                    $this->CI->load->ext_view(
                                        MIDRUB_BASE_USER_COMPONENTS_PLANS . 'views',
                                        'coupon-code',
                                        $params,
                                        true
                                    )
                                );

                            } else {

                                // go to plans page
                                redirect('user/plans');

                            }

                        } else {
                            show_404();
                        }

                    } else {
                        show_404();
                    }

                    break;

                default:
                    show_404();
                    break;

            }

        } else {

            $upgrade = '';

            // Get complete transaction
            $complete_transaction = the_complete_transaction();

            // Verify if complete transaction exists
            if ( $complete_transaction ) {

                // Verify if options exists
                if ( !empty($complete_transaction['options']) ) {

                    // Options array
                    $options = array();

                    // List all transaction's options
                    foreach ( $complete_transaction['options'] as $option ) {

                        // Set option
                        $options[$option['option_name']] = $option['option_value'];
                        
                    }

                    // Verify if options exists
                    if ( $options ) {

                        // Verify if plan's ID exists
                        if ( isset($options['plan_id']) ) {

                            // Get the user's plan
                            $user_plan = get_user_option( 'plan', $this->CI->user_id );

                            // Change user's plan
                            if ( $this->CI->plans_model->change_plan($options['plan_id'], $this->CI->user_id) ) {

                                // Verify if user has renewed the subscription
                                if ( $user_plan === $options['plan_id'] ) {

                                    // Set renew's success message
                                    $upgrade = $this->CI->lang->line('plans_was_renewed');

                                } else {

                                    // Set upgrade's success message
                                    $upgrade = $this->CI->lang->line('plans_was_upgraded');

                                    // Verify if Referrals are enabled
                                    if ( get_option('enable_referral') ) {
                
                                        // Get referral data
                                        $referral = $this->CI->referrals->get_referral($this->CI->user_id);
                    
                                        if ( $referral ) {
                    
                                            if ( $referral[0]->earned < 1 ) {
                                                
                                                if ( get_option('referrals_exact_gains') ) {
                    
                                                    if ( is_numeric(plan_feature('referrals_exact_revenue', $options['plan_id'])) ) {
                                                        
                                                        // Add referral earning
                                                        $this->CI->referrals->add_earnings_to_referral($this->CI->user_id, $options['plan_id'], plan_feature('referrals_exact_revenue', $options['plan_id']));
                                                        
                                                    }
                                                    
                                                } else {
                                                    
                                                    if ( is_numeric(plan_feature('referrals_percentage_revenue', $options['plan_id'])) ) {
                                                        
                                                        // Calculate percentage
                                                        $total = number_format( ( (plan_feature('referrals_percentage_revenue', $options['plan_id']) / 100) * $complete_transaction['pay']['amount']), 2);   
                                                        
                                                        // Add referral earning
                                                        $this->CI->referrals->add_earnings_to_referral($this->CI->user_id, $options['plan_id'], $total);                                    
                                                        
                                                    }
                                                    
                                                }
                    
                                            }
                    
                                        }
                                    
                                    }

                                }

                            } else {

                                // Verify if user has renewed the subscription
                                if ( $user_plan === $options['plan_id'] ) {

                                    // Set renew's error message
                                    $upgrade = $this->CI->lang->line('plans_was_not_renewed');                                    
                                    
                                } else {

                                    // Set upgrade's error message
                                    $upgrade = $this->CI->lang->line('plans_was_not_upgraded');

                                }

                            }

                        }

                        // Verify if the discount code exists
                        if ( isset($options['discount_code']) ) {

                            // Search for coupon
                            $coupon = $this->CI->base_model->get_data_where('coupons', '*', array(
                                'code' => $this->CI->security->xss_clean($options['discount_code'])
                            ));

                            // Verify if coupon exists
                            if ( $coupon ) {

                                // Update count
                                $this->CI->base_model->update('coupons', array(
                                    'coupon_id' => $coupon[0]['coupon_id']
                                ), array(
                                    'count' => ($coupon[0]['count'] + 1)
                                ));

                            }

                        }

                    }

                }

            }

            // Verify if user has changed to a free plan
            if ( $this->CI->session->flashdata('plans_change_message') ) {

                // Set upgrade's message
                $upgrade = $this->CI->session->flashdata('plans_change_message');
                
            }

            // Get all plans
            $get_plans = $this->CI->plans->get_all_plans();

            // Get user plan
            $user_plan = $this->CI->plans->get_user_plan($this->CI->user_id);

            // Check if user plan expires soon
            $check_plan = $this->CI->plans->check_if_plan_ended($this->CI->user_id);

            $expires_soon = 0;

            if ( $check_plan ) {

                if ( $check_plan < time() + 432000 ) {

                    $expires_soon = 1;

                }

            }

            // Prepare params
            $params = array(
                'plans' => $get_plans,
                'user_plan' => $user_plan,
                'expires_soon' => $expires_soon,
                'upgrade' => $upgrade
            );

            // Set views params
            set_user_view(
                $this->CI->load->ext_view(
                    MIDRUB_BASE_USER_COMPONENTS_PLANS . 'views',
                    'main',
                    $params,
                    true
                )

            );
        
        }
        
    }
    
}
