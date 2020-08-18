<?php
/**
 * Faq Helper
 *
 * This file contains the class Faq
 * with methods to manage the Faq's articles and categories
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\User\Components\Collection\Faq\Helpers; 

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Faq class provides the methods to manage the Faq's articles and categories
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Faq {
    
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

    }

    /**
     * The public method load_faq_articles_by_search gets articles by search
     * 
     * @since 0.0.7.9
     * 
     * @return void
     */ 
    public function load_faq_articles_by_search() {
        
        // Check if data was submitted
        if ( $this->CI->input->post() ) {

            // Add form validation
            $this->CI->form_validation->set_rules('key', 'key', 'trim|required');
            
            // Get data
            $key = $this->CI->input->post('key');
            
            // Check form validation
            if ($this->CI->form_validation->run() !== false ) {
                
                $search = $this->CI->faq_model->get_faq_articles_by_search($key);
                
                if ( $search ) {
                    
                    $results = '';
                    
                    foreach ( $search as $article ) {
                        
                        $results .= '<li>'
                                        . '<a href="' . site_url('user/faq?p=articles&article=' . $article->article_id) . '">'
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
                        . $this->CI->lang->line('no_articles_found')
                    . '</li>';        
        
        $data = array(
            'success' => FALSE,
            'results' => $results
        );

        echo json_encode($data);
        
    }

}

/* End of file faq.php */