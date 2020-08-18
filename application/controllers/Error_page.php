<?php
/**
 * Error_page Controller
 *
 * PHP Version 5.6
 *
 * Error_page contains the Error_page class to display errors page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}

/**
 * Error_page class - contains the method to display errors page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Error_page extends MY_Controller {
    
    /**
     * Initialise the Error_page controller
     */
    public function __construct() {
        parent::__construct();
        
        // Load URL Helper
        $this->load->helper('url');
        
    }
    
    /**
     * The public method show_error displays an error's page
     * 
     * @param string $type contains the error's type
     * 
     * @return void
     */
    public function show_error($type) {
        
        switch ( $type ) {

            case 'no-user-theme':

                // Load no-user-theme page
                $this->load->ext_view(APPPATH . 'views/errors/html', 'no_user_theme', array());

                break;

            case 'maintenance':

                // Load maintenance page
                $this->load->ext_view(APPPATH . 'views/errors/html', 'maintenance', array());

                break;

        }
        
    }  
    
}

/* End of file Error.php */
