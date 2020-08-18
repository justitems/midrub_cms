<?php
/**
 * Breadcrumb Class
 *
 * This file loads the Breadcrumb Class with methods to process the breadcrumb
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Breadcrumb class loads methods to process the breadcrumb
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Breadcrumb {

    /**
     * The public method the_classification_breadcrumb generates the classification's breadcrumb
     * 
     * @since 0.0.8.1
     * 
     * @return array with items
     */
    public function the_classification_breadcrumb() {
     
        $list = array();
        
        // Verify if classification has parent
        if ( md_the_component_variable('classification_item_parent') ) {

            // Set classification's id
            $classification_id = md_the_component_variable('classification_item_id');

            if ( $classification_id ) {

                for ( $e = 0; $e < 100; $e++ ) {

                    // Get classification's item
                    $item = the_db_request(
                        'classifications',
                        'classifications.classification_id, classifications.parent, classifications_meta.meta_slug, classifications_meta.meta_value as name',
                        array(
                            'classifications.classification_id' => $classification_id,
                            'classifications_meta.meta_name' => 'name'
                        ),
                        array(),
                        array(),
                        array(
                            array(
                                'table' => 'classifications_meta',
                                'condition' => 'classifications.classification_id=classifications_meta.classification_id',
                                'join_from' => 'LEFT'
                            )

                        )

                    );

                    if ( $item ) {

                        if ( $classification_id === md_the_component_variable('classification_item_id') ) {
                                
                            $list[$e] = array(
                                'name' => $item[0]['name']
                            );

                        } else {

                            $list[$e] = array(
                                'name' => $item[0]['name'],
                                'url' => site_url(md_the_component_variable('classification_slug') . '/' . $item[0]['meta_slug'])
                            );

                        }
                        
                        if ( $item[0]['parent'] > 0 ) {

                            $classification_id = $item[0]['parent'];

                        } else {

                            break;

                        }

                    }

                }

                if ( $list ) {
                    array_multisort ($list, SORT_DESC, $list);
                }
                
            }

        } else {

            $list[] = array(
                'name' => md_the_component_variable('classification_item_name')
            );

        }

        return $list;

    }

}
