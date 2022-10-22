<?php
/**
 * Download Class
 *
 * This file loads the Download Class with methods to download media files in the user's storage
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Media;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Media Save Inc file
require_once CMS_BASE_PATH . 'inc/media/save.php';

/*
 * Download class loads the methods to download media files in the user's storage
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Download {

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
        
        // Get CodeIgniter object instance
        $this->CI =& get_instance();

        // Load language
        $this->CI->lang->load( 'medias', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_PATH );

        // Verify if the Settings component exists
        if ( defined('CMS_BASE_ADMIN_COMPONENTS_SETTINGS') ) {

            // Load the component's language files
            $this->CI->lang->load( 'settings', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_ADMIN_COMPONENTS_SETTINGS);               

            // Require the Storage Init Hooks Inc file
            require_once CMS_BASE_ADMIN_COMPONENTS_SETTINGS . 'inc/storage_init_hooks.php';
            
        }
        
    }

    /**
     * The public method upload_from_url uploads files in the user's storage
     * 
     * @param array $params contains the file's data
     * @param boolean $return contains the return option
     * 
     * @since 0.0.8.4
     * 
     * @return void
     */
    public function upload_from_url($params, $return=FALSE) {

        // Get upload limit
        $upload_limit = md_the_option('upload_limit');
        
        // Verify for upload limit
        if ( !$upload_limit ) {

            // Set default limit
            $upload_limit = 6291456;

        } else {

            // Set wanted limit
            $upload_limit = $upload_limit * 1048576;

        }

        // Verify if the cover's url exists
        if ( empty($params['cover_url']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_file_cover_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        } else {

            // Verify if the cover is a url
            if ( filter_var($params['cover_url'], FILTER_VALIDATE_URL) !== FALSE ) {

                // Get cover's headers
                $cover_headers = $this->parse_header($params['cover_url']);

                // Verify if 2 key exists
                if ( empty($cover_headers['content-type']) || empty($cover_headers['content-length']) ) {

                    // Prepare response
                    $message = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('media_header_cover_wrong')
                    );

                    // Verify if the data should be returned
                    if ( $return ) {

                        // Return the message
                        return $message;

                    } else {

                        // Display the response
                        echo json_encode($message);
                        exit();

                    }

                }

                // Set file's type
                $cover_file_type = $cover_headers['content-type'];

                // Verify if the file has supported format
                if ( !in_array($cover_file_type, array('image/png', 'image/jpg', 'image/jpeg', 'image/gif')) ) {
                    
                    // Prepare response
                    $message = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('media_cover_no_supported_format')
                    );

                    // Verify if the data should be returned
                    if ( $return ) {

                        // Return the message
                        return $message;

                    } else {

                        // Display the response
                        echo json_encode($message);
                        exit();

                    }
                    
                }

                // Set file's size
                $cover_file_size = $cover_headers['content-length'];

                // Verify if the file size has allowed size
                if ( $cover_file_size > $upload_limit ) {
                    
                    // Prepare response
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('media_cover_too_large')
                    );

                    // Verify if the data should be returned
                    if ( $return ) {

                        // Return the message
                        return $data;

                    } else {

                        // Display the response
                        echo json_encode($data);
                        exit();

                    }
                    
                }

            }

        }

        // Set default user's ID
        $user_id = md_the_user_id();

        // Verify if user's ID exists
        if ( !empty($params['user_id']) ) {

            // Set new user's ID
            $user_id = $params['user_id'];

        }

        // Verify if any user's ID exists
        if ( empty($user_id) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_user_id_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if the allowed_extensions parameter exists
        if ( empty($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }
        
        // Verify if the allowed_extensions parameter is array
        if ( !is_array($params['allowed_extensions']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_allowed_extensions_missing')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if category exists
        if ( empty($params['category']) ) {
            $params['category'] = 0;
        }

        // Set headers
        $headers = $this->parse_header($params['file_url']);

        // Verify if 2 key exists
        if ( empty($headers['content-type']) || empty($headers['content-length']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_header_file_wrong')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Set file's type
        $params['file_type'] = $headers['content-type'];

        // Get the file's extension
        $params['file_extension'] = $this->the_file_extension($params['file_type']);

        // Verify if the file extension exists
        if ( !$params['file_extension'] ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_supported_format')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Set file's size
        $params['file_size'] = $headers['content-length'];
                
        // Get user storage
        $params['user_storage'] = md_the_user_option($user_id, 'user_storage');
        
        // Get total storage
        $params['total_storage'] = $params['file_size'] + ($params['user_storage']?$params['user_storage']:0);

        // Get plan's storage
        $the_storage = $this->CI->base_model->the_data_where(
        'plans_meta',
        'meta_value AS storage',
        array(
            'plan_id' => md_the_user_option($user_id, 'plan'),
            'meta_name' => 'storage'
        ));

        // Prepare plan's storage
        $plan_storage = $the_storage?$the_storage:0;
        
        // Verify if user has enough storage
        if ( $params['total_storage'] >= $plan_storage ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_free_space')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Get upload limit
        $upload_limit = md_the_option('upload_limit');
        
        // Verify for upload limit
        if ( !$upload_limit ) {

            // Set default limit
            $upload_limit = 6291456;

        } else {

            // Set wanted limit
            $upload_limit = $upload_limit * 1048576;

        }
        
        // Verify if the file size has allowed size
        if ( $params['file_size'] > $upload_limit ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_file_too_large')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the file has supported format
        if ( !in_array($params['file_type'], $params['allowed_extensions']) ) {
            
            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_an_error_has_occurred') . ': ' . $this->CI->lang->line('media_no_supported_format')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Get the storage's location
        $storage_location = md_the_option('storage_location');

        // Get the locations
        $the_locations = the_storage_locations();

        // Verify if storage's locations exists
        if ( !$the_locations ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_locations_were_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Verify if the storage's location exists
        if ( !$storage_location ) {        

            // Try to update the option
            if ( md_update_option('storage_location', 'local') ) {

                // Set default storage's location
                $storage_location = 'local';

            }

        }

        // Verify if the storage's location exists
        if ( !$storage_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }          

        }

        // Set where location
        $where = array('location_slug' => $storage_location);

        // Get the location
        $the_location = array_filter(array_map(function($location) use($where){
            
            // Verify if is required location
            if ( $where['location_slug'] === key($location) ) {

                return array(
                    'location_slug' => $location
                );

            }

        }, $the_locations));

        // Verify if the location exists
        if ( !$the_location ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }

        // Get the location's data
        $location_data = array_column($the_location, 'location_slug');

        // Verify if location's data exists
        if ( empty($location_data[0][$storage_location]) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_found')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }

        }

        // Verify if the storage's location has the upload option
        if ( empty($location_data[0][$storage_location]['location_upload_from_url']) ) {

            // Prepare response
            $message = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('media_no_storage_location_upload_option')
            );

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $message;

            } else {

                // Display the response
                echo json_encode($message);
                exit();

            }
            
        }
        
        // Try to upload the file
        $upload = $location_data[0][$storage_location]['location_upload_from_url']($params);

        // Verify if the file was uploaded
        if ( !empty($upload['success']) ) {

            // Set media's ID
            $params['media_id'] = $upload['media_id'];

            // Set media's cover
            $params['media_cover'] = $upload['media_cover'];

            // Run hook
            md_run_hook('upload_media', $params);
                
            // Extensions list
            $extensions = array(
                '.php',
                '.php3',
                '.php4',
                '.php5',
                '.php7',
                '.phtml',
                '.pht'
            );

            // List all extensions
            foreach ( $extensions as $ext ) {
                $this->delete_files(FCPATH . 'assets/share', $ext);   
            } 

            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);   

            }

        } else {
            
            // Verify if the data should be returned
            if ( $return ) {

                // Return the message
                return $upload;

            } else {

                // Display the response
                echo json_encode($upload);   

            }

        }

    }

    /**
     * The public method parse_header gets header's data from url
     * 
     * @param string $url contains the url to parse
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function parse_header($url) {

        // Get headers
        $the_params = get_headers($url);

        // Params array
        $params = array();

        // Verify if params exists
        if ( $the_params ) {

            // List params
            foreach ( $the_params as $the_param ) {

                // Set value
                $params[strtolower(substr($the_param, 0, strripos($the_param, ':')))] = substr($the_param, (strripos($the_param, ':') + 2), strlen($the_param));

            }

        }

        // Verify if params exists
        if ( $params ) {
            return $params;
        } else {
            return array();
        }

    }

    /**
     * The public method the_file_extension gets the file extension
     * 
     * @param string $mime contains the file's mime
     * 
     * @since 0.0.8.5
     * 
     * @return string with extension or boolean false
     */
    public function the_file_extension($mime) {

        // Extensions list
        $extensions_list = array(
            'video/3gpp2'                                                               => '3g2',
            'video/3gp'                                                                 => '3gp',
            'video/3gpp'                                                                => '3gp',
            'application/x-compressed'                                                  => '7zip',
            'audio/x-acc'                                                               => 'aac',
            'audio/ac3'                                                                 => 'ac3',
            'application/postscript'                                                    => 'ai',
            'audio/x-aiff'                                                              => 'aif',
            'audio/aiff'                                                                => 'aif',
            'audio/x-au'                                                                => 'au',
            'video/x-msvideo'                                                           => 'avi',
            'video/msvideo'                                                             => 'avi',
            'video/avi'                                                                 => 'avi',
            'application/x-troff-msvideo'                                               => 'avi',
            'application/macbinary'                                                     => 'bin',
            'application/mac-binary'                                                    => 'bin',
            'application/x-binary'                                                      => 'bin',
            'application/x-macbinary'                                                   => 'bin',
            'image/bmp'                                                                 => 'bmp',
            'image/x-bmp'                                                               => 'bmp',
            'image/x-bitmap'                                                            => 'bmp',
            'image/x-xbitmap'                                                           => 'bmp',
            'image/x-win-bitmap'                                                        => 'bmp',
            'image/x-windows-bmp'                                                       => 'bmp',
            'image/ms-bmp'                                                              => 'bmp',
            'image/x-ms-bmp'                                                            => 'bmp',
            'application/bmp'                                                           => 'bmp',
            'application/x-bmp'                                                         => 'bmp',
            'application/x-win-bitmap'                                                  => 'bmp',
            'application/cdr'                                                           => 'cdr',
            'application/coreldraw'                                                     => 'cdr',
            'application/x-cdr'                                                         => 'cdr',
            'application/x-coreldraw'                                                   => 'cdr',
            'image/cdr'                                                                 => 'cdr',
            'image/x-cdr'                                                               => 'cdr',
            'zz-application/zz-winassoc-cdr'                                            => 'cdr',
            'application/mac-compactpro'                                                => 'cpt',
            'application/pkix-crl'                                                      => 'crl',
            'application/pkcs-crl'                                                      => 'crl',
            'application/x-x509-ca-cert'                                                => 'crt',
            'application/pkix-cert'                                                     => 'crt',
            'text/css'                                                                  => 'css',
            'text/x-comma-separated-values'                                             => 'csv',
            'text/comma-separated-values'                                               => 'csv',
            'application/vnd.msexcel'                                                   => 'csv',
            'application/x-director'                                                    => 'dcr',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
            'application/x-dvi'                                                         => 'dvi',
            'message/rfc822'                                                            => 'eml',
            'application/x-msdownload'                                                  => 'exe',
            'video/x-f4v'                                                               => 'f4v',
            'audio/x-flac'                                                              => 'flac',
            'video/x-flv'                                                               => 'flv',
            'image/gif'                                                                 => 'gif',
            'application/gpg-keys'                                                      => 'gpg',
            'application/x-gtar'                                                        => 'gtar',
            'application/x-gzip'                                                        => 'gzip',
            'application/mac-binhex40'                                                  => 'hqx',
            'application/mac-binhex'                                                    => 'hqx',
            'application/x-binhex40'                                                    => 'hqx',
            'application/x-mac-binhex40'                                                => 'hqx',
            'text/html'                                                                 => 'html',
            'image/x-icon'                                                              => 'ico',
            'image/x-ico'                                                               => 'ico',
            'image/vnd.microsoft.icon'                                                  => 'ico',
            'text/calendar'                                                             => 'ics',
            'application/java-archive'                                                  => 'jar',
            'application/x-java-application'                                            => 'jar',
            'application/x-jar'                                                         => 'jar',
            'image/jp2'                                                                 => 'jp2',
            'video/mj2'                                                                 => 'jp2',
            'image/jpx'                                                                 => 'jp2',
            'image/jpm'                                                                 => 'jp2',
            'image/jpeg'                                                                => 'jpeg',
            'image/pjpeg'                                                               => 'jpeg',
            'application/x-javascript'                                                  => 'js',
            'application/json'                                                          => 'json',
            'text/json'                                                                 => 'json',
            'application/vnd.google-earth.kml+xml'                                      => 'kml',
            'application/vnd.google-earth.kmz'                                          => 'kmz',
            'text/x-log'                                                                => 'log',
            'audio/x-m4a'                                                               => 'm4a',
            'application/vnd.mpegurl'                                                   => 'm4u',
            'audio/midi'                                                                => 'mid',
            'application/vnd.mif'                                                       => 'mif',
            'video/quicktime'                                                           => 'mov',
            'video/x-sgi-movie'                                                         => 'movie',
            'audio/mpeg'                                                                => 'mp3',
            'audio/mpg'                                                                 => 'mp3',
            'audio/mpeg3'                                                               => 'mp3',
            'audio/mp3'                                                                 => 'mp3',
            'video/mp4'                                                                 => 'mp4',
            'video/mpeg'                                                                => 'mpeg',
            'application/oda'                                                           => 'oda',
            'audio/ogg'                                                                 => 'ogg',
            'video/ogg'                                                                 => 'ogg',
            'application/ogg'                                                           => 'ogg',
            'application/x-pkcs10'                                                      => 'p10',
            'application/pkcs10'                                                        => 'p10',
            'application/x-pkcs12'                                                      => 'p12',
            'application/x-pkcs7-signature'                                             => 'p7a',
            'application/pkcs7-mime'                                                    => 'p7c',
            'application/x-pkcs7-mime'                                                  => 'p7c',
            'application/x-pkcs7-certreqresp'                                           => 'p7r',
            'application/pkcs7-signature'                                               => 'p7s',
            'application/pdf'                                                           => 'pdf',
            'application/octet-stream'                                                  => 'pdf',
            'application/x-x509-user-cert'                                              => 'pem',
            'application/x-pem-file'                                                    => 'pem',
            'application/pgp'                                                           => 'pgp',
            'application/x-httpd-php'                                                   => 'php',
            'application/php'                                                           => 'php',
            'application/x-php'                                                         => 'php',
            'text/php'                                                                  => 'php',
            'text/x-php'                                                                => 'php',
            'application/x-httpd-php-source'                                            => 'php',
            'image/png'                                                                 => 'png',
            'image/x-png'                                                               => 'png',
            'application/powerpoint'                                                    => 'ppt',
            'application/vnd.ms-powerpoint'                                             => 'ppt',
            'application/vnd.ms-office'                                                 => 'ppt',
            'application/msword'                                                        => 'doc',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/x-photoshop'                                                   => 'psd',
            'image/vnd.adobe.photoshop'                                                 => 'psd',
            'audio/x-realaudio'                                                         => 'ra',
            'audio/x-pn-realaudio'                                                      => 'ram',
            'application/x-rar'                                                         => 'rar',
            'application/rar'                                                           => 'rar',
            'application/x-rar-compressed'                                              => 'rar',
            'audio/x-pn-realaudio-plugin'                                               => 'rpm',
            'application/x-pkcs7'                                                       => 'rsa',
            'text/rtf'                                                                  => 'rtf',
            'text/richtext'                                                             => 'rtx',
            'video/vnd.rn-realvideo'                                                    => 'rv',
            'application/x-stuffit'                                                     => 'sit',
            'application/smil'                                                          => 'smil',
            'text/srt'                                                                  => 'srt',
            'image/svg+xml'                                                             => 'svg',
            'application/x-shockwave-flash'                                             => 'swf',
            'application/x-tar'                                                         => 'tar',
            'application/x-gzip-compressed'                                             => 'tgz',
            'image/tiff'                                                                => 'tiff',
            'text/plain'                                                                => 'txt',
            'text/x-vcard'                                                              => 'vcf',
            'application/videolan'                                                      => 'vlc',
            'text/vtt'                                                                  => 'vtt',
            'audio/x-wav'                                                               => 'wav',
            'audio/wave'                                                                => 'wav',
            'audio/wav'                                                                 => 'wav',
            'application/wbxml'                                                         => 'wbxml',
            'video/webm'                                                                => 'webm',
            'audio/x-ms-wma'                                                            => 'wma',
            'application/wmlc'                                                          => 'wmlc',
            'video/x-ms-wmv'                                                            => 'wmv',
            'video/x-ms-asf'                                                            => 'wmv',
            'application/xhtml+xml'                                                     => 'xhtml',
            'application/excel'                                                         => 'xl',
            'application/msexcel'                                                       => 'xls',
            'application/x-msexcel'                                                     => 'xls',
            'application/x-ms-excel'                                                    => 'xls',
            'application/x-excel'                                                       => 'xls',
            'application/x-dos_ms_excel'                                                => 'xls',
            'application/xls'                                                           => 'xls',
            'application/x-xls'                                                         => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
            'application/vnd.ms-excel'                                                  => 'xlsx',
            'application/xml'                                                           => 'xml',
            'text/xml'                                                                  => 'xml',
            'text/xsl'                                                                  => 'xsl',
            'application/xspf+xml'                                                      => 'xspf',
            'application/x-compress'                                                    => 'z',
            'application/x-zip'                                                         => 'zip',
            'application/zip'                                                           => 'zip',
            'application/x-zip-compressed'                                              => 'zip',
            'application/s-compressed'                                                  => 'zip',
            'multipart/x-zip'                                                           => 'zip',
            'text/x-scriptzsh'                                                          => 'zsh'
        );

        return isset($extensions_list[$mime]) === true?$extensions_list[$mime]:false;

    }

    /**
     * The public method delete_files deletes all files by extension
     * 
     * @param string $path contains the dir path
     * @param string $ext the files extension
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function delete_files($path, $ext) {

        // Verify if files exists
        if ( glob($path . '/*' . $ext) ) {
        
            // List all files
            foreach (glob($path . '/*' . $ext) as $filename) {
                unlink($filename);
            }
        
        }

    }

}

/* End of file download.php */