<?php
/**
 * Rss Read Class
 *
 * This file loads the Rss Class with methods for rss reading
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Rss;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Read class loads the methods to read the rss feeds
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Read {

    /**
     * Class variables
     *
     * @since 0.0.8.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'rss', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PATH );
        
    }

    /**
     * The public method the_xml_content gets the content from a XML url
     * 
     * @param array $params contains the parameters
     * 
     * @since 0.0.8.5
     * 
     * @return array with response
     */
    public function the_xml_content($params) {

        // Verify if url key exists
        if ( empty($params['url']) ) {

            // Return error message
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('rss_xml_url_not_found')
            );
            
        }

        // Sanitize the url
        $sanitized_url = filter_var($params['url'], FILTER_SANITIZE_URL);

        // Verify if the url is valid
        if (filter_var($sanitized_url, FILTER_VALIDATE_URL) === false) {

            // Return error message
            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('rss_xml_url_not_found')
            );

        }

        // Get the xml content
        $the_xml_content = $this->the_curl_request($sanitized_url);

        // Check if the XML is valid
        if ( empty($the_xml_content) ) {

            return array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('rss_no_valid_xml_code')
            );

        }

        // Remove JavaScript code
        $xml = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $the_xml_content);

        // Content container
        $content = array();

        // Verify if options exists
        if ( !empty(glob(CMS_BASE_PATH . 'classes/rss/options/*.php')) ) {

            try {

                // Init SimpleXmlElement
                $xml_content = new \SimpleXmlElement($xml, LIBXML_NOERROR);
                
            } catch (\Throwable $t) {
                
                return array(
                    'success' => FALSE,
                    'message' => $t->getMessage()
                );                

            }

            // List all templates
            foreach (glob(CMS_BASE_PATH . 'classes/rss/options/*.php') as $filename) {

                // Get option
                $option = str_replace(array(CMS_BASE_PATH . 'classes/rss/options/', '.php'), '', $filename);

                // Create an array
                $array = array(
                    'CmsBase',
                    'Classes',
                    'Rss',
                    'Options',
                    ucfirst($option)
                );

                // Implode the array above
                $cl = implode('\\',$array);      
                
                // Instantiate the class
                $response = (new $cl())->the_xml_content($xml_content);

                // Verify if the response is valid
                if ( !empty($response['success']) ) {

                    // Add response to the container
                    $content = $response['content'];
                    break;

                }

            }

            // Verify if valid content exists
            if ( empty($content) ) {

                // Return error message
                return array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('rss_xml_code_not_supported')
                );

            }

        }

        // Return the rss content
        return array(
            'success' => TRUE,
            'content' => $content
        );        
        
    }

    /**
     * The public method the_curl_request gets content from url
     * 
     * @param string $url contains the RSS url
     * 
     * @since 0.0.8.5
     * 
     * @return string with response
     */
    public function the_curl_request($url) {

        // CURL Init
        $curl = curl_init();

        // Set URL
        curl_setopt($curl, CURLOPT_URL, $url);

        // Set User Agent
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');

        // Enable return
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Get the response
        $url_content = curl_exec($curl);

        // Close the CURL
        curl_close($curl);

        // Verify if content exists
        if ( !empty($url_content) ) {

            // Check if the XML is valid
            if ( !$this->the_xml_is_valid($url_content) ) {

                // Try with file get contents
                $the_content = @file_get_contents($url);

                // Verify if content exists
                if ( !empty($the_content) ) {

                    // Verify if the content is xml
                    if ( $this->the_xml_is_valid($the_content) ) {

                        // Set url content
                        $url_content = $the_content;

                    }

                }

            }

        }

        return $url_content;
        
    }
    
    /**
     * The public method the_xml_is_valid verifies if a xml file is valid
     * 
     * @param string $xml contains the XML
     * 
     * @since 0.0.8.5
     * 
     * @return boolean
     */
    public function the_xml_is_valid($xml) {

        // Enable fetch error information
        libxml_use_internal_errors(true);

        // Initiate the DOMDocument object
        $doc = new \DOMDocument('1.0', 'utf-8');

        // Set XML
        $doc->loadXML($xml);
        
        // Get errors
        $errors = libxml_get_errors();

        // Clear the errors
        libxml_clear_errors();

        return empty($errors)?TRUE:FALSE;
        
    }

}

/* End of file rss.php */