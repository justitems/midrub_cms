<?php
/**
 * Email Templates Class
 *
 * This file loads the Email_templates Class which collects all email templates
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */

// Define the email_template namespace
namespace CmsBase\Admin\Components\Collection\Notifications\Classes;

// Constats
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Email_templates class collects all email templates
 * 
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://github.com/scrisoft/midrub_cms Midrub’s License
 * @link     https://www.midrub.com/
 * 
 * @since 0.0.8.3
 */
class Email_templates {
    
    /**
     * Contains and array with saved email templates
     *
     * @since 0.0.8.3
    */
    public static $the_templates = array(); 

    /**
     * The public method set_email_template adds email's template
     * 
     * @param string $template_slug contains the template's slug
     * @param array $args contains the template's arguments
     * 
     * @since 0.0.8.3
     * 
     * @return void
    */
    public function set_template($template_slug, $args) {

        // Verify if the email template has valid fields
        if ( $template_slug ) {

            self::$the_templates[][$template_slug] = $args;
            
        }

    } 

    /**
     * The public method load_templates loads all email's templates
     * 
     * @since 0.0.8.3
     * 
     * @return array with email templates or boolean false
    */
    public function load_templates() {

        // Verify if email templates exists
        if ( self::$the_templates ) {

            return self::$the_templates;

        } else {

            return false;

        }

    }

    /**
     * The function the_admin_notifications_email_template gets the email's template
     * 
     * @param string $template_slug contains the template slug
     * @param string $language contains the language
     * 
     * @since 0.0.8.3
     * 
     * @return array with email template or boolean false
    */
    public function the_email_template($template_slug, $language=NULL) {

        // Where conditions
        $where = array(
            'notifications_templates.template_slug' => $template_slug
        );

        // Verify if $language is not null
        if ( $language ) {

            // Set where
            $where['notifications_templates_meta.language'] = $language;

        }

        // Get the template's meta
        $get_template_meta = get_instance()->base_model->the_data_where('notifications_templates_meta',
        'notifications_templates_meta.*, notifications_templates.template_slug',
        $where,
        array(),
        array(),
        array(array(
            'table' => 'notifications_templates',
            'condition' => 'notifications_templates_meta.template_id=notifications_templates.template_id',
            'join_from' => 'LEFT'
        )));

        // Verify if $get_template_meta exists
        if ( $get_template_meta ) {

            return $get_template_meta;

        } else {

            return false;

        }

    }

}

/* End of file email_templates.php */