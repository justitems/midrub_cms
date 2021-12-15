<?php
/**
 * Cron Controller
 *
 * PHP Version 7.3
 *
 * Cron contains the Cron Controller
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Constants
defined('BASEPATH') OR exit('No direct script access allowed');
defined('CMS_BASE_USER') OR define('CMS_BASE_USER', APPPATH . 'base/user/');

/**
 * Cron class - runs all Midrub's cron jobs commands
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Cron extends CI_Controller {

    /**
     * Class variables
     *
     * @since 0.0.8.1
     */
    protected $CI;
    
    public function __construct() {
        parent::__construct();

        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
    }
    
    /**
     * The public method run is called to run all Midrub's cron jobs
     * 
     * @return void
     */
    public function run() {
        
        // Require the base class
        $this->load->file(APPPATH . '/base/main.php');

        // Load Base Model
        $this->CI->load->ext_model( CMS_BASE_PATH . 'models/', 'Base_model', 'base_model' );

        // Call the section class
        new CmsBase\CmsBase('init');

        // List all user's apps
        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Verify if the app is enabled
            if (!md_the_option('app_' .  $app . '_enabled')) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Run cron job commands
            (new $cl())->cron_jobs();

        }
        
        // Prepare allowed files
        $allowed_files = array(
            'cron.php',
            'index.php'
        );
        
        // List all files
        foreach (glob(FCPATH . '/*.php') as $filename) {
            
            $name = str_replace(FCPATH . '/', '', $filename);

            if ( !in_array($name, $allowed_files) ) {
                
                $msg = 'Was detected and deleted the file ' . $filename . '. Please contact support if you don\'t know this file.';
                
                $this->send_warning_message($msg);
                unlink($filename);
                
            } else {
                
                if ( $this->check_for_malware($filename) ) {
                    
                    $msg = 'Was detected malware in the file ' . $filename . ' and was deleted.';

                    $this->send_warning_message($msg);
                    unlink($filename);
                    
                }
                
            }
            
        }

        // Verifies if update exists
        if ( !md_the_option('cron_update_verify') ) {

            // Verify for updates
            $this->check_for_updates();

        } elseif ( md_the_option('cron_update_verify') !== date('Y-m-d') ) {

            // Verify for updates
            $this->check_for_updates();            

        } elseif ( !md_the_option('cron_subscription_verify') ) {

            // Verify for subscriptions
            $this->check_for_subscriptions();            

        } elseif ( md_the_option('cron_subscription_verify') !== date('Y-m-d') ) {

            // Verify for subscriptions
            $this->check_for_subscriptions();            

        }
        
        $extensions = array(
            '.php3',
            '.php4',
            '.php5',
            '.php7',
            '.phtml',
            '.pht'
        );

        foreach ( $extensions as $ext ) {
            $this->delete_files_by_extension(FCPATH, $ext);   
        }
        
        $extensions[] = '.php';
        
        foreach ( $extensions as $ext ) {
            $this->delete_files_by_extension(FCPATH . 'assets', $ext);   
        }
        
        $this->check_for_non_midrub_files(FCPATH . 'assets');
        
    }
    
    /**
     * The protected method check_for_non_midrub_files verifies for non midrub's files
     * 
     * @param string $path contains the path to index
     * 
     * @return void
     */
    protected function check_for_non_midrub_files($path) {
        
        $dirs = scandir($path);

        unset($dirs[array_search('.', $dirs, true)]);
        unset($dirs[array_search('..', $dirs, true)]);

        if (count($dirs) < 1) {
            return;
        }


        foreach($dirs as $dir){
            
            if ( is_dir( $path . '/' . $dir ) ) {
                
                $extensions = array(
                    '.php',
                    '.php3',
                    '.php4',
                    '.php5',
                    '.php7',
                    '.phtml',
                    '.pht'
                );

                foreach ( $extensions as $ext ) {
                    $this->delete_files_by_extension($path . '/' . $dir, $ext);   
                }
                
                $this->check_for_non_midrub_files( $path . '/' . $dir );
                
            }
            
        }
        
    }
    
    /**
     * The protected delete_files_by_extension deletes all files by extension
     * 
     * @param string $path contains the dir path
     * @param string $ext the files extension
     * 
     * @return void
     */
    protected function delete_files_by_extension($path, $ext) {
        
        if ( glob($path . '/*' . $ext) ) {
        
            foreach (glob($path . '/*' . $ext) as $filename) {
                
                $msg = 'Was detected and deleted the file ' . $filename . '. Please contact support if you don\'t know this file.';
                
                $this->send_warning_message($msg);
                
                unlink($filename);
            }
        
        }
        
    } 
    
    /**
     * The protected check_for_malware verifies if a file has malware
     * 
     * @param string $file contains the file's path
     * 
     * @return boolean true or false
     */
    protected function check_for_malware($file) {
        
        header('Content-Type: text/plain');
        
        $contents = file_get_contents($file);
        
        $searchfor = 'base64';
        
        $pattern = preg_quote($searchfor, '/');
        
        $pattern = "/^.*$pattern.*\$/m";

        if (preg_match_all($pattern, $contents, $matches)) {
            return true;
        }
        
        $searchfor = 'eval';
        
        $pattern = preg_quote($searchfor, '/');
        
        $pattern = "/^.*$pattern.*\$/m";        
        
        if (preg_match_all($pattern, $contents, $matches)) {
            return true;
        }
        
        $searchfor = 'rawurldecode';
        
        $pattern = preg_quote($searchfor, '/');
        
        $pattern = "/^.*$pattern.*\$/m";        
        
        if (preg_match_all($pattern, $contents, $matches)) {
            return true;
        }        
        
        return false;
        
    } 
    
    /**
     * The protected send_warning_message sends alert by email
     * 
     * @param string $msg contains message to send
     * 
     * @return void
     */
    protected function send_warning_message($msg) {
        
        $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
        $this->email->to($this->config->item('notification_mail'));
        $this->email->subject('Unexpected files on your server');
        $this->email->message($msg);
        $this->email->send();
        
    }
    
    /**
     * The protected check_for_updates verifies if there are available updates
     * 
     * @return void
     */
    protected function check_for_updates() {

        // Save the today verification 
        md_update_option('cron_update_verify', date('Y-m-d'));
        
        // List all user's apps
        foreach (glob(APPPATH . 'base/user/apps/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $app = trim(basename($directory) . PHP_EOL);

            // Verify if update already is in the database
            $app_update = $this->CI->base_model->the_data_where('updates', '*', array(
                'slug' => $app,
                'type' => 'apps'
            ));

            if ( $app_update ) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Apps',
                'Collection',
                ucfirst($app),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get app's info
            $info = (new $cl())->app_info();

            // Verify if update's url exists
            if (  isset($info['update_url']) ) {

                // Current version
                $current_version = 0;

                // Verify if update.json exists
                if ( file_exists(APPPATH . 'base/user/apps/collection/' . $app . '/update.json') ) {
                
                    // Get content
                    $get_last = json_decode(file_get_contents(APPPATH . 'base/user/apps/collection/' . $app . '/update.json'), TRUE);

                    // Verify if version exists
                    if ( isset($get_last['version']) ) {

                        // Set version
                        $current_version = $get_last['version'];

                    }
                    
                }
                
                // Get update
                $update_down = json_decode(md_get($info['update_url']), TRUE);

                // New version variable
                $new_version = '';

                // Changelogs variable
                $changelogs = '';

                // Verify if update exists
                if ( $update_down ) {

                    // Verify if current version is not same as on server
                    if ( $update_down['version'] !== $current_version ) {

                        // Add update data
                        $update = array(
                            'slug' => $app,
                            'version' => $update_down['version'],
                            'body' => $update_down['changelogs'],
                            'type' => 'apps',
                            'created' => time()
                        );

                        // Insert update record
                        $this->CI->base_model->insert('updates', $update);

                    }
                    
                }

            }
            
        }

        // List all user's components
        foreach (glob(APPPATH . 'base/user/components/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the directory's name
            $component = trim(basename($directory) . PHP_EOL);

            // Verify if update already is in the database
            $component_update = $this->CI->base_model->the_data_where('updates', '*', array(
                'slug' => $component,
                'type' => 'user_components'
            ));

            if ( $component_update ) {
                continue;
            }

            // Create an array
            $array = array(
                'CmsBase',
                'User',
                'Components',
                'Collection',
                ucfirst($component),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Get component's info
            $info = (new $cl())->component_info();

            // Verify if update's url exists
            if (  isset($info['update_url']) ) {

                // Current version
                $current_version = 0;

                // Verify if update.json exists
                if ( file_exists(APPPATH . 'base/user/components/collection/' . $component . '/update.json') ) {
                
                    // Get content
                    $get_last = json_decode(file_get_contents(APPPATH . 'base/user/components/collection/' . $component . '/update.json'), TRUE);

                    // Verify if version exists
                    if ( isset($get_last['version']) ) {

                        // Set version
                        $current_version = $get_last['version'];

                    }
                    
                }
                
                // Get update
                $update_down = json_decode(md_get($info['update_url']), TRUE);

                // New version variable
                $new_version = '';

                // Changelogs variable
                $changelogs = '';

                // Verify if update exists
                if ( $update_down ) {

                    // Verify if current version is not same as on server
                    if ( $update_down['version'] !== $current_version ) {

                        // Add update data
                        $update = array(
                            'slug' => $component,
                            'version' => $update_down['version'],
                            'body' => $update_down['changelogs'],
                            'type' => 'user_components',
                            'created' => time()
                        );

                        // Insert update record
                        $this->CI->base_model->insert('updates', $update);

                    }
                    
                }

            }
            
        }

        // List all frontend's themes
        foreach (glob(APPPATH . 'base/frontend/themes/collection/*', GLOB_ONLYDIR) as $directory) {

            // Get the theme's name
            $theme = trim(basename($directory) . PHP_EOL);

            // Verify if update already is in the database
            $theme_update = $this->CI->base_model->the_data_where('updates', '*', array(
                'slug' => $theme,
                'type' => 'frontend_themes'
            ));

            if ( $theme_update ) {
                continue;
            }

            // Get theme's configuration
            $info = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/collection/' . $theme . '/config.json'), TRUE);

            // Verify if update's url exists
            if (  isset($info['update_url']) ) {

                // Current version
                $current_version = 0;

                // Verify if update.json exists
                if ( file_exists(APPPATH . 'base/frontend/themes/collection/' . $theme . '/update.json') ) {
                
                    // Get content
                    $get_last = json_decode(file_get_contents(APPPATH . 'base/frontend/themes/collection/' . $theme . '/update.json'), TRUE);

                    // Verify if version exists
                    if ( isset($get_last['version']) ) {

                        // Set version
                        $current_version = $get_last['version'];

                    }
                    
                }
                
                // Get update
                $update_down = json_decode(md_get($info['update_url']), TRUE);

                // New version variable
                $new_version = '';

                // Changelogs variable
                $changelogs = '';

                // Verify if update exists
                if ( $update_down ) {

                    // Verify if current version is not same as on server
                    if ( $update_down['version'] !== $current_version ) {

                        // Add update data
                        $update = array(
                            'slug' => $theme,
                            'version' => $update_down['version'],
                            'body' => $update_down['changelogs'],
                            'type' => 'frontend_themes',
                            'created' => time()
                        );

                        // Insert update record
                        $this->CI->base_model->insert('updates', $update);

                    }
                    
                }

            }
            
        }

        // Verify if update already is in the database
        $midrub_update = $this->CI->base_model->the_data_where('updates', '*', array(
            'slug' => 'midrub',
            'type' => 'system'
        ));

        if ( !$midrub_update ) {

            // Current version
            $current_version = 0;

            // Verify if update.json exists
            if ( file_exists('update.json') ) {
            
                // Get content
                $get_last = json_decode(file_get_contents('update.json'), TRUE);

                // Verify if version exists
                if ( isset($get_last['version']) ) {

                    // Set version
                    $current_version = $get_last['version'];

                }
                
            }
            
            // Get update
            $update_down = json_decode(md_get('https://update.midrub.com/0-0-8-4-b/'), TRUE);

            // New version variable
            $new_version = '';

            // Changelogs variable
            $changelogs = '';

            // Verify if update exists
            if ( $update_down ) {

                // Verify if current version is not same as on server
                if ( $update_down['version'] !== $current_version ) {

                    // Add update data
                    $update = array(
                        'slug' => 'midrub',
                        'version' => $update_down['version'],
                        'body' => $update_down['changelogs'],
                        'type' => 'system',
                        'created' => time()
                    );

                    // Insert update record
                    $this->CI->base_model->insert('updates', $update);

                }
                
            }

        }

        // Verify if plugins exists
        if ( glob(APPPATH . 'base/plugins/collection/*', GLOB_ONLYDIR) ) {

            // List all plugins
            foreach (glob(APPPATH . 'base/plugins/collection/*', GLOB_ONLYDIR) as $directory) {

                // Get the directory's name
                $plugin = trim(basename($directory) . PHP_EOL);

                // Verify if update already is in the database
                $plugin_update = $this->CI->base_model->the_data_where('updates', '*', array(
                    'slug' => $plugin,
                    'type' => 'plugins'
                ));

                if ( $plugin_update ) {
                    continue;
                }

                // Create an array
                $array = array(
                    'CmsBase',
                    'Plugins',
                    'Collection',
                    ucfirst($plugin),
                    'Main'
                );

                // Implode the array above
                $cl = implode('\\', $array);

                // Get plugin's info
                $info = (new $cl())->plugin_info();

                // Verify if update's url exists
                if (  isset($info['update_url']) ) {

                    // Current version
                    $current_version = 0;

                    // Verify if update.json exists
                    if ( file_exists(APPPATH . 'base/plugins/collection/' . $plugin . '/update.json') ) {
                    
                        // Get content
                        $get_last = json_decode(file_get_contents(APPPATH . 'base/plugins/collection/' . $plugin . '/update.json'), TRUE);

                        // Verify if version exists
                        if ( isset($get_last['version']) ) {

                            // Set version
                            $current_version = $get_last['version'];

                        }
                        
                    }
                    
                    // Get update
                    $update_down = json_decode(md_get($info['update_url']), TRUE);

                    // New version variable
                    $new_version = '';

                    // Changelogs variable
                    $changelogs = '';

                    // Verify if update exists
                    if ( $update_down ) {

                        // Verify if current version is not same as on server
                        if ( $update_down['version'] !== $current_version ) {

                            // Add update data
                            $update = array(
                                'slug' => $plugin,
                                'version' => $update_down['version'],
                                'body' => $update_down['changelogs'],
                                'type' => 'plugins',
                                'created' => time()
                            );

                            // Insert update record
                            $this->CI->base_model->insert('updates', $update);

                        }
                        
                    }

                }
                
            }

        }

        
    }

    /**
     * The protected check_for_subscriptions verifies for subscriptions
     * 
     * @return void
     */
    protected function check_for_subscriptions() {

        // Save the today verification 
        md_update_option('cron_subscription_verify', date('Y-m-d'));
        
        // Get soon or ended subscriptions
        $get_subscriptions = $this->CI->base_model->the_data_where('users_meta', 'users_meta.*, subscriptions.subscription_id', array(
            'users_meta.meta_name' => 'plan_end',
            'unix_timestamp(users_meta.meta_value) >'=> ( time() - 432000 )
        ),
        array(),
        array(),
        array(array(
            'table' => 'subscriptions',
            'condition' => 'users_meta.user_id=subscriptions.user_id',
            'join_from' => 'LEFT'
        )));

        // Verify if subscriptions were found
        if ( $get_subscriptions ) {

            // List subscriptions
            foreach ( $get_subscriptions as $get_subscription ) {

                // Verify if user has a subscription
                if ( $get_subscription['subscription_id'] ) {

                    // Expiration time
                    $expired = ceil((time() - strtotime($get_subscription['meta_value']))/86400);

                    // Verify if the subscription had expired
                    if ( time() > strtotime($get_subscription['meta_value']) ) {

                        // Get user's plan
                        $get_plan = $this->CI->base_model->the_data_where('users_meta', 'users_meta.meta_id,plans.*', array(
                            'users_meta.user_id' => $get_subscription['user_id'],
                            'users_meta.meta_name' => 'plan'
                        ),
                        array(),
                        array(),
                        array(array(
                            'table' => 'plans',
                            'condition' => 'users_meta.meta_value=plans.plan_id',
                            'join_from' => 'LEFT'
                        )));

                        // Verify if plan exists
                        if ( $get_plan ) {

                            // Use the base model for a simply sql query
                            $this->CI->base_model->update(
                                'users_meta',
                                array(
                                    'meta_id' => $get_subscription['meta_id']
                                ),
                                array(
                                    'meta_value' => date('Y-m-d H:i:s', (strtotime($get_subscription['meta_value']) + ($get_plan[0]['period'] * 86400)))
                                )
                            );

                        }

                    }

                    continue;

                }

                // Expiration time
                $expired = ceil((time() - strtotime($get_subscription['meta_value']))/86400);

                // Verify if the subscription had expired
                if ( time() > strtotime($get_subscription['meta_value']) ) {

                    // Run hook
                    md_run_hook('user_plan_subscription_expired_' . ceil((time() - strtotime($get_subscription['meta_value']))/86400), array('user_id' => $get_subscription['user_id']));

                } else {

                    // Run hook
                    md_run_hook('user_plan_subscription_expires_' . ceil((time() - strtotime($get_subscription['meta_value']))/86400), array('user_id' => $get_subscription['user_id']));

                }

            }

        }
        
    }
    
}

/* End of file Cron.php */
