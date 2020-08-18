<?php
/**
 * Pagination Class
 *
 * This file loads the Pagination Class with methods to display the pagination
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Pagination class loads methods to display the pagination
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Pagination {


    /**
     * The public method get_pagination provides the information to generate the pagination
     * 
     * @since 0.0.8.1
     * 
     * @return array with pagination's data
     */
    public function the_pagination() {
     
        // Set current page
        $current = md_the_component_variable('page')?md_the_component_variable('page'):1;

        // Limit variable
        $limit = md_the_component_variable('contents_display_limit');

        // Total
        $total = md_the_component_variable('contents_display_total');

        // Url
        $url = md_the_component_variable('contents_pagination_url');

        if ( $total > $limit ) {

            return array(
                'total' => $total,
                'current' => $current,
                'limit' => $limit,
                'url' => $url
            );

        } else {

            return false;

        }
        
    }

    /**
     * The public method get_pagination displays the pagination
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function get_pagination() {

        // Get the pagination
        $pagination = $this->the_pagination();

        // Verify if pagination exists
        if ( $pagination ) {

            // Set current page
            $current = $pagination['current'];

            // Limit variable
            $limit = $pagination['limit'];

            // Total
            $total = $pagination['total'];

            // Url
            $url = $pagination['url'];

            // Verify if the current page is greater than 1
            if ($current > 1) {

                // Calculate the previous link
                $previous = $current - 1;

                // Set previous
                $pages = '<li>'
                            . '<a href="' . $url . $previous . '">'
                                . 'Prev'
                            . '</a>'
                        . '</li>';

            } else {

                // Set previous
                $pages = '<li class="pagehide">'
                            . '<a href="#">'
                                . 'Prev'
                            . '</a>'
                        . '</li>';

            }

            // Calculate the page by total and limit
            $total = $total / $limit;

            // Set new total value
            $total = ceil($total) + 1;

            // Set the page from where to start the counting
            $from = ($current > 2) ? $current - 2 : 1;

            // List pages
            for ($p = $from; $p < $total; $p++) {

                // Verify if is the current page
                if ($p == $current) {

                    // Set the current page
                    $pages .= '<li class="active">'
                                . '<a href="' . $url . $p . '">'
                                    . $p
                                . '</a>'
                            . '</li>';

                } else if ( ( $p < $current + 3 ) && ( $p > $current - 3 ) ) {

                    // Set pages link
                    $pages .= '<li>'
                                . '<a href="' . $url . $p . '">'
                                    . $p
                                . '</a>'
                            . '</li>';

                } else if (($p < 6) && ($total > 5) && (($current == 1) || ($current == 2))) {

                    // Set pages link
                    $pages .= '<li>'
                                . '<a href="' . $url . $p . '">'
                                    . $p
                                . '</a>'
                            . '</li>';                    

                } else {

                    break;
                    
                }

            }

            // Verify if current page is 1
            if ($p === 1) {

                // Set the active page
                $pages .= '<li class="active">'
                            . '<a href="' . $url . $p . '">'
                                . $p
                            . '</a>'
                        . '</li>';

            }

            // Set next page
            $next = $current;

            // Increase next page
            $next++;
            
            // Verify if next page exists
            if ( $next < $total ) {

                // Display pagination
                echo '<ul class="pagination">'
                        . $pages
                        . '<li>'
                            . '<a href="' . $url . $next . '">'
                                . 'Next'
                            . '</a>'
                        . '</li>'
                    . '</ul>';

            } else {

                // Display pagination
                echo '<ul class="pagination">'
                        . $pages
                        . '<li class="pagehide">'
                            . '<a href="#">'
                                . 'Next'
                            . '</a>'
                        . '</li>'
                    . '</ul>';
            
            }

        }

    }

}
