<?php
/**
 * Rss Clean Helper Class
 *
 * This file loads the Clean Class with methods to sanitize the content
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Rss\Helpers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Clean class loads the methods to sanitize the content
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Clean {

    /**
     * The public method the_clean_text removes the special characters and html from a string
     * 
     * @param string $text contains the text
     * 
     * @since 0.0.8.5
     * 
     * @return string
     */
    public function the_clean_text($text) {

        // Verify if text is array
        if ( is_array($text) ) {
            return '';
        }

        // Remove the CDATA
        $text = str_replace(array('<![CDATA[', ']]>'), '', $text);
        
        // Remove html
        $text = strip_tags($text);

        // Remove html
        $text = strip_tags(html_entity_decode($text));

        // Return text
        return !empty($text)?trim($text):$text;
        
    }

    /**
     * The public method the_clean_url sanitizes a url
     * 
     * @param string $url
     * 
     * @since 0.0.8.5
     * 
     * @return string
     */
    public function the_clean_url($url) {

        // Verify if url is array
        if ( is_array($url) ) {
            return '';
        }

        // Remove the CDATA
        $url = str_replace(array('<![CDATA[', ']]>'), '', $url);
        
        // Verify if url is valid
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {

            // Return the sanitized url
            return filter_var($url, FILTER_SANITIZE_URL);

        } else {

            return '';

        }
        
    }

    /**
     * The public method the_clean_email sanitizes an email
     * 
     * @param string $email
     * 
     * @since 0.0.8.5
     * 
     * @return string
     */
    public function the_clean_email($email) {

        // Verify if email is array
        if ( is_array($email) ) {
            return '';
        }

        // Remove the CDATA
        $email = str_replace(array('<![CDATA[', ']]>'), '', $email);
        
        // Verify if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {

            // Return the sanitized email
            return filter_var($email, FILTER_SANITIZE_EMAIL);

        } else {

            return '';

        }
        
    }

}