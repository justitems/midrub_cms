<?php
/**
 * Email Templates Inc
 *
 * PHP Version 7.3
 *
 * This files contains the the email templates
 * for the Members component
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

// Register email template
set_admin_notifications_email_template(
    'members_member_account_created',
    array(
        'template_name' => get_instance()->lang->line('members_member_account_created'),
        'template_placeholders' => array(
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('members_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('members_last_name_placeholder_description')
            ),
            array(
                'code' => '[website_name]',
                'description' => get_instance()->lang->line('members_website_name_placeholder_description')
            ),
            array(
                'code' => '[email]',
                'description' => get_instance()->lang->line('members_member_email_description')
            ), 
            array(
                'code' => '[password]',
                'description' => get_instance()->lang->line('members_member_password_description')
            ),                        
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('members_login_url_placeholder_description')
            ),
            array(
                'code' => '[website_url]',
                'description' => get_instance()->lang->line('members_website_url_placeholder_description')
            )

        )

    )

);

// Register email template
set_admin_notifications_email_template(
    'members_member_account_updated',
    array(
        'template_name' => get_instance()->lang->line('members_member_account_updated'),
        'template_placeholders' => array(
            array(
                'code' => '[first_name]',
                'description' => get_instance()->lang->line('members_first_name_placeholder_description')
            ),
            array(
                'code' => '[last_name]',
                'description' => get_instance()->lang->line('members_last_name_placeholder_description')
            ),
            array(
                'code' => '[website_name]',
                'description' => get_instance()->lang->line('members_website_name_placeholder_description')
            ),
            array(
                'code' => '[email]',
                'description' => get_instance()->lang->line('members_member_email_description')
            ), 
            array(
                'code' => '[password]',
                'description' => get_instance()->lang->line('members_member_password_description')
            ),                        
            array(
                'code' => '[login_url]',
                'description' => get_instance()->lang->line('members_login_url_placeholder_description')
            ),
            array(
                'code' => '[website_url]',
                'description' => get_instance()->lang->line('members_website_url_placeholder_description')
            )

        )

    )

);

/* End of file email_template.php */