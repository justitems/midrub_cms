<?php
/**
 * Networks
 *
 * PHP Version 7.4
 *
 * Networks Interface for Midrub's User Networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\User\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Networks interface - allows to create network classes for User's panel
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
interface Networks {
    
    /**
     * The public method availability checks if the network api is configured correctly
     *
     * @return boolean true or false
     */
    public function availability();

    /**
     * The public method connect requests the access token
     *
     * @return void
     */
    public function connect();  
    
    /**
     * The public method callback generates the access token
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function callback($token = null);
    
    /**
     * The public method actions executes the actions
     *
     * @param string $action contains the action's name
     * @param array $params contains the request's params
     * 
     * @return array with response
     */
    public function actions($action, $params);    

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info();
 
}

/* End of file networks.php */