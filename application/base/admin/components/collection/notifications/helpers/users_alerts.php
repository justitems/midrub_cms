<?php
/**
 * Users Alerts
 *
 * This file contains the class Users_alerts
 * with methods to manage the users alerts
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Notifications\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Users_alerts class provides the methods to manage users alerts
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.4
*/
class Users_alerts {
    
    /**
     * Class variables
     *
     * @since 0.0.8.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Notifications Users Alerts Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_alerts_model', 'notifications_alerts_model' );

        // Load the alerts language file
        $this->CI->lang->load( 'notifications_alerts', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS );
        
    }

    //-----------------------------------------------------
    // Ajax's methods for Users Alerts Helper
    //-----------------------------------------------------

    /**
     * The public method notifications_create_users_alert creates a users alert
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_create_users_alert() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alert_name', 'Alert Name', 'trim');
            $this->CI->form_validation->set_rules('alert_type', 'Alert Type', 'trim');
            $this->CI->form_validation->set_rules('alert_banner', 'Alert Banner', 'trim');
            $this->CI->form_validation->set_rules('alert_banner_enabled', 'Alert Banner Enabled', 'trim');
            $this->CI->form_validation->set_rules('alert_page_title', 'Alert Page Title', 'trim');
            $this->CI->form_validation->set_rules('alert_page', 'Alert Page', 'trim');
            $this->CI->form_validation->set_rules('alert_page_enabled', 'Alert Page Enabled', 'trim');
            $this->CI->form_validation->set_rules('plans', 'Plans', 'trim');
            $this->CI->form_validation->set_rules('languages', 'Languages', 'trim');

            // Get received data
            $alert_name = $this->the_clean_text($this->CI->input->post('alert_name', TRUE));
            $alert_type = $this->the_clean_number($this->CI->input->post('alert_type', TRUE));
            $alert_banner = $this->CI->input->post('alert_banner', FALSE);
            $alert_banner_enabled = $this->the_clean_number($this->CI->input->post('alert_banner_enabled', TRUE));
            $alert_page_title = $this->CI->input->post('alert_page_title');
            $alert_page = $this->CI->input->post('alert_page', FALSE);
            $alert_page_enabled = $this->the_clean_number($this->CI->input->post('alert_page_enabled', TRUE));
            $plans = $this->CI->input->post('plans', TRUE);
            $languages = $this->CI->input->post('languages', TRUE);

            // Check form validation
            if ( $this->CI->form_validation->run() !== false ) {

                // Set alert fields
                $alert_fields = array();

                // Verify if banners exists
                if ( $alert_banner ) {

                    // List banners
                    foreach( $alert_banner as $banner ) {

                        // Verify if the banner is enabled
                        if ( $alert_banner_enabled ) {

                            // Verify if banner content exists
                            if ( empty($banner[1]) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('notifications_banner_enabled_but_missing')
                                );

                                // Display the error response
                                echo json_encode($data);
                                exit();

                            }

                        }

                        // Set as field
                        $alert_fields[] = array(
                            'field_name' => 'banner_content',
                            'field_value' => $this->the_secure_js($banner[1][0]),
                            'language' => $this->the_clean_text($banner[0])
                        );

                    }

                }

                // Verify if the banner is enabled
                if ( $alert_banner_enabled ) {

                    // Verify if banners exists
                    if ( !$alert_banner ) {

                        // Prepare error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('notifications_banner_enabled_but_missing')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }

                    // Set as field
                    $alert_fields[] = array(
                        'field_name' => 'banner_enabled',
                        'field_value' => 1
                    );                    

                } else {

                    // Set as field
                    $alert_fields[] = array(
                        'field_name' => 'banner_enabled',
                        'field_value' => ((int)$alert_type > 0)?1:0
                    );     

                }

                // Verify if page titles exists
                if ( $alert_page_title ) {

                    // List page titles
                    foreach( $alert_page_title as $page_title ) {

                        // Verify if the page is enabled
                        if ( $alert_page_enabled ) {

                            // Verify if page's title exists
                            if ( empty($page_title[1]) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('notifications_alert_page_enabled_but_missing_title')
                                );

                                // Display the error response
                                echo json_encode($data);
                                exit();

                            }

                            // Verify if page's title exists
                            if ( empty($page_title[1][0]) ) {

                                // Prepare error response
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('notifications_alert_page_enabled_but_missing_title')
                                );

                                // Display the error response
                                echo json_encode($data);
                                exit();

                            }                            

                        }                        

                        // Set as field
                        $alert_fields[] = array(
                            'field_name' => 'page_title',
                            'field_value' => $this->the_clean_text($page_title[1][0]),
                            'language' => $this->the_clean_text($page_title[0])
                        );

                    }

                }

                // Verify if page content exists
                if ( $alert_page ) {

                    // List page content
                    foreach( $alert_page as $page ) {                     

                        // Set as field
                        $alert_fields[] = array(
                            'field_name' => 'page_content',
                            'field_value' => $this->the_clean_html($page[1][0]),
                            'language' => $this->the_clean_text($page[0])
                        );

                    }                    
                
                }

                // Verify if the page is enabled
                if ( $alert_page_enabled ) {

                    // Verify if page's title exists
                    if ( !$alert_page_title ) {

                        // Prepare error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('notifications_alert_page_enabled_but_missing_title')
                        );

                        // Display the error response
                        echo json_encode($data);
                        exit();

                    }

                    // Set as field
                    $alert_fields[] = array(
                        'field_name' => 'page_enabled',
                        'field_value' => 1
                    );  

                } else {

                    // Set as field
                    $alert_fields[] = array(
                        'field_name' => 'page_enabled',
                        'field_value' => 0
                    );  

                }
                
                // Alert Filters container
                $alert_filters = array();

                // Verify if plans exists
                if ( $plans ) {

                    // Plans container
                    $plans_filter = array();

                    // List plans
                    foreach ( $plans as $plan ) {

                        // Add plan to the filter
                        $plans_filter[] = $this->the_clean_number($plan);

                    }                 

                    // Verify if plans filter is not empty
                    if ( !empty($plans_filter) ) {

                        // Set filter
                        $alert_filters[] = array(
                            'filter_name' => 'plans',
                            'filter_value' => serialize($plans_filter)
                        );  

                    }

                }

                // Verify if languages exists
                if ( $languages ) {

                    // languages container
                    $languages_filter = array();

                    // List languages
                    foreach ( $languages as $laguage ) {

                        // Add laguage to the filter
                        $languages_filter[] = $this->the_clean_text($laguage[0]);

                    }

                    // Verify if languages filter is not empty
                    if ( !empty($languages_filter) ) {

                        // Set filter
                        $alert_filters[] = array(
                            'filter_name' => 'languages',
                            'filter_value' => serialize($languages)
                        );  

                    }

                }

                // Save the alert
                $alert_response = md_save_admin_notifications_alert(
                    array(
                        'alert_name' => $alert_name,
                        'alert_type' => $alert_type,
                        'alert_audience' => 0,
                        'alert_fields' => $alert_fields,
                        'alert_filters' => $alert_filters
                    )
                );
                
                // Verify if alert response exists
                if ( $alert_response ) {

                    // Display the response
                    echo json_encode($alert_response);
                    exit();

                }
                
            }
            
        }

        // Prepare error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_an_error_occured')
        );

        // Display the error response
        echo json_encode($data);

    }

    /**
    * The public method notifications_load_users_alerts loads users alerts
    * 
    * @since 0.0.8.4
    * 
    * @return void
    */
    public function notifications_load_users_alerts() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page')?($this->CI->input->post('page') - 1):0;
            $key = $this->CI->input->post('key');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;

                // Set like
                $like = $key?array('LOWER(alert_name)' => strtolower(trim(str_replace('!_', '_', $this->CI->db->escape_like_str($key))))):array();

                // Use the base model for a simply sql query
                $users_alerts = $this->CI->base_model->the_data_where(
                'notifications_alerts',
                '*',
                array(
                    'alert_type <' => 3
                ),
                array(),
                $like,
                array(),
                array(
                    'order_by' => array('alert_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if users alerts exists
                if ( $users_alerts ) {

                    // Get total number of users alerts with base model
                    $total = $this->CI->base_model->the_data_where(
                        'notifications_alerts',
                        'COUNT(alert_id) AS total',
                        array(
                            'alert_type <' => 3
                        ),
                        array(),
                        $like
                    );

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'alerts' => $users_alerts,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
                            'news' => $this->CI->lang->line('notifications_news'),
                            'promo' => $this->CI->lang->line('notifications_promo'),
                            'fixed' => $this->CI->lang->line('notifications_fixed'),
                            'delete' => $this->CI->lang->line('notifications_delete'),
                            'of' => $this->CI->lang->line('notifications_of'),
                            'results' => $this->CI->lang->line('notifications_results')
                        )
                    );

                    // Display the response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_no_alerts_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method notifications_delete_users_alerts deletes multiple users alerts
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function notifications_delete_users_alerts() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('alerts', 'Alerts', 'trim');
           
            // Get received data
            $alerts = $this->CI->input->post('alerts');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if at least an alert was selected
                if ( $alerts ) {

                    // Count number of deleted users alerts
                    $count = 0;

                    // List all users alerts
                    foreach ( $alerts as $alert ) {

                        // Try to delete the users alert
                        $response = $this->delete_users_alert($alert);

                        // Verify if the users alert was deleted
                        if ( !empty($response['success']) ) {
                            $count++;
                        }

                    }

                    // Prepare success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $count . ' ' . $this->CI->lang->line('notifications_users_alerts_were_deleted')
                    );

                    // Display the success message
                    echo json_encode($data);

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_please_select_at_least_alert')
                    );

                    // Display the error message
                    echo json_encode($data);

                }

                exit();

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_an_error_occured')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    //-----------------------------------------------------
    // General's methods for Users Alerts Helper
    //-----------------------------------------------------

    /**
     * The protected method the_secure_js removes any dangerous javascript code
     * 
     * @param string $text contains the text which should the cleaned
     * 
     * @since 0.0.8.4
     * 
     * @return string with text
     */ 
    protected function the_secure_js($text) {

        //  Find code
        $find = array(
            'alert',
            'write',
            'inner',
            'insert',
            'activexobject',
            'unescape',
            'cookie'
        );

        // Return clean
        return str_replace($find, array(''), $text);

    }

    /**
     * The protected method the_clean_html removes any javascript code
     * 
     * @param string $text contains the text which should the cleaned
     * 
     * @since 0.0.8.4
     * 
     * @return string with html as entities
     */ 
    protected function the_clean_html($text) {

        // Remove the tags
        return strip_tags($text, array('iframe', 'video', 'source', 'img', 'p','b','i','br'));

    }

    /**
     * The protected method the_clean_text removes unexpected tags and spaces 
     * 
     * @param string $text contains the text which should the cleaned
     * 
     * @since 0.0.8.4
     * 
     * @return string
     */ 
    protected function the_clean_text($text) {

        // Remove the html tags and spaces
        return $text?trim(strip_tags($text)):'';

    }

    /**
     * The protected method the_clean_number removes unexpected tags and spaces 
     * 
     * @param string $number contains the number which should the cleaned
     * 
     * @since 0.0.8.4
     * 
     * @return integer
     */ 
    protected function the_clean_number($number) {

        // Remove anything except number and decimals
        return $number?trim(preg_replace("/[^0-9\.,]/", "", $number)):0;

    }

    /**
     * The protected method delete_users_alert deletes a users alert
     * 
     * @param integer $alert_id contains the users alert's ID
     * 
     * @since 0.0.8.4
     * 
     * @return array with response
     */
    protected function delete_users_alert($alert_id) {

        // Try to delete the users alert
        if ( $this->CI->base_model->delete('notifications_alerts', array('alert_id' => $alert_id, 'alert_type <' => 3)) ) {

            // Delete the alert's fields
            $this->CI->base_model->delete('notifications_alerts_fields', array('alert_id' => $alert_id));

            // Delete the alert's filters
            $this->CI->base_model->delete('notifications_alerts_filters', array('alert_id' => $alert_id));            
            
            // Prepare success message
            return array(
                'success' => TRUE,
                'message' => $this->CI->lang->line('members_member_was_deleted')
            );
            
        } else {
            
            // Prepare error message
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('members_member_was_not_deleted')
            );
            
        }

    }

}

/* End of file users_alerts.php */