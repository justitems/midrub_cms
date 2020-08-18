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
namespace MidrubBase\Admin\Collection\User\Helpers;

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
        $this->CI->load->ext_model( MIDRUB_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );
        
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
                    'plan_name' => $plan_name
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
     * The public method update_a_plan updates a plan
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function update_a_plan() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required');
            $this->CI->form_validation->set_rules('all_inputs', 'All Inputs', 'trim');
            $this->CI->form_validation->set_rules('all_options', 'All Options', 'trim');

            // Get data
            $plan_id = $this->CI->input->post('plan_id');
            $all_inputs = $this->CI->input->post('all_inputs');
            $all_options = $this->CI->input->post('all_options');

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Prepare the error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('mm3')
                );

                // Display the error message
                echo json_encode($data);

            } else {
                    
                // Data array
                $data = array();
                
                // Plan's metas array
                $plan_metas = array();
                        
                // List all inputs
                foreach( $all_inputs as $input ) {

                    if ( $input[0] === 'plan_name' ) {
                        $data['plan_name'] = $input[1];
                    } else if ( $input[0] === 'plan_price' ) {
                        $data['plan_price'] = $input[1];
                    } else if ( $input[0] === 'currency_sign' ) {
                        $data['currency_sign'] = $input[1];
                    } else if ( $input[0] === 'currency_code' ) {
                        $data['currency_code'] = $input[1];
                    } else if ( $input[0] === 'network_accounts' ) {
                        $data['network_accounts'] = $input[1];
                    } else if ( $input[0] === 'storage' ) {
                        $data['storage'] = $input[1];
                    } else if ( $input[0] === 'features' ) {
                        $data['features'] = $input[1];
                    } else if ( $input[0] === 'teams' ) {
                        $data['teams'] = $input[1];
                    } else if ( $input[0] === 'header' ) {
                        $data['header'] = $input[1];
                    } else if ( $input[0] === 'period' ) {
                        $data['period'] = $input[1];
                    } else {
                        $plan_metas[$input[0]] = $input[1];
                    }

                }
                
                // List all options
                foreach( $all_options as $option ) {

                    if ( $option[0] === 'visible' ) {
                        $data['visible'] = $option[1];
                    } else if ( $option[0] === 'popular' ) {
                        $data['popular'] = $option[1];
                    } else if ( $option[0] === 'featured' ) {
                        $data['featured'] = $option[1];
                    } else if ( $option[0] === 'trial' ) {
                        $data['trial'] = $option[1];
                    } else {
                        $plan_metas[$option[0]] = $option[1];
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
                
                // Verify if the plan was updated
                if( $plan_update ) {
                    
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
                
            }
            
        }
        
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
                $limit = 20;
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

                    // Display plans
                    $data = array(
                        'success' => TRUE,
                        'plans' => $plans,
                        'total' => $total,
                        'page' => ($page + 1)
                    );

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
        exit();
        
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

    /**
     * The public method reload_plan_dropdown reloads the dropdown for a plan
     * 
     * @since 0.0.8.2
     * 
     * @return void
     */
    public function reload_plan_dropdown() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('plan_id', 'Plan ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('option', 'Option', 'trim|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $plan_id = $this->CI->input->post('plan_id');
            $option = $this->CI->input->post('option');
            $key = $this->CI->input->post('key');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Verify if the option is for plans groups
                if ( $option === 'plans_group' ) {

                    // Response array
                    $response = array();

                    // Verify if the plan has a selected group
                    if ( plan_feature( 'plans_group', $plan_id ) ) {

                        // Get group by id
                        $get_group = $this->CI->base_model->get_data_where(
                            'plans_groups',
                            '*',
                            array(
                                'group_id' => plan_feature( 'plans_group', $plan_id )
                            )
                        );

                        // Verify if group exists
                        if ( $get_group ) {

                            // Set group
                            $response['selected'] = array(
                                'id' => $get_group[0]['group_id'],
                                'name' => $get_group[0]['group_name']
                            );

                        } else {

                            // Set default
                            $response['default'] = $this->CI->lang->line('user_select_plan_group');


                        }

                    } else {

                        // Set default
                        $response['default'] = $this->CI->lang->line('user_select_plan_group');

                    }

                    // Get groups
                    $get_groups = $this->CI->base_model->get_data_where(
                        'plans_groups',
                        '*',
                        array(),
                        array(),
                        array('group_name' => $this->CI->db->escape_like_str($key)),
                        array(),
                        array(
                            'order' => array('group_id', 'asc'),
                            'start' => 0,
                            'limit' => 10
                        )
                    );

                    // Verify if groups exists
                    if ( $get_groups ) {

                        // Items array
                        $items = array();

                        // List all groups
                        foreach ( $get_groups as $group ) {

                            // Set item
                            $items[] = array(
                                'id' => $group['group_id'],
                                'name' => $group['group_name'],
                            );

                        }

                        // Set items
                        $response['items'] = $items;

                    } else {

                        // Set default mesage
                        $response['no_items_message'] = $this->CI->lang->line('user_no_plans_groups_found');

                    }

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'response' => $response,
                        'option' => $option
                    );

                    // Display the success message
                    echo json_encode($data);
                    exit();

                } else if ( $option === 'user_redirect' ) {

                    // Response array
                    $response = array();

                    // Verify if the plan has a selected user_redirect
                    if ( plan_feature( 'user_redirect', $plan_id ) ) {
                        
                        // List all user's apps
                        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

                            // Get the directory's name
                            $app = trim(basename($directory) . PHP_EOL);

                            // Verify if the app is enabled
                            if ( !get_option('app_' .  $app. '_enable') ) {
                                continue;
                            }

                            // Create an array
                            $array = array(
                                'MidrubBase',
                                'User',
                                'Apps',
                                'Collection',
                                ucfirst($app),
                                'Main'
                            );

                            // Implode the array above
                            $cl = implode('\\', $array);

                            // Get app's info
                            $info = (new $cl())->app_info();

                            // Verify if redirect is the current app
                            if ( plan_feature( 'user_redirect', $plan_id ) === $info['app_slug'] ) {

                                // Set app
                                $response['selected'] = array(
                                    'id' => $info['app_slug'],
                                    'name' => $info['app_name']
                                );

                                break;

                            }

                        }

                        // Verify if an app was selected
                        if ( !isset($response['selected']) ) {

                            // List all user's components
                            foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

                                // Get the directory's name
                                $component = trim(basename($directory) . PHP_EOL);

                                // Verify if the component is enabled
                                if ( !get_option('component_' . $component . '_enable') ) {
                                    continue;
                                }

                                // Create an array
                                $array = array(
                                    'MidrubBase',
                                    'User',
                                    'Components',
                                    'Collection',
                                    ucfirst($component),
                                    'Main'
                                );

                                // Implode the array above
                                $cl = implode('\\', $array);

                                // Get component's info
                                $info = (new $cl())->component_info();

                                // Verify if redirect is the current component
                                if ( plan_feature( 'user_redirect', $plan_id ) === $info['component_slug'] ) {

                                    // Set component
                                    $response['selected'] = array(
                                        'id' => $info['component_name'],
                                        'name' => $info['component_slug']
                                    );

                                    break;

                                }

                            }

                        }

                        // Verify if app or component exists
                        if ( !isset($response['selected']) ) {

                            // Set default
                            $response['default'] = $this->CI->lang->line('user_select_component_or_app');


                        }

                    } else {

                        // Set default
                        $response['default'] = $this->CI->lang->line('user_select_component_or_app');

                    }

                    // Items array
                    $items = array();

                    // List all user's apps
                    foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

                        // Get the directory's name
                        $app = trim(basename($directory) . PHP_EOL);

                        // Verify if the app is enabled
                        if ( !get_option('app_' .  $app. '_enable') ) {
                            continue;
                        }

                        // Create an array
                        $array = array(
                            'MidrubBase',
                            'User',
                            'Apps',
                            'Collection',
                            ucfirst($app),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\', $array);

                        // Get app's info
                        $info = (new $cl())->app_info();

                        if ( preg_match("/{$key}/i", $info['app_name']) ) {

                            // Add info to items array
                            $items[] = array(
                                'name' => $info['app_name'],
                                'id' => $info['app_slug']
                            );

                        }

                        // Max number 10
                        if ( count($items) > 9 ) {
                            break;
                        }

                    }

                    // List all user's components
                    foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

                        // Get the directory's name
                        $component = trim(basename($directory) . PHP_EOL);

                        // Verify if the component is enabled
                        if ( !get_option('component_' . $component . '_enable') ) {
                            continue;
                        }

                        // Create an array
                        $array = array(
                            'MidrubBase',
                            'User',
                            'Components',
                            'Collection',
                            ucfirst($component),
                            'Main'
                        );

                        // Implode the array above
                        $cl = implode('\\', $array);

                        // Get component's info
                        $info = (new $cl())->component_info();

                        if ( preg_match("/{$key}/i", $info['component_name']) ) {

                            // Add info to items array
                            $items[] = array(
                                'name' => $info['component_name'],
                                'id' => $info['component_slug']
                            );

                        }

                        // Max number 10
                        if ( count($items) > 9 ) {
                            break;
                        }

                    }

                    // Verify if items exists
                    if ( $items ) {

                        // Set items
                        $response['items'] = $items;

                    } else {

                        // Set default mesage
                        $response['no_items_message'] = $this->CI->lang->line('user_no_apps_components_found');

                    }

                    // Prepare the success message
                    $data = array(
                        'success' => TRUE,
                        'response' => $response,
                        'option' => $option
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
            'message' => $this->CI->lang->line('user_error_occurred_request')
        );

        // Display the error message
        echo json_encode($data);

    }

}

/* End of file social.php */