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
namespace CmsBase\Admin\Components\Collection\Dashboard\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Widgets class contains the properties used to displays widgets in the admin panel
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
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_DASHBOARD . 'models/', 'Dashboard_users_model', 'dashboard_users_model' );

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
     * The public method dashboard_reorder_widgets saves the widgets order
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function dashboard_reorder_widgets() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('widgets', 'Widgets', 'trim');

            // Get data
            $widgets = $this->CI->input->post('widgets', TRUE);

            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Get available widgets
                $the_available_widgets = md_the_admin_dashboard_widgets()?array_column(md_the_admin_dashboard_widgets(), 'widget_slug'):array();

                // Verify if widgets exists
                if ( $widgets ) {

                    // Reset all positions
                    $this->CI->base_model->update('dashboard_widgets', array('widget_id >' => 0), array('widget_position' => 0));

                    // Set position
                    $position = 1;

                    // List all widgets
                    foreach ( $widgets as $widget ) {

                        // Verify if the widget exists
                        if ( !in_array($widget, $the_available_widgets) ) {
                            continue;
                        }

                        // Get the widget's data from the database
                        $the_widget = $this->CI->base_model->the_data_where(
                            'dashboard_widgets',
                            '*',
                            array(
                                'widget' => $widget
                            )
                        );

                        // Verify if the preferences were saved
                        if ( $the_widget ) {

                            // Reset all positions
                            $this->CI->base_model->update('dashboard_widgets', array('widget' => $widget ), array('widget_position' => $position));

                        } else {

                            // Insert data
                            $insert = array(
                                'widget' => $widget,
                                'widget_position' => $position,
                                'status' => 1  
                            );

                            // Insert data
                            $this->CI->base_model->insert('dashboard_widgets', $insert);

                        }
                        
                        // Increase position
                        $position++;                    

                    }

                    
                    // Prepare the success response
                    $data = array(
                        'success' => TRUE
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }

        }
        
        // Prepare the false response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('dashboard_widgets_order_not_saved')
        );

        // Display the false response
        echo json_encode($data);
        
    }

}

/* End of file widgets.php */