<?php
/**
 * Classification Helper
 *
 * This file contains the class Classification
 * with methods to manage the contents classifications
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Frontend\Helpers;

// Constants
defined('BASEPATH') or exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Contents as CmsBaseClassesContents;

/*
 * Classification class provides the methods to manage the contents classifications
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Classification
{

    /**
     * Class variables
     *
     * @since 0.0.7.9
     */
    protected $CI, $items = array();

    /**
     * Initialise the Class
     *
     * @since 0.0.7.9
     */
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();

        // Load Base Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_model', 'base_model');

        // Load Base Classification Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_classifications', 'base_classifications');
    }

    /**
     * The public method get_classification_data gets classification's data
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_classification_data()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('classification_slug', 'Classification Slug', 'trim');

            // Get received data
            $classification_slug = $this->CI->input->post('classification_slug');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Call the contents_categories class
                $contents_categories = (new CmsBaseClassesContents\Contents_categories);

                // Verify if options exists
                if ( $contents_categories::$the_contents_categories_options ) {
                    
                    // List all categories options
                    foreach ( $contents_categories::$the_contents_categories_options as $option ) {

                        // Verify if the $option has fields
                        if ( isset($option[0]['fields'][0]['slug']) ) {
                            
                            // List all fields
                            foreach( $option as $fields ) {
                                
                                foreach ( $fields['fields'] as $field ) {

                                    // Verify if classification slug is equal to requested classification's slug
                                    if ( ($field['slug'] === $classification_slug) && ($field['type'] === 'contents_classification') ) {

                                        // Verify if words list exists
                                        if ( isset($field['words_list']['search_input_placeholder']) && isset($field['words_list']['new_classification_option']) && isset($field['words_list']['classification_slug_input_placeholder']) && isset($field['words_list']['classification_name_input_placeholder']) && isset($field['words_list']['single_item']) ) {
                                            
                                            // Set default input
                                            $inputs = '<div class="row">'
                                                . '<div class="col-xs-12">'
                                                    . '<input type="text" class="form-control classification-input theme-text-input-1 mb-3" placeholder="' . $field['words_list']['classification_name_input_placeholder'] . '" data-meta="name">'
                                                . '</div>'
                                            . '</div>';

                                            // Verify if classification has fields
                                            if ( isset( $field['fields'][0]['slug'] ) ) {

                                                // List all fields
                                                foreach ( $field['fields'] as $cfield ) {

                                                    if ( $cfield['type'] === 'text' ) {

                                                        $inputs .= '<div class="row">'
                                                            . '<div class="col-xs-12">'
                                                                . '<input type="text" class="form-control classification-input theme-text-input-1 mb-3" placeholder="' . $cfield['placeholder'] . '" data-meta="' . $cfield['slug'] . '">'
                                                            . '</div>'
                                                        . '</div>';

                                                    }

                                                }
                                                
                                            }

                                            // Return success response
                                            $data = array(
                                                'success' => TRUE,
                                                'field' => $field,
                                                'inputs' => $inputs
                                            );
                                    
                                            echo json_encode($data);
                                            exit();

                                        }

                                    }
                        
                                }
                    
                            }
                
                        }
            
                    }
        
                }
    
            }

        }

        // Return error message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_classification_wrong_parameters')
        );

        echo json_encode($data);
    }

    /**
     * The public method create_new_classification_item saves classification's item
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function create_new_classification_item()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('parent', 'parent', 'trim|numeric');
            $this->CI->form_validation->set_rules('slug', 'Slug', 'trim|required');
            $this->CI->form_validation->set_rules('meta_option_classification_slug', 'Meta Option Slug', 'trim|required');
            $this->CI->form_validation->set_rules('single_item', 'Single Item', 'trim|required');

            // Get all languages
            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

            // List all languages
            foreach ($languages as $language) {

                // Get language directory
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Add validation
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');

            }

            // Get received data
            $parent = $this->CI->input->post('parent');
            $slug = $this->CI->input->post('slug');
            $meta_option_classification_slug = $this->CI->input->post('meta_option_classification_slug');
            $single_item = $this->CI->input->post('single_item');

            // Empty langs array
            $langs = array();

            // List all languages
            foreach ( $languages as $language ) {

                // Get language directory
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                // Get language value
                $langs[$only_dir] = $this->CI->input->post($only_dir);

                // Verify if title exists
                if ( !$langs[$only_dir]['name']['meta'] ) {
                    
                    // Display error message
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('frontend_please_fill_all_required_fields')
                    );

                    echo json_encode($data);
                    exit();
                
                }
                
            }

            // Check form validation
            if ($this->CI->form_validation->run() === false) {

                // Display error message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('frontend_submitted_data_is_not_valid')
                );

                echo json_encode($data);
                exit();

            } else {

                // Prepare data to save
                $params = array(
                    'classification_slug' => $meta_option_classification_slug,
                    'classification_type' => 'contents_classification'
                );

                // Verify if a parent exists
                if ( $parent ) {

                    $check_parent = $this->CI->base_model->the_data_where('classifications', 'classification_id', array(
                        'classification_id' => $parent,
                        'classification_type' => 'contents_classification'
                    ));

                    if ( $check_parent ) {
                        $params['classification_parent'] = $parent;
                    }

                }

                // Save classification's item
                $classification_id = $this->CI->base_model->insert('classifications', $params);

                // Verify if classification's item exists
                if ( !$classification_id ) {

                    // Send error response
                    $data = array(
                        'success' => FALSE,
                        'message' => str_replace('(item)', $single_item, $this->CI->lang->line('frontend_classification_item_was_not_saved'))
                    );

                    echo json_encode($data);
                    exit();

                }

                // Remove non allowed characters
                $new_slug = preg_replace(array('#[\\s-]+#', '#[^A-Za-z0-9\. -]+#'), array('-', ''), $slug);

                // Verify if url's slug is still valid
                if ($new_slug) {

                    // Prepare url's slug
                    $new_slug = strtolower(str_replace(' ', '-', $new_slug));

                    // If the slug already exists will generate a new slug
                    for ($e = 0; $e < 1000; $e++) {

                        // If $e is bigger than 0, will be renamed the slug
                        if ($e > 0) {

                            $slugs = explode('-', $new_slug);

                            if ( count($slugs) > 0 ) {

                                end($slugs);
                                $key = key($slugs);

                                if ( is_numeric($slugs[$key]) ) {
                                    $slugs[$key] = $e;
                                    $new_slug = implode('-', $slugs);
                                } else {
                                    $slugs[$key] = $slugs[$key] . '-' . $e;
                                    $new_slug = implode('-', $slugs);                                    
                                }

                            } else {

                                $new_slug = $new_slug . '-' . $e;                                

                            }

                        }

                        // Prepare arguments
                        $args = array(
                            'slug' => $new_slug,
                            'type' => 'contents_classification'
                        );

                        // Get slug
                        $class_slug = $this->CI->base_classifications->get_classifications_item_by_slug($args);

                        // Verify if slug doesn't exists
                        if (!$class_slug) {
                            break;
                        }
                        
                    }

                }

                // If new slug is still empty use classification's ID
                if ( !$new_slug ) {
                    $new_slug = $classification_id;
                }

                // Count data saved
                $c = 0;

                // List all languages
                foreach ($langs as $key => $value) {

                    // Get metas
                    $metas = array_keys($value);

                    // Verify if $metas is not empty
                    if ($metas) {

                        // List all metas
                        foreach ($value as $val) {

                            // Verify if meta has correct format
                            if (isset($val['meta']) && isset($val['value'])) {

                                // Prepare data to save
                                $params = array(
                                    'classification_id' => $classification_id,
                                    'meta_slug' => $new_slug,
                                    'meta_name' => $val['meta'],
                                    'meta_value' => $val['value'],
                                    'language' => $key
                                );

                                // Save the content meta
                                if ( $this->CI->base_model->insert('classifications_meta', $params) ) {
                                    $c++;
                                }

                            }

                        }

                    }

                }

                if ($c > 0) {

                    // Send success response
                    $data = array(
                        'success' => TRUE,
                        'message' => str_replace('(item)', $single_item, $this->CI->lang->line('frontend_classification_item_was_saved'))
                    );

                    echo json_encode($data);
                    exit();

                } else {

                    // Send error response
                    $data = array(
                        'success' => FALSE,
                        'message' => str_replace('(item)', $single_item, $this->CI->lang->line('frontend_classification_item_was_not_saved'))
                    );

                    echo json_encode($data);
                    exit();
                    
                }

            }

        }

        // Send error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_an_error_occurred')
        );

        echo json_encode($data);

    }
    
    /**
     * The public method get_classification_parents returns classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_classification_parents()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('meta_option_classification_slug', 'Meta Option Classification Slug', 'trim|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get received data
            $meta_option_classification_slug = $this->CI->input->post('meta_option_classification_slug');
            $key = $this->CI->input->post('key');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                $args = array(
                    'classification_slug' => $meta_option_classification_slug,
                    'classification_type' => 'contents_classification',
                    'subclassifications' => TRUE
                );

                // Get classifications
                $classifications = $this->CI->base_classifications->the_classifications_by_slug($args);

                // Verify if classifications exists
                if ( $classifications ) {

                    // Classifications Items
                    $classification_items = array();

                    // List all classifications
                    foreach ($classifications as $classification) {

                        $classification_items[$classification['classification_parent']][] = $classification;

                    }

                    if ($classification_items) {

                        // Order items
                        $this->order_items($classification_items);
                        
                    }

                    // All classifications
                    $all_classifications = array();

                    $total = 0;

                    $parent = '';

                    // List all classifications
                    foreach( $this->items as $classification ) {

                        if ( $classification['classification_parent'] < 1 ) {
                            $parent = $classification['classification_name'];
                        }

                        if ( preg_match("/{$key}/i", $classification['classification_name'] ) ) {

                            if ( $classification['classification_parent'] < 1 ) {

                                $all_classifications[] = $classification;

                            } else {

                                $classification['classification_name'] = $parent . ' &#8594; ' . $classification['classification_name'];

                                $all_classifications[] = $classification;

                            }

                            $total++;

                        }

                        if ( $total > 99 ) {
                            break;
                        }

                    }

                    // Send success response
                    $data = array(
                        'success' => TRUE,
                        'classifications' => $all_classifications,
                        'select_a_parent' => $this->CI->lang->line('frontend_select_a_parent')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Send error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_data_found_to_show'),
            'select_a_parent' => $this->CI->lang->line('frontend_select_a_parent')
        );

        echo json_encode($data);        

    }

    /**
     * The public method load_classifications returns classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function load_classifications()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('meta_option_classification_slug', 'Meta Option Classification Slug', 'trim|required');

            // Get received data
            $meta_option_classification_slug = $this->CI->input->post('meta_option_classification_slug');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                $args = array(
                    'classification_slug' => $meta_option_classification_slug,
                    'classification_type' => 'contents_classification',
                    'subclassifications' => TRUE
                );

                // Get classifications
                $classifications = $this->CI->base_classifications->the_classifications_by_slug($args);

                // Verify if classifications exists
                if ( $classifications ) {

                    // Classifications Items
                    $classification_items = array();

                    // List all classifications
                    foreach ($classifications as $classification) {

                        $classification_items[$classification['classification_parent']][] = $classification;
                    }

                    if ($classification_items) {

                        // Order items
                        $this->order_items($classification_items);
                        
                    }

                    // All classifications
                    $all_classifications = '';

                    // Count ul
                    $count_ul = 0;

                    // Last classification's parent
                    $classification_parent = 0;

                    // Parent level
                    $parent_level = array();

                    // Verify if items exists
                    if ($this->items) {

                        // List all classifications
                        foreach ($this->items as $classification) {

                            if ($classification_parent < $classification['classification_parent']) {

                                $all_classifications .= '<ul class="collapse" id="classification-show-collection-' . $classification['classification_parent'] . '">';

                                $count_ul++;

                                $parent_level[$classification['classification_parent']] = $count_ul;

                            } else if ($classification_parent > $classification['classification_parent']) {

                                if ($classification['classification_parent'] < 1) {

                                    for ( $f = $count_ul; $f > 0; $f-- ) {
                                        $all_classifications .= '</ul>';
                                    }

                                    $count_ul = 0;

                                    $parent_level = array();

                                } else {

                                    $minus = $count_ul - $parent_level[$classification['classification_parent']];

                                    for ( $m = 0; $m < $minus; $m++ ) {
                                        $count_ul--;
                                        $all_classifications .= '</ul>';
                                    }

                                }

                            }

                            // Set new parent
                            $classification_parent = $classification['classification_parent'];

                            $pa = 0;

                            if ( $classification['classification_parent'] ) {
                                $pa = $parent_level[$classification['classification_parent']];
                            }

                            if ($all_classifications) {
                                $all_classifications .= '</li>';
                            }

                            // Add html
                            $all_classifications .= $this->classification_template($classification['classification_name'], $classification['classification_id']);

                        }

                    }

                    if ( !$all_classifications ) {

                        // Send error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('frontend_no_data_found_to_show')
                        );

                        echo json_encode($data);
                        exit();

                    }

                    if ( $classification_parent > 0 ) {
                        $all_classifications .= '</ul>';
                    } 

                    $all_classifications .= '</li>';

                    // Send success response
                    $data = array(
                        'success' => TRUE,
                        'classifications' => $all_classifications,
                        'select_a_parent' => $this->CI->lang->line('frontend_select_a_parent')
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Send error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_data_found_to_show')
        );

        echo json_encode($data);   

    }

    /**
     * The public method selected_classification_item returns selected classification's items from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function selected_classification_item()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_classification_ids', 'All Classification Ids', 'trim');
            $this->CI->form_validation->set_rules('classification_slug', 'Classification Slug', 'trim|required');

            // Get received data
            $all_classification_ids = $this->CI->input->post('all_classification_ids');
            $classification_slug = $this->CI->input->post('classification_slug');

            // Check form validation
            if ( ($this->CI->form_validation->run() !== false) && $all_classification_ids ) {

                $args = array(
                    'slug' => $classification_slug,
                    'type' => 'contents_classification',
                    'subclassifications' => TRUE
                );

                // Get classifications
                $classifications = $this->CI->base_classifications->the_classifications_by_slug($args);

                // Verify if classifications exists
                if ( $classifications ) {

                    // Classifications Items
                    $classification_items = array();

                    // List all classifications
                    foreach ($classifications as $classification) {

                        $classification_items[$classification['classification_parent']][] = $classification;
                    }

                    if ($classification_items) {

                        // Order items
                        $this->order_items($classification_items, $all_classification_ids);
                        
                    }

                    // All classifications
                    $all_classifications = '';

                    // Count ul
                    $count_ul = 0;

                    // Last classification's parent
                    $classification_parent = 0;

                    // Parent level
                    $parent_level = array();

                    // Verify if items exists
                    if ($this->items) {

                        // List all classifications
                        foreach ($this->items as $classification) {

                            if ($classification_parent < $classification['classification_parent']) {
                                $all_classifications .= '<ul class="collapse" id="classification-show-selected-collection-' . $classification['classification_parent'] . '">';
                                $count_ul++;
                                $parent_level[$classification['classification_parent']] = $count_ul;
                            } else if ($classification_parent > $classification['classification_parent']) {

                                if ($classification['classification_parent'] < 1) {

                                    for ( $f = $count_ul; $f > 0; $f-- ) {
                                        $all_classifications .= '</ul>';
                                    }

                                    $count_ul = 0;

                                    $parent_level = array();

                                } else {

                                    $minus = $count_ul - $parent_level[$classification['classification_parent']];

                                    for ( $m = 0; $m < $minus; $m++ ) {
                                        $count_ul--;
                                        $all_classifications .= '</ul>';
                                    }

                                }

                            }

                            // Set new parent
                            $classification_parent = $classification['classification_parent'];

                            if ($all_classifications) {
                                $all_classifications .= '</li>';
                            }

                            // Add html
                            $all_classifications .= $this->selected_classification_template($classification['classification_name'], $classification['classification_id'], $all_classification_ids);

                        }

                    }

                    if ( !$all_classifications ) {

                        // Send error response
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('frontend_no_data_found_to_show'),
                            'classification_slug' => $classification_slug
                        );

                        echo json_encode($data);
                        exit();

                    }

                    if ( $classification_parent > 0 ) {
                        $all_classifications .= '</ul>';
                    } 

                    $all_classifications .= '</li>';

                    // Send success response
                    $data = array(
                        'success' => TRUE,
                        'classifications' => $all_classifications,
                        'classification_slug' => $classification_slug
                    );

                    echo json_encode($data);
                    exit();

                }

            }

        }

        // Send error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_no_data_found_to_show'),
            'classification_slug' => $classification_slug
        );

        echo json_encode($data);   

    }

    /**
     * The public method delete_classification deletes classification's item from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function delete_classification()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('all_classification_ids', 'Classification IDs', 'trim');
            $this->CI->form_validation->set_rules('single_item', 'Single Item', 'trim|required');

            // Get received data
            $all_classification_ids = $this->CI->input->post('all_classification_ids');
            $single_item = $this->CI->input->post('single_item');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                $c = 0;

                if ( $all_classification_ids ) {

                    foreach ( $all_classification_ids as $classification_id ) {

                        // Delete old menu's items
                        if ($this->CI->base_model->delete('classifications', array(
                            'classification_id' => $classification_id
                        ))) {

                            $c++;

                            $this->CI->base_model->delete('classifications_meta', array(
                                'classification_id' => $classification_id
                            ));

                            $this->CI->base_model->delete('contents_classifications', array(
                                'classification_value' => $classification_id
                            ));                            

                        }

                    }

                }


                if ($c > 0) {

                    // Send success response
                    $data = array(
                        'success' => TRUE,
                        'message' => str_replace('(item)', $single_item, $this->CI->lang->line('frontend_classification_item_was_deleted'))
                    );

                    echo json_encode($data);
                    exit();

                } else {

                    // Send error response
                    $data = array(
                        'success' => FALSE,
                        'message' => str_replace('(item)', $single_item, $this->CI->lang->line('frontend_classification_item_was_not_deleted'))
                    );

                    echo json_encode($data);
                    exit();
                    
                }

            }

        }

        // Send error response
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('frontend_an_error_occurred')
        );

        echo json_encode($data);

    }

    /**
     * The public method get_content_classifications gets content's classifications from the database
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function get_content_classifications()
    {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('content_id', 'Content ID', 'trim|numeric|required');

            // Get received data
            $content_id = $this->CI->input->post('content_id');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Gets classifications
                $contents_classifications = $this->CI->base_model->the_data_where(
                    'contents_classifications',
                    'classification_slug, classification_value',
                    array(
                        'content_id' => $content_id
                    )
                );

                $classifications_list = array();

                if ( $contents_classifications ) {

                    foreach ( $contents_classifications as $contents_classification ) {

                        if ( !isset($classifications_list[$contents_classification['classification_slug']]) ) {
                            $classifications_list[$contents_classification['classification_slug']] = array();
                        }

                        $classifications_list[$contents_classification['classification_slug']][] = $contents_classification['classification_value'];

                    }
                    
                }

                if ( $classifications_list ) {

                    $response = array();

                    foreach ( $classifications_list as $classification_slug => $all_classification_ids ) {

                        $args = array(
                            'slug' => $classification_slug,
                            'type' => 'contents_classification',
                            'subclassifications' => TRUE
                        );

                        // Get classifications
                        $classifications = $this->CI->base_classifications->the_classifications_by_slug($args);

                        // Verify if classifications exists
                        if ($classifications) {

                            // Classifications Items
                            $classification_items = array();

                            // List all classifications
                            foreach ($classifications as $classification) {

                                $classification_items[$classification['classification_parent']][] = $classification;

                            }

                            if ($classification_items) {

                                // Order items
                                $this->order_items($classification_items, $all_classification_ids);

                            }

                            // Count ul
                            $count_ul = 0;

                            // All classifications
                            $all_classifications = '';

                            // Last classification's parent
                            $classification_parent = 0;

                            // Parent level
                            $parent_level = array();

                            // Verify if items exists
                            if ( $this->items ) {

                                // List all classifications
                                foreach ($this->items as $classification) {

                                    if ($classification_parent < $classification['classification_parent']) {
                                        $all_classifications .= '<ul class="collapse" id="classification-show-selected-collection-' . $classification['classification_parent'] . '">';
                                        $count_ul++;
                                        $parent_level[$classification['classification_parent']] = $count_ul;
                                    } else if ($classification_parent > $classification['classification_parent']) {

                                        if ($classification['classification_parent'] < 1) {

                                            for ( $f = $count_ul; $f > 0; $f-- ) {
                                                $all_classifications .= '</ul>';
                                            }
        
                                            $count_ul = 0;
        
                                            $parent_level = array();
        
                                        } else {
        
                                            $minus = $count_ul - $parent_level[$classification['classification_parent']];
        
                                            for ( $m = 0; $m < $minus; $m++ ) {
                                                $count_ul--;
                                                $all_classifications .= '</ul>';
                                            }
        
                                        }

                                    }

                                    // Set new parent
                                    $classification_parent = $classification['classification_parent'];

                                    if ($all_classifications) {
                                        $all_classifications .= '</li>';
                                    }

                                    // Add html
                                    $all_classifications .= $this->selected_classification_template($classification['classification_name'], $classification['classification_id'], $all_classification_ids);
                                }
                            }

                            if (!$all_classifications) {

                                // Add error response
                                $response[] = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('frontend_no_data_found_to_show'),
                                    'classification_slug' => $classification_slug
                                );

                                continue;

                            }

                            if ($classification_parent > 0) {
                                $all_classifications .= '</ul>';
                            }

                            $all_classifications .= '</li>';

                            // Add success response
                            $response[] = array(
                                'success' => TRUE,
                                'classifications' => $all_classifications,
                                'classification_slug' => $classification_slug
                            );

                        }

                        $this->items = array();

                    }

                    if ( $response ) {

                        // Send success response
                        $data = array(
                            'success' => TRUE,
                            'response' => $response
                        );

                        echo json_encode($data);

                    }

                }

            }

        }

    }

    /**
     * The public method order_items orders classification's items
     * 
     * @param array $classification_items contains the classification's items list
     * @param array $ids contains the classification's ids
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */
    public function order_items($classification_items, $ids=array())
    {

        $items = array();

        $selected = array();

        foreach ($classification_items as $item) {

            // Verify if parent is 0
            if ($item[0]['classification_parent'] > 0) {
                continue;
            }

            for ($w = 0; $w < count($item); $w++) {

                // Add item to the list
                $items[] = $item[$w];

                if ( in_array($item[$w]['classification_id'], $ids) ) {
                    $selected[] = $item[$w]['classification_id'];
                }

                // Verify if item has array
                if (isset($classification_items[$item[$w]['classification_id']])) {

                    // List all sub items
                    for ($s = 0; $s < count($classification_items[$item[$w]['classification_id']]); $s++) {

                        $items[] = $classification_items[$item[$w]['classification_id']][$s];

                        if ( in_array($classification_items[$item[$w]['classification_id']][$s]['classification_id'], $ids) ) {
                            $selected[] = $item[$w]['classification_id'];
                        }

                        if ( isset($classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']]) ) {

                            for ($s2 = 0; $s2 < count($classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']]); $s2++) {

                                $items[] = $classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2];

                                if ( in_array($classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id'], $ids) ) {
                                    $selected[] = $item[$w]['classification_id'];
                                }

                                if ( isset($classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']]) ) {

                                    for ($s3 = 0; $s3 < count($classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']]); $s3++) {

                                        $items[] = $classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3];

                                        if ( in_array($classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id'], $ids) ) {
                                            $selected[] = $item[$w]['classification_id'];
                                        }

                                        if ( isset($classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']]) ) {

                                            for ($s4 = 0; $s4 < count($classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']]); $s4++) {

                                                $items[] = $classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4];

                                                if ( in_array($classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id'], $ids) ) {
                                                    $selected[] = $item[$w]['classification_id'];
                                                }

                                                if ( isset($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']]) ) {

                                                    for ($s5 = 0; $s5 < count($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']]); $s5++) {
        
                                                        $items[] = $classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5];
        
                                                        if ( in_array($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5]['classification_id'], $ids) ) {
                                                            $selected[] = $item[$w]['classification_id'];
                                                        }
        
                                                        if ( isset($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5]['classification_id']]) ) {

                                                            for ($s6 = 0; $s6 < count($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5]['classification_id']]); $s6++) {
                
                                                                $items[] = $classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5]['classification_id']][$s6];
                
                                                                if ( in_array($classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$classification_items[$item[$w]['classification_id']][$s]['classification_id']][$s2]['classification_id']][$s3]['classification_id']][$s4]['classification_id']][$s5]['classification_id']][$s6]['classification_id'], $ids) ) {
                                                                    $selected[] = $item[$w]['classification_id'];
                                                                }
                
                                                                
                
                                                            }
                
                                                        }
        
                                                    }
        
                                                }

                                            }

                                        }

                                    }

                                }

                            }

                        }

                    }

                }

            }

        }

        if ( $ids ) {

            $stop = 0;

            foreach ( $items as $item ) {

                // Verify if parent is 0
                if ( $item['classification_parent'] > 0 && $stop > 0 ) {
                    continue;
                }

                if ( !in_array($item['classification_id'], $selected) && ($item['classification_parent'] < 1) ) {
                    $stop = 1;
                    continue;
                } else if ( in_array($item['classification_id'], $selected) && ($item['classification_parent'] < 1) ) {
                    $stop = 0;
                }

                $this->items[] = $item;

            }

        } else {

            $this->items = $items;

        }

    }

    /**
     * The public method classification_template returns html code for classification
     * 
     * @param string $classification_name contains the classification's name
     * @param integer $classification_id contains the classification's id
     * 
     * @since 0.0.7.9
     * 
     * @return string with html code
     */
    public function classification_template($classification_name, $classification_id)
    {

        return  '<li>'
        . '<div class="row">'
            . '<div class="col-10 d-flex justify-content-start position-relative">'
                . '<div class="checkbox-option-select theme-checkbox-input-1">'
                    . '<label for="frontend-contents-single-' . $classification_id . '">'
                        . '<input type="checkbox" id="frontend-contents-single-' . $classification_id . '" name="frontend-contents-single-' . $classification_id . '" data-id="' . $classification_id . '" />'
                        . '<span class="theme-checkbox-checkmark"></span>'
                    . '</label>'
                . '</div>'
                . '<a href="#classification-show-collection-' . $classification_id . '" role="button" class="d-flex justify-content-between" aria-controls="classification-show-collection-' . $classification_id . '" data-bs-toggle="collapse">'
                    . '<span>'
                        . $classification_name . ' (' . $classification_id . ')'
                    . '</span>'
                    . md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon'))
                . '</a>'
            . '</div>'
            . '<div class="col-2 text-end">'
                . '<a href="#" role="button" class="delete-classification-single d-block">'
                    . md_the_admin_icon(array('icon' => 'delete'))
                . '</a>'
            . '</div>'
        . '</div>';

    }

    /**
     * The public method selected_classification_template returns html code for selected items
     * 
     * @param string $classification_name contains the classification's name
     * @param integer $classification_id contains the classification's id
     * @param array $all_classification_ids contains the selected ids
     * 
     * @since 0.0.7.9
     * 
     * @return string with html code
     */
    public function selected_classification_template($classification_name, $classification_id, $all_classification_ids)
    {

        // Default checked
        $checked = '';

        // Verify if current id is in array
        if ( in_array($classification_id, $all_classification_ids) ) {
            $checked = ' checked';
        }

        return  '<li>'
        . '<div class="row">'
            . '<div class="col-12 d-flex justify-content-start position-relative">'
                . '<div class="checkbox-option-select theme-checkbox-input-1">'
                    . '<label for="frontend-contents-selected-' . $classification_id . '">'
                        . '<input type="checkbox" id="frontend-contents-selected-' . $classification_id . '" name="frontend-contents-selected-' . $classification_id . '" data-id="' . $classification_id . '"' . $checked . ' />'
                        . '<span class="theme-checkbox-checkmark"></span>'
                    . '</label>'
                . '</div>'
                . '<a href="#classification-show-selected-collection-' . $classification_id . '" role="button" class="d-flex justify-content-between" aria-controls="classification-show-selected-collection-' . $classification_id . '" data-bs-toggle="collapse">'
                    . '<span>'
                        . $classification_name . ' (' . $classification_id . ')'
                    . '</span>'
                    . md_the_admin_icon(array('icon' => 'arrow_down', 'class' => 'theme-dropdown-arrow-icon'))
                . '</a>'
            . '</div>'
        . '</div>';

    }

}

/* End of file classification.php */
