<?php
/**
 * Init Controller
 *
 * This file loads the Update Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Update\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Update Component in the admin's panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */
class Init {
    
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
        
        // Load the component's language files
        $this->CI->lang->load( 'update', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_ADMIN_UPDATE );

        // Load Updates Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_UPDATE . 'models/', 'Updates_model', 'updates_model' );
        
    }
    
    /**
     * The public method view loads the update's template
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('update'));

        // Set the component's slug
        md_set_component_variable('component_slug', 'update');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/collection/update/styles/css/styles.css?ver=' . MIDRUB_BASE_ADMIN_UPDATE_VERSION), 'text/css', 'all'));

        // Verify if there is an input parameter
        if ( $this->CI->input->get('p', true) ) {
            
            // Load view by page
            switch ( $this->CI->input->get('p', true) ) {
                
                case 'apps':

                    // Set Apps Js file
                    md_set_js_urls(array(base_url('assets/base/admin/collection/update/js/apps.js?ver=' . MIDRUB_BASE_ADMIN_UPDATE_VERSION)));

                    // Load the apps view
                    $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_UPDATE .  'views', 'apps', array('updates' => $this->available_updates('apps')), true);

                    break;

                case 'user_components':

                    // Set User Components Js file
                    md_set_js_urls(array(base_url('assets/base/admin/collection/update/js/user-components.js?ver=' . MIDRUB_BASE_ADMIN_UPDATE_VERSION)));

                    // Load the User Components view
                    $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_UPDATE .  'views', 'user_components', array('updates' => $this->available_updates('user_components')), true);

                    break;

                case 'frontend_themes':

                    // Set Frontend Themes Js file
                    md_set_js_urls(array(base_url('assets/base/admin/collection/update/js/frontend-themes.js?ver=' . MIDRUB_BASE_ADMIN_UPDATE_VERSION)));

                    // Load the Frontend Themes view
                    $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_UPDATE .  'views', 'frontend_themes', array('updates' => $this->available_updates('frontend_themes')), true);

                    break;
                    
                default:

                    // Display 404 page
                    show_404();

                    break;

            }

        } else {

            // Set Main Js file
            md_set_js_urls(array(base_url('assets/base/admin/collection/update/js/main.js?ver=' . MIDRUB_BASE_ADMIN_UPDATE_VERSION)));

            // Default restore
            $restore = false;
        
            // Verify if backup exists
            if ( file_exists('backup/backup.json') ) {
                
                // If backup exists
                $restore = true;
                
            }

            // Load the main's view
            $template['body'] = $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_UPDATE .  'views', 'main', array(
                'update' => $this->available_updates('system'),
                'restore' => $restore
            ), true);            

        }

        // Making temlate and send data to view.
        $template['header'] = $this->CI->load->view('admin/layout/header2', array('admin_header' => admin_header()), true);
        $template['left'] = $this->CI->load->view('admin/layout/left', array(), true);
        $template['footer'] = $this->CI->load->view('admin/layout/footer', array(), true);
        $this->CI->load->ext_view(MIDRUB_BASE_ADMIN_UPDATE . 'views/layout', 'index', $template);
        
    }

    /**
     * The public method available_updates provide the available updates
     * 
     * @param string $type contains the list's type
     * 
     * @since 0.0.8.1
     * 
     * @return array with available updates or boolean false
     */
    protected function available_updates($type) {

        // Get availale updates
        $updates = $this->CI->base_model->get_data_where('updates', '*', array(
            'type' => $type
        ));

        // Verify if updates exists
        if ( $updates ) {

            switch ( $type ) {

                case 'apps':

                    // Apps array
                    $apps = array();

                    // List all updates
                    foreach ( $updates as $update ) {

                        // App array
                        $app = array(
                            'version' => $update['version'],
                            'body' => $update['body'],
                            'created' => $update['created']
                        );

                        // Verify if app exists
                        if ( is_dir(APPPATH . 'base/user/apps/collection/' . $update['slug']) ) {

                            // Create an array
                            $array = array(
                                'MidrubBase',
                                'User',
                                'Apps',
                                'Collection',
                                ucfirst($update['slug']),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get app's info
                            $info = (new $cl())->app_info();

                            // Set the app's name
                            $app['name'] = $info['app_name'];

                            // Set the app's slug
                            $app['slug'] = $update['slug'];

                            // Verify if update's url exists
                            if (  isset($info['update_url']) ) {

                                // Set update url
                                $app['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if update's code is required
                            if (  isset($info['update_code']) ) {

                                // Set update's code requirements
                                $app['update_code'] = $info['update_code'];

                            } else {

                                // Set update's code requirements
                                $app['update_code'] = false;
                            }

                            // Verify if update's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set update's code url
                                $app['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add update to the list
                        $apps[] = $app;

                    }

                    // Verify if apps exists
                    if ( $apps ) {

                        return $apps;

                    } else {

                        return false;

                    }

                    break;

                case 'user_components':

                    // Components array
                    $components = array();

                    // List all updates
                    foreach ( $updates as $update ) {

                        // Component array
                        $component = array(
                            'version' => $update['version'],
                            'body' => $update['body'],
                            'created' => $update['created']
                        );

                        // Verify if component exists
                        if ( is_dir(APPPATH . 'base/user/components/collection/' . $update['slug']) ) {

                            // Create an array
                            $array = array(
                                'MidrubBase',
                                'User',
                                'Components',
                                'Collection',
                                ucfirst($update['slug']),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get component's info
                            $info = (new $cl())->component_info();

                            // Set the component's name
                            $component['name'] = $info['component_name'];

                            // Set the component's slug
                            $component['slug'] = $update['slug'];

                            // Verify if update's url exists
                            if (  isset($info['update_url']) ) {

                                // Set update url
                                $component['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if update's code is required
                            if (  isset($info['update_code']) ) {

                                // Set update's code requirements
                                $component['update_code'] = $info['update_code'];

                            } else {

                                // Set update's code requirements
                                $component['update_code'] = false;
                            }

                            // Verify if update's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set update's code url
                                $component['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add update to the list
                        $components[] = $component;

                    }

                    // Verify if component exists
                    if ( $components ) {

                        return $components;

                    } else {

                        return false;

                    }

                    break;

                case 'frontend_themes':

                    // Themes array
                    $themes = array();

                    // List all updates
                    foreach ( $updates as $update ) {

                        // Themes array
                        $theme = array(
                            'version' => $update['version'],
                            'body' => $update['body'],
                            'created' => $update['created']
                        );

                        // Verify if theme exists
                        if ( is_dir(APPPATH . 'base/frontend/themes/' . $update['slug']) ) {

                            // Get theme's configuration
                            $info = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/' . $update['slug'] . '/config.json'), TRUE);

                            // Set the theme's name
                            $theme['name'] = $info['name'];

                            // Set the theme's slug
                            $theme['slug'] = $update['slug'];

                            // Verify if update's url exists
                            if (  isset($info['update_url']) ) {

                                // Set update url
                                $theme['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if update's code is required
                            if (  !empty($info['update_code']) ) {

                                // Set update's code requirements
                                $theme['update_code'] = $info['update_code'];

                            } else {

                                // Set update's code requirements
                                $theme['update_code'] = false;

                            }

                            // Verify if update's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set update's code url
                                $theme['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add update to the list
                        $themes[] = $theme;

                    }

                    // Verify if theme exists
                    if ( $themes ) {

                        return $themes;

                    } else {

                        return false;

                    }

                    break;

                case 'system':

                    // System array
                    $system = array(
                        'version' => $updates[0]['version'],
                        'body' => $updates[0]['body'],
                        'created' => $updates[0]['created']
                    );

                    // Set the system's name
                    $system['name'] = 'Midrub';

                    // Set update url
                    $system['update_url'] = 'https://raw.githubusercontent.com/scrisoft/midrub_cms/master/updates.json';

                    // Set update's code requirements
                    $system['update_code'] = false;

                    return $system;

                    break;

            }

        } else {

            return false;

        }
        
    }

}
