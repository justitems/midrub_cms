<!-- Modal -->
<div class="modal fade theme-modal" id="create-menu-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend', array('class' => 'create-menu-item', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('frontend_new_menu_item'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="theme-label" for="frontend-select-menu-item-parent-list">
                        <?php echo $this->lang->line('frontend_select_menu_item_parent'); ?>
                    </label>
                    <select class="form-control theme-select" id="frontend-select-menu-item-parent-list">
                        <option value="" disabled selected>
                            <?php echo $this->lang->line('frontend_select_menu_item'); ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    <?php echo $this->lang->line('frontend_cancel'); ?>
                </button>
                <button type="submit" class="btn btn-primary">
                    <?php echo $this->lang->line('frontend_save'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>