<?php
/**
 * Adminarea
 *
 * PHP Version 5.6
 *
 * Adminarea contains the Adminarea class for admin account
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Adminarea class - contains all metods and pages for admin account.
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Adminarea extends MY_Controller {

    public $user_id, $user_role, $socials = [];

    public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load User Model
        $this->load->model('user');
        
        // Load User Meta Model
        $this->load->model('user_meta');
        
        // Load Notifications Model
        $this->load->model('notifications');
        
        // Load Posts Model
        $this->load->model('posts');
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load Urls Model
        $this->load->model('urls');
        
        // Load Networks Model
        $this->load->model('networks');
        
        // Load Options Model
        $this->load->model('options');
        
        // Load Campaigns Model
        $this->load->model('campaigns');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        // Load Gshorter library
        $this->load->library('gshorter');
        
        // Check if session username exists
        if (isset($this->session->userdata ['username'])) {
            
            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata ['username']);
            
            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata ['username']);
            
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_admin_lang.php' ) ) {
            $this->lang->load( 'default_admin', $this->config->item('language') );
        }
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
            $this->lang->load( 'default_alerts', $this->config->item('language') );
        }
    }

    /**
     * The public method dashboard displays admin dashboard.
     * 
     * @return void
     */
    public function dashboard() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);

        // Redirect to the Dashboard component
        redirect('admin/dashboard');

    }

    /**
     * The public method scheduled_posts displays scheduled posts page
     * 
     * @return void
     */
    public function scheduled_posts() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Count all scheduled posts
        $all_scheduled = $this->posts->count_all_scheduled_posts();
        
        // Count all unpublished scheduled posts
        $unpublished = $this->posts->count_all_scheduled_posts('unpublished');
        
        // Get first unpublished scheduled post
        $first_unpublished = $this->posts->get_first_unpublished_post();
        
        // Get the last unpublished scheduled post
        $last_scheduled = $this->posts->get_the_time_scheduled_post();
        
        $this->content = [
            'scheduled' => $all_scheduled,
            'unpublished' => $unpublished,
            'first_unpublished' => $first_unpublished,
            'last_scheduled' => $last_scheduled
        ];
        
        // Get auto-publish template
        $this->body = 'admin/auto-publish';
        $this->admin_layout();
        
    }

    /**
     * The public method notifications displays notifications page
     * 
     * @return void
     */
    public function notifications() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get templates
        $templates = $this->notifications->get_templates(1);
        
        // Get all notifications
        $notifications = $this->notifications->get_templates(0);
        
        $this->content = [
            'templates' => $templates,
            'notifications' => $notifications
        ];
        
        // Get notifications template
        $this->body = 'admin/notifications';
        
        $this->admin_layout();
        
    }

    /**
     * The public method users displays users page
     * 
     * @return void
     */
    public function users() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get all plans
        $get_plans = $this->plans->get_all_plans(1);
        
        // Get users template
        $this->body = 'admin/users';
        
        $this->content = [
            'plans' => $get_plans
        ];
        
        $this->admin_layout();
        
    }

    /**
     * The public method new_user displays new user page
     * 
     * @return void
     */
    public function new_user() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get new user template
        $this->body = 'admin/new-user';
        $this->admin_layout();
    }
    
    /**
     * The public method ajax is universal caller for default user ajax calls
     * 
     * @param string $name contains the helper name
     * 
     * @return void
     */
    public function ajax($name) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Verify if helper exists
        if ( file_exists( APPPATH . 'helpers/' . $name . '_helper.php' ) ) {
            
            // Get action's get input
            $action = $this->input->get('action');

            if ( !$action ) {
                $action = $this->input->post('action');
            }

            try {

                // Load Helper
                $this->load->helper($name . '_helper');
                
                // Call the function
                $action();

            } catch (Exception $ex) {

                $data = array(
                    'success' => FALSE,
                    'message' => $ex->getMessage()
                );

                echo json_encode($data);

            }
            
        } else {
            
            show_error('Invalid parameters');
            
        }
        
    }

    /**
     * The public method set_option enables and disables an option
     *
     * @param string $option_name contains the option name
     * 
     * @return void
     */
    public function set_option($option_name, $value = null) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        if ( $value ) {
            
            // Enable and add value to an option
            $value = str_replace('-', '/', $value);
            
            $value = $this->security->xss_clean(base64_decode($value));
            
            if ( $this->options->add_option_value($option_name, $value) ) {
                
                echo json_encode(1);
                
            } else {
                
                display_mess();
                
            }
            
        } else {
            
            // Enable or disable the $option_name option
            if ( $this->options->enable_or_disable_network($option_name) ) {
                
                echo json_encode(1);
                
            } else {
                
                display_mess();
                
            }
            
        }
        
    }


    
    /**
     * The public method appearance displays the appearance's page
     * 
     * @return void
     */
    public function appearance() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get all options
        $options = $this->options->get_all_options();

        $this->content = [
            'options' => $options
        ];
        
        // Get the appearance page
        $this->body = 'admin/appearance';
        $this->admin_layout();
        
    }
    
    /**
     * The public method payment displays the network single page.
     *
     * @param string $gateway contains the gateway's name
     * 
     * @return void
     */
    public function payment($gateway) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);  
        
        $class = [];
        
        if ( $gateway ) {
            
            // Get all available payment gateways
            include_once APPPATH . 'interfaces/Payments.php';
                
            if ( file_exists(APPPATH . 'payments/' . ucfirst($gateway) . '.php') ) {

                // Require the class
                require_once APPPATH . 'payments/' . ucfirst($gateway) . '.php';
                
                $gateway = ucfirst($gateway);

                // Call the class
                $get = new $gateway;

                // Get class info
                $class = $get->info();

            }
            
        }

        $this->body = 'admin/gateway';
        
        $this->content = [
            'gateway' => $gateway,
            'class' => $class
        ];
        
        $this->admin_layout();
        
    }

    /**
     * The public method get_notifications gets all sent notifications
     * 
     * @return void
     */
    public function get_notifications() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Get all notifications
        $get_notifications = $this->notifications->get_templates(0);
        
        if ( $get_notifications ) {
            
            echo json_encode([
                'notification' => $get_notifications,
                'time' => time()
            ]);
            
        }
        
    }

    /**
     * The public method get_notification gets notifications by id
     *
     * @param integer $notification_id contains the notification's id
     * 
     * @return void
     */
    public function get_notification($notification_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Get notification data by $notification_id
        $get_notification = $this->notifications->get_notification($notification_id);
        
        if ( $get_notification ) {
            
            echo json_encode($get_notification);
            
        }
        
    }

    /**
     * The public method del_notification deletes a notification by $notification_id
     *
     * @param integer $notification_id contains the notification's id
     * 
     * @return void
     */
    public function del_notification($notification_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Get notification data by $notification_id
        $del_notification = $this->notifications->del_notification_completely($notification_id);
        
        if ( $del_notification ) {
            
            display_mess(11);
            
        } else {
            
            display_mess();
            
        }
        
    }

    /**
     * The public method notification updates or saves a new notification
     * 
     * @return void
     */
    public function notification() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('body', 'Body', 'trim|required');
            $this->form_validation->set_rules('template', 'Template', 'trim');
            
            // Get data
            $title = str_replace('-', '/', $this->input->post('title'));
            $body = str_replace('-', '/', $this->input->post('body'));
            $title = $this->security->xss_clean(base64_decode($title));
            $body = htmlspecialchars_decode($this->security->xss_clean(base64_decode($body)));
            $template = $this->input->post('template');
            
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                display_mess(7);
                
            } else {
                
                if ( $this->notifications->update_msg($title, $body, $template) ) {
                    
                    if ( $template ) {
                        
                        display_mess(9);
                        
                    } else {
                        
                        // Check if admin wants to send notification via email
                        if ( $this->options->check_enabled('enable-notifications-email') == false ) {
                            
                            display_mess(76);
                            
                        } else {
                            
                            // Gets all user's email that want to receive notifications by email
                            $emails = $this->user->get_all_user_email_for_notifications();
                            
                            $i = 0;
                            
                            if ( $emails ) {
                                
                                foreach ( $emails as $email ) {
                                    
                                    // Sends to getted emails
                                    $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                                    $this->email->to($email->email);
                                    $this->email->subject($title);
                                    $this->email->message($body);
                                    
                                    if ( $this->email->send() ) {
                                        
                                        $i ++;
                                        
                                    }
                                    
                                }
                                
                            }
                            
                            if ( $i > 0 ) {
                                
                                display_mess(10, $i);
                                
                            } else {
                                
                                display_mess(76);
                                
                            }
                            
                        }
                        
                    }
                    
                } else {
                    
                    display_mess(8);
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method user_info gets user data by $user_id
     *
     * @param integer $user_id is the user's id
     * 
     * @return void
     */
    public function user_info($user_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        $getdata = $this->user->get_user_info($user_id);
        
        if ( $getdata ) {
            
            echo json_encode([
                'msg' => $getdata,
                'user_id' => $this->user_id
            ]);
            
        }
        
    }

    /**
     * The public method delete_user deletes an user by $user_id
     *
     * @param integer $user_id is the user's id
     * 
     * @return void
     */
    public function delete_user($user_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Check if user want delete his own account
        if ( $this->user_id == $user_id ) {
            return false;
        }
        
        // Require the base class
        $this->load->file(APPPATH . 'base/main.php');

        defined('MIDRUB_BASE_USER') OR define('MIDRUB_BASE_USER', APPPATH . 'base/user/');

        // List all apps
        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $dir) {

            $app_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Delete user's data
            (new $cl())->delete_account($user_id);

        }
        
        // Delete connected social accounts
        $this->networks->delete_network('all', $user_id);
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load Tickets Model
        $this->load->model('tickets');
        
        // Load Media Model
        $this->load->model('media');
        
        // Get all user medias
        $getmedias = $this->media->get_user_medias($user_id, 0, 1000000);
      
        // Verify if user has media and delete them
        if ( $getmedias ) {
            
            foreach( $getmedias as $media ) {
                $this->delete_media($user_id, $media->media_id);
            }
            
        }
        
        // Load Team Model
        $this->load->model('team');
        
        // Delete the user's team
        $this->team->delete_members( $user_id );
        
        // Load Activities Model
        $this->load->model('activities');
        
        // Delete the user's activities
        $this->activities->delete_activity( $user_id, 0 ); 
        
        // Delete user account
        $result = $this->user->delete_user($user_id);
        
        if ( $result ) {
            
            echo json_encode(array(
                'success' => TRUE,
                'message' => $this->lang->line('mm61')
            ));
            
        } else {
            
            echo json_encode(array(
                'success' => FALSE,
                'message' => $this->lang->line('mm68')
            )); 
            
        }
        
    }
    
    /**
     * The public method delete_media deletes user's media
     *
     * @param integer $user_id is the user's id
     * @param integer $media_id contains the media's ID
     * 
     * @return void
     */
    public function delete_media( $user_id, $media_id ) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role, 1 );
        
        // Load Media Model
        $this->load->model('media');
        
        // Get media
        $get_media = $this->media->single_media($user_id, $media_id);
        
        // Verify if the user is owner of the media
        if ( $get_media ) {
            
            if ( $this->media->delete_media($user_id, $media_id) ) {
                
                // Get file path
                $filename = str_replace(base_url(), FCPATH, $get_media[0]->body);
                
                try {
                    
                    // Get file data
                    $info = new SplFileInfo( $filename );                    
                
                    // Delete file 
                    @unlink($filename);
                    
                    // Delete cover
                    @unlink( str_replace('.' . $info->getExtension(), '-cover.png', $filename) );
                    
                    // Verify if the file was deleted
                    if ( !file_exists($filename) ) {
                        
                        // Get file size
                        $file_size = $get_media[0]->size;
                        
                        // Get user storage
                        $user_storage = get_user_option('user_storage', $user_id);
                        
                        $total_storage = $user_storage - $file_size;
                        
                        // Update the user storage
                        update_user_option( $user_id, 'user_storage', $total_storage );
                        
                    }
                
                } catch ( Exception $e ) {
                
                }
                
            }
            
        }
        
    }

    /**
     * The public method show_users displays users from database
     *
     * @param integer $page is the number of page
     * @param integer $order contains the order param
     * @param string $search is the search key
     * 
     * @return void
     */
    public function show_users( $page, $order, $search = null ) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session();
        if ( $this->user_role == 0 ) {
            
            return false;
            
        }
        
        // This function display users
        $page --;
        $limit = 10;
        $total = $this->user->count_all_users($search);
        $get_users = $this->user->get_users($page * $limit, $limit, $order, $search);
        if ( $get_users ) {
            
            $data = [
                'total' => $total,
                'users' => $get_users
            ];
            
            echo json_encode($data);
            
        }
        
    }

    /**
     * The public method search_users searches users
     *
     * @param integer $order contains the order param
     * @param string $search is the search key
     * 
     * @return void
     */
    public function search_users( $order, $search ) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        $page = 0;
        $limit = 10;
        $total = $this->user->count_all_users($search);
        $get_users = $this->user->get_users($page * $limit, $limit, $order, $search);
        
        if ( $get_users ) {
            
            $data = [
                'total' => $total,
                'users' => $get_users
            ];
            echo json_encode($data);
            
        }
        
    }

    /**
     * The public method update_user updates or changes data and user's plan if is different than current user's plan
     * 
     * @return void
     */
    public function update_user() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('first_name', 'First Name', 'trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('proxy', 'Proxy', 'trim');
            $this->form_validation->set_rules('role', 'Role', 'integer');
            $this->form_validation->set_rules('user_id', 'User ID', 'integer');
            $this->form_validation->set_rules('status', 'Status', 'integer');
            $this->form_validation->set_rules('plan', 'Plan', 'integer');
            
            // Get data
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $role = $this->input->post('role');
            $user_id = $this->input->post('user_id');
            $status = $this->input->post('status');
            $plan = $this->input->post('plan');
            $proxy = $this->input->post('proxy');
            
            // The admin can't changes this role or status
            if ( $this->user_id == $user_id ) {
                
                $role = 1;
                $status = 1;
                
            }
            
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                display_mess(16);
                
            } else {
                
                if ( $this->user->check_email($email, $user_id) == true ) {
                    
                    // Check if the email address are present in our database
                    display_mess(57);
                    
                } else {
                    
                    $r = 0;
                    if ( $this->user->updateuser($user_id, $first_name, $last_name, $email, $password, $role, $status, $plan, $proxy) ) {
                        
                        $this->user->delete_user_option($user_id, 'nonpaid');
                        
                        display_mess(58);
                        $r++;
                        
                    }
                    
                    if ( $r == 0 ) {
                        
                        if ( $proxy ) {
                            
                            if ( $this->user->update_proxy($user_id, $proxy) ) {
                                
                                display_mess(58);
                                
                            } else {
                                
                                display_mess(59);
                                
                            }
                            
                        } else {
                            
                            display_mess(59);
                            
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method create_user creates an user
     * 
     * @return void
     */
    public function create_user() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('first_name', 'First Name', 'trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('role', 'Role', 'integer');
            $this->form_validation->set_rules('sendpass', 'Send Password', 'integer');
            $this->form_validation->set_rules('plan', 'Plan', 'integer');
            
            // Get data
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $role = $this->input->post('role');
            $sendpass = $this->input->post('sendpass');
            $plan = $this->input->post('plan');
            
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                display_mess(33);
                
            } else {
                
                // Check if the password has less than six characters
                if ( (strlen($username) < 6) || (strlen($password) < 6) ) {
                    
                    display_mess(34);
                    
                } elseif ( preg_match('/\s/', $username) || preg_match('/\s/', $password) ) {
                    
                    // Check if the username or password contains white spaces
                    display_mess(35);
                    
                } elseif ( $this->user->check_email($email) ) {
                    
                    // Check if the email address are present in our database
                    display_mess(60);
                    
                } elseif ( $this->user->check_username($username) ) {
                    
                    // Check if the username are present in our database
                    display_mess(37);
                    
                } else {
                    
                    if ( $this->user->signup( $first_name, $last_name, $username, $email, $password, 1, $role ) ) {
                        
                        // The username and password will be send via email
                        if ( $sendpass == 1 ) {
                            
                            $args = [
                                '[username]' => $username,
                                '[password]' => $password,
                                '[site_name]' => $this->config->item('site_name'),
                                '[login_address]' => $this->config->item('login_url'),
                                '[site_url]' => $this->config->base_url()
                            ];
                            
                            // Get the send-password-new-users notification template
                            $template = $this->notifications->get_template('send-password-new-users', $args);
                            
                            if ( $template ) {
                                
                                $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                                $this->email->to($email);
                                $this->email->subject($template ['title']);
                                $this->email->message($template ['body']);
                                
                                if ( $this->email->send() ) {
                                    
                                    display_mess(61);
                                    
                                } else {
                                    
                                    display_mess(62);
                                    
                                }
                                
                            } else {
                                
                                display_mess(18);
                                
                            }
                            
                        } else {
                            
                            display_mess(63);
                            
                        }
                        
                    } else {
                        
                        display_mess(64);
                        
                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method upmedia uploads media files using ajax
     * 
     * @return void
     */
    public function upmedia() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // The background can be a video or an image
        $allowedimageformat = ($_POST ['media-name'] == 'login-bg') ? [
            'gif',
            'png',
            'jpg',
            'jpeg',
            'avi',
            'mp4',
            'webm'
                ] : [
            'gif',
            'png',
            'jpg',
            'jpeg',
            'ico'
        ];
        
        $format = pathinfo($_FILES ['file'] ['name'], PATHINFO_EXTENSION);
        
        if ( !in_array($format, $allowedimageformat) ) {
            
            echo ($_POST ['media-name'] == 'login-bg') ? 2 : 1;
            die();
            
        }
        
        $config ['upload_path'] = 'assets/img';
        
        $config ['file_name'] = time();
        
        $this->load->library('upload', $config);
        
        $this->upload->initialize($config);
        
        $this->upload->set_allowed_types('*');
        
        $data ['upload_data'] = '';
        
        if ( $this->upload->do_upload('file') ) {
            
            // Delete old media file
            $old_url = get_option($_POST ['media-name']);
            
            if ( $old_url ) {
                
                $url = str_replace($this->config->base_url(), '', $old_url);
                // Check if old file exist and delete it
                if ( file_exists($url) ) {
                    
                    unlink($url);
                    
                }
                
            }
            
            // Get information about uploaded file
            $data ['upload_data'] = $this->upload->data();
            
            $this->options->set_media_option($_POST ['media-name'], $this->config->base_url() . 'assets/img/' . $data ['upload_data'] ['file_name']);
            
            if ( !in_array($format, [
                        'avi',
                        'mp4',
                        'webm'
                    ])) {
                
                echo '<img src="' . $this->config->base_url() . 'assets/img/' . $data ['upload_data'] ['file_name'] . '" class="thumbnail" />';
                
            } else {
                
                echo '<video autoplay="" loop="" class="fillWidth fadeIn wow collapse in" id="video-background" width="187"><source src="' . $this->config->base_url() . 'assets/img/' . $data ['upload_data'] ['file_name'] . '" type="video/mp4"></video>';
                
            }
            
        }
        
    }

    /**
     * The public method get_statistics gets statistics and display in the admin dashboard
     *
     * @param integer $num contains the period number
     * 
     * @return void
     */
    public function get_statistics($num) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        // This function get statistics by $num
        $statistics = generate_admin_statstics($num, $this->user->get_last_users($num));
        
        if ( $statistics ) {
            
            echo json_encode($statistics);
            
        }
        
    }

    /**
     * The public method check_update checks if an update are available
     * 
     * @return void
     */
    public function check_update() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);
        
        $l_version = '';
        
        if ( file_exists('update.json') ) {
            
            $get_last = file_get_contents('update.json');
            $from = json_decode($get_last, true);
            unset($decode);
            $l_version = $from ['version'];
            
        }
        
        // Check if the update file is available
        $update_url = 'https://update.midrub.com/';
        
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 30
            )
        ));
        
        $update_down = @file_get_contents($update_url, 0, $context);
        
        $new_update = '';
        
        if ( $update_down ) {
            
            $from = json_decode($update_down, true);
            
            unset($update_down);
            
            // Check if the last version is equal to the current version
            if ( $from ['version'] != $l_version ) {
                
                // Set update option available. In this way the script will not check if an update available every time when will be loaded a page.
                if ( $this->options->check_enabled('update') == false ) {
                    
                    $this->options->enable_or_disable_network('update');
                    
                }
                
                // Return update information
                return $from;
                
            }
            
        }
        
        return false;
        
    }

}

/* End of file Adminarea.php */
