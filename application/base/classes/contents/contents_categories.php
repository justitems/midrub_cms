<?php
/**
 * Contents Categories Class
 *
 * This file loads the Contents_categories Class with properties used to displays contents categories in the admin panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

// Define the page namespace
namespace MidrubBase\Classes\Contents;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Contents_categories class loads the general properties used to displays contents categories in the admin panel
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */
class Contents_categories {
    
    /**
     * Contains and array with saved categories
     *
     * @since 0.0.7.8
     */
    public static $the_contents_categories = array(); 

    /**
     * Contains and array with saved categories meta
     *
     * @since 0.0.7.8
     */
    public static $the_contents_categories_meta = array();     

    /**
     * Contains and array with saved admin contents meta fields
     *
     * @since 0.0.7.8
     */
    public static $the_contents_meta_fields = array();

    /**
     * Contains and array with saved categories options
     *
     * @since 0.0.7.8
     */
    public static $the_contents_categories_options = array(); 

    /**
     * Contains and array with saved admin contents option fields
     *
     * @since 0.0.7.8
     */
    public static $the_contents_options_fields = array();    

    /**
     * The public method set_contents_category adds contents categories
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_contents_category($category_slug, $args) {

        // Verify if the contents category has valid fields
        if ( $category_slug && isset($args['category_name']) && isset($args['category_icon']) ) {

            self::$the_contents_categories[][$category_slug] = $args;
            
        }

    } 

    /**
     * The public method load_contents_categories loads all contents categories
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents categories or boolean false
     */
    public function load_contents_categories() {

        // Verify if contents categories exists
        if ( self::$the_contents_categories ) {

            return self::$the_contents_categories;

        } else {

            return false;

        }

    }     

    /**
     * The public method set_contents_category_meta adds contents category meta
     * 
     * @param string $category_slug contains the categorys slug
     * @param array $args contains the contents category meta arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_contents_category_meta($category_slug, $args) {

        // Verify if the contents category has valid fields
        if ( $category_slug && isset($args['name']) ) {

            // Verify if already a meta with same category slug exists
            if ( !isset(self::$the_contents_categories_meta[$category_slug]) ) {
                self::$the_contents_categories_meta[$category_slug] = array();
            }

            self::$the_contents_categories_meta[$category_slug][] = $args;
            
        }

    }    
    
    /**
     * The public method load_contents_categories_metas loads all contents category metas by contents category slug
     * 
     * @param string $category_slug contains the category's slug
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents category metas or boolean false
     */
    public function load_contents_categories_metas($category_slug) {

        // Verify if contents categories meta exists
        if ( isset(self::$the_contents_categories_meta[$category_slug]) ) {

            return self::$the_contents_categories_meta[$category_slug];

        } else {

            return false;

        }

    }

    /**
     * The public method set_contents_meta_fields adds admin contents meta fields in the queue
     * 
     * @param string $meta_name contains the meta's name
     * @param string $meta_slug contains the meta's slug
     * @param array $args contains the admin contents meta fields
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_contents_meta_fields($meta_name, $meta_slug, $args) {
        
        // Save meta fields
        self::$the_contents_meta_fields[] = array(
            'meta_name' => $meta_name,
            'meta_slug' => $meta_slug,
            'fields' => $args
        );

    } 

    /**
     * The public method set_contents_category_option adds contents category option
     * 
     * @param string $category_slug contains the categorys slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_contents_category_option($category_slug, $args) {

        // Verify if the contents category option has valid fields
        if ( $category_slug && isset($args['name']) ) {

            // Verify if already an option with same category slug exists
            if ( !isset(self::$the_contents_categories_options[$category_slug]) ) {
                self::$the_contents_categories_options[$category_slug] = array();
            }

            self::$the_contents_categories_options[$category_slug][] = $args;
            
        }

    }
    
    /**
     * The public method load_contents_categories_options loads all contents category options by contents category slug
     * 
     * @param string $category_slug contains the category's slug
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents category options or boolean false
     */
    public function load_contents_categories_options($category_slug) {

        // Verify if contents categories options exists
        if ( isset(self::$the_contents_categories_options[$category_slug]) ) {

            return self::$the_contents_categories_options[$category_slug];

        } else {

            return false;

        }

    }

    /**
     * The public method set_contents_option_fields adds admin contents option's fields in the queue
     * 
     * @param string $option_name contains the option's name
     * @param string $option_slug contains the option's slug
     * @param array $args contains the admin contents option's fields
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    public function set_contents_option_fields($option_name, $option_slug, $args) {
        
        // Save meta fields
        self::$the_contents_options_fields[] = array(
            'option_name' => $option_name,
            'option_slug' => $option_slug,
            'fields' => $args
        );

    }

}
