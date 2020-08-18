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
namespace MidrubBase\Admin\Collection\Support\Helpers;

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
            $categories_html = '<ul class="list-group">';

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

                    $subcats .= '<ul class="list-group">';

                    foreach ($subcategories[$cat->category_id] as $subcat) {

                        $subcats .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                            . '<div class="row">'
                                . '<div class="col-lg-11">'
                                    . '<h3>'
                                        . $subcat->name
                                    . '</h3>'
                                . '</div>'
                                . '<div class="col-xs-1">'
                                    . '<a href="#" role="button" class="delete-category-single" data-id="' . $subcat->category_id . '">'
                                        . '<i class="icon-trash"></i>'
                                    . '</a>'
                                . '</div>'
                            . '</div>'
                        . '</li>';
                    }

                    $subcats .= '</ul>';
                }

                $categories_html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                    . '<div class="row">'
                        . '<div class="col-lg-11">'
                            . '<h3>'
                                . $cat->name
                            . '</h3>'
                        . '</div>'
                        . '<div class="col-xs-1">'
                            . '<a href="#" role="button" class="delete-category-single" data-id="' . $cat->category_id . '">'
                                . '<i class="icon-trash"></i>'
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
                'message' => $this->CI->lang->line('no_categories_found')
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
            $categories_html = '<ul class="list-group">';

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

                    $subcats .= '<ul class="list-group">';

                    foreach ($subcategories[$cat->category_id] as $subcat) {

                        $subcats .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                            . '<div class="row">'
                                . '<div class="col-lg-12">'
                                    . '<div class="checkbox-option-select">'
                                        . '<input id="faq-category-' . $subcat->category_id . '" name="faq-category-' . $subcat->category_id . '" type="checkbox" data-id="' . $subcat->category_id . '">'
                                        . '<label for="faq-category-' . $subcat->category_id . '"></label>'
                                    . '</div>'
                                    . $subcat->name
                                . '</div>'
                            . '</div>'
                        . '</li>';
    
                    }

                    $subcats .= '</ul>';
                
                }

                $categories_html .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                    . '<div class="row">'
                        . '<div class="col-lg-12">'
                            . '<div class="checkbox-option-select">'
                                . '<input id="faq-category-' . $cat->category_id . '" name="faq-category-' . $cat->category_id . '" type="checkbox" data-id="' . $cat->category_id . '">'
                                . '<label for="faq-category-' . $cat->category_id . '"></label>'
                            . '</div>'
                            . $cat->name
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
                'message' => $this->CI->lang->line('no_categories_found')
            );

            echo json_encode($data);

        }

    }

    /**
     * The public method load_all_parent_faq_categories loads all Parents Faq's Categories
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_all_parent_faq_categories() {

        // Get the Faq's Categories
        $categories = $this->CI->faq_model->get_categories();

        // Verify if Faq's Categories exists
        if ( $categories ) {

            // Parent categories
            $parent = array();

            // List all categories
            foreach ($categories as $category) {

                if ($category->parent < 1) {

                    $parent[] = $category;

                }

            }

            // Send categories
            $data = array(
                'success' => TRUE,
                'categories' => $parent
            );

            echo json_encode($data);

        } else {

            // Send no categories message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('no_categories_found')
            );

            echo json_encode($data);

        }

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
                    'message' => $this->CI->lang->line('an_error_occured')
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
                            'message' => $this->CI->lang->line('an_error_occured')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('category_was_created'),
                        'select_category' => $this->CI->lang->line('frontend_select_a_parent')
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
