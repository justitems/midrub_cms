<?php
/**
 * Init Controller
 *
 * This file loads the Updates Component in the admin's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.0
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Updates\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Init class loads the Updates Component in the admin's panel
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
        $this->CI->lang->load( 'updates', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_UPDATES );

        // Load Updates Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_UPDATES . 'models/', 'Updates_model', 'updates_model' );
        
    }
    
    /**
     * The public method view loads the updates's template
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function view() {

        // Set page's title
        md_set_the_title($this->CI->lang->line('updates'));

        // Set the component's slug
        md_set_data('component_slug', 'updates');

        // Set styles
        md_set_css_urls(array('stylesheet', base_url('assets/base/admin/components/collection/updates/styles/css/styles.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION), 'text/css', 'all'));

        // Verify if there is an input parameter
        if ( $this->CI->input->get('p', true) ) {
            
            // Load view by page
            switch ( $this->CI->input->get('p', true) ) {
                
                case 'apps':

                    // Set Apps Js file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/updates/js/apps.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_UPDATES .  'views',
                            'apps',
                            array(
                                'updates' => $this->available_updates('apps')
                            ),
                            true
                        )

                    );

                    break;

                case 'user_components':

                    // Set User Components Js file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/updates/js/user-components.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_UPDATES .  'views',
                            'user_components',
                            array(
                                'updates' => $this->available_updates('user_components')
                            ),
                            true
                        )

                    );

                    break;

                case 'frontend_themes':

                    // Set Frontend Themes Js file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/updates/js/frontend-themes.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_UPDATES .  'views',
                            'frontend_themes',
                            array(
                                'updates' => $this->available_updates('frontend_themes')
                            ),
                            true
                        )

                    );

                    break;

                case 'plugins':

                    // Set Plugins Js file
                    md_set_js_urls(array(base_url('assets/base/admin/components/collection/updates/js/plugins.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION)));

                    // Set views params
                    set_admin_view(

                        $this->CI->load->ext_view(
                            CMS_BASE_ADMIN_COMPONENTS_UPDATES .  'views',
                            'plugins',
                            array(
                                'updates' => $this->available_updates('plugins')
                            ),
                            true
                        )

                    );

                    break;
                    
                default:

                    // Display 404 page
                    show_404();

                    break;

            }

        } else {

            // Set Main Js file
            md_set_js_urls(array(base_url('assets/base/admin/components/collection/updates/js/main.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_UPDATES_VERSION)));

            // Default restore
            $restore = false;
        
            // Verify if backup exists
            if ( file_exists('backup/backup.json') ) {
                
                // If backup exists
                $restore = true;
                
            }

            // Set views params
            set_admin_view(

                $this->CI->load->ext_view(
                    CMS_BASE_ADMIN_COMPONENTS_UPDATES .  'views',
                    'main',
                    array(
                        'updates' => $this->available_updates('system'),
                        'restore' => $restore
                    ),
                    true
                )

            );          

        }
        
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
        $updates = $this->CI->base_model->the_data_where('updates', '*', array(
            'type' => $type
        ));

        // Verify if updates exists
        if ( $updates ) {

            switch ( $type ) {

                case 'apps':

                    // Apps array
                    $apps = array();

                    // List all updates
                    foreach ( $updates as $updates ) {

                        // App array
                        $app = array(
                            'version' => $updates['version'],
                            'body' => $updates['body'],
                            'created' => $updates['created']
                        );

                        // Verify if app exists
                        if ( is_dir(APPPATH . 'base/user/apps/collection/' . $updates['slug']) ) {

                            // Create an array
                            $array = array(
                                'CmsBase',
                                'User',
                                'Apps',
                                'Collection',
                                ucfirst($updates['slug']),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get app's info
                            $info = (new $cl())->app_info();

                            // Set the app's name
                            $app['name'] = $info['app_name'];

                            // Set the app's slug
                            $app['slug'] = $updates['slug'];

                            // Verify if updates's url exists
                            if (  isset($info['update_url']) ) {

                                // Set updates url
                                $app['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if updates's code is required
                            if (  isset($info['update_code']) ) {

                                // Set updates's code requirements
                                $app['update_code'] = $info['update_code'];

                            } else {

                                // Set updates's code requirements
                                $app['update_code'] = false;
                            }

                            // Verify if updates's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set updates's code url
                                $app['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add updates to the list
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
                    foreach ( $updates as $updates ) {

                        // Component array
                        $component = array(
                            'version' => $updates['version'],
                            'body' => $updates['body'],
                            'created' => $updates['created']
                        );

                        // Verify if component exists
                        if ( is_dir(APPPATH . 'base/user/components/collection/' . $updates['slug']) ) {

                            // Create an array
                            $array = array(
                                'CmsBase',
                                'User',
                                'Components',
                                'Collection',
                                ucfirst($updates['slug']),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get component's info
                            $info = (new $cl())->component_info();

                            // Set the component's name
                            $component['name'] = $info['component_name'];

                            // Set the component's slug
                            $component['slug'] = $updates['slug'];

                            // Verify if updates's url exists
                            if (  isset($info['update_url']) ) {

                                // Set updates url
                                $component['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if updates's code is required
                            if (  isset($info['update_code']) ) {

                                // Set updates's code requirements
                                $component['update_code'] = $info['update_code'];

                            } else {

                                // Set updates's code requirements
                                $component['update_code'] = false;
                            }

                            // Verify if updates's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set updates's code url
                                $component['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add updates to the list
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
                    foreach ( $updates as $updates ) {

                        // Themes array
                        $theme = array(
                            'version' => $updates['version'],
                            'body' => $updates['body'],
                            'created' => $updates['created']
                        );

                        // Verify if theme exists
                        if ( is_dir(APPPATH . 'base/frontend/themes/' . $updates['slug']) ) {

                            // Get theme's configuration
                            $info = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/' . $updates['slug'] . '/config.json'), TRUE);

                            // Set the theme's name
                            $theme['name'] = $info['name'];

                            // Set the theme's slug
                            $theme['slug'] = $updates['slug'];

                            // Verify if updates's url exists
                            if (  isset($info['update_url']) ) {

                                // Set updates url
                                $theme['update_url'] = $info['update_url'];

                            } else {

                                continue;

                            }

                            // Verify if updates's code is required
                            if (  !empty($info['update_code']) ) {

                                // Set updates's code requirements
                                $theme['update_code'] = $info['update_code'];

                            } else {

                                // Set updates's code requirements
                                $theme['update_code'] = false;

                            }

                            // Verify if updates's code url exists
                            if (  isset($info['update_code_url']) ) {

                                // Set updates's code url
                                $theme['update_code_url'] = $info['update_code_url'];

                            }

                        } else {

                            continue;

                        }

                        // Add updates to the list
                        $themes[] = $theme;

                    }

                    // Verify if theme exists
                    if ( $themes ) {

                        return $themes;

                    } else {

                        return false;

                    }

                    break;

                case 'plugins':

                    // Plugins array
                    $plugins = array();
                    
                    // List all updates
                    foreach ( $updates as $updates ) {
                    
                        // Plugin array
                        $plugin = array(
                            'version' => $updates['version'],
                            'body' => $updates['body'],
                            'created' => $updates['created']
                        );
                    
                        // Verify if plugin exists
                        if ( is_dir(APPPATH . 'base/plugins/collection/' . $updates['slug']) ) {
                    
                            // Create an array
                            $array = array(
                                'CmsBase',
                                'Plugins',
                                'Collection',
                                ucfirst($updates['slug']),
                                'Main'
                            );
                    
                            // Implode the array above
                            $cl = implode('\\', $array);
                    
                            // Get plugin's info
                            $info = (new $cl())->plugin_info();
                    
                            // Set the plugin's name
                            $plugin['name'] = $info['plugin_name'];
                    
                            // Set the plugin's slug
                            $plugin['slug'] = $updates['slug'];
                    
                            // Verify if updates's url exists
                            if (  isset($info['update_url']) ) {
                    
                                // Set updates url
                                $plugin['update_url'] = $info['update_url'];
                    
                            } else {
                    
                                continue;
                    
                            }
                    
                            // Verify if updates's code is required
                            if (  isset($info['update_code']) ) {
                    
                                // Set updates's code requirements
                                $plugin['update_code'] = $info['update_code'];
                    
                            } else {
                    
                                // Set updates's code requirements
                                $plugin['update_code'] = false;
                            }
                    
                            // Verify if updates's code url exists
                            if (  isset($info['update_code_url']) ) {
                    
                                // Set updates's code url
                                $plugin['update_code_url'] = $info['update_code_url'];
                    
                            }
                    
                        } else {
                    
                            continue;
                    
                        }
                    
                        // Add updates to the list
                        $plugins[] = $plugin;
                    
                    }
                    
                    // Verify if plugin exists
                    if ( $plugins ) {
                    
                        return $plugins;
                    
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

                    return $system;

                    break;

            }

        } else {

            return false;

        }
        
    }

}

/* End of file init.php */