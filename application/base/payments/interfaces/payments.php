<?php
/**
 * Payments
 *
 * PHP Version 7.3
 *
 * Payments Interface for Payments Gateways
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Define the page namespace
namespace MidrubBase\Payments\Interfaces;

// Define the Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Payments interface - allows to create payments gateways for Midrub
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
interface Payments {

    /**
     * The public method check_availability checks if the gateway is available
     *
     * @return boolean true or false
     */
    public function check_availability();
    
    /**
     * The public method connect redirects user to the gateway's page
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function connect();

    /**
     * The public method save saves saves returned user's data
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function save();

    /**
     * The public method pay makes a payment
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function pay();    
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function ajax();

    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function cron_jobs();

    /**
     * The public method hooks contains the gateway's hooks
     * 
     * @param string $category contains the hooks category
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function load_hooks($category);

    /**
     * The public method guest contains the gateway's access for guests
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function guest();

    /**
     * The public method delete_subscription deletes subscribtions
     * 
     * @param array $subscribtion contains the subscribtion's data
     * 
     * @since 0.0.8.0
     * 
     * @return void
     */
    public function delete_subscription($subscribtion);
    
    /**
     * The public method gateway_info contains the gateway's info
     * 
     * @since 0.0.8.0
     * 
     * @return array with gateway's info
     */
    public function gateway_info();
    
}

/* End of file payments.php */
