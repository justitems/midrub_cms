<?php
/**
 * Contents Categories Inc
 *
 * This file contains the contents categories functions
 * used in the Midrub's frontend
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.8
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubBase\Classes\Contents as MidrubBaseClassesContents;

if ( !function_exists('md_set_contents_category') ) {
    
    /**
     * The function md_set_contents_category adds contents categories
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_contents_category($category_slug, $args) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Set contents category in the queue
        $contents_categories->set_contents_category($category_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_contents_categories') ) {
    
    /**
     * The function md_the_contents_categories gets the contents categories
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents categories or boolean false
     */
    function md_the_contents_categories() {
        
        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Return contents categories
        return $contents_categories->load_contents_categories();
        
    }
    
}

if ( !function_exists('md_set_contents_category_meta') ) {
    
    /**
     * The function md_set_contents_category_meta adds contents category meta
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_contents_category_meta($category_slug, $args) {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if meta has a template
        if ( isset($args["template"]) ) {

            // Verify if template doesn't meet the query template
            if ( $CI->input->get('template', true) === $args["template"] ) {

                // Call the contents_categories class
                $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

                // Set contents category meta in the queue
                $contents_categories->set_contents_category_meta($category_slug, $args);
                
            }

        } else {

            // Call the contents_categories class
            $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

            // Set contents category meta in the queue
            $contents_categories->set_contents_category_meta($category_slug, $args);

        }
        
    }
    
}

if ( !function_exists('md_the_contents_categories_metas') ) {
    
    /**
     * The function md_the_contents_categories_metas gets contents category's metas
     * 
     * @param string $category_slug contains the category's slug
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents category metas or boolean false
     */
    function md_the_contents_categories_metas($category_slug) {
        
        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Return contents category metas
        return $contents_categories->load_contents_categories_metas($category_slug);
        
    }
    
}

if ( !function_exists('md_set_contents_meta_fields') ) {
    
    /**
     * The function md_set_contents_meta_fields adds admin contents meta fields in the queue
     * 
     * @param string $meta_name contains the meta's name
     * @param string $meta_slug contains the meta's slug
     * @param array $args contains the admin contents meta fields
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_contents_meta_fields($meta_name, $meta_slug, $args) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Adds contents category meta fields in the queue
        $contents_categories->set_contents_meta_fields($meta_name, $meta_slug, $args);
        
    }
    
}

if ( !function_exists('md_set_contents_meta_field') ) {
    
    /**
     * The function md_set_contents_meta_field sets contents meta field
     * 
     * @param string $method contains the method's name
     * @param function $function contains the function
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    function md_set_contents_meta_field($method, $function) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Admin_contents_meta_templates);

        // Set the method
        $contents_categories->$method = $function;
        
    }
    
}

if ( !function_exists('md_get_all_contents_categories_metas') ) {
    
    /**
     * The function md_get_all_contents_categories_metas generates contents categories metas
     * 
     * @param string $language contains the language
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_all_contents_categories_metas($language) {

        // Get codeigniter object instance
        $CI = &get_instance();
        
        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Verify if meta's fields exists
        if ( $contents_categories::$the_contents_meta_fields ) {

            // Lista all meta's fields
            foreach ( $contents_categories::$the_contents_meta_fields as $fields ) {

                $content = '<div class="row">'
                                . '<div class="col-lg-12">'
                                    . '<div class="panel panel-default contents-meta-area">'
                                        . '<div class="panel-heading">'
                                            . $fields['meta_name']
                                        . '</div>'
                                        . '<div class="panel-body">';

                // Verify if meta has fields
                if ( $fields['fields'] ) {

                    // List all fields
                    foreach ( $fields['fields'] as $field ) {
                        
                        if ( $field['type'] === 'list_items' ) {

                            // Set HTML content
                            $content .=  '<div class="form-group list-area" data-slug="' . $field['slug'] . '">'
                                    . '<div class="row">'
                                        . '<div class="col-lg-12">'
                                            . '<div class="panel panel-default">'
                                                . '<div class="panel-heading">'
                                                    . '<div class="row">'
                                                        . '<div class="col-lg-8 col-xs-6">'
                                                            . '<h3>'
                                                                . $field['label']
                                                            . '</h3>'
                                                        . '</div>'
                                                        . '<div class="col-lg-4 col-xs-6 text-right">'
                                                            . '<a href="#" class="btn-option btn-new-list-item" data-type="list_item_' . str_replace('-', '_', $field['slug']) . '">'
                                                                . $field['words']['new_item_text']
                                                            . '</a>'
                                                        . '</div>'
                                                    . '</div>'
                                                . '</div>'
                                                . '<div class="panel-body">';

                            $fields_data = array();

                            if ( isset($field['fields']) ) {

                                $item_fields = array(); 

                                foreach ( $field['fields'] as $nfield ) {

                                    try {

                                        $fields_data[$nfield['slug']] = $nfield;

                                        $method = $nfield['type'];

                                        $nfield['meta_slug'] = $fields['meta_slug'];

                                        $item_fields[] = (new MidrubBaseClassesContents\Admin_contents_meta_templates)->$method($nfield, $language);
            
                                    } catch(Exception $e) {
            
                                        continue;
            
                                    }

                                }

                                $item_fields[] = '<div class="form-group clean">'
                                    . '<a href="#" class="delete-item">'
                                        . $CI->lang->line('frontend_delete')
                                    . '</a>'
                                . '</div>';

                                if ( $item_fields ) {

                                    $content .= '<script language="javascript">'
                                            . 'var list_item_' . str_replace('-', '_', $field['slug']) . ' = ' . json_encode($item_fields)
                                        . '</script>';

                                }

                            }

                            $content .= '<ul class="list-items-ul">'; 
                            
                            // Get input's value
                            $get_value = md_the_single_content_meta($field['slug'], $language);

                            if ( $get_value ) {

                                if ($fields_data) {

                                    $values = unserialize($get_value);
                                    
                                    $content .= '<li>';

                                    $a = 0;

                                    foreach ($values as $meta) {

                                        if ( count($fields_data) <= $a ) {
                                            $a = 0;
                                            $content .= '</li><li>';
                                        }

                                        try {
                                            
                                            $method = $fields_data[$meta['meta']]['type'];

                                            $fields_data[$meta['meta']]['meta_slug'] = $fields_data[$meta['meta']]['slug'];

                                            if ( $meta['value'] ) {
                                                $fields_data[$meta['meta']]['value'] = $meta['value'];
                                            }

                                            $content .= (new MidrubBaseClassesContents\Admin_contents_meta_templates)->$method($fields_data[$meta['meta']], $language);
                
                                        } catch(Exception $e) {
                
                                            continue;
                
                                        }

                                        $a++;

                                        if ( count($fields_data) === $a ) {

                                            $content .= '<div class="form-group clean">'
                                                    . '<a href="#" class="delete-item">'
                                                        . $CI->lang->line('frontend_delete')
                                                    . '</a>'
                                                . '</div>';

                                        }

                                    }
                                    
                                    $content .= '</li>';

                                }

                            }

                            $content .= '</ul>';

                            $content .= '</div>'
                                            . '</div>'
                                        . '</div>'
                                    . '</div>'
                                . '</div>';

                        } else {

                            try {
                                            
                                // Set the method
                                $method = $field['type'];

                                // Add meta's slug
                                $field['meta_slug'] = $fields['meta_slug'];

                                // Set HTML content
                                $content .= (new MidrubBaseClassesContents\Admin_contents_meta_templates)->$method($field, $language);
    
                            } catch(Exception $e) {
    
                                continue;
    
                            }

                        }

                    }

                }

                $content .= '</div>'
                    . '</div>'
                    . '</div>'
                . '</div>';
                

                echo $content;
            }

        }
        
    }
    
}

if ( !function_exists('md_set_contents_category_option') ) {
    
    /**
     * The function md_set_contents_category_option adds contents category option
     * 
     * @param string $category_slug contains the category's slug
     * @param array $args contains the contents category arguments
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_contents_category_option($category_slug, $args) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Set contents category option in the queue
        $contents_categories->set_contents_category_option($category_slug, $args);
        
    }
    
}

if ( !function_exists('md_the_contents_categories_options') ) {
    
    /**
     * The function md_the_contents_categories_options gets contents category's options
     * 
     * @param string $category_slug contains the category's slug
     * 
     * @since 0.0.7.8
     * 
     * @return array with contents category options or boolean false
     */
    function md_the_contents_categories_options($category_slug) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Return contents category options
        return $contents_categories->load_contents_categories_options($category_slug);
        
    }
    
}

if ( !function_exists('md_set_contents_option_fields') ) {
    
    /**
     * The function md_set_contents_option_fields adds admin contents option's fields in the queue
     * 
     * @param string $option_name contains the option's name
     * @param string $option_slug contains the option's slug
     * @param array $args contains the admin contents option's fields
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_set_contents_option_fields($option_name, $option_slug, $args) {

        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Adds contents category option fields in the queue
        $contents_categories->set_contents_option_fields($option_name, $option_slug, $args);
        
    }
    
}

if ( !function_exists('md_get_all_contents_categories_options') ) {
    
    /**
     * The function md_get_all_contents_categories_options generates contents categories options
     * 
     * @since 0.0.7.8
     * 
     * @return void
     */
    function md_get_all_contents_categories_options() {
        
        // Call the contents_categories class
        $contents_categories = (new MidrubBaseClassesContents\Contents_categories);

        // Verify if options fields exists
        if ( $contents_categories::$the_contents_options_fields ) {

            // Lista all options fields
            foreach ( $contents_categories::$the_contents_options_fields as $fields ) {

                $content = '<div class="row">'
                                . '<div class="col-lg-12">'
                                    . '<div class="panel panel-default contents-option-area">'
                                        . '<div class="panel-heading">'
                                            . $fields['option_name']
                                        . '</div>'
                                        . '<div class="panel-body">';

                // Verify if option has fields
                if ( $fields['fields'] ) {

                    // List all fields
                    foreach ( $fields['fields'] as $field ) {

                        try {

                            // Set the method
                            $method = $field['type'];

                            // Add option's slug
                            $field['option_slug'] = $fields['option_slug'];

                            // Set HTML content
                            $content .= (new MidrubBaseClassesContents\Admin_contents_option_templates)->$method($field);

                        } catch(Exception $e) {

                            continue;

                        }


                    }

                }

                $content .= '</div>'
                    . '</div>'
                    . '</div>'
                . '</div>';
                

                echo $content;
            }

        }
        
    }
    
}