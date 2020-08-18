<?php
/**
 * Change Password Class
 *
 * This file loads the Change Class with properties and methods for change password process
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Auth\Classes\Change;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Email as MidrubBaseClassesEmail;

/*
 * Change class loads the properties and methods for change password process
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Change {
    
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

        // Load the bcrypt library
        $this->CI->load->library('bcrypt');
        
    }

    /**
     * The public method change_password changes user's password
     * 
     * @param integer $user_id contains the user's id
     * @param string $reset_code contains the reset code
     * @param string $new_password contains the new password
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function change_password($user_id, $reset_code, $new_password) {

        // Verify if password has right length
        if ( ( strlen($new_password) < 6 ) || ( strlen($new_password) > 20 ) ) {

            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_change_password_password_too_short')
            );

            echo json_encode($data);
            
        } elseif ( preg_match('/\s/', $new_password) ) {
            
            // Display error message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('auth_change_password_password_has_white_spaces')
            );

            echo json_encode($data);
            
        } else {

            // Encrypt the password
            $encrypted_password = $this->CI->bcrypt->hash_password($new_password);

            // Save activation code in user's data from database
            $save_password = $this->CI->base_model->update_ceil('users', array('user_id' => $user_id, 'reset_code' => $reset_code), array('password' => $encrypted_password));
            
            // Verify if password was changed
            if ( $save_password ) {

                // Default redirect
                $redirect = $this->get_plan_redirect($user_id);

                // Display success message
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('auth_change_password_password_was_changed'),
                    'redirect' => $redirect
                );

                echo json_encode($data);                
                
            } else {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('auth_change_password_password_was_not_changed')
                );

                echo json_encode($data);
                
            }
            
        }

    }


    /**
     * The private method get_plan_redirect gets redirect for the user plan
     * 
     * @param integer $user_id contains the user's id
     * 
     * @since 0.0.8.2
     * 
     * @return string with redirect's url
     */
    private function get_plan_redirect($user_id) {
        
        // Get the user's plan
        $plan_id = get_user_option('plan', $user_id);

        // Redirect url
        $redirect_url = base_url('user/app/dashboard');

        // Verify if the plan has a selected user_redirect
        if ( plan_feature( 'user_redirect', $plan_id ) ) {

            // Get user_redirect
            $user_redirect = plan_feature( 'user_redirect', $plan_id );

            // Verify if the redirect is a component
            if ( is_dir(MIDRUB_BASE_USER . 'components/collection/' . $user_redirect . '/') ) {
                
                // Get the component
                $cl = implode('\\', array('MidrubBase', 'User', 'Components', 'Collection', ucfirst($user_redirect), 'Main'));

                // Verify if the component is available
                if ( (new $cl())->check_availability() ) {

                    // Set new redirect
                    $redirect_url = site_url('user/' . $user_redirect);

                }

            } else if ( is_dir(MIDRUB_BASE_USER . 'apps/collection/' . $user_redirect . '/') ) {

                // Get the app
                $cl = implode('\\', array('MidrubBase', 'User', 'Apps', 'Collection', ucfirst($user_redirect), 'Main'));

                // Verify if the app is available
                if ( (new $cl())->check_availability() ) {

                    // Set new redirect
                    $redirect_url = site_url('user/app/' . $user_redirect);

                }

            }
            
        }

        // Return the redirect
        return $redirect_url;
        
    }

}
