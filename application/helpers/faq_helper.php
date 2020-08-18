<?php
/**
 * Faq helper
 *
 * This file contains the methods
 * for Ajax Faq methods
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_category_meta')) {
    
    /**
     * The function get_category_meta gets category's meta
     * 
     * @param integer $category_id contains the category's id
     * @param string $language contains the category's language
     * 
     * @since 0.0.7.5
     * 
     * @return string with category
     */
    function get_category_meta($category_id, $language) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Faq Model
        $CI->load->model( 'faq' );

        $category = $CI->faq->get_category_meta($category_id, $language);
        
        if ( $category ) {
            
            return $category[0]->name;
            
        } else {
            
            return ' ';
            
        }
        
    }
    
}

if (!function_exists('load_all_faq_articles')) {
    
    /**
     * The function load_all_faq_articles gets all faq articles
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function load_all_faq_articles() {

        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('type', 'Type', 'trim');
            $CI->form_validation->set_rules('page', 'Page', 'trim|integer|required');
            
            $type = $CI->input->post('type');
            $page = $CI->input->post('page');

            // Check form validation
            if ($CI->form_validation->run() === false ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('no_articles_found'),
                    'type' => $type
                );

                echo json_encode($data);

            } else {

                // Set the limit
                $limit = 10;
                $page--;
                
                // Get faq articles by page
                $faq_articles = $CI->faq->get_faq_articles( $type, $page * $limit, $limit );
                
                // Get total faq articles
                $total_faq_articles = $CI->faq->get_faq_articles( $type );
                
                if ( $faq_articles ) {
                
                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'articles' => $faq_articles,
                        'total' => $total_faq_articles,
                        'page' => ($page + 1),
                        'published' => $CI->lang->line('published'),
                        'draft' => $CI->lang->line('draft'),
                        'type' => $type
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('no_articles_found'),
                        'type' => $type
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('load_tickets')) {
    
    /**
     * The function load_tickets gets ickets
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function load_tickets() {

        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('type', 'Type', 'trim');
            $CI->form_validation->set_rules('page', 'Page', 'trim|integer|required');
            
            $type = $CI->input->post('type');
            $page = $CI->input->post('page');

            // Check form validation
            if ($CI->form_validation->run() === false ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('no_tickets_found'),
                    'type' => $type
                );

                echo json_encode($data);

            } else {

                // Set the limit
                $limit = 10;
                $page--;
                
                // Get tickets by page
                $tickets = $CI->tickets->get_all_tickets( $type, 0, $page * $limit, $limit );
                
                // Get total tickets
                $total_tickets = $CI->tickets->get_all_tickets( $type );
                
                if ( $tickets ) {
                
                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'tickets' => $tickets,
                        'total' => $total_tickets,
                        'page' => ($page + 1),
                        'answered' => strtolower($CI->lang->line('answered')),
                        'unanswered' => strtolower($CI->lang->line('unanswered')),
                        'closed' => strtolower($CI->lang->line('closed')),
                        'type' => $type
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('no_tickets_found'),
                        'type' => $type
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('create_category')) {
    
    /**
     * The function create_category creates a new category
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function create_category() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('parent', 'Parent', 'trim|required');
            
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');
            }
            
            $langs = array();
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $langs[$only_dir] = $CI->input->post($only_dir);
            }

            // Get data
            $parent = $CI->input->post('parent');

            // Check form validation
            if ($CI->form_validation->run() === false || !$langs ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);

            } else {

                $category_id = $CI->faq->save_category($parent);
                
                if ( $category_id ) {
                    
                    $c = 0;
                    foreach ( $langs as $key => $value ) {
                        if ( $CI->faq->save_category_meta($category_id, $value, $key) ) {
                            $c++;
                        }
                    }
                    
                    if ( !$c ) {
                        
                        // If meta wasn't saved will be deleted the category
                        $CI->faq->delete_category($category_id);
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('mm3')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }
                    
                    // Get all categories
                    $categories = $CI->faq->get_categories();
                    
                    $all_categories = '';
                    
                    $all_categories .= '<ul class="list-group">';

                    $subcategories = array();

                    foreach ($categories as $category) {

                        if ( $category->parent > 0 ) {

                            $subcategories[$category->parent][] = $category;

                        }

                    }

                    foreach ($categories as $cat) {
                        
                        if ( $cat->parent > 0 ) {
                            continue;
                        }

                        $subcats = '';

                        if ( isset($subcategories[$cat->category_id]) ) {

                            $subcats = '<ul class="list-group">';

                            foreach ( $subcategories[$cat->category_id] as $subcat ) {

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

                        $all_categories .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
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

                    $all_categories .= '</ul>';

                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line('category_was_created'),
                        'categories' => $all_categories,
                        'categories_list' => $categories,
                        'select_category' => $CI->lang->line('select_category')
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('category_was_not_created')
                    );

                    echo json_encode($data);                    
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('create_new_faq_article')) {
    
    /**
     * The function create_new_faq_article creates a new faq article
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function create_new_faq_article() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('cats', 'Cats', 'trim');
            $CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');
            }
            
            $cats = $CI->input->post('cats');
            $status = $CI->input->post('status');
            $langs = array();
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $langs[$only_dir] = $CI->input->post($only_dir);
                
                if ( !$langs[$only_dir]['title'] ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('article_title_is_required')
                    );

                    echo json_encode($data);
                    exit();
                
                }
                
            }

            // Check form validation
            if ($CI->form_validation->run() === false || !$langs || $status < 0 || $status > 1 ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);

            } else {
                
                $article_id = $CI->faq->save_article($CI->user_id, $status);
                
                if ( $article_id ) {
                    
                    $c = 0;
                    
                    foreach ( $langs as $key => $value ) {
                        
                        if ( $CI->faq->save_article_meta($article_id, $value['title'], $value['body'], $key) ) {
                            $c++;
                        }
                        
                    }
                    
                    if ( $c > 0 ) {

                        if ($cats) {
                            
                            foreach ( $cats as $key => $value ) {
                                $CI->faq->save_article_category($article_id, $value);
                            }
                            
                        }
                        
                        $data = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('article_was_created')
                        );

                        echo json_encode($data);                         
                        
                    } else {
                    
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('article_was_not_created')
                        );

                        echo json_encode($data);                    

                    }
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('update_faq_article')) {
    
    /**
     * The function update_faq_article creates a new faq article
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function update_faq_article() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('cats', 'Cats', 'trim');
            $CI->form_validation->set_rules('article_id', 'Article ID', 'trim|integer|required');
            $CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');
            }
            
            $cats = $CI->input->post('cats');
            $article_id = $CI->input->post('article_id');
            $status = $CI->input->post('status');
            
            // Verify if faq article exists
            if ( !$CI->faq->get_faq_article($article_id) ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('article_not_found')
                );

                echo json_encode($data);
                exit();
                
            }
            
            $langs = array();
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $langs[$only_dir] = $CI->input->post($only_dir);
                
                if ( !$langs[$only_dir]['title'] ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('article_title_is_required')
                    );

                    echo json_encode($data);
                    exit();
                
                }
                
            }
            
            // Delete the article's meta
            if ( !$CI->faq->delete_article_meta($article_id) ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('article_was_not_updated')
                );

                echo json_encode($data);
                exit();
                
            }            

            // Check form validation
            if ($CI->form_validation->run() === false || !$langs || $status < 0 || $status > 1 ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);

            } else {
                
                if ( $article_id ) {
                    
                    $c = 0;
                    
                    foreach ( $langs as $key => $value ) {
                        
                        if ( $CI->faq->save_article_meta($article_id, $value['title'], $value['body'], $key) ) {
                            $c++;
                        }
                        
                    }
                    
                    if ( $c > 0 ) {

                        if ($cats) {
                            
                            foreach ( $cats as $key => $value ) {
                                $CI->faq->save_article_category($article_id, $value);
                            }
                            
                        }
                        
                        $data = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('article_was_updated')
                        );

                        echo json_encode($data);                         
                        
                    } else {
                    
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('article_was_not_updated')
                        );

                        echo json_encode($data);                    

                    }
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('delete_categories')) {
    
    /**
     * The function delete_categories deletes categories
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function delete_categories() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('categories', 'Categories', 'trim');

            // Get data
            $categories = $CI->input->post('categories');

            // Check form validation
            if ($CI->form_validation->run() !== false) {
                
                if ( count($categories) ) {
                    
                    $count = 0;

                    foreach ( $categories as $category ) {
                        
                        if ( @is_numeric($category[1]) ) {

                            if ( $CI->faq->delete_category($category[1]) ) {
                                $count++;
                            }
                            
                        }

                    }
                    
                    if ( $count ) {
                        
                        // Get all categories
                        $categories = $CI->faq->get_categories();
                        
                        if ( $categories ) {

                            $all_categories = '';

                            $all_categories .= '<ul class="list-group">';

                            $subcategories = array();

                            foreach ($categories as $category) {

                                if ( $category->parent > 0 ) {

                                    $subcategories[$category->parent][] = $category;

                                }

                            }

                            foreach ($categories as $cat) {

                                if ( $cat->parent > 0 ) {
                                    continue;
                                }

                                $subcats = '';

                                if ( isset($subcategories[$cat->category_id]) ) {

                                    $subcats = '<ul class="list-group">';

                                    foreach ( $subcategories[$cat->category_id] as $subcat ) {

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

                                $all_categories .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
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

                            $all_categories .= '</ul>';

                            $data = array(
                                'success' => TRUE,
                                'message' => $CI->lang->line('category_was_deleted'),
                                'categories' => $all_categories,
                                'categories_list' => $categories,
                                'select_category' => $CI->lang->line('select_category')
                            );

                            echo json_encode($data); 
                            exit();
                            
                        } else {
                            
                            $data = array(
                                'success' => TRUE,
                                'message' => $CI->lang->line('category_was_deleted'),
                                'categories' => '<p>' . $CI->lang->line('no_categories_found') . '</p>',
                                'select_category' => $CI->lang->line('select_category')
                            );

                            echo json_encode($data); 
                            exit();                            
                            
                        }
                        
                    } else {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('category_was_not_deleted')
                        );

                        echo json_encode($data); 
                        exit();
                        
                    }
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('mm3')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('delete_faq_articles')) {
    
    /**
     * The function delete_faq_articles deletes faq articles
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function delete_faq_articles() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('articles', 'Articles', 'trim');
            
            $articles = $CI->input->post('articles');

            if ( !$articles ) {
                    
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('please_select_one_article')
                );

                echo json_encode($data); 
                exit();
                
            }

            

            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                $count = 0;

                foreach ( $articles as $article ) {

                    if ( is_numeric($article) ) {

                        if ( $CI->faq->delete_article($article) ) {
                            $count++;
                        }

                    }

                }
                
                if ( $count > 0 ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line('article_was_deleted')
                    );

                    echo json_encode($data);                     
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('article_was_not_deleted')
                    );

                    echo json_encode($data); 
                    
                }
                
                exit();
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('mm3')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('mark_as_important')) {
    
    /**
     * The function mark_as_important marks tickets as important
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function mark_as_important() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('tickets', 'Tickets', 'trim');
            
            $tickets = $CI->input->post('tickets');

            if ( !$tickets ) {
                    
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('please_select_one_ticket')
                );

                echo json_encode($data); 
                exit();
                
            }

            

            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                $count = 0;

                foreach ( $tickets as $ticket ) {

                    if ( is_numeric($ticket) ) {

                        if ( $CI->tickets->ticket_update($ticket, 'important', 1) ) {
                            $count++;
                        }

                    }

                }
                
                if ( $count > 0 ) {
                    
                    $data = array(
                        'success' => TRUE
                    );

                    echo json_encode($data);  
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('mm3')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('remove_important_mark')) {
    
    /**
     * The function remove_important_mark removes important mark
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function remove_important_mark() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('tickets', 'Tickets', 'trim');
            
            $tickets = $CI->input->post('tickets');

            if ( !$tickets ) {
                    
                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('please_select_one_ticket')
                );

                echo json_encode($data); 
                exit();
                
            }

            

            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                $count = 0;

                foreach ( $tickets as $ticket ) {

                    if ( is_numeric($ticket) ) {

                        if ( $CI->tickets->ticket_update($ticket, 'important', 0) ) {
                            $count++;
                        }

                    }

                }
                
                if ( $count > 0 ) {
                    
                    $data = array(
                        'success' => TRUE
                    );

                    echo json_encode($data);  
                    exit();
                    
                }
                
            }
            
        }
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('mm3')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('load_faq_articles_by_search')) {
    
    /**
     * The function load_faq_articles_by_search gets articles by search
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function load_faq_articles_by_search() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 0 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Faq Model
        $CI->load->model( 'faq' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('key', 'key', 'trim|required');
            
            // Get data
            $key = $CI->input->post('key');
            
            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                $search = $CI->faq->get_faq_articles_by_search($key);
                
                if ( $search ) {
                    
                    $results = '';
                    
                    foreach ( $search as $article ) {
                        
                        $results .= '<li>'
                                        . '<a href="' . site_url('user/faq-article/' . $article->article_id) . '">'
                                            . '<i class="far fa-file-alt"></i> ' . $article->title
                                        . '</a>'
                                    . '</li>';
                        
                    }
                    
                    $data = array(
                        'success' => TRUE,
                        'results' => $results
                    );

                    echo json_encode($data);
                    exit();
                    
                }
                
            }
            
        }
        
        $results = '<li>'
                        . $CI->lang->line('no_articles_found')
                    . '</li>';        
        
        $data = array(
            'success' => FALSE,
            'results' => $results
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('create_new_ticket')) {
    
    /**
     * The function create_new_ticket creates a new ticket
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function create_new_ticket() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Verify if the user is admin
        if ( $CI->user_role != 0 ) {
            exit();
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $CI->form_validation->set_rules('body', 'Body', 'trim');
            
            // Get data
            $subject = $CI->input->post('subject');
            $body = $CI->input->post('body');
            
            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                // Verify when was saved the last ticket
                $last_ticket = $CI->tickets->last_ticket($CI->user_id);
                
                if ( $last_ticket ) {
                    
                    $limit = 24;
                    // Verify if admin had changed the default limit
                    $verify = get_option('tickets_limit');
                    
                    if($verify) {
                        
                        $limit = $verify;
                        
                    }
                    
                    if ( ($last_ticket + $limit * 3600) > time() ) {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('you_can_open_one_ticket') . ' ' . $limit . ' ' . $CI->lang->line('mm107')
                        );

                        echo json_encode($data);
                        exit();
                        
                    }
                    
                }
                
                // Verify if tickets are enabled
                if ( get_option('disable-tickets') ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('creation_new_tickets_restricted')
                    );

                    echo json_encode($data);
                    exit();
                    
                }
                
                $create = $CI->tickets->save_ticket($CI->user_id, $subject, $body);
                
                if ( $create ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line('ticket_was_created'),
                        'ticket_id' => $create
                    );

                    echo json_encode($data);
                    exit();
                    
                }
                
            }
            
        }    
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('ticket_was_not_created')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('create_ticket_reply')) {
    
    /**
     * The function create_ticket_reply creates a ticket's reply
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function create_ticket_reply() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('body', 'Body', 'trim|required');
            $CI->form_validation->set_rules('ticket_id', 'Ticket ID', 'trim|integer|required');
            
            // Get data
            $body = $CI->input->post('body');
            $ticket_id = $CI->input->post('ticket_id');
            
            // Check form validation
            if ($CI->form_validation->run() !== false ) {
                
                // Verify if the user is admin
                if ( $CI->user_role != 1 ) {
                
                    $get_ticket = $CI->tickets->get_ticket($CI->user_id, $ticket_id);
                    
                } else {
                    
                    $get_ticket = $CI->tickets->get_ticket(0, $ticket_id);
                    
                }
                
                // Verify if user is the creator of this ticket
                if ( $get_ticket ) {
                    
                    // Verify if the user is admin
                    if ( $CI->user_role != 1 ) {
                    
                        if ( (int)$get_ticket[0]->status < 1 ) {

                            $data = array(
                                'success' => FALSE,
                                'message' => $CI->lang->line('ticket_is_closed')
                            );

                            echo json_encode($data);
                            exit();

                        }
                        
                    }
                
                    // Verify if the user is admin
                    if ( $CI->user_role != 1 ) {

                        // Save new ticket's reply
                        $create = $CI->tickets->save_reply($CI->user_id, $ticket_id, $body);

                    } else {

                        // Save new ticket's reply
                        $create = $CI->tickets->save_reply(0, $ticket_id, $body);

                    }

                    // Verify if the ticket's reply was saved 
                    if ( $create ) {
                        
                        // Verify if the user is admin
                        if ( $CI->user_role != 1 ) {

                            $CI->tickets->ticket_update($ticket_id, 'status', 1);  

                        } else {

                            $CI->tickets->ticket_update($ticket_id, 'status', 2);  

                        }                        

                        $data = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('reply_was_saved')
                        );

                        echo json_encode($data);
                        exit();

                    }
                
                }
                
            }
            
        }    
        
        $data = array(
            'success' => FALSE,
            'message' => $CI->lang->line('reply_was_not_saved')
        );

        echo json_encode($data);
        
    }
    
}

if (!function_exists('load_ticket_replies')) {
    
    /**
     * The function load_ticket_replies returns all ticket's replies
     * 
     * @return void
     */
    function load_ticket_replies() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Get ticket_id's input
        $ticket_id = $CI->input->get('ticket_id');        
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
        
            // Verify if user is the creator of this ticket
            if ( !$CI->tickets->get_ticket($CI->user_id, $ticket_id) ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('no_replies_found')
                );

                echo json_encode($data);  
                exit();

            }
            
        }
        
        // Gets ticket's replies
        $replies = $CI->tickets->get_metas($ticket_id);   
        
        if ( $replies ) {
            
            $data = array(
                'success' => TRUE,
                'content' => $replies,
                'cdate' => time()
            );

            echo json_encode($data);            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line('no_replies_found')
            );

            echo json_encode($data);             
            
        }
        
    }
    
}

if (!function_exists('set_ticket_status')) {
    
    /**
     * The function set_ticket_status changes the ticket's status
     * 
     * @return void
     */
    function set_ticket_status() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Get ticket_id's input
        $ticket_id = $CI->input->get('ticket_id');  
        
        // Get status's input
        $status = (int)$CI->input->get('status');          
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tickets_lang.php' ) ) {
            $CI->lang->load( 'default_tickets', $CI->config->item('language') );
        }
        
        // Load Tickets Model
        $CI->load->model( 'tickets' );
        
        // Verify if the user is admin
        if ( $CI->user_role != 1 ) {
        
            // Verify if user is the creator of this ticket
            if ( !$CI->tickets->get_ticket($CI->user_id, $ticket_id) ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);  
                exit();

            }
        
        }
        
        // Verify if status is valid
        if ( ($status !== 1) && ($status !== 0) ) {
            
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line('mm3')
            );

            echo json_encode($data);  
            exit();

        }        
        
        // Change the ticket's status
        $response = $CI->tickets->ticket_update($ticket_id, 'status', $status);        
        
        if ( $response ) {
            
            if ( $status === 1 ) {
                
                $new_status = $CI->lang->line('active');
                
            } else {
                
                $new_status = $CI->lang->line('closed');
                
            }
            
            $data = array(
                'success' => TRUE,
                'message' => $CI->lang->line('ticket_status_was_changed'),
                'status' => $new_status
            );

            echo json_encode($data);            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line('ticket_status_was_not_changed')
            );

            echo json_encode($data);             
            
        }
        
    }
    
}