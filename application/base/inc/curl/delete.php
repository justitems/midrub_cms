<?php
/**
 * Curl Delete Inc
 *
 * This file contains the functions to
 * use delete requests
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('md_delete') ) {
    
    /**
     * The function md_delete deletes content via http request
     * 
     * @param array $params contains the request's parameters
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    function md_delete($params) {

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
        if ( empty($params['token']) ) {

            // Prepare authorization
            $authorization = "Authorization: Bearer " . $params['token'];

            // Set authorization
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        }
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
        
    }
    
}

/* End of file delete.php */