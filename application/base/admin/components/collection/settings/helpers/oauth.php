<?php
/**
 * Oauth Helpers
 *
 * This file contains the class Oauth
 * with methods to manage the api's permissions
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Settings\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Oauth class provides the methods to manage the api's permissions
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
*/
class Oauth {
    
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
        
        // Load the api permissions model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . '/models/', 'Oauth_permissions_model', 'oauth_permissions_model' );
        
        // Load the api applications model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_SETTINGS . '/models/', 'Oauth_applications_model', 'oauth_applications_model' );
        
    }
    
    /**
     * The public method create_new_api_app creates a new application
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function create_new_api_app() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('application_name', 'Application Name', 'trim|required');
            $this->CI->form_validation->set_rules('redirect_url', 'Redirect Url');
            $this->CI->form_validation->set_rules('cancel_redirect', 'Cancel Redirect');
            $this->CI->form_validation->set_rules('permissions', 'Permissions');

            // Get data
            $application_name = $this->CI->input->post('application_name');
            $all_permissions = $this->CI->input->post('all_permissions');
            $redirect_url = str_replace('url: ', '', $this->CI->input->post('redirect_url'));
            $cancel_redirect = str_replace('url: ', '', $this->CI->input->post('cancel_redirect'));

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Save application
                $application = $this->CI->oauth_applications_model->save_application( md_the_user_id(), $application_name, $redirect_url, $cancel_redirect );

                if ( $application ) {
                    
                    if ( $all_permissions ) {
                        
                        foreach ( $all_permissions as $permission ) {
                            
                            // Save application's permissions
                            $this->CI->oauth_applications_model->save_application_permission( $application, $permission );                            
                            
                        }
                        
                    }
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('api_app_was_created')
                    );

                    echo json_encode($data); 
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('api_app_was_not_created')
        );

        echo json_encode($data);  
        
    }
    
    /**
     * The public method update_api_app updates an application
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function update_api_app() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('application_id', 'Application ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('application_name', 'Application Name', 'trim|required');
            $this->CI->form_validation->set_rules('redirect_url', 'Redirect Url');
            $this->CI->form_validation->set_rules('cancel_redirect', 'Cancel Redirect');
            $this->CI->form_validation->set_rules('permissions', 'Permissions');

            // Get data
            $application_id = $this->CI->input->post('application_id');
            $application_name = $this->CI->input->post('application_name');
            $redirect_url = str_replace('url: ', '', $this->CI->input->post('redirect_url'));
            $cancel_redirect = str_replace('url: ', '', $this->CI->input->post('cancel_redirect'));
            $all_permissions = $this->CI->input->post('all_permissions');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                $count = 0;
                
                // Update application
                if ( $this->CI->oauth_applications_model->update_application( $application_id, $application_name, $redirect_url, $cancel_redirect ) ) {
                    $count++;
                }
                
                // Delete application's permissions
                if ( $this->CI->oauth_applications_model->delete_application_permissions( $application_id ) && !$all_permissions ) {
                    $count++;
                }

                if ( $all_permissions ) {

                    foreach ( $all_permissions as $permission ) {

                        // Save application's permissions
                        if ( $this->CI->oauth_applications_model->save_application_permission( $application_id, $permission ) ) {
                            $count++;
                        }                        

                    }

                }

                if ( $count ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('api_app_was_updated')
                    );

                    echo json_encode($data); 
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('api_app_was_not_updated')
        );

        echo json_encode($data);  
        
    }
    
    /**
     * The public method load_applications_list loads api's applications list
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function load_applications_list() {
        
        // Get page's input
        $page = $this->CI->input->get('page');     
        
        if ( is_numeric($page) ) {
            
            // Set the limit
            $limit = 10;
            $page--;
            
            // Get applications by page
            $applications = $this->CI->oauth_applications_model->get_applications( $page * $limit, $limit );
            
            // Get total number applications
            $total = $this->CI->oauth_applications_model->get_applications();
            
            // Verify if applications exists
            if ( $applications ) {
            
                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'applications' => $applications,
                    'words' => array(
                        'results' => $this->CI->lang->line('settings_results'),
                        'of' => $this->CI->lang->line('settings_of'),
                        'delete' => $this->CI->lang->line('settings_delete')
                    ),
                    'page' => ($page + 1),
                    'total' => $total
                );

                // Display the success response
                echo json_encode($data); 
                exit(); 
                
            }
            
        }

        // Prepare error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_no_applications_found')
        );

        // Display the error response
        echo json_encode($data);    
        
    }
    
    /**
     * The public method delete_api_application deletes api application
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function delete_api_application() {
        
        // Get application_id's input
        $application_id = $this->CI->input->get('application_id');     
        
        // Verify if application's ID exists
        if ( is_numeric($application_id) ) {
            
            // Delete application
            $delete_application = $this->CI->oauth_applications_model->delete_application( $application_id );
            
            // Verify if the application was deleted
            if ( $delete_application ) {
            
                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('settings_api_app_was_deleted')
                );

                // Display the success response
                echo json_encode($data); 
                exit();
                
            }
            
        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_api_app_was_not_deleted')
        );

        // Display the error response
        echo json_encode($data);  
        
    }
    
    /**
     * The public method manage_api_application gets application's data
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function manage_api_application() {
        
        // Get application_id's input
        $application_id = $this->CI->input->get('application_id');     
        
        // Verify if application's ID is correct
        if ( is_numeric($application_id) ) {
            
            // Get application
            $application = $this->CI->oauth_applications_model->get_application( $application_id );
            
            // Verify if application exists
            if ( $application ) {
 
                // Get application's permissions
                $application_permissions = $this->CI->oauth_applications_model->get_application_permissions( $application_id );                
            
                // Prepare the success response
                $data = array(
                    'success' => TRUE,
                    'application' => $application,
                    'secret_key' => md5($application[0]->application_id . '-' . $application[0]->user_id),
                    'permissions' => $application_permissions
                );

                // Display the success response
                echo json_encode($data); 
                exit(); 
                
            }
            
        }

        // Prepare the error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('settings_api_app_was_not_found')
        );

        // Display the error response
        echo json_encode($data);   
        
    }

}

/* End of file oauth.php */