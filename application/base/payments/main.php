<?php
/**
 * Midrub Base Payments
 *
 * This file loads the Midrub's Base Payments
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Payments;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_PAYMENTS') OR define('MIDRUB_BASE_PAYMENTS', APPPATH . 'base/payments/');

// Require the general Inc file
require_once MIDRUB_BASE_PAYMENTS . 'inc/general.php';

// Define the namespaces to use
use Exception;
use MidrubBase\Payments\Classes as MidrubBasePaymentsClasses;

/*
 * Main is the Payments's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Main {

    /**
     * Class variables
     *
     * @since 0.0.8.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.0
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method init loads the admin's components
     * 
     * @since 0.0.8.0
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * 
     * @return void
     */
    public function init( $static_slug, $dynamic_slug=NULL ) {

        // Verify the dynamic's slug is not null
        if ( !$dynamic_slug ) {

            // Detect which $static_slug is
            switch ( $static_slug ) {

                case 'cron-job':

                    // Load cron's jobs
                    $this->cron_jobs();

                    break;

                default:

                    // Display 404 page
                    show_404();

                    break;                    

            }

        } else {

            // Verify if $dynamic_slug exists
            if ( file_exists(MIDRUB_BASE_PAYMENTS . 'collection/' . $static_slug . '/main.php' ) ) {

                try {

                    // Create an array
                    $array = array(
                        'MidrubBase',
                        'Payments',
                        'Collection',
                        ucfirst($static_slug),
                        'Main'
                    );

                    // Implode the array above
                    $cl = implode('\\', $array);

                    // Get method
                    (new $cl())->$dynamic_slug();

                    // Load view
                    $this->load_view();


                } catch (Exception $e) {
                    
                    // Display 404 page
                    show_404();
                    
                }

            } else {

                // Display 404 page
                show_404();
                
            }

        }
        
    }

    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @since 0.0.8.0
     * 
     * @param string $gateway contains the gateway's name
     * 
     * @return void
     */
    public function ajax_init($gateway) {

        // Verify if gateway exists
        if ( file_exists(MIDRUB_BASE_PAYMENTS . 'collection/' . $gateway . '/main.php') ) {

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

            // Instantiate the component's view
            (new $cl())->ajax();

        }
        
    }

    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function cron_jobs() {

        // List all payments gateways
        foreach (glob(MIDRUB_BASE_PAYMENTS . 'collection/*', GLOB_ONLYDIR) as $gateway) {

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

            // Run cron job
            (new $cl())->cron_jobs();

        }

    }

    /**
     * The private method load_view loads user's theme
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function load_view() {

        // Load the theme
        md_include_component_file(MIDRUB_BASE_PAYMENTS . 'themes/default/main.php');
        
    }

}

/* End of file main.php */