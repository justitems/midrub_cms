<?php
/**
 * Notifications Template Inc
 *
 * PHP Version 7.3
 *
 * This files contains the functions used
 * in the template's page
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

if ( !function_exists('get_admin_notifications_selected_template') ) {

    /**
     * The function get_admin_notifications_selected_template shows selected template
     * 
     * @param string $template_slug contains the template's slug
     * 
     * @since 0.0.8.3
     * 
     * @return void
     */
    function get_admin_notifications_selected_template($template_slug) {

        // Get email's templates
        $email_templates = the_admin_notifications_email_templates();

        // Dropdown
        $dropdown = '';

        // Verify if email's templates exists
        if ( $email_templates ) {

            // List email's templates
            foreach ( $email_templates as $email_template ) {

                // Get key
                $key = key($email_template);

                // Verify if this is the selected template
                if ( $template_slug !== $key ) {
                    continue;
                }

                // Set selected template
                $dropdown = '<option value="' . $key . '" selected>'
                        . $email_template[$key]['template_name']
                    . '</option>';

            }

        }

        // Verify if $dropdown is empty
        if ( empty($dropdown) ) {

            // Set default dropdown
            $dropdown = '<option disabled selected>'
                . get_instance()->lang->line('notifications_select_template')
            . '</option>';

            // Get all templates
            $get_templates = get_instance()->base_model->the_data_where('notifications_templates', '*');

            // Set all templates
            $all_templates = !empty($get_templates)?array_column($get_templates, 'template_slug'):array();

            // Verify if email's templates exists
            if ( $email_templates ) {

                // List email's templates
                foreach ( $email_templates as $email_template ) {

                    // Get key
                    $key = key($email_template);

                    // Verify if array already exists
                    if ( in_array($key, $all_templates ) ) {
                        continue;
                    }

                    // Set dropdown
                    $dropdown .= '<option value="' . $key . '">'
                            . $email_template[$key]['template_name']
                        . '</option>';

                }

            }

        }

        // Display dropdown
        echo '<div class="row">'
            . '<div class="col-lg-12">'
                . '<div class="theme-box-1">'
                    . '<div class="card theme-card-box notifications-email-templates">'
                        . '<div class="card-header">'
                            . '<button class="btn btn-link">'
                                . md_the_admin_icon(array('icon' => 'email_template')) . ' '
                                . get_instance()->lang->line('notifications_email_template')
                            . '</button>'
                        . '</div>'
                        . '<div class="card-body">'
                            . '<div class="form-group">'
                                . '<select class="form-control w-100 theme-select notifications-email-template-select">'
                                    . $dropdown
                                . '</select>'
                            . '</div>'
                        . '</div>'
                    . '</div>'
                . '</div>'
            . '</div>'
        . '</div>';
        
    }

}

if ( !function_exists('the_admin_notifications_selected_template_placeholders') ) {

    /**
     * The function the_admin_notifications_selected_template_placeholders gets selected template's placeholders
     * 
     * @param string $template_slug contains the template's slug
     * 
     * @since 0.0.8.3
     * 
     * @return string with placeholders
     */
    function the_admin_notifications_selected_template_placeholders($template_slug) {

        // Get email's templates
        $email_templates = the_admin_notifications_email_templates();

        // Placeholders
        $placeholders = '';

        // Verify if email's templates exists
        if ( $email_templates ) {

            // List email's templates
            foreach ( $email_templates as $email_template ) {

                // Get key
                $key = key($email_template);

                // Verify if this is the selected template
                if ( $template_slug !== $key ) {
                    continue;
                }
                
                // Verify if placeholders exists
                if ( !empty($email_template[$key]['template_placeholders']) ) {

                    // List placeholders
                    foreach ( $email_template[$key]['template_placeholders'] as $placeholder ) {

                        // Set placeholder
                        $placeholders .= '<li>'
                            . '<p>'
                                . '<span class="notifications-emails-template-placeholder">'
                                    . $placeholder['code']
                                . '</span>'
                                . $placeholder['description']
                            . '</p>'
                        . '</li>';

                    }

                }

            }

        }

        // Verify if $placeholders is empty
        if ( empty($placeholders) ) {

            // Set no placeholders message
            $placeholders = '<li class="default-card-box-no-items-found">'
                . get_instance()->lang->line('notifications_no_placeholders_found')
            . '</li>';

        }

        // Return the placeholders
        return $placeholders;
        
    }

}

/* End of file notifications_template.php */