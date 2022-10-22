<?php
/**
 * Dashboard Events Class
 *
 * This file loads the Events Class with properties used to displays events in the Dashboard component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the namespace
namespace CmsBase\Admin\Components\Collection\Dashboard\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Wigets class contains the properties used to displays events in the Dashboard component
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Events {

    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;
    
    /**
     * Contains and array with saved events
     *
     * @since 0.0.8.5
     */
    public static $the_events = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

    }

    /**
     * The public method dashboard_get_events gets the events for the dashboard
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function dashboard_get_events() {

        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('view', 'View', 'trim');
            $this->CI->form_validation->set_rules('current', 'Current', 'trim');
            $this->CI->form_validation->set_rules('date', 'Date', 'trim');

            // Get data
            $view = $this->CI->input->post('view', TRUE);
            $current = $this->CI->input->post('current', TRUE);
            $date = $this->CI->input->post('date', TRUE);

            // Verify if the submitted data is correct
            if ( $this->CI->form_validation->run() !== false ) {

                // Events old
                $events_old = '';

                // Events new
                $events_new = '';

                // Set interval
                $interval = !empty($view)?2505600:518400;                

                // Dates container
                $dates = array();

                // Get the events
                $the_events = $this->CI->base_model->the_data_where(
                    'dashboard_events',
                    'dashboard_events.event_id, dashboard_events.created, dashboard_events_meta.meta_value AS title, font.meta_value AS font_icon',
                    array(
                        'dashboard_events.created >' => $date?(strtotime($date) - $interval):(strtotime($current) - $interval - 86400),
                        'dashboard_events.created <' => $date?(strtotime($date) + 86400):(strtotime($current) + 86400)
                    ),
                    array(),
                    array(),
                    array(array(
                        'table' => 'dashboard_events_meta',
                        'condition' => "dashboard_events.event_id=dashboard_events_meta.event_id AND dashboard_events_meta.meta_name='title'",
                        'join_from' => 'LEFT'
                    ), array(
                        'table' => 'dashboard_events_meta as font',
                        'condition' => "dashboard_events.event_id=font.event_id AND font.meta_name='font_icon'",
                        'join_from' => 'LEFT'
                    ))
                );

                // Events list
                $events_list = array();

                // Verify if events exists
                if ( $the_events ) {

                    // Reduce the events
                    $events_list = array_reduce($the_events, function($accumulator, $the_event) {
                        
                        // Verify if date exists
                        if (!isset($accumulator[date('Y-m-d', $the_event['created'])])) {

                            // Set array as value
                            $accumulator[date('Y-m-d', $the_event['created'])] = array();

                        }

                        // Verify if font's icon exists
                        if ( !empty($the_event['font_icon']) ) {

                            // Set the font's icon
                            $the_event['font_icon'] = md_the_admin_icon(array('icon' => $the_event['font_icon']));

                        }
                        
                        // Add event to the list
                        $accumulator[date('Y-m-d', $the_event['created'])][] = $the_event;

                        return $accumulator;

                    }, []);

                }

                // Verify if date exists
                if ( $date ) {

                    // Set events old
                    $events_old = date('Y-m-d', (strtotime($date) - $interval - 86400));

                    // Set events new
                    $events_new = date('Y-m-d', (strtotime($date) + 86400  + $interval));

                    // Get period of time
                    $period = new \DatePeriod(
                        new \DateTime(date('Y-m-d', (strtotime($date) - $interval))),
                        new \DateInterval('P1D'),
                        new \DateTime(date('Y-m-d', (strtotime($date) + 86400)))
                    );                    

                } else {

                    // Set events old
                    $events_old = date('Y-m-d', (strtotime($current) - $interval - 86400));

                    // Set events new
                    $events_new = date('Y-m-d', (strtotime($current) + $interval));

                    // Get period of time
                    $period = new \DatePeriod(
                        new \DateTime(date('Y-m-d', (strtotime($current) - $interval))),
                        new \DateInterval('P1D'),
                        new \DateTime(date('Y-m-d', (strtotime($current) + 86400)))
                    );    
                    
                }
               
                // List the dates
                foreach ($period as $key => $value) {

                    // Events container
                    $events = array();

                    // Verify if the day has events
                    if ( isset($events_list[$value->format('Y-m-d')]) ) {

                        // Set events
                        $events = $events_list[$value->format('Y-m-d')];

                    }
                    
                    // Add date to the container
                    $dates[] = array(
                        'day' => $key,
                        'date' => $value->format('d/m/Y'),
                        'events' => $events,
                        'total' => count($events)
                    );
                    
                }

                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'dates' => $dates,
                    'events_old' => $events_old,
                    'events_new' => $events_new,
                    'words' => array(
                        'no_events_were_found' => $this->CI->lang->line('dashboard_no_events_were_found')
                    )
                );

                // Display the success response
                echo json_encode($data);
                exit();

            }

        }
        
        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('dashboard_no_events_were_found')
        );

        // Display the error response
        echo json_encode($data);
        
    }

}

/* End of file events.php */