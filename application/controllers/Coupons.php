<?php
/**
 * Coupons Controller
 *
 * PHP Version 5.6
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
class Coupons extends MY_Controller {
    
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
        
        // Load User Model
        $this->load->model('user');
        
        // Load User Meta Model
        $this->load->model('user_meta');
        
        // Load Tickets Model
        $this->load->model('tickets');
        
        // Load Coupons Model
        $this->load->model('codes');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        if ( isset($this->session->userdata['username']) ) {
            
            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
            
            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
            
            // Set user_status
            $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);
            
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php') ) {
            
            // load the alerts language file
            $this->lang->load( 'default_alerts', $this->config->item('language') );
            
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_admin_lang.php') ) {
            
            // load the admin language file
            $this->lang->load( 'default_admin', $this->config->item('language') );
            
        }
        
    }
    
    /**
     * The public method codes display a list with all available coupon codes
     * 
     * @return void
     */
    public function codes() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Create the alert message
        $alert = '';
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('value', 'Value', 'trim');
            $this->form_validation->set_rules('type', 'Type', 'trim');
            
            // get data
            $value = $this->input->post('value');
            $type = $this->input->post('type');
            
            if ( $this->form_validation->run() == false ) {
                
                display_mess(12);
                
            } else {
                
                if ( $this->codes->save_coupon( $value, $type ) ) {
                    
                    $alert = display_mess( '144' );
                    
                } else {
                    
                    $alert = display_mess( '145' );
                    
                }
                
            }
            
        }
        
        // Get statistics template
        $this->body = 'admin/coupon-codes';
        
        // Set the content
        $this->content = [
            'alert' => $alert
        ];
        
        // Load the admin layout
        $this->admin_layout();
        
    }
    
    /**
     * The public method get_all_codes gets all available codes by page
     * 
     * @param integer $page contains the page's number
     * 
     * @return void
     */
    public function get_all_codes( $page ) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        $limit = 10;
        $page--;
        $current_page = $page * $limit;
        
        $total = $this->codes->get_codes( $current_page );
        
        $coupons = $this->codes->get_codes( $current_page, $limit );
        
        if ( $coupons ) {
            
            echo json_encode(['total' => $total, 'coupons' => $coupons]);
            
        }
        
    }
    
    /**
     * The public method delete_code deletes a coupon code
     *
     * @param integer $code contains the coupon_id
     * 
     * @return void
     */
    public function delete_code( $code ) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        $delete_coupon = $this->codes->delete_coupon( $code );
        
        if ( $delete_coupon ) {
            
            echo json_encode(display_mess(146));
            
        } else {
            
            echo json_encode(display_mess(147));
            
        }
        
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
            $this->user_meta->update_user_meta( $this->user_id, 'user_coupon_code', $code );
            
            // Set the user discount value
            $this->user_meta->update_user_meta( $this->user_id, 'user_coupon_value', $coupon_code[0]->value );

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
