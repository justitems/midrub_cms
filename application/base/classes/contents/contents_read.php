<?php
/**
 * Contents Read Class
 *
 * This file loads the Contents_read Class with properties used to set and read content
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes\Contents;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Contents_read class loads the properties used to set and read content
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Contents_read {
    
    /**
     * Contains the object with content
     *
     * @since 0.0.7.8
     */
    public static $the_single_content;

    /**
     * The public method set_single_content set content
     * 
     * @param object $content contains the content's data
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_single_content($content) {

        $metas = array();

        foreach ( $content as $meta ) {

            $metas[$meta['language']][$meta['meta_name']] = $meta['meta_value']; 

        }

        self::$the_single_content = $content;

    } 

}
