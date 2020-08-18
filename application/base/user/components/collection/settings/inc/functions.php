<?php
/**
 * Functions Inc
 *
 * PHP Version 7.2
 *
 * This files contains the functions used
 * in the view's files
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('display_plan_usage') ) {
    
    /**
     * The function display_plan_usage displays plan's usage
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    function display_plan_usage() {

        // Get plan's usage
        $plan_usages = the_plans_usage();

        // Verify if plan's usages exists
        if ( $plan_usages ) {

            // List all usages
            foreach ( $plan_usages as $plan_usage ) {

                // Get usage's left
                $usage_left = ($plan_usage['limit'] < 1)?'0':number_format((100 - (($plan_usage['limit'] - $plan_usage['value']) / $plan_usage['limit']) * 100));
        
                // Get processbar color
                if ( $usage_left < 90 ) {
                    $color = ' theme-background-green';
                } else {
                    $color = ' theme-background-red';
                }

                // Display usage
                echo '<li>'
                        . '<div class="row">'
                            . '<div class="col-xl-9 col-sm-8 col-6">'
                                . $plan_usage['name']
                            . '</div>'
                            . '<div class="col-xl-3 col-sm-4 col-6 text-right">'
                                . $plan_usage['left']
                            . '</div>'
                        . '</div>'
                        . '<div class="progress">'
                            . '<div class="progress-bar' . $color . '" role="progressbar" style="width: ' . $usage_left . '%" aria-valuenow="' . $usage_left . '" aria-valuemin="0" aria-valuemax="100"></div>'
                        . '</div>'
                    . '</li>';

            }

        }
        
    }
    
}

if ( !function_exists('get_option_template') ) {
    
    /**
     * The function get_option_template shows the option's template
     * 
     * @param array $option contains an array with option's data
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    function get_option_template($option) {

        // Verify if class has the method
        if (method_exists((new MidrubBase\User\Components\Collection\Settings\Helpers\Options_templates), $option['type'])) {

            // Set the method to call
            $method = $option['type'];

            // Display option
            echo (new MidrubBase\User\Components\Collection\Settings\Helpers\Options_templates)->$method($option);
        }
        
    }
    
}

if ( !function_exists('settings_language_list') ) {

    /**
     * The function settings_language_list provides the language list
     * 
     * @return array with languages
     */
    function settings_language_list() {

        // Get codeigniter object instance
        $CI = get_instance();

        // Language list
        $language_list = array();

        // List all languages
        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

        if ( $languages ) {

            foreach ( $languages as $language ) {

                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                $selected = false;

                if ( ( $CI->config->item('language') === $only_dir ) && !get_user_option('user_language') ) {
                    $selected = true;
                }

                if ( get_user_option('user_language') === $only_dir ) {
                    $selected = true;
                }

                $language_list[] = array(
                    'value' => $only_dir,
                    'text' => ucfirst($only_dir),
                    'selected' => $selected
                );

            }

        }

        return $language_list;

    }

}

/* End of file functions.php */