<div class="frontend-settings">
    <div class="row">
        <div class="col-lg-2 col-lg-offset-1">
            <div class="row">
                <div class="col-lg-12">
                    <?php md_include_component_file(MIDRUB_BASE_ADMIN_FRONTEND . 'views/settings/menu.php'); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <?php md_get_the_frontend_settings_page_content(the_global_variable('frontend_settings_page')); ?>
        </div>
    </div>
</div>

<?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="settings-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('frontend_settings_you_have_unsaved_changes'); ?></p>
    </div>
     <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('frontend_settings_save_changes'); ?>
        </button>
    </div>   
</div>


<!-- Modal -->
<div class="modal fade" id="multimedia-manager" tabindex="-1" role="dialog" aria-labelledby="multimedia-manager-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a data-toggle="tab" href="#multimedia-gallery">
                            <i class="fas fa-photo-video"></i>
                            <?php echo $this->lang->line('frontend_multimedia_gallery'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#multimedia-upload">
                            <i class="fas fa-upload"></i>
                            <?php echo $this->lang->line('frontend_multimedia_upload'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="modal-body">
                <div class="tab-content tab-all-editors">
                    <div id="multimedia-gallery" class="tab-pane fade in active">
                        <div class="row multimedia-gallery-items">
                        </div>
                        <div class="row multimedia-pagination">
                            <div class="col-xs-12">
                                <a href="#" class="btn-option btn-load-old-media">
                                    <i class="icon-refresh"></i>
                                    <?php echo $this->lang->line('frontend_load_more_files'); ?>
                                </a>
                            </div>
                        </div>                        
                    </div>
                    <div id="multimedia-upload" class="tab-pane fade">
                        <div class="drag-and-drop-files">
                            <div>
                                <i class="icon-cloud-upload"></i><br>
                                <?php echo $this->lang->line('frontend_drag_files_here'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer hidden">
                <?php
                $attributes = array('class' => 'upim hidden', 'id' => 'upim', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name());
                echo form_open_multipart('admin/frontend', $attributes);
                ?>
                <input type="hidden" name="type" id="type" value="video">
                <input type="file" name="file[]" id="file" accept=".gif,.jpg,.jpeg,.png,.mp4,.avi" multiple>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>