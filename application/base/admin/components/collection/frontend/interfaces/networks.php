<?php
/**
 * Networks
 *
 * PHP Version 7.4
 *
 * Networks Interface for Social Access
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Interfaces;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Networks interface - allows to create network classes for social login
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
     * @param string $redirect_url contains the redirect's url
     * 
     * @return void
     */
    public function connect($redirect_url);  
    
    /**
     * The public method callback generates the access token
     * 
     * @param string $redirect_url contains the redirect's url
     * 
     * @return void
     */
    public function callback($redirect_url);  

    /**
     * The public method info provides information about this class
     * 
     * @return array with network's data
     */
    public function info();
 
}

/* End of file networks.php */