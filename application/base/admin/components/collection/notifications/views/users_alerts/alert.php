<div class="notifications-users-alert" data-alert="<?php echo $this->input->get('alert', true); ?>">
    <div class="row">
        <div class="col-lg-9 theme-editor">
            <div class="card theme-card-box">
                <div class="card-header">
                    <button class="btn btn-link">
                        <?php echo md_the_admin_icon(array('icon' => 'info')); ?>
                        <?php echo $this->lang->line('notifications_alert_information'); ?>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3 theme-form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="theme-label" for="notifications-alert-name">
                                    <?php echo $this->lang->line('notifications_alert_name'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" value="<?php echo the_users_alert_name(); ?>" placeholder="<?php echo $this->lang->line('notifications_enter_name'); ?>" class="form-control theme-text-input-1" id="notifications-alert-name" />
                                <small class="form-text text-muted mb-0 theme-small">
                                    <?php echo $this->lang->line('notifications_alert_name_description'); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mb-3 theme-form-group">
                        <div class="row">
                            <div class="col-lg-12">
                                <label class="theme-label" for="notifications-alert-type">
                                    <?php echo $this->lang->line('notifications_alert_type'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="btn-group mt-1 theme-input-group-3 notifications-buttons-group notifications-select-alert-type" role="group" aria-label="Alerts Type">
                                    <?php if (the_users_alert_type() === '0') { ?>
                                    <button type="button" class="btn btn-secondary theme-button-3" aria-expanded="true" data-bs-tab="#notifications-users-alert-type-news" data-type="0">
                                        <?php echo $this->lang->line('notifications_news'); ?>
                                    </button>
                                    <?php } ?>
                                    <?php if (the_users_alert_type() === '1') { ?>
                                    <button type="button" class="btn btn-secondary theme-button-3" aria-expanded="true" data-bs-tab="#notifications-users-alert-type-promo" data-type="1">
                                        <?php echo $this->lang->line('notifications_promo'); ?>
                                    </button>
                                    <?php } ?>
                                    <?php if (the_users_alert_type() === '2') { ?>
                                    <button type="button" class="btn btn-secondary theme-button-3" aria-expanded="true" data-bs-tab="#notifications-users-alert-type-fixed" data-type="2">
                                        <?php echo $this->lang->line('notifications_fixed'); ?>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>                           
                    </div>
                    <hr>
                    <div class="tab-content" id="notifications-users-alert-types-content">
                        <div class="tab-pane fade<?php echo (the_users_alert_type() === '0')?' active show':''; ?>" id="notifications-users-alert-type-news" role="tabpanel" aria-labelledby="notifications-users-alert-type-news-tab">
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-banner">
                                            <?php echo $this->lang->line('notifications_alert_banner'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 theme-tabs">
                                        <?php

                                        // Get all languages
                                        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                        // Verify if there are more than 1 language
                                        if ( count($languages) > 1 ) {

                                        ?>
                                        <ul class="nav nav-tabs nav-justified mb-3 mb-3">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' active';
                                                }

                                                echo '<li class="nav-item">'
                                                    . '<a href="#notifications-type-news-alert-banner-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
                                                        . ucfirst($only_dir)
                                                    . '</a>'
                                                . '</li>';
                                            }

                                            ?>
                                        </ul>
                                        <?php
                                        }

                                        ?>
                                        <div class="tab-content tab-all-banner-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-type-news-alert-banner-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-news-alert-banner-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"><?php echo (the_users_alert_type() === '0')?the_users_alerts_field('banner_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-10 col-xs-6">
                                        <label class="theme-label" for="menu-item-text-input">
                                            <?php echo $this->lang->line('notifications_enable_alert_banner'); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <div class="theme-checkbox-input-2 pull-right">
                                            <input type="checkbox" name="notifications-alert-enable-banner" class="notifications-option-checkbox" id="notifications-alert-enable-banner"<?php echo the_users_alerts_field('banner_enabled')?' checked':''; ?> />
                                            <label class="theme-label" for="notifications-alert-enable-banner"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-page">
                                            <?php echo $this->lang->line('notifications_alert_page'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 theme-tabs">
                                        <?php

                                        // Get all languages
                                        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                        // Verify if there are more than 1 language
                                        if ( count($languages) > 1 ) {

                                        ?>
                                        <ul class="nav nav-tabs nav-justified mb-3 mb-3">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' active';
                                                }

                                                echo '<li class="nav-item">'
                                                    . '<a href="#notifications-type-news-alert-banner-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
                                                        . ucfirst($only_dir)
                                                    . '</a>'
                                                . '</li>';
                                            }

                                            ?>
                                        </ul>
                                        <?php
                                        }

                                        ?>
                                        <div class="tab-content tab-all-page-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-news-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input type="text" value="<?php echo (the_users_alert_type() === '0')?the_users_alerts_field('page_title', '', $only_dir):''; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-news-alert-page-title-<?php echo $only_dir; ?>" />
                                                            <small class="form-text text-muted mb-0 theme-small">
                                                                <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <br>                                             
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-news-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea notifications-alert-page-textarea d-none"><?php echo (the_users_alert_type() === '0')?the_users_alerts_field('page_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <div class="form-group theme-form-group">
                                <div class="row">
                                    <div class="col-lg-10 col-xs-6">
                                        <label class="theme-label" for="menu-item-text-input">
                                            <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <div class="theme-checkbox-input-2 pull-right">
                                            <input type="checkbox" name="notifications-news-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-news-alert-enable-page"<?php echo the_users_alerts_field('page_enabled')?' checked':''; ?> />
                                            <label class="theme-label" for="notifications-news-alert-enable-page"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade<?php echo (the_users_alert_type() === '1')?' active show':''; ?>" id="notifications-users-alert-type-promo" role="tabpanel" aria-labelledby="notifications-users-alert-type-promo-tab">
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-banner">
                                            <?php echo $this->lang->line('notifications_alert_banner'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 theme-tabs">
                                        <ul class="nav nav-tabs nav-justified">
                                            <?php

                                            // Get all languages
                                            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' class="active"';
                                                }

                                                echo '<li' . $active . '>'
                                                    . '<a data-bs-toggle="tab" href="#notifications-type-promo-alert-banner' . $only_dir . '">'
                                                        . ucfirst($only_dir)
                                                    . '</a>'
                                                . '</li>';
                                            }

                                            ?>
                                        </ul>
                                        <div class="tab-content tab-all-banner-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-type-promo-alert-banner<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">   
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-promo-alert-banner-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"><?php echo (the_users_alert_type() === '1')?the_users_alerts_field('banner_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <hr>
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-page">
                                            <?php echo $this->lang->line('notifications_alert_page'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 theme-tabs">
                                        <ul class="nav nav-tabs nav-justified">
                                            <?php

                                            // Get all languages
                                            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' class="active"';
                                                }

                                                echo '<li' . $active . '>'
                                                    . '<a data-bs-toggle="tab" href="#notifications-type-promo-alert-page-' . $only_dir . '">'
                                                        . ucfirst($only_dir)
                                                    . '</a>'
                                                . '</li>';
                                            }

                                            ?>
                                        </ul>
                                        <div class="tab-content tab-all-page-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-type-promo-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input type="text" value="<?php echo (the_users_alert_type() === '1')?the_users_alerts_field('page_title', '', $only_dir):''; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-promo-alert-page-title-<?php echo $only_dir; ?>" />
                                                            <small class="form-text text-muted mb-0 theme-small">
                                                                <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <br>   
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-promo-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea d-none"><?php echo (the_users_alert_type() === '1')?the_users_alerts_field('page_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <div class="form-group theme-form-group">
                                <div class="row">
                                    <div class="col-lg-10 col-xs-6">
                                        <label class="theme-label" for="menu-item-text-input">
                                            <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <div class="theme-checkbox-input-2 pull-right">
                                            <input type="checkbox" name="notifications-news-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-news-alert-enable-page"<?php echo the_users_alerts_field('page_enabled')?' checked':''; ?> />
                                            <label class="theme-label" for="notifications-news-alert-enable-page"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade<?php echo (the_users_alert_type() === '2')?' active show':''; ?>" id="notifications-users-alert-type-fixed" role="tabpanel" aria-labelledby="notifications-users-alert-type-fixed-tab">
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-banner">
                                            <?php echo $this->lang->line('notifications_alert_banner'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 theme-tabs">
                                        <ul class="nav nav-tabs nav-justified">
                                            <?php

                                            // Get all languages
                                            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                            // Verify if there are more than 1 language
                                            if ( count($languages) > 1 ) {

                                                // List all languages
                                                foreach ($languages as $language) {

                                                    // Get language dir name
                                                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                    // Active variable
                                                    $active = '';

                                                    // Verify if is the configured language
                                                    if ($this->config->item('language') === $only_dir) {
                                                        $active = ' class="active"';
                                                    }

                                                    echo '<li' . $active . '>'
                                                        . '<a data-bs-toggle="tab" href="#notifications-type-fixed-alert-banner-' . $only_dir . '">'
                                                            . ucfirst($only_dir)
                                                        . '</a>'
                                                    . '</li>';

                                                }

                                            }

                                            ?>
                                        </ul>
                                        <div class="tab-content tab-all-banner-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-type-fixed-alert-banner-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>"> 
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-fixed-alert-banner-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"><?php echo (the_users_alert_type() === '2')?the_users_alerts_field('banner_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <hr>
                            <div class="form-group mb-3 theme-form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-page">
                                            <?php echo $this->lang->line('notifications_alert_page'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 theme-tabs">
                                        <ul class="nav nav-tabs nav-justified">
                                            <?php

                                            // Get all languages
                                            $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

                                            // Verify if there are more than 1 language
                                            if ( count($languages) > 1 ) {

                                                // List all languages
                                                foreach ($languages as $language) {

                                                    // Get language dir name
                                                    $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                    // Active variable
                                                    $active = '';

                                                    // Verify if is the configured language
                                                    if ($this->config->item('language') === $only_dir) {
                                                        $active = ' class="active"';
                                                    }

                                                    echo '<li' . $active . '>'
                                                        . '<a data-bs-toggle="tab" href="#notifications-type-fixed-alert-page-' . $only_dir . '">'
                                                            . ucfirst($only_dir)
                                                        . '</a>'
                                                    . '</li>';
                                                    
                                                }

                                            }

                                            ?>
                                        </ul>
                                        <div class="tab-content tab-all-page-editors">
                                            <?php

                                            // List all languages
                                            foreach ($languages as $language) {

                                                // Get language dir name
                                                $only_dir = str_replace(APPPATH . 'language' . '/', '', $language);

                                                // Active variable
                                                $active = '';

                                                // Verify if is the configured language
                                                if ($this->config->item('language') === $only_dir) {
                                                    $active = ' show active';
                                                }

                                                ?>
                                                <div id="notifications-type-fixed-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input type="text" value="<?php echo (the_users_alert_type() === '2')?the_users_alerts_field('page_title', '', $only_dir):''; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-fixed-alert-page-title-<?php echo $only_dir; ?>" />
                                                            <small class="form-text text-muted mb-0 theme-small">
                                                                <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <br>   
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="summernote-editor notifications-type-fixed-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                            <textarea class="summernote-editor-textarea d-none"><?php echo (the_users_alert_type() === '2')?the_users_alerts_field('page_content', '', $only_dir):''; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <small class="form-text text-muted mb-0 theme-small">
                                            <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                        </small>
                                    </div>
                                </div>                          
                            </div>
                            <div class="form-group theme-form-group">
                                <div class="row">
                                    <div class="col-lg-10 col-xs-6">
                                        <label class="theme-label" for="menu-item-text-input">
                                            <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                        </label>
                                    </div>
                                    <div class="col-lg-2 col-xs-6">
                                        <div class="theme-checkbox-input-2 pull-right">
                                            <input type="checkbox" name="notifications-news-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-news-alert-enable-page"<?php echo the_users_alerts_field('page_enabled')?' checked':''; ?> />
                                            <label class="theme-label" for="notifications-news-alert-enable-page"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>
            <div class="card mt-3 mb-0 theme-card-box theme-list">
                <div class="card-header">
                    <button class="btn btn-link">
                        <?php echo md_the_admin_icon(array('icon' => 'users', 'class' => 'ms-0')); ?>
                        <?php echo $this->lang->line('notifications_users'); ?>
                    </button>
                </div>
                <div class="card-body">
                    <ul class="notifications-list-users"></ul>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <h6 class="theme-color-black"></h6>
                        </div>
                        <div class="col-md-7 col-12 text-end">
                            <nav aria-label="alert-users">
                                <ul class="theme-pagination" data-type="alert-users">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="col-lg-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-box-1">
                        <div class="card theme-card-box notifications-users-alert-filters">
                            <div class="card-header">
                                <button class="btn btn-link">
                                    <?php echo md_the_admin_icon(array('icon' => 'filter')); ?>
                                    <?php echo $this->lang->line('notifications_filters'); ?>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 theme-form-group">
                                    <div class="card theme-box-1 theme-card-box notifications-users-alert-selected-plans">
                                        <div class="card-header">
                                            <button class="btn btn-link">
                                                <?php echo $this->lang->line('notifications_selected_plans'); ?>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <ul class="theme-card-box-list notifications-selected-plans-list">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3 theme-form-group">
                                    <div class="card theme-box-1 theme-card-box notifications-users-alert-selected-languages">
                                        <div class="card-header">
                                            <button class="btn btn-link">
                                                <?php echo $this->lang->line('notifications_selected_languages'); ?>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <ul class="theme-card-box-list notifications-selected-languages-list">
                                                <?php

                                                // Get languages
                                                $languages = the_users_alerts_filters('languages');

                                                // Verify if languages exists
                                                if ( $languages ) {

                                                    // List all languages
                                                    foreach (unserialize($languages) as $language) {

                                                        // Display the language
                                                        echo '<li data-language="' . $language . '">'
                                                            . '<p>'
                                                                . ucfirst($language)
                                                            . '</p>'
                                                        . '</li>';

                                                    }

                                                } else {

                                                    // Display no languages message
                                                    echo '<li class="default-card-box-no-items-found">'
                                                        . $this->lang->line('notifications_no_languages_were_selected')
                                                    . '</li>';

                                                }

                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>