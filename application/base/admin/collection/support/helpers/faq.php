<?php
/**
 * Faq Helper
 *
 * This file contains the class Faq
 * with methods to manage the Faq
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Admin\Collection\Support\Helpers;

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Faq class provides the methods to manage the Faq
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Faq
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
     * The public method load_all_faq_articles loads all Faq's Articles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_all_faq_articles() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|integer|required');

            // Get post data
            $key = $this->CI->input->post('key');
            $page = $this->CI->input->post('page');

            // Check form validation
            if ($this->CI->form_validation->run() === false ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_articles_found')
                );

                echo json_encode($data);

            } else {

                // Set the limit
                $limit = 20;
                $page--;
                
                // Get faq articles by page
                $faq_articles = $this->CI->faq_model->get_faq_articles( $key, $page * $limit, $limit );
                
                // Get total faq articles
                $total_faq_articles = $this->CI->faq_model->get_faq_articles($key);
                
                if ( $faq_articles ) {
                
                    // Display success message
                    $data = array(
                        'success' => TRUE,
                        'articles' => $faq_articles,
                        'total' => $total_faq_articles,
                        'page' => ($page + 1),
                        'words' => array(
                            'published' => $this->CI->lang->line('published'),
                            'draft' => $this->CI->lang->line('draft'),
                            'delete' => $this->CI->lang->line('delete')                       
                        )
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_articles_found')
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }

    }

    /**
     * The public method delete_faq_articles deletes Faq's Articles
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function delete_faq_articles() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('articles', 'Articles', 'trim');
            
            $articles = $this->CI->input->post('articles');

            if ( !$articles ) {
                    
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('please_select_one_article')
                );

                echo json_encode($data); 
                exit();
                
            }

            

            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                $count = 0;

                foreach ( $articles as $article ) {

                    if ( is_numeric($article) ) {

                        if ( $this->CI->faq_model->delete_article($article) ) {
                            $count++;
                        }

                    }

                }
                
                if ( $count > 0 ) {

                    $message = $this->CI->lang->line('article_was_deleted');
                    
                    if ( $count > 1 ) {
                        $message = $this->CI->lang->line('article_were_deleted');
                    }

                    $data = array(
                        'success' => TRUE,
                        'message' => $message
                    );

                    echo json_encode($data);                     
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('article_was_not_deleted')
                    );

                    echo json_encode($data); 
                    
                }
                
                exit();
                
            }
            
        }

    }

    /**
     * The public method create_new_faq_article create Faq's Article
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function create_new_faq_article() {

        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('cats', 'Cats', 'trim');
            $this->CI->form_validation->set_rules('article_id', 'Article ID', 'trim');
            $this->CI->form_validation->set_rules('status', 'Status', 'trim|integer|required');
            $languages = glob(APPPATH . 'language' . '/*' , GLOB_ONLYDIR);
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $this->CI->form_validation->set_rules($only_dir, ucfirst($only_dir), 'trim');
            }
            
            $cats = $this->CI->input->post('cats');
            $article_id = $this->CI->input->post('article_id');
            $status = $this->CI->input->post('status');
            $langs = array();
            foreach ( $languages as $language ) {
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);
                $langs[$only_dir] = $this->CI->input->post($only_dir);
                
                if ( !$langs[$only_dir]['title'] ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('article_title_is_required')
                    );

                    echo json_encode($data);
                    exit();
                
                }
                
            }

            // Check form validation
            if ($this->CI->form_validation->run() === false || !$langs || $status < 0 || $status > 1 ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('an_error_occured')
                );

                echo json_encode($data);

            } else {

                // Verify if article should be updated
                if ($article_id) {

                    // Verify if faq article exists
                    if ( !$this->CI->faq_model->get_faq_article($article_id) ) {

                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('article_not_found')
                        );

                        echo json_encode($data);
                        exit();

                    }

                    $langs = array();
                    foreach ( $languages as $language ) {

                        $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                        $langs[$only_dir] = $this->CI->input->post($only_dir);
                        
                        if ( !$langs[$only_dir]['title'] ) {
                            
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('article_title_is_required')
                            );
        
                            echo json_encode($data);
                            exit();
                        
                        }
                        
                    }
                    
                    // Delete the article's meta
                    if ( !$this->CI->faq_model->delete_article_meta($article_id) ) {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('article_was_not_updated')
                        );
        
                        echo json_encode($data);
                        exit();
                        
                    }            
        
                    // Check form validation
                    if ($this->CI->form_validation->run() === false || !$langs || $status < 0 || $status > 1 ) {
        
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('an_error_occured')
                        );
        
                        echo json_encode($data);
        
                    } else {
                        
                        if ( $article_id ) {
                            
                            $c = 0;
                            
                            foreach ( $langs as $key => $value ) {
                                
                                if ( $this->CI->faq_model->save_article_meta($article_id, $value['title'], $value['body'], $key) ) {
                                    $c++;
                                }
                                
                            }
                            
                            if ( $c > 0 ) {
        
                                if ($cats) {
                                    
                                    foreach ( $cats as $key => $value ) {
                                        $this->CI->faq_model->save_article_category($article_id, $value);
                                    }
                                    
                                }
                                
                                $data = array(
                                    'success' => TRUE,
                                    'message' => $this->CI->lang->line('article_was_updated')
                                );
        
                                echo json_encode($data);                         
                                
                            } else {
                            
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('article_was_not_updated')
                                );
        
                                echo json_encode($data);                    
        
                            }
                            
                        }
                        
                    }

                } else {

                    $article_id = $this->CI->faq_model->save_article($this->CI->user_id, $status);

                    if ($article_id) {

                        $c = 0;

                        foreach ($langs as $key => $value) {

                            if ($this->CI->faq_model->save_article_meta($article_id, $value['title'], $value['body'], $key)) {
                                $c++;
                            }
                        }

                        if ($c > 0) {

                            if ($cats) {

                                foreach ($cats as $key => $value) {
                                    $this->CI->faq_model->save_article_category($article_id, $value);
                                }
                            }

                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('article_was_created'),
                                'article_id' => $article_id
                            );

                            echo json_encode($data);
                        } else {

                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('article_was_not_created')
                            );

                            echo json_encode($data);

                        }

                    }

                }
                
            }
            
        }

    }

}

/* End of file faq.php */
