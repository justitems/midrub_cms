<?php
/**
 * Social
 *
 * PHP Version 5.6
 *
 * Autopost Interface for Login Classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace MidrubBase\Auth\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Social interface - allows to create components for social's classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
interface Social {

    /**
     * The public method check_availability verifies if social class is configured
     * 
     * @since 0.0.7.8
     * 
     * @return boolean true or false
     */
    public function check_availability();

    /**
     * The public method connect redirects user to social network where should approve permissions
     * 
     * @param string $redirect_url contains the redirect url
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function connect($redirect_url=NULL);

    /**
     * The public method save gets the access token and saves it
     * 
     * @param string $redirect_url contains the redirect url
     * 
     * @since 0.0.7.8
     * 
     * @return array with response
     */
    public function save($redirect_url=NULL);

    /**
     * The public method login uses the access token to verify if user is register already
     * 
     * @param string $redirect_url contains the redirect url
     * 
     * @since 0.0.7.8
     * 
     * @return array with response
     */
    public function login($redirect_url=NULL);    

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network data
     */
    public function get_info();

}
