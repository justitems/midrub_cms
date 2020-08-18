<div class="row">
    <div class="col-lg-12">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <a href="<?php echo site_url('admin/frontend?p=themes&directory=1&group=frontend_page'); ?>" class="btn-option new-theme">
                                <i class="icon-doc"></i>
                                <?php echo $this->lang->line('frontend_new_theme'); ?>
                            </a>
                        </div>
                        <div class="col-lg-6">
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul class="list-themes">
            <?php
            // Verify if themes exists
            if (md_the_frontend_themes()) {

                foreach (md_the_frontend_themes() as $theme) {

                    ?>
                    <li class="theme-single<?php echo (get_option('themes_activated_theme') === $theme['slug'])?' activated-theme':''; ?>" data-slug="<?php echo $theme['slug']; ?>">
                        <div class="row">
                            <div class="col-lg-10 col-xs-8">
                                <div class="theme-preview">
                                    <img src="<?php echo $theme['screenshot']; ?>">
                                </div>
                                <div class="theme-description">
                                    <h2>
                                        <?php echo $theme['name']; ?>
                                    </h2>
                                    <p>
                                        <?php echo $theme['description']; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1 col-xs-2">
                                <span class="label label-default">
                                    <?php echo $theme['version']; ?>
                                </span>
                            </div>
                            <div class="col-lg-1 col-xs-2 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-options-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <?php
                                            if ( get_option('themes_activated_theme') === $theme['slug'] ) {
                                                ?>
                                                <a href="#" class="deactivate-theme">
                                                    <i class="icon-close"></i>
                                                    <?php echo $this->lang->line('frontend_deactivate'); ?>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="#" class="activate-theme">
                                                    <i class="icon-check"></i>
                                                    <?php echo $this->lang->line('frontend_activate'); ?>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php

            }
        }
        ?>
        </ul>
    </div>
</div>

<?php echo form_open('admin/frontend', array('class' => 'upload-new-theme', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>