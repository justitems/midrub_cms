<div class="row mt-3">
   <div class="col-lg-12">
      <div class="theme-box-1">
         <div class="card themes-directory theme-card-box">
            <div class="card-header">
               <button class="btn btn-link">
                  <?php echo md_the_admin_icon(array('icon' => 'install')); ?>
                  <?php echo $this->lang->line('user_install'); ?>
               </button>
            </div>
            <div class="card-body">
               <div class="default-installation-box">
               <a href="#" class="default-installation-select-btn theme-button-2">
                  <?php echo md_the_admin_icon(array('icon' => 'browse')); ?>
                  <?php echo $this->lang->line('user_upload_theme'); ?>
               </a>
               <div class="d-none">
                  <?php
                     $attributes = array('class' => 'upload-theme', 'id' => 'upload-theme', 'method' => 'post', 'data-csrf' => $this->security->get_csrf_token_name());
                     echo form_open_multipart('admin/user?p=themes&directory=1', $attributes);
                     ?>
                     <input type="file" name="file[]" id="file" accept=".zip">
                  <?php echo form_close(); ?>
               </div>
            </div>
         </div>         
      </div>
   </div>
</div>

<?php md_get_the_file(CMS_BASE_ADMIN_COMPONENTS_USER . 'views/modals/theme_installation.php'); ?>