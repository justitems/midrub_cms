<?php
/**
 * Base Controller
 *
 * PHP Version 7.3
 *
 * Base will load soon all Midrub's content
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the General Inc
require_once APPPATH . 'base/inc/general.php';

/**
 * Base class - loads the Midrub's content
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Base extends CI_Controller {
    
    /**
     * Class variables
     */   
    public $user_id, $user_role;
    
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

        // Verify if the database is configured
        if ( empty($this->db->database) ) {
            $this->install();
        }     
        
    }
    
    /**
     * The public method init loads base's data
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * @param string $identifier_slug contains an identifier for the additional's slug
     * 
     * @return void
     */
    public function init($static_slug=NULL, $dynamic_slug=NULL, $additional_slug=NULL, $identifier_slug=NULL) {

        if ( defined('cron') ) {
            return false;
        }
        
        $static_slug = ($static_slug)?urlencode($static_slug):NULL;
        $dynamic_slug = ($dynamic_slug)?urlencode($dynamic_slug):NULL;
        $additional_slug = ($additional_slug)?urlencode($additional_slug):NULL;
        $identifier_slug = ($identifier_slug)?urlencode($identifier_slug):NULL;

        // Require the base class
        $this->load->file(APPPATH . '/base/main.php');

        $this->load->ext_model( APPPATH . 'base/models/', 'Base_model', 'base_model' );        

        // Verify if static or dynamic slug is ajax
        if ( ($static_slug === 'theme-ajax')|| 
            ($dynamic_slug === 'theme-ajax') || 
            ($static_slug === 'ajax') || 
            ($dynamic_slug === 'ajax') || 
            ($dynamic_slug === 'app-ajax') || 
            ($dynamic_slug === 'component-ajax') || 
            ($dynamic_slug === 'payment-ajax') || 
            ($static_slug === 'plugin-ajax') ) {

            $this->ajax($static_slug, $dynamic_slug, $additional_slug);

        } else if ( ($static_slug === 'oauth2') || ($static_slug === 'rest-app') ) {

            $this->rest($static_slug, $dynamic_slug, $additional_slug);

        } else if ($static_slug === 'guest') {

            // Call the section class
            $base = new CmsBase\CmsBase('user_init', $static_slug, $dynamic_slug);

            if ( !$dynamic_slug ) {

                // Display 404 page
                show_404();

            }

            // Call the user's guest
            $base->guest($dynamic_slug);

        } else {

            // Verify if url has refferer
            $this->check_referrer();

            // Verify if the $additional_slug exists
            if ( ( $additional_slug === 'page' ) && is_numeric($identifier_slug) ) {

                // Set page
                md_set_component_variable('page', $identifier_slug);

            } else if ( ($static_slug !== 'auth') && ( $static_slug !== 'payments' ) && ($dynamic_slug !== 'app') && $additional_slug ) {

                // Display 404 page
                show_404();

            }

            // Default base's section
            $section = 'frontend';

            // Verify if section isn't the default
            if ($static_slug === 'auth' || $static_slug === 'admin' ) {
                $section = $static_slug;
            }

            if ( $static_slug === 'user' || $static_slug === 'payments' ) {

                // Set section
                $section = $static_slug;

                // Set dynamic slug as static
                $static_slug = $dynamic_slug;

                // Set additional slug as additional
                $dynamic_slug = $additional_slug;

            }

            // Call the section class
            $base = new CmsBase\CmsBase($section . '_init', $static_slug, $dynamic_slug);

            // Call the base's init
            $base->init($section, $static_slug, $dynamic_slug);

        }
        
    }  
    
    /**
     * The public method ajax is universal caller for ajax calls
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * 
     * @return void
     */
    public function ajax($static_slug=NULL, $dynamic_slug=NULL, $additional_slug=NULL) {

        // Default base's section
        $section = 'frontend';

        // Verify if section isn't the default
        if ( ( $static_slug === 'auth' ) || ( $static_slug === 'admin' ) ) {

            // Prepare the static slug
            $section = str_replace('-', '_', $static_slug);

        } else if ( ($dynamic_slug === 'component-ajax') || ($dynamic_slug === 'app-ajax' ) ) {
            $section = 'user';
        } else if ( $dynamic_slug === 'payment-ajax'  ) {
            $section = 'payments';
        } else if ( $static_slug === 'plugin-ajax' ) {
            $section = 'plugins';
        }

        if ( $static_slug === 'theme-ajax' ) {
            $dynamic_slug = str_replace('-', '_', $static_slug);
        } else if ( $dynamic_slug === 'theme-ajax' ) {
            $section = 'user';
            $dynamic_slug = str_replace('-', '_', $dynamic_slug);
        }

        if ( $additional_slug ) {

            // Prepare the component's name
            $component = str_replace('-', '_', $additional_slug);

        } else {

            // Prepare the component's name
            $component = str_replace('-', '_', $dynamic_slug);
            
        }

        // Call the section class
        $base = new CmsBase\CmsBase($section . '_init', $component);

        // Call the base's ajax
        $base->ajax_init($section, $component);
        
    }

    /**
     * The public method rest processes the rest's calls
     * 
     * @since 0.0.7.8
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * @param string $additional_slug contains additional url's slug
     * 
     * @return void
     */
    public function rest($static_slug=NULL, $dynamic_slug=NULL, $additional_slug=NULL) {

        // Call the section class
        $base = new CmsBase\CmsBase('rest_init');

        // Call the base's rest
        $base->rest_init($static_slug, $dynamic_slug, $additional_slug);
        
    }

    /**
     * The public method logout will delete user's session
     * 
     * @return void
     */
    public function logout() {
        
        // This function will delete all active session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('member');
        $this->session->unset_userdata('autodelete');
        
        // Get current user IP
        $ip = $this->input->ip_address();
        
        // Delete all user sessions
        $this->db->delete('ci_sessions', array('ip_address' => $ip));

        redirect('/');
        
    }

    /**
     * The public method check_referrer verifies if the url has a referrer
     * 
     * @return void
     */
    public function check_referrer() {

        // Verify if Referrals section is enabled
        if ( md_the_option('enable_referral') ) {
        
            // Get referrer
            $referrer = $this->input->get('ref', true);

            if ( $referrer ) {                

                if ( !$this->session->userdata('referrer') ) {
                    $this->session->set_userdata('referrer', $referrer);
                }

            }
            
        }
        
    }

    /**
     * The public method install installs Midrub
     * 
     * @return void
     */
    public function install() {

        // Require the base class
        $this->load->file(APPPATH . '/base/main.php');

        (new CmsBase\Install\Main)->init();

        
    }
    
}

/* End of file base.php */
