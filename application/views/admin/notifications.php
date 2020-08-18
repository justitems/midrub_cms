<section>
    <div class="container-fluid notifications">
        <div class="col-lg-4">
            <div class="col-lg-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <div class="widget-toolbar">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a data-toggle="tab" href="#templates" aria-expanded="true"><?= $this->lang->line('ma9'); ?></a> </li>
                                <li class=""> <a data-toggle="tab" href="#sent" aria-expanded="false"><?= $this->lang->line('ma10'); ?></a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="tab-content">
                                <div id="templates" class="tab-pane active">
                                    <ul class="list-group">
                                        <?php
                                        if ($templates) {
                                            foreach ($templates as $template) {
                                                echo '<li class="list-group-item" data-id="' . $template->notification_id . '"><i class="fa fa-envelope-o" aria-hidden="true"></i> ' . $template->notification_name . '</li>';
                                            }
                                        } else {
                                            echo '<li class="list-group-item">'.$this->lang->line('ma16').'</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div id="sent" class="tab-pane">
                                    <ul class="list-group">
                                        <?php
                                        if ($notifications) {
                                            foreach ($notifications as $notification) {
                                                echo '<li class="list-group-item" data-id="' . $notification->notification_id . '"><i class="fa fa-share" aria-hidden="true"></i> ' . $notification->notification_title . ' <span class="pull-right">' . calculate_time($notification->sent_time, time()) . '</span></li>';
                                            }
                                        } else {
                                            echo '<li class="list-group-item">'.$this->lang->line('ma11').'</li>';
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
        <div class="col-lg-8">
            <div class="col-lg-12 msg-body">
                <?= form_open('admin/notifications', ['class' => 'send-mess']) ?>
                <div class="col-lg-12 clean">
                    <input type="text" class="form-control input-form msg-title" required="required" placeholder="<?= $this->lang->line('ma15'); ?>" />
                </div>
                <div class="col-lg-12 clean editor">
                    <div id="summernote"></div>
                    <textarea class="msg-body hidden"></textarea>
                </div>
                <div class="col-lg-12 clean buttons">
                    <input type="hidden" class="template" />
                    <button type="button" class="btn btn-danger display-none delete-notification pull-left" data-id=""><?= $this->lang->line('ma12'); ?></button>
                    <button type="submit" class="btn btn-edit send-msg pull-right"><?= $this->lang->line('ma13'); ?></button>
                    <button type="submit" class="btn btn-edit display-none update-msg answer pull-right"><?= $this->lang->line('ma14'); ?></button>
                    <img src="<?= base_url() . 'assets/img/pageload.gif'; ?>" vspace="15" hspace="10" class="display-none pull-right" />
                </div>
                <div class="col-lg-12 clean alert-msg display-none"></div>
                <?= form_close() ?> 
            </div>
        </div>
    </div>
</section>
