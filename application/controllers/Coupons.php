<?php
/**
 * Coupons Controller
 *
 * PHP Version 7.3
 *
 * Coupons contains the Coupons class for Admin Coupons
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
 * Coupons class - contains all methods for Admin Coupons
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Coupons extends CI_Controller {
    
    /**
     * Class variables
     */   
    private $user_id, $user_role;
    
    /**
     * Initialise the Coupons controller
     */
    public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
    }
    
    /**
     * The public method verify_coupon verifies if the coupon is valid
     * 
     * @param string $code contains the coupon's code
     * 
     * @return void
     */
    public function verify_coupon( $code ) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Verify if the coupon code exists
        $coupon_code = $this->codes->get_code( $code );
        
        if ( $coupon_code ) {
            
            // Set the user coupon code
            //$this->user_meta->update_user_meta( $this->user_id, 'user_coupon_code', $code );
            
            // Set the user discount value
            //$this->user_meta->update_user_meta( $this->user_id, 'user_coupon_value', $coupon_code[0]->value );

            // Prepare the response
            $response = array(
                'success' => TRUE,
                'message' => $this->lang->line('mm217'),
                'value' => $coupon_code[0]->value
            );
            
            // Display response
            echo json_encode( $response );
            
        } else {

            // Prepare the response
            $response = array(
                'success' => FALSE,
                'message' => $this->lang->line('mm216')
            );
            
            // Display response
            echo json_encode( $response );            

        }
        
    }
 
}

/* End of file Coupons.php */
