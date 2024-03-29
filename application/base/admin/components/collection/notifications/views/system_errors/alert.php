<div class="notifications-errors-alert" data-alert="<?php echo $this->input->get('alert', true); ?>">
    <div class="row">
        <div class="col-lg-9 theme-editor">
            <div class="theme-box-1">
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
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="tab-content" id="notifications-users-alert-types-content">
                            <div class="tab-pane fade<?php echo (the_users_alert_type() === '3')?' active show':''; ?>" id="notifications-users-alert-type-news" role="tabpanel" aria-labelledby="notifications-users-alert-type-news-tab">
                                <div class="form-group mb-3 theme-form-group">
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
                                                                <textarea class="summernote-editor-textarea notifications-alert-banner-textarea d-none"><?php echo (the_users_alert_type() === '3')?the_users_alerts_field('banner_content', '', $only_dir):''; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }

                                                ?>
                                            </div>
                                        </div>
                                    </div>                       
                                </div>
                                <hr>
                                <div class="form-group theme-form-group">
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
                                                    <div id="notifications-news-alert-page-<?php echo $only_dir; ?>" class="tab-pane fade<?php echo $active; ?>">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" value="<?php echo (the_users_alert_type() === '3')?the_users_alerts_field('page_title', '', $only_dir):''; ?>" placeholder="<?php echo $this->lang->line('notifications_enter_page_title'); ?>" class="form-control theme-text-input-1" id="notifications-news-alert-page-title-<?php echo $only_dir; ?>" />
                                                            </div>
                                                        </div>
                                                        <br>                                             
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="summernote-editor notifications-type-news-alert-page-<?php echo $only_dir; ?>" data-dir="<?php echo $only_dir; ?>"></div>
                                                                <textarea class="summernote-editor-textarea notifications-alert-page-textarea d-none"><?php echo (the_users_alert_type() === '3')?the_users_alerts_field('page_content', '', $only_dir):''; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }

                                                ?>
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
            <?php if ( the_system_errors_user('user_id') ) { ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="theme-box-1">
                        <div class="card theme-card-box notifications-users-alert-filters">
                            <div class="card-header">
                                <button class="btn btn-link">
                                    <?php echo md_the_admin_icon(array('icon' => 'user')); ?>
                                    <?php echo $this->lang->line('notifications_user'); ?>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3 theme-form-group">
                                    <div class="media d-flex justify-content-start">
                                        <div class="media-left">
                                            <img class="mr-3" src="//www.gravatar.com/avatar/<?php echo md5(the_system_errors_user('email')); ?>" alt="User Avatar" />
                                        </div>
                                        <div class="media-body">
                                            <h5 class="mt-0">
                                                <a href="<?php echo site_url('admin/members?p=all_members&member=' . the_system_errors_user('user_id')); ?>">
                                                    <?php echo the_system_errors_user('name'); ?>
                                                </a>
                                            </h5>
                                            <?php if ( the_system_errors_user('status') === '0' ) { ?>
                                                <span class="notifications-user-status-inactive">
                                                    <?php echo $this->lang->line('notifications_inactive'); ?>
                                                </span>
                                            <?php } else if ( the_system_errors_user('status') === '1' ) { ?>
                                                <span class="notifications-user-status-active">
                                                    <?php echo $this->lang->line('notifications_active'); ?>
                                                </span>
                                            <?php } else if ( the_system_errors_user('status') === '2' ) { ?>
                                                <span class="notifications-user-status-blocked">
                                                    <?php echo $this->lang->line('notifications_blocked'); ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>