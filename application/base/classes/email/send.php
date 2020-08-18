<?php
/**
 * Mail Send Class
 *
 * This file loads the Send Class with methods for email sending
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes\Email;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Send class loads the methods to send emails
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Send {

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
     * The public method send_mail sends an email
     * 
     * @param array $args contains the email's data
     * 
     * @since 0.0.7.8
     * 
     * @return true or false
     */
    public function send_mail($args) {

        // Verify if required fields exists
        if ( isset($args['from_name']) && isset($args['from_email']) && isset($args['to_email']) && isset($args['subject']) && isset($args['body']) ) {

            // Send
            $this->CI->email->from($args['from_email'], $args['from_name']);
            $this->CI->email->to($args['to_email']);
            $this->CI->email->subject($args['subject']);
            $this->CI->email->message($args['body']);

            // Verify if email was sent
            if ( $this->CI->email->send() ) {

                return true;

            } else {

                // Verify if we should debug response
                if ( isset($args['debug']) ) {

                    // Show error
                    echo $this->CI->email->print_debugger();

                }

                return false;

            }

        } else {

            return false;

        }

    } 

}

/* End of file send.php */