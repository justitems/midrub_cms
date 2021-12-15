<?php
/**
 * Categories Helper
 *
 * This file contains the class Categories
 * with methods to manage the Faq's Categories
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace CmsBase\Admin\Components\Collection\Support\Helpers;

// Constants
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Categories class provides the methods to manage the Faq's Categories
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Categories
{

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
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();

    }

    /**
     * The public method load_all_faq_categories loads all Faq's Categories
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_all_faq_categories() {

        // Get the Faq's Categories
        $categories = $this->CI->faq_model->get_categories();

        // Verify if Faq's Categories exists
        if ( $categories ) {

            // Prepare categories
            $categories_html = '<ul>';

            $subcategories = array();

            foreach ($categories as $category) {

                if ($category->parent > 0) {

                    $subcategories[$category->parent][] = $category;
                }
            }

            foreach ($categories as $cat) {

                if ($cat->parent > 0) {
                    continue;
                }

                $subcats = '';

                if (isset($subcategories[$cat->category_id])) {

                    $subcats .= '<ul>';

                    foreach ($subcategories[$cat->category_id] as $subcat) {

                        $subcats .= '<li>'
                            . '<div class="row">'
                                . '<div class="col-lg-10">'
                                    . '<h3>'
                                        . $subcat->name
                                    . '</h3>'
                                . '</div>'
                                . '<div class="col-lg-2 text-end">'
                                    . '<a href="#" role="button" class="support-delete-category" data-id="' . $subcat->category_id . '">'
                                        . md_the_admin_icon(array('icon' => 'delete'))
                                    . '</a>'
                                . '</div>'
                            . '</div>'
                        . '</li>';
                    }

                    $subcats .= '</ul>';
                }

                $categories_html .= '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-10">'
                            . '<h3>'
                                . $cat->name
                            . '</h3>'
                        . '</div>'
                        . '<div class="col-lg-2 text-end">'
                            . '<a href="#" role="button" class="support-delete-category" data-id="' . $cat->category_id . '">'
                                . md_the_admin_icon(array('icon' => 'delete'))
                            . '</a>'
                        . '</div>'
                    . '</div>'
                    . $subcats
                . '</li>';
            }

            $categories_html .= '</ul>';

            // Send categories
            $data = array(
                'success' => TRUE,
                'categories' => $categories_html
            );

            echo json_encode($data);

        } else {

            // Send no categories message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('support_no_categories_found')
            );

            echo json_encode($data);

        }

    }

    /**
     * The public method refresh_categories_list loads categories for the Faq's article
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function refresh_categories_list() {

        // Get the Faq's Categories
        $categories = $this->CI->faq_model->get_categories();

        // Verify if Faq's Categories exists
        if ( $categories ) {

            // Prepare categories
            $categories_html = '<ul>';

            $subcategories = array();

            foreach ($categories as $category) {

                if ($category->parent > 0) {

                    $subcategories[$category->parent][] = $category;
                }
            }

            foreach ($categories as $cat) {

                if ($cat->parent > 0) {
                    continue;
                }

                $subcats = '';

                if (isset($subcategories[$cat->category_id])) {

                    $subcats .= '<ul>';

                    foreach ($subcategories[$cat->category_id] as $subcat) {

                        $subcats .= '<li>'
                            . '<div class="row">'
                                . '<div class="col-lg-12">'
                                    . '<div class="checkbox-option-select theme-checkbox-input-1">'
                                        . '<label for="faq-category-' . $subcat->category_id . '">'
                                            . '<input type="checkbox" name="faq-category-' . $subcat->category_id . '" id="faq-category-' . $subcat->category_id . '" data-id="' . $subcat->category_id . '">'
                                            . '<span class="theme-checkbox-checkmark"></span>'
                                        . '</label>'
                                    . '</div>'
                                    . '<span class="support-category-name">'
                                        . $subcat->name
                                    . '</span>'
                                . '</div>'
                            . '</div>'
                        . '</li>';
    
                    }

                    $subcats .= '</ul>';
                
                }

                $categories_html .= '<li>'
                    . '<div class="row">'
                        . '<div class="col-lg-12">'
                            . '<div class="checkbox-option-select theme-checkbox-input-1">'
                                . '<label for="faq-category-' . $cat->category_id . '">'
                                    . '<input type="checkbox" name="faq-category-' . $cat->category_id . '" id="faq-category-' . $cat->category_id . '" data-id="' . $cat->category_id . '">'
                                    . '<span class="theme-checkbox-checkmark"></span>'
                                . '</label>'
                            . '</div>'
                            . '<span class="support-category-name">'
                                . $cat->name
                            . '</span>'
                        . '</div>'
                    . '</div>'
                    . $subcats
                . '</li>';

            }

            $categories_html .= '</ul>';

            // Send categories
            $data = array(
                'success' => TRUE,
                'categories' => $categories_html
            );

            echo json_encode($data);

        } else {

            // Send no categories message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('support_no_categories_found')
            );

            echo json_encode($data);

        }

    }

    /**
     * The public method support_get_categories_parents gets all Parents Faq's Categories
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function support_get_categories_parents() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');

            // Get received data
            $key = $this->CI->input->post('key');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {

                // Get the Faq's Categories
                $categories = $this->CI->faq_model->get_categories();

                // Verify if Faq's Categories exists
                if ( $categories ) {

                    // Parents categories
                    $parents = array();

                    // List all categories
                    foreach ($categories as $category) {

                        // Verify if is a parent
                        if ($category->parent < 1) {

                            // Verify if key exists
                            if ( $key ) {

                                // Verify if category meets the key
                                if ( strpos($category->name, $key) === FALSE ) {
                                    continue;
                                }

                            }

                            // Append category
                            $parents[] = $category;

                            // Verify if 10 parents were found
                            if ( count($parents) > 9 ) {
                                break;
                            }

                        }

                    }

                    // Verify if categories exists
                    if ( $parents ) {

                        // Prepare the categories response
                        $data = array(
                            'success' => TRUE,
                            'categories' => $parents
                        );

                        // Display the categories response
                        echo json_encode($data);
                        exit();

                    }

                }

            }

        }

        // Prepare the no categories message
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('support_no_categories_found')
        );

        // Display the no categories message
        echo json_encode($data);

    }

    /**
     * The public method create_category creates a category
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function create_category() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('parent', 'Parent', 'trim');
            
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');
            }
            
            $langs = array();
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $langs[$only_dir] = $this->CI->input->post($only_dir);
            }

            // Get data
            $parent = $this->CI->input->post('parent');

            // If parent is false, will be 0
            if ( !$parent ) {
                $parent = 0;
            }

            // Check form validation
            if ($this->CI->form_validation->run() === false || !$langs ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('support_an_error_occured')
                );

                echo json_encode($data);

            } else {

                $category_id = $this->CI->faq_model->save_category($parent);

                if ( $category_id ) {

                    $c = 0;
                    foreach ( $langs as $key => $value ) {
                        if ( $this->CI->faq_model->save_category_meta($category_id, $value, $key) ) {
                            $c++;
                        }
                    }
                    
                    if ( !$c ) {
                        
                        // If meta wasn't saved will be deleted the category
                        $this->CI->faq->delete_category($category_id);
                        
                        $this->data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('support_an_error_occured')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('category_was_created'),
                        'select_category' => $this->CI->lang->line('support_select_a_parent')
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('category_was_not_created')
                    );

                    echo json_encode($data);                    
                    
                }
                
            }
            
        }

    }

    /**
     * The public method delete_category deletes a category
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function delete_category() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('category_id', 'Category ID', 'trim');

            // Get data
            $category_id = $this->CI->input->post('category_id');

            // Check form validation
            if ($this->CI->form_validation->run() !== false) {
                
                // Try to delete a category
                $delete_category = $this->CI->faq_model->delete_category($category_id);

                // Verifies if category was deleted
                if ($delete_category) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('category_was_deleted')
                    );

                    echo json_encode($data);

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('category_was_not_deleted')
                    );

                    echo json_encode($data);

                }
                
            }
            
        }

    }

}

/* End of file categories.php */
