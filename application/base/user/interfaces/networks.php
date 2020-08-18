<?php
/**
 * Networks
 *
 * PHP Version 5.6
 *
 * Networks Interface for Midrub's User Networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace MidrubBase\User\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Networks interface - allows to create network classes for User's panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
interface Networks {
    
    /**
     * The public method check_availability checks if the network api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability();

    /**
     * The public method connect will redirect user to network login page.
     * 
     * @return void
     */
    public function connect();

    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function save($token = null);

    /**
     * The public method post publishes posts on network
     *
     * @param $args contains the post data.
     * @param $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = NULL);

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network's data
     */
    public function get_info();

    /**
     * The public preview generates a preview for network
     *
     * @param $args contains the img or url.
     * 
     * @return array with html content
     */
    public function preview($args);
 
}

/* End of file networks.php */
