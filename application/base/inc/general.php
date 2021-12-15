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

if ( !function_exists('md_set_hook') ) {
    
    /**
     * The function md_set_hook registers a hook which can be called after
     * 
     * @param string $hook_name contains the hook's name
     * @param function $function contains the function to call
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_hook($hook_name, $function) {

        // Call the properties class
        $hooks = (new CmsBase\Classes\Hooks);

        // Create hook or add function to an existing hook
        $hooks->md_set_hook($hook_name, $function);
        
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
        $hooks = (new CmsBase\Classes\Hooks);

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
        $properties = (new CmsBase\Classes\Properties);

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
        $the_title = isset((new CmsBase\Classes\Properties)::$the_single_property['title']) ? ' | ' . (new CmsBase\Classes\Properties)::$the_single_property['title'] : '';
        
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
        $properties = (new CmsBase\Classes\Properties);

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
        if ( isset((new CmsBase\Classes\Properties)::$the_single_property['description']) ) {

            echo "<meta name=\"description\" content=\"" . (new CmsBase\Classes\Properties)::$the_single_property['description'] . "\" />\n";

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
        $properties = (new CmsBase\Classes\Properties);

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
        if ( isset((new CmsBase\Classes\Properties)::$the_single_property['keywords']) ) {

            echo "<meta name=\"keywords\" content=\"" . (new CmsBase\Classes\Properties)::$the_single_property['keywords'] . "\" />\n";

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
        $properties = (new CmsBase\Classes\Properties);

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
        if ( isset( (new CmsBase\Classes\Properties)::$the_multilpe_properties['css_urls'] ) )  {

            $i = 0;

            foreach ( (new CmsBase\Classes\Properties)::$the_multilpe_properties['css_urls'] as $array ) {

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
        $properties = (new CmsBase\Classes\Properties);

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
        if ( isset((new CmsBase\Classes\Properties)::$the_multilpe_properties['js_urls']) ) {

            $i = 0;

            foreach ( (new CmsBase\Classes\Properties)::$the_multilpe_properties['js_urls'] as $array ) {

                if ( !isset($array[0]) ) {
                    continue;
                }

                echo "<script src=\"" . $array[0] . "\"></script>\r\n";
                $i++;


            }

        }
        
    }
    
}

if ( !function_exists('md_set_data') ) {
    
    /**
     * The function md_set_data sets the component's variable
     * 
     * @param string $name contains the variable's name
     * @param string $value contains the variable value
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_data($name, $value) {

        // Call the properties class
        $properties = (new CmsBase\Classes\Properties);

        // Set the variable name and value
        $properties->set_the_single_property($name, $value);
        
    }
    
}

if ( !function_exists('md_the_data') ) {
    
    /**
     * The function md_the_data returns variable value
     * 
     * @since 0.0.7.8
     * 
     * @return string with variable value or boolean false
     */
    function md_the_data($name) {

        if ( isset((new CmsBase\Classes\Properties)::$the_single_property[$name]) ) {

            return (new CmsBase\Classes\Properties)::$the_single_property[$name];

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
        $favicon = md_the_option('favicon');

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
        if ( isset((new CmsBase\Classes\Properties)::$the_single_property['user_data']) ) {

            // User data
            $user_data = (new CmsBase\Classes\Properties)::$the_single_property['user_data'];

            if ( $user_data['role'] < 1 ) {

                // Get codeigniter object instance
                $CI = get_instance();

                // Verify if BASE User exists
                if ( !defined('CMS_BASE_USER') ) {

                    define('CMS_BASE_USER', APPPATH . 'base/user/');
                    
                    // Require the general functions file
                    require_once CMS_BASE_USER . 'inc/general.php';

                }

                // Get the user's plan
                $plan_id = md_the_user_option($CI->user_id, 'plan');

                // Redirect url
                $redirect_url = base_url('user/app/dashboard');

                // Verify if the plan has a selected user_redirect
                if ( md_the_plan_feature( 'user_redirect', $plan_id ) ) {

                    // Get user_redirect
                    $user_redirect = md_the_plan_feature( 'user_redirect', $plan_id );

                    // Verify if the redirect is a component
                    if ( is_dir(APPPATH . 'base/user/components/collection/' . $user_redirect . '/') ) {
                        
                        // Get the component
                        $cl = implode('\\', array('CmsBase', 'User', 'Components', 'Collection', ucfirst($user_redirect), 'Main'));

                        // Verify if the component is available
                        if ( (new $cl())->check_availability() ) {

                            // Set new redirect
                            $redirect_url = site_url('user/' . $user_redirect);

                        }

                    } else if ( is_dir(APPPATH . 'base/user/apps/collection/' . $user_redirect . '/') ) {

                        // Get the app
                        $cl = implode('\\', array('CmsBase', 'User', 'Apps', 'Collection', ucfirst($user_redirect), 'Main'));

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
                $user_data['redirect'] = site_url('admin/dashboard');                

            }

            return $user_data;

        } else {

            return false;

        }
        
    }
    
}

if ( !function_exists('md_the_date_format') ) {
    
    /**
     * The function md_the_date_format provides the user wanted date format
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @return string with date format
     */
    function md_the_date_format($user_id) {

        // Get date's format
        return md_the_user_option($user_id, 'user_date_format')?md_the_user_option($user_id, 'user_date_format'):'dd/mm/yyyy';

    }

}

if ( !function_exists('md_the_time_format') ) {
    
    /**
     * The function md_the_time_format provides the user wanted time format
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @return string with time format
     */
    function md_the_time_format($user_id) {

        // Get time's format
        return md_the_user_option($user_id, 'user_time_format')?md_the_user_option($user_id, 'user_time_format'):'hh:ii';

    }

}

if ( !function_exists('md_the_calculate_time') ) {
    
    /**
     * The function md_the_hours_format calculates the time
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $time contains the user's time
     * 
     * @return string with time
     */
    function md_the_calculate_time($user_id, $time) {

        // Time format
        $format = (md_the_time_format($user_id) === 'hh:ii')?'h:i':'h:i:s';

        // Calculate time
        return (md_the_hours_format($user_id) === '12')?date($format . ' a', $time):date(str_replace('h', 'H', $format), $time);

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

if ( !function_exists('md_update_option') ) {

    /**
     * The function md_update_option updates/creates an option
     * 
     * @param string $name contains the option's name
     * @param string $value contains the new option's value
     * 
     * @return boolean true or false
     */
    function md_update_option( $name, $value ) {

        // Save the option
        return (new CmsBase\Classes\Options)->update_option( $name, $value );
        
    }

}

if ( !function_exists('md_the_option') ) {

    /**
     * The function md_the_option returns option by option's name
     * 
     * @param string $name contains the option's name
     * 
     * @return string with option's value
     */
    function md_the_option( $name ) {
        
        // Return the option
        return (new CmsBase\Classes\Options)->md_the_option($name);
        
    }

}

if ( !function_exists('md_delete_option') ) {

    /**
     * The function md_delete_option deletes an option
     * 
     * @param string $name contains the option's name
     * 
     * @return string with option's value
     */
    function md_delete_option( $name ) {

        // Delete the option
        return (new CmsBase\Classes\Options)->delete_option( $name );
        
    }

}

if ( !function_exists('md_smtp') ) {

    /**
     * The function provides the md_smtp configuration
     * 
     * @return array with smtp's configuration
     */
    function md_smtp() {
        
        // Verify if the smtp option is enabled
        if (md_the_option('smtp_enabled') ) {
            
            // Set the default protocol
            $protocol = 'sendmail';
            
            // Verify if user have added a protocol
            if (md_the_option('smtp_protocol') ) {
                
                $protocol = md_the_option('smtp_protocol');
                
            }
            
            // Create the configuration array
            $d = array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'smtpauth' => true,
                'priority' => '1',
                'newline' => "\r\n",
                'protocol' => $protocol,
                'smtp_host' => md_the_option('smtp_host'),
                'smtp_port' => md_the_option('smtp_port'),
                'smtp_user' => md_the_option('smtp_username'),
                'smtp_pass' => md_the_option('smtp_password')
            );
            
            // Verify if ssl is enabled
            if (md_the_option('smtp_ssl')) {
                
                $d['smtp_crypto'] = 'ssl';
                
            } elseif (md_the_option('smtp_tls')) {
                
                // Set TSL if is enabled
                $d['smtp_crypto'] = 'tls';
                
            }
            
            return $d;
            
        } else {
            
            return ['mailtype' => 'html', 'charset' => 'utf-8', 'newline' => "\r\n", 'priority' => '1'];
            
        }
        
    }

}



if ( !function_exists( 'md_calculate_size' ) ) {
    
    /**
     * The function md_calculate_size calculates the size
     * 
     * @param integer $size contains size in bytes
     * 
     * @return string with size
     */
    function md_calculate_size($size) {
        if (!$size) {
            return '0';
        }
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');
        if ( isset($suffixes[floor($base)]) ) {
            return round(pow(1024, $base - floor($base)), 2) . ' ' . $suffixes[floor($base)];
        } else {
            return '0';
        }
        
    }

}

if ( !function_exists('md_smtp') ) {

    /**
     * The function md_smtp provides the smtp's configuration
     * 
     * @return array with smtp's configuration
     */
    function md_smtp() {
        
        // Verify if the smtp option is enabled
        if (md_the_option('smtp_enabled') ) {
            
            // Set the default protocol
            $protocol = 'sendmail';
            
            // Verify if user have added a protocol
            if (md_the_option('smtp_protocol') ) {
                
                $protocol = md_the_option('smtp_protocol');
                
            }
            
            // Create the configuration array
            $d = array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'smtpauth' => true,
                'priority' => '1',
                'newline' => "\r\n",
                'protocol' => $protocol,
                'smtp_host' => md_the_option('smtp_host'),
                'smtp_port' => md_the_option('smtp_port'),
                'smtp_user' => md_the_option('smtp_username'),
                'smtp_pass' => md_the_option('smtp_password')
            );
            
            // Verify if ssl is enabled
            if (md_the_option('smtp_ssl')) {
                
                $d['smtp_crypto'] = 'ssl';
                
            } elseif (md_the_option('smtp_tls')) {
                
                // Set TSL if is enabled
                $d['smtp_crypto'] = 'tls';
                
            }
            
            return $d;
            
        } else {
            
            return array(
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'newline' => "\r\n",
                'priority' => '1'
            );
            
        }
        
    }

}

if ( !function_exists('md_get_the_file') ) {
    
    /**
     * The function md_get_the_file gets a file
     * 
     * @param string $file_path contains the file's path
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    function md_get_the_file($file_path) {

        md_include_component_file($file_path);

    }
    
}

/* End of file general.php */