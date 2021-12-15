<?php
/**
 * Categories Inc
 *
 * PHP Version 7.2
 *
 * This files contains the categories functions
 * used in faq's articles
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_faq_categories') ) {

    /**
     * The function the_faq_categories gets the Faq's categories
     * 
     * @return object with categories or boolean false
     */
    function the_faq_categories() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Get all categories
        return $CI->faq_model->get_categories();
        
    }

}