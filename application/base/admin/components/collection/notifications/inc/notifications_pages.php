<?php
/**
 * Notifications Pages Functions
 *
 * PHP Version 7.3
 *
 * This files contains the admin's pages
 * methods used in admin -> notifications
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * The public method set_admin_notifications_page adds a notifications's page in the admin panel
 */
set_admin_notifications_page(
    'email_templates',
    array(
        'page_name' => get_instance()->lang->line('notifications_email_templates'),
        'page_icon' => md_the_admin_icon(array('icon' => 'email_templates')),
        'content' => 'get_admin_notifications_page_email_templates',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/notifications/styles/css/email-templates.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION), 'text/css', 'all'),
            array('stylesheet', '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css', 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/notifications/js/email-templates.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION)),
            array('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js')
        )  
    )
);

if ( !function_exists('get_admin_notifications_page_email_templates') ) {

    /**
     * The function get_admin_notifications_page_email_templates displays the All notifications page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function get_admin_notifications_page_email_templates() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify which page should be displayed
        if ( $CI->input->get('new', true) ) {     

            // Include Email Templates New view
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/email_templates/templates_new.php');

        } else if ( $CI->input->get('template', true) ) {
            
            // Get the template's metas
            $get_template_metas = $CI->base_model->the_data_where('notifications_templates_meta',
            'notifications_templates_meta.*, notifications_templates.template_slug',
            array(
                'notifications_templates_meta.template_id' => $CI->input->get('template', true)
            ),
            array(),
            array(),
            array(array(
                'table' => 'notifications_templates',
                'condition' => 'notifications_templates_meta.template_id=notifications_templates.template_id',
                'join_from' => 'LEFT'
            )));

            // Verify if the template's metas exists
            if ( $get_template_metas ) {

                // Require the Notifications Template Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_template.php';
                
                // Template's data
                $template = array();

                // Set template slug
                $template['template_slug'] = $get_template_metas[0]['template_slug'];

                // List the template's meta
                foreach ( $get_template_metas as $get_template_meta ) {

                    // Set template
                    $template[$get_template_meta['language']] = $get_template_meta;

                }

                // Set template's ID
                md_set_data('template', $template);

                // Include Email Template view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/email_templates/template.php');
            
            } else {

                // Include Notifications No Data view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/no_data.php');    

            }

        } else {

            // Include Email Templates List view
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/email_templates/templates_list.php');

        }
        
    }

}

/**
 * The public method set_admin_notifications_page adds a notifications's page in the admin panel
 */
set_admin_notifications_page(
    'users_alerts',
    array(
        'page_name' => get_instance()->lang->line('notifications_users_alerts'),
        'page_icon' => md_the_admin_icon(array('icon' => 'snooze')),
        'content' => 'get_admin_notifications_page_users_alerts',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/notifications/styles/css/users-alerts.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION), 'text/css', 'all'),
            array('stylesheet', '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css', 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/notifications/js/users-alerts.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION)),
            array('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js')
        )  
    )
);

if ( !function_exists('get_admin_notifications_page_users_alerts') ) {

    /**
     * The function get_admin_notifications_page_users_alerts displays the Users Alerts page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function get_admin_notifications_page_users_alerts() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify which page should be displayed
        if ( $CI->input->get('new', true) ) {     

            // Include Users Alerts New view
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/users_alerts/alerts_new.php');

        } else if ( $CI->input->get('alert', true) ) {

            // Get the alert's fields
            $the_alert_fields = $CI->base_model->the_data_where(
            'notifications_alerts_fields',
            'notifications_alerts_fields.*, notifications_alerts.alert_name, notifications_alerts.alert_type',
            array(
                'notifications_alerts.alert_id' => $CI->input->get('alert', true),
                'notifications_alerts.alert_type <' => 3
            ),
            array(),
            array(),
            array(array(
                'table' => 'notifications_alerts',
                'condition' => 'notifications_alerts_fields.alert_id=notifications_alerts.alert_id',
                'join_from' => 'LEFT'
            )));

            // Verify if the alert exists
            if ( $the_alert_fields ) {

                // Require the Notifications Alert Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_alert.php';

                // Alert fields container
                $alert_fields = array();

                // List alert's fields
                foreach ( $the_alert_fields as $alert_field ) {

                    // Set field to container
                    $alert_fields[$alert_field['field_name']] = isset($alert_fields[$alert_field['field_name']])?$alert_fields[$alert_field['field_name']]:array();

                    // Verify if language exists
                    if ( !empty($alert_field['language']) ) {

                        // Set new keys
                        $alert_fields[$alert_field['field_name']][$alert_field['language']] = array(
                            'field_value' => $alert_field['field_value'],
                            'field_extra' => $alert_field['field_extra']
                        );

                    } else {

                        // Set new keys
                        $alert_fields[$alert_field['field_name']] = array(
                            'field_value' => $alert_field['field_value'],
                            'field_extra' => $alert_field['field_extra']
                        );

                    }

                }

                // Set alert's name
                md_set_data('notifications_users_alert_name', $the_alert_fields[0]['alert_name']);
                
                // Set alert's type
                md_set_data('notifications_users_alert_type', $the_alert_fields[0]['alert_type']);

                // Set alert's fields
                md_set_data('notifications_users_alert_fields', $alert_fields);

                // Get the alert's filters
                $the_alert_filters = $CI->base_model->the_data_where(
                    'notifications_alerts_filters',
                    'notifications_alerts_filters.*, notifications_alerts.alert_name, notifications_alerts.alert_type',
                    array(
                        'notifications_alerts.alert_id' => $CI->input->get('alert', true),
                        'notifications_alerts.alert_type <' => 3
                    ),
                    array(),
                    array(),
                    array(array(
                        'table' => 'notifications_alerts',
                        'condition' => 'notifications_alerts_filters.alert_id=notifications_alerts.alert_id',
                        'join_from' => 'LEFT'
                    )
                ));

                // Verify if filters exists
                if ( $the_alert_filters ) {

                    // Set alert's filters
                    md_set_data('notifications_users_alert_filters', $the_alert_filters);                    

                }

                // Include Users alert's view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/users_alerts/alert.php');

            } else {

                // Include Notifications No Data view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/no_data.php');    

            }

        } else {

            // Include Users Alerts view
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/users_alerts/alerts_list.php');

        }
        
    }

}

/**
 * The public method set_admin_notifications_page adds a notifications's page in the admin panel
 */
set_admin_notifications_page(
    'system_errors',
    array(
        'page_name' => get_instance()->lang->line('notifications_system_errors'),
        'page_icon' => md_the_admin_icon(array('icon' => 'system_errors')),
        'content' => 'get_admin_notifications_page_system_errors',
        'css_urls' => array(
            array('stylesheet', base_url('assets/base/admin/components/collection/notifications/styles/css/system-errors.css?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION), 'text/css', 'all'),
            array('stylesheet', '//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css', 'text/css', 'all')
        ),
        'js_urls' => array(
            array(base_url('assets/base/admin/components/collection/notifications/js/errors-alerts.js?ver=' . CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS_VERSION)),
            array('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js')
        )  
    )
);

if ( !function_exists('get_admin_notifications_page_system_errors') ) {

    /**
     * The function get_admin_notifications_page_system_errors displays the System Errors page
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function get_admin_notifications_page_system_errors() {

        // Get codeigniter object instance
        $CI = &get_instance();

        // Verify if alert exists
        if ( $CI->input->get('alert', true) ) {

            // Get the alert's fields
            $the_alert_fields = $CI->base_model->the_data_where(
            'notifications_alerts_fields',
            'notifications_alerts_fields.*, notifications_alerts.alert_name, notifications_alerts.alert_type, users.*',
            array(
                'notifications_alerts.alert_id' => $CI->input->get('alert', true),
                'notifications_alerts.alert_type' => 3
            ),
            array(),
            array(),
            array(array(
                'table' => 'notifications_alerts',
                'condition' => 'notifications_alerts_fields.alert_id=notifications_alerts.alert_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'notifications_alerts_users',
                'condition' => 'notifications_alerts.alert_id=notifications_alerts_users.alert_id',
                'join_from' => 'LEFT'
            ),
            array(
                'table' => 'users',
                'condition' => 'notifications_alerts_users.user_id=users.user_id',
                'join_from' => 'LEFT'
            )));

            // Verify if the alert exists
            if ( $the_alert_fields ) {

                // Require the Notifications Alert Inc file
                require_once CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'inc/notifications_alert.php';

                // Alert fields container
                $alert_fields = array();

                // List alert's fields
                foreach ( $the_alert_fields as $alert_field ) {

                    // Set field to container
                    $alert_fields[$alert_field['field_name']] = isset($alert_fields[$alert_field['field_name']])?$alert_fields[$alert_field['field_name']]:array();

                    // Verify if language exists
                    if ( !empty($alert_field['language']) ) {

                        // Set new keys
                        $alert_fields[$alert_field['field_name']][$alert_field['language']] = array(
                            'field_value' => $alert_field['field_value'],
                            'field_extra' => $alert_field['field_extra']
                        );

                    } else {

                        // Set new keys
                        $alert_fields[$alert_field['field_name']] = array(
                            'field_value' => $alert_field['field_value'],
                            'field_extra' => $alert_field['field_extra']
                        );

                    }

                }

                // Set alert's name
                md_set_data('notifications_users_alert_name', $the_alert_fields[0]['alert_name']);
                
                // Set alert's type
                md_set_data('notifications_users_alert_type', $the_alert_fields[0]['alert_type']);

                // Set alert's fields
                md_set_data('notifications_users_alert_fields', $alert_fields);

                // Verify if user's ID exists
                if ( isset($the_alert_fields[0]['user_id']) ) {

                    // User's data
                    $user = array(
                        'user_id' => $the_alert_fields[0]['user_id'],
                        'name' => !empty($the_alert_fields[0]['first_name'])?$the_alert_fields[0]['first_name'] . ' ' . $the_alert_fields[0]['last_name']:$the_alert_fields[0]['username'],
                        'email' => $the_alert_fields[0]['email'],
                        'status' => $the_alert_fields[0]['status']
                    );

                    // Set user
                    md_set_data('notifications_system_errors_user', $user);                    

                }

                // Include Error Alert view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/system_errors/alert.php');

            } else {

                // Include Notifications No Data view
                md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/no_data.php');    

            }

        } else {

            // Include System Errors list view
            md_include_component_file(CMS_BASE_ADMIN_COMPONENTS_NOTIFICATIONS . 'views/system_errors/errors_list.php');
        
        }

    }

}

/* End of file notifications_pages.php */