<?php
/**
 * Plugins
 *
 * PHP Version 7.3
 *
 * Plugins Interface for Midrub's Plugins
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace CmsBase\Interfaces;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins interface - allows to create plugins for Midrub
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms/blob/master/license
 * @link     https://www.midrub.com/
 */
interface Plugins {
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function ajax();

    /**
     * The public method rest processes the rest's requests
     * 
     * @param string $endpoint contains the requested endpoint
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function rest($endpoint);
    
    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function cron_jobs();
    
    /**
     * The public method delete_account is called when user's account is deleted
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function delete_account($user_id);
    
    /**
     * The public method hooks contains the plugin's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function load_hooks($category);
    
    /**
     * The public method plugin_info contains the plugin's info
     * 
     * @since 0.0.8.4
     * 
     * @return array with plugin's info
     */
    public function plugin_info();
    
}

/* End of file plugins.php */
