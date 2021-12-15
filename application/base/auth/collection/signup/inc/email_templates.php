<?php
/**
 * Email Templates Inc
 *
 * PHP Version 7.3
 *
 * This files contains the the email templates
 * for Sign Up page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

 // Define the constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Register email template
set_admin_notifications_email_template(
    'signup_welcome_confirmation',
    array(
        'template_name' => get_instance()->lang->line('auth_signup_welcome_confirmation'),
        'template_placeholders' => array(
            array(
                'code' => '[username]',
                'description' => get_instance()->lang->line('auth_signup_username_placeholder_description')
            ),
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('auth_signup_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('auth_signup_last_name_placeholder_description')
            ),
            array(
                'code' => '[website_name]',
                'description' => get_instance()->lang->line('auth_signup_website_name_placeholder_description')
            ),
            array(
                'code' => '[confirmation_url]',
                'description' => get_instance()->lang->line('auth_signup_confirmation_url_placeholder_description')
            ),
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('auth_signup_login_url_placeholder_description')
            ),
            array(
                'code' => '[website_url]',
                'description' => get_instance()->lang->line('auth_signup_website_url_placeholder_description')
            )

        )

    )

);

// Register email template
set_admin_notifications_email_template(
    'signup_welcome_no_confirmation',
    array(
        'template_name' => get_instance()->lang->line('auth_signup_welcome_without_confirmation'),
        'template_placeholders' => array(
            array(
                'code' => '[username]',
                'description' => get_instance()->lang->line('auth_signup_username_placeholder_description')
            ),
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('auth_signup_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('auth_signup_last_name_placeholder_description')
            ),
            array(
                'code' => '[website_name]',
                'description' => get_instance()->lang->line('auth_signup_website_name_placeholder_description')
            ),
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('auth_signup_login_url_placeholder_description')
            ),
            array(
                'code' => '[website_url]',
                'description' => get_instance()->lang->line('auth_signup_website_url_placeholder_description')
            )

        )

    )

);

// Register email template
set_admin_notifications_email_template(
    'signup_new_user_notification',
    array(
        'template_name' => get_instance()->lang->line('auth_signup_new_user_notification'),
        'template_placeholders' => array(
            array(
                'code' => '[username]',
                'description' => get_instance()->lang->line('auth_signup_username_placeholder_description')
            ),
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('auth_signup_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('auth_signup_last_name_placeholder_description')
            ),
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('auth_signup_login_url_placeholder_description')
            )

        )

    )

);