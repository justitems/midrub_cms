<?php
/**
 * Curl Post Inc
 *
 * This file contains the functions to
 * use post requests
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_post') ) {
    
    /**
     * The function md_the_post posts content via http request
     * 
     * @param array $params contains the request's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_the_post($params) {

        // Verify if the url exists
        if ( empty($params['url']) ) {
            return '';
        }

        // Initialize a cURL session
        $curl = curl_init($params['url']);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        
        // Verify if token exists
        if ( !empty($params['token']) ) {

            // Prepare authorization
            $authorization = "Authorization: Bearer " . $params['token'];

            // Set authorization
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        }
        
        // Verify if fields exists
        if ( !empty($params['fields']) ) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params['fields']));
        }

        $data = curl_exec($curl);
        curl_close($curl);


        return $data;
        
    }
    
}

/* End of file post.php */