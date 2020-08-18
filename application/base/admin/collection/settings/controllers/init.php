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
namespace MidrubBase\Admin\Collection\Settings\Controllers;

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
        
        // Load the component's language files
        $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_SETTINGS);
        
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
        md_set_component_variable('component_slug', 'settings');
        
        // Get the admin's header
        $this->CI->admin_header = admin_header();
        
        // Set styles
        $this->CI->admin_header['component_styles'] = $this->assets_css();
        
        // Making temlate and send data to view.
        if ( $this->CI->input->get('p', TRUE) ) {
            
            switch ( $this->CI->input->get('p', TRUE) ) {
                
                case 'advanced':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('advanced_settings');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'advanced', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                
                case 'users':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('users_settings');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'users', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                
                case 'smtp':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('smtp_settings');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'smtp', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;

                case 'widgets':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('widgets_administrator');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'widgets'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'widgets', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                
                case 'gateways':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('payments_gateways');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    // Define the left sidebar
                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    // Define the required constant
                    defined('MIDRUB_BASE_PAYMENTS') OR define('MIDRUB_BASE_PAYMENTS', APPPATH . 'base/payments/');

                    // Require the payments gateway Inc functions file
                    require_once MIDRUB_BASE_PATH . 'inc/payments/gateways.php';

                    // List all payments gateways
                    foreach (glob(APPPATH . 'base/payments/collection/*', GLOB_ONLYDIR) as $gateway) {

                        // Get the gateway's name
                        $gateway = trim(basename($gateway) . PHP_EOL);

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
                        (new $cl())->load_hooks('admin_init');
            
                    }

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

                                    // Set Body
                                    $this->CI->template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'gateway', array('gateway' => $payment[$gateway_slug[0]]), true);
                                    break;

                                }

                            }

                        }

                        // Verify if body exists
                        if ( !isset($this->CI->template['body']) ) {

                            // If no gateway available show 404
                            show_404();

                        }

                    } else {

                        // Set Body
                        $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'gateways', array(), true);

                    }

                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                    
                case 'affiliates-reports':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('affiliates_reports');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'affiliates_reports', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;  
                    
                case 'affiliates-settings':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('settings');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'affiliates_settings', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;   
                
                case 'api-permissions':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('api_permissions');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'permissions', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                
                case 'api-applications':

                    // Set component's title
                    $this->CI->admin_header['title'] = $this->CI->lang->line('api_apps');

                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

                    $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                        'component' => 'settings'
                    ), true);

                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'apps', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template); 
                    
                    break;
                    
                default:
                    
                    show_404();
                    
                    break;
                    
            }
            
        } else {
        
            // Set component's title
            $this->CI->admin_header['title'] = $this->CI->lang->line('general_settings');

            // Making temlate and send data to view.
            $this->CI->template['header'] = $this->CI->load->view('admin/layout/header', $this->CI->admin_header, true);

            $this->CI->template['left'] = $this->CI->load->view('admin/layout/left', array(
                'component' => 'settings'
            ), true);

            $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS .  'views', 'main', array(), true);
            $this->CI->template['footer'] = $this->CI->load->view('admin/layout/footer', array('component_scripts' => $this->assets_js()), true);
            $this->CI->load->ext_view( MIDRUB_BASE_ADMIN_SETTINGS . 'views/layout', 'index', $this->CI->template);
            
        }
        
    }

    /**
     * The private method assets_css contains the component's css links
     * 
     * @since 0.0.7.6
     * 
     * @return string with css links
     */
    public function assets_css() {
        
        $data = '<link rel="stylesheet" type="text/css" href="' . base_url('assets/base/admin/collection/settings/styles/css/settings.css?ver=' . MIDRUB_BASE_ADMIN_SETTINGS_VERSION) . '" media="all"/> ';
        $data .= "\n";
        
        if ( $this->CI->input->get('p', TRUE) ) {
            
            switch ( $this->CI->input->get('p', TRUE) ) {
                    
                case 'affiliates-reports':
                    
                    $data .= '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" media="all"/> ';
                    $data .= "\n";  
                    
                    break; 
                    
            }
            
        }
        
        return $data;
        
    }
    
    /**
     * The private method assets_js contains the component's javascript links
     * 
     * @since 0.0.7.6
     * 
     * @return string with javascript links
     */
    public function assets_js() {
        
        $data = '<script src="' . base_url('assets/base/admin/collection/settings/js/main.js?ver=' . MIDRUB_BASE_ADMIN_SETTINGS_VERSION) . '"></script>';
        $data .= "\n";
        
        if ( $this->CI->input->get('p', TRUE) ) {
            
            switch ( $this->CI->input->get('p', TRUE) ) {
                    
                case 'affiliates-reports':
                  
                    $data .= '<script src="' . base_url('assets/base/admin/collection/settings/js/referrals.js?ver=' . MIDRUB_BASE_ADMIN_SETTINGS_VERSION) . '"></script>';
                    $data .= "\n";                    
                    $data .= '<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>';
                    $data .= "\n";                   
                    
                    break; 
                
                case 'api-permissions':
                case 'api-applications':
                  
                    $data .= '<script src="' . base_url('assets/base/admin/collection/settings/js/api.js?ver=' . MIDRUB_BASE_ADMIN_SETTINGS_VERSION) . '"></script>';
                    $data .= "\n";                
                    
                    break; 
                    
            }
            
        }        
        
        return $data;
        
    }

}
