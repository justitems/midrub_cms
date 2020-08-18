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
namespace MidrubBase\Admin\Collection\Settings\Helpers;

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
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SETTINGS . '/models/', 'Oauth_permissions_model', 'oauth_permissions_model' );
        
        // Load the api applications model
        $this->CI->load->ext_model( MIDRUB_BASE_ADMIN_SETTINGS . '/models/', 'Oauth_applications_model', 'oauth_applications_model' );
        
    }
    
    /**
     * The public method save_admin_settings saves the admin's settings
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */ 
    public function update_api_permission_settings() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('permission', 'Permission', 'trim|required');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim|required');

            // Get data
            $permission = $this->CI->input->post('permission');
            $status = $this->CI->input->post('status');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Save permission status
                $save_status = $this->CI->oauth_permissions_model->save_permission( $permission, $status );
                
                if ( $save_status ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('changes_were_saved')
                    );

                    echo json_encode($data); 
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('changes_were_not_saved')
        );

        echo json_encode($data);  
        
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
                $application = $this->CI->oauth_applications_model->save_application( $this->CI->user_id, $application_name, $redirect_url, $cancel_redirect );

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
            
            if ( $applications ) {
            
                $data = array(
                    'success' => TRUE,
                    'applications' => $applications,
                    'words' => array(
                        'manage' => $this->CI->lang->line('api_manage')
                    ),
                    'page' => ($page + 1),
                    'total' => $total
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_applications_found')
                );

                echo json_encode($data);                
                
            }
            
        }
        
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
        
        if ( is_numeric($application_id) ) {
            
            // Delete application
            $delete_application = $this->CI->oauth_applications_model->delete_application( $application_id );
            
            if ( $delete_application ) {
            
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('api_app_was_deleted')
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_app_was_not_deleted')
                );

                echo json_encode($data);                
                
            }
            
        }
        
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
        
        if ( is_numeric($application_id) ) {
            
            // Get application
            $application = $this->CI->oauth_applications_model->get_application( $application_id );
            
            if ( $application ) {
                
                // Get application's permissions
                $application_permissions = $this->CI->oauth_applications_model->get_application_permissions( $application_id );                
            
                $data = array(
                    'success' => TRUE,
                    'application' => $application,
                    'secret_key' => md5($application[0]->application_id . '-' . $application[0]->user_id),
                    'permissions' => $application_permissions
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_app_was_not_found')
                );

                echo json_encode($data);                
                
            }
            
        }
        
    }

}

/* End of file oauth.php */