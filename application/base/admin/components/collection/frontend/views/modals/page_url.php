<!-- Modal -->
<div class="modal fade theme-modal" id="page-url-composer" tabindex="-1" role="dialog" aria-labelledby="page-url-composer-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('admin/frontend', array('class' => 'update-content-url', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
            <div class="modal-header">
                <h5 class="modal-title theme-color-black">
                    <?php echo $this->lang->line('frontend_url_builder'); ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group theme-input-group-2">
                        <input type="text" class="form-control theme-text-input-1 url-slug-input" placeholder="<?php echo $this->lang->line('frontend_enter_url_builder'); ?>" required>
                        <button type="submit" class="input-group-addon btn">
                            <?php echo $this->lang->line('frontend_save'); ?>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group url-preview">
                        <?php
                        if (md_the_data('content_slug')) {
                            ?>
                            <?php echo base_url(); ?><?php echo md_the_data('contents_category')['slug_in_url'] ? '<span class="category-slug" data-slug="' . md_the_data('contents_category_slug') . '">' . md_the_data('contents_category_slug') . '</span>/' : ''; ?><span class="url-slug" data-slug="<?php echo str_replace(md_the_data('contents_category_slug') . '/', '', md_the_data('content_slug')); ?>"><?php echo str_replace(md_the_data('contents_category_slug') . '/', '', md_the_data('content_slug')); ?></span>
                        <?php
                        } else {
                            ?>
                            <?php echo base_url(); ?><?php echo md_the_data('contents_category')['slug_in_url'] ? '<span class="category-slug" data-slug="' . md_the_data('contents_category_slug') . '">' . md_the_data('contents_category_slug') . '</span>/' : ''; ?><span class="url-slug">(content-id)</span>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>