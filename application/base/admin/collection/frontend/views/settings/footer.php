<div class="row">
    <div class="col-lg-12 settings-area">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fab fa-js"></i>
                <?php echo $this->lang->line('frontend_settings_footer_code'); ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        get_option_textarea(
                            'frontend_footer_code',
                            array(
                                'words' => array(
                                    'placeholder' => $this->lang->line('frontend_enter_code_used_footer')
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