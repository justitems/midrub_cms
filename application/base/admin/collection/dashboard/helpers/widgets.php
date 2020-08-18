<?php
/**
 * Dashboard Widgets Class
 *
 * This file loads the Widgets Class with properties used to displays widgets in the admin panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the namespace
namespace MidrubBase\Admin\Collection\Dashboard\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Wigets class contains the properties used to displays widgets in the admin panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Widgets {

    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;
    
    /**
     * Contains and array with saved widgets
     *
     * @since 0.0.8.1
     */
    public static $the_widgets = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load the Dashboard Users Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_DASHBOARD . 'models/', 'Dashboard_users_model', 'dashboard_users_model' );

        // Load the Dashboard Sales Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_DASHBOARD . 'models/', 'Dashboard_sales_model', 'dashboard_sales_model' );

        // Load the Dashboard Widgets Model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_DASHBOARD . 'models/', 'Dashboard_widgets_model', 'dashboard_widgets_model' );

    }

    /**
     * The public method load_members_for_graph loads members for graph
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_members_for_graph() {

        // Gets users for last 30 days
        $users = $this->CI->dashboard_users_model->get_last_users(30);

        // Verify if users exists
        if ( $users ) {

            // Prepare the success response
            $data = array(
                'success' => TRUE,
                'users' => $users,
                'words' => array(
                    'members' => $this->CI->lang->line('dashboard_members')
                )
            );

            // Display the success response
            echo json_encode($data);
            exit();

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'words' => array(
                'members' => $this->CI->lang->line('dashboard_members')
            )
        );

        // Display the false response
        echo json_encode($data);

    }

    /**
     * The public method load_sales_for_graph loads sales for graph
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function load_sales_for_graph() {

        // Gets sales for last year
        $sales = $this->CI->dashboard_sales_model->get_last_sales();

        // Verify if sales exists
        if ( $sales ) {

            // Prepare the success response
            $data = array(
                'success' => TRUE,
                'sales' => $sales,
                'words' => array(
                    'transactions' => $this->CI->lang->line('dashboard_completed_transactions')
                )
            );

            // Display the success response
            echo json_encode($data);
            exit();

        }

        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'words' => array(
                'transactions' => $this->CI->lang->line('dashboard_completed_transactions')
            )
        );

        // Display the false response
        echo json_encode($data);

    }

    /**
     * The public method change_widget_status changes the widget status
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function change_widget_status() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $this->CI->form_validation->set_rules('slug', 'slug', 'trim|required');
            
            // Get data
            $status = $this->CI->input->post('status');
            $slug = $this->CI->input->post('slug');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                if ( ( $status > -1 ) && ( $status < 2 ) ) {

                    // Use the base model to get the widgets
                    $dashboard_widgets = $this->CI->base_model->get_data_where(
                        'administrator_dashboard_widgets',
                        '*',
                        array(
                            'widget_slug' => $slug
                        )

                    );

                    // Verify if administrator has widgets
                    if ( $dashboard_widgets ) {

                        // Update Widget's Settings
                        $settings_update =$this->CI->base_model->update_ceil('administrator_dashboard_widgets', array(
                            'widget_id' => $dashboard_widgets[0]['widget_id']
                        ), array(
                            'enabled' => $status
                        ));

                        // Verify if the Widget's Settings were updated
                        if ( $settings_update ) {

                            if ( $status > 0 ) {

                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('dashboard_widget_enabled'),
                                    'slug' => $slug,
                                    'status' => $this->CI->lang->line('dashboard_enabled')
                                );

                                echo json_encode($data);

                            } else {

                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('dashboard_widget_disabled'),
                                    'slug' => $slug,
                                    'status' => $this->CI->lang->line('dashboard_disabled')  
                                );

                                echo json_encode($data);

                            }

                            exit();
                            
                        }

                    } else {

                        // Save Widget's Settings
                        $settings = array(
                            'user_id' => $this->CI->user_id,
                            'widget_slug' => $slug,
                            'enabled' => $status
                        );

                        // Save default message by using the basic model
                        if ( $this->CI->base_model->insert('administrator_dashboard_widgets', $settings) ) {

                            if ( $status > 0 ) {

                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('dashboard_widget_enabled'),
                                    'slug' => $slug,
                                    'status' => $this->CI->lang->line('dashboard_enabled')
                                );

                                echo json_encode($data);

                            } else {

                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('dashboard_widget_disabled'),
                                    'slug' => $slug,
                                    'status' => $this->CI->lang->line('dashboard_disabled')                                
                                );

                                echo json_encode($data);

                            }

                            exit();

                        }

                    }

                }
                
            }
            
        }

        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('dashboard_error_occurred')
        );

        echo json_encode($data);

    }    

    /**
     * The public method set_widget adds widget
     * 
     * @param array $args contains the widget's arguments
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function set_widget($args) {

        // Verify if at least a widget exists
        if ( $args ) {

            // List all widgets
            foreach ( $args as $arg ) {

                // Verify if the widget has valid fields
                if ( isset($arg['widget_name']) && isset($arg['widget_slug']) && isset($arg['widget_icon']) && isset($arg['content']) && isset($arg['css_urls']) && isset($arg['js_urls']) ) {

                    self::$the_widgets[] = $arg;
                    
                }

            }

        }

    } 

    /**
     * The public method load_widgets loads all widgets
     * 
     * @param array $widgets_list contains the widgets
     * 
     * @since 0.0.8.1
     * 
     * @return array with widgets or boolean false
     */
    public function load_widgets($widgets_list = NULL) {

        // Verify if widgets exists
        if ( self::$the_widgets ) {

            $all_widgets = array();

            // Verify if the parameter $widgets_list is not empty
            if ( $widgets_list ) {

                foreach ( self::$the_widgets as $widget ) {

                    if ( !empty($widgets_list[$widget['widget_slug']]) ) {
                        continue;
                    }

                    $all_widgets[] = $widget;

                }

            } else {

                return self::$the_widgets;

            }

            // Verify if enabled widgets exists
            if ( $all_widgets ) {

                return $all_widgets;

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

}

/* End of file widgets.php */