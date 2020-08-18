<?php
/**
 * Midrub Base Rest
 *
 * This file loads the Midrub's Base Rest
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */

// Define the page namespace
namespace MidrubBase\Install;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('MIDRUB_BASE_INSTALL') OR define('MIDRUB_BASE_INSTALL', APPPATH . 'base/install/');

/*
 * Main is the rest's base loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.1
 */
class Main {

    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.8.1
     */
    public function __construct() {

        // Get codeigniter object instance
        $this->CI =& get_instance();

    }
    
    /**
     * The public method init starts the Midrub's installation
     * 
     * @since 0.0.8.1
     * 
     * @return void
     */
    public function init() {

        // Require the General Inc
        require_once MIDRUB_BASE_INSTALL . 'inc/general.php';

        // Load the view
        switch ( $this->CI->input->get('action') ) {

            case 'enter-information':

                // Require the Information View
                require_once MIDRUB_BASE_INSTALL . 'views/information.php';

                break;

            case 'database-information':

                // Error variable
                $error = '';

                // Check if data was submitted
                if ($this->CI->input->post()) {
                    
                    // Add form validation
                    $this->CI->form_validation->set_rules('website_name', 'Website Name', 'trim|required');
                    $this->CI->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required|valid_email');
                    $this->CI->form_validation->set_rules('notification_email', 'Notification Email', 'trim|required|valid_email');

                    // Get data
                    $website_name = $this->CI->input->post('website_name', TRUE);
                    $contact_email = $this->CI->input->post('contact_email', TRUE);
                    $notification_email = $this->CI->input->post('notification_email', TRUE);
                    
                    // Verify if the submitted data is correct
                    if ( $this->CI->form_validation->run() === false ) {

                        // Set the error
                        $error = 'The entered information is not valid.';
                        
                    } else {

                        // Verify if the file exists
                        if ( file_exists(MIDRUB_BASE_INSTALL . 'templates/config.txt') ) {

                            // Open the file to get existing content
                            $template = file_get_contents(MIDRUB_BASE_INSTALL . 'templates/config.txt');

                            // Set the website url
                            $template = str_replace('[url]', md_the_url(), $template);

                            // Set the website name
                            $template = str_replace('[name]', $website_name, $template);
                            
                            // Set the contact's email
                            $template = str_replace('[contact_mail]', $contact_email, $template);
                            
                            // Set the notification's email
                            $template = str_replace('[notification_mail]', $notification_email, $template);
                            
                            // If url is localhost the cookie domain should be empty
                            if ( preg_match('/localhost/i', md_the_url()) ) {

                                // Empty value
                                $template = str_replace('[cookie_domain]', '', $template);

                            } else {

                                // Get domain
                                $parse = parse_url(md_the_url());

                                // Set domain
                                $template = str_replace('[cookie_domain]', '.' . $parse['host'], $template);

                            }

                            // Write the contents to the file
                            file_put_contents(MIDRUB_BASE_INSTALL . 'temp/config.php', $template);

                            // Verify if the file was saved
                            if ( !file_exists(MIDRUB_BASE_INSTALL . 'temp/config.php') ) {

                                // Set the error
                                $error = 'The config.php was not created.';        

                            }

                        } else {

                            // Set the error
                            $error = 'The config.txt template was not found.';                            

                        }

                    }

                } else {

                    // Set the error
                    $error = 'The page isn\'t available.';

                }

                // Verify if errors exists
                if ( $error ) {

                    // Set error constant
                    define('ERROR_MESSAGE', $error);

                    // Require the Error View
                    require_once MIDRUB_BASE_INSTALL . 'views/error.php';

                } else {

                    // Require the Database View
                    require_once MIDRUB_BASE_INSTALL . 'views/database.php';

                }

                break;

            case 'finish':

                // Error variable
                $error = '';

                // Check if data was submitted
                if ($this->CI->input->post()) {
                    
                    // Add form validation
                    $this->CI->form_validation->set_rules('db_host', 'DB Host', 'trim|required');
                    $this->CI->form_validation->set_rules('db_user_name', 'DB User Name', 'trim|required');
                    $this->CI->form_validation->set_rules('db_user_password', 'DB User Password', 'trim');
                    $this->CI->form_validation->set_rules('db_name', 'DB Name', 'trim|required');

                    // Get data
                    $db_host = $this->CI->input->post('db_host', TRUE);
                    $db_user_name = $this->CI->input->post('db_user_name', TRUE);
                    $db_user_password = $this->CI->input->post('db_user_password', TRUE);
                    $db_name = $this->CI->input->post('db_name', TRUE);
                    
                    // Verify if the submitted data is correct
                    if ( $this->CI->form_validation->run() === false ) {

                        // Set the error
                        $error = 'The entered information is not valid.';
                        
                    } else {

                        // Verify if the file exists
                        if ( file_exists(MIDRUB_BASE_INSTALL . 'templates/database.txt') ) {

                            // Open the file to get existing content
                            $template = file_get_contents(MIDRUB_BASE_INSTALL . 'templates/database.txt');

                            // Set the database name
                            $template = str_replace('[db_host]', $db_host, $template);
                            
                            // Set the database's user name
                            $template = str_replace('[db_user_name]', $db_user_name, $template);
                            
                            // Set the database's user password
                            $template = str_replace('[db_user_password]', $db_user_password, $template);
                            
                            // Set the database's name
                            $template = str_replace('[db_name]', $db_name, $template);
                            
                            // Create connection
                            @$conn = new \mysqli($db_host, $db_user_name, $db_user_password, $db_name);

                            // Check connection
                            if ($conn->connect_error) {

                                // Set the error
                                $error = 'Connection failed: ' . $conn->connect_error;    

                            } else {

                                // Get Sql mode
                                $mode = $conn->query('SELECT @@GLOBAL.sql_mode');

                                // Get the response
                                $response = $mode->fetch_assoc();

                                // Response exists and just verify if the resuls has the sql restriction
                                if ( strpos($response["@@GLOBAL.sql_mode"], 'ONLY_FULL_GROUP_BY') !== false ) {

                                    // Set the error
                                    $error = 'The ONLY_FULL_GROUP_BY restriction is enabled. Please click here for <a href="https://www.midrub.com/articles/in-aggregated-query-without-group-by-expression-of-select-list-contains-nonaggregated-column" target="_blank">more</a> details.';     

                                } else {

                                    // Write the contents to the file
                                    file_put_contents(MIDRUB_BASE_INSTALL . 'temp/database.php', $template);

                                    // Verify if the file was saved
                                    if ( !file_exists(MIDRUB_BASE_INSTALL . 'temp/database.php') ) {

                                        // Set the error
                                        $error = 'The database.php was not created.';        

                                    }

                                }

                            }

                        } else {

                            // Set the error
                            $error = 'The database.txt template was not found.';                            

                        }

                    }

                } else {

                    // Set the error
                    $error = 'The page isn\'t available.';

                }

                // Verify if errors exists
                if ( $error ) {

                    // Set error constant
                    define('ERROR_MESSAGE', $error);

                    // Require the Error View
                    require_once MIDRUB_BASE_INSTALL . 'views/error.php';

                } else {

                    // Select the midrub.sql file
                    $sqltbs = file(MIDRUB_BASE_INSTALL . 'templates/midrub.sql');

                    // Tb Error
                    $tb_error = '';

                    // List all lines
                    foreach ($sqltbs as $line)	{
                        
                        $start = substr(trim($line), 0 ,2);
                        $end = substr(trim($line), -1 ,1);
                        
                        if ( empty($line) || $start == '--' || $start == '/*' || $start == '//' ) {
                            continue;
                        }
                        
                        $tb_error = $tb_error . $line;
                        if ( $end == ';' ) {
                            mysqli_query($conn, $tb_error) or die('Problem in executing the SQL query <b>' . $tb_error . '</b>');
                            $tb_error= '';
                        }
                    }

                    // Try to copy the config.php
                    if ( !copy(MIDRUB_BASE_INSTALL . 'temp/config.php', FCPATH . 'application/config/config.php') ) {

                        // Set the error
                        $error = 'The file config.php was not copied successfully.';    

                    }

                    // Try to copy the database.php
                    if ( !copy(MIDRUB_BASE_INSTALL . 'temp/database.php', FCPATH . 'application/config/database.php') ) {

                        // Set the error
                        $error = 'The file database.php was not copied successfully.';    

                    }

                    // Try to copy the autoload.php
                    if ( !copy(MIDRUB_BASE_INSTALL . 'temp/autoload.php', FCPATH . 'application/config/autoload.php') ) {

                        // Set the error
                        $error = 'The file autoload.php was not copied successfully.';    

                    }

                    // Verify if errors exists
                    if ( $error ) {

                        // Set error constant
                        define('ERROR_MESSAGE', $error);

                        // Require the Error View
                        require_once MIDRUB_BASE_INSTALL . 'views/error.php';

                    } else {                    

                        // Require the Finish View
                        require_once MIDRUB_BASE_INSTALL . 'views/finish.php';

                    }

                }

                break;

            default:

                // Require the Install View
                require_once MIDRUB_BASE_INSTALL . 'views/install.php';            

                break;

        }

        exit();
        
    }

}

/* End of file main.php */