<div class="row">
    <div class="col-lg-12 settings-area">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="icon-grid"></i>
                <?php echo $this->lang->line('theme_midrub_theme'); ?>
            </div>
            <div class="panel-body">
                <ul class="settings-list-options">
                    <li>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('theme_midrub_theme_logo'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('theme_midrub_theme_logo_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <?php
                                get_option_media(
                                    'frontend_theme_logo',
                                    array(
                                        'words' => array(
                                            'placeholder' => $this->lang->line('theme_logo_for_sign_in_placeholder')
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <h4>
                                    <?php echo $this->lang->line('theme_midrub_theme_favicon'); ?>
                                </h4>
                                <p>
                                    <?php echo $this->lang->line('theme_midrub_theme_favicon_description'); ?>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <?php
                                get_option_media(
                                    'frontend_theme_favicon',
                                    array(
                                        'words' => array(
                                            'placeholder' => $this->lang->line('theme_favicon_for_sign_in_placeholder')
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </li>                             
                </ul>
            </div>
        </div>
    </div>
</div>