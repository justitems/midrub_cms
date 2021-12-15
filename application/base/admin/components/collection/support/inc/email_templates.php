<?php
/**
 * Email Templates Inc
 *
 * PHP Version 7.3
 *
 * This files contains the the email templates
 * for the Support component
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
    'support_ticket_reply_notification',
    array(
        'template_name' => get_instance()->lang->line('support_ticket_reply_notification'),
        'template_placeholders' => array(
            array(
                'code' => '[username]',
                'description' => get_instance()->lang->line('support_username_placeholder_description')
            ),
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('support_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('support_last_name_placeholder_description')
            ),
            array(
                'code' => '[website_name]',
                'description' => get_instance()->lang->line('support_website_name_placeholder_description')
            ),
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('support_login_url_placeholder_description')
            ),
            array(
                'code' => '[website_url]',
                'description' => get_instance()->lang->line('support_website_url_placeholder_description')
            )

        )

    )

);