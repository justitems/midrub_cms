<?php
/**
 * Emails Helpers
 *
 * This file contains the class Emails
 * with methods to manage the email templates
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Notifications\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Emails class provides the methods to manage the email templates
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
*/
class Emails {
    
    /**
     * Class variables
     *
     * @since 0.0.8.3
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.3
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load Notifications Model
        $this->CI->load->ext_model( CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'models/', 'Notifications_model', 'notifications_model' );
        
    }

    /**
     * The public method create_email_template saves an email's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function create_email_template() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('template', 'Template', 'trim|required');

            // Set languages
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);

            // List all languages
            foreach ( $languages as $language ) {

                // Set language's dir
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Set rule
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');

            }
            
            // Set template
            $template = $this->CI->input->post('template');
            
            // Languages container
            $langs = array();

            // List languages
            foreach ( $languages as $language ) {

                // Set language's dir
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Set content
                $langs[$only_dir] = $this->CI->input->post($only_dir, TRUE);
                
                // Verify if title is not empty
                if ( !$langs[$only_dir]['title'] ) {
                    
                    // Prepare error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_title_is_required')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                
                }
                
            }
            
            // Verify if a template is selected
            if ( !$template ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_please_select_template')
                );

                // Display the error response
                echo json_encode($data);
                exit();

            }

            // Verify if the selected email's template exists
            if ( !$this->the_template($template) ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_template_parent_do_not_exists')
                );

                // Display the error response
                echo json_encode($data);
                exit();

            }

            // Verify if the template is already in use
            if ( $this->CI->base_model->the_data_where('notifications_templates', 'template_id', array('template_slug' => $template) ) ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_template_already_use')
                );

                // Display the error response
                echo json_encode($data);
                exit();
                
            }

            // Check form validation
            if ( $this->CI->form_validation->run() !== false && $langs ) {

                // Prepare template args
                $template_args = array(
                    'user_id' => $this->CI->user_id,
                    'template_slug' => $template,
                    'created' => time()
                );

                // Save template by using the Base's Model
                $template_id = $this->CI->base_model->insert('notifications_templates', $template_args);

                // Verify if the template was saved
                if ( $template_id ) {

                    // Counters
                    $c = 0;

                    // List languages
                    foreach ($langs as $key => $value) {

                        // Prepare template's meta args
                        $template_meta_args = array(
                            'template_id' => $template_id,
                            'template_title' => $value['title'],
                            'template_body' => $value['body'],
                            'language' => $key
                        );

                        // Save template's meta by using the Base's Model
                        $meta_id = $this->CI->base_model->insert('notifications_templates_meta', $template_meta_args);

                        // Verify if meta was saved
                        if ( $meta_id ) {

                            // Increase counter
                            $c++;

                        } else {

                            break;

                        }
                        
                    }

                }

                // Verify if the template was saved
                if ( $c ) {
                    
                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('notifications_template_was_saved_successfully'),
                        'words' => array(
                            'no_placeholders_found' => $this->CI->lang->line('notifications_no_placeholders_found')
                        )
                    );

                    // Display the success response
                    echo json_encode($data);

                } else {

                    // Prepare success response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_template_was_not_saved_successfully')
                    );

                    // Display the success response
                    echo json_encode($data);

                }

                exit();
                
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
     * The public method update_email_template updates an email's template
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function update_email_template() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('template_id', 'Template ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('template', 'Template', 'trim|required');

            // Set languages
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);

            // List all languages
            foreach ( $languages as $language ) {

                // Set language's dir
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Set rule
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');

            }
            
            // Set template
            $template_id = $this->CI->input->post('template_id');
            $template = $this->CI->input->post('template');
            
            // Languages container
            $langs = array();

            // List languages
            foreach ( $languages as $language ) {

                // Set language's dir
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Set content
                $langs[$only_dir] = $this->CI->input->post($only_dir);
                
                // Verify if title is not empty
                if ( !$langs[$only_dir]['title'] ) {
                    
                    // Prepare error response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_title_is_required')
                    );

                    // Display the error response
                    echo json_encode($data);
                    exit();
                
                }
                
            }
            
            // Verify if a template is selected
            if ( !$template ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_please_select_template')
                );

                // Display the error response
                echo json_encode($data);
                exit();

            }

            // Verify if the selected email's template exists
            if ( !$this->the_template($template) ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_template_parent_do_not_exists')
                );

                // Display the error response
                echo json_encode($data);
                exit();

            }

            // Verify if the template is already in use
            if ( $this->CI->base_model->the_data_where('notifications_templates', 'template_id', array('template_id !=' => $template_id, 'template_slug' => $template) ) ) {

                // Prepare error response
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('notifications_template_already_use_another_template')
                );

                // Display the error response
                echo json_encode($data);
                exit();
                
            }

            // Check form validation
            if ( $this->CI->form_validation->run() !== false && $langs ) {

                // Verify if the template was saved
                if ( $template_id ) {

                    // Delete the template's meta
                    $this->CI->base_model->delete('notifications_templates_meta', array('template_id' => $template_id) );

                    // Counters
                    $c = 0;

                    // List languages
                    foreach ($langs as $key => $value) {

                        // Prepare template's meta args
                        $template_meta_args = array(
                            'template_id' => $template_id,
                            'template_title' => $value['title'],
                            'template_body' => $value['body'],
                            'language' => $key
                        );

                        // Save template's meta by using the Base's Model
                        $meta_id = $this->CI->base_model->insert('notifications_templates_meta', $template_meta_args);

                        // Verify if meta was saved
                        if ( $meta_id ) {

                            // Increase counter
                            $c++;

                        } else {

                            break;

                        }
                        
                    }

                }

                // Verify if the template was saved
                if ( $c ) {
                    
                    // Prepare success response
                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('notifications_template_was_updated_successfully')
                    );

                    // Display the success response
                    echo json_encode($data);

                } else {

                    // Prepare success response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('notifications_template_was_not_updated_successfully')
                    );

                    // Display the success response
                    echo json_encode($data);

                }

                exit();
                
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
     * The public method get_email_template_placeholder loads the email template's placeholders
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function get_email_template_placeholder() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('template_slug', 'Template Slug', 'trim|required');
            
            // Get received data
            $template_slug = $this->CI->input->post('template_slug');
           
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Get email's templates
                $email_templates = the_admin_notifications_email_templates();

                // Verify if email's templates exists
                if ( $email_templates ) {

                    // List email's templates
                    foreach ( $email_templates as $email_template ) {

                        // Get key
                        $key = key($email_template);

                        // Verify if array's key is the requested slug
                        if ( $template_slug === $key ) {

                            // Verify if placeholders exists
                            if ( !empty($email_template[$key]['template_placeholders']) ) {

                                // Prepare success message
                                $data = array(
                                    'success' => TRUE,
                                    'placeholders' => $email_template[$key]['template_placeholders']
                                );

                                // Display the success message
                                echo json_encode($data);
                                exit();

                            }

                        }

                    }

                }

            }
            
        }

        // Prepare error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('notifications_no_placeholders_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The public method email_templates_load_all loads the email templates
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    public function email_templates_load_all() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get received data
            $page = $this->CI->input->post('page');
            $key = $this->CI->input->post('key');

            // Set like
            $like = $key?array('LOWER(notifications_templates_meta.template_title)' => strtolower(trim(str_replace('!_', '_', $this->CI->db->escape_like_str($key))))):array();

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {

                // Set the limit
                $limit = 10;
                $page--;

                // Use the base model for a simply sql query
                $notifications_templates = $this->CI->base_model->the_data_where(
                'notifications_templates',
                'notifications_templates_meta.*, notifications_templates.template_slug',
                array(),
                array(),
                $like,
                array(
                    array(
                        'table' => 'notifications_templates_meta',
                        'condition' => 'notifications_templates.template_id=notifications_templates_meta.template_id',
                        'join_from' => 'LEFT'
                    )
                ),
                array(
                    'group_by' => array('notifications_templates.template_id'),
                    'order_by' => array('template_id', 'desc'),
                    'start' => ($page * $limit),
                    'limit' => $limit
                ));

                // Verify if email's templates exists
                if ( $notifications_templates ) {

                    // Get total number of email's templates with base model
                    $total = $this->CI->base_model->the_data_where(
                    'notifications_templates',
                    'COUNT(notifications_templates.template_id) AS total',
                    array(),
                    array(),
                    $like,
                    array(
                        array(
                            'table' => 'notifications_templates_meta',
                            'condition' => 'notifications_templates.template_id=notifications_templates_meta.template_id',
                            'join_from' => 'LEFT'
                        )
                    ),
                    array(
                        'group_by' => array('notifications_templates.template_id')
                    ));

                    // Get email's templates
                    $email_templates = the_admin_notifications_email_templates();

                    // Templates container
                    $templates = array();

                    // Verify if email's templates exists
                    if ( $email_templates ) {

                        // List email's templates
                        foreach ( $email_templates as $email_template ) {

                            // Get key
                            $key = key($email_template);

                            // Set template
                            $templates[$key] = $email_template[$key]['template_name'];

                        }

                    }

                    // Notifications templates container
                    $notifications_temps = array();
                    
                    // List all found notification's templates
                    foreach ( $notifications_templates as $notifications_template ) {

                        // Set template
                        $notifications_temps[] = array(
                            'template_id' => $notifications_template['template_id'],
                            'template_title' => $notifications_template['template_title'],
                            'template_body' => $notifications_template['template_body'],
                            'template' => isset($templates[$notifications_template['template_slug']])?$templates[$notifications_template['template_slug']]:$notifications_template['template_slug']
                        );

                    }

                    // Prepare the response
                    $data = array(
                        'success' => TRUE,
                        'templates' => $notifications_temps,
                        'total' => $total[0]['total'],
                        'page' => ($page + 1),
                        'words' => array(
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
            'message' => $this->CI->lang->line('notifications_no_templates_found')
        );

        // Delete the error message
        echo json_encode($data);
        
    }

    /**
     * The protected method delete_template deletes a template
     * 
     * @param integer $template_id contains the template's ID
     * 
     * @since 0.0.8.3
     * 
     * @return boolean true or false
     */
    protected function delete_template($template_id) {

        // Try to delete the template
        if ( $this->CI->base_model->delete('notifications_templates', array('template_id' => $template_id) ) ) {

            // Delete the template's meta
            $this->CI->base_model->delete('notifications_templates_meta', array('template_id' => $template_id) );

            return true;

        } else {

            return false;

        }

    }

    /**
     * The protected method the_template verifies if a template exists
     * 
     * @param string $template_slug contains the template's slug
     * 
     * @since 0.0.8.3
     * 
     * @return array with template parameters or boolean false
     */
    protected function the_template($template_slug) {

        // Get email's templates
        $email_templates = the_admin_notifications_email_templates();

        // Verify if email's templates exists
        if ( $email_templates ) {

            // List email's templates
            foreach ( $email_templates as $email_template ) {

                // Get key
                $key = key($email_template);

                // Verify if array's key is the requested slug
                if ( $template_slug === $key ) {

                    return $email_template[$key];

                }

            }

        }

        return false;

    }

}

/* End of file emails.php */