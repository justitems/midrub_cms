<?php
/**
 * Admin
 *
 * PHP Version 5.6
 *
 * Admin Interface for Midrub's Base Admin
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace MidrubBase\Admin\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin interface - allows to create components for Admin's panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
interface Admin {
    
    /**
     * The public method init loads the component's main page in the user panel
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function init();
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function ajax();

    /**
     * The public method load_hooks by category
     * 
     * @since 0.0.7.8
     * 
     * @param string $category contains the hooks category
     * 
     * @return void
     */
    public function load_hooks($category);

    /**
     * The public method api_call processes the api's calls
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function api_call();
    
    /**
     * The public method component_info contains the admin component's info
     * 
     * @since 0.0.7.8
     * 
     * @return array with admin component's information
     */
    public function component_info();
 
}

/* End of file Admin.php */