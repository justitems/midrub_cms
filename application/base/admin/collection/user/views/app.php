<?php

// Get app's data
$app = md_the_user_app($this->input->get('app', true));

// Verify if $app exists
if ( $app ) {
   ?>
   <div class="row">
      <div class="col-lg-12">
         <div class="panel panel-default single-app">
            <div class="panel-heading">
               <div class="row">
                  <div class="col-lg-12">
                     <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                           <a data-toggle="tab" href="#app-<?php echo $app['app_slug']; ?>">
                              <?php echo $app['app_name']; ?>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="panel-body">
               <div class="tab-content tab-all-editors">
                  <div id="app-<?php echo $app['app_slug']; ?>" class="tab-pane fade in active">
                     <?php
                     md_get_admin_app_options();
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<?php
} else {
   ?>
   <div class="row">
      <div class="col-lg-12">
         <nav class="navbar navbar-default">
            <div class="container-fluid">
               <div class="navbar-header">
                  <div class="row">
                     <div class="col-lg-12">
                        <p>
                           <?php
                           echo $this->lang->line('user_no_data_found_to_show');
                           ?>
                        </p>
                     </div>
                  </div>
               </div>
            </div>
         </nav>
      </div>
   </div>
<?php
}
?>

<?php echo form_open('admin/frontend', array('class' => 'save-settings', 'data-csrf' => $this->security->get_csrf_token_name())) ?>
<?php echo form_close() ?>

<div class="settings-save-changes">
    <div class="col-xs-6">
        <p><?php echo $this->lang->line('user_settings_you_have_unsaved_changes'); ?></p>
    </div>
    <div class="col-xs-6 text-right">
        <button type="button" class="btn btn-default">
            <i class="far fa-save"></i>
            <?php echo $this->lang->line('user_settings_save_changes'); ?>
        </button>
    </div>
</div>