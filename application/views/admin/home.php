<section>
    <div class="container-fluid dashboard">
        <?php get_admin_widgets(); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="panel-heading">
                            <h2><i class="fa fa-area-chart"></i> <?= $this->lang->line('ma118'); ?><span></span></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 pull-right text-right order-by">
                            <ul>
                                <li><a href="#" data-time="7" class="active"><?= $this->lang->line('ma119'); ?></a></li>
                                <li><a href="#" data-time="30"><?= $this->lang->line('ma120'); ?></a></li>
                                <li><a href="#" data-time="90"><?= $this->lang->line('ma121'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div id="statistics" class="graph"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 fl">
                    <div class="col-lg-12 clean-mob">
                        <div class="row">
                            <div class="panel-heading">
                                <h2><i class="fa fa-users"></i> <?= $this->lang->line('ma122'); ?></h2>
                            </div>
                        </div>
                        <div class="row user-item last">
                            <?php
                            if ($last_users) {
                                foreach ($last_users as $last) {
                                    ?>
                                    <div class="col-lg-12 clean">
                                        <img src="//www.gravatar.com/avatar/<?= $last->md5 ?>" alt="<?= $last->username ?>">
                                        <h4><?= $last->username ?> <small><?= $last->email ?></small><br><span><?= ($last->role == 0) ? $this->lang->line('ma132') : $this->lang->line('ma133') ?></span></h4>
                                        <a href="<?php echo site_url('admin/users') ?>#<?= $last->user_id ?>" class="pull-right"><button type="button" class="btn btn-edit"><i class="fas fa-pencil-alt"></i></button></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fr">
                    <div class="col-lg-12 clean-mob">
                        <div class="row">
                            <div class="panel-heading">
                                <h2><i class="fa fa-share-square"></i> <?= $this->lang->line('ma123'); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="soci-networks"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>