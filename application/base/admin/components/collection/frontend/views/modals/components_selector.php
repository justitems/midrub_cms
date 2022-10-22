<!-- Modal -->
<div class="modal fade theme-modal" id="theme-components-selector" tabindex="-1" role="dialog" aria-labelledby="theme-components-selector-label">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend?p=editor&category=auth', array('class' => 'create-content', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('frontend_set_auth_components'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="theme-label" for="contents-option-field-auth_components">
                        <?php echo $this->lang->line('frontend_select_auth_component'); ?>
                    </label>
                    <select class="form-control theme-select" id="contents-option-field-auth_components" required>
                        <?php
                        $auth_components = md_the_auth_components();
                        if ($auth_components) {

                            foreach ($auth_components as $component) {

                                echo '<option value="' . $component['slug'] . '">' . $component['name'] . '</option>';
                            }
                        }
                        ?>
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