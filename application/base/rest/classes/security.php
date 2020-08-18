<?php
/**
 * Midrub Base Rest Security
 *
 * This file contains the class Security
 * with methods to verify if user is authorized to access a REST Endpoint
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
 */

// Define the page namespace
namespace MidrubBase\Rest\Classes;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Security class with methods to verify if user is authorized to access a REST Endpoint
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.9
*/
class Security
{

    /**
     * Class variables
     *
     * @since 0.0.7.8
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.8
     */
    public function __construct()
    {

        // Get codeigniter object instance
        $this->CI = &get_instance();
    }

    /**
     * The public method verify_token verifies if access token is valid
     * 
     * @param array $permissions contains the required permissions
     * 
     * @since 0.0.7.7
     * 
     * @return integer with user's id or false
     */
    public function verify_token($permissions)
    {

        // Verify if user has tried 5 wrong access tokens
        $this->check_block();

        // Verify the submitted data type
        switch ($this->CI->input->server('REQUEST_METHOD')) {

            case 'GET':

                // Get access_token's input
                $access_token = $this->CI->input->get('access_token');

                if (!$access_token) {

                    // Set failed attempt
                    $this->block_count();

                    // Display message
                    echo json_encode(array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('api_failed_connect')
                    ));

                    exit();
                }

                break;

            case 'POST':

                // Get access_token's from header
                $access_token = $this->get_token_header();

                if (!$access_token) {

                    // Set failed attempt
                    $this->block_count();

                    // Display message
                    echo json_encode(array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('api_failed_connect')
                    ));

                    exit();
                }

                break;
        }

        // Verify if access token is valid
        $token = $this->CI->base_rest->check_token($access_token);

        if (!$token) {

            // Set failed attempt
            $this->block_count();

            // Display message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('api_failed_connect_access_token')
            );

            echo json_encode($data);

            exit();
        }

        // Get token's permissions
        $token_permissions = $this->CI->base_rest->get_token_permissions($token[0]->token_id);

        if ($token_permissions) {

            $count = 0;

            foreach ($token_permissions as $permission) {

                if (in_array($permission->permission_slug, $permissions)) {
                    $count++;
                }
            }

            if ($count < count($permissions)) {

                // Set failed attempt
                $this->block_count();

                // Display message
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_failed_connect_enough_permissions') . ''
                );

                echo json_encode($data);

                exit();
            } else {

                $this->CI->user_id = $token[0]->user_id;

                return $token[0]->user_id;
            }
        } else {

            // Set failed attempt
            $this->block_count();

            // Display message
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('api_failed_connect_enough_permissions')
            );

            echo json_encode($data);

            exit();
        }
    }

    /**
     * The private method get_token_token gets token from header
     * 
     * @since 0.0.7.7
     * 
     * @return string with access token or boolean false
     */
    private function get_token_header()
    {

        $headers = FALSE;

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {

            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {

            $apacheHeader = apache_request_headers();

            $apacheHeaders = array_combine(array_map('ucwords', array_keys($apacheHeader)), array_values($apacheHeader));

            if (isset($apacheHeaders['Authorization'])) {

                $headers = trim($apacheHeaders['Authorization']);
            }
        }

        if ($headers) {

            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {

                return $matches[1];
            }
        }

        return $headers;

    }

    /**
     * The private method block_count will block user and if 5 blocks user won't be able more to access for 60 minutes
     * 
     * @return void
     */
    private function block_count()
    {

        // Get user ip
        $user_ip = $this->CI->input->ip_address();

        // Set block_user variable
        $block_user = array();

        $this->CI->db->select('data');
        $this->CI->db->from('ci_sessions');
        $this->CI->db->where(array('ip_address' => $user_ip));
        $this->CI->db->like('data', 'block');
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {

            $user_data = $query->result();

            $vars = explode('block_user|', $user_data[0]->data);

            $block_user = unserialize($vars[1]);
        }

        if ($block_user) {

            // Delete user session by ip
            $this->CI->db->delete('ci_sessions', array('ip_address' => $user_ip));

            if (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 1)) {

                // Prepare data to save
                $session_data = array(
                    'time' => time(),
                    'tried' => 2
                );

                $this->CI->session->set_userdata('block_user', $session_data);

            } elseif (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 2)) {

                // Prepare data to save
                $session_data = array(
                    'time' => time(),
                    'tried' => 3
                );

                $this->CI->session->set_userdata('block_user', $session_data);

            } elseif (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 3)) {

                // Prepare data to save
                $session_data = array(
                    'time' => time(),
                    'tried' => 4
                );

                $this->CI->session->set_userdata('block_user', $session_data);

            } elseif (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 4)) {

                // Prepare data to save
                $session_data = array(
                    'time' => time(),
                    'tried' => 5
                );

                $this->CI->session->set_userdata('block_user', $session_data);

                // Display message
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_failed_connect')
                ));

                exit();

            } else {

                // Prepare data to save
                $session_data = array(
                    'time' => time(),
                    'tried' => 1
                );

                $this->CI->session->set_userdata('block_user', $session_data);
            }

        } else {

            $session_data = array(
                'time' => time(),
                'tried' => 1
            );

            $this->CI->session->set_userdata('block_user', $session_data);

        }

    }

    /**
     * The private method block_count checks if the user is already blocked
     * 
     * @return void
     */
    private function check_block()
    {

        // Get user ip
        $user_ip = $this->CI->input->ip_address();

        // Set block_user variable
        $block_user = array();

        $this->CI->db->select('data');
        $this->CI->db->from('ci_sessions');
        $this->CI->db->where(array('ip_address' => $user_ip));
        $this->CI->db->like('data', 'block');
        $this->CI->db->limit(1);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {

            $user_data = $query->result();

            $vars = explode('block_user|', $user_data[0]->data);

            $block_user = unserialize($vars[1]);
        }

        if ($block_user) {

            if (($block_user['time'] > time() - 3600) and ($block_user['tried'] == 5)) {

                // Display message
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('api_failed_access_token')
                ));

                exit();

            } else {

                if (($block_user['time'] < time() - 3600)) {

                    // Delete user session by ip
                    $this->CI->db->delete('ci_sessions', array('ip_address' => $user_ip));

                }

            }

        }

    }

}

/* End of file security.php */