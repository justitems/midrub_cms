<?php
/**
 * User Controller
 *
 * This file loads the Notifications component in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Notifications\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User class loads the Notifications's content
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load language
        $this->CI->lang->load( 'notifications_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS );

        // Load Notifications Model
        $this->CI->load->ext_model( MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_model', 'notifications_model' );
        
    }
    
    /**
     * The public method view loads the component's template
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function view() {

        // Set the Notifications styles
        set_css_urls(array('stylesheet', base_url('assets/base/user/components/collection/notifications/styles/css/styles.css?ver=' . MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS_VERSION), 'text/css', 'all'));
        
        // Set the Main Notifications Js
        set_js_urls(array(base_url('assets/base/user/components/collection/notifications/js/main.js?ver=' . MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS_VERSION)));
        
        // Set the user's view
        $this->set_user_view();
        
    }

    /**
     * The public method set_user_view prepare and add in the queue the user view
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function set_user_view() {

        // Verify if single page exists
        if ( $this->CI->input->get('p', TRUE) ) {

            switch ( $this->CI->input->get('p', TRUE) ) {

                case 'notifications':

                    // Verify if notification page exists
                    if ( $this->CI->input->get('notification', TRUE) ) {

                        // Get notification
                        $notification = $this->CI->notifications_model->get_notification($this->CI->user_id, $this->CI->input->get('notification', TRUE) );
                        
                        if ( $notification ) {

                            // Prepare view params
                            $params = array(
                                'notification' => $notification,
                                'page' => 'notifications'
                            );

                            // Set views params
                            set_user_view(

                                $this->CI->load->ext_view(
                                    MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views',
                                    'notification',
                                    $params,
                                    true
                                )

                            );                            

                        } else {

                            show_404();

                        }

                    } else {

                        // Get Notifications
                        $notifications = $this->CI->notifications_model->get_notifications($this->CI->user_id, 0, 10);

                        // Get total number of notifications
                        $total = $this->CI->notifications_model->get_notifications($this->CI->user_id);

                        // Prepare view params
                        $params = array(
                            'notifications' => $notifications,
                            'total' => $total,
                            'page_header' => '<i class="icon-general"></i> ' . $this->CI->lang->line('notifications_general'),
                            'page' => 'notifications'
                        );

                        // Set views params
                        set_user_view(

                            $this->CI->load->ext_view(
                                MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views',
                                'main',
                                $params,
                                true
                            )

                        );

                    }

                    break;

                case 'errors':

                    // Prepare view params
                    $params = array(
                        'notifications' => array(),
                        'total' => 0,
                        'page_header' => '<i class="icon-error"></i> ' . $this->CI->lang->line('notifications_errors'),
                        'page' => 'errors'
                    );

                    // Set views params
                    set_user_view(

                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views',
                            'main',
                            $params,
                            true
                        )

                    );

                    break;
                    
                case 'offers':

                    // Prepare view params
                    $params = array(
                        'notifications' => array(),
                        'total' => 0,
                        'page_header' => '<i class="icon-offers"></i> ' . $this->CI->lang->line('notifications_offers'),
                        'page' => 'offers'
                    );

                    // Set views params
                    set_user_view(

                        $this->CI->load->ext_view(
                            MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views',
                            'main',
                            $params,
                            true
                        )

                    );

                    break;                    

                default:

                    show_404();

                    break;

            }

        } else {

            // Get Notifications
            $notifications = $this->CI->notifications_model->get_notifications($this->CI->user_id, 0, 10);

            // Get total number of notifications
            $total = $this->CI->notifications_model->get_notifications($this->CI->user_id);

            // Prepare view params
            $params = array(
                'notifications' => $notifications,
                'total' => $total,
                'page_header' => '<i class="icon-general"></i> ' . $this->CI->lang->line('notifications_general'),
                'page' => 'notifications'
            );

            // Set views params
            set_user_view(

                $this->CI->load->ext_view(
                    MIDRUB_BASE_USER_COMPONENTS_NOTIFICATIONS . 'views',
                    'main',
                    $params,
                    true
                )

            );
        
        }
        
    }    
    
}
