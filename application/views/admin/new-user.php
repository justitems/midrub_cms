<section>
    <div class="container-fluid users">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-user-plus"></i> <?= $this->lang->line('ma126'); ?></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?= form_open('admin/new-user', ['class' => 'new-user']) ?>
                                <div class="form-group">
                                    <input class="new-message form-control first_name" type="text" placeholder="<?= $this->lang->line('ma277'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control last_name" type="text" placeholder="<?= $this->lang->line('ma278'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control username" type="text" placeholder="<?= $this->lang->line('ma127'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control email" type="email" placeholder="<?= $this->lang->line('ma128'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control password" type="password" placeholder="<?= $this->lang->line('ma129'); ?>" required>
                                </div>
                                <div class="form-group">
                                    <select class="new-message form-control role">
                                        <option value="0"><?= $this->lang->line('ma132'); ?></option>
                                        <option value="1"><?= $this->lang->line('ma133'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-labeled btn-primary pull-right"><?= $this->lang->line('ma130'); ?></button>
                                </div>
                                <div class="form-group alert-msg"></div>
                                <?= form_close() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel-footer"><input type="checkbox" class="sendpass" align="left"> <?= $this->lang->line('ma131'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>