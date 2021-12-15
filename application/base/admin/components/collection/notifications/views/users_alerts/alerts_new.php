<div class="notifications-new-users-alert">
    <?php echo form_open('admin/notifications', array('class' => 'notifications-create-users-alert', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
        <div class="row">
            <div class="col-lg-9 theme-editor">
                <div class="theme-box-1 mb-3">
                    <div class="card theme-card-box">
                        <div class="card-header">
                            <button class="btn btn-link">
                                <?php echo md_the_admin_icon(array('icon' => 'notification_add')); ?>
                                <?php echo $this->lang->line('notifications_new_alert'); ?>                            
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-name">
                                            <?php echo $this->lang->line('notifications_alert_name'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control theme-text-input-1" id="notifications-alert-name" placeholder="<?php echo $this->lang->line('notifications_enter_name'); ?>" />
                                        <small class="form-text text-muted theme-small">
                                            <?php echo $this->lang->line('notifications_alert_name_description'); ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 default-buttons-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label class="theme-label" for="notifications-alert-type">
                                            <?php echo $this->lang->line('notifications_alert_type'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group theme-input-group-1 notifications-buttons-group notifications-select-alert-type" role="group" aria-label="Alerts Type">
                                            <button type="button" class="btn btn-secondary theme-button-1" aria-expanded="true" data-bs-tab="#notifications-users-alert-type-news" data-type="0">
                                                <?php echo $this->lang->line('notifications_news'); ?>
                                            </button>
                                            <button type="button" class="btn btn-secondary theme-button-1" data-bs-tab="#notifications-users-alert-type-promo" data-type="1">
                                                <?php echo $this->lang->line('notifications_promo'); ?>
                                            </button>
                                            <button type="button" class="btn btn-secondary theme-button-1" data-bs-tab="#notifications-users-alert-type-fixed" data-type="2">
                                                <?php echo $this->lang->line('notifications_fixed'); ?>
                                            </button>
                                        </div>
                                        <small class="form-text text-muted mt-2 mb-3 theme-small">
                                            <a href="#notifications-users-alert-type" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="notifications-users-alert-type">
                                                <?php echo $this->lang->line('notifications_more_information'); ?>
                                            </a>
                                        </small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="collapse theme-short-description theme-card-box-info" id="notifications-users-alert-type">
                                            <p>
                                                <?php echo $this->lang->line('notifications_alert_type_instructions'); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            <hr>
                            <div class="tab-content" id="notifications-users-alert-types-content">
                                <div class="tab-pane fade active show" id="notifications-users-alert-type-news" role="tabpanel" aria-labelledby="notifications-users-alert-type-news-tab">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="theme-label" for="notifications-alert-banner">
                                                    <?php echo $this->lang->line('notifications_alert_banner'); ?>
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
                                                                    <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-10 col-xs-6">
                                                <label class="theme-label" for="menu-item-text-input">
                                                    <?php echo $this->lang->line('notifications_enable_alert_banner'); ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2 col-xs-6">
                                                <div class="theme-checkbox-input-2 pull-right">
                                                    <input type="checkbox" name="notifications-alert-enable-banner" class="notifications-option-checkbox" id="notifications-alert-enable-banner" />
                                                    <label class="theme-label" for="notifications-alert-enable-banner"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
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
                                                            . '<a href="#notifications-news-alert-page-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
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
                                                                    <input type="text" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-news-alert-page-title-<?php echo $only_dir; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" />
                                                                    <small class="form-text text-muted theme-small">
                                                                        <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <br>                                             
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="summernote-editor notifications-type-news-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                    <textarea class="summernote-editor-textarea notifications-alert-page-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-10 col-xs-6">
                                                <label class="theme-label" for="menu-item-text-input">
                                                    <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2 col-xs-6">
                                                <div class="theme-checkbox-input-2 pull-right">
                                                    <input type="checkbox" name="notifications-news-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-news-alert-enable-page" />
                                                    <label class="theme-label" for="notifications-news-alert-enable-page"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notifications-users-alert-type-promo" role="tabpanel" aria-labelledby="notifications-users-alert-type-promo-tab">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="theme-label" for="notifications-alert-banner">
                                                    <?php echo $this->lang->line('notifications_alert_banner'); ?>
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
                                                <ul class="nav nav-tabs nav-justified mb-3">
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
                                                            . '<a href="#notifications-type-promo-alert-banner' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
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
                                                        <div id="notifications-type-promo-alert-banner<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">   
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="summernote-editor notifications-type-promo-alert-banner-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                    <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <hr>
                                    <div class="form-group">
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
                                                <ul class="nav nav-tabs nav-justified mb-3">
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
                                                            . '<a href="#notifications-type-promo-alert-page-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
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
                                                        <div id="notifications-type-promo-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <input type="text" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-promo-alert-page-title-<?php echo $only_dir; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" />
                                                                    <small class="form-text text-muted theme-small">
                                                                        <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <br>   
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="summernote-editor notifications-type-promo-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                    <textarea class="summernote-editor-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-10 col-xs-6">
                                                <label class="theme-label" for="menu-item-text-input">
                                                    <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2 col-xs-6">
                                                <div class="theme-checkbox-input-2 pull-right">
                                                    <input type="checkbox" name="notifications-promo-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-promo-alert-enable-page" />
                                                    <label class="theme-label" for="notifications-promo-alert-enable-page"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="notifications-users-alert-type-fixed" role="tabpanel" aria-labelledby="notifications-users-alert-type-fixed-tab">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="theme-label" for="notifications-alert-banner">
                                                    <?php echo $this->lang->line('notifications_alert_banner'); ?>
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
                                                <ul class="nav nav-tabs nav-justified mb-3">
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
                                                            . '<a href="#notifications-type-fixed-alert-banner-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
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
                                                        <div id="notifications-type-fixed-alert-banner-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>"> 
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="summernote-editor notifications-type-fixed-alert-banner-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                    <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_banner_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <hr>
                                    <div class="form-group">
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
                                                    <ul class="nav nav-tabs nav-justified mb-3">
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
                                                                . '<a href="#notifications-type-fixed-alert-page-' . $only_dir . '" class="nav-link' . $active . '" data-bs-toggle="tab">'
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
                                                        <div id="notifications-type-fixed-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <input type="text" class="form-control theme-text-input-1 notifications-alert-page-title" id="notifications-fixed-alert-page-title-<?php echo $only_dir; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" />
                                                                    <small class="form-text text-muted theme-small">
                                                                        <?php echo $this->lang->line('notifications_alert_page_title_description'); ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <br>   
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="summernote-editor notifications-type-fixed-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                    <textarea class="summernote-editor-textarea d-none"></textarea>
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
                                                <small class="form-text text-muted theme-small">
                                                    <?php echo $this->lang->line('notifications_alert_page_description'); ?>
                                                </small>
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-10 col-xs-6">
                                                <label class="theme-label" for="menu-item-text-input">
                                                    <?php echo $this->lang->line('notifications_enable_alert_page'); ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2 col-xs-6">
                                                <div class="theme-checkbox-input-2 pull-right">
                                                    <input type="checkbox" name="notifications-fixed-alert-enable-page" class="notifications-option-checkbox notifications-alert-page-enabled" id="notifications-fixed-alert-enable-page" />
                                                    <label class="theme-label" for="notifications-fixed-alert-enable-page"></label>
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
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="theme-box-1">
                            <div class="col-12 pt-3 pb-3 ps-4 pe-4 text-end">
                                <button type="submit" class="btn btn-success w-100 notifications-save-users-alert theme-button-2">
                                    <?php echo $this->lang->line('notifications_save'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <div class="form-group mb-3">
                                        <div class="card theme-box-1 theme-card-box notifications-users-alert-selected-plans">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <button class="btn btn-link">
                                                            <?php echo $this->lang->line('notifications_selected_plans'); ?>
                                                        </button>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <button type="button" class="btn mt-2 me-3 ps-2 pe-2 theme-button-1" data-bs-toggle="modal" data-bs-target="#notifications-users-alert-filters-plans-filter">
                                                            <?php echo md_the_admin_icon(array('icon' => 'plus', 'class' => 'me-0')); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <ul class="theme-card-box-list notifications-selected-plans-list">
                                                    <li class="default-card-box-no-items-found">
                                                        <?php echo $this->lang->line('notifications_no_plans_were_selected'); ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="card theme-box-1 theme-card-box notifications-users-alert-selected-languages">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <button class="btn btn-link">
                                                            <?php echo $this->lang->line('notifications_selected_languages'); ?>
                                                        </button>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <button type="button" class="btn mt-2 me-3 ps-2 pe-2 theme-button-1" data-bs-toggle="modal" data-bs-target="#notifications-users-alert-filters-languages-filter">
                                                            <?php echo md_the_admin_icon(array('icon' => 'plus', 'class' => 'me-0')); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <ul class="theme-card-box-list notifications-selected-languages-list">
                                                    <li class="default-card-box-no-items-found">
                                                        <?php echo $this->lang->line('notifications_no_languages_were_selected'); ?>
                                                    </li>
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
    <?php echo form_close() ?>
</div>