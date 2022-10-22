<?php
/**
 * Curl Get Inc
 *
 * This file contains the functions to
 * use get requests
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_the_get') ) {
    
    /**
     * The function md_the_get gets content via http request
     * 
     * @param array $params contains the request's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_the_get($params) {

        // Verify if the url exists
        if ( empty($params['url']) ) {
            return '';
        }

        // Initialize a cURL session
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_URL => $params['url'],
            CURLOPT_HEADER => 'User-Agent: Chrome\r\n',
            CURLOPT_TIMEOUT => '3L'));
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
        
    }
    
}

/* End of file get.php */