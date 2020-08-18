<?php
/**
 * General Inc
 *
 * This file contains the general functions
 * used in the Midrub's frontend
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_add_hook') ) {
    
    /**
     * The function md_add_hook registers a hook which can be called after
     * 
     * @param string $hook_name contains the hook's name
     * @param function $function contains the function to call
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_add_hook($hook_name, $function) {

        // Call the properties class
        $hooks = (new MidrubBase\Classes\Hooks);

        // Create hook or add function to an existing hook
        $hooks->add_hook($hook_name, $function);
        
    }
    
}

if ( !function_exists('md_run_hook') ) {
    
    /**
     * The function md_run_hook runs a hook based on hook name
     * 
     * @param string $hook_name contains the hook's name
     * @param array $args contains the function's args
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_run_hook($hook_name, $args) {

        // Call the properties class
        $hooks = (new MidrubBase\Classes\Hooks);

        // Runs a hook based on hook's name
        $hooks->run_hook($hook_name, $args);
        
    }
    
}

if ( !function_exists('md_set_the_title') ) {
    
    /**
     * The function md_set_the_title sets the page title
     * 
     * @param string $title contains the title
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_the_title($title) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set custom title if exists
        $properties->set_the_single_property('title', $title);
        
    }
    
}

if ( !function_exists('md_get_the_title') ) {
    
    /**
     * The function md_get_the_title displays the page title
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_title() {
        
        // Get codeigniter object instance
        $CI = get_instance();

        // Get custom title if exists
        $the_title = isset((new MidrubBase\Classes\Properties)::$the_single_property['title']) ? ' | ' . (new MidrubBase\Classes\Properties)::$the_single_property['title'] : '';
        
        // Display title
        echo $CI->config->item('site_name') . $the_title;
        
    }
    
}

if ( !function_exists('md_set_the_meta_description') ) {
    
    /**
     * The function md_set_the_meta_description sets the meta's description
     * 
     * @param string $description contains the meta's description
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_the_meta_description($description) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set meta description
        $properties->set_the_single_property('description', $description);
        
    }
    
}

if ( !function_exists('md_get_the_meta_description') ) {
    
    /**
     * The function md_get_the_meta_description gets meta's description
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_meta_description() {
        
        // Verify meta's description exists
        if ( isset((new MidrubBase\Classes\Properties)::$the_single_property['description']) ) {

            echo "<meta name=\"description\" content=\"" . (new MidrubBase\Classes\Properties)::$the_single_property['description'] . "\" />\n";

        }
        
    }
    
}

if ( !function_exists('md_set_the_meta_keywords') ) {
    
    /**
     * The function md_set_the_meta_keywords sets the meta's keywords
     * 
     * @param string $keywords contains the meta's keywords
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_the_meta_keywords($keywords) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set meta keywords
        $properties->set_the_single_property('keywords', $keywords);
        
    }
    
}

if ( !function_exists('md_get_the_meta_keywords') ) {
    
    /**
     * The function md_get_the_meta_keywords gets meta's keywords
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_meta_keywords() {
        
        // Verify meta's keywords exists
        if ( isset((new MidrubBase\Classes\Properties)::$the_single_property['keywords']) ) {

            echo "<meta name=\"keywords\" content=\"" . (new MidrubBase\Classes\Properties)::$the_single_property['keywords'] . "\" />\n";

        }
        
    }
    
}

if ( !function_exists('md_set_css_urls') ) {
    
    /**
     * The function md_set_css_urls sets the css links
     * 
     * @param array $css_url contains the css link parameters
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_css_urls($css_url) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set css links with parameters
        $properties->set_the_multiple_properties('css_urls', $css_url);
        
    }
    
}

if ( !function_exists('md_get_the_css_urls') ) {
    
    /**
     * The function md_get_the_css_urls displays the css links
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_css_urls() {
        
        // Verify if css urls exists
        if ( isset( (new MidrubBase\Classes\Properties)::$the_multilpe_properties['css_urls'] ) )  {

            $i = 0;

            foreach ( (new MidrubBase\Classes\Properties)::$the_multilpe_properties['css_urls'] as $array ) {

                if ( !isset($array[0]) || !isset($array[1]) || !isset($array[2]) ) {
                    continue;
                }

                $media = '';

                if ( isset($array[3]) ) {

                    if ( $array[3] ) {

                        $media = ' media="' . $array[3] . '"';

                    }

                }

                if ( $i > 0 ) {
                    echo "\x20\x20\x20\x20";
                }

                echo "<link rel=\"" . $array[0] . "\" href=\"" . $array[1] . "\" type=\"" . $array[2] . "\"" . $media . " />\r\n";

                $i++;

            }

        }
        
    }
    
}

if ( !function_exists('md_set_js_urls') ) {
    
    /**
     * The function md_set_js_urls sets the js links
     * 
     * @param array $js_url contains the js link parameters
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_js_urls($js_url) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set js links with parameters
        $properties->set_the_multiple_properties('js_urls', $js_url);
        
    }
    
}

if ( !function_exists('md_get_the_js_urls') ) {
    
    /**
     * The function md_get_the_js_urls displays the js links
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_js_urls() {
        
        // Verify if js urls exists
        if ( isset((new MidrubBase\Classes\Properties)::$the_multilpe_properties['js_urls']) ) {

            $i = 0;

            foreach ( (new MidrubBase\Classes\Properties)::$the_multilpe_properties['js_urls'] as $array ) {

                if ( !isset($array[0]) ) {
                    continue;
                }

                echo "<script src=\"" . $array[0] . "\"></script>\r\n";
                $i++;


            }

        }
        
    }
    
}

if ( !function_exists('md_set_component_variable') ) {
    
    /**
     * The function md_set_component_variable sets the component's variable
     * 
     * @param string $name contains the variable's name
     * @param string $value contains the variable value
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_component_variable($name, $value) {

        // Call the properties class
        $properties = (new MidrubBase\Classes\Properties);

        // Set the variable name and value
        $properties->set_the_single_property($name, $value);
        
    }
    
}

if ( !function_exists('md_the_component_variable') ) {
    
    /**
     * The function md_the_component_variable returns variable value
     * 
     * @since 0.0.7.8
     * 
     * @return string with variable value or boolean false
     */
    function md_the_component_variable($name) {

        if ( isset((new MidrubBase\Classes\Properties)::$the_single_property[$name]) ) {

            return (new MidrubBase\Classes\Properties)::$the_single_property[$name];

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_get_the_website_favicon') ) {
    
    /**
     * The function md_get_the_website_favicon displays favicon link if exists
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_the_website_favicon() {

        // Get favicon
        $favicon = get_option("favicon");

        // Verify if favicon exists
        if ($favicon) {

            echo '<link rel="shortcut icon" href="' . $favicon . '" />';

        } else {

            echo '<link rel="shortcut icon" href="' . base_url('assets/img/favicon.png') . '" />';

        }
        
    }
    
}

if ( !function_exists('md_include_component_file') ) {
    
    /**
     * The function md_include_component_file requires a file
     * 
     * The string $path contains the file path
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_include_component_file($path) {
        
        // Get codeigniter object instance
        $CI = get_instance();

        if ( file_exists($path) ) {
            
            $CI->load->file($path);

        }
        
    }
    
}

if ( !function_exists('md_the_user_session') ) {
    
    /**
     * The function md_the_user_session if session exists will return user information
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_the_user_session() {
        
        // Verify if user data exists
        if ( isset((new MidrubBase\Classes\Properties)::$the_single_property['user_data']) ) {

            // User data
            $user_data = (new MidrubBase\Classes\Properties)::$the_single_property['user_data'];

            if ( $user_data['role'] < 1 ) {

                // Get codeigniter object instance
                $CI = get_instance();

                // Get the user's plan
                $plan_id = get_user_option('plan', $CI->user_id);

                // Redirect url
                $redirect_url = base_url('user/app/dashboard');

                // Verify if the plan has a selected user_redirect
                if ( plan_feature( 'user_redirect', $plan_id ) ) {

                    // Get user_redirect
                    $user_redirect = plan_feature( 'user_redirect', $plan_id );

                    // Verify if the redirect is a component
                    if ( is_dir(MIDRUB_BASE_USER . 'components/collection/' . $user_redirect . '/') ) {
                        
                        // Get the component
                        $cl = implode('\\', array('MidrubBase', 'User', 'Components', 'Collection', ucfirst($user_redirect), 'Main'));

                        // Verify if the component is available
                        if ( (new $cl())->check_availability() ) {

                            // Set new redirect
                            $redirect_url = site_url('user/' . $user_redirect);

                        }

                    } else if ( is_dir(MIDRUB_BASE_USER . 'apps/collection/' . $user_redirect . '/') ) {

                        // Get the app
                        $cl = implode('\\', array('MidrubBase', 'User', 'Apps', 'Collection', ucfirst($user_redirect), 'Main'));

                        // Verify if the app is available
                        if ( (new $cl())->check_availability() ) {

                            // Set new redirect
                            $redirect_url = site_url('user/app/' . $user_redirect);

                        }

                    }
                    
                }

                // Set redirect
                $user_data['redirect'] = $redirect_url;

            } else {

                // Set redirect
                $user_data['redirect'] = site_url('admin/home');                

            }

            return $user_data;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_set_config_item') ) {
    
    /**
     * The function md_set_config_item sets the config's item
     * 
     * @param string $slug contains the item's slug
     * @param string $value contains the new item's value
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_set_config_item($slug, $value) {
        
        // Get codeigniter object instance
        $CI = get_instance();

        $CI->config->set_item($slug, $value);
        
    }
    
}