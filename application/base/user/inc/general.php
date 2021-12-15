<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the User's panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\User\Classes as CmsBaseUserClasses;

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH RETURNS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_the_team_role_permission') ) {
    
    /**
     * The function md_the_team_role_permission verifies if member has permission
     * 
     * @param string $permission contains the requested permission
     * 
     * @since 0.0.7.9
     * 
     * @return boolean true or false
     */
    function md_the_team_role_permission($permission) {

        // Get codeigniter object instance
        $CI =& get_instance();

        // Verify if user is team's member
        if ( isset( $CI->session->userdata['member'] ) ) {

            // Require the Team Inc file
            require_once CMS_BASE_USER . 'inc/team.php';

            // Verify if user has or no this permission
            return verify_team_role_permission($permission);

        } else {
            return true;
        }

    }

}

if (!function_exists('md_the_user_option')) {
    
    /**
     * The function md_the_user_option gets the user's options
     * 
     * @param integer $user_id contains the user's id
     * @param string $option contains the option's name
     * 
     * @return object or string with meta's value
     */
    function md_the_user_option($user_id, $option) {

        // Require the General Parts Options Inc
        require_once CMS_BASE_PATH . 'user/inc/parts/options/general.php';

        // Get the user's option
        return md_the_user_option_from_parts($user_id, $option);

    }

}

if (!function_exists('md_the_plan_feature')) {
    
    /**
     * The function md_the_plan_feature gets plan's feature
     * 
     * @param string $features contains the feature's name
     * @param integer $plan_id contains optionally the plan's id
     * @param integer $user_id contains optionally the user's id
     * 
     * @return string with feature's value or boolean false
     */
    function md_the_plan_feature($feature, $plan_id = 0, $user_id = 0) {
        
        // Require the General Parts Options Inc
        require_once CMS_BASE_PATH . 'user/inc/parts/options/general.php';

        // Get the gets plan's feature
        return md_the_plan_feature_from_parts($feature, $plan_id, $user_id);        
        
    }

}

if (!function_exists('md_the_user_image')) {
    
    /**
     * The function md_the_user_image gets the user's image
     * 
     * @param integer $user_id contains the user's id
     * 
     * @return array with image or boolean false
     */
    function md_the_user_image($user_id) {
        
        // Require the Media Parts Options Inc
        require_once CMS_BASE_PATH . 'user/inc/parts/options/media.php';

        // Get the gets user's media
        return md_the_user_image_from_parts($user_id);        
        
    }

}

if ( !function_exists('md_the_user_icon') ) {
    
    /**
     * The function md_the_user_icon gets the user icon
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return string with icon or boolean
     */
    function md_the_user_icon($params) {

        // Call the icons class
        return (new CmsBaseUserClasses\Icons)->the_icon($params);

    }
    
}

if ( !function_exists('md_the_file_size') ) {
    
    /**
     * The function md_the_file_size calculates the file size
     * 
     * @param integer $file_size contains the file's size
     * 
     * @since 0.0.8.5
     * 
     * @return string with file's size
     */
    function md_the_file_size($file_size) {
        
        // Set logarithm
        $file_log = log($file_size, 1024);

        // Set labels
        $labels = array('', 'K', 'M', 'G', 'T');   
    
        return round(pow(1024, $file_log - floor($file_log)), 2) .' '. $labels[floor($file_log)];

    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULTS FUNCTIONS WHICH DISPLAYS DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('get_the_js_urls') ) {
    
    /**
     * The function get_the_js_urls gets the js links
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_js_urls() {

        md_get_the_js_urls();
        
    }
    
}

if ( !function_exists('get_the_header') ) {
    
    /**
     * The function get_the_header loads the header
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_header() {

        // Call the properties class
        $hooks = (new CmsBase\Classes\Hooks);

        // Runs a hook based on hook's name
        $hooks->run_hook('the_header', array());
        
    }
    
}

if ( !function_exists('get_the_footer') ) {
    
    /**
     * The function get_the_footer loads the header
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_footer() {

        // Call the properties class
        $hooks = (new CmsBase\Classes\Hooks);

        // Runs a hook based on hook's name
        $hooks->run_hook('the_footer', array());
        
    }
    
}

if ( !function_exists('set_user_view') ) {
    
    /**
     * The function set_user_view sets the user's view
     * 
     * @param array $view contains the view parameters
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_user_view($view) {

        // Set content view
        md_set_data('user_content_view', $view);
        
    }
    
}

if ( !function_exists('get_user_view') ) {
    
    /**
     * The function get_user_view gets the user view
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_user_view() {

        // Verify if view exists
        if ( md_the_data('user_content_view') ) {

            // Display view
            echo md_the_data('user_content_view');

        }
        
    }
    
}

if ( !function_exists('get_the_css_urls') ) {
    
    /**
     * The function get_the_css_urls gets the css links
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function get_the_css_urls() {

        md_get_the_css_urls();
        
    }
    
}

if ( !function_exists('md_get_menu') ) {
    
    /**
     * The function md_get_menu generates a menu
     * 
     * @param string $menu_slug contains the menu's slug
     * @param array $args contains the menu's arguments
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_menu($menu_slug, $args) {

        // Require the Read Menu Inc file
        require_once APPPATH . 'base/inc/menu/read_menu.php';

        // Prepare menu's args
        $menu_args = array(
            'slug' => $menu_slug,
            'fields' => array(
                'selected_component',
                'permalink',
                'class'
            ),
            'language' => TRUE
        );

        // Get menu's items
        $menu_items = md_the_theme_menu($menu_args);

        // Verify if menu items exists
        if ( $menu_items ) {

            if ( isset($args['before_menu']) ) {
                echo $args['before_menu'];
            }

            // List all menu items
            for ( $m = 0; $m < count($menu_items); $m++ ) {

                $permalink = '';

                $classification_id = $menu_items[$m]['classification_id'];

                if ( is_dir(CMS_BASE_USER . 'components/collection/' . $menu_items[$m]['selected_component']. '/') && !$menu_items[$m]['permalink'] ) {
                    $permalink = site_url('user/' . $menu_items[$m]['selected_component']);
                    $cl = implode('\\', array('CmsBase', 'User', 'Components', 'Collection', ucfirst($menu_items[$m]['selected_component']), 'Main'));
                    if (!(new $cl())->check_availability()) {
                        continue;
                    }
                } else if ( is_dir(CMS_BASE_USER . 'apps/collection/' . $menu_items[$m]['selected_component']. '/') && !$menu_items[$m]['permalink'] ) {
                    $permalink = site_url('user/app/' . $menu_items[$m]['selected_component']);
                    $cl = implode('\\', array('CmsBase', 'User', 'Apps', 'Collection', ucfirst($menu_items[$m]['selected_component']), 'Main'));
                    if (!(new $cl())->check_availability()) {
                        continue;
                    }
                }

                if ( $menu_items[$m]['permalink'] ) {
                    $permalink = $menu_items[$m]['permalink'];
                }

                $class = '';

                if ( $menu_items[$m]['class'] ) {
                    $class = $menu_items[$m]['class'];
                }

                $active = '';

                if ( $menu_items[$m]['selected_component'] === md_the_data('url_slug') ) {
                    $active = ' class="active"';
                }

                if ( isset($args['before_single_item']) ) {
                    echo str_replace(array('[class]', '[url]', '[active]', '[text]'), array($class, $permalink, $active, $menu_items[$m]['meta_value']), $args['before_single_item']);
                }

                if ( isset($menu_items[($m + 1)]) ) {

                    if ( $menu_items[($m + 1)]['classification_parent'] === $classification_id ) {

                        if ( isset($args['before_submenu']) ) {
                            echo $args['before_submenu'];
                        }

                        $fs = ($m + 1);

                        for ( $m2 = $fs; $m2 < count($menu_items); $m2++ ) {

                            if ( $menu_items[$m2]['classification_parent'] !== $classification_id ) {
                                break;
                            }

                            $permalink = '';

                            if ( is_dir(CMS_BASE_USER . 'components/collection/' . $menu_items[$m2]['selected_component']. '/') && !$menu_items[$m2]['permalink'] ) {
                                $permalink = site_url('user/' . $menu_items[$m2]['selected_component']);
                                $cl = implode('\\', array('CmsBase', 'User', 'Components', 'Collection', ucfirst($menu_items[$m2]['selected_component']), 'Main'));
                                if (!(new $cl())->check_availability()) {
                                    $m++;
                                    continue;
                                }
                            } else if ( is_dir(CMS_BASE_USER . 'apps/collection/' . $menu_items[$m2]['selected_component']. '/') && !$menu_items[$m2]['permalink'] ) {
                                $permalink = site_url('user/app/' . $menu_items[$m2]['selected_component']);
                                $cl = implode('\\', array('CmsBase', 'User', 'Apps', 'Collection', ucfirst($menu_items[$m2]['selected_component']), 'Main'));
                                if (!(new $cl())->check_availability()) {
                                    $m++;
                                    continue;
                                }
                            }
            
                            if ( $menu_items[$m2]['permalink'] ) {
                                $permalink = $menu_items[$m2]['permalink'];
                            }
            
                            $class = '';
            
                            if ( $menu_items[$m2]['class'] ) {
                                $class = $menu_items[$m2]['class'];
                            }
            
                            $active = '';
            
                            if ( $menu_items[$m2]['selected_component'] === md_the_data('url_slug') ) {
                                $active = ' class="active"';
                            }
            
                            if ( isset($args['before_single_item']) ) {
                                echo str_replace(array('[class]', '[url]', '[active]', '[text]'), array($class, $permalink, $active, $menu_items[$m2]['meta_value']), $args['before_single_item']);
                            }

                            if ( isset($args['after_single_item']) ) {
                                echo $args['after_single_item'];
                            }
                            
                            $m++;

                        }

                        if ( isset($args['after_submenu']) ) {
                            echo $args['after_submenu'];
                        }
                    
                    }

                }

                if ( isset($args['after_single_item']) ) {
                    echo $args['after_single_item'];
                }

            }

            if ( isset($args['after_menu']) ) {
                echo $args['after_menu'];
            }

        }
        
    }
    
}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS FOR ACTIONS
|--------------------------------------------------------------------------
*/

if ( !function_exists('md_run_hook') ) {
    
    /**
     * The function md_run_hook runs a hook based on hook name
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_run_hook($hook_name, $args) {

        // Run a hook
        md_run_hook($hook_name, $args);
        
    }
    
}

if ( !function_exists( 'md_update_user_option' ) ) {
    
    /**
     * The function md_update_user_option updates the user's option
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * @param string $meta_value contains the user's meta value
     * 
     * @return boolean true or false
     */
    function md_update_user_option($user_id, $meta_name, $meta_value) {

        // Require the Update Parts Options Inc
        require_once CMS_BASE_PATH . 'user/inc/parts/options/update.php';

        // Update option
        return md_update_user_option_from_parts($user_id, $meta_name, $meta_value);
        
    }

}

if ( !function_exists( 'md_delete_user_option' ) ) {
    
    /**
     * The function md_delete_user_option deletes a user's option
     * 
     * @param integer $user_id contains the user_id
     * @param string $meta_name contains the user's meta name
     * 
     * @return boolean true or false
     */
    function md_delete_user_option($user_id, $meta_name) {

        // Require the General Parts Options Inc
        require_once CMS_BASE_PATH . 'user/inc/parts/options/general.php';

        // Delete the user's option
        return md_delete_user_option_from_parts($user_id, $meta_name);
        
    }

}

/*
|--------------------------------------------------------------------------
| DEFAULT FUNCTIONS TO SAVE DATA
|--------------------------------------------------------------------------
*/

if ( !function_exists('set_css_urls') ) {
    
    /**
     * The function set_css_urls sets the css links
     * 
     * @param array $css_url contains the css link parameters
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_css_urls($css_url) {

        md_set_css_urls($css_url);
        
    }
    
}

if ( !function_exists('set_js_urls') ) {
    
    /**
     * The function set_js_urls sets the js links
     * 
     * @param array $js_url contains the js link parameters
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_js_urls($js_url) {

        md_set_js_urls($js_url);
        
    }
    
}

if ( !function_exists('set_the_title') ) {
    
    /**
     * The function set_the_title sets the page's title
     * 
     * @param string $title contains the title
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_the_title($title) {

        md_set_the_title($title);
        
    }
    
}

if ( !function_exists('set_admin_component_options') ) {
    
    /**
     * DEPRECATED
     * 
     * @param array $args contains the component's options for admin
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function set_admin_component_options($args) {

        // Require the Admin Components Options Inc
        require_once CMS_BASE_PATH . 'inc/components/user_options.php';

        
    }
    
}

if ( !function_exists('md_set_hook') ) {
    
    /**
     * The function md_set_hook registers a hook
     * 
     * @param string $hook_name contains the hook's name
     * @param function $function contains the function to call
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_hook($hook, $function) {

        md_set_hook($hook, $function);

    }
    
}

/*
|--------------------------------------------------------------------------
| REGISTER DEFAULT HOOKS
|--------------------------------------------------------------------------
*/

/**
 * The public method md_set_hook registers a hook
 * 
 * @since 0.0.7.9
 */
md_set_hook(
    'the_header',
    function () {

        // Get header code
        $footer = md_the_option('user_header_code');

        // Verify if header code exists
        if ( $footer ) {

            // Show code
            echo $footer;

        }

    }

);

/**
 * The public method md_set_hook registers a hook
 * 
 * @since 0.0.7.9
 */
md_set_hook(
    'the_footer',
    function () {

        // Get footer code
        $footer = md_the_option('user_footer_code');

        // Verify if footer code exists
        if ( $footer ) {

            // Show code
            echo $footer;

        }

        echo "<script src=\"" . base_url("assets/js/main.js?ver=" . MD_VER) . "\"></script>\n";

    }

);

/* End of file general.php */