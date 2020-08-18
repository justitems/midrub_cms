<?php
/**
 * Referrals Helpers
 *
 * This file contains the class Referrals
 * with methods to manage the referrals
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Settings\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Referrals class provides the methods to manage the referrals
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Referrals {
    
    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method save_admin_settings saves the admin's settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_referrals_reports() {
        
        // Load Referrals Model
        $this->CI->load->model('referrals');
        
        // Get page's input
        $page = $this->CI->input->get('page');
        
        // Get date_from's input
        $date_from = $this->CI->input->get('date_from');

        // Get date_to's input
        $date_to = $this->CI->input->get('date_to');        
        
        if ( is_numeric($page) ) {
            
            // Set the limit
            $limit = 10;
            $page--;
            
            // Get referrals by page
            $referrals = $this->CI->referrals->get_referrals( $page * $limit, $limit, $date_from, $date_to );
            
            if ( $referrals ) {
            
                $data = array(
                    'success' => TRUE,
                    'referrals' => $referrals,
                    'time' => time(),
                    'words' => array(
                        'free' => $this->CI->lang->line('free'),
                        'paid' => $this->CI->lang->line('paid'),
                    ),
                    'page' => ($page + 1)
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_referrals_found')
                );

                echo json_encode($data);                
                
            }
            
        }
        
    }
    
    /**
     * The public method load_referrers_list loads referrers list
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_referrers_list() {
        
        // Load Referrals Model
        $this->CI->load->model('referrals');
        
        // Get page's input
        $page = $this->CI->input->get('page');     
        
        if ( is_numeric($page) ) {
            
            // Set the limit
            $limit = 10;
            $page--;
            
            // Get referrals by page
            $referrals = $this->CI->referrals->get_referrers( $page * $limit, $limit );
            
            if ( $referrals ) {
            
                $data = array(
                    'success' => TRUE,
                    'referrals' => $referrals,
                    'time' => time(),
                    'words' => array(
                        'has_non_paid_gains' => $this->CI->lang->line('has_non_paid_gains'),
                        'dont_has_non_paid_gains' => $this->CI->lang->line('dont_has_non_paid_gains'),
                        'pay' => $this->CI->lang->line('pay'),
                    ),
                    'page' => ($page + 1)
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_referrers_found')
                );

                echo json_encode($data);                
                
            }
            
        }
        
    }
    
    /**
     * The public method referral_pay_gains pays user gains
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function referral_pay_gains() {
        
        // Load Referrals Model
        $this->CI->load->model('referrals');
        
        // Get user_id's input
        $user_id = $this->CI->input->get('user_id');     
        
        if ( is_numeric($user_id) ) {
            
            // Mark as paid the user's gains
            $referrals = $this->CI->referrals->pay_referrers_earns( $user_id );
            
            if ( $referrals ) {
            
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('changes_were_saved')
                    
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('changes_were_not_saved')
                );

                echo json_encode($data);                
                
            }
            
        }
        
    }

}

/* End of file referrals.php */