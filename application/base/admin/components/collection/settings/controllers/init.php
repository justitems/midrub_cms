<?php
/**
 * Init Controller
 *
 * This file loads the Settings Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Settings Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.6
 */
class Init {
    
    /**
     * Class variables
     *
     * @since 0.0.7.6
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.6
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method view loads the settings's template
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function view() {

        // Set the component's slug
        md_set_data('component_slug', 'settings');

        // Set Main Settings CSS file
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/settings/styles/css/settings.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION), 'text/css', 'all'));
        
        // Set Main Settings JS file
        md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/main.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));
        
        // Making temlate and send data to view.
        if ( $this->CI->input->get('p', TRUE) ) {
            
            switch ( $this->CI->input->get('p', TRUE) ) {
                
                case 'advanced':

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'advanced',
                            array(),
                            true
                        )

                    );
                    
                    break;
                
                case 'users':

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'users',
                            array(),
                            true
                        )

                    );
                    
                    break;

                case 'storage':

                    // Set Storage JS file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/storage.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'storage',
                            array(),
                            true
                        )

                    );
                    
                    break;
                
                case 'smtp':

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'smtp',
                            array(),
                            true
                        )

                    );
                    
                    break;
                
                case 'gateways':

                    // Enable gateways
                    md_set_data('hook', 'payments');

                    // Define the required constant
                    defined('CMS_BASE_PAYMENTS') OR define('CMS_BASE_PAYMENTS', APPPATH . 'base/payments/');

                    // Require the payments gateway Inc functions file
                    require_once CMS_BASE_PATH . 'inc/payments/gateways.php';

                    // List all payments gateways
                    foreach (glob(APPPATH . 'base/payments/collection/*', GLOB_ONLYDIR) as $gateway) {

                        // Get the gateway's name
                        $gateway = trim(basename($gateway) . PHP_EOL);

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
                        (new $cl())->load_hooks('admin_init');
            
                    }

                    // Gateway array
                    $gateway = array();

                    // Verify if the payment gateway exists
                    if ( $this->CI->input->get('gateway', true) ) {

                        // Verify if payments gateways exists
                        if ( md_the_gateways() ) {

                            // List all payments gateways
                            foreach (md_the_gateways() as $payment) {

                                // Get gateway slug
                                $gateway_slug = array_keys($payment);

                                // Verify if the gateway is the required from url
                                if ( $gateway_slug[0] === $this->CI->input->get('gateway', true) ) {

                                    // Set gateway
                                    $gateway = array('gateway' => $payment[$gateway_slug[0]]);
                                    break;

                                }

                            }

                        }

                        // Verify if gateway array is not empty
                        if ( $gateway ) {

                            // Set views params
                            set_admin_view(

                                $this->CI->load->ext_view(
                                    CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                                    'gateway',
                                    $gateway,
                                    true
                                )

                            );

                        } else {

                            // If no gateway available show 404
                            show_404();                            

                        }

                    } else {

                        // Set views params
                        set_admin_view(

                            $this->CI->load->ext_view(
                                CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                                'gateways',
                                array(),
                                true
                            )

                        );

                    }
                    
                    break;

                case 'coupon-codes':

                    // Load Referrals Model
                    $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_codes', 'base_codes' );

                    // Set Coupon Codes JS file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/coupon-codes.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));                       

                    // Create the alert message
                    $alert = '';
                    
                    // Check if data was submitted
                    if ( $this->CI->input->post() ) {
                        
                        // Add form validation
                        $this->CI->form_validation->set_rules('value', 'Value', 'trim|numeric|required');
                        $this->CI->form_validation->set_rules('type', 'Type', 'trim');
                        
                        // get data
                        $value = $this->CI->input->post('value');
                        $type = $this->CI->input->post('type');
                        
                        // Verify if the sent data is correct
                        if ( $this->CI->form_validation->run() == false ) {
                            
                            // Set error message
                            $alert = array('error', $this->CI->lang->line('settings_coupon_code_was_not_created'));
                            
                        } else {
                            
                            // Try to save the button
                            if ( $this->CI->base_codes->save_coupon( $value, $type ) ) {
                                
                                // Set success message
                                $alert = array('success', $this->CI->lang->line('settings_coupon_code_was_created'));
                                
                            } else {
                                
                                // Set error message
                                $alert = array('error', $this->CI->lang->line('settings_coupon_code_was_not_created'));
                                
                            }
                            
                        }
                        
                    }              

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'coupon_codes',
                            array(
                                'alert' => $alert
                            ),
                            true
                        )

                    );
                    
                    break;                      
                    
                case 'affiliates-reports':

                    // Set Bootstrap Picker CSS file
                    md_set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css', 'text/css', 'all'));

                    // Set Referrals JS file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/referrals.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));

                    // Set Bootstrap Picker JS file
                    md_set_js_urls(array('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js'));                    

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'affiliates_reports',
                            array(),
                            true
                        )

                    );
                    
                    break;  
                    
                case 'affiliates-settings':

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'affiliates_settings',
                            array(),
                            true
                        )

                    );                    
                    
                    break;   
                
                case 'api-permissions':

                    // Set Api JS file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/api.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'permissions',
                            array(),
                            true
                        )

                    );
                    
                    break;
                
                case 'api-applications':

                    // Set Api JS file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/settings/js/api.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_SETTINGS_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                            'apps',
                            array(),
                            true
                        )

                    );
                    
                    break;
                    
                default:
                    
                    show_404();
                    
                    break;
                    
            }
            
        } else {

            // Set views params
            set_admin_view(

                $this->CI->load->ext_view(
                    CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'views',
                    'main',
                    array(),
                    true
                )

            );
            
        }
        
    }

}

/* End of file init.php */