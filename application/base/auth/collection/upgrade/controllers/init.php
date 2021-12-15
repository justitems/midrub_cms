<?php
/**
 * Init Controller
 *
 * This file loads the Upgrade Auth Component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Upgrade\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// General functions
require_once CMS_BASE_AUTH_UPGRADE . 'inc/general.php';

/*
 * Init class loads the Upgrade Component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load the component's language files
        $this->CI->lang->load( 'auth_upgrade', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_UPGRADE );

        // Load Coupons Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_referrals', 'base_referrals' );
        
    }
    
    /**
     * The public method view loads the settings's template
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function view() {

        // If session exists, redirect user
        if ( !md_the_user_session() ) {
            redirect('/');
        }

        // Get component's title
        $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):$this->CI->lang->line('upgrade_page_title');

        // Set page's title
        md_set_the_title($title);

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/upgrade/styles/css/styles.css?ver=' . CMS_BASE_AUTH_UPGRADE_VERSION), 'text/css', 'all'));

        // Set Font Awesome Styles
        md_set_css_urls(array('stylesheet', '//use.fontawesome.com/releases/v5.2.0/css/all.css', 'text/css', 'all'));             

        // Set Simple Line Icons Styles
        md_set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css', 'text/css', 'all'));        

        // Set javascript links
        md_set_js_urls(array(base_url('assets/base/auth/collection/upgrade/js/main.js?ver=' . CMS_BASE_AUTH_UPGRADE_VERSION)));

        // Verify if meta description exists
        if ( md_the_single_content_meta('quick_seo_meta_description') ) {

            // Set meta description
            md_set_the_meta_description(md_the_single_content_meta('quick_seo_meta_description'));

        }

        // Verify if meta keywords exists
        if ( md_the_single_content_meta('quick_seo_meta_keywords') ) {

            // Set meta keywors
            md_set_the_meta_keywords(md_the_single_content_meta('quick_seo_meta_keywords'));

        }

        /**
         * The public method md_set_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_set_hook(
            'the_frontend_header',
            function () {

                // Get header code
                $header = md_the_option('frontend_header_code');

                // Verify if header code exists
                if ( $header ) {

                    // Show code
                    echo $header;

                }

                echo "<!-- Bootstrap CSS -->\n";
                echo "    <link rel=\"stylesheet\" href=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css\">\n";

            }
        );

        /**
         * The public method md_set_hook registers a hook
         * 
         * @since 0.0.7.8
         */
        md_set_hook(
            'the_frontend_footer',
            function () {

                // Get footer code
                $footer = md_the_option('frontend_footer_code');

                // Verify if footer code exists
                if ( $footer ) {

                    // Show code
                    echo $footer;

                }

                echo "<script src=\"" . base_url("assets/js/jquery.min.js") . "\"></script>\n";
                echo "<script src=\"//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js\"></script>\n";
                echo "<script src=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>\n";
                echo "<script src=\"" . base_url("assets/js/main.js?ver=" . MD_VER) . "\"></script>\n";

            }

        );

        // Verify if single page exists
        if ( $this->CI->input->get('p', TRUE) ) {

            switch ( $this->CI->input->get('p', TRUE) ) {

                case 'gateways':

                    // Get the user's plan
                    $plan_id = md_the_user_option($this->CI->user_id, 'plan');
                
                    // Verify if plan exists
                    if ( is_numeric( $plan_id ) ) {

                        // Get plan
                        $plan = $this->CI->plans->get_plan($plan_id);

                        // Verify if plan exists
                        if ( $plan ) {

                            // Get plan's data
                            $plan_data = $this->CI->plans->get_plan_price($plan_id);

                            if ($plan_data[0]->plan_price > 0) {

                                // Delete the user coupon code
                                $this->CI->user->delete_user_option($this->CI->user_id, 'user_coupon_code');

                                // Delete the user discount value
                                $this->CI->user->delete_user_option($this->CI->user_id, 'user_coupon_value');

                                // Define the required constant
                                defined('CMS_BASE_PAYMENTS') OR define('CMS_BASE_PAYMENTS', APPPATH . 'base/payments/');

                                // Require the payments gateway Inc functions file
                                require_once CMS_BASE_PATH . 'inc/payments/gateways.php';

                                // List all payments gateways
                                foreach (glob(APPPATH . 'base/payments/collection/*', GLOB_ONLYDIR) as $gateway) {

                                    // Get the gateway's name
                                    $gateway = trim(basename($gateway) . PHP_EOL);

                                    // Verify if the gateway is enabled
                                    if ( !md_the_option($gateway) ) {
                                        continue;
                                    }

                                    // Create an array
                                    $array = array(
                                        'CmsBase',
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

                                // Making temlate and send data to view.
                                $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views/layout', 'header', array(), true);
                                $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views', 'gateways', $params, true);
                                $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views/layout', 'footer', array(), true);
                                $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE . 'views/layout', 'index', $this->CI->template);

                            }

                        } else {
                            show_404();
                        }

                    } else {
                        show_404();
                    }

                    break;  
                    
                case 'success':
                    
                    // Get complete transaction
                    $complete_transaction = the_complete_transaction();

                    // Verify if complete transaction exists
                    if ( $complete_transaction ) {

                        // Get transaction's data
                        $transaction_data = $this->CI->base_model->the_data_where('transactions', '*', 
                            array(
                                'user_id' => $this->CI->user_id,
                                'transaction_id' => $complete_transaction['transaction_id']
                            )
                        );

                        // Verify if transaction exists
                        if ( $transaction_data ) {

                            // Verify if the transaction is success
                            if ( $transaction_data[0]['status'] === '1' ) {

                                // Remove the unpaid option
                                md_delete_user_option($this->CI->user_id, 'nonpaid');

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

                                            // Verify if Referrals are enabled
                                            if ( md_the_option('enable_referral') ) {

                                                // Get referral data
                                                $referral = $this->CI->base_referrals->get_referral($this->CI->user_id);

                                                // Verify if referrer exists
                                                if ( $referral ) {

                                                    // Verify if referrer already earned
                                                    if ( $referral[0]->earned < 1 ) {

                                                        // Verify if the referrals_exact_gains option is enabled
                                                        if ( md_the_option('referrals_exact_gains') ) {

                                                            // Get the referrals_exact_revenue value
                                                            $the_plan_meta = $this->CI->base_model->the_data_where('plans_meta', 'meta_value AS referrals_exact_revenue', array(
                                                                'plan_id' => $options['plan_id'],
                                                                'meta_name' => 'referrals_exact_revenue'
                                                            ));

                                                            // Verify if the referrals_exact_revenue value exists
                                                            if ( !empty($the_plan_meta) ) {

                                                                // Verify if the referrals_exact_revenue value is numeric
                                                                if ( is_numeric($the_plan_meta[0]['referrals_exact_revenue']) ) {
                                                                    
                                                                    // Add referral earning
                                                                    $this->CI->base_referrals->add_earnings_to_referral($this->CI->user_id, $options['plan_id'], $the_plan_meta[0]['referrals_exact_revenue']);
                                                                    
                                                                }                                                        

                                                            }
                                                            
                                                        } else {

                                                            // Get the referrals_percentage_revenue value
                                                            $the_plan_meta = $this->CI->base_model->the_data_where('plans_meta', 'meta_value AS referrals_percentage_revenue', array(
                                                                'plan_id' => $options['plan_id'],
                                                                'meta_name' => 'referrals_percentage_revenue'
                                                            ));

                                                            // Verify if the referrals_percentage_revenue value exists
                                                            if ( !empty($the_plan_meta) ) {

                                                                // Verify if the referrals_percentage_revenue value is numeric
                                                                if ( is_numeric($the_plan_meta[0]['referrals_percentage_revenue']) ) {

                                                                    // Calculate percentage
                                                                    $total = number_format( ( ($the_plan_meta[0]['referrals_percentage_revenue'] / 100) * $complete_transaction['amount']), 2);   
                                                                    
                                                                    // Add referral earning
                                                                    $this->CI->base_referrals->add_earnings_to_referral($this->CI->user_id, $options['plan_id'], $total);
                                                                    
                                                                }                                                        

                                                            }
                                                            
                                                        }
                            
                                                    }
                            
                                                }
                                            
                                            }

                                        }

                                        // Verify if the discount code exists
                                        if ( isset($options['discount_code']) ) {

                                            // Search for coupon
                                            $coupon = $this->CI->base_model->the_data_where('coupons', '*', array(
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

                                // Redirect to login page
                                redirect(md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin'));
                                
                            }

                        }

                    }

                    // Show the 404 error
                    show_404();

                    break;  

                default:

                    // Show the 404 error
                    show_404();

                    break;

            }

        } else {

            // Get the user's plan
            $plan_id = md_the_user_option($this->CI->user_id, 'plan');

            // Get plan's data
            $plan_data = $this->CI->base_model->the_data_where('plans', 'plan_id,plan_price,currency_sign', array('plan_id' => $plan_id));

            // Verify if plan exists
            if ( !$plan_data ) {

                // Show the 404 error
                show_404();

            }

            // Making temlate and send data to view.
            $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views/layout', 'header', array(), true);
            $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views', 'coupon-code', array(
                'plan_data' => $plan_data
            ), true);
            $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE .  'views/layout', 'footer', array(), true);
            $this->CI->load->ext_view(CMS_BASE_AUTH_UPGRADE . 'views/layout', 'index', $this->CI->template);

        }
        
    }

}
