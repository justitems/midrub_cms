<?php
/**
 * Replacers Class
 *
 * This file loads the Replacers Class with methods to process the replacers
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Frontend\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Replacers class loads methods to process the replacers
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Replacers {

    /**
     * The public method the_replacers replaces the placeholders
     * 
     * @param string $content contains the content
     * 
     * @since 0.0.8.1
     * 
     * @return string with content
     */
    public function the_replacers($content) {
     
        // Get replacers
        $replacers = md_the_component_variable('content_replacer');

        // Get placeholders
        preg_match_all("/{[^}]*}/", $content, $placeholders);

        // Verify if placeholders exists
        if ( $placeholders[0] ) {

            foreach ( $placeholders[0] as $placeholder ) {

                $found = explode(' ', str_replace(array('{', '}'), array('', ''), $placeholder));

                if ( $found[0] ) {

                    if ( isset($replacers[$found[0]]) ) {

                        $args = array(
                            'start' => 1,
                            'content' => $content
                        );

                        if ( count($found) > 1 ) {

                            for( $f = 1; $f < count($found); $f++ ) {

                                parse_str(str_replace('"', "", $found[$f]), $a);

                                $key = array_keys($a);
                                
                                if ( isset($a[$key[0]]) ) {

                                    $args[$key[0]] = $a[$key[0]];

                                }

                            }

                        }

                        $content = $replacers[$found[0]]($args);

                    } else if ( isset($replacers[str_replace('|', '', $found[0])]) ) {

                        $args = array(
                            'end' => 1,
                            'content' => $content
                        );

                        $content = $replacers[str_replace('|', '', $found[0])]($args);

                    }

                }

            }

        }

        return $content;

    }

}
