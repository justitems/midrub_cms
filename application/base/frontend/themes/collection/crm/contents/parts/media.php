<!-- Modal -->
<div class="modal fade theme-modal theme-upload-media-modal" id="theme-upload-logo-modal" tabindex="-1" role="dialog" aria-labelledby="theme-upload-logo-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('theme_upload_image'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="theme-drag-and-drop-files" data-upload-form-url="<?php echo site_url('theme-ajax'); ?>" data-upload-form-action="theme_change_frontend_logo" data-supported-extensions=".png,.jpeg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>