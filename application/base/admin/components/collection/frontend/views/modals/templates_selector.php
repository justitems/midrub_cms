<!-- Modal -->
<div class="modal fade theme-modal" id="theme-templates-selector" tabindex="-1" role="dialog" aria-labelledby="theme-templates-selector-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend?p=editor&category=' . md_the_data('component_order_data'), array('class' => 'create-content', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('frontend_templates'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="theme-label" for="contents-option-field-theme-template">
                        <?php echo $this->lang->line('frontend_select_templates'); ?>
                    </label>
                    <select class="form-control theme-select" id="contents-option-field-theme-template" required>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?php echo $this->lang->line('frontend_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('frontend_create'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>