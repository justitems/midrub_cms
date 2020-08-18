<div class="row">
    <div class="col-lg-12 settings-area">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fab fa-css3"></i>
                <?php echo $this->lang->line('frontend_settings_header_code'); ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        get_option_textarea(
                            'frontend_header_code',
                            array(
                                'words' => array(
                                    'placeholder' => $this->lang->line('frontend_enter_code_used_header')
                                )
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>