<?php
/**
 * Plans Helper
 *
 * This file contains the class Plans
 * with methods to manage the plans's data
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\User\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans class provides the methods to manage the plans's data
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Plans {
    
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

        // Load Base Plans Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );
        
    }

    /**
     * The public method create_new_plan creates a new plan
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function create_new_plan() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plan_name', 'Plan Name', 'trim|required');
            $this->CI->form_validation->set_rules('group_id', 'Group ID', 'trim');

            // Get data
            $plan_name = $this->CI->input->post('plan_name');
            $group_id = $this->CI->input->post('group_id');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Prepare the error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('user_plan_was_not_saved')
                );

                // Display the error message
                echo json_encode($data);
                exit();

            } else {

                // Prepare the plan data
                $plan = array(
                    'plan_name' => $plan_name,
                    'period' => 30,
                    'hidden' => 0,
                    'popular' => 0,
                    'featured' => 0,
                    'trial' => 0
                );

                // Save plan
                $plan_id = $this->CI->base_model->insert('plans', $plan);

                // Verify if the plan was saved
                if ( $plan_id ) {

                    // Verify if the group_id is numeric
                    if ( is_numeric($group_id) ) {

                        // Prepare the group's information
                        $group = array(
                            'plan_id' => $plan_id,
                            'meta_name' => 'plans_group',
                            'meta_value' => $group_id
                        );
                        
                        // Save the Group's ID
                        $this->CI->base_model->insert('plans_meta', $group);

                    }

                    // Prepare default storage
                    $storage_params = array(
                        'plan_id' => $plan_id,
                        'meta_name' => 'storage',
                        'meta_value' => 1048576
                    );
                    
                    // Save the storage
                    $this->CI->base_model->insert('plans_meta', $storage_params);
                    
                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_plan_was_saved'),
                        'plan_id' => $plan_id
                    );

                    // Display the success message
                    echo json_encode($data);
                    exit();              
                    
                }
                
            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_plan_was_not_saved')
        );

        // Display the error message
        echo json_encode($data);
        
    }

    /**
     * The public method user_update_a_plan updates a plan
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function user_update_a_plan() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required');
            $this->CI->form_validation->set_rules('all_dropdowns', 'All Dropdowns', 'trim');
            $this->CI->form_validation->set_rules('all_multiselector_dropdowns', 'All Multiselector Dropdowns', 'trim');
            $this->CI->form_validation->set_rules('all_textareas', 'All Textareas', 'trim');
            $this->CI->form_validation->set_rules('texts', 'Texts', 'trim');

            // Get data
            $plan_id = $this->CI->input->post('plan_id', TRUE);
            $all_dropdowns = $this->CI->input->post('all_dropdowns', TRUE);
            $all_multiselector_dropdowns = $this->CI->input->post('all_multiselector_dropdowns', TRUE);
            $all_textareas = $this->CI->input->post('all_textareas', TRUE);
            $texts = $this->CI->input->post('texts', TRUE);

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Data array
                $data = array();
                
                // Plan's metas array
                $plan_metas = array();

                // Verify if dropdowns exists
                if ( $all_dropdowns ) {

                    // List all dropdowns
                    foreach( $all_dropdowns as $dropdown ) {
                        
                        if ( !isset($dropdown[1]) ) {
                            continue;
                        }

                        $plan_metas[$dropdown[0]] = $dropdown[1];
                    }

                }

                // Verify if multiselector dropdowns exists
                if ( $all_multiselector_dropdowns ) {

                    // List all multiselector dropdowns
                    foreach( $all_multiselector_dropdowns as $multiselector_dropdown ) {

                        // Set meta
                        $plan_metas[$multiselector_dropdown[0]] = !empty($multiselector_dropdown[1])?serialize($multiselector_dropdown[1]):'';

                    }

                }

                // Verify if textareas exists
                if ( $all_textareas ) {
                
                    // List all textareas
                    foreach( $all_textareas as $text ) {

                        if ( !isset($text[1]) ) {
                            continue;
                        }

                        // Verify if is a default data
                        if ( $text[0] === 'plan_name' ) {
                            $data['plan_name'] = $text[1];
                        } else if ( $text[0] === 'plan_price' ) {
                            $data['plan_price'] = $text[1];
                        } else if ( $text[0] === 'currency_sign' ) {
                            $data['currency_sign'] = $text[1];
                        } else if ( $text[0] === 'currency_code' ) {
                            $data['currency_code'] = $text[1];
                        } else if ( $text[0]=== 'period' ) {
                            $data['period'] = $text[1];
                        } else if ( $text[0] === 'hidden' ) {
                            $data['hidden'] = $text[1];
                        } else if ( $text[0] === 'popular' ) {
                            $data['popular'] = $text[1];
                        } else if ( $text[0] === 'featured' ) {
                            $data['featured'] = $text[1];
                        } else if ( $text[0] === 'trial' ) {
                            $data['trial'] = $text[1];
                        } else {
                            $plan_metas[$text[0]] = $text[1];
                        }

                    }
                
                }

                // Plan counter
                $plan_update = 0;
                
                // Verify if data exists
                if ( $data ) {
                
                    if ( $this->CI->base_model->update( 'plans', array( 'plan_id' => $plan_id ), $data ) ) {
                        $plan_update++;
                    }
                
                }
                
                // Verify if plan's meta exists
                if ( $plan_metas ) {
             
                    if ( $this->CI->base_plans->update_plan_meta($plan_id, $plan_metas) ) {
                        $plan_update++;
                    }
                
                } 

                // Verify if texts exists
                if ( $texts ) {

                    // Delete the existing text
                    $this->CI->base_model->delete( 'plans_texts', array( 'plan_id' => $plan_id ) );

                    // List the languages
                    foreach ( $texts as $language => $text ) {

                        // Verify if text contains two keys
                        if ( empty($text[1]) ) {
                            continue;
                        }

                        // Verify if text contains language
                        if ( !empty($text[0]) ) {

                            // Verify if title exists
                            if ( !empty($text[1]['title']) ) {

                                // Prepare the text's params
                                $text_params = array(
                                    'plan_id' => $plan_id,
                                    'language' => $text[0],
                                    'text_name' => 'title',
                                    'text_value' => trim($text[1]['title'])
                                );
                                
                                // Save the title
                                if ( $this->CI->base_model->insert('plans_texts', $text_params) ) {
                                    $plan_update++;
                                }

                            }

                            // Verify if short_description exists
                            if ( !empty($text[1]['short_description']) ) {

                                // Prepare the text's params
                                $text_params = array(
                                    'plan_id' => $plan_id,
                                    'language' => $text[0],
                                    'text_name' => 'short_description',
                                    'text_value' => trim($text[1]['short_description'])
                                );
                                
                                // Save the short description
                                if ( $this->CI->base_model->insert('plans_texts', $text_params) ) {
                                    $plan_update++;
                                }

                            }

                            // Verify if displayed_price exists
                            if ( !empty($text[1]['displayed_price']) ) {

                                // Prepare the text's params
                                $text_params = array(
                                    'plan_id' => $plan_id,
                                    'language' => $text[0],
                                    'text_name' => 'displayed_price',
                                    'text_value' => trim($text[1]['displayed_price'])
                                );
                                
                                // Save the displayed price
                                if ( $this->CI->base_model->insert('plans_texts', $text_params) ) {
                                    $plan_update++;
                                }

                            }                            

                            // Verify if features exists
                            if ( !empty($text[1]['features']) ) {

                                // List all features
                                foreach ( $text[1]['features'] as $feature ) {

                                    // Prepare the feature's params
                                    $feature_params = array(
                                        'plan_id' => $plan_id,
                                        'language' => $text[0],
                                        'text_name' => 'feature',
                                        'text_value' => trim($feature)
                                    );
                                    
                                    // Save the feature
                                    if ( $this->CI->base_model->insert('plans_texts', $feature_params) ) {
                                        $plan_update++;
                                    }

                                }

                            }

                        }

                    }

                }
                
                // Verify if the plan was updated
                if( $plan_update ) {

                    // Delete cache
                    md_delete_cache('md_plan_features_' . $plan_id);
                    
                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('user_settings_changes_were_saved')
                    );

                    // Display the success message
                    echo json_encode($data);                    
                    
                } else {
                    
                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('user_settings_changes_were_not_saved')
                    );

                    // Display the error message
                    echo json_encode($data);                    
                    
                }

                exit();
                
            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_error_occurred_request')
        );

        // Display the error message
        echo json_encode($data);
        
    }

    /**
     * The public method load_all_plans loads plans by page
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_all_plans() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $key = $this->CI->input->post('key');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;
                $page--;

                // Prepare arguments for request
                $args = array(
                    'start' => ($page * $limit),
                    'limit' => $limit,
                    'key' => $key
                );
                
                // Get plans by page
                $plans = $this->CI->base_plans->get_plans($args);

                // Verify if plans exists
                if ( $plans ) {

                    // Get total plans
                    $total = $this->CI->base_plans->get_plans(array(
                        'key' => $key
                    ));                    

                    // Prepare the success response
                    $data = array(
                        'success' => TRUE,
                        'plans' => $plans,
                        'total' => $total,
                        'page' => ($page + 1),
                        'words' => array(
                            'results' => $this->CI->lang->line('user_results'),
                            'of' => $this->CI->lang->line('user_of')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);
                    exit();

                }

            }
            
        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_no_plans_found')
        );

         // Display the error message
        echo json_encode($data);
        
    }

    /**
     * The public method delete_plans deletes plans by plan's ids
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function delete_plans() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plans_ids', 'Plans Ids', 'trim');
           
            // Get received data
            $plans_ids = $this->CI->input->post('plans_ids');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if plans ids exists
                if ( $plans_ids ) {

                    // Count number of deleted plans
                    $count = 0;

                    // List all plans
                    foreach ( $plans_ids as $id ) {

                        // Default plan can't be deleted
                        if ( $id < 2 ) {
                            continue;
                        }

                        // Delete the plan
                        $delete_plan = $this->CI->base_model->delete('plans', array(
                            'plan_id' => $id
                        )); 

                        // Delete plan
                        if ( $delete_plan ) {

                            // Delete the plan's meta
                            $delete_plan = $this->CI->base_model->delete('plans_meta', array(
                                'plan_id' => $id
                            )); 

                            // Delete plans records
                            md_run_hook(

                                'delete_plan',

                                array(
                                    'plan_id' => $id
                                )

                            );

                            $count++;

                        }

                    }

                    if ( $count > 0 ) {

                        // Prepare the success message
                        $data = array(
                            'success' => TRUE,
                            'message' => $this->CI->lang->line('user_plans_were_deleted')
                        );

                        // Display the success message
                        echo json_encode($data);
                        exit();

                    }

                } else {

                    // Prepare the error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('user_plans_were_not_deleted')
                    );

                    // Display the error message
                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Prepare the error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('user_plans_were_not_deleted')
        );

        // Display the error message
        echo json_encode($data); 

    }

}

/* End of file plans.php */