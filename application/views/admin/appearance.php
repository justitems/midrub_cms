<section>
    <div class="container-fluid settings">
        <div class="row">
            <div class="col-lg-12"> 
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-paint-brush"></i> <?= $this->lang->line('ma37'); ?></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="widget-box">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="tab-content">                
                                            <div id="appearance" class="tab-pane active">
                                                <div class="setrow" id="main_logo">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma57'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['main_logo'])) echo '<img src="' . $options['main_logo'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default main_logo" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <div class="setrow" id="favicon">
                                                    <div class="image-head-title"><h3><?= $this->lang->line('ma59'); ?></h3></div>
                                                    <p class="preview"><?php if (isset($options['favicon'])) echo '<img src="' . $options['favicon'] . '" class="thumbnail" />'; ?></p>
                                                    <p><a class="btn btn-default favicon" href="#"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <?= $this->lang->line('ma58'); ?></a></p>
                                                    <div class="error-upload"></div>
                                                    <hr>
                                                </div>
                                                <!--upload media form !-->
                                                <div class="hidden">
                                                    <?php
                                                    $attributes = array('class' => 'upmedia', 'method' => 'post');
                                                    echo form_open_multipart('admin/settings', $attributes);
                                                    ?>
                                                    <input type="file" name="file" id="file">
                                                    <input type="text" name="media-name" id="media-name">
                                                    <?php
                                                    echo form_close();
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 clean alert-msg display-none"></div>
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
</section>