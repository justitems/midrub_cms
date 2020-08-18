<!-- Loader -->
<div class="page-loading">
    <div class="loading-animation-area">
        <div class="loading-center-absolute">
            <div class="object object_four"></div>
            <div class="object object_three"></div>
            <div class="object object_two"></div>
            <div class="object object_one"></div>
        </div>
    </div>
</div>

<?php echo form_open('admin/settings', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name() ) ) ?>
<?php echo form_close() ?>

<div class="settings-save-changes">
    <div class="col-xs-8">
        <p><?php echo $this->lang->line('you_have_unsaved_changes'); ?></p>
    </div>
     <div class="col-xs-4 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('save_changes'); ?>
        </button>
    </div>   
</div>