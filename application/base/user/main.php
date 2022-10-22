<?php
/**
 * Midrub Base User
 *
 * This file loads the Midrub's User Base
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\User;

// Require the Team Permissions Inc
require_once CMS_BASE_PATH . 'inc/team/permissions.php';

// Require the General Inc
require_once CMS_BASE_PATH . 'user/inc/general.php';

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_USER') OR define('CMS_BASE_USER', APPPATH . 'base/user/');
defined('CMS_BASE_USER_VERSION') OR define('CMS_BASE_USER_VERSION', '0.1');

/*
 * Main is the user's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class Main {

    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI, $user_theme;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Get enabled user theme's slug
        $this->user_theme = str_replace('-', '_', md_the_option('themes_enabled_user_theme'));

    }
    
    /**
     * The public method init loads the user's components
     * 
     * @since 0.0.7.9
     * 
     * @param string $static_slug contains static url's slug
     * @param string $dynamyc_slug contains a dynamic url's slug
     * 
     * 
     * @return void
     */
    public function init($static_slug, $dynamic_slug = NULL) {

        // Verify if session exists
        if ( !md_the_user_session() || $this->CI->user_role === '1' ) {
            redirect('/admin/dashboard');
        } else if (!$this->user_theme) {
            redirect('/error/no-user-theme');
        } else if ( md_the_user_option(md_the_user_id(), 'nonpaid') ) {
            redirect('/auth/upgrade');
        } else if ( $this->CI->user_status !== '1' ) {
            redirect('/auth/confirmation');
        } else if ( (strtotime(md_the_user_option(md_the_user_id(), 'plan_end')) + 86400) < time() ) {
            redirect('/error/subscription-expired');            
        }

        // Verify if is required an application
        if ( $static_slug === 'app' ) {
            
            // Prepare the app's name
            $dynamic_slug = str_replace('-', '_', $dynamic_slug);

            // Verify if app exists
            if ( file_exists( CMS_BASE_USER . 'apps/collection/' . $dynamic_slug . '/main.php' ) ) {

                // Load Guest
                $this->load_component_apps('Apps', ucfirst($dynamic_slug), 'user');

                // Set url's slug
                md_set_data('url_slug', $dynamic_slug); 

            } else {

                // Display 404 page
                show_404();
                
            }

        } else {

            // Prepare the component's name
            $static_slug = str_replace('-', '_', $static_slug);

            // Verify if component exists
            if ( file_exists( CMS_BASE_USER . 'components/collection/' . $static_slug . '/main.php' ) ) {

                // Load Guest
                $this->load_component_apps('Components', ucfirst($static_slug), 'user');

                // Set url's slug
                md_set_data('url_slug', $static_slug); 

            } else {

                // Display 404 page
                show_404();
                
            }
            
        }

        // Load View
        $this->load_view();
        
    }
    
    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @since 0.0.7.9
     * 
     * @param string $component contains the base's component
     * 
     * @return void
     */
    public function ajax_init($component) {

        // Verify if user is user
        if ( !md_the_user_session() || $this->CI->user_role === '1' || !$this->user_theme || $this->CI->user_status !== '1' ) {
            exit();
        } else if ( md_the_user_option(md_the_user_id(), 'nonpaid') ) {
            exit();
        }

        // Type
        $type = 'apps';

        // Prepare the component or app's name
        $component = str_replace('-', '_', $component);

        // Verify if app exists
        if ( file_exists(CMS_BASE_USER . 'apps/collection/' . $component . '/main.php') ) {
            $type = 'apps';
        } else if ( file_exists(CMS_BASE_USER . 'components/collection/' . $component . '/main.php') ) {
            $type = 'components';
        } else if ( $component === 'theme_ajax' ) {

            // Verify if ajax directory exists
            if ( is_dir(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/ajax/') ) {

                // List ajax files
                foreach (glob(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/ajax/' . '*.php') as $filename) {
                    require_once $filename;
                }

                // Get action's get input
                $action = $this->CI->input->get('action');

                if (!$action) {
                    $action = $this->CI->input->post('action');
                }

                try {

                    // Call function if exists
                    $action();
        
                } catch (Exception $ex) {
        
                    $data = array(
                        'success' => FALSE,
                        'message' => $ex->getMessage()
                    );
        
                    echo json_encode($data);
        
                }

                exit();

            }  

        } else {
            exit();
        }

        // Load component
        $this->load_component_apps($type, $component, 'ajax');
        
    }

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.7.9
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category) {

        // Load the create menu inc file
        md_include_component_file(CMS_BASE_PATH . 'inc/menu/create_menu.php');

        // Verify if a user's theme is enabled
        if ($this->user_theme) {

            // Verify if the theme has language files
            if (is_dir(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/language/' . $this->CI->config->item('language') . '/')) {

                // Load all language files
                foreach (glob(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/language/' . $this->CI->config->item('language') . '/' . '*.php') as $filename) {

                    $this->CI->lang->load(str_replace(array(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/language/' . $this->CI->config->item('language') . '/', '_lang.php'), '', $filename), $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/');

                }

            }

            // Load hooks by category
            switch ($category) {

                case 'admin_init':

                    if (file_exists(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/hooks/admin_init.php')) {
                        md_include_component_file(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/hooks/admin_init.php');
                    }

                    break;
                    
            }

        }

        // List all user's components
        foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Load components hooks
            $this->load_component_apps('Components', ucfirst($app), 'load_hooks', $category);

        }

        // List all user's apps
        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Load apps hooks
            $this->load_component_apps('Apps', ucfirst($app), 'load_hooks', $category);

        }

    }

    /**
     * The public method guest displays pages for guests
     * 
     * @param string $dynamic_slug contains a dynamic url's slug
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function guest($dynamic_slug) {

        // Prepare the app's name
        $dynamic_slug = str_replace('-', '_', $dynamic_slug);

        // Verify if app exists
        if ( file_exists(CMS_BASE_USER . 'apps/collection/' . $dynamic_slug . '/main.php') ) {

            // Load Guest
            $this->load_component_apps('Apps', ucfirst($dynamic_slug), 'guest');
            
        } else {

            // Display 404 page
            show_404();

        }

    }

    /**
     * The private method load_component_apps loads a component or app
     * 
     * @param string $type contains the component's type
     * @param string $slug contains the component's slug
     * @param string $method contains the component's method
     * @param string $method_var contains the component's method var
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_component_apps($type, $slug, $method, $method_var=NULL) {

        // Create an array
        $array = array(
            'CmsBase',
            'User',
            ucfirst($type),
            'Collection',
            ucfirst($slug),
            'Main'
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Get method
        (new $cl())->$method($method_var);
        
    } 

    /**
     * The private method load_view loads user's theme
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_view() {

        // Load theme's inc files
        if ( is_dir(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/inc/') ) {

            foreach ( glob(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/core/inc/*.php') as $filename ) {
                require_once $filename;
            }
            
        }

        // Load the theme
        md_include_component_file(CMS_BASE_USER . 'themes/collection/' . $this->user_theme . '/main.php');
        
    }    
    
}

/* End of file main.php */