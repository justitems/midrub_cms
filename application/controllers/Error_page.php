<?php
/**
 * Error_page Controller
 *
 * PHP Version 7.3
 *
 * Error_page contains the Error_page class to display errors page
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
 * Error_page class - contains the method to display errors page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Error_page extends CI_Controller {
    
    /**
     * Class variables
     */   
    public $user_id, $user_role, $user_email;
    
    /**
     * Initialise the Base controller
     */
    public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');

        // Require the base class
        $this->load->file(APPPATH . 'base/main.php');

        // Require the User General Inc
        require_once CMS_BASE_PATH . 'user/inc/general.php';
        
        // Verify if username exists
        if ( isset( $this->session->userdata['username'] ) ) {

            // Load Base Model
            $this->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_model', 'base_model' );            

            // Load Base Users Model
            $this->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_users', 'base_users');

            // Load Base Plans Model
            $this->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );            

            // Get user data
            $user_data = $this->base_users->get_user_data_by_username($this->session->userdata['username']);

            // Verify if user exists
            if ( $user_data ) {

                // Set user_id
                $this->user_id = $user_data[0]->user_id;

                // Set user_role
                $this->user_role = $user_data[0]->role;

                // Set user_email
                $this->user_email = $user_data[0]->email;

                // Get user language
                $user_lang = md_the_user_option($this->user_id, 'user_language');

                // Verify if user has selected a language
                if ($user_lang) {

                    // Set user's language
                    $this->config->set_item('language', $user_lang);

                }     

            }
            
        }

        // Default Errors Language
        $this->lang->load( 'default_errors', $this->config->item('language') );
        
    }
    
    /**
     * The public method show_error displays an error's page
     * 
     * @param string $type contains the error's type
     * 
     * @return void
     */
    public function show_error($type) {
        
        switch ( $type ) {

            case 'no-user-theme':

                // Load the no user theme view
                $this->load->ext_view(APPPATH . 'views/errors/html', 'no_user_theme', array());

                break;

            case 'maintenance':

                // Load the maintenance view
                $this->load->ext_view(APPPATH . 'views/errors/html', 'maintenance', array());

                break;

            case 'subscription-expired':

                // Verify if user's id exists
                if ( $this->user_id ) {

                    // Load Base Model
                    $this->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_users', 'base_users');

                    // Get user data
                    $user_data = $this->base_users->get_user_data_by_username($this->session->userdata['username']);

                    // Verify if the user's plan is not expired
                    if ( (strtotime(md_the_user_option($this->user_id, 'plan_end')) + 86400) > time() ) {

                        // Display 404 page
                        show_404();
                        
                    }

                    // Get the user's plan
                    $user_plan = md_the_user_option($this->user_id, 'plan');

                    // Verify if user's plan exists
                    if ( !$user_plan ) {

                        // Display 404 page
                        show_404();

                    }

                    // Get the plan
                    $the_plan = $this->base_model->the_data_where(
                        'plans',
                        '*',
                        array(
                            'plan_id' => $user_plan
                        )
                    );

                    // Verify if user's plan exists
                    if ( !$the_plan ) {

                        // Display 404 page
                        show_404();

                    }

                    // Verify if single page exists
                    if ( $this->input->get('p', TRUE) ) {

                        switch ( $this->input->get('p', TRUE) ) {

                            case 'order':

                                // Set plan's id
                                $plan_id = $this->input->get('plan', TRUE);

                                // Get the plan
                                $plan_data = $this->base_model->the_data_where(
                                    'plans',
                                    '*',
                                    array(
                                        'plan_id' => $plan_id
                                    )
                                );
                            
                                // Verify if plan exists
                                if ( $plan_data ) {

                                    // Verify if the plan is hidden
                                    if ( !empty($plan_data[0]['visible']) ) {

                                        // Verify if user has already this plan
                                        if ( $plan_data[0]['plan_id'] !== $user_plan ) {

                                            // Display 404 page
                                            show_404();                                            

                                        }

                                    }

                                    // Verify if the plan's price is free
                                    if ( (int)$plan_data[0]['plan_price'] > 0 ) {

                                        // Set the layout's content
                                        $params = array(
                                            'plan_id' => $plan_id,
                                            'plan_data' => $plan_data
                                        );

                                        // Set views params
                                        $this->load->ext_view(APPPATH . 'views/errors/html', 'coupon_code', $params);

                                    } else {

                                        // Change user's plan
                                        if ( $this->base_plans->change_plan(array(
                                                'plan_id' => $plan_id,
                                                'user_id' => $this->user_id,
                                                'period' => $plan_data[0]['period'],
                                                'plan_end' => md_the_user_option($this->user_id, 'plan_end')
                                            )) ) {

                                            // Verify if user has renewed the subscription
                                            if ( $user_plan === $plan_id ) {

                                                // Set renew's success message
                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_renewed'));

                                            } else {

                                                // Set upgrade's success message
                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_upgraded'));

                                            }

                                            // We need to delete the previous subscription
                                            $subscriptions = $this->base_model->the_data_where('subscriptions', '*', array(
                                                'user_id' => $this->user_id
                                            ));

                                            // Verify if old subscribtions exists
                                            if ( $subscriptions ) {

                                                // List all subscriptions
                                                foreach ( $subscriptions as $subscription ) {
                                                    
                                                    // Create an array
                                                    $array = array(
                                                        'CmsBase',
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
                                                $this->base_model->delete('subscriptions', array(
                                                    'user_id' => $this->user_id,
                                                ) );

                                            }

                                        } else {

                                            // Verify if user has tried to renew the subscription
                                            if ( $user_plan === $plan_id ) {

                                                // Set renew's error message
                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_not_renewed'));

                                            } else {

                                                // Set upgrade's error message
                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_not_upgraded'));

                                            }

                                        }

                                        // Redirect
                                        $this->redirect_to_login();

                                    }

                                } else {

                                    // Display 404 page
                                    show_404();

                                }

                                break;

                            case 'pay':

                                // Set plan's id
                                $plan_id = $this->input->get('plan', TRUE);

                                // Get the plan
                                $plan_data = $this->base_model->the_data_where(
                                    'plans',
                                    '*',
                                    array(
                                        'plan_id' => $plan_id
                                    )
                                );
                            
                                // Verify if plan exists
                                if ( $plan_data ) {

                                    // Verify if the plan is hidden
                                    if ( !empty($plan_data[0]['visible']) ) {

                                        // Verify if user has already this plan
                                        if ( $plan_data[0]['plan_id'] !== $user_plan ) {

                                            // Display 404 page
                                            show_404();                                            

                                        }

                                    }

                                    // Define the required constant
                                    defined('CMS_BASE_PAYMENTS') OR define('CMS_BASE_PAYMENTS', APPPATH . 'base/payments/');

                                    // General functions
                                    require_once CMS_BASE_PATH . 'user/components/collection/plans/inc/general.php';

                                    // Require the payments gateway Inc functions file
                                    require_once CMS_BASE_PATH . 'inc/payments/gateways.php';

                                    // Verify if the plan's price is free
                                    if ( (int)$plan_data[0]['plan_price'] > 0 ) {

                                        // Set the layout's content
                                        $params = array(
                                            'plan_id' => $plan_id,
                                            'plan_data' => $plan_data
                                        );

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
                                            
                                            // Set current component
                                            set_global_variable('component', 'plans');

                                            // Get method
                                            (new $cl())->load_hooks('user_init');

                                        }

                                        // Set the layout's content
                                        $params = array(
                                            'plan_id' => $plan_id,
                                            'plan_data' => $plan_data
                                        );

                                        // Get discount if exists
                                        $discount = $this->session->flashdata('transaction_discount');

                                        // Verify if discount exists
                                        if ($discount) {

                                            // Calculate total discount
                                            $total = ($plan_data[0]['plan_price'] / 100) * $discount['discount_value'];

                                            // Set new price
                                            $params['plan_data'][0]['plan_price'] = number_format(($plan_data[0]['plan_price'] - $total), 2);

                                            // Set discount
                                            $params['discount'] = $discount['discount_value'];

                                            // Set discount code
                                            $params['discount_code'] = $discount['discount_code'];

                                        }

                                        // Set views params
                                        $this->load->ext_view(APPPATH . 'views/errors/html', 'gateways', $params);

                                    } else {

                                        // Display 404 page
                                        show_404();
                                    
                                    }

                                } else {

                                    // Display 404 page
                                    show_404();

                                }

                                break;

                            default:

                                // Display 404 page
                                show_404();

                                break;

                        }

                    } else {

                        // Upgrade container
                        $upgrade = '';

                        // Verify if flash data exists
                        if ( $this->session->flashdata('complete_transaction') ) {

                            // Get complete transaction
                            $transaction = $this->session->flashdata('complete_transaction');

                            // Verify if transaction's ID exists
                            if ( isset($transaction['transaction_id']) ) {

                                // Verify if transaction's ID is numeric
                                if ( is_numeric($transaction['transaction_id']) ) {

                                    // Try to find the transaction
                                    $get_transaction = $this->base_model->the_data_where('transactions', 'transactions.*, users.username', array('transactions.transaction_id' => $transaction['transaction_id'], 'transactions.user_id' => $this->user_id),
                                        array(),
                                        array(),
                                        array(array(
                                            'table' => 'users',
                                            'condition' => 'transactions.user_id=users.user_id',
                                            'join_from' => 'LEFT'
                                        ))
                                    );

                                    // Verify if the transaction exists
                                    if ( $get_transaction ) {

                                        // Transaction array
                                        $transaction = array(
                                            'transaction_id' => $get_transaction[0]['transaction_id'],
                                            'user_id' => $get_transaction[0]['user_id'],
                                            'net_id' => $get_transaction[0]['net_id'],
                                            'amount' => $get_transaction[0]['amount'],
                                            'currency' => $get_transaction[0]['currency'],
                                            'gateway' => $get_transaction[0]['gateway'],
                                            'status' => $get_transaction[0]['status'],
                                            'created' => $get_transaction[0]['created'],
                                            'username' => $get_transaction[0]['username'],
                                        );

                                        // Try to find the transaction's fields
                                        $fields = $this->base_model->the_data_where('transactions_fields', '*', array('transaction_id' => $transaction['transaction_id']));
                                        
                                        // Verify if the transaction has fields
                                        if ( $fields ) {

                                            // Set fields key
                                            $transaction['fields'] = array();

                                            // List all fields
                                            foreach ( $fields as $field ) {

                                                // Set field
                                                $transaction['fields'][] = array(
                                                    'field_name' => $field['field_name'],
                                                    'field_value' => $field['field_value']
                                                );

                                            }

                                        }

                                        // Try to find the transaction's options
                                        $options = $this->base_model->the_data_where('transactions_options', '*', array('transaction_id' => $transaction['transaction_id']));
                                        
                                        // Verify if the transaction has options
                                        if ( $options ) {

                                            // Set options key
                                            $transaction['options'] = array();

                                            // List all options
                                            foreach ( $options as $option ) {

                                                // Set option
                                                $transaction['options'][] = array(
                                                    'option_name' => $option['option_name'],
                                                    'option_value' => $option['option_value']
                                                );

                                            }

                                        }

                                        // Verify if options exists
                                        if ( !empty($transaction['options']) ) {

                                            // Options array
                                            $options = array();

                                            // List all transaction's options
                                            foreach ( $transaction['options'] as $option ) {

                                                // Set option
                                                $options[$option['option_name']] = $option['option_value'];
                                                
                                            }
                                            
                                            // Verify if options exists
                                            if ( $options ) {

                                                // Verify if plan's ID exists
                                                if ( isset($options['plan_id']) ) {

                                                    // Get the user's plan
                                                    $user_plan = md_the_user_option($this->user_id, 'plan');

                                                    // Get the plan
                                                    $plan_data = $this->base_model->the_data_where(
                                                        'plans',
                                                        '*',
                                                        array(
                                                            'plan_id' => $options['plan_id']
                                                        )
                                                    );

                                                    // Verify if the plan exists
                                                    if ( $plan_data ) {

                                                        // Change user's plan
                                                        if ( $this->base_plans->change_plan(array(
                                                            'plan_id' => $options['plan_id'],
                                                            'user_id' => $this->user_id,
                                                            'period' => $plan_data[0]['period']
                                                            )) ) {

                                                            // Verify if user has renewed the subscription
                                                            if ( $user_plan === $options['plan_id'] ) {

                                                                // Set renew's success message
                                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_renewed'));

                                                            } else {

                                                                // Set upgrade's success message
                                                                $this->session->set_flashdata('plans_change_message', $this->lang->line('default_errors_was_upgraded'));

                                                                // Verify if Referrals are enabled
                                                                if ( md_the_option('enable_referral') ) {

                                                                    // Get referral data
                                                                    $referral = $this->referrals->get_referral($this->user_id);

                                                                    // Verify if referrer exists
                                                                    if ( $referral ) {
                                                
                                                                        // Verify if referrer already earned
                                                                        if ( $referral[0]->earned < 1 ) {
                                                                            
                                                                            // Verify if the referrals_exact_gains option is enabled
                                                                            if ( md_the_option('referrals_exact_gains') ) {

                                                                                // Get the referrals_exact_revenue value
                                                                                $the_plan_meta = $this->base_model->the_data_where('plans_meta', 'meta_value AS referrals_exact_revenue', array(
                                                                                    'plan_id' => $options['plan_id'],
                                                                                    'meta_name' => 'referrals_exact_revenue'
                                                                                ));

                                                                                // Verify if the referrals_exact_revenue value exists
                                                                                if ( !empty($the_plan_meta) ) {

                                                                                    // Verify if the referrals_exact_revenue value is numeric
                                                                                    if ( is_numeric($the_plan_meta[0]['referrals_exact_revenue']) ) {
                                                                                        
                                                                                        // Add referral earning
                                                                                        $this->referrals->add_earnings_to_referral($this->user_id, $options['plan_id'], $the_plan_meta[0]['referrals_exact_revenue']);
                                                                                        
                                                                                    }                                                        

                                                                                }
                                                                                
                                                                            } else {

                                                                                // Get the referrals_percentage_revenue value
                                                                                $the_plan_meta = $this->base_model->the_data_where('plans_meta', 'meta_value AS referrals_percentage_revenue', array(
                                                                                    'plan_id' => $options['plan_id'],
                                                                                    'meta_name' => 'referrals_percentage_revenue'
                                                                                ));

                                                                                // Verify if the referrals_percentage_revenue value exists
                                                                                if ( !empty($the_plan_meta) ) {

                                                                                    // Verify if the referrals_percentage_revenue value is numeric
                                                                                    if ( is_numeric($the_plan_meta[0]['referrals_percentage_revenue']) ) {

                                                                                        // Calculate percentage
                                                                                        $total = number_format( ( ($the_plan_meta[0]['referrals_percentage_revenue'] / 100) * $transaction['amount']), 2);   
                                                                                        
                                                                                        // Add referral earning
                                                                                        $this->referrals->add_earnings_to_referral($this->user_id, $options['plan_id'], $total);
                                                                                        
                                                                                    }                                                        

                                                                                }
                                                                                
                                                                            }
                                                
                                                                        }
                                                
                                                                    }
                                                                
                                                                }

                                                            }

                                                            // Redirect
                                                            $this->redirect_to_login();

                                                        } else {

                                                            // Verify if user has renewed the subscription
                                                            if ( $user_plan === $options['plan_id'] ) {

                                                                // Set renew's error message
                                                                $upgrade = $this->lang->line('default_errors_was_not_renewed');                                    
                                                                
                                                            } else {

                                                                // Set upgrade's error message
                                                                $upgrade = $this->lang->line('default_errors_was_not_upgraded');

                                                            }

                                                        }

                                                    }

                                                }

                                                // Verify if the discount code exists
                                                if ( isset($options['discount_code']) ) {

                                                    // Search for coupon
                                                    $coupon = $this->base_model->the_data_where('coupons', '*', array(
                                                        'code' => $this->security->xss_clean($options['discount_code'])
                                                    ));

                                                    // Verify if coupon exists
                                                    if ( $coupon ) {

                                                        // Update count
                                                        $this->base_model->update('coupons', array(
                                                            'coupon_id' => $coupon[0]['coupon_id']
                                                        ), array(
                                                            'count' => ($coupon[0]['count'] + 1)
                                                        ));

                                                    }

                                                }

                                            }

                                        }

                                    }

                                }

                            }

                        }

                        // Verify if user has changed to a free plan
                        if ( $this->session->flashdata('plans_change_message') ) {

                            // Set upgrade's message
                            $upgrade = $this->session->flashdata('plans_change_message');
                            
                        }

                        // Get the public plans
                        $the_plans = $this->base_plans->the_public_plans();

                        // Plans texts container
                        $plans_texts = array();

                        // Verify if public plans exists
                        if ( $the_plans ) {
                            
                            // Plans ids container
                            $plans_ids = array();

                            // Verify if plans groups missing
                            if ( empty($the_plans[0]['plans']) ) {

                                // List all plans
                                foreach ($the_plans as $plan) {
                                    
                                    // Set plan's id to the group
                                    $plans_ids[] = $plan['plan_id'];
                                    
                                }
                            
                            } else if ( !empty($the_plans[0]['plans']) ) {
                            
                                // List groups
                                foreach ( $the_plans as $group ) {
                            
                                    // List all plans
                                    foreach ($group['plans'] as $plan) {
                                        
                                        // Set plan's id to the group
                                        $plans_ids[] = $plan['plan_id'];
                            
                                    }
                            
                                }
                            
                            }

                            // Verify if plans exists
                            if ( $plans_ids ) {

                                // Get the texts
                                $the_texts = $this->base_model->the_data_where(
                                    'plans_texts',
                                    '*',
                                    array(),
                                    array(
                                        'plan_id', $plans_ids
                                    )
                                );
                                
                                // Verify if texts exists
                                if ( $the_texts ) {

                                    // Group the texts
                                    $texts = array_reduce($the_texts, function($accumulator, $plan) {

                                        // Verify if plan's key exists
                                        if ( !isset($accumulator[$plan['plan_id']]) ) {
                                            $accumulator[$plan['plan_id']] = array();
                                        }
                                        
                                        // Set plan
                                        $accumulator[$plan['plan_id']][] = $plan;

                                        return $accumulator;

                                    }, []);

                                    // Verify if texts exists
                                    if ( $texts ) {

                                        // Set texts to response
                                        $plans_texts = $texts;

                                    }

                                }

                            }

                        }
                        
                        // Set params
                        $params = array(
                            'plan' => $the_plan[0],
                            'plans' => $the_plans,
                            'plans_texts' => $plans_texts,
                            'upgrade' => $upgrade,
                            'user_data' => $user_data[0]
                        );

                        // Load the subscription expired view
                        $this->load->ext_view(APPPATH . 'views/errors/html', 'subscription_expired', $params);  
                        
                    }

                } else {

                    // Display 404 page
                    show_404();

                }

                break;                

        }
        
    }  

    /**
     * The protected method redirect_to_login redirects user to the login page
     * 
     * @return void
     */
    protected function redirect_to_login() {

        // Set sign in url
        $sign_in = site_url('auth/signin');

        // Get selected pages
        $selected_pages = md_the_data('selected_pages_by_role');

        if ( !$selected_pages ) {

            // Load Base Contents Model
            $this->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_contents', 'base_contents');

            // Get selected pages by role
            $selected_pages = $this->base_contents->the_contents_by_meta_name('selected_page_role');

            // Set pages
            md_set_data('selected_pages_by_role', $selected_pages);
        
        }

        if ( $selected_pages ) {

            foreach ( $selected_pages as $selected_page ) {

                if ( $selected_page['meta_value'] === 'settings_auth_' . $type . '_page' ) {

                    $sign_in = site_url($selected_page['contents_slug']);

                }

            }

        }

        // Redirect
        redirect($sign_in);

    }
    
}

/* End of file Error.php */
