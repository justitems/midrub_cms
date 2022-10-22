<?php
/**
 * Social Controller
 *
 * This file connects user by using networks
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Auth\Collection\Signin\Controllers;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Require the Get Inc file
require_once CMS_BASE_PATH . 'inc/curl/get.php';   

// Require the Post Inc file
require_once CMS_BASE_PATH . 'inc/curl/post.php';   

/*
 * Social class connects user by using networks
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Social {
    
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
        
        // Load the component's language files
        $this->CI->lang->load( 'auth_signin', $this->CI->config->item('language'), FALSE, TRUE, CMS_BASE_AUTH_SIGNIN );

        // Load Base Contents Model
        $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_auth_social', 'base_auth_social');
        
    }
    
    /**
     * The public method connect redirects user to the network
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.8.5
     * 
     * @return void
     */
    public function connect($network) {

        // Verify if network exists
        if ( !file_exists(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !md_the_option('auth_network_' . strtolower($network) . '_enabled') ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_enabled'));
            exit();

        }

        // Require network
        require_once CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php';

        // Create an array
        $array = array(
            'CmsBase',
            'Admin',
            'Components',
            'Collection',
            'Frontend',
            'Networks',
            'Collection',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_configured'));
            exit();            

        }

        // Set the sign in page
        $sign_in = md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin');

        // Redirect user
        (new $cl())->connect($sign_in . '/' . $network);
        
    }

    /**
     * The public method login tries to login the user
     * 
     * @param string $network contains the name of the network
     * 
     * @since 0.0.8.5
     * 
     * @return array with error message or void
     */
    public function login($network) {

        // Verify if network exists
        if ( !file_exists(CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php') ) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_available'));
            exit();

        }

        // Verify if option is enabled
        if ( !md_the_option('auth_network_' . strtolower($network) . '_enabled') ) {
            
            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_enabled'));
            exit();

        }

        // Require network
        require_once CMS_BASE_PATH . 'admin/components/collection/frontend/networks/collection/' . $network . '.php';

        // Create an array
        $array = array(
            'CmsBase',
            'Admin',
            'Components',
            'Collection',
            'Frontend',
            'Networks',
            'Collection',
            ucfirst($network)
        );

        // Implode the array above
        $cl = implode('\\', $array);

        // Verify if network is configured
        if (!(new $cl())->availability()) {

            echo str_replace('(network)', ucfirst($network), $this->CI->lang->line('auth_signin_network_not_configured'));
            exit();            

        }

        // Params array
        $params = array();

        // Set the sign in page
        $sign_in = md_the_url_by_page_role('sign_in') ? md_the_url_by_page_role('sign_in') : site_url('auth/signin');

        // Try to login
        $user_data = (new $cl())->callback($sign_in . '/' . $network);

        // Verify if login is success
        if ( $user_data['success'] ) {

            // Load Base Model
            $this->CI->load->ext_model(CMS_BASE_PATH . 'models/', 'Base_users', 'base_users');

            // Load Base Plans Model
            $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_plans', 'base_plans' );

            // Verify if user's data exists
            if ( isset($user_data['data']) ) {

                // Verify if account's ID exists
                if ( isset($user_data['data']['net_id']) ) {

                    // Get user
                    $get_user = $this->CI->base_model->the_data_where(
                        'users_social',
                        'users.user_id, users.username',
                        array(
                            'users_social.network_name' => $user_data['data']['network_name'],
                            'users_social.net_id' => $user_data['data']['net_id']
                        ),
                        array(),
                        array(),
                        array(array(
                            'table' => 'users',
                            'condition' => 'users_social.user_id=users.user_id',
                            'join_from' => 'LEFT'
                        ))
                    );

                    // Verify if the user was found
                    if ( $get_user ) {

                        // Register session
                        $this->CI->session->set_userdata('username', $get_user[0]['username']);

                        // Get user data
                        $user_data = $this->CI->base_users->get_user_data_by_username($this->CI->session->userdata['username']);

                        // Get the user's plan
                        $user_plan = md_the_user_option($get_user[0]['user_id'], 'plan');
                        
                        // Verify if user has a plan, if no add default plan
                        if (!$user_plan) {

                            // Get the plan
                            $plan_data = $this->CI->base_model->the_data_where(
                                'plans',
                                '*',
                                array(
                                    'plan_id' => 1
                                )
                            );

                            // Verify if plan exists
                            if ( $plan_data ) {

                                // Change the plan
                                $this->CI->base_plans->change_plan(array(
                                    'plan_id' => 1,
                                    'user_id' => $get_user[0]['user_id'],
                                    'period' => $plan_data[0]['period']
                                ));

                            }
                            
                        }

                        // Default redirect
                        $redirect = $this->get_plan_redirect($get_user[0]['user_id']);

                        // Redirect to the dashboard app
                        redirect($redirect);                        

                    } else {

                        // Verify if email exists
                        if ( !empty($user_data['data']['email']) ) {

                            // Get the team member by email
                            $the_team_member_email = $this->CI->base_model->the_data_where(
                                'teams',
                                '*',
                                array(
                                    'member_email' => trim($user_data['data']['email'])
                                )
                            );

                            // Get the user by email
                            $the_user_email = $this->CI->base_model->the_data_where(
                                'users',
                                '*',
                                array(
                                    'email' => trim($user_data['data']['email'])
                                )
                            );

                            // Get the user by username
                            $the_user_username = $this->CI->base_model->the_data_where(
                                'users',
                                '*',
                                array(
                                    'username' => trim($user_data['data']['email'])
                                )
                            );

                            // Verify if another user has this email
                            if ( empty($the_team_member_email) && empty($the_user_email) && empty($the_user_username) ) {

                                // Create $user_args array
                                $user_args = array();

                                // Set the user name
                                $user_args['username'] = $user_data['data']['email'];

                                // Set the email
                                $user_args['email'] = $user_data['data']['email'];

                                // Set the password
                                $user_args['password'] = md5(time());

                                // Set the default role
                                $user_args['role'] = 0;

                                // Set first name
                                $user_args['first_name'] = $user_data['data']['user_name'];

                                // Set last name
                                $user_args['last_name'] = '';

                                // Set the default status
                                $user_args['status'] = 1;

                                // Set date when user joined
                                $user_args['date_joined'] = date('Y-m-d H:i:s');

                                // Set user's ip
                                $user_args['ip_address'] = $this->CI->input->ip_address();

                                // Save the user
                                $user_id = $this->CI->base_model->insert('users', $user_args);

                                // Verify if user has signed up successfully
                                if ( $user_id ) {

                                    // Account parameters
                                    $account_params = array(
                                        'user_id' => $user_id,
                                        'network_name' => $network,
                                        'net_id' => $user_data['data']['net_id'],
                                        'user_name' => $user_data['data']['user_name'],
                                        'created' => time()
                                    );

                                    // Save the account
                                    $save = $this->CI->base_model->insert(
                                        'users_social',
                                        $account_params
                                    );

                                    // Verify if the social account was saved
                                    if ( $save ) {

                                        // Get the plan
                                        $plan_data = $this->CI->base_model->the_data_where(
                                            'plans',
                                            '*',
                                            array(
                                                'plan_id' => 1
                                            )
                                        );

                                        // Verify if plan exists
                                        if ( $plan_data ) {

                                            // Change the plan
                                            $change_plan = $this->CI->base_plans->change_plan(array(
                                                'plan_id' => 1,
                                                'user_id' => $user_id,
                                                'period' => $plan_data[0]['period']
                                            ));

                                            // Verify if the plan was changed
                                            if ( $change_plan ) {

                                                // Metas container
                                                $metas = array(
                                                    array(
                                                        'meta_name' => 'event_scope',
                                                        'meta_value' => $user_id
                                                    ),
                                                    array(
                                                        'meta_name' => 'title',
                                                        'meta_value' => $user_data['data']['user_name'] . ' ' . $this->CI->lang->line('auth_has_been_joined')
                                                    ),
                                                    array(
                                                        'meta_name' => 'font_icon',
                                                        'meta_value' => 'member_add'
                                                    )
                                                    
                                                );

                                                // Create the event
                                                md_create_admin_dashboard_event(
                                                    array(
                                                        'event_type' => 'new_member',
                                                        'metas' => $metas
                                                    )

                                                );

                                                // Register session
                                                $this->CI->session->set_userdata('username', $user_data['data']['email']);

                                                // Get user data
                                                $user_data = $this->CI->base_users->get_user_data_by_username($this->CI->session->userdata['username']);

                                                // Default redirect
                                                $redirect = $this->get_plan_redirect($user_id);

                                                // Redirect to the dashboard app
                                                redirect($redirect);  

                                            } else {

                                                // Delete the user
                                                $this->CI->base_model->delete(
                                                    'users_social',
                                                    array(
                                                        'user_id' => $user_id
                                                    )
                                                );

                                                // Delete the connection
                                                $this->CI->base_model->delete(
                                                    'users_social',
                                                    array(
                                                        'user_id' => $user_id
                                                    )
                                                );

                                                // Set error message
                                                $params['message'] = $this->CI->lang->line('auth_no_account_found');

                                            }

                                        } else {

                                            // Delete the user
                                            $this->CI->base_model->delete(
                                                'users_social',
                                                array(
                                                    'user_id' => $user_id
                                                )
                                            );

                                            // Delete the connection
                                            $this->CI->base_model->delete(
                                                'users_social',
                                                array(
                                                    'user_id' => $user_id
                                                )
                                            );

                                            // Set error message
                                            $params['message'] = $this->CI->lang->line('auth_no_account_found');

                                        }

                                    } else {

                                        // Delete the user
                                        $this->CI->base_model->delete(
                                            'users',
                                            array(
                                                'user_id' => $user_id
                                            )
                                        );

                                        // Set error message
                                        $params['message'] = $this->CI->lang->line('auth_no_account_found');
        
                                    }

                                } else {

                                    // Set error message
                                    $params['message'] = $this->CI->lang->line('auth_no_account_found');

                                }

                            } else {

                                // Set error message
                                $params['message'] = $this->CI->lang->line('auth_no_account_found');
                                
                            }

                        } else {

                            // Set error message
                            $params['message'] = $this->CI->lang->line('auth_no_account_found');

                        }
        
                    }

                } else {

                    // Set error message
                    $params['message'] = $this->CI->lang->line('auth_no_account_found');
    
                }

            } else {

                // Set error message
                $params['message'] = $user_data['message'];

            }

            // Get component's title
            $title = (md_the_single_content_meta('quick_seo_page_title'))?md_the_single_content_meta('quick_seo_page_title'):$this->CI->lang->line('auth_signin_sign_in_title');

            // Set page's title
            md_set_the_title($title);

            // Set styles
            md_set_css_urls(array('stylesheet', base_url('assets/base/auth/collection/signin/styles/css/styles.css?ver=' . CMS_BASE_AUTH_SIGNIN_VERSION), 'text/css', 'all'));

            // Set Font Awesome
            md_set_css_urls(array('stylesheet', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css', 'text/css', 'all'));

            // Set javascript links
            md_set_js_urls(array(base_url('assets/base/auth/collection/signin/js/main.js?ver=' . CMS_BASE_AUTH_SIGNIN_VERSION)));

            // Verify if meta description exists
            if ( md_the_single_content_meta('quick_seo_meta_description') ) {

                // Set meta description
                md_set_the_meta_description(md_the_single_content_meta('quick_seo_meta_description'));

            }

            // Verify if meta keywords exists
            if ( md_the_single_content_meta('quick_seo_meta_keywords') ) {

                // Set meta keywors
                md_set_the_meta_keywords(md_the_single_content_meta('quick_seo_meta_keywords'));

            }

            /**
             * The public method md_set_hook registers a hook
             * 
             * @since 0.0.8.5
             */
            md_set_hook(
                'the_frontend_header',
                function () {

                    // Get header code
                    $header = md_the_option('frontend_header_code');

                    // Verify if header code exists
                    if ( $header ) {

                        // Show code
                        echo $header;

                    }

                    echo "<!-- Bootstrap CSS -->\n";
                    echo "    <link rel=\"stylesheet\" href=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css\">\n";

                }
            );

            /**
             * The public method md_set_hook registers a hook
             * 
             * @since 0.0.8.5
             */
            md_set_hook(
                'the_frontend_footer',
                function () {

                    // Get footer code
                    $footer = md_the_option('frontend_footer_code');

                    // Verify if footer code exists
                    if ( $footer ) {

                        // Show code
                        echo $footer;

                    }

                    echo "<script src=\"" . base_url("assets/js/jquery.min.js") . "\"></script>\n";
                    echo "<script src=\"//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js\"></script>\n";
                    echo "<script src=\"//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js\"></script>\n";
                    echo "<script src=\"" . base_url("assets/js/main.js?ver=" . MD_VER) . "\"></script>\n";

                }

            );

            // Making temlate and send data to view.
            $this->CI->template['header'] = $this->CI->load->ext_view(CMS_BASE_AUTH_SIGNIN .  'views/layout', 'header', array(), true);
            $this->CI->template['body'] = $this->CI->load->ext_view(CMS_BASE_AUTH_SIGNIN .  'views', 'main', $params, true);
            $this->CI->template['footer'] = $this->CI->load->ext_view(CMS_BASE_AUTH_SIGNIN .  'views/layout', 'footer', array(), true);
            $this->CI->load->ext_view(CMS_BASE_AUTH_SIGNIN . 'views/layout', 'index', $this->CI->template);

        } else {

            return $user_data;

        }
        
    }

    /**
     * The private method get_plan_redirect gets redirect for the user plan
     * 
     * @param integer $user_id contains the user's id
     * 
     * @since 0.0.8.2
     * 
     * @return string with redirect's url
     */
    private function get_plan_redirect($user_id) {

        // Verify if required redirect exists
        if ( $this->CI->session->userdata('required_redirect') ) {

            // Set required redirect
            $redirect = base_url($this->CI->session->userdata('required_redirect'));

            // Delete the required redirect
            $this->CI->session->unset_userdata('required_redirect');

            return $redirect;

        }
        
        // Get the user's plan
        $plan_id = md_the_user_option($user_id, 'plan');

        // Redirect url
        $redirect_url = base_url('user/app/dashboard');

        // Verify if the plan has a selected user_redirect
        if ( md_the_plan_feature( 'user_redirect', $plan_id ) ) {

            // Get user_redirect
            $user_redirect = md_the_plan_feature( 'user_redirect', $plan_id );

            // Verify if the redirect is a component
            if ( is_dir(CMS_BASE_USER . 'components/collection/' . $user_redirect . '/') ) {

                // Set new redirect
                $redirect_url = site_url('user/' . $user_redirect);

            } else if ( is_dir(CMS_BASE_USER . 'apps/collection/' . $user_redirect . '/') ) {

                // Set new redirect
                $redirect_url = site_url('user/app/' . $user_redirect);

            }
            
        }
        
        // Return the redirect
        return $redirect_url;
        
    }

}

/* End of file social.php */