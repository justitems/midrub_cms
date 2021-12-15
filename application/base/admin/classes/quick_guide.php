<?php
/**
 * Base Admin Quick Guide
 *
 * This file contains the class Quick_guide
 * which processes the Admin's Quick Guide
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Admin\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Quick_guide class processes the Admin's Quick Guide
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
*/
class Quick_guide {

    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
    }
    
    /**
     * The public method get_quick_guide shows the admin's quick_guide
     * 
     * @param array $params contains the parameters
     *
     * @since 0.0.8.5
     * 
     * @return void
     */ 
    public function get_quick_guide( $params ) {

        // Display the guide
        echo '<div class="theme-quick-guide">'
            . '<div class="row">'
                . '<div class="col-12">'
                    . '<a href="#" class="theme-toggle-quick-guide">'
                        . md_the_admin_icon(array('icon' => 'chat'))
                        . md_the_admin_icon(array('icon' => 'close'))
                    . '</a>'
                . '</div>'
            . '</div>'
            . '<div class="row">'
                . '<div class="col-10">'
                    . '<h3 class="theme-quick-guide-header">'
                        . $this->CI->lang->line('theme_quick_guide')
                    . '</h3>'
                . '</div>'
                . '<div class="col-2 text-right">'
                    . '<a href="#" class="theme-quick-guide-go-back">'
                        . md_the_admin_icon(array('icon' => 'arrow_left_line'))
                    . '</a>'
                . '</div>'
            . '</div>'
            . '<div class="row">'
                . '<div class="col-12">'
                    . '<div class="theme-quick-guide-contents">'
                        . $this->CI->lang->line('theme_quick_guide')
                    . '</div>'
                . '</div>'
            . '</div>'            
            . '<script>'
                . 'let the_quick_guide_data = JSON.parse(JSON.stringify(' .  json_encode($params) . '));'
            . '</script>'                       
        . '</div>';
        
        
    }
    
}

/* End of file quick_guide.php */