<div class="row">
    <div class="col-lg-12 settings-area">
        <?php

            // Default website's logo
            $website_logo = '';

            // Verify if the website's logo exists
            if ( md_the_option('frontend_theme_logo') ) {

                // Get the media
                $the_media = $this->base_model->the_data_where('medias', '*', array('media_id' => md_the_option('frontend_theme_logo')));

                // Verify if media's exists
                if ( $the_media ) {

                    // Set media
                    $website_logo = $the_media[0]['body'];

                }

            }
            
        ?>
        <?php md_get_admin_fields(array(
            'header' => array(
                'title' => md_the_admin_icon(array('icon' => 'general'))
                . $this->lang->line('theme_general')
            ),
            'fields' => array(
                array(
                    'field_slug' => 'crm_frontend_website_name',
                    'field_type' => 'text',
                    'field_words' => array(
                        'field_title' => $this->lang->line('theme_crm_frontend_website_name'),
                        'field_description' => $this->lang->line('theme_crm_frontend_website_name_description')
                    ),
                    'field_params' => array(
                        'placeholder' => $this->lang->line('theme_crm_frontend_enter_website_name'),
                        'value' => md_the_option('crm_frontend_website_name'),
                        'disabled' => false
                    )

                ),
                array(
                    'field_slug' => 'frontend_theme_logo',
                    'field_type' => 'image',
                    'field_words' => array(
                        'field_title' => $this->lang->line('theme_crm_frontend_website_logo'),
                        'field_description' => $this->lang->line('theme_crm_frontend_website_logo_description')
                    ),
                    'field_params' => array(
                        'modal' => '#theme-upload-logo-modal',
                        'src' => $website_logo
                    )

                )

            )

        )); ?>
        <?php md_get_admin_fields(array(
            'header' => array(
                'title' => md_the_admin_icon(array('icon' => 'news'))
                . $this->lang->line('theme_newsletter')
            ),
            'fields' => array(
                array(
                    'field_slug' => 'crm_frontend_newsletter',
                    'field_type' => 'checkbox',
                    'field_words' => array(
                        'field_title' => $this->lang->line('theme_newsletter_enabled'),
                        'field_description' => $this->lang->line('theme_newsletter_enabled_description')
                    ),
                    'field_params' => array(
                        'checked' => md_the_option('crm_frontend_newsletter')?1:0
                    )

                ),
                array(
                    'field_slug' => 'crm_frontend_newsletter_title',
                    'field_type' => 'text',
                    'field_words' => array(
                        'field_title' => $this->lang->line('theme_newsletter_title'),
                        'field_description' => $this->lang->line('theme_newsletter_title_description')
                    ),
                    'field_params' => array(
                        'placeholder' => $this->lang->line('theme_newsletter_enter_title'),
                        'value' => md_the_option('crm_frontend_newsletter_title')?md_the_option('crm_frontend_newsletter_title'):$this->lang->line('theme_get_touch_news'),
                        'disabled' => false
                    )

                ),
                array(
                    'field_slug' => 'crm_frontend_newsletter_mailchimp_api_key',
                    'field_type' => 'text',
                    'field_words' => array(
                        'field_title' => $this->lang->line('theme_mailchimp_api_key'),
                        'field_description' => $this->lang->line('theme_mailchimp_api_key_description')
                    ),
                    'field_params' => array(
                        'placeholder' => $this->lang->line('theme_mailchimp_enter_api_key'),
                        'value' => md_the_option('crm_frontend_newsletter_mailchimp_api_key'),
                        'disabled' => false
                    )

                )

            )

        )); ?>        
    </div>
</div>
<?php md_get_the_file(md_the_theme_path() . 'contents/parts/media.php'); ?>